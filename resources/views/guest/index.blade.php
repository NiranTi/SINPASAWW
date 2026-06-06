{{-- resources/views/guest/index.blade.php --}}
@extends('layouts.guest')

@section('title', 'Pasar Modern Sinpasa Summarecon Bandung')

@section('styles')
<style>
/* ── Hero ─────────────────────────────────────── */
.hero-section {
    min-height: screen;
    width: 100%;
    background: url('{{ asset("images/bg-user.jpg") }}') center/cover no-repeat;
    position: relative;
    display: flex; align-items: center;
}
.hero-section::before {
    content:''; position:absolute; inset:0;
    background:linear-gradient(to right, rgba(0,59,31,.88) 0%, rgba(0,59,31,.5) 55%, transparent 100%);
}

/* ── Fasilitas card ───────────────────────────── */
.fasilitas-card {
    background:#fff; border-radius:16px; padding:1.75rem 1.5rem;
    text-align:center; transition:box-shadow .2s, transform .2s;
}
.fasilitas-card:hover {
    box-shadow:0 8px 30px rgba(0,126,67,.12);
    transform:translateY(-3px);
}
.fasilitas-icon {
    width:56px; height:56px; border-radius:16px;
    background:#E6F6EE; display:flex; align-items:center; justify-content:center;
    margin:0 auto 1rem;
}

/* ── Testimoni card ───────────────────────────── */
.testi-card {
    background:#fff; border-radius:16px; padding:1.5rem;
    box-shadow:0 2px 12px rgba(0,0,0,.06);
}

/* ── Berita card ──────────────────────────────── */
.berita-card {
    background:#fff; border-radius:16px; overflow:hidden;
    transition:box-shadow .2s, transform .2s;
}
.berita-card:hover {
    box-shadow:0 8px 30px rgba(0,0,0,.1);
    transform:translateY(-3px);
}

/* ── Section title ────────────────────────────── */
.section-title {
    font-family:'Manrope',sans-serif; font-size:clamp(1.5rem,4vw,2.25rem);
    font-weight:800; color:#003B1F; letter-spacing:-.02em;
}
.section-subtitle { font-size:15px; color:#6b7280; margin-top:.5rem; }
</style>
@endsection

@section('content')

{{-- ════════════════════════════════════════════════════
     HERO
════════════════════════════════════════════════════ --}}
<section id="hero" class="hero-section">
    <div class="relative z-10 max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="max-w-4xl">
            <h1 class="text-white font-manrope font-extrabold leading-tight mb-4"
                style="font-size:clamp(1.8rem,5vw,3.5rem); font-family:'Manrope',sans-serif; letter-spacing:-.02em;">
                Pasar Modern Sinpasa Kini Hadir <br class="hidden sm:inline"> di Summarecon Bandung
            </h1>
            <p class="text-white text-base leading-relaxed mb-8 max-w-4xl">
                Pasar Modern Sinpasa Bandung siap untuk memenuhi kebutuhan sehari-hari
                penghuni Summarecon Bandung maupun warga Bandung secara lebih luas.
            </p>
            {{-- CTA: mengarah ke berita terbaru atau halaman tetap --}}
            @if ($beritaTerbaru->count())
                <a href="{{ route('guest.berita', $beritaTerbaru->first()->konten_id) }}"
                   class="btn-primary-guest">
                    Selengkapnya
                </a>
            @else
                <a href="#fasilitas" class="btn-primary-guest">Jelajahi Pasar</a>
            @endif
        </div>
    </div>
</section>

{{-- ════════════════════════════════════════════════════
     FASILITAS
════════════════════════════════════════════════════ --}}
<section id="fasilitas" class="py-16 lg:py-24 bg-[#f5f5f5]">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="section-title">Fasilitas Lengkap</h2>
            <p class="section-subtitle">Kenyamanan Anda adalah prioritas kami saat berbelanja.</p>
        </div>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6">
            @foreach ([
                ['icon' => 'parking', 'title' => 'Parkir Luas',    'desc' => 'Area parkir aman untuk motor dan mobil.'],
                ['icon' => 'toilet',  'title' => 'Toilet Bersih',  'desc' => 'Fasilitas sanitasi yang terjaga kebersihannya.'],
                ['icon' => 'mosque',  'title' => 'Musholla',        'desc' => 'Ruang ibadah yang nyaman dan tenang.'],
                ['icon' => 'atm',     'title' => 'ATM Center',      'desc' => 'Akses perbankan mudah di dalam area pasar.'],
            ] as $f)
            <div class="fasilitas-card">
                <div class="fasilitas-icon">
                    @if ($f['icon'] === 'parking')
                        <svg class="w-7 h-7" style="color:#007E43;" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7v10m4-10v10M5 3h14a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2z"/>
                        </svg>
                    @elseif ($f['icon'] === 'toilet')
                        <svg class="w-7 h-7" style="color:#007E43;" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    @elseif ($f['icon'] === 'mosque')
                        <svg class="w-7 h-7" style="color:#007E43;" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 21h18M5 21V8.72a2 2 0 011.18-1.82l5-2.22a2 2 0 011.64 0l5 2.22A2 2 0 0119 8.72V21M9 21v-5a3 3 0 016 0v5"/>
                        </svg>
                    @else
                        <svg class="w-7 h-7" style="color:#007E43;" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                        </svg>
                    @endif
                </div>
                <h4 class="font-manrope font-bold text-[#003B1F] mb-1.5 text-sm lg:text-base"
                    style="font-family:'Manrope',sans-serif;">{{ $f['title'] }}</h4>
                <p class="text-gray-500 text-xs lg:text-sm leading-relaxed">{{ $f['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ════════════════════════════════════════════════════
     DENAH PREVIEW
════════════════════════════════════════════════════ --}}
<section id="denah" class="py-16 lg:py-20 bg-white">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="section-title mb-2">Temukan Rute Belanja Anda</h2>
        <p class="section-subtitle mb-8">
            Gunakan denah interaktif kami untuk menemukan produk yang dicari lebih cepat.
        </p>

        {{-- Preview denah (static image, link ke halaman denah penuh) --}}
        <div class="relative rounded-2xl overflow-hidden max-w-3xl mx-auto shadow-lg">
            <img src="{{ asset('images/denah-preview.png') }}"
                 alt="Denah Pasar Sinpasa"
                 class="w-full object-cover"
                 onerror="this.style.display='none'; document.getElementById('denahPlaceholder').style.display='flex';">

            {{-- Fallback placeholder jika gambar belum ada --}}
            <div id="denahPlaceholder"
                 class="w-full h-64 lg:h-96 bg-[#F4F4EF] hidden items-center justify-center rounded-2xl">
                <div class="text-center text-gray-400">
                    <svg class="w-16 h-16 mx-auto mb-3" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                    </svg>
                    <p class="text-sm font-medium">Denah Interaktif</p>
                </div>
            </div>

            {{-- Overlay dengan tombol ke denah penuh --}}
            <div class="absolute inset-0 flex items-end justify-center pb-8">
                <a href="{{ route('guest.denah') }}"
                   class="btn-primary-guest shadow-xl"
                   style="font-size:15px;padding:13px 32px;">
                    Buka Denah Interaktif
                </a>
            </div>
        </div>

        {{-- Legenda ringkas --}}
        <div class="flex flex-wrap justify-center gap-x-5 gap-y-2 mt-6 text-xs text-gray-600">
            @foreach ([
                ['Kios Besar',                    '#4B7AA8'],
                ['Kios F&B/Kuliner',              '#589A67'],
                ['Lapak Sayur & Buah',            '#25C54E'],
                ['Lapak Basah',                   '#DED24D'],
                ['Lapak Olahan & Jajanan',        '#EB8946'],
                ['Lapak Non-Halal',               '#C36D8A'],
            ] as [$nama, $warna])
                <span class="flex items-center gap-1.5">
                    <span class="w-2.5 h-2.5 rounded-full flex-shrink-0" style="background:{{ $warna }};"></span>
                    {{ $nama }}
                </span>
            @endforeach
        </div>
    </div>
</section>

{{-- ════════════════════════════════════════════════════
     TESTIMONI
════════════════════════════════════════════════════ --}}
<section id="testimoni" class="py-16 lg:py-24 bg-[#f5f5f5]">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="section-title text-center mb-12">Kesan Pengunjung</h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            {{-- Testimoni 1 --}}
            <div class="testi-card">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center font-bold text-[#007E43]">R</div>
                    <div>
                        <p class="font-semibold text-sm text-gray-900">Ria Vitriani</p>
                        <p class="text-xs text-gray-400">5 bulan lalu</p>
                    </div>
                </div>
                <div class="flex gap-0.5 mb-2">
                    @for($i=0;$i<5;$i++)<svg class="w-3.5 h-3.5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>@endfor
                </div>
                <p class="text-sm text-gray-600 leading-relaxed">
                    Benar-benar pasar modern, pasarnya bersih, terkelola dengan baik, rapih, kebutuhan bahan masakan semua tersedia. Bisa jadi pilihan tempat jalan pagi di weekend bersama keluarga.
                </p>
            </div>

            {{-- Testimoni 2 (featured / big) --}}
            <div class="testi-card border-2 border-[#007E43]/20">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center font-bold text-[#007E43]">M</div>
                    <div>
                        <p class="font-semibold text-sm text-gray-900">Marsian</p>
                        <p class="text-xs text-gray-400">2 bulan lalu</p>
                    </div>
                </div>
                <div class="flex gap-0.5 mb-2">
                    @for($i=0;$i<5;$i++)<svg class="w-3.5 h-3.5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>@endfor
                </div>
                <p class="text-sm text-gray-600 leading-relaxed">
                    Summarecon Gedebage bisa menjadi salah satu destinasi olahraga jalan pagi. Ada berbagai lapak sayuran, bumbu basah/kering, buah, daging, ayam, ikan basah, bahkan alat dapur. Kulineran juga tersedia!
                </p>
            </div>

            {{-- Testimoni 3 --}}
            <div class="testi-card">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center font-bold text-[#007E43]">H</div>
                    <div>
                        <p class="font-semibold text-sm text-gray-900">Hanny Mardiani</p>
                        <p class="text-xs text-gray-400">3 bulan lalu</p>
                    </div>
                </div>
                <div class="flex gap-0.5 mb-2">
                    @for($i=0;$i<5;$i++)<svg class="w-3.5 h-3.5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>@endfor
                </div>
                <p class="text-sm text-gray-600 leading-relaxed">
                    Pasar bersih, harganya tidak jauh beda dengan pasar pada umumnya. Ada kedai favorit mie gomak aceh yang mantap dan harganya murah.
                </p>
            </div>
        </div>
    </div>
</section>

{{-- ════════════════════════════════════════════════════
     BERITA TERBARU (dari database konten)
════════════════════════════════════════════════════ --}}
@if ($beritaTerbaru->count())
<section class="py-16 lg:py-24 bg-white">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="section-title text-center mb-10">Berita &amp; Promosi Terbaru</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach ($beritaTerbaru as $k)
            <a href="{{ route('guest.berita', $k->konten_id) }}" class="berita-card group">
                {{-- Gambar --}}
                @if ($k->img_url)
                    <img src="{{ asset('storage/' . $k->img_url) }}"
                         alt="{{ $k->judul }}"
                         class="w-full object-cover"
                         style="aspect-ratio:16/9;">
                @else
                    <div class="w-full bg-[#E6F6EE] flex items-center justify-center" style="aspect-ratio:16/9;">
                        <svg class="w-10 h-10 text-green-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                @endif
                <div class="p-4">
                    <span class="kategori-pill mb-2 inline-block">{{ strtoupper($k->kategori) }}</span>
                    <h3 class="font-manrope font-bold text-gray-900 text-sm leading-snug line-clamp-2 mb-1 group-hover:text-[#007E43] transition-colors"
                        style="font-family:'Manrope',sans-serif;">
                        {{ $k->judul }}
                    </h3>
                    <p class="text-xs text-gray-500 line-clamp-2">{{ $k->deskripsi }}</p>
                    <p class="text-[10px] text-gray-400 mt-2">{{ $k->created_at->translatedFormat('d F Y') }}</p>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection
