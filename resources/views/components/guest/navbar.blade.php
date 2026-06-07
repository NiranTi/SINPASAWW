{{-- resources/views/components/guest/navbar.blade.php --}}
<header class="bg-white shadow-sm sticky top-0 z-50"
        style="box-shadow:0 2px 10px rgba(0,0,0,.06);">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">

            {{-- Logo --}}
            <a href="{{ route('guest.index') }}" class="shrink-0">
                <img src="{{ asset('images/LOGO_PASAR.svg') }}"
                     alt="Pasar Modern Sinpasa"
                     class="h-9 w-auto"
                     onerror="this.onerror=null;this.style.display='none';this.nextElementSibling.style.display='block';">
                <span class="hidden font-manrope font-black text-lg text-[#007E43]"
                      style="font-family:'Manrope',sans-serif;">Sinpasa</span>
            </a>

            {{-- Desktop nav ─ hidden on mobile --}}
            <nav class="hidden lg:flex items-center gap-8 text-sm font-reguler text-[#121212] uppercase">
                @php
                    $current = request()->routeIs('guest.index') ? 'index' : (request()->routeIs('guest.denah') ? 'denah' : '');
                @endphp

                @if ($current === 'index')
                    {{-- On homepage: smooth scroll anchors --}}
                    <a href="#hero"      class="nav-link {{ $current==='index' ? 'active' : '' }}" data-section="beranda">Beranda</a>
                    <a href="#fasilitas" class="nav-link" data-section="fasilitas">Fasilitas</a>
                    <a href="{{ route('guest.denah') }}" class="nav-link" data-section="denah">Denah</a>
                    <a href="#testimoni" class="nav-link" data-section="testimoni">Testimoni</a>
                    <a href="#footer"    class="nav-link" data-section="footer">Tentang Kami</a>
                @elseif ($current === 'denah')
                    <a href="{{ route('guest.index') }}"              class="nav-link">Beranda</a>
                    <a href="{{ route('guest.index') }}#fasilitas"    class="nav-link">Fasilitas</a>
                    <a href="{{ route('guest.denah') }}"              class="nav-link active">Denah</a>
                    <a href="{{ route('guest.index') }}#testimoni"    class="nav-link">Testimoni</a>
                    <a href="{{ route('guest.index') }}#footer"       class="nav-link">Tentang Kami</a>
                @else
                    <a href="{{ route('guest.index') }}"              class="nav-link">Beranda</a>
                    <a href="{{ route('guest.index') }}#fasilitas"    class="nav-link">Fasilitas</a>
                    <a href="{{ route('guest.denah') }}"              class="nav-link">Denah</a>
                    <a href="{{ route('guest.index') }}#testimoni"    class="nav-link">Testimoni</a>
                    <a href="{{ route('guest.index') }}#footer"       class="nav-link">Tentang Kami</a>
                @endif
            </nav>

            {{-- Portal login link (subtle, top right) --}}
            <div class="hidden lg:flex items-center gap-3">
                <a href="{{ route('login') }}"
                   class="text-xs text-[#40493D] hover:text-[#007E43] transition-colors font-reguler">
                    Portal Login →
                </a>
            </div>

            {{-- Mobile: hamburger --}}
            <button id="navHamburger"
                    class="lg:hidden flex items-center justify-center w-9 h-9 rounded-xl hover:bg-gray-100 transition-colors"
                    aria-label="Buka menu">
                <svg id="iconOpen"  class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
                <svg id="iconClose" class="w-5 h-5 text-gray-700 hidden" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>

    {{-- Mobile menu panel --}}
    <div id="mobileMenu"
         class="hidden lg:hidden border-t border-gray-100 bg-white px-4 py-3 space-y-1">
        <a href="{{ route('guest.index') }}" class="block px-3 py-2.5 rounded-xl text-sm text-[#121212] hover:bg-green-50 hover:text-[#007E43] transition-colors uppercase">Beranda</a>
        <a href="{{ route('guest.index') }}#fasilitas" class="block px-3 py-2.5 rounded-xl text-sm text-[#121212] hover:bg-green-50 hover:text-[#007E43] transition-colors uppercase">Fasilitas</a>
        <a href="{{ route('guest.denah') }}" class="block px-3 py-2.5 rounded-xl text-sm text-[#121212] hover:bg-green-50 hover:text-[#007E43] transition-colors uppercase">Denah</a>
        <a href="{{ route('guest.index') }}#testimoni" class="block px-3 py-2.5 rounded-xl text-sm text-[#121212] hover:bg-green-50 hover:text-[#007E43] transition-colors uppercase">Testimoni</a>
        <a href="{{ route('guest.index') }}#footer" class="block px-3 py-2.5 rounded-xl text-sm text-[#121212] hover:bg-green-50 hover:text-[#007E43] transition-colors uppercase">Tentang Kami</a>
        <div class="pt-2 border-t border-gray-100">
            <a href="{{ route('login') }}" class="block px-3 py-2.5 rounded-xl text-sm text-[#40493D] hover:text-[#007E43]">Portal Login →</a>
        </div>
    </div>
</header>

<script>
(function() {
    const btn       = document.getElementById('navHamburger');
    const menu      = document.getElementById('mobileMenu');
    const iconOpen  = document.getElementById('iconOpen');
    const iconClose = document.getElementById('iconClose');
    if (!btn) return;

    btn.addEventListener('click', () => {
        const open = menu.classList.toggle('hidden') === false;
        iconOpen.classList.toggle('hidden',  open);
        iconClose.classList.toggle('hidden', !open);
    });

    /* Close menu when a mobile link is clicked */
    menu.querySelectorAll('a').forEach(a => {
        a.addEventListener('click', () => {
            menu.classList.add('hidden');
            iconOpen.classList.remove('hidden');
            iconClose.classList.add('hidden');
        });
    });

    /* Scroll-spy: only on homepage */
    @if(request()->routeIs('guest.index'))
    if (window.innerWidth >= 1024) {
        const navLinks = document.querySelectorAll('nav a.nav-link');
        const sections = document.querySelectorAll('section[id]');
        let clicking   = false;

        navLinks.forEach(l => l.addEventListener('click', () => {
            clicking = true;
            navLinks.forEach(x => x.classList.remove('active'));
            l.classList.add('active');
            setTimeout(() => { clicking = false; }, 600);
        }));

        window.addEventListener('scroll', () => {
            if (clicking) return;
            let cur = 'beranda';
            sections.forEach(s => {
                if (window.scrollY >= s.offsetTop - 120) cur = s.id;
            });
            navLinks.forEach(l => {
                l.classList.toggle('active', l.dataset.section === cur);
            });
        });
    }
    @endif
})();
</script>
