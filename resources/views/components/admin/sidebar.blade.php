{{-- resources/views/components/admin/sidebar.blade.php --}}

{{-- Overlay gelap di belakang sidebar saat mobile --}}
<div id="sidebarOverlay"
     class="fixed inset-0 bg-black/40 z-20 hidden lg:hidden"
     onclick="closeSidebar()">
</div>

<aside id="sidebarPanel"
       style="background:#F4F4EF; border-x:1px solid #e5e7eb; font-family:'Be Vietnam Pro',sans-serif;"
       class="fixed top-0 left-0 h-screen w-56 flex flex-col z-30 shadow-sm
              -translate-x-full lg:translate-x-0
              transition-transform duration-300 ease-in-out px-3 py-6 gap-6">

    {{-- Portal Admin badge --}}
    <div class="p-4 border-b border-gray-100 bg-[#FFFFFF] rounded-xl font-reguler font-[Manrope]">
        <p class="text-[12px] tracking-widest uppercase text-[#707A6C] mb-2.5">PORTAL ADMIN</p>
        <p class="text-[14px] leading-tight text-[#1A1C19]">{{ config('app.mall_name', 'Pasar Modern Sinpasa') }}</p>
        <p class="text-[14px] text-[#1A1C19]">{{ config('app.mall_location', 'Summarecon Bandung') }}</p>
    </div>

    {{-- Nav links --}}
    <nav class="flex-1 px-3 py-4 space-y-1">
        @php
            $links = [
                ['route' => 'admin.beranda', 'label' => 'Beranda',           'icon' => 'dashboard'],
                ['route' => 'admin.konten',  'label' => 'Manajemen Konten',  'icon' => 'content'],
            ];
        @endphp

        @foreach ($links as $link)
            @php $active = request()->routeIs($link['route']); @endphp

            <a href="{{ route($link['route']) }}"
               onclick="closeSidebar()"
               class="flex items-center gap-3 px-3 py-2.5 rounded-2xl text-[0.7rem]
                      transition-all duration-150
                      {{ $active ? 'text-white' : 'text-[#007E43]' }}"
               style="{{ $active ? 'background-color:#007E43;' : '' }}"
               @if(!$active)
                   onmouseenter="this.style.backgroundColor='#EAF7F1'; this.style.color='#007E43';"
                   onmouseleave="this.style.backgroundColor=''; this.style.color='';"
               @endif>

                @if ($link['icon'] === 'dashboard')
                    {{-- Grid/dashboard icon --}}
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M4 5a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM14 5a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zM4 15a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1v-4zM14 15a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z"/>
                    </svg>
                @else
                    {{-- Content/document icon --}}
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                    </svg>
                @endif

                {{ $link['label'] }}
            </a>
        @endforeach
    </nav>
    {{---Logout---}}
    <div class="px-3 pb-2">
        <form method="POST" action="{{route('logout')}}">
            @csrf
            <button type="submit"
                class="flex items-center gap-3 px-3 py-2.5 rounded-2xl text-[0.7rem] w-full text-[#007E43] transition-all duration-150"
                onmouseenter="this.style.backgroundColor='#FEE2E2'; this.style.color='#DC2626';"
                onmouseleave="this.style.backgroundColor=''; this.style.color='';">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
            </svg>
            Logout
            </button>
        </form>
    </div>
</aside>

<script>
    function openSidebar() {
        document.getElementById('sidebarPanel').classList.remove('-translate-x-full');
        document.getElementById('sidebarPanel').classList.add('translate-x-0');
        document.getElementById('sidebarOverlay').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
    function closeSidebar() {
        document.getElementById('sidebarPanel').classList.add('-translate-x-full');
        document.getElementById('sidebarPanel').classList.remove('translate-x-0');
        document.getElementById('sidebarOverlay').classList.add('hidden');
        document.body.style.overflow = '';
    }
</script>
