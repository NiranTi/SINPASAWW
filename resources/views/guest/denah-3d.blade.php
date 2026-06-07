<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Navigasi 3D interaktif untuk Pasar Sinpasa">
        <title>Navigasi 3D Pasar Sinpasa</title>
        <style>
            /* ── Dasar Canvas & Halaman ── */
            body {
                margin: 0;
                overflow: hidden;
                font-family: 'Manrope', sans-serif;
                background-color: #1a1a1a;
            }

            #gameCanvas {
                display: block;
                width: 100vw;
                height: 100vh;
            }

            /* ── UI Keterangan Navigasi (Pojok Kiri Atas) ── */
            .ui-overlay {
                position: absolute;
                top: 20px;
                left: 20px;
                color: #ffffff;
                background: rgba(20, 20, 25, 0.85);
                padding: 15px 20px;
                border-radius: 8px;
                border: 1px solid rgba(255, 255, 255, 0.1);
                pointer-events: none;
                z-index: 10;
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
            }

            /* ── Tombol Kembali (Pojok Kanan Atas) ── */
            .btn-return {
                position: absolute;
                top: 20px;
                left: 20px;
                padding: 10px 18px;
                background: #007E43;
                color: white;
                text-decoration: none;
                border-radius: 6px;
                font-weight: 700;
                font-size: 13px;
                z-index: 10;
                box-shadow: 0 4px 15px rgba(255, 79, 59, 0.3);
            }

            /* ── Kartu Detil Kios (Pojok Kanan Bawah) ── */
            #tenant-card {
                position: absolute;
                bottom: 30px;
                right: 30px;
                background: rgba(20, 20, 25, 0.95);
                border: 1px solid #333;
                border-left: 5px solid #1f6feb;
                padding: 15px 20px;
                border-radius: 8px;
                color: white;
                width: 300px;
                box-shadow: 0 10px 30px rgba(0,0,0,0.5);
                pointer-events: auto; 
                z-index: 100;
                display: none;
            }
        </style>
    </head>
    <body>
        <!-- Navigation Canvas -->
        <canvas id="gameCanvas" aria-label="Rendering area for 3D marketplace navigation"></canvas>

        <!-- UI Overlay with Navigation Info -->
        {{-- <div id="uiOverlay" class="ui-overlay" role="complementary" aria-label="Navigation information">
            <h2 class="ui-overlay__title">Navigasi 3D</h2>
            <p class="ui-overlay__target">
                Tujuan: <strong>{{ $target }}</strong>
            </p>
            <p class="ui-overlay__hint">Gunakan W, A, S, D & Mouse</p>
        </div> --}}

        <!-- Return Button -->
        <a href="{{ route('guest.denah') }}" id="btnKembali" class="btn-return" aria-label="Kembali ke denah 2D">
            ← Kembali ke Denah
        </a>

        <button id="btnGyro" class="btn-gyro" aria-label="Aktifkan Sensor Gerak">
            🧭
        </button>
        <style>
            .btn-gyro {
                position: fixed; bottom: 20px; right: 20px; z-index: 100;
                padding: 10px 16px; border-radius: 999px; border: none;
                background: #fff; color: #1a1a1a; font-weight: bold;
                box-shadow: 0 4px 15px rgba(0,0,0,0.2); cursor: pointer;
                transition: background 0.2s, color 0.2s;
            }
            .btn-gyro.active { background: #25C54E; color: white; }
        </style>

        <button id="btnResetCam" class="btn-reset-cam">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><!--!Font Awesome Free v7.2.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2026 Fonticons, Inc.--><path d="M129.9 292.5C143.2 199.5 223.3 128 320 128C373 128 421 149.5 455.8 184.2C456 184.4 456.2 184.6 456.4 184.8L464 192L416.1 192C398.4 192 384.1 206.3 384.1 224C384.1 241.7 398.4 256 416.1 256L544.1 256C561.8 256 576.1 241.7 576.1 224L576.1 96C576.1 78.3 561.8 64 544.1 64C526.4 64 512.1 78.3 512.1 96L512.1 149.4L500.8 138.7C454.5 92.6 390.5 64 320 64C191 64 84.3 159.4 66.6 283.5C64.1 301 76.2 317.2 93.7 319.7C111.2 322.2 127.4 310 129.9 292.6zM573.4 356.5C575.9 339 563.7 322.8 546.3 320.3C528.9 317.8 512.6 330 510.1 347.4C496.8 440.4 416.7 511.9 320 511.9C267 511.9 219 490.4 184.2 455.7C184 455.5 183.8 455.3 183.6 455.1L176 447.9L223.9 447.9C241.6 447.9 255.9 433.6 255.9 415.9C255.9 398.2 241.6 383.9 223.9 383.9L96 384C87.5 384 79.3 387.4 73.3 393.5C67.3 399.6 63.9 407.7 64 416.3L65 543.3C65.1 561 79.6 575.2 97.3 575C115 574.8 129.2 560.4 129 542.7L128.6 491.2L139.3 501.3C185.6 547.4 249.5 576 320 576C449 576 555.7 480.6 573.4 356.5z" fill="white" width="20px" height="20px"/></svg>
        </button>

        <style>
        .btn-reset-cam {
            position: fixed; bottom: 70px; right: 20px; z-index: 100;
            padding: 10px 16px; border-radius: 999px; border: none;
            background: #007E43; color: #EAF7F1; font-weight: normal;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2); cursor: pointer;
        }
        </style>

        <div id="joystickZone" class="joystick-zone">
            <div id="joystickBase" class="joystick-base">
                <div id="joystickStick" class="joystick-stick"></div>
            </div>
        </div>

        <style>
        /* CSS Analog Joystick */
        .joystick-zone {
            position: fixed; 
            bottom: 30px; 
            left: 50%; 
            transform: translateX(-50%); 
            width: 140px; 
            height: 140px; 
            z-index: 100;
            display: none; 
            touch-action: none; /* Mencegah layar ikut ter-scroll saat joystick ditarik */
        }
        @media (max-width: 768px) { .joystick-zone { display: block; } }

        .joystick-base {
            width: 100%; height: 100%; 
            background: rgba(255, 255, 255, 0.15); 
            border-radius: 50%; 
            position: relative; 
            backdrop-filter: blur(5px);
            border: 2px solid rgba(255,255,255,0.3);
        }

        .joystick-stick {
            width: 50px; height: 50px; 
            background: rgba(255, 255, 255, 0.9); 
            border-radius: 50%; 
            position: absolute; 
            top: 50%; left: 50%; 
            transform: translate(-50%, -50%); 
            box-shadow: 0 4px 10px rgba(0,0,0,0.3); 
            pointer-events: none; /* Agar sentuhan tembus langsung ke base */
            transition: transform 0.1s ease-out; /* Animasi memantul saat dilepas */
        }
        </style>

        <!-- Three.js Import Map -->
        <script type="importmap">
            {
                "imports": {
                    "three": "https://unpkg.com/three@0.160.0/build/three.module.js",
                    "three/addons/": "https://unpkg.com/three@0.160.0/examples/jsm/"
                }
            }
        </script>

        <!-- 3D Navigation Application -->
        @vite(['resources/js/denah-3d.js'])
    </body>
</html>