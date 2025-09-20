<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? 'Admin Panel' }} - {{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <!-- Scripts & Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        

        @livewireStyles
        {{ $styles ?? '' }}
        @stack('styles')

        <!-- Theme Application -->
        <script>
            @auth('admin')
                // Apply admin theme on page load
                const theme = '{{ auth("admin")->user()->theme ?? "light" }}';
                
                if (theme === 'dark') {
                    document.documentElement.classList.add('dark');
                }
            @endauth
        </script>
        

    </head>
    <body class="font-sans antialiased overflow-x-hidden">
        @if($showNavigation ?? true)
            <div class="flex min-h-screen bg-gray-100 dark:bg-gray-900 overflow-x-hidden">
                <!-- Admin Sidebar -->
                @include('components.management.portal.admin.sidebar')

                <!-- Content Wrapper -->
                <div class="flex flex-col flex-1 w-full min-h-screen transition-all duration-300 ease-in-out md:ml-[70px] md:[.sidebar:not(.collapsed)_~_&]:ml-[250px] overflow-x-hidden">
                    <!-- Admin Top Navigation Menu -->
                    @include('components.management.portal.admin.navigation-menu')

                    <!-- Page Heading -->
                    @isset($header)
                        <header class="bg-white shadow dark:bg-gray-800">
                            <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
                                {{ $header }}
                            </div>
                        </header>
                    @endisset

                    <!-- Page Content -->
                    <main class="overflow-x-hidden">
                        {{ $slot }}
                    </main>
                </div>
            </div>

            <!-- Admin Mobile Bottom Nav -->
            @include('components.management.portal.admin.bottom-nav')
        @else
            <main>
                {{ $slot }}
            </main>
        @endif

        @stack('modals')
        @livewireScripts

        <!-- Theme Functions -->
        <script>
            function getCurrentTheme() {
                return document.documentElement.classList.contains('dark') ? 'dark' : 'light';
            }
            
            function applyTheme(theme) {
                if (theme === 'dark') {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
            }
            
            // Sync with localStorage
            localStorage.setItem('admin-theme', getCurrentTheme());

            // Listen for theme changes
            document.addEventListener('adminThemeChanged', function(event) {
                applyTheme(event.detail.theme);
                localStorage.setItem('admin-theme', event.detail.theme);
            });
        </script>
        @stack('scripts')
    </body>
</html>
