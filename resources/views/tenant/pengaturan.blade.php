{{-- resources/views/tenant/pengaturan.blade.php --}}
@extends('layouts.tenant')

@section('title', 'Pengaturan – ' . $tenant->nama_tenant)

@section('styles')
/* ── Avatar section ─────────────────────────────────────── */
.avatar-wrap {
    position:relative; width:96px; height:96px; margin:0 auto 1rem;
}
.avatar-img {
    width:96px; height:96px; border-radius:50%; object-fit:cover;
    border:3px solid #fff; box-shadow:0 2px 8px rgba(0,0,0,.1);
}
.avatar-placeholder {
    width:96px; height:96px; border-radius:50%;
    background:var(--primary-soft);
    display:flex; align-items:center; justify-content:center;
    font-size:2rem; font-weight:700; color:var(--primary);
    border:3px solid #fff; box-shadow:0 2px 8px rgba(0,0,0,.1);
}
/* Tombol kamera edit (overlay sudut kanan bawah) */
.avatar-edit-btn {
    position:absolute; bottom:2px; right:2px;
    width:28px; height:28px; border-radius:50%;
    background:var(--primary); color:#fff;
    display:flex; align-items:center; justify-content:center;
    cursor:pointer; border:2px solid #fff; transition:background .15s;
}
.avatar-edit-btn:hover { background:#006435; }

/* ── Desktop: sticky avatar card ── */
.avatar-card {
    background:#fff; border-radius:16px; border:1px solid #eef0ef;
    padding:2.5rem 1.5rem; text-align:center;
}
@media (min-width:1024px) {
    .avatar-card { position:sticky; top:2rem; }
}

/* ── Settings section (form card + heading) ── */
.settings-section {
    background:#fff; border-radius:16px; border:1px solid #eef0ef; padding:1.75rem;
}

@endsection

@section('content')

{{-- Page header --}}
<div class="mb-7">
    <p class="page-label">PENGATURAN</p>
    <h1 class="page-title">Pengaturan Akun</h1>
    <p class="page-subtitle">Atur informasi akun Anda dengan mudah dan aman.</p>
</div>

{{-- Error banner --}}
@if ($errors->any())
    <div class="mb-4 px-4 py-3 rounded-xl text-sm font-medium"
         style="background-color:var(--danger-soft);color:var(--danger);">
        {{ $errors->first() }}
    </div>
@endif

{{-- ══════════════════════════════════════════════════════════
     Layout
     Mobile  : single column stacked
     Desktop : avatar card kiri (w-60) | form sections kanan (flex-1)
═════════════════════════════════════════════════════════════ --}}
<div class="flex flex-col lg:flex-row gap-6 items-start">

    {{-- ════════════════════════════════════════
         Avatar + info toko
         Mobile  : full width, text-center, no card bg (raw)
         Desktop : white card, sticky
    ════════════════════════════════════════ --}}

    {{-- ── Mobile avatar (no card wrapper, sesuai desain) ── --}}
    <div class="lg:hidden w-full flex flex-col items-center mb-2">
        <div class="avatar-wrap">
            @if ($tenant->foto)
                <img src="{{ asset($tenant->foto) }}" alt="{{ $tenant->nama_tenant }}"
                     class="avatar-img" id="avatarPreviewMobile">
            @else
                <div class="avatar-placeholder" id="avatarPlaceholderMobile">
                    {{ strtoupper(substr($tenant->nama_tenant, 0, 1)) }}
                </div>
                <img src="" alt="" class="avatar-img hidden" id="avatarPreviewMobile">
            @endif
            <label class="avatar-edit-btn" for="fotoInput" title="Ganti foto">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </label>
        </div>
        <p class="font-manrope font-bold text-gray-900 text-base">{{ $tenant->nama_tenant }}</p>
        <p class="text-xs font-semibold uppercase tracking-wide mt-1" style="color:var(--orange);">
            {{ strtoupper($tenant->kategori ?? 'Bahan Pangan') }}
        </p>
        <div class="flex items-center gap-1.5 text-xs text-gray-400 mt-1">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            Bergabung {{ $tenant->created_at->translatedFormat('F Y') }}
        </div>
    </div>

    {{-- ── Desktop avatar card (hidden on mobile) ── --}}
    <div class="hidden lg:block w-60 flex-shrink-0">
        <div class="avatar-card">
            <div class="avatar-wrap">
                @if ($tenant->foto)
                    <img src="{{ asset($tenant->foto) }}" alt="{{ $tenant->nama_tenant }}"
                         class="avatar-img" id="avatarPreviewDesktop">
                @else
                    <div class="avatar-placeholder" id="avatarPlaceholderDesktop">
                        {{ strtoupper(substr($tenant->nama_tenant, 0, 1)) }}
                    </div>
                    <img src="" alt="" class="avatar-img hidden" id="avatarPreviewDesktop">
                @endif
                <label class="avatar-edit-btn" for="fotoInput" title="Ganti foto">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </label>
            </div>
            <p class="font-manrope font-bold text-gray-900 text-base">{{ $tenant->nama_tenant }}</p>
            <p class="text-xs font-semibold uppercase tracking-wide mt-1 mb-3" style="color:var(--orange);">
                {{ strtoupper($tenant->kategori ?? 'Bahan Pangan') }}
            </p>
            <div class="flex items-center justify-center gap-1.5 text-xs text-gray-400">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Bergabung {{ $tenant->created_at->translatedFormat('F Y') }}
            </div>
        </div>
    </div>

    {{-- ════════════════════════════════════════
         Form sections (kanan pada desktop)
    ════════════════════════════════════════ --}}
    <div class="flex-1 min-w-0 w-full space-y-5">

        {{-- ── Profil Toko ──────────────────────────────── --}}
        {{-- Section heading di luar card (sesuai desain mobile) --}}
        <h3 class="font-manrope font-bold text-gray-900 text-lg">Profil Toko</h3>

        <div class="settings-section">
            <form method="POST"
                  action="{{ route('tenant.pengaturan.profil') }}"
                  enctype="multipart/form-data">
                @csrf @method('PUT')

                {{-- File input tersembunyi --}}
                <input type="file" id="fotoInput" name="foto"
                       accept="image/*" class="hidden"
                       onchange="previewAvatar(this)">

                {{-- Nama Toko --}}
                <div class="form-group mb-4">
                    <label class="form-label" style="margin-left: 15px !important;">NAMA TOKO</label>
                    <input type="text" name="nama_tenant"
                           class="form-input @error('nama_tenant') ring-2 ring-red-300 @enderror"
                           value="{{ old('nama_tenant', $tenant->nama_tenant) }}" required>
                    @error('nama_tenant')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Kategori — full width (mobile), 2-col (desktop) --}}
                {{-- Mobile: stacked single col sesuai desain screenshot --}}
                <div class="form-group" style="padding-left: 15px !important;">
                    <label class="form-label">KATEGORI</label>
                    <select name="kategori" class="form-select @error('kategori') ring-2 ring-red-300 @enderror">
                    @foreach (['Lapak Basah','Kios Besar','Kios Kecil','Kios F&B/Kuliner','Lapak Sayur, Buah dan Jajanan','Lapak Non-Halal', 'Lapak Olahan dan Jajanan', 'Pojok Kuliner', 'Galeri Dekranasda'] as $opt)
                <option value="{{ $opt }}" {{ old('kategori', $tenant->kategori) === $opt ? 'selected' : '' }}>
                {{ $opt }}
                </option>
                    @endforeach
                </select>
                </div>

                {{-- Blok — i --}}
                <div class="form-group" style="padding-left: 15px !important;">
                    <label class="form-label">BLOK</label>
                    <select type="text" name="denah_id"
                           class="form-select @error('blok') ring-2 ring-red-300 @enderror"
                            placeholder="Pilih blok disini...">
                           @foreach($lapakKosong as $lapak)
                            <option
                                value="{{ $lapak->denah_id }}"
                                {{ old('denah_id', $tenant->denah?->denah_id) == $lapak->denah_id ? 'selected' : '' }}
                            >
                                {{ $lapak->denah_id }}
                            </option>
                        @endforeach
                    </select>
                    @error('blok')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>
                
                {{-- Nama Pemilik --}}
                <div class="form-group mb-4">
                    <label class="form-label" style="margin-left: 15px !important;">NAMA PEMILIK</label>
                    <input type="text" name="nama_pemilik"
                           class="form-input @error('nama_pemilik') ring-2 ring-red-300 @enderror"
                           value="{{ old('nama_pemilik', $user->name) }}" required>
                    @error('nama_pemilik')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Email --}}
                <div class="form-group mb-4">
                    <label class="form-label" style="margin-left: 15px !important;">EMAIL</label>
                    <input type="email" name="email"
                           class="form-input @error('email') ring-2 ring-red-300 @enderror"
                           value="{{ old('email', $user->email) }}" required>
                    @error('email')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- No. HP — Geser teks label ke kiri --}}
                <div class="form-group" style="margin-bottom:1.5rem;">
                    <label class="form-label" style="margin-left: 15px !important;">NO. HP</label>
                    <input type="tel" name="no_hp"
                           class="form-input"
                           value="{{ old('no_hp', $user->phone ?? '') }}"
                           placeholder="Masukkan no. HP disini...">
                           </div>

                {{-- Simpan profil
                     Mobile : full width pill (sesuai desain)
                     Desktop: right-aligned --}}
                <div class="flex justify-end">
                    <button type="submit" class="btn-primary w-full lg:w-auto"
                            style="justify-content:center;font-size:14px;padding:13px 40px;">
                        Simpan
                    </button>
                </div>
            </form>
        </div>

{{-- ── Ubah Kata Sandi ──────────────────────────── --}}
        <h3 class="font-manrope font-bold text-gray-900 text-lg">Ubah Kata Sandi</h3>

        <div class="settings-section">
            <form method="POST" action="{{ route('tenant.pengaturan.password') }}">
                @csrf @method('PUT')

                {{-- Kata Sandi Lama  --}}
                <div class="form-group">
                    <label class="form-label" style="margin-left: 15px !important;">KATA SANDI LAMA</label>
                    <div class="input-prefix-wrap">
                        <input type="password" name="kata_sandi_lama"
                               class="form-input pr-10 @error('kata_sandi_lama') ring-2 ring-red-300 @enderror"
                               placeholder="••••••••" autocomplete="current-password">
                    </div>
                    @error('kata_sandi_lama')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Kata Sandi Baru --}}
                <div class="form-group">
                    <label class="form-label" style="margin-left: 15px !important;">KATA SANDI BARU</label>
                    <div class="input-prefix-wrap">
                        <input type="password" name="kata_sandi_baru"
                               class="form-input pr-10 @error('kata_sandi_baru') ring-2 ring-red-300 @enderror"
                               placeholder="Masukkan kata sandi disini..." autocomplete="new-password">
                    </div>
                    @error('kata_sandi_baru')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Ulangi Kata Sandi --}}
                <div class="form-group" style="margin-bottom:1.5rem;">
                    <label class="form-label" style="margin-left: 15px !important;">ULANGI KATA SANDI</label>
                    <div class="input-prefix-wrap">
                        <input type="password" name="kata_sandi_baru_confirmation"
                               class="form-input pr-10"
                               placeholder="Ulangi kata sandi disini..." autocomplete="new-password">
                    </div>
                </div>

              {{-- Simpan password --}}
                <div class="flex justify-end">
                    <button type="submit" class="btn-primary w-full lg:w-auto"
                            style="justify-content:center;font-size:14px;padding:13px 40px;">
                        Simpan
                    </button>
                </div>

<div class="pb-6"></div>
@endsection

@section('scripts')
<script>
/* ── Preview avatar sebelum upload ─────────────────────── */
function previewAvatar(input) {
    if (!input.files?.[0]) return;
    const reader = new FileReader();
    reader.onload = e => {
        /* Update kedua preview (mobile + desktop) jika ada */
        ['Mobile','Desktop'].forEach(suffix => {
            const preview     = document.getElementById('avatarPreview' + suffix);
            const placeholder = document.getElementById('avatarPlaceholder' + suffix);
            if (!preview) return;
            preview.src = e.target.result;
            preview.classList.remove('hidden');
            if (placeholder) placeholder.style.display = 'none';
        });
    };
    reader.readAsDataURL(input.files[0]);
}
</script>
@endsection
