{{-- resources/views/admin/konten.blade.php --}}
@extends('layouts.admin')

@section('title', 'Manajemen Konten')

@section('styles')
/* ── Content card ── */
.konten-card {
    background:#fff; border-radius:16px; overflow:hidden;
    transition:box-shadow .15s;
}
.konten-card:hover { box-shadow:0 4px 20px rgba(0,0,0,.08); }

.konten-card-img {
    width:100%; aspect-ratio:16/9; object-fit:cover;
    background:linear-gradient(135deg,#A8D5BE,#EAF7F1);
    display:flex; align-items:center; justify-content:center;
}

/* ── Kategori badge ── */
.kategori-badge {
    display:inline-block; padding:3px 10px; border-radius:999px;
    font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:.06em;
}
.badge-berita  { background:var(--orange-soft);   color:var(--orange); }
.badge-promosi { background:var(--primary-soft);  color:var(--primary); }

/* ── Image upload dropzone ── */
.dropzone {
    border:2px dashed #d1d5db; border-radius:12px; padding:2rem 1rem;
    text-align:center; cursor:pointer; transition:border-color .15s, background .15s;
    background:#fafafa; position:relative;
}
.dropzone:hover { border-color:var(--primary); background:var(--primary-soft); }
.dropzone input[type=file] {
    position:absolute; inset:0; width:100%; height:100%; opacity:0; cursor:pointer;
}
.dropzone-preview {
    width:100%; aspect-ratio:16/9; object-fit:cover; border-radius:10px; display:none;
}

/* ── Tab underline ── */
.tab-ul-btn {
    padding:8px 2px; font-size:14px; font-weight:500; cursor:pointer;
    border:none; background:transparent; color:#6b7280;
    border-bottom:2px solid transparent; transition:all .15s;
    white-space:nowrap;
}
.tab-ul-btn.active { color:var(--primary); border-bottom-color:var(--primary); }

/* ── Mobile: form panel slide-down ── */
.mobile-form-panel {
    overflow:hidden; transition:max-height .35s ease, opacity .3s ease;
    max-height:0; opacity:0;
}
.mobile-form-panel.open { max-height:1600px; opacity:1; }
@endsection

@section('content')

{{-- ── Page header ────────────────────────────────────── --}}
<div class="mb-6">
    <p class="page-label">MANAJEMEN KONTEN</p>
    <h1 class="page-title">Berita dan Promosi Terbaru</h1>
    <p class="page-subtitle">Buat dan kelola konten terbaru.</p>
</div>

{{-- ── Mobile: tombol tampilkan form (lg:hidden) ─────── --}}
<div class="lg:hidden mb-4">
    <button onclick="toggleMobileForm()"
            id="mobileFormToggle"
            class="btn-primary"
            style="padding:11px 22px;font-size:14px;">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
        </svg>
        <span id="mobileFormToggleLabel">Buat Konten Baru</span>
    </button>
</div>

{{-- ── Mobile form panel (hidden by default, shown via toggle) ── --}}
<div id="mobileFormPanel" class="mobile-form-panel lg:hidden mb-5">
    <div class="form-card">
        <h3 class="font-manrope font-bold text-gray-800 mb-4">Buat Konten Baru</h3>
        @include('admin.konten._form', ['prefix' => 'm', 'editKonten' => $editKonten])
    </div>
</div>

{{-- ══════════════════════════════════════════════════════
     Main layout: form kiri (desktop) + grid kanan
     Desktop : 40% form | 60% grid
     Mobile  : hanya grid (form via toggle di atas)
════════════════════════════════════════════════════════ --}}
<div class="flex flex-col lg:flex-row gap-6 items-start">

    {{-- ── LEFT: Form (desktop only) ── --}}
    <div class="hidden lg:block w-full lg:w-[42%] xl:w-[38%] shrink-0">
        <div class="form-card">
            <h3 class="font-manrope font-bold text-[#1A1C19] mb-4">Buat Konten Baru</h3>
            @include('admin.konten._form', ['prefix' => 'd', 'editKonten' => $editKonten])
        </div>
    </div>

    {{-- ── RIGHT: Content grid dengan tabs ── --}}
    <div class="flex-1 min-w-0 w-full">

        {{-- Tab bar: Konten Aktif | Konten Nonaktif ── --}}
        <div class="flex items-center gap-6 border-b border-gray-200 mb-5">
            <button id="tab-aktif"
                    class="tab-ul-btn {{ ($tab ?? 'aktif') === 'aktif' ? 'active' : '' }}"
                    onclick="switchTab('aktif')">
                Konten Aktif
                <span class="ml-1.5 text-xs font-bold px-1.5 py-0.5 rounded-full"
                      style="{{ ($tab ?? 'aktif') === 'aktif' ? 'background:var(--primary-soft);color:var(--primary);' : 'background:#f3f4f6;color:#9ca3af;' }}">
                    {{ $kontenAktif->count() }}
                </span>
            </button>
            <button id="tab-nonaktif"
                    class="tab-ul-btn {{ ($tab ?? 'aktif') === 'nonaktif' ? 'active' : '' }}"
                    onclick="switchTab('nonaktif')">
                Konten Nonaktif
                <span class="ml-1.5 text-xs font-bold px-1.5 py-0.5 rounded-full"
                      style="{{ ($tab ?? 'aktif') === 'nonaktif' ? 'background:var(--primary-soft);color:var(--primary);' : 'background:#f3f4f6;color:#9ca3af;' }}">
                    {{ $kontenNonaktif->count() }}
                </span>
            </button>
        </div>

        {{-- ── Konten Aktif grid ── --}}
        <div id="grid-aktif" class="{{ ($tab ?? 'aktif') === 'aktif' ? '' : 'hidden' }}">
            @if ($kontenAktif->isEmpty())
                <div class="text-center py-16 text-gray-400">
                    <svg class="w-12 h-12 mx-auto mb-3 text-gray-200" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                    </svg>
                    <p class="text-sm">Belum ada konten aktif.</p>
                </div>
            @else
                {{-- 2 kolom di sm+, 1 kolom di mobile --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @foreach ($kontenAktif as $k)
                        @include('admin.konten._card', ['konten' => $k])
                    @endforeach
                </div>
            @endif
        </div>

        {{-- ── Konten Nonaktif grid ── --}}
        <div id="grid-nonaktif" class="{{ ($tab ?? 'aktif') === 'nonaktif' ? '' : 'hidden' }}">
            @if ($kontenNonaktif->isEmpty())
                <div class="text-center py-16 text-gray-400">
                    <p class="text-sm">Belum ada konten nonaktif.</p>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @foreach ($kontenNonaktif as $k)
                        @include('admin.konten._card', ['konten' => $k])
                    @endforeach
                </div>
            @endif
        </div>

    </div>{{-- /right --}}
</div>

<div class="pb-8"></div>
@endsection

@section('scripts')
<script>
/* ── Tab switcher ────────────────────────────────────────── */
function switchTab(tab) {
    ['aktif','nonaktif'].forEach(t => {
        document.getElementById('grid-' + t).classList.toggle('hidden', t !== tab);
        document.getElementById('tab-' + t).classList.toggle('active', t === tab);
    });
    /* Update URL tanpa reload */
    const url = new URL(window.location);
    url.searchParams.set('tab', tab);
    window.history.replaceState({}, '', url);
}

/* ── Mobile form toggle ──────────────────────────────────── */
let mobileFormOpen = false;
function toggleMobileForm() {
    mobileFormOpen = !mobileFormOpen;
    const panel = document.getElementById('mobileFormPanel');
    const label = document.getElementById('mobileFormToggleLabel');
    panel.classList.toggle('open', mobileFormOpen);
    label.textContent = mobileFormOpen ? 'Tutup Form' : 'Buat Konten Baru';
}

/* ── Image preview di dropzone ───────────────────────────── */
function previewGambar(input, previewId, zoneId) {
    if (!input.files?.[0]) return;
    const reader = new FileReader();
    reader.onload = e => {
        const preview = document.getElementById(previewId);
        const zone    = document.getElementById(zoneId);
        if (preview) { preview.src = e.target.result; preview.style.display = 'block'; }
        if (zone)    { zone.querySelector('.dropzone-placeholder')?.classList.add('hidden'); }
    };
    reader.readAsDataURL(input.files[0]);
}

/* ── Load konten ke form untuk edit ─────────────────────── */
function editKonten(id, judul, kategori, status, deskripsi, imgUrl) {
    /* Cari form yang aktif (desktop atau mobile) */
    const isMobile = window.innerWidth < 1024;
    const prefix   = isMobile ? 'm' : 'd';

    /* Buka mobile form jika diperlukan */
    if (isMobile && !mobileFormOpen) toggleMobileForm();

    const p = s => document.getElementById(prefix + s);
    if (p('KontenId'))   p('KontenId').value   = id;
    if (p('Judul'))      p('Judul').value       = judul;
    if (p('Kategori'))   p('Kategori').value    = kategori;
    if (p('Status'))     p('Status').value      = status;
    if (p('Deskripsi'))  p('Deskripsi').value   = deskripsi;

    /* Update form action ke route update */
    const form = document.getElementById(prefix + 'KontenForm');
    if (form) {
        form.action = `/admin/konten/${id}`;
        const methodInput = form.querySelector('input[name="_method"]');
        if (methodInput) methodInput.value = 'PUT';
    }

    /* Scroll ke form */
    const formEl = document.getElementById(prefix + 'KontenForm');
    formEl?.scrollIntoView({ behavior:'smooth', block:'start' });
}

/* ── Inisialisasi edit dari query param ─────────────────── */
@if ($editKonten)
    document.addEventListener('DOMContentLoaded', function() {
        editKonten(
            @json($editKonten->konten_id),
            @json($editKonten->judul),
            @json($editKonten->kategori),
            @json($editKonten->status),
            @json($editKonten->deskripsi),
            @json($editKonten->img_url)
        );
    });
@endif
</script>
@endsection
