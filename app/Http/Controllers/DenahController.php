<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tenant;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Denah;

class DenahController extends Controller
{
    public function index()
    {
        $denah = Denah::with('tenant')
            ->get();

        $slotData = $denah->map(function ($item) {

            return [
                'id' => $item->denah_id,
                'status' => $item->status,
                'tenant_id' => $item->tenant_id,
                'tenant' => $item->tenant?->nama_tenant,
                'blok' => $item->blok,
            ];

        });

        return view(
            'guest.denah',
            compact('denah')
        );
    }

    public function getApiData()
    {
        // Mengambil data relasi dari tabel denah dan tenant
        // Asumsi: Model 'denah' punya relasi 'tenant'
        $denahList = Denah::with('tenant')->get();

        $formattedData = $denahList->map(function ($d) {
            return [
                // $d->kode_svg harus sama persis dengan ID di file SVG (misal: "KB001")
                'tenant_id'   => $d->kode_svg ?? $d->id, 
                'name'        => $d->tenant ? $d->tenant->nama_tenant : 'Lapak Kosong',
                'details'     => $d->tenant ? $d->tenant->deskripsi : 'Belum ada penyewa di lapak ini.',
                'category_id' => $d->kategori_slug // misal: "kios-besar"
            ];
        });

        // Kategori statis (atau ambil dari DB jika ada model Category)
        $categories = [
            ['category_id' => 'kios-besar', 'category_name' => 'Kios Besar'],
            ['category_id' => 'kios-kecil', 'category_name' => 'Kios Kecil'],
            ['category_id' => 'kios-fnb', 'category_name' => 'Kios FNB'],
            ['category_id' => 'lapak-sayur-buah-dan-jajanan', 'category_name' => 'Lapak Sayur & Buah & Jajanan'],
            ['category_id' => 'lapak-olahan-dan-jajanan', 'category_name' => 'Lapak Olahan & Jajanan'],
            ['category_id' => 'lapak-kuliner', 'category_name' => 'Lapak Kuliner'],
            ['category_id' => 'galeri-dekranasda', 'category_name' => 'Galeri Dekranasda'],
            ['category_id' => 'mushola', 'category_name' => 'Mushola'],
            ['category_id' => 'atm', 'category_name' => 'ATM Center'],
            ['category_id' => 'toilet', 'category_name' => 'Toilet'],
            ['category_id' => 'area-pengelola', 'category_name' => 'Area Pengelola'],
        ];

        return response()->json([
            'tenant'     => $formattedData,
            'categories' => $categories
        ]);
    }

    public function show3D(Request $request)
    {
        return view('guest.denah-3d');
    }
}
