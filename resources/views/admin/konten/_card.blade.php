{{-- resources/views/admin/konten/_card.blade.php
     Partial untuk satu kartu konten (berita/promosi)
     $konten: instance App\Models\Konten
──────────────────────────────────────────────────────────── --}}

<div class="konten-card">
    {{-- Gambar (16:9) --}}
    @if ($konten->img_url)
        <img src="{{ asset('storage/' . $konten->img_url) }}"
             alt="{{ $konten->judul }}"
             class="w-full object-cover"
             style="aspect-ratio:16/9;">
    @else
        {{-- Placeholder jika tidak ada gambar --}}
        <div class="w-full flex items-center justify-center bg-gray-100 text-gray-300"
             style="aspect-ratio:16/9;">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
        </div>
    @endif

    {{-- Body --}}
    <div class="p-4">
        {{-- Kategori badge --}}
        @php
            $badgeClass = match(strtolower($konten->kategori)) {
                'berita'      => 'badge-berita',
                'promosi'     => 'badge-promosi',
                'pengumuman'  => 'badge-berita',
                default       => 'badge-promosi',
            };
        @endphp
        <span class="kategori-badge {{ $badgeClass }} mb-2 inline-block">
            {{ strtoupper($konten->kategori) }}
        </span>

        {{-- Judul --}}
        <h4 class="font-manrope font-bold text-gray-900 text-sm leading-snug mb-1 line-clamp-2">
            {{ $konten->judul }}
        </h4>

        {{-- Deskripsi --}}
        <p class="text-xs text-gray-500 leading-relaxed line-clamp-2 mb-3">
            {{ $konten->deskripsi }}
        </p>

        {{-- Actions: edit + delete --}}
        <div class="flex items-center gap-2">
            {{-- Edit: pre-fill form --}}
            <button type="button"
                    onclick="editKonten(this)"
                    data-id="{{$konten->konten_id}}"
                    data-judul="{{ e($konten->judul) }}"
                    data-kategori="{{ e($konten->kategori) }}"
                    data-status="{{ e($konten->status) }}"
                    data-deskripsi="{{ e($konten->deskripsi ?? '') }}"
                    data-img="{{ e($konten->img_url ?? '') }}"
                    class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 hover:bg-gray-200 text-gray-500 hover:text-gray-700 transition-colors"
                    title="Edit">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
            </button>

            {{-- Toggle status aktif/nonaktif --}}
            <form method="POST" action="{{ route('admin.konten.toggle', $konten->konten_id) }}">
                @csrf
                <button type="submit"
                        class="w-8 h-8 flex items-center justify-center rounded-full transition-colors
                               {{ $konten->status === 'aktif'
                                  ? 'bg-green-50 hover:bg-green-100 text-green-600'
                                  : 'bg-gray-100 hover:bg-gray-200 text-gray-400 hover:text-gray-600' }}"
                        title="{{ $konten->status === 'aktif' ? 'Nonaktifkan' : 'Aktifkan' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        @if ($konten->status === 'aktif')
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        @else
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        @endif
                    </svg>
                </button>
            </form>

            {{-- Delete --}}
            <form method="POST"
                  action="{{ route('admin.konten.destroy', $konten->konten_id) }}"
                  onsubmit="return confirm('Hapus konten ini?')">
                @csrf @method('DELETE')
                <button type="submit"
                        class="w-8 h-8 flex items-center justify-center rounded-full bg-red-50 hover:bg-red-100 text-red-400 hover:text-red-600 transition-colors"
                        title="Hapus">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </button>
            </form>

            {{-- Tanggal publish --}}
            <span class="ml-auto text-[10px] text-gray-400">
                {{ $konten->created_at->translatedFormat('d M Y') }}
            </span>
        </div>
    </div>
</div>
