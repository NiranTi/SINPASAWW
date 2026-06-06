{{-- resources/views/admin/konten/_form.blade.php
     Partial dipakai di desktop ($prefix='d') dan mobile ($prefix='m')
     $editKonten: konten yang sedang diedit (nullable)
──────────────────────────────────────────────────────────────── --}}
@php $prefix ??= 'd'; @endphp

<form id="{{ $prefix }}KontenForm"
      method="POST"
      action="{{ route('admin.konten.store') }}"
      enctype="multipart/form-data">
    @csrf
    {{-- Method spoofing: default POST, diubah ke PUT saat edit via JS --}}
    <input type="hidden" name="_method" value="POST">
    {{-- ID konten yang diedit (kosong saat create) --}}
    <input type="hidden" id="{{ $prefix }}KontenId" name="_edit_id" value="{{ $editKonten?->konten_id }}">

    {{-- Judul --}}
    <div class="form-group">
        <label class="form-label">JUDUL</label>
        <input type="text"
               id="{{ $prefix }}Judul"
               name="judul"
               class="form-input"
               placeholder="Masukkan judul konten disini..."
               value="{{ old('judul', $editKonten?->judul) }}"
               required>
    </div>

    {{-- Kategori + Status Awal (2 kolom) --}}
    <div class="grid grid-cols-2 gap-3.5 form-group pl-3">
        <div>
            <label class="form-label">KATEGORI</label>
            <select id="{{ $prefix }}Kategori" name="kategori" class="form-select" required>
                <option value="">Pilih...</option>
                @foreach (['Berita', 'Promosi', 'Pengumuman', 'Event'] as $kat)
                    <option value="{{ $kat }}"
                        {{ old('kategori', $editKonten?->kategori) === $kat ? 'selected' : '' }}>
                        {{ $kat }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="form-label">STATUS AWAL</label>
            <select id="{{ $prefix }}Status" name="status" class="form-select" required>
                <option value="aktif"    {{ old('status', $editKonten?->status ?? 'aktif') === 'aktif'    ? 'selected' : '' }}>Aktif</option>
                <option value="nonaktif" {{ old('status', $editKonten?->status) === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
            </select>
        </div>
    </div>

    {{-- Deskripsi --}}
    <div class="form-group">
        <label class="form-label">DESKRIPSI</label>
        <textarea id="{{ $prefix }}Deskripsi"
                  name="deskripsi"
                  class="form-input form-textarea"
                  placeholder="Masukkan deskripsi konten disini...">{{ old('deskripsi', $editKonten?->deskripsi) }}</textarea>
    </div>

    {{-- Upload Gambar --}}
    <div class="form-group" style="margin-bottom:1.5rem;">
        <label class="form-label">UPLOAD GAMBAR</label>
        <div class="dropzone" id="{{ $prefix }}Dropzone">
            <input type="file"
                   name="gambar"
                   accept="image/*"
                   onchange="previewGambar(this,'{{ $prefix }}GambarPreview','{{ $prefix }}Dropzone')">

            {{-- Preview gambar yang sudah ada (saat edit) --}}
            @if ($editKonten?->img_url)
                <img src="{{ asset('storage/' . $editKonten->img_url) }}"
                     id="{{ $prefix }}GambarPreview"
                     class="dropzone-preview"
                     style="display:block;">
            @else
                <img id="{{ $prefix }}GambarPreview" class="dropzone-preview" src="" alt="">
            @endif

            <div class="dropzone-placeholder {{ $editKonten?->img_url ? 'hidden' : '' }}">
                <svg class="w-8 h-8 mx-auto mb-2 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <p class="text-sm text-gray-500">Klik untuk unggah <span class="text-gray-400">(Rasio 16:9)</span></p>
            </div>
        </div>
    </div>

    {{-- Submit --}}
    <button type="submit"
            class="btn-primary"
            style="width:100%;justify-content:center;padding:13px 24px;font-size:15px;">
        Publikasi Konten
    </button>
</form>
