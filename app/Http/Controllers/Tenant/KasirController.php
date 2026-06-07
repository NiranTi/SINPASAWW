<?php
// ── app/Http/Controllers/Tenant/KasirController.php ─────────────────────────
namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\barang;
use App\Models\transaksi;
use App\Models\transaksi_barang;
use App\Models\kasbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class KasirController extends Controller
{
    /* ── Halaman Kasir ─────────────────────────────────────────────── */
    public function index(Request $request)
    {
        $tenant = Auth::user()->tenant;

        /* Ambil semua barang yang tersedia (stok > 0) */
        $query = Barang::where('tenant_id', $tenant->tenant_id)->where('stok', '>', 0);

        /* Filter pencarian nama barang */
        if ($search = $request->get('q')) {
            $query->where('nama', 'like', "%{$search}%");
        }

        $barang = $query->orderBy('nama')->get();

        /* Generate kode transaksi berikutnya */
        $lastId = Transaksi::max('transaksi_id') ?? 0;
        $kodeTransaksi = 'PS-' . str_pad($lastId + 1, 5, '0', STR_PAD_LEFT);

        return view('tenant.kasir', compact('tenant', 'barang', 'kodeTransaksi'));
    }
    public function strukPdf($id)
    {
        $tenant = Auth::user()->tenant;

        $transaksi = Transaksi::where(
                'tenant_id',
                $tenant->tenant_id
            )
            ->findOrFail($id);

        $detail = transaksi_barang::with('barang')
            ->where('transaksi_id', $id)
            ->get();

        $pdf = Pdf::loadView(
            'tenant.kasir.struk-pdf',
            compact(
                'transaksi',
                'detail',
                'tenant'
            )
        );
        $tinggi = 300 + ($detail->count() * 35);

        $pdf->setPaper([0, 0, 226.77, $tinggi], 'portrait');

        return $pdf->stream(
            'struk-'.$id.'.pdf'
        );
    }

    /* ── Proses Bayar ──────────────────────────────────────────────── */
    public function store(Request $request)
    {
        $request->validate([
            'items'            => 'required|string', // JSON
            'metode_bayar'     => 'required|in:qris,tunai',
            'nominal'          => 'required|numeric|min:0',
            'nama_pelanggan'   => 'nullable|string|max:255',
            'kontak_pelanggan' => 'nullable|string|max:100',
            'print_struk'      => 'nullable|boolean',
        ]);

        $tenant = Auth::user()->tenant;
        $items  = json_decode($request->items, true);

        if (empty($items)) {
            return back()->withErrors(['items' => 'Keranjang tidak boleh kosong.']);
        }

        foreach ($items as $item) {

            $barang = Barang::lockForUpdate()
                ->where('tenant_id', $tenant->tenant_id)
                ->find($item['id']);

            if (!$barang) {
                throw new \Exception('Barang tidak ditemukan.');
            }

            if ($barang->stok < $item['qty']) {
                throw new \Exception(
                    "Stok {$barang->nama} tidak cukup. Sisa stok: {$barang->stok}"
                );
            }
        }
        $transaksi = null;
        try {
        $transaksi = DB::transaction(function () use ($request, $tenant, $items) {
            /* ── Hitung total ── */
            $subtotal = collect($items)->sum(fn($i) => $i['qty'] * $i['harga']);
            $pajak    = 0; // bisa dikonfigurasi
            $total    = $subtotal + $pajak;
            $nominal  = (float) $request->nominal;
            $kembalian = max(0, $nominal - $total);
            $kurang    = max(0, $total - $nominal);

            /* ── Tentukan metode & status ── */
            $metodeBayar = $kurang > 0 ? 'kasbon' : $request->metode_bayar;
            $status      = $kurang > 0 ? 'diproses' : 'selesai';

            /* ── Buat transaksi ── */
            $transaksi = Transaksi::create([
                'tenant_id'    => $tenant->tenant_id,
                'total'        => $total,
                'jumlah_bayar' => $nominal,
                'kembalian'    => $kembalian,
                'metode_bayar' => $metodeBayar,
                'status'       => $status,
            ]);

            /* ── Buat transaksi_barang & kurangi stok ── */
            foreach ($items as $item) {
                transaksi_barang::create([
                    'transaksi_id' => $transaksi->transaksi_id,
                    'barang_id'    => $item['id'],
                    'qty'          => $item['qty'],
                    'harga'        => $item['harga'],
                    'subtotal'     => $item['qty'] * $item['harga'],
                ]);
                $barang = Barang::lockForUpdate()->find($item['id']);

                $barang->stok -= $item['qty'];
                $barang->save();

                if ($item['qty'] <= 0) {
                    throw new \Exception('Qty tidak valid.');
                }
            }

            /* ── Buat kasbon pelanggan jika kurang ── */
            if ($kurang > 0 && $request->filled('nama_pelanggan')) {
                Kasbon::create([
                    'tenant_id'    => $tenant->tenant_id,
                    'transaksi_id' => $transaksi->transaksi_id,
                    'tipe_kasbon'  => 'pelanggan',
                    'nama'         => $request->nama_pelanggan,
                    'kontak'       => $request->kontak_pelanggan,
                    'total'        => $total,
                    'sisa'         => $kurang,
                    'status'       => 'belum_lunas',
                    'tenggat'      => now()->addDays(30),
                ]);
            }
            return $transaksi;
        });

        if ($request->print_struk) {
            return redirect()->route(
                'tenant.kasir.struk',
                $transaksi->transaksi_id
            );
        }
            return redirect()->route('tenant.kasir')
                ->with([
                    'alert' => 'Pembayaran Anda berhasil!',
                    'alert_type' => 'success'
                ]);
    } catch (\Exception $e) {

        return back()
            ->with([
                'alert' => $e->getMessage(),
                'alert_type' => 'error'
            ])
            ->withInput();
    }
}
}
