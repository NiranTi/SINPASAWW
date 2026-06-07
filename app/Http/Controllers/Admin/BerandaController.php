<?php
// ── app/Http/Controllers/Admin/BerandaController.php ─────────────────────
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use App\Models\transaksi;
use App\Models\Denah;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BerandaController extends Controller
{
    public function index(Request $request)
    {
        /* ── Stats ─────────────────────────────────────────────── */
        $totalTenantAktif = Tenant::where('is_active', 1)->count();

        /* Masa kontrak hampir habis: berakhir dalam 30 hari ke depan */
        $masaKontrakHampirHabis = Tenant::where('is_active', 1)
            ->whereRaw(
                'DATE_ADD(created_at, INTERVAL lama_kontrak MONTH) BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 30 DAY)'
            )
            ->count();

        /* Slot kosong: denah yang tidak punya tenant (tenant_id IS NULL) */
        $slotKosong = Denah::whereNull('tenant_id')->count();

        /* ── Chart: trafik penjualan bulanan sepanjang tahun ini ── */
        $trenData = $this->getTrenTahunan();

        /* ── Denah: semua slot + info tenant ── */
        $denahData = Denah::with('tenant:tenant_id,nama_tenant,kategori,foto,deskripsi')
            ->orderBy('posisi_y')
            ->orderBy('posisi_x')
            ->get();

        $denahTenants = Tenant::all();
        // return view('guest.denah', compact('denahData', 'denahTenants'));


        /* ── Tenant list (dengan filter & sort) ── */
        $query = Tenant::with('user:id,name,email')
            ->where('is_active', 1);

        /* Filter kategori */
        if ($kategori = $request->get('filter')) {
            $query->where('kategori', $kategori);
        }

        /* Sort */
        $sort = $request->get('sort', 'terbaru');
        match ($sort) {
            'az'       => $query->orderBy('nama_tenant'),
            'za'       => $query->orderByDesc('nama_tenant'),
            'kontrak'  => $query->orderBy('lama_kontrak'),
            default    => $query->latest(),
        };

        $tenants = $query->paginate(10)->withQueryString();

        /* Daftar kategori unik untuk dropdown filter */
        $kategoriList = Tenant::where('is_active', 1)
            ->distinct()
            ->pluck('kategori')
            ->filter()
            ->sort()
            ->values();

        return view('admin.beranda', compact(
            'totalTenantAktif',
            'masaKontrakHampirHabis',
            'slotKosong',
            'trenData',
            'denahData',
            'denahTenants',
            'tenants',
            'kategoriList',
        ));
    }

    /* ── Helper: data tren bulanan tahun berjalan ── */
    private function getTrenTahunan(): array
    {
        $now    = Carbon::now();
        $labels = $current = $previous = [];

        for ($i = 0; $i < 12; $i++) {
            $month      = Carbon::create($now->year, $i + 1, 1);
            $labels[]   = $month->translatedFormat('M');

            $current[]  = (float) Transaksi::whereYear('created_at', $now->year)
                ->whereMonth('created_at', $i + 1)
                ->where('status', 'selesai')
                ->sum('total');

            $previous[] = (float) Transaksi::whereYear('created_at', $now->year - 1)
                ->whereMonth('created_at', $i + 1)
                ->where('status', 'selesai')
                ->sum('total');
        }

        return compact('labels', 'current', 'previous');
    }

    /* ── Toggle aktif/nonaktif tenant ── */
    public function toggleTenant(int $tenantId)
    {
        $tenant = Tenant::findOrFail($tenantId);
        $tenant->update(['is_active' => !$tenant->is_active]);

        $status = $tenant->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return back()->with('alert', "Tenant {$tenant->nama_tenant} berhasil {$status}.");
    }
}
