@php
    $navLinks = [
        ['label' => 'Home', 'route' => 'home'],
        ['label' => 'Marketplace', 'route' => 'marketplace'],
        ['label' => 'How It Works', 'route' => 'how-it-works'],
        ['label' => 'Testimonials', 'route' => 'testimonials'],
        ['label' => 'Contact Us', 'route' => 'contact'],
        ['label' => 'Affiliate Network', 'route' => 'guest.affiliate'],
    ];
@endphp

<nav id="navbar" class="fixed top-0 z-50 w-full transition-all duration-300">
    <div class="container flex items-center justify-between px-6 py-4 mx-auto">
        <!-- Logo -->
        <a href="{{ url('/') }}" class="flex items-center space-x-2 text-xl font-bold text-purple-700">
            <img src="https://musamin.com/company/logo/logo.png" alt="Logo" class="w-8 h-8">
            <span>{{ config('app.name') }}</span>
        </a>

        <!-- Desktop Menu -->
        <ul class="hidden space-x-6 lg:space-x-8 md:flex">
            @foreach ($navLinks as $link)
                <li>
                    <a href="{{ route($link['route']) }}"
                       class="nav-link {{ request()->routeIs($link['route']) ? 'active text-purple-600 font-semibold' : 'text-gray-700 hover:text-purple-600' }} transition-colors duration-200">
                        {{ $link['label'] }}
                    </a>
                </li>
            @endforeach
        </ul>

        <!-- Right side -->
        <div class="hidden space-x-3 md:flex">
            @auth
                <a href="{{ route('dashboard') }}" class="px-4 py-2 text-sm font-medium text-white transition-colors duration-200 bg-purple-600 rounded-lg hover:bg-purple-700">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-medium text-purple-600 transition-colors duration-200 border border-purple-600 rounded-lg hover:bg-purple-50">Login</a>
                <a href="{{ route('register') }}" class="px-4 py-2 text-sm font-medium text-white transition-colors duration-200 bg-purple-600 rounded-lg hover:bg-purple-700">Register</a>
            @endauth
        </div>

        <!-- Mobile Hamburger -->
        <button id="mobile-menu-toggle" class="md:hidden focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="text-gray-700 w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </div>
</nav>

<!-- Mobile Sidebar Menu -->
<div id="mobile-menu-overlay" class="fixed inset-0 z-40 hidden transition-opacity bg-black bg-opacity-50" onclick="closeSidebar()"></div>

<div id="mobile-sidebar" class="fixed inset-y-0 left-0 z-50 w-64 transition-transform duration-300 ease-in-out transform -translate-x-full bg-white shadow-lg">
    <div class="flex items-center justify-between px-6 py-4 border-b">
        <span class="text-lg font-bold text-purple-700">{{ config('app.name') }}</span>
        <button id="mobile-menu-close" class="focus:outline-none" onclick="closeSidebar()">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <div class="px-6 py-4 space-y-4">
        @foreach ($navLinks as $link)
            <a href="{{ route($link['route']) }}"
               class="block py-2 nav-link {{ request()->routeIs($link['route']) ? 'active text-purple-600 font-semibold' : 'text-gray-700 hover:text-purple-600' }} transition-colors duration-200"
               onclick="closeSidebar()">
                {{ $link['label'] }}
            </a>
        @endforeach

        <div class="pt-4 mt-4 border-t border-gray-200">
            @auth
                <a href="{{ route('dashboard') }}" class="block w-full px-4 py-2 text-sm font-medium text-center text-white transition-colors duration-200 bg-purple-600 rounded-lg hover:bg-purple-700" onclick="closeSidebar()">Dashboard</a>
            @else
                <div class="grid grid-cols-2 gap-3">
                    <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-medium text-center text-purple-600 transition-colors duration-200 border border-purple-600 rounded-lg hover:bg-purple-50" onclick="closeSidebar()">Login</a>
                    <a href="{{ route('register') }}" class="px-4 py-2 text-sm font-medium text-center text-white transition-colors duration-200 bg-purple-600 rounded-lg hover:bg-purple-700" onclick="closeSidebar()">Register</a>
                </div>
            @endauth
        </div>
    </div>
</div>

<!-- Scroll + Mobile Script -->
<script>
    const navbar = document.getElementById('navbar');
    const toggle = document.getElementById('mobile-menu-toggle');
    const closeBtn = document.getElementById('mobile-menu-close');
    const overlay = document.getElementById('mobile-menu-overlay');
    const sidebar = document.getElementById('mobile-sidebar');

    // Navbar shrink on scroll
    window.addEventListener('scroll', () => {
        if (window.scrollY > 50) {
            navbar.classList.add('bg-white', 'shadow-md', 'py-2');
        } else {
            navbar.classList.remove('bg-white', 'shadow-md', 'py-2');
        }
    });

    // Open sidebar
    toggle.addEventListener('click', () => {
        overlay.classList.remove('hidden');
        setTimeout(() => overlay.classList.add('opacity-100'), 10);
        sidebar.classList.remove('-translate-x-full');
        sidebar.classList.add('translate-x-0');
        document.body.style.overflow = 'hidden';
    });

    // Close sidebar
    function closeSidebar() {
        overlay.classList.add('hidden');
        overlay.classList.remove('opacity-100');
        sidebar.classList.add('-translate-x-full');
        sidebar.classList.remove('translate-x-0');
        document.body.style.overflow = 'auto';
    }

    closeBtn.addEventListener('click', closeSidebar);
    overlay.addEventListener('click', closeSidebar);

    // Close sidebar when clicking outside
    document.addEventListener('click', (event) => {
        const isClickInsideSidebar = sidebar.contains(event.target);
        const isClickOnToggle = toggle.contains(event.target);
        const isSidebarOpen = !sidebar.classList.contains('-translate-x-full');

        if (!isClickInsideSidebar && !isClickOnToggle && isSidebarOpen) {
            closeSidebar();
        }
    });

    // Close sidebar on escape key
    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            closeSidebar();
        }
    });
</script>
