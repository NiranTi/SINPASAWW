{{-- resources/views/layouts/admin.blade.php --}}
<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Portal Admin')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* ── Design tokens (identik dengan tenant) ─────────── */
        :root {
            --primary:      #007E43;
            --primary-soft: #EAF7F1;
            --danger:       #BA1A1A;
            --danger-soft:  #FFDAD6;
            --orange:       #925800;
            --orange-soft:  #FBDDB0;
        }

        body { font-family:'Be Vietnam Pro',sans-serif; background-color:#FAFAF5; color:#1a1a1a; }
        .font-manrope { font-family:'Manrope',sans-serif; }
        ::-webkit-scrollbar { width:4px; }
        ::-webkit-scrollbar-track { background:transparent; }
        ::-webkit-scrollbar-thumb { background:#d1d5db; border-radius:2px; }

        /* ── Cards ── */
        .stat-card    { background:#F4F4EF; border-radius:16px; padding:1.5rem; }
        .stat-card.danger-card { background-color:var(--danger-soft); }
        .section-card { background:#F4F4EF; border-radius:16px; }
        .form-card    { background:#fff; border-radius:16px; padding:1.5rem; }

        /* ── Buttons ── */
        .btn-outline {
            display:inline-flex; align-items:center; justify-content:center; gap:6px;
            background:#fff; color:#374151; padding:7px 16px; border-radius:999px;
            font-size:13px; font-weight:500; cursor:pointer; text-decoration:none;
            transition:background .15s, color .15s; white-space:nowrap; border:none;
        }
        .btn-outline:hover  { background:#E8E8E3; color:var(--primary); }
        .btn-outline:active { background:var(--primary); color:#fff; }

        .btn-primary {
            display:inline-flex; align-items:center; justify-content:center; gap:6px;
            background-color:var(--primary); color:#fff;
            border-radius:999px; font-size:14px; font-weight:500; border:none;
            cursor:pointer; text-decoration:none; transition:background-color .15s;
            white-space:nowrap; letter-spacing:.3px;
        }
        .btn-primary:hover { background-color:#009750; }

        /* ── Form elements ── */
        .form-group   { margin-bottom:1rem; }
        .form-label   { display:block; padding-left:12px; font-size:12px; font-weight:200; letter-spacing:.07em; text-transform:uppercase; color:#707A6C; margin-bottom:5px; }
        .form-input   { width:100%; padding:12px 14px; border-radius:12px; border:none; outline:none; background:#f0f2f1; font-family:'Be Vietnam Pro',sans-serif; font-size:14px; color:#1c1c1c; transition:background .15s, box-shadow .15s; }
        .form-input:focus { background:#e8f5ef; box-shadow:0 0 0 2px rgba(0,126,67,.2); }
        .form-input::placeholder { color:#b0b8bf; }
        .form-select {
            width:100%; padding:12px 14px; border-radius:12px; border:none; outline:none;
            background:#f0f2f1 url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%236b7280' stroke-width='2'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E") no-repeat right 12px center/16px;
            font-family:'Be Vietnam Pro',sans-serif; font-size:14px; color:#1c1c1c; appearance:none; padding-right:36px;
            transition:box-shadow .15s;
        }
        .form-select:focus { box-shadow:0 0 0 2px rgba(0,126,67,.2); }
        .form-textarea { resize:vertical; min-height:80px; }

        /* ── Tab buttons (Konten Aktif / Nonaktif) ── */
        .tab-underline-btn {
            padding:8px 4px; font-size:14px; font-weight:500; cursor:pointer;
            border:none; background:transparent; color:#6b7280;
            border-bottom:2px solid transparent; transition:all .15s;
        }
        .tab-underline-btn.active { color:var(--primary); border-bottom-color:var(--primary); }

        /* ── Page labels ── */
        .page-label   { font-size:12px; font-weight:500; letter-spacing:.08em; text-transform:uppercase; color:var(--orange); margin-bottom:4px; }
        .page-title   { font-family:'Manrope',sans-serif; font-size:clamp(1.6rem,4vw,2.5rem); font-weight:700; color:black; letter-spacing:-.02em; line-height:1.1; }
        .page-subtitle{ font-size:13px; color:black; margin-top:6px; }

        /* ── Hamburger ── */
        .hamburger-btn {
            display:flex; align-items:center; justify-content:center;
            width:2rem; height:2rem; flex-shrink:0;
            border-radius:999px; cursor:pointer; background:transparent; transition:background .15s;
        }
        .hamburger-btn:hover  { background:var(--primary-soft); }
        .hamburger-btn:active { background:var(--primary); }
        .hamburger-btn:active svg { color:#fff !important; }

        /* ── Bar chart ── */
        .bar-wrap  { display:flex; align-items:flex-end; gap:5px; height:140px; }
        .bar-col   { display:flex; flex-direction:column; align-items:center; flex:1; gap:4px; height:100%; }
        .bar       { width:100%; border-radius:5px 5px 0 0; transition:opacity .15s; }
        .bar:hover { opacity:.75; }
        .bar-label { font-size:9px; color:#9ca3af; white-space:nowrap; }

        /* ── Blok badge (orange pill) ── */
        .blok-badge {
            display:inline-block; padding:2px 8px; border-radius:999px;
            font-size:11px; font-weight:600;
            background-color:var(--orange-soft); color:var(--orange);
        }

        @yield('styles')
    </style>
</head>
<body>
    <x-admin.sidebar />

    <main class="lg:ml-56 min-h-screen p-4 lg:p-8">

        {{-- Mobile top bar ── --}}
        <div class="flex items-center justify-between mb-5 lg:hidden">
            <button onclick="openSidebar()" class="hamburger-btn" aria-label="Buka menu">
                <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
            <span class="font-manrope font-bold text-sm text-gray-800">Portal Admin</span>
        </div>

        {{-- Alert modal ── --}}
        @include('components.tenant.alert-modal')

        @yield('content')
    </main>

    @yield('modals')

    @yield('scripts')
</body>
</html>
