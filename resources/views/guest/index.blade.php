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
    background:linear-gradient(to right, rgba(0,0,0,.88) 0%, rgba(0,0,0,.5) 55%, transparent 100%);
}

/* ── Fasilitas card ───────────────────────────── */
.fasilitas-card {
    background:#FAFAF5; border-radius:16px; padding:1.75rem 1.5rem;
    text-align:center; transition:box-shadow .2s, transform .2s;
}
.fasilitas-card:hover {
    box-shadow:0 8px 30px rgba(0,126,67,.12);
    transform:translateY(-3px);
}
.fasilitas-icon {
    width:56px; height:56px; border-radius:16px;
    background:#B0E4CC; display:flex; align-items:center; justify-content:center;
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
    font-weight:800; color:#121212; letter-spacing:-.02em;
}
.section-subtitle { font-size:15px; color:#121212; margin-top:.5rem; }

/* ── Denah container ────────────────────────────── */
.denah-wrap {
    width:100%; overflow:auto; border-radius:16px;
    background:#D9D9D9; position:relative;
    max-height:75vh; min-height:300px;
    border:1px solid #e5e7eb;
    cursor:grab;
}
.denah-wrap:active { cursor:grabbing; }

.denah-wrap svg {
    width:100%; min-width:700px;
    transform-origin:top left;
    transition:transform .2s ease;
    display:block;
}

/* ── Lapak hover ─────────────────────────────────── */
.denah-wrap svg [class]:not(.galeri-dekranasda):not(.area-pengelola) {
    cursor:pointer; transition:opacity .15s, filter .1s;
}
.denah-wrap svg [class]:not(.galeri-dekranasda):not(.area-pengelola):hover {
    opacity:.75; filter:brightness(1.1);
}
.lapak-dimmed { opacity:.2 !important; }

/* ── Info card ──────────────────────────────────── */
.info-card {
    position:fixed; bottom:-100%; left:50%; transform:translateX(-50%);
    width:min(380px, 95vw); background:#fff; border-radius:20px 20px 0 0;
    box-shadow:0 -4px 30px rgba(0,0,0,.15); z-index:100;
    transition:bottom .35s cubic-bezier(.4,0,.2,1);
    overflow:hidden;
}
.info-card.show { bottom:0; }

@media (min-width:768px) {
    .info-card {
        position:fixed; bottom:auto; left:auto;
        top:50%; right:1.5rem; transform:translateY(-50%);
        border-radius:16px;
        box-shadow:0 8px 40px rgba(0,0,0,.15);
        transition:opacity .2s, transform .2s;
        opacity:0; transform:translateY(-50%) translateX(20px);
        pointer-events:none;
    }
    .info-card.show {
        opacity:1; transform:translateY(-50%) translateX(0);
        pointer-events:auto;
    }
}

.info-card-image { position:relative; }
.info-card-image img { width:100%; height:160px; object-fit:cover; }
.info-badge {
    position:absolute; bottom:10px; left:12px;
    padding:3px 10px; border-radius:999px;
    font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:.06em;
    background:rgba(0,0,0,.55); color:#fff; backdrop-filter:blur(4px);
}
.info-card-body { padding:1rem 1.25rem 1.5rem; }
.info-id { font-size:11px; color:#9ca3af; font-family:monospace; margin-bottom:2px; }
.info-title { font-family:'Manrope',sans-serif; font-size:1.1rem; font-weight:800; color:#1a1a1a; line-height:1.2; margin-bottom:.4rem; }
.info-desc { font-size:13px; color:#6b7280; line-height:1.5; margin-bottom:1rem; }

/* ── Legend ──────────────────────────────────────── */
.legend-item {
    display:flex; align-items:center; gap:8px; cursor:pointer;
    padding:5px 10px; border-radius:999px; transition:background .15s;
    font-size:12px; color:#374151;
}
.legend-item:hover { background:#f3f4f6; }
.legend-item.active { background:#E6F6EE; color:#007E43; font-weight:600; }
.legend-dot { width:12px; height:12px; border-radius:3px; flex-shrink:0; }

/* ── Zoom controls ───────────────────────────────── */
.zoom-btn {
    display:flex; align-items:center; justify-content:center; gap:6px;
    padding:8px 16px; border-radius:999px; border:1.5px solid #e5e7eb;
    background:#fff; font-size:13px; font-weight:500; color:#374151;
    cursor:pointer; transition:all .15s; white-space:nowrap;
}
.zoom-btn:hover { border-color:#007E43; color:#007E43; }
</style>
@endsection

@section('content')

{{-- ════════════════════════════════════════════════════
     HERO
════════════════════════════════════════════════════ --}}
<section id="hero" class="hero-section rounded-3xl mt-5 overflow-hidden">
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
    <div class="max-w-6xl mx-auto px-4 sm:px-7 lg:px-8">
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
                        <svg class="w-7 h-7" style="color:#008647;" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7v10m4-10v10M5 3h14a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2z"/>
                        </svg>
                    @elseif ($f['icon'] === 'toilet')
                        <svg class="w-7 h-7" style="color:#6D4200;" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    @elseif ($f['icon'] === 'mosque')
                        <svg class="w-7 h-7" style="color:#008647;" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 21h18M5 21V8.72a2 2 0 011.18-1.82l5-2.22a2 2 0 011.64 0l5 2.22A2 2 0 0119 8.72V21M9 21v-5a3 3 0 016 0v5"/>
                        </svg>
                    @else
                        <svg class="w-7 h-7" style="color:#6D4200;" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                        </svg>
                    @endif
                </div>
                <h4 class="font-manrope font-bold text-[#121212] mb-1.5 text-sm lg:text-base"
                    style="font-family:'Manrope',sans-serif;">{{ $f['title'] }}</h4>
                <p class="text-[#121212] text-xs lg:text-sm leading-relaxed">{{ $f['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ════════════════════════════════════════════════════
     DENAH PREVIEW
════════════════════════════════════════════════════ --}}
<section id="denah" class="py-16 lg:py-20 bg-[#FAFAF5]">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="section-title mb-2">Temukan Rute Belanja Anda</h2>
        <p class="section-subtitle mb-8">
            Gunakan denah interaktif kami untuk menemukan produk yang dicari lebih cepat.
        </p>

        {{-- Zoom controls --}}
        <div class="flex items-center justify-end gap-2 mb-3">
            <button id="btn-zoom-in" class="zoom-btn">+ Perbesar</button>
            <button id="btn-zoom-reset" class="zoom-btn">Reset</button>
            <button id="btn-zoom-out" class="zoom-btn">− Perkecil</button>
        </div>

        {{-- Denah SVG --}}
        <div class="denah-wrap" id="denahContainer">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 2132 1032" fill="none" id="denahSvg">
                @include('components.guest.denah-svg')
            </svg>
        </div>

        {{-- Legenda --}}
        <div class="flex flex-wrap justify-center gap-2 mt-6">
            @foreach ([
                ['all',                          '#374151', 'Semua Lapak'],
                ['kios-besar',                   '#4B7AA8', 'Kios Besar'],
                ['kios-fnb',                     '#589A67', 'Kios F&B/Kuliner'],
                ['lapak-sayur-buah-dan-jajanan', '#25C54E', 'Lapak Sayur & Buah'],
                ['lapak-basah',                  '#DED24D', 'Lapak Basah'],
                ['lapak-olahan-dan-jajanan',     '#EB8946', 'Lapak Olahan & Jajanan'],
                ['lapak-non-halal',              '#C36D8A', 'Lapak Non-Halal'],
            ] as [$filter, $warna, $label])
                <button class="legend-item {{ $filter === 'all' ? 'active' : '' }}"
                        data-filter="{{ $filter }}">
                    <span class="legend-dot" style="background:{{ $warna }};"></span>
                    {{ $label }}
                </button>
            @endforeach
        </div>
    </div>

    {{-- Info card popup --}}
    <div id="infoCard" class="info-card" role="dialog">
        <div class="info-card-image">
            <img id="infoImage" src="{{ asset('images/default-lapak.jpg') }}" alt="Foto Tenant">
            <span id="infoBadge" class="info-badge">KATEGORI</span>
            <button id="infoClose"
                    class="absolute top-3 right-3 w-7 h-7 flex items-center justify-center bg-black/50 text-white rounded-full text-lg leading-none">×</button>
        </div>
        <div class="info-card-body">
            <p id="infoId" class="info-id"></p>
            <h2 id="infoTitle" class="info-title"></h2>
            <p id="infoDesc" class="info-desc"></p>
        </div>
    </div>
    <div id="infoOverlay" class="fixed inset-0 bg-black/30 z-50 hidden md:hidden" onclick="closeInfoCard()"></div>

    {{-- Tenant data JSON --}}
    <script id="tenantData" type="application/json">@json($denahTenants)</script>
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
                        <p class="font-reguler text-sm text-[#1A1C19]">Ria Vitriani</p>
                        <p class="text-xs text-[#40493D]">5 bulan lalu</p>
                    </div>
                </div>
                <div class="flex gap-0.5 mb-2">
                    @for($i=0;$i<5;$i++)<svg class="w-3.5 h-3.5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>@endfor
                </div>
                <p class="text-sm text-[#121212] leading-relaxed">
                    Benar-benar pasar modern, pasarnya bersih, terkelola dengan baik, rapih, kebutuhan bahan masakan semua tersedia. Bisa jadi pilihan tempat jalan pagi di weekend bersama keluarga.
                </p>
            </div>

            {{-- Testimoni 2 (featured / big) --}}
            <div class="testi-card border-2 border-[#007E43]/20">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center font-bold text-[#007E43]">M</div>
                    <div>
                        <p class="font-reguler text-sm text-[#1A1C19]">Marsian</p>
                        <p class="text-xs text-[#40493D]">2 bulan lalu</p>
                    </div>
                </div>
                <div class="flex gap-0.5 mb-2">
                    @for($i=0;$i<5;$i++)<svg class="w-3.5 h-3.5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>@endfor
                </div>
                <p class="text-sm text-[#121212] leading-relaxed">
                    Summarecon Gedebage bisa menjadi salah satu destinasi olahraga jalan pagi. Ada berbagai lapak sayuran, bumbu basah/kering, buah, daging, ayam, ikan basah, bahkan alat dapur. Kulineran juga tersedia!
                </p>
            </div>

            {{-- Testimoni 3 --}}
            <div class="testi-card">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center font-bold text-[#007E43]">H</div>
                    <div>
                        <p class="font-reguler text-sm text-[#1A1C19]">Hanny Mardiani</p>
                        <p class="text-xs text-[#40493D]">3 bulan lalu</p>
                    </div>
                </div>
                <div class="flex gap-0.5 mb-2">
                    @for($i=0;$i<5;$i++)<svg class="w-3.5 h-3.5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>@endfor
                </div>
                <p class="text-sm text-[#121212] leading-relaxed">
                    Pasar bersih, harganya tidak jauh beda dengan pasar pada umumnya. Ada kedai favorit mie gomak aceh yang mantap dan harganya murah.
                </p>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>

(function () {
    const tenantData = JSON.parse(document.getElementById('tenantData')?.textContent || '{}');

    const imgMap = {
        sayur:    '{{ asset("images/sayuran.png") }}',
        basah:    '{{ asset("images/daging.png") }}',
        olahan:   '{{ asset("images/jajanan.png") }}',
        'non-halal': '{{ asset("images/nonhalal.png") }}',
        fnb:      '{{ asset("images/kuliner.png") }}',
        kuliner:  '{{ asset("images/kuliner.png") }}',
        default:  '{{ asset("images/default-lapak.jpg") }}',
    };

    function getImg(kategori) {
        if (!kategori) return imgMap.default;
        const k = kategori.toLowerCase();
        if (k.includes('sayur') || k.includes('buah')) return imgMap.sayur;
        if (k.includes('basah') || k.includes('daging') || k.includes('ikan')) return imgMap.basah;
        if (k.includes('olahan') || k.includes('jajanan')) return imgMap.olahan;
        if (k.includes('non-halal') || k.includes('non halal')) return imgMap['non-halal'];
        if (k.includes('fnb') || k.includes('f&b') || k.includes('kuliner')) return imgMap.kuliner;
        return imgMap.default;
    }

    const infoCard    = document.getElementById('infoCard');
    const infoOverlay = document.getElementById('infoOverlay');
    const infoImage   = document.getElementById('infoImage');
    const infoBadge   = document.getElementById('infoBadge');
    const infoId      = document.getElementById('infoId');
    const infoTitle   = document.getElementById('infoTitle');
    const infoDesc    = document.getElementById('infoDesc');
    const btnClose    = document.getElementById('infoClose');

    function showInfoCard(lapakId, cssClass) {
        const t = tenantData[lapakId];
        infoId.textContent    = lapakId;
        infoTitle.textContent = t?.nama      ?? lapakId;
        infoDesc.textContent  = t?.deskripsi ?? 'Belum ada informasi detail.';
        infoBadge.textContent = (t?.kategori ?? cssClass.replace(/-/g,' ')).toUpperCase();
        infoImage.src = t?.foto ?? getImg(t?.kategori ?? cssClass);
        infoCard.classList.add('show');
        infoOverlay.classList.remove('hidden');
    }

    function closeInfoCard() {
        infoCard.classList.remove('show');
        infoOverlay.classList.add('hidden');
    }

    btnClose?.addEventListener('click', closeInfoCard);

    const interactiveClasses = [
        'lapak-sayur-buah-dan-jajanan','lapak-olahan-dan-jajanan','lapak-non-halal',
        'lapak-basah','lapak-kuliner','kios-besar','kios-kecil','kios-fnb',
        'atm','mushola','toilet',
    ];

    const svg = document.getElementById('denahSvg');
    const lapakEls = svg ? svg.querySelectorAll(interactiveClasses.map(c => '.' + c).join(',')) : [];

    lapakEls.forEach(el => {
        el.style.cursor = 'pointer';
        el.addEventListener('click', () => {
            showInfoCard(el.id || '', el.classList[0] || '');
        });
    });

    // Filter legend
    document.querySelectorAll('.legend-item').forEach(btn => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('.legend-item').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            const f = btn.dataset.filter;
            lapakEls.forEach(el => {
                if (f === 'all' || el.classList.contains(f)) {
                    el.classList.remove('lapak-dimmed');
                } else {
                    el.classList.add('lapak-dimmed');
                }
            });
        });
    });

    // Zoom
    let scale = 1;
    const svgEl     = document.getElementById('denahSvg');
    const container = document.getElementById('denahContainer');

    function applyZoom() {
        if (svgEl) svgEl.style.transform = `scale(${scale})`;
    }

    document.getElementById('btn-zoom-in')?.addEventListener('click', () => {
        scale = Math.min(3, parseFloat((scale + 0.3).toFixed(1)));
        applyZoom();
    });
    document.getElementById('btn-zoom-out')?.addEventListener('click', () => {
        scale = Math.max(0.5, parseFloat((scale - 0.3).toFixed(1)));
        applyZoom();
    });
    document.getElementById('btn-zoom-reset')?.addEventListener('click', () => {
        scale = 1;
        applyZoom();
        if (container) { container.scrollTop = 0; container.scrollLeft = 0; }
        closeInfoCard();
    });

    // Pinch zoom mobile
    let startDist = null, startScale = 1;
    container?.addEventListener('touchstart', e => {
        if (e.touches.length === 2) {
            startDist  = Math.hypot(e.touches[0].clientX - e.touches[1].clientX, e.touches[0].clientY - e.touches[1].clientY);
            startScale = scale;
        }
    }, { passive: true });

    container?.addEventListener('touchmove', e => {
        if (e.touches.length === 2 && startDist) {
            const dist = Math.hypot(e.touches[0].clientX - e.touches[1].clientX, e.touches[0].clientY - e.touches[1].clientY);
            scale = Math.min(3, Math.max(0.5, startScale * (dist / startDist)));
            applyZoom();
        }
    }, { passive: true });

    container?.addEventListener('touchend', () => { startDist = null; });
})();
</script>
@endsection
