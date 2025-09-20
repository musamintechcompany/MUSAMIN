<x-guest1-layout>
    <x-slot name="title">{{ config('app.name') }} | WebMarket</x-slot>

    <!-- SEO Meta -->
    <x-slot name="meta">
        <meta name="description" content="Buy, rent, and sell premium digital assets instantly on {{ config('app.name') }}. Discover ready-to-use websites with no development time, just launch and grow.">
        <meta name="keywords" content="websites, digital assets, buy websites, rent websites, sell websites, digital marketplace, online business">
        <meta name="author" content="Musamin Team">
        <meta property="og:title" content="{{ config('app.name') }} - Premium Digital Asset Marketplace">
        <meta property="og:description" content="Discover premium ready-to-use digital assets. Launch your business instantly with {{ config('app.name') }}.">
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:image" content="https://images.unsplash.com/photo-1563986768609-322da13575f3?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1200&q=80">
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="{{ config('app.name') }} - Premium Digital Asset Marketplace">
        <meta name="twitter:description" content="Buy, rent, and sell premium digital assets instantly with {{ config('app.name') }}.">
        <meta name="twitter:image" content="https://images.unsplash.com/photo-1563986768609-322da13575f3?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1200&q=80">
    </x-slot>

    <!-- Hero Section -->
    <section class="relative flex items-center justify-center min-h-screen text-white bg-gradient-to-br from-purple-200 via-purple-300 to-purple-400">
        <div class="container grid items-center gap-12 px-6 mx-auto lg:px-12 lg:grid-cols-2">
            <div>
                <h1 class="mb-6 text-5xl font-extrabold leading-tight text-purple-900 lg:text-6xl">
                    Buy or Rent Premium Digital Assets Instantly
                </h1>
                <p class="mb-8 text-xl text-purple-800">
                    Discover ready-to-use digital assets for your business. No development time, just launch and grow!
                </p>
                <div class="flex flex-wrap gap-4">
                    <a href="{{ url('/marketplace') }}" class="px-6 py-3 text-lg font-semibold text-white bg-purple-600 rounded-lg shadow hover:bg-purple-700">Browse Assets</a>
                    <a href="{{ url('/how-it-works') }}" class="px-6 py-3 text-lg font-semibold text-purple-800 border border-purple-700 rounded-lg hover:bg-white hover:text-purple-600">Learn More</a>
                </div>
            </div>
            <div class="flex justify-center lg:order-last">
                <img src="https://images.unsplash.com/photo-1563986768609-322da13575f3?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80" alt="Digital Asset Marketplace" class="shadow-2xl rounded-xl lg:mt-0 -mb-24 lg:-mb-0">
            </div>
        </div>
        <a href="#stats" class="absolute text-purple-800 bottom-10 animate-bounce">
            <i class="text-3xl fas fa-chevron-down"></i>
        </a>
    </section>

    <!-- Stats Section -->
    <section id="stats" class="flex items-center justify-center min-h-screen bg-gray-50 pt-24 lg:pt-0">
        <div class="container px-6 mx-auto text-center lg:px-12">
            <div class="grid grid-cols-1 gap-8 md:grid-cols-4">
                <div>
                    <h2 class="text-5xl font-bold text-purple-600"><span class="counter" data-count="10000">0</span>+</h2>
                    <p class="mt-2 text-lg text-gray-600">Digital Assets Available</p>
                </div>
                <div>
                    <h2 class="text-5xl font-bold text-purple-600"><span class="counter" data-count="4000">0</span>+</h2>
                    <p class="mt-2 text-lg text-gray-600">Happy Clients</p>
                </div>
                <div>
                    <h2 class="text-5xl font-bold text-purple-600">$<span class="counter" data-count="30">0</span>M+</h2>
                    <p class="mt-2 text-lg text-gray-600">In Transactions</p>
                </div>
                <div>
                    <h2 class="text-5xl font-bold text-purple-600">24/7</h2>
                    <p class="mt-2 text-lg text-gray-600">Support</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Assets Preview -->
    <section class="py-16 bg-white">
        <div class="container px-6 mx-auto lg:px-12">
            <h2 class="mb-2 text-4xl font-bold text-center text-purple-900">Featured Digital Assets</h2>
            <p class="mb-10 text-lg text-center text-gray-600">Browse our curated selection of premium digital assets</p>

            <!-- Horizontal scrolling cards -->
            <div class="relative">
                <div id="scrolling-container" class="flex pb-6 overflow-x-auto scrollbar-hide scrolling-touch">
                    <div id="scrolling-content" class="flex space-x-6">
                        @foreach([
                            ['id' => 1, 'name' => 'E-Commerce Store', 'price' => 3500, 'image' => 'https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', 'category' => 'E-Commerce'],
                            ['id' => 2, 'name' => 'Blog Platform', 'price' => 2500, 'image' => 'https://images.unsplash.com/photo-1486312338219-ce68d2c6f44d?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', 'category' => 'Blog'],
                            ['id' => 3, 'name' => 'SaaS Application', 'price' => 6500, 'image' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', 'category' => 'SaaS'],
                            ['id' => 4, 'name' => 'Restaurant Website', 'price' => 2000, 'image' => 'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', 'category' => 'Food & Beverage'],
                            ['id' => 5, 'name' => 'Fitness Portal', 'price' => 3200, 'image' => 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', 'category' => 'Health & Fitness'],
                            ['id' => 6, 'name' => 'Real Estate Platform', 'price' => 4800, 'image' => 'https://images.unsplash.com/photo-1560518883-ce09059eeffa?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', 'category' => 'Real Estate'],
                            ['id' => 7, 'name' => 'Travel Blog', 'price' => 2900, 'image' => 'https://images.unsplash.com/photo-1488646953014-85cb44e25828?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', 'category' => 'Travel'],
                            ['id' => 8, 'name' => 'Cryptocurrency Exchange', 'price' => 8500, 'image' => 'https://images.unsplash.com/photo-1620336655055-bd87ca8f1370?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', 'category' => 'Crypto']
                        ] as $asset)
                        <div class="flex-shrink-0 w-64 overflow-hidden transition bg-white rounded-lg shadow hover:shadow-xl hover:scale-105">
                            <div class="relative">
                                <img src="{{ $asset['image'] }}" alt="{{ $asset['name'] }}" class="object-cover w-full h-40">
                                <span class="absolute px-3 py-1 text-sm font-semibold text-white bg-green-500 rounded top-2 right-2">For Sale</span>
                                <span class="absolute px-2 py-1 text-xs font-semibold text-white bg-purple-500 rounded top-2 left-2">{{ $asset['category'] }}</span>
                            </div>
                            <div class="p-4">
                                <h5 class="mb-2 text-lg font-bold truncate">{{ $asset['name'] }}</h5>
                                <p class="mb-4 text-sm text-gray-600 line-clamp-2">Fully functional digital asset with traffic and revenue potential.</p>
                                <div class="flex items-center justify-between">
                                    <span class="text-lg font-bold text-purple-600">${{ number_format($asset['price']) }}</span>
                                    <a href="{{ url('/marketplace') }}" class="px-3 py-1 text-sm font-semibold text-purple-600 border border-purple-600 rounded hover:bg-purple-600 hover:text-white">Details</a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="mt-10 text-center">
                <a href="{{ url('/marketplace') }}" class="px-8 py-4 text-lg font-semibold text-white bg-purple-600 rounded-lg shadow hover:bg-purple-700">See More Assets</a>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="py-16 bg-gradient-to-br from-purple-50 to-indigo-50">
        <div class="container px-6 mx-auto lg:px-12">
            <h2 class="mb-2 text-4xl font-bold text-center text-purple-900">Popular Categories</h2>
            <p class="mb-12 text-lg text-center text-gray-600">Find digital assets in your industry or niche</p>

            <div class="grid grid-cols-2 gap-6 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6">
                @foreach([
                    ['name' => 'E-Commerce', 'icon' => 'fas fa-shopping-cart', 'count' => '1245', 'color' => 'bg-purple-100'],
                    ['name' => 'Blog', 'icon' => 'fas fa-blog', 'count' => '987', 'color' => 'bg-indigo-100'],
                    ['name' => 'SaaS', 'icon' => 'fas fa-cloud', 'count' => '876', 'color' => 'bg-purple-100'],
                    ['name' => 'Education', 'icon' => 'fas fa-graduation-cap', 'count' => '754', 'color' => 'bg-indigo-100'],
                    ['name' => 'Health', 'icon' => 'fas fa-heartbeat', 'count' => '632', 'color' => 'bg-purple-100'],
                    ['name' => 'Real Estate', 'icon' => 'fas fa-home', 'count' => '521', 'color' => 'bg-indigo-100'],
                    ['name' => 'Food', 'icon' => 'fas fa-utensils', 'count' => '489', 'color' => 'bg-purple-100'],
                    ['name' => 'Travel', 'icon' => 'fas fa-plane', 'count' => '376', 'color' => 'bg-indigo-100'],
                    ['name' => 'Finance', 'icon' => 'fas fa-dollar-sign', 'count' => '298', 'color' => 'bg-purple-100'],
                    ['name' => 'Entertainment', 'icon' => 'fas fa-film', 'count' => '265', 'color' => 'bg-indigo-100'],
                    ['name' => 'Sports', 'icon' => 'fas fa-running', 'count' => '187', 'color' => 'bg-purple-100'],
                    ['name' => 'Technology', 'icon' => 'fas fa-laptop-code', 'count' => '154', 'color' => 'bg-indigo-100']
                ] as $category)
                <div class="p-4 text-center transition transform bg-white rounded-lg shadow-md hover:shadow-xl hover:-translate-y-2">
                    <div class="inline-flex items-center justify-center w-16 h-16 mx-auto mb-3 rounded-full {{ $category['color'] }}">
                        <i class="{{ $category['icon'] }} text-xl text-purple-600"></i>
                    </div>
                    <h3 class="font-semibold text-purple-900">{{ $category['name'] }}</h3>
                    <p class="text-sm text-gray-500"><span class="font-mono text-purple-600 category-counter" data-count="{{ $category['count'] }}">0</span> assets</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 text-white bg-gradient-to-br from-purple-600 to-indigo-600">
        <div class="container px-6 mx-auto text-center lg:px-12">
            <h2 class="mb-4 text-4xl font-bold">Ready to Find Your Perfect Digital Asset?</h2>
            <p class="mb-8 text-lg text-purple-200">Join thousands of entrepreneurs who launched their online presence instantly</p>
            <div class="flex flex-wrap justify-center gap-6">
                <a href="{{ url('/marketplace') }}" class="px-8 py-4 text-lg font-semibold text-purple-600 bg-white rounded-lg shadow hover:bg-gray-100">Browse Assets</a>
                <a href="{{ url('/contact') }}" class="px-8 py-4 text-lg font-semibold text-white border border-white rounded-lg hover:bg-white hover:text-purple-600">Contact Us</a>
            </div>
        </div>
    </section>

    <x-slot name="scripts">
        <script>
            // Smooth scrolling for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    document.querySelector(this.getAttribute('href')).scrollIntoView({
                        behavior: 'smooth'
                    });
                });
            });

            // Counter animation for stats
            function animateCounters() {
                const counters = document.querySelectorAll('.counter');
                const speed = 200; // The lower the slower

                counters.forEach(counter => {
                    const target = +counter.getAttribute('data-count');
                    let count = 0;

                    // For million+ counter
                    if (counter.parentElement.textContent.includes('$')) {
                        const updateCount = () => {
                            const increment = target / speed;

                            if (count < target) {
                                count += increment;
                                counter.innerText = Math.ceil(count);
                                setTimeout(updateCount, 15);
                            } else {
                                counter.innerText = target;
                            }
                        };

                        updateCount();
                    } else {
                        const updateCount = () => {
                            const increment = target / speed;

                            if (count < target) {
                                count += increment;
                                counter.innerText = Math.ceil(count);
                                setTimeout(updateCount, 15);
                            } else {
                                counter.innerText = target;
                            }
                        };

                        updateCount();
                    }
                });
            }

            // Category counter animation
            function animateCategoryCounters() {
                const counters = document.querySelectorAll('.category-counter');
                const speed = 200; // The lower the slower

                counters.forEach(counter => {
                    const target = +counter.getAttribute('data-count');
                    let count = 0;

                    const updateCount = () => {
                        const increment = target / speed;

                        if (count < target) {
                            count += increment;
                            counter.innerText = Math.ceil(count);
                            setTimeout(updateCount, 15);
                        } else {
                            counter.innerText = target;
                        }
                    };

                    updateCount();
                });
            }

            // Auto-scroll for featured assets
            function setupAutoScroll() {
                const container = document.getElementById('scrolling-container');
                const content = document.getElementById('scrolling-content');
                const items = content.children;
                const itemWidth = items[0].offsetWidth + 24; // width + gap

                // Clone items for seamless looping
                for (let i = 0; i < items.length; i++) {
                    const clone = items[i].cloneNode(true);
                    content.appendChild(clone);
                }

                let scrollPosition = 0;
                let isPaused = false;
                let animationFrameId;

                function autoScroll() {
                    if (!isPaused) {
                        scrollPosition += 0.5; // Scroll speed

                        // Reset to beginning when reaching the original content width
                        if (scrollPosition >= itemWidth * items.length) {
                            scrollPosition = 0;
                        }

                        container.scrollLeft = scrollPosition;
                    }

                    animationFrameId = requestAnimationFrame(autoScroll);
                }

                // Pause on hover
                container.addEventListener('mouseenter', () => {
                    isPaused = true;
                });

                container.addEventListener('mouseleave', () => {
                    isPaused = false;
                });

                // Touch events for mobile
                container.addEventListener('touchstart', () => {
                    isPaused = true;
                });

                container.addEventListener('touchend', () => {
                    // Resume after a short delay
                    setTimeout(() => { isPaused = false; }, 1000);
                });

                // Start auto-scroll
                autoScroll();

                // Cleanup function
                return () => {
                    cancelAnimationFrame(animationFrameId);
                };
            }

            // Initialize animations when page loads
            document.addEventListener('DOMContentLoaded', function() {
                // Use Intersection Observer to trigger animations when in viewport
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            animateCounters();
                            animateCategoryCounters();
                            setupAutoScroll();
                            observer.unobserve(entry.target);
                        }
                    });
                }, { threshold: 0.5 });

                // Observe stats section
                const statsSection = document.getElementById('stats');
                if (statsSection) {
                    observer.observe(statsSection);
                }

                // Observe categories section
                const categoriesSection = document.querySelector('.bg-gradient-to-br');
                if (categoriesSection) {
                    observer.observe(categoriesSection);
                }

                // Also trigger animations if elements are already in view
                if (isElementInViewport(document.getElementById('stats'))) {
                    animateCounters();
                }

                if (isElementInViewport(document.querySelector('.bg-gradient-to-br'))) {
                    animateCategoryCounters();
                }

                // Setup auto-scroll regardless of viewport
                setupAutoScroll();
            });

            // Helper function to check if element is in viewport
            function isElementInViewport(el) {
                if (!el) return false;
                const rect = el.getBoundingClientRect();
                return (
                    rect.top >= 0 &&
                    rect.left >= 0 &&
                    rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
                    rect.right <= (window.innerWidth || document.documentElement.clientWidth)
                );
            }
        </script>
        <style>
            /* Custom scrollbar hiding for horizontal scrolling */
            .scrollbar-hide {
                -ms-overflow-style: none;
                scrollbar-width: none;
            }
            .scrollbar-hide::-webkit-scrollbar {
                display: none;
            }

            /* Line clamp utility for text truncation */
            .line-clamp-2 {
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
                overflow: hidden;
            }

            /* Smooth scrolling for the container */
            .scrolling-touch {
                scroll-behavior: smooth;
            }
        </style>
    </x-slot>
</x-guest1-layout>
