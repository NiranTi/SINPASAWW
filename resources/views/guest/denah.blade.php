{{-- resources/views/guest/denah.blade.php --}}
@extends('layouts.guest')

@section('title', 'Denah Pasar – Pasar Modern Sinpasa')

@section('styles')
<style>
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

/* ── Info card (klik lapak) ──────────────────────── */
.info-card {
    position:fixed; bottom:-100%; left:50%; transform:translateX(-50%);
    width:min(380px, 95vw); background:#fff; border-radius:20px 20px 0 0;
    box-shadow:0 -4px 30px rgba(0,0,0,.15); z-index:100;
    transition:bottom .35s cubic-bezier(.4,0,.2,1);
    display: flex;
    flex-direction: column;
    max-height: 85vh; 
    overflow: hidden;
}
.info-card.show { bottom:0; }

/* Desktop: tampilkan sebagai panel kanan */
@media (min-width:768px) {
    .info-card {
        position:fixed; bottom:auto; left:auto;
        top:50%; right:1.5rem; transform:translateY(-50%);
        border-radius:16px;
        box-shadow:0 8px 40px rgba(0,0,0,.15);
        transition:opacity .2s, transform .2s;
        opacity:0; transform:translateY(-50%) translateX(20px);
        pointer-events:none;
        max-height: 90vh;
    }
    .info-card.show {
        opacity:1; transform:translateY(-50%) translateX(0);
        pointer-events:auto;
    }
}

.info-card-image { position:relative; flex-shrink: 0;}
.info-card-image img { width:100%; height:160px; object-fit:cover; }
.info-badge {
    position:absolute; bottom:10px; left:12px;
    padding:3px 10px; border-radius:999px;
    font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:.06em;
    background:rgba(0,0,0,.55); color:#fff; backdrop-filter:blur(4px);
}
.info-card-body { 
    padding:1rem 1.25rem 1.5rem;
    overflow-y: auto;
    padding-bottom: calc(2rem + env(safe-area-inset-bottom));
}
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

{{-- ── Page header ── --}}
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pt-10 pb-4 text-center">
    <h1 class="font-manrope font-black text-2xl lg:text-4xl text-[#003B1F] mb-2"
        style="font-family:'Manrope',sans-serif;">Denah Pasar</h1>
    <p class="text-gray-500 text-sm lg:text-base max-w-lg mx-auto">
        Gunakan denah interaktif kami untuk menemukan tenant yang dicari lebih cepat.
    </p>
</div>

{{-- ── Zoom controls ── --}}
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 mb-3">
    <div class="flex items-center justify-end gap-2">
        <button id="btn-zoom-in"    class="zoom-btn">+ Perbesar</button>
        <button id="btn-zoom-reset" class="zoom-btn">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
            </svg>
            Reset
        </button>
        <button id="btn-zoom-out"   class="zoom-btn">− Perkecil</button>
    </div>
</div>

{{-- ── Denah map container ── --}}
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 mb-6">
    <div class="denah-wrap" id="denahContainer">
        {{-- EMBEDDED SVG dari denah.html asli --}}
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 2124 1024" fill="none" id="denahSvg">
            @include('components.guest.denah-svg')
            <polyline id="dijkstraPath" points="" stroke="#00AAFF" stroke-width="8" stroke-linecap="round" stroke-linejoin="round" fill="none" style="filter: drop-shadow(0px 0px 8px #00AAFF); opacity: 0.9; pointer-events: none;" />
        </svg>
    </div>
</div>

{{-- ── Legend / Filter ── --}}
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 mb-12">
    <div class="flex flex-wrap gap-2">
        @foreach ([
            ['all',                              '#374151', 'Semua Lapak'],
            ['kios-besar',                       '#4B7AA8', 'Kios Besar'],
            ['kios-kecil',                       '#2C85B1', 'Kios Kecil'],
            ['kios-fnb',                         '#589A67', 'Kios F&B/Kuliner'],
            ['lapak-sayur-buah-dan-jajanan',     '#25C54E', 'Lapak Sayur & Buah'],
            ['lapak-non-halal',                  '#C36D8A', 'Lapak Non-Halal'],
            ['lapak-basah',                      '#DED24D', 'Lapak Basah'],
            ['lapak-olahan-dan-jajanan',         '#EB8946', 'Lapak Olahan & Jajanan'],
            ['lapak-kuliner',                    '#FF4F3B', 'Pojok Kuliner'],
            ['galeri-dekranasda',                '#ABA08E', 'Galeri Dekranasda'],
            ['mushola',                          '#8E9176', 'Mushola'],
            ['atm',                              '#827E8E', 'ATM Center'],
            ['toilet',                           '#A78A85', 'Toilet'],
            ['area-pengelola',                   '#D9D9D9', 'Area Pengelola'],
        ] as [$filter, $warna, $label])
            <button class="legend-item {{ $filter === 'all' ? 'active' : '' }}"
                    data-filter="{{ $filter }}">
                <span class="legend-dot" style="background:{{ $warna }};"></span>
                {{ $label }}
            </button>
        @endforeach
    </div>
</div>

{{-- ── Info card popup (click on lapak) ── --}}
<div id="infoCard" class="info-card" role="dialog" aria-label="Info Lapak">
    <div class="info-card-image">
        <img id="infoImage" src="{{ asset('images/default-lapak.jpg') }}" alt="Foto Tenant"
             onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'380\' height=\'160\' viewBox=\'0 0 380 160\'%3E%3Crect fill=\'%23E6F6EE\' width=\'380\' height=\'160\'/%3E%3C/svg%3E';">
        <span id="infoBadge" class="info-badge">KATEGORI</span>
        <button id="infoClose"
                class="absolute top-3 right-3 w-7 h-7 flex items-center justify-center bg-black/50 text-white rounded-full text-lg leading-none hover:bg-black/70 transition-colors">
            ×
        </button>
    </div>
    <div class="info-card-body">
        <p id="infoId" class="info-id">L000</p>
        <h2 id="infoTitle" class="info-title">Nama Toko</h2>
        <p id="infoDesc" class="info-desc">Deskripsi toko akan muncul di sini.</p>

        <a href="#" id="infoLink"
           class="btn-primary-guest w-full justify-center text-sm py-2.5 hidden"
           style="font-size:13px; padding:10px 20px; display:none;">
            Kunjungi Profil Toko
        </a>

        <div id="navStatus" class="text-xs" style="margin-bottom: 10px; padding: 8px; background: #f3f4f6; border-radius: 6px; font-size: 12px; color: #4b5563;">
            📍 Titik Awal: <span id="txtStartNode" style="font-weight: bold; color: #007E43;">Belum ditentukan (Klik Manual di Denah / Scan QR Terdekat)</span>
        </div>

        <button id="btnPilihStart" class="zoom-btn w-full justify-center mb-2" style="width:100%; margin-bottom:8px; display:block;">
            🎯 Jadikan Ini Titik Awal Navigasi
        </button>
        
        <button id="btnNavigasi3d" class="btn-secondary" style="display: block; width: 100%; margin-top: 10px; padding: 10px; background-color: #1f6feb; color: white; border: none; border-radius: 5px; cursor: pointer;">
            Mulai Navigasi 3D ke Sini
        </button>
    </div>
</div>

{{-- Overlay penutup info card di mobile --}}
<div id="infoOverlay" class="fixed inset-0 bg-black/30 z-50 hidden md:hidden" onclick="closeInfoCard()"></div>

{{-- ── Tenant data dari database (JSON inline untuk JS) ── --}}
<script id="tenantData" type="application/json">
    @json($denahTenants)
</script>
@endsection

@section('scripts')
{{-- Compile dlu bundle script lewat Vite --}}
@vite(['resources/js/dijkstra.js'])

<script>
    (function () {
        let graphData = null;
        let startNodeId = null; 
        let currentTargetLapakId = null;
        const tenantData = JSON.parse(document.getElementById('tenantData').textContent || '{}');
        let data = { nodes: {}, edges: [] };

        // ==========================================
        // A. EKSTRAK NODES (Sama seperti sebelumnya)
        // ==========================================
        const lingkaranSvg = document.querySelectorAll('#denahSvg circle[id^="node-"]');
        lingkaranSvg.forEach(circle => {
            const nodeId = circle.id;
            const cx = parseFloat(circle.getAttribute('cx')) || 0;
            const cy = parseFloat(circle.getAttribute('cy')) || 0;

            data.nodes[nodeId] = {
                x: cx,
                y: cy,
                label: nodeId.replace('node-', '').replace(/_/g, ' ').toUpperCase()
            };
        });

        // ==========================================
        // B. EKSTRAK EDGES + GAMBAR STROKE OTOMATIS
        // ==========================================
        const garisJalur = document.querySelectorAll('#denahSvg line[data-from][data-to]');
        garisJalur.forEach(line => {
            const fromNode = line.getAttribute('data-from');
            const toNode = line.getAttribute('data-to');

            if (data.nodes[fromNode] && data.nodes[toNode]) {
                const nodeA = data.nodes[fromNode];
                const nodeB = data.nodes[toNode];

                // 💡 TRIKNYA DI SINI: SUNTIKKAN KOORDINAT VISUAL KE ELEMEN <line> SECARA OTOMATIS!
                line.setAttribute('x1', nodeA.x);
                line.setAttribute('y1', nodeA.y);
                line.setAttribute('x2', nodeB.x);
                line.setAttribute('y2', nodeB.y);

                // Hitung jarak (Weight) otomatis dengan Pythagoras
                const dx = nodeA.x - nodeB.x;
                const dy = nodeA.y - nodeB.y;
                const jarakOtomatis = Math.round(Math.sqrt(dx * dx + dy * dy));

                data.edges.push({
                    from: fromNode,
                    to: toNode,
                    weight: jarakOtomatis
                });
            }
        });

        graphData = data;
        console.log("Graf & Garis Visual Berhasil Digenerate Otomatis!", graphData);

        checkQrCodeParam();
        
        /* ── 2. DETEKSI QR CODE URL (DEEP-LINK LOKASI AWAL) ── */
        function checkQrCodeParam() {
            const urlParams = new URLSearchParams(window.location.search);
            const scanNode = urlParams.get('scan_node');

            if (scanNode && graphData && graphData.nodes[scanNode]) {
                startNodeId = scanNode;
                const nodeInfo = graphData.nodes[scanNode];
                
                const txtStart = document.getElementById('txtStartNode');
                if (txtStart) txtStart.textContent = nodeInfo.label || scanNode;
                
                const circleEl = document.getElementById(scanNode);
                if (circleEl) {
                    circleEl.setAttribute('fill', '#007E43');
                    circleEl.setAttribute('r', '12');
                    circleEl.style.opacity = '1';
                }
            }
        }

        /* ── 3. HITUNG & GAMBAR PREVIEW RUTE DIJKSTRA ── */
        function updateRoutePreview() {
            if (!graphData || !startNodeId || !currentTargetLapakId) return;

            const endNodeId = `node-${currentTargetLapakId}`;
            
            // Diubah menjadi window.findShortestPath agar terbaca dari hasil compile Vite
            if (typeof window.findShortestPath !== 'function') {
                console.error("Fungsi findShortestPath belum dimuat di object window.");
                return;
            }
            const routePoints = window.findShortestPath(graphData, startNodeId, endNodeId);
            const polylineEl = document.getElementById('dijkstraPath');

            if (polylineEl) {
                if (routePoints && routePoints.length > 0) {
                    const pointsString = routePoints.map(p => `${p.x},${p.y}`).join(' ');
                    polylineEl.setAttribute('points', pointsString);
                    console.log("Rute jalan 2D berhasil digambar!");
                } else {
                    polylineEl.setAttribute('points', '');
                }
            }
        }

        /* ── 4. KONTROL KARTU INFORMASI (INFO CARD) ── */
        const infoCard    = document.getElementById('infoCard');
        const infoOverlay = document.getElementById('infoOverlay');
        const infoImage   = document.getElementById('infoImage');
        const infoBadge   = document.getElementById('infoBadge');
        const infoId      = document.getElementById('infoId');
        const infoTitle   = document.getElementById('infoTitle');
        const infoDesc    = document.getElementById('infoDesc');
        const btnClose    = document.getElementById('infoClose');

        function showInfoCard(lapakId, cssClass) {
            if (!infoCard) return;
            
            currentTargetLapakId = lapakId;
            const t = tenantData[lapakId];

            infoId.textContent    = lapakId;
            infoTitle.textContent = t?.nama ?? formatId(lapakId);
            infoDesc.textContent  = t?.deskripsi ?? 'Belum ada informasi detail untuk lapak ini.';
            infoBadge.textContent = (t?.kategori ?? cssClass.replace(/-/g,' ')).toUpperCase();

            const txtStart = document.getElementById('txtStartNode');
            if (txtStart) {
                if (startNodeId && graphData && graphData.nodes[startNodeId]) {
                    txtStart.textContent = graphData.nodes[startNodeId].label || startNodeId;
                } else {
                    txtStart.textContent = "Belum ditentukan (Klik Manual / Scan QR)";
                }
            }

            const btnPilihStart = document.getElementById('btnPilihStart');
            if (btnPilihStart) {
                btnPilihStart.onclick = function() {
                    startNodeId = `node-${lapakId}`;
                    if (graphData && graphData.nodes[startNodeId]) {
                        if (txtStart) txtStart.textContent = graphData.nodes[startNodeId].label;
                        updateRoutePreview();
                    } else {
                        alert("Titik navigasi untuk lapak ini belum terdaftar di data graf!");
                    }
                };
            }

            const btnNavigasi3d = document.getElementById('btnNavigasi3d');
            if (btnNavigasi3d) {
                btnNavigasi3d.onclick = function() {
                    if (!startNodeId) {
                        alert("Silakan tentukan Lokasi Awal Anda terlebih dahulu!");
                        return;
                    }

                    sessionStorage.setItem('graphData', JSON.stringify(graphData));
                    window.location.href = `/denah/rute?start=${startNodeId}&target=${lapakId}`;
                    // window.location.href = `${url3D}?start=${startNodeId}&target=${lapakId}`;
                };
            }

            infoCard.classList.add('show');
            if (infoOverlay) infoOverlay.classList.remove('hidden');
            
            updateRoutePreview();
        }

        window.closeInfoCard = function() {
            if (infoCard) infoCard.classList.remove('show');
            if (infoOverlay) infoOverlay.classList.add('hidden');
        }

        if (btnClose) btnClose.addEventListener('click', window.closeInfoCard);

        function formatId(id) { return id.replace(/-/g,' ').replace(/\b\w/g, c => c.toUpperCase()); }

        /* ── 5. PASANG EVENT LISTENER KLIK PADA SVG KIOS ── */
        const interactiveClasses = [
            'lapak-sayur-buah-dan-jajanan','lapak-olahan-dan-jajanan','lapak-non-halal',
            'lapak-basah','lapak-kuliner','kios-besar','kios-kecil','kios-fnb','atm','mushola','toilet',
        ];

        const svg = document.getElementById('denahSvg');
        const lapakEls = svg ? svg.querySelectorAll(interactiveClasses.map(c => '.' + c).join(',')) : [];

        lapakEls.forEach(el => {
            el.style.cursor = 'pointer';
            el.addEventListener('click', (e) => {
                e.stopPropagation(); 
                showInfoCard(el.id || '', el.classList[0] || '');
            });
        });

        /* ── 6. LEGENDA FILTER KATEGORI LAPAK ── */
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

        /* ── 7. FITUR ZOOM & RESET PETA ── */
        let scale = 1;
        const container = document.getElementById('denahContainer');

        function applyZoom() { if (svg) svg.style.transform = `scale(${scale})`; }
        document.getElementById('btn-zoom-in')?.addEventListener('click', () => { scale = Math.min(3, parseFloat((scale + 0.3).toFixed(1))); applyZoom(); });
        document.getElementById('btn-zoom-out')?.addEventListener('click', () => { scale = Math.max(0.5, parseFloat((scale - 0.3).toFixed(1))); applyZoom(); });
        document.getElementById('btn-zoom-reset')?.addEventListener('click', () => { scale = 1; applyZoom(); if (container) { container.scrollTop = 0; container.scrollLeft = 0; } window.closeInfoCard(); });

        /* Tutup info card saat klik di luar area lapak */
        document.addEventListener('click', e => {
            if (infoCard && !infoCard.contains(e.target) && !e.target.closest('svg')) {
                window.closeInfoCard();
            }
        });
    })();
</script>
@endsection