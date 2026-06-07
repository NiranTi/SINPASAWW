{{-- resources/views/layouts/tenant.blade.php --}}
<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Portal Tenant')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* ── Design tokens (dari beranda) ───────────────────── */
        :root {
            --primary:      #007E43;
            --primary-soft: #EAF7F1;
            --danger:       #BA1A1A;
            --danger-soft:  #FFDAD6;
            --orange:       #B66E00;
            --orange-soft:  #FBDDB0;
        }

        /* ── Base ── */
        body { font-family:'Be Vietnam Pro',sans-serif; background-color:#FAFAF5; color:#1a1a1a; }
        .font-manrope { font-family:'Manrope',sans-serif; }
        ::-webkit-scrollbar { width:4px; }
        ::-webkit-scrollbar-track { background:transparent; }
        ::-webkit-scrollbar-thumb { background:#d1d5db; border-radius:2px; }

        /* ── Cards ── */
        .stat-card    { background:#F4F4EF; border-radius:16px; padding:1.5rem 1.8rem; }
        .stat-card.danger-card { background-color:var(--danger-soft); }
        .section-card { background:#F4F4EF; border-radius:16px; }
        .form-card    { background:#ffffff; border-radius:16px; padding:1.5rem; }
        .kasbon-card  { background:#ffffff; border-radius:12px; padding:1rem 1.1rem; }

        /* ── Badges — hanya warna, tanpa background ── */
        .badge-success { color:var(--primary); }
        .badge-orange  { color:var(--orange);  }
        .badge-danger  { color:var(--danger);  }
        .badge-gray    { color:#6b7280; }

        /* ── Kode transaksi ── */
        .kode-ps { color:var(--primary); font-weight:600; font-size:10px;
                   background-color:var(--primary-soft); padding:2px 6px; border-radius:4px; }
        .kode-sp { color:var(--orange);  font-weight:600; font-size:10px;
                   background-color:var(--orange-soft);  padding:2px 6px; border-radius:4px; }

        /* ── Buttons ── */
        /* Outline: default putih, hover abu, active hijau */
        .btn-outline {
            display:inline-flex; align-items:center; justify-content:center; gap:6px;
            background:#fff; color:#374151; padding:7px 14px; border-radius:999px;
            font-size:13px; font-weight:500; cursor:pointer; text-decoration:none;
            transition:background .15s, color .15s; white-space:nowrap; border:none;
        }
        .btn-outline:hover  { background:#E8E8E3; color:var(--primary); }
        .btn-outline:active { background:var(--primary); color:#fff; }

        .btn-outline-barang { letter-spacing:1.2px; transition:background .15s, color .15s; }
        .btn-outline-barang:hover { background:#E8E8E3; color:var(--primary); }

        /* Primary: hijau pill — hover lebih cerah */
        .btn-primary {
            display:inline-flex; align-items:center; justify-content:center; gap:6px;
            background-color:var(--primary); color:#fff;
            border-radius:999px;
            font-size:14px; font-weight:500; border:none; letter-spacing:0.3px;
            cursor:pointer; text-decoration:none; transition:background-color .15s;
            white-space:nowrap;
        }
        .btn-primary:hover { background-color:#009750; }

        /* Lunasi pill */
        .btn-lunasi {
            border:1.5px solid #d1d5db; background:#fff; color:#374151;
            padding:5px 18px; border-radius:999px; font-size:12px; font-weight:500;
            cursor:pointer; transition:border-color .15s, background .15s, color .15s;
            white-space:nowrap;
        }
        .btn-lunasi:hover  { border-color:var(--primary); color:var(--primary); }
        .btn-lunasi:active { background:var(--primary); color:#fff; border-color:var(--primary); }

        /* ── Hamburger (2rem, pill, no border) ── */
        .hamburger-btn {
            display:flex; align-items:center; justify-content:center;
            width:2rem; height:2rem; flex-shrink:0;
            border-radius:999px; cursor:pointer; background:transparent;
            transition:background .15s;
        }
        .hamburger-btn:hover  { background:var(--primary-soft); }
        .hamburger-btn:active { background:var(--primary); }
        .hamburger-btn:active svg { color:#fff !important; }

        /* ── Shared tab/toggle wrap (periode, stok form tabs, dll) ── */
        .tab-wrap {
            display:inline-flex; align-items:center;
            gap:4px; background:#F4F4EF; border-radius:999px; padding:4px;
        }
        .tab-btn {
            padding:5px 14px; border-radius:999px; font-size:12px; font-weight:500;
            cursor:pointer; border:none; color:#40493D; background:transparent;
            transition:all .15s; white-space:nowrap;
        }
        .tab-btn.active { background-color:var(--primary); color:#fff; }

        /* alias beranda pakai periode-wrap/btn — pointer ke tab-wrap/btn */
        .periode-wrap { display:inline-flex; align-items:center; gap:4px; background:#F4F4EF; border-radius:999px; padding:4px; }
        .periode-btn  { padding:5px 14px; border-radius:999px; font-size:10px; font-weight:500; cursor:pointer; border:none; color:#40493D; background:transparent; transition:all .15s; }
        .periode-btn.active { background-color:var(--primary); color:#fff; }

        /* ── Form elements ── */
        .form-group { margin-bottom:1rem; }
        .form-label {
            display:block; font-size:11px; font-weight:500;
            letter-spacing:.07em; text-transform:uppercase; color:#707A6C; margin-bottom:5px; padding-left:14px;
        }
        .form-input {
            width:100%; padding:12px 14px; border-radius:12px; border:none; outline:none; 
            background:#f0f2f1; font-family:'Be Vietnam Pro',sans-serif;
            font-size:14px; color:#1c1c1c; transition:background .15s, box-shadow .15s;
        }
        .form-input:focus     { background:#e8f5ef; box-shadow:0 0 0 2px rgba(0,126,67,.2); }
        .form-input::placeholder { color:#b0b8bf; }
        .input-prefix-wrap    { position:relative; }
        .input-prefix {
            position:absolute; left:20px; top:50%; transform:translateY(-50%);
            font-weight:600; font-size:14px; color:#007E43; pointer-events:none;
        }
        .form-input.has-prefix { padding-left:38px; }
        .form-select {
            width:100%; padding:12px 14px; border-radius:12px; border:none; outline:none;
            background:#f0f2f1; font-family:'Be Vietnam Pro',sans-serif;
            font-size:14px; color:#1c1c1c; appearance:none; padding-right:36px;
            background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%236b7280' stroke-width='2'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E");
            background-repeat:no-repeat; background-position:right 12px center; background-size:16px;
            transition:box-shadow .15s;
        }
        .form-select:focus { box-shadow:0 0 0 2px rgba(0,126,67,.2); }

        /* ── Page header ── */
        .page-label {
            font-size:12px; font-weight:700; letter-spacing:.08em;
            text-transform:uppercase; color:var(--orange); margin-bottom:4px;
        }
        .page-title {
            font-family:'Manrope',sans-serif; font-size:clamp(1.8rem,4vw,2.5rem);
            font-weight:800; color:#1a1a1a; letter-spacing:-.02em; line-height:1.1;
        }
        .page-subtitle { font-size:13px; color:#6b7280; margin-top:6px; line-height:1.5; }

        @yield('styles')
    </style>
</head>
<body>
    <x-tenant.sidebar />

    <main class="lg:ml-56 min-h-screen p-4 lg:p-8">

        {{-- ── Mobile top bar: hamburger kiri, avatar kanan ── --}}
        <div class="flex items-center justify-between mb-5 lg:hidden">
            <button onclick="openSidebar()" class="hamburger-btn" aria-label="Buka menu">
                <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
            @isset($tenant)
                <div class="relative">
                    <button type="button" onclick="event.stopPropagation(); document.getElementById('mobileDropdownLogout').classList.toggle('hidden');" class="flex items-center focus:outline-none bg-transparent border-none p-0 cursor-pointer">
                        @if($tenant->foto)
                            <img src="{{ asset($tenant->foto) }}" alt="{{ $tenant->nama_tenant }}" class="w-8 h-8 rounded-full object-cover">
                        @else
                            <div class="w-8 h-8 rounded-full flex items-center justify-center text-white text-xs font-bold" style="background-color:var(--primary);">
                                {{ strtoupper(substr($tenant->nama_tenant, 0, 1)) }}
                            </div>
                        @endif
                    </button>
                    <div id="mobileDropdownLogout" class="hidden absolute right-0 mt-2 w-36 bg-white rounded-md shadow-xl py-1 border border-gray-200 z-[99999]">
                        <form method="POST" action="{{ route('logout') }}" class="m-0">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-red-50 hover:text-red-600 font-semibold bg-transparent border-none cursor-pointer">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            @endisset
        </div>

        <div class="hidden lg:block absolute top-5 right-5 z-[9999]">
            @isset($tenant)
                <div class="relative">
                    <button type="button" onclick="event.stopPropagation(); document.getElementById('desktopDropdownLogout').classList.toggle('hidden');" class="flex items-center focus:outline-none bg-transparent border-none p-0 cursor-pointer">
                        @if($tenant->foto)
                            <img src="{{ asset($tenant->foto) }}" alt="{{ $tenant->nama_tenant }}" class="w-10 h-10 rounded-full object-cover border border-gray-100 hover:opacity-90 transition-opacity">
                        @else
                            <div class="w-10 h-10 rounded-full flex items-center justify-center text-white text-sm font-bold hover:brightness-95 transition-all" style="background-color:var(--primary);">
                                {{ strtoupper(substr($tenant->nama_tenant, 0, 1)) }}
                            </div>
                        @endif
                    </button>
                    <div id="desktopDropdownLogout" class="hidden absolute right-0 mt-2 w-36 bg-white rounded-md shadow-xl py-1 border border-gray-200 z-[99999]">
                        <form method="POST" action="{{ route('logout') }}" class="m-0">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-red-50 hover:text-red-600 font-semibold bg-transparent border-none cursor-pointer">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            @endisset
        </div>

        {{-- Script penutup otomatis dropdown jika klik di luar --}}
        <script>
            window.addEventListener('click', function() {
                const mobileMenu = document.getElementById('mobileDropdownLogout');
                const desktopMenu = document.getElementById('desktopDropdownLogout');
                if (mobileMenu && !mobileMenu.classList.contains('hidden')) mobileMenu.classList.add('hidden');
                if (desktopMenu && !desktopMenu.classList.contains('hidden')) desktopMenu.classList.add('hidden');
            });
        </script>

        {{-- Alert modal (dipicu session('alert')) --}}
        @include('components.tenant.alert-modal')

        @yield('content')
    </main>

    @yield('modals')

    <script>
        /* setPeriode — shared untuk beranda */
        function setPeriode(val) {
            document.getElementById('periodeInput').value = val;
            document.querySelectorAll('.periode-btn').forEach(b => b.classList.remove('active'));
            document.getElementById('btn-' + val)?.classList.add('active');
            document.getElementById('periodeForm')?.submit();
        }
    </script>
    @yield('scripts')
</body>
</html>
