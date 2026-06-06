{{-- resources/views/admin/beranda.blade.php --}}
@extends('layouts.admin')

@section('title', 'Beranda Admin')

@section('styles')
/* ── 3-dot dropdown menu ── */
.actions-menu { position:relative; display:inline-block; }
.actions-dropdown {
    display:none; position:absolute; right:0; top:100%; z-index:10;
    background:#fff; border-radius:12px; box-shadow:0 4px 20px rgba(0,0,0,.1);
    min-width:160px; padding:6px; border:1px solid #f0f0f0;
}
.actions-menu.open .actions-dropdown { display:block; }
.actions-dropdown a, .actions-dropdown button {
    display:flex; align-items:center; gap:8px; width:100%; padding:8px 12px;
    font-size:13px; color:#374151; background:none; border:none; cursor:pointer;
    border-radius:8px; text-decoration:none; text-align:left;
}
.actions-dropdown a:hover, .actions-dropdown button:hover { background:#f4f4ef; color:var(--primary); }
.actions-dropdown button.danger:hover { background:var(--danger-soft); color:var(--danger); }

/* ── Denah placeholder ── */
.denah-container {
    background:#e8e8e0; border-radius:12px; overflow:hidden;
    position:relative; cursor:grab; user-select:none;
    min-height:320px;
}
.denah-container:active { cursor:grabbing; }
.denah-inner {
    display:grid;
    gap:3px; padding:12px;
    transform-origin:top left;
    transition:transform .2s ease;
}
.denah-cell {
    border-radius:4px; cursor:pointer;
    transition:opacity .15s, transform .1s;
    min-width:28px; min-height:28px;
    display:flex; align-items:center; justify-content:center;
}
.denah-cell:hover { opacity:.8; transform:scale(1.05); }
.denah-cell.empty { background:#d1cfc7; cursor:default; }
.denah-cell.empty:hover { opacity:1; transform:none; }

/* ── Denah popup ── */
.denah-popup {
    position:absolute; top:50%; left:50%; transform:translate(-50%,-50%);
    background:#fff; border-radius:16px; padding:0; width:280px;
    box-shadow:0 8px 32px rgba(0,0,0,.18); z-index:20;
    overflow:hidden;
}

/* ── Tenant table ── */
.tenant-table th { font-size:10px; text-transform:uppercase; letter-spacing:.06em; color:#A1A1AA;}
.tenant-table td { font-size:14px; }
.tenant-table tr:hover td { background:#f9fafb; }

/* ── Masa kontrak warning ── */
.kontrak-warning { color:var(--danger); font-weight:600; }
@endsection

@section('content')

{{-- ── Page header ────────────────────────────────────── --}}
<div class="mb-7">
    <p class="text-[14px] font-[Be Vietnam Pro] font-semibold tracking-widest uppercase mb-1" style="color:var(--primary);">
        SELAMAT DATANG KEMBALI
    </p>
    <h1 class="font-manrope text-2xl lg:text-4xl font-bold text-black leading-tight">Admin Pasar</h1>
    <p class="text-sm text-[#40493D] font-[Be Vietnam Pro] mt-1">Berikut laporan performa Pasar Sinpasa</p>
</div>

{{-- ══════════════════════════════════════════════════════
     STAT CARDS — 3 kolom desktop, full-width stack mobile
     ══════════════════════════════════════════════════════ --}}
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">

    {{-- Total Tenant Aktif --}}
    <div class="stat-card">
        <div class="w-9 h-9 rounded-xl flex items-center justify-center mb-3"
             style="background-color:var(--primary-soft);">
            <svg class="w-5 h-5" style="color:var(--primary);" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <p class="text-xs text-[#40493D] font-reguler font-[manrope] uppercase tracking-wide mb-1">TOTAL TENANT AKTIF</p>
        <p class="font-manrope text-2xl lg:text-3xl font-bold text-[#1A1C19]">{{ $totalTenantAktif }}</p>
    </div>

    {{-- Masa Kontrak < 30 Hari --}}
    <div class="stat-card {{ $masaKontrakHampirHabis > 0 ? '' : '' }}">
        <div class="w-9 h-9 rounded-xl flex items-center justify-center mb-3"
             style="background-color:var(--orange-soft);">
            <svg class="w-5 h-5" style="color:var(--orange);" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <p class="text-xs text-[#40493D] font-[manrope] uppercase tracking-wide mb-1">MASA KONTRAK &lt; 30 HARI</p>
        <p class="font-manrope text-2xl lg:text-3xl font-bold"
           style="{{ $masaKontrakHampirHabis > 0 ? 'color:var(--orange);' : 'color:#1a1a1a;' }}">
            {{ $masaKontrakHampirHabis }}
        </p>
    </div>

    {{-- Slot Kosong --}}
    <div class="stat-card">
        <div class="w-9 h-9 rounded-xl flex items-center justify-center mb-3 bg-gray-200">
            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </div>
        <p class="text-xs text-[#40493D] font-[manrope] uppercase tracking-wide mb-1">SLOT KOSONG</p>
        <p class="font-manrope text-2xl lg:text-3xl font-bold text-gray-900">{{ $slotKosong }}</p>
    </div>
</div>

{{-- ══════════════════════════════════════════════════════
     TRAFIK PENJUALAN PASAR — bar chart tahunan
     ══════════════════════════════════════════════════════ --}}
<div class="section-card p-5 lg:p-6 mb-8">
    <div class="flex items-center justify-between mb-5">
        <h3 class="font-manrope text-[20px] text-[#1A1C19]">Trafik Penjualan Pasar</h3>
        <div class="flex items-center gap-4 text-xs text-[#A1A1AA] font-[Be Vietnam Pro] font-semibold">
            <span class="flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full inline-block" style="background:var(--primary);"></span>Saat ini
            </span>
            <span class="flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full inline-block bg-gray-300"></span>Sebelumnya
            </span>
        </div>
    </div>

    <div class="bar-wrap">
        @php $maxVal = max(array_merge($trenData['current'], $trenData['previous'], [1])); @endphp
        @foreach ($trenData['labels'] as $i => $label)
            @php
                $curH      = $maxVal > 0 ? round(($trenData['current'][$i]  / $maxVal) * 100) : 0;
                $prevH     = $maxVal > 0 ? round(($trenData['previous'][$i] / $maxVal) * 100) : 0;
                $isBiggest = $trenData['current'][$i] === max($trenData['current']);
            @endphp
            <div class="bar-col">
                <div style="flex:1;display:flex;align-items:flex-end;gap:2px;width:100%;">
                    <div class="bar" style="height:{{ max($prevH,4) }}%;background:#D1E8DC;flex:1;"></div>
                    <div class="bar" style="height:{{ max($curH,4) }}%;background:{{ $isBiggest ? 'var(--primary)' : '#A8D5BE' }};flex:1;"></div>
                </div>
                <span class="bar-label">{{ $label }}</span>
            </div>
        @endforeach
    </div>
</div>

{{-- ══════════════════════════════════════════════════════
     DENAH PASAR — placeholder interaktif
     ══════════════════════════════════════════════════════ --}}
<div class="mb-8">
    <h2 class="font-manrope text-xl lg:text-2xl font-bold text-[#121212] text-center">Denah Pasar</h2>
    <p class="text-sm text-[#121212] font-[Be Vietnam Pro] text-center mt-1 mb-5">
        Gunakan denah interaktif kami untuk menemukan tenant yang dicari lebih cepat.
    </p>

    {{-- Kontrol denah --}}
    <div class="flex items-center justify-end gap-3 mb-3">
        <button onclick="zoomDenah(0.15)" class="btn-outline" style="font-size:13px;padding:6px 14px;">
            + Perbesar
        </button>
        <button onclick="resetDenah()" class="btn-outline" style="font-size:13px;padding:6px 14px;">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
            </svg>
            Reset
        </button>
        <button onclick="zoomDenah(-0.15)" class="btn-outline" style="font-size:13px;padding:6px 14px;">
            − Perkecil
        </button>
    </div>

    {{-- Denah canvas --}}
    <div class="denah-container overflow-auto" id="denahContainer" style="max-height:500px;">
        <div class="denah-inner" id="denahInner"
             style="grid-template-columns: repeat(16, minmax(28px,1fr)); grid-template-rows: repeat(10, 28px);">

            @php
                /* Kelompokkan denah berdasarkan posisi */
                $denahGrid = [];
                foreach ($denahData as $d) {
                    $denahGrid[$d->posisi_y][$d->posisi_x] = $d;
                }

                /* Warna per kategori */
                $kategoriWarna = [
                    'Lapak Basah'              => '#E2B84B',
                    'Kios Besar'               => '#4A90D9',
                    'Kios Kecil'               => '#7BB8F0',
                    'Kios F&B/Kuliner'         => '#4CAF7D',
                    'Lapak Sayur, Buah dan Jajanan' => '#6CC08B',
                    'Lapak Non-Halal'          => '#E091A3',
                    'Lapak Olahan dan Jajanan' => '#E07A3A',
                    'Pojok Kuliner'            => '#D9534F',
                    'Galeri Dekranasda'        => '#9B59B6',
                    'Mushola'                  => '#95A5A6',
                    'ATM Center'               => '#7F8C8D',
                    'Toilet'                   => '#BDC3C7',
                ];

                /* Render 10×16 grid */
                $maxY = 10; $maxX = 16;
            @endphp

            @for ($y = 0; $y < $maxY; $y++)
                @for ($x = 0; $x < $maxX; $x++)
                    @php
                        $cell   = $denahGrid[$y][$x] ?? null;
                        $tenant = $cell?->tenant;
                        $warna  = $tenant
                            ? ($kategoriWarna[$tenant->kategori] ?? '#A8D5BE')
                            : null;
                    @endphp

                    @if ($cell && $tenant)
                        <div class="denah-cell"
                             style="background:{{ $warna }};"
                             onclick="showDenahPopup(this)"
                             data-blok="{{ $cell->denah_id }}"
                             data-nama="{{ $tenant->nama_tenant }}"
                             data-kategori="{{ $tenant->kategori }}"
                             data-deskripsi="{{ $tenant->deskipsi }}"
                             data-foto="{{ $tenant->foto ? asset($tenant->foto) : '' }}"
                             title="{{ $tenant->nama_tenant }} – {{ $cell->denah_id }}">
                        </div>
                    @else
                        <div class="denah-cell empty" style="background:#d1cfc7;"></div>
                    @endif
                @endfor
            @endfor
        </div>

        {{-- Popup info tenant (hidden by default) --}}
        <div id="denahPopup" class="denah-popup hidden">
            <img id="dpFoto" src="" alt="" class="w-full h-36 object-cover hidden">
            <div class="p-4">
                <div class="flex items-center justify-between mb-2">
                    <span id="dpKategori"
                          class="text-[10px] font-bold uppercase tracking-widest px-2 py-0.5 rounded-full"
                          style="background:var(--orange-soft);color:var(--orange);"></span>
                    <button onclick="closeDenahPopup()"
                            class="w-6 h-6 flex items-center justify-center text-gray-400 hover:text-gray-600 rounded-full hover:bg-gray-100 text-lg leading-none">×</button>
                </div>
                <p id="dpBlok" class="text-xs text-gray-400 font-mono mb-0.5"></p>
                <p id="dpNama" class="font-manrope font-bold text-gray-900 text-base leading-tight mb-1"></p>
                <p id="dpDesc" class="text-xs text-gray-500 leading-relaxed"></p>
            </div>
        </div>
    </div>

    {{-- Legenda --}}
    <div class="flex flex-wrap gap-x-5 gap-y-2 mt-4 text-xs text-gray-600">
        @foreach ([
            ['Semua Lapak',                    '#1a1a1a'],
            ['Kios Besar',                     '#4A90D9'],
            ['Kios Kecil',                     '#7BB8F0'],
            ['Kios F&B/Kuliner',               '#4CAF7D'],
            ['Lapak Sayur, Buah dan Jajanan',  '#6CC08B'],
            ['Mushola',                        '#95A5A6'],
            ['Lapak Non-Halal',                '#E091A3'],
            ['Lapak Basah',                    '#E2B84B'],
            ['Pojok Kuliner',                  '#D9534F'],
            ['Galeri Dekranasda',              '#9B59B6'],
            ['Lapak Olahan dan Jajanan',       '#E07A3A'],
            ['ATM Center',                     '#7F8C8D'],
            ['Toilet',                         '#BDC3C7'],
        ] as [$nama, $warna])
            <span class="flex items-center gap-1.5">
                <span class="w-2.5 h-2.5 rounded-full shrink-0" style="background:{{ $warna }};"></span>
                {{ $nama }}
            </span>
        @endforeach
    </div>
</div>

{{-- ══════════════════════════════════════════════════════
     DAFTAR TENANT
     ══════════════════════════════════════════════════════ --}}
<div class="section-card px-4 pt-7 pb-5">

    {{-- Toolbar --}}
    <div class="flex flex-wrap items-center gap-3 px-4 lg:px-5 py-4 border-b border-gray-100">

        {{-- Filter kategori --}}
        <form method="GET" class="relative">
            @if(request('sort')) <input type="hidden" name="sort" value="{{ request('sort') }}"> @endif
            <select name="filter" onchange="this.form.submit()"
                    class="appearance-none bg-white rounded-full pl-9 pr-8 py-2 text-xs font-medium text-gray-700
                           focus:outline-none focus:ring-2 focus:ring-green-200 border border-gray-200">
                <option value="">Semua Kategori</option>
                @foreach ($kategoriList as $kat)
                    <option value="{{ $kat }}" {{ request('filter') === $kat ? 'selected' : '' }}>{{ $kat }}</option>
                @endforeach
            </select>
            <div class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2">
                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z"/>
                </svg>
            </div>
        </form>

        {{-- Sort --}}
        <form method="GET" class="relative">
            @if(request('filter')) <input type="hidden" name="filter" value="{{ request('filter') }}"> @endif
            <select name="sort" onchange="this.form.submit()"
                    class="appearance-none bg-white rounded-full pl-9 pr-8 py-2 text-xs font-medium text-gray-700
                           focus:outline-none focus:ring-2 focus:ring-green-200 border border-gray-200">
                <option value="terbaru"  {{ request('sort','terbaru') === 'terbaru'  ? 'selected' : '' }}>Terbaru</option>
                <option value="az"       {{ request('sort') === 'az'       ? 'selected' : '' }}>A → Z</option>
                <option value="za"       {{ request('sort') === 'za'       ? 'selected' : '' }}>Z → A</option>
                <option value="kontrak"  {{ request('sort') === 'kontrak'  ? 'selected' : '' }}>Masa Kontrak</option>
            </select>
            <div class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2">
                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/>
                </svg>
            </div>
        </form>
    </div>

    {{-- Table --}}
    <div class="overflow-x-auto bg-white rounded-3xl p-6">
        <table class="tenant-table w-full min-w-140">
            <thead>
                <tr>
                    <th class="px-5 py-3 text-left">NAMA TENANT</th>
                    <th class="px-4 py-3 text-left">BLOK</th>
                    <th class="px-4 py-3 text-left">KATEGORI</th>
                    <th class="px-4 py-3 text-left">MASA KONTRAK</th>
                    <th class="px-4 py-3 w-10"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse ($tenants as $t)
                    @php
                        /* Hitung tanggal berakhir kontrak */
                        $berakhir = \Carbon\Carbon::parse($t->created_at)->addMonths($t->lama_kontrak ?? 12);
                        $sisaHari = now()->diffInDays($berakhir, false);
                        $isWarning = $sisaHari >= 0 && $sisaHari <= 30;
                    @endphp
                    <tr>
                        <td class="px-5 py-3 font-medium text-[#27272A]">{{ $t->nama_tenant }}</td>
                        <td class="px-4 py-3">
                            <span class="blok-badge">{{ $t->blok }}</span>
                        </td>
                        <td class="px-4 py-3 text-[#27272A]">{{ $t->kategori }}</td>
                        <td class="px-4 py-3">
                            <p class="text-sm font-medium {{ $isWarning ? 'kontrak-warning' : 'text-gray-800' }}">
                                {{ $t->lama_kontrak ?? 12 }} Bulan
                            </p>
                            <p class="text-xs {{ $isWarning ? 'text-red-400' : 'text-gray-400' }}">
                                Berakhir {{ $berakhir->translatedFormat('M Y') }}
                            </p>
                        </td>
                        <td class="px-4 py-3">
                            {{-- 3-dot actions dropdown --}}
                            <div class="actions-menu" id="menu-{{ $t->tenant_id }}">
                                <button class="w-7 h-7 flex items-center justify-center rounded-lg hover:bg-gray-100 text-[#27272A] hover:text-gray-700"
                                        onclick="toggleMenu('menu-{{ $t->tenant_id }}')" type="button">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 5a1.5 1.5 0 110-3 1.5 1.5 0 010 3zm0 7a1.5 1.5 0 110-3 1.5 1.5 0 010 3zm0 7a1.5 1.5 0 110-3 1.5 1.5 0 010 3z"/>
                                    </svg>
                                </button>
                                <div class="actions-dropdown">
                                    <a href="#" onclick="closAllMenus()">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        Lihat Detail
                                    </a>
                                    <form method="POST" action="{{ route('tenant.toggle', $t->tenant_id) }}">
                                        @csrf
                                        <button type="submit" class="danger">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                                            </svg>
                                            Nonaktifkan
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-5 py-10 text-center text-sm text-gray-400">Belum ada tenant aktif.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="flex flex-wrap items-center justify-between gap-3 px-5 py-4 border-t border-gray-100">
        <p class="text-xs text-gray-400">
            Menampilkan {{ $tenants->firstItem() }}–{{ $tenants->lastItem() }} dari {{ $tenants->total() }} tenant
        </p>
        <div class="flex items-center gap-1">
            @if ($tenants->onFirstPage())
                <span class="px-2.5 py-1.5 text-xs text-gray-300">‹</span>
            @else
                <a href="{{ $tenants->previousPageUrl() }}" class="px-2.5 py-1.5 rounded-lg text-xs text-gray-600 hover:bg-gray-100">‹</a>
            @endif

            @foreach ($tenants->getUrlRange(1, min($tenants->lastPage(), 3)) as $page => $url)
                <a href="{{ $url }}"
                   class="px-2.5 py-1.5 rounded-lg text-xs font-medium {{ $page == $tenants->currentPage() ? 'text-white' : 'text-gray-600 hover:bg-gray-100' }}"
                   style="{{ $page == $tenants->currentPage() ? 'background:var(--primary);' : '' }}">
                    {{ $page }}
                </a>
            @endforeach

            @if ($tenants->lastPage() > 3)
                <span class="px-1 text-xs text-gray-400">...</span>
                <a href="{{ $tenants->url($tenants->lastPage()) }}" class="px-2.5 py-1.5 rounded-lg text-xs text-gray-600 hover:bg-gray-100">{{ $tenants->lastPage() }}</a>
            @endif

            @if ($tenants->hasMorePages())
                <a href="{{ $tenants->nextPageUrl() }}" class="px-2.5 py-1.5 rounded-lg text-xs text-gray-600 hover:bg-gray-100">›</a>
            @else
                <span class="px-2.5 py-1.5 text-xs text-gray-300">›</span>
            @endif
        </div>
    </div>
</div>

<div class="pb-6"></div>
@endsection

@section('scripts')
<script>
/* ── Denah zoom ─────────────────────────────────────────── */
let denahScale = 1;
function zoomDenah(delta) {
    denahScale = Math.max(0.5, Math.min(2.5, denahScale + delta));
    document.getElementById('denahInner').style.transform = `scale(${denahScale})`;
}
function resetDenah() {
    denahScale = 1;
    document.getElementById('denahInner').style.transform = 'scale(1)';
    closeDenahPopup();
}

/* ── Denah popup ─────────────────────────────────────────── */
function showDenahPopup(cell) {
    const p = document.getElementById('denahPopup');
    const foto = cell.dataset.foto;
    const img  = document.getElementById('dpFoto');

    document.getElementById('dpBlok').textContent     = cell.dataset.blok;
    document.getElementById('dpNama').textContent     = cell.dataset.nama;
    document.getElementById('dpKategori').textContent = cell.dataset.kategori;
    document.getElementById('dpDesc').textContent     = cell.dataset.deskripsi || '';

    if (foto) { img.src = foto; img.classList.remove('hidden'); }
    else       { img.classList.add('hidden'); }

    p.classList.remove('hidden');
}
function closeDenahPopup() {
    document.getElementById('denahPopup').classList.add('hidden');
}

/* ── 3-dot action dropdown ───────────────────────────────── */
function toggleMenu(id) {
    closAllMenus();
    document.getElementById(id)?.classList.toggle('open');
}
function closAllMenus() {
    document.querySelectorAll('.actions-menu.open').forEach(m => m.classList.remove('open'));
}
document.addEventListener('click', e => {
    if (!e.target.closest('.actions-menu')) closAllMenus();
});
</script>
@endsection
