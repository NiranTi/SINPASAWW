<?php
// ── app/Http/Controllers/GuestController.php ─────────────────────────────
namespace App\Http\Controllers;

use App\Models\Denah;
use App\Models\Konten;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    /* ── Beranda / Homepage ─────────────────────────────────────────── */
    public function index()
    {
        /* 3 konten aktif terbaru untuk ditampilkan di homepage */
        $beritaTerbaru = Konten::aktif()->latest()->take(3)->get();

        $denahTenants = Denah::with('tenant:tenant_id,nama_tenant,kategori,foto,deskripsi')
        ->get()
        ->mapWithKeys(fn($d) => [
            $d->denah_id => [
                'nama'      => $d->tenant?->nama_tenant ?? 'Belum ada informasi',
                'kategori'  => $d->tenant?->kategori    ?? '',
                'deskripsi' => $d->tenant?->deskipsi    ?? 'Belum ada informasi detail.',
                'foto'      => $d->tenant?->foto ? asset($d->tenant->foto) : null,
            ]
        ]);

        return view('guest.index', compact('beritaTerbaru', 'denahTenants'));
    }

    /* ── Denah Interaktif ───────────────────────────────────────────── */
    public function denah()
    {
        /* Ambil semua denah beserta info tenant-nya
           Hasil di-encode ke JSON lalu diinjeksikan ke JS sebagai lookup table
           Key = denah_id (misal "L055"), Value = info tenant */
        $denahTenants = Denah::with('tenant:tenant_id,nama_tenant,kategori,foto,deskripsi')
            ->get()
            ->mapWithKeys(fn($d) => [
                $d->denah_id => [
                    'nama'      => $d->tenant?->nama_tenant ?? 'Belum ada informasi',
                    'kategori'  => $d->tenant?->kategori    ?? '',
                    'deskripsi' => $d->tenant?->deskipsi    ?? 'Belum ada informasi detail untuk lapak ini.',
                    'foto'      => $d->tenant?->foto
                                    ? asset($d->tenant->foto)
                                    : null,
                ]
            ]);

        return view('guest.denah', compact('denahTenants'));
    }

    /* ── Detail satu berita/konten ──────────────────────────────────── */
    public function beritaDetail(string $id)
    {
        $konten = Konten::aktif()->findOrFail($id);

        /* Konten lain (exclude yang sedang dibuka) untuk sidebar/related */
        $kontenLain = Konten::aktif()
            ->where('konten_id', '!=', $id)
            ->latest()
            ->take(3)
            ->get();

        return view('guest.berita-detail', compact('konten', 'kontenLain'));
    }

    /* ── Syarat & Ketentuan ─────────────────────────────────────────── */
    public function snk()
    {
        return view('guest.snk');
    }

    /* ── Kebijakan Privasi ──────────────────────────────────────────── */
    public function privasi()
    {
        return view('guest.privasi');
    }
}
