{{-- resources/views/layouts/guest.blade.php --}}
<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Pasar Modern Sinpasa')</title>

    {{-- Fonts — sama dengan static site asli --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700&family=Manrope:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* ── Design tokens dari static site asli ────────── */
        :root {
            --green-light:         #E6F6EE;
            --green-normal:        #00A859;
            --green-normal-hover:  #009750;
            --green-dark:          #007E43;
            --green-dark-hover:    #006535;
            --green-darker:        #003B1F;
            --yellow-dark:         #B66E00;
            --yellow-soft:         #FBDDB0;
        }

        body {
            font-family: 'Be Vietnam Pro', sans-serif;
            background: #FAFAF5;
            color: #0c0c0c;
            line-height: 1.5;
            letter-spacing: .3px;
            padding:5px;
        }

        /* ── Scroll offset untuk section anchor ── */
        section { scroll-margin-top: 5rem; }

        /* ── Nav active underline (dari styles.css asli) ── */
        nav a { text-decoration:none; transition:.3s; position:relative; }
        nav a::after {
            content:""; position:absolute; left:0; bottom:-4px;
            width:0; height:2px; background:var(--green-normal-hover); transition:.3s;
        }
        nav a.active { color:var(--green-normal-hover); font-weight:600; }
        nav a.active::after { width:100%; }
        nav a:hover::after { width:100%; }
        nav a:hover { color:var(--green-dark); }

        /* ── Btn primary ── */
        .btn-primary-guest {
            display:inline-flex; align-items:center; gap:8px;
            background:var(--green-dark); color:#fff;
            padding:12px 28px; border-radius:999px;
            font-weight:600; font-size:14px; text-decoration:none;
            transition:background .2s; border:none; cursor:pointer;
        }
        .btn-primary-guest:hover { background:var(--green-dark-hover); }

        /* ── Kategori badge ── */
        .kategori-pill {
            display:inline-block; padding:3px 10px; border-radius:999px;
            font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:.06em;
            background:var(--yellow-soft); color:var(--yellow-dark);
        }

        /* ── Hero overlay text ── */
        .hero-overlay {
            background:linear-gradient(to right, rgba(0,59,31,.85) 0%, rgba(0,59,31,.3) 60%, transparent 100%);
        }
    </style>

    @yield('styles')
</head>
<body>

{{-- Navbar component --}}
<x-guest.navbar />

{{-- Page content --}}
<main>
    @yield('content')
</main>

{{-- Footer component --}}
<x-guest.footer />

@yield('scripts')
</body>
</html>
