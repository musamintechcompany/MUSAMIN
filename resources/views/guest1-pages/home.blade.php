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

    <!-- Stats Section - Adjusted with more spacing for the title -->
    <section id="stats" class="pt-24 pb-20 bg-gray-50"
             x-data="{
                counted: false,
                assets: 0,
                clients: 0,
                revenue: 0,
                animateCounters() {
                    if (this.counted) return;

                    const duration = 2000;
                    const steps = 60;
                    const interval = duration / steps;

                    // Animate assets counter
                    const assetsTarget = 12500;
                    const assetsIncrement = assetsTarget / steps;
                    let assetsCurrent = 0;

                    // Animate clients counter
                    const clientsTarget = 4200;
                    const clientsIncrement = clientsTarget / steps;
                    let clientsCurrent = 0;

                    // Animate revenue counter
                    const revenueTarget = 32.5;
                    const revenueIncrement = revenueTarget / steps;
                    let revenueCurrent = 0;

                    let step = 0;

                    const counterInterval = setInterval(() => {
                        step++;

                        // Update assets
                        assetsCurrent += assetsIncrement;
                        this.assets = Math.min(Math.floor(assetsCurrent), assetsTarget);

                        // Update clients
                        clientsCurrent += clientsIncrement;
                        this.clients = Math.min(Math.floor(clientsCurrent), clientsTarget);

                        // Update revenue
                        revenueCurrent += revenueIncrement;
                        this.revenue = Math.min(parseFloat(revenueCurrent.toFixed(1)), revenueTarget);

                        if (step >= steps) {
                            clearInterval(counterInterval);
                            this.assets = assetsTarget;
                            this.clients = clientsTarget;
                            this.revenue = revenueTarget;
                            this.counted = true;
                        }
                    }, interval);
                }
             }"
             x-intersect="animateCounters()">
        <div class="container px-6 mx-auto">
            <!-- Added a top spacer to push the title down further -->
            <div class="h-16"></div>
            <h2 class="mb-4 text-4xl font-bold text-center text-purple-900">Why Choose {{ config('app.name') }}?</h2>
            <p class="mb-16 text-lg text-center text-gray-600">Join thousands of satisfied customers who trust our platform</p>

            <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-4">
                <!-- Digital Assets Card -->
                <div class="p-6 bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border border-purple-100 text-center">
                    <h3 class="mb-2 text-5xl font-bold text-purple-600"><span x-text="assets.toLocaleString()">0</span>+</h3>
                    <p class="text-lg font-semibold text-gray-700">Digital Assets Available</p>
                    <p class="mt-2 text-sm text-gray-500">From e-commerce stores to SaaS applications</p>
                </div>

                <!-- Happy Clients Card -->
                <div class="p-6 bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border border-purple-100 text-center">
                    <h3 class="mb-2 text-5xl font-bold text-purple-600"><span x-text="clients.toLocaleString()">0</span>+</h3>
                    <p class="text-lg font-semibold text-gray-700">Happy Clients</p>
                    <p class="mt-2 text-sm text-gray-500">Satisfied customers worldwide</p>
                </div>

                <!-- Transactions Card -->
                <div class="p-6 bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border border-purple-100 text-center">
                    <h3 class="mb-2 text-5xl font-bold text-purple-600">$<span x-text="revenue.toLocaleString()">0</span>M+</h3>
                    <p class="text-lg font-semibold text-gray-700">In Transactions</p>
                    <p class="mt-2 text-sm text-gray-500">Secure and reliable transactions</p>
                </div>

                <!-- Support Card -->
                <div class="p-6 bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border border-purple-100 text-center">
                    <h3 class="mb-2 text-5xl font-bold text-purple-600">24/7</h3>
                    <p class="text-lg font-semibold text-gray-700">Support</p>
                    <p class="mt-2 text-sm text-gray-500">Dedicated customer service team</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Assets Preview -->
    <section class="py-20 bg-white">
        <div class="container px-6 mx-auto lg:px-12">
            <h2 class="mb-2 text-4xl font-bold text-center text-purple-900">Featured Digital Assets</h2>
            <p class="mb-10 text-lg text-center text-gray-600">Browse our curated selection of premium digital assets</p>

            <!-- Grid layout instead of horizontal scrolling -->
            <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-4">
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
                <div class="overflow-hidden transition bg-white rounded-lg shadow hover:shadow-xl hover:scale-105">
                    <div class="relative">
                        <img src="{{ $asset['image'] }}" alt="{{ $asset['name'] }}" class="object-cover w-full h-48">
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

            <div class="mt-12 text-center">
                <a href="{{ url('/marketplace') }}" class="px-8 py-4 text-lg font-semibold text-white bg-purple-600 rounded-lg shadow hover:bg-purple-700">See More Assets</a>
            </div>
        </div>
    </section>

    <!-- Big CTA Section -->
    <section class="py-24 text-white bg-gradient-to-br from-purple-600 to-indigo-600">
        <div class="container px-6 mx-auto text-center lg:px-12">
            <h2 class="mb-6 text-5xl font-bold">Ready to Find Your Perfect Digital Asset?</h2>
            <p class="mb-10 text-xl text-purple-200">Join thousands of entrepreneurs who launched their online presence instantly</p>
            <div class="flex flex-wrap justify-center gap-6">
                <a href="{{ url('/marketplace') }}" class="px-10 py-5 text-xl font-semibold text-purple-600 bg-white rounded-lg shadow-lg hover:bg-gray-100 transition-all duration-300 transform hover:-translate-y-1">Browse All Assets</a>
                <a href="{{ url('/contact') }}" class="px-10 py-5 text-xl font-semibold text-white border-2 border-white rounded-lg hover:bg-white hover:text-purple-600 transition-all duration-300">Contact Our Team</a>
            </div>
            <div class="mt-16 grid grid-cols-1 md:grid-cols-3 gap-8 text-left">
                <div class="bg-white bg-opacity-10 p-8 rounded-lg backdrop-blur-sm">
                    <div class="text-4xl mb-4 text-purple-200"><i class="fas fa-rocket"></i></div>
                    <h3 class="text-xl font-semibold mb-3">Instant Launch</h3>
                    <p class="text-purple-100">Get your business online immediately with our ready-to-use assets. No technical skills required.</p>
                </div>
                <div class="bg-white bg-opacity-10 p-8 rounded-lg backdrop-blur-sm">
                    <div class="text-4xl mb-4 text-purple-200"><i class="fas fa-shield-alt"></i></div>
                    <h3 class="text-xl font-semibold mb-3">Secure Transactions</h3>
                    <p class="text-purple-100">Our escrow system ensures safe and secure transactions for all parties with money-back guarantee.</p>
                </div>
                <div class="bg-white bg-opacity-10 p-8 rounded-lg backdrop-blur-sm">
                    <div class="text-4xl mb-4 text-purple-200"><i class="fas fa-headset"></i></div>
                    <h3 class="text-xl font-semibold mb-3">24/7 Support</h3>
                    <p class="text-purple-100">Our team is always available to help you with any questions or issues you might encounter.</p>
                </div>
            </div>
        </div>
    </section>

    <x-slot name="scripts">
        <script>
            // Smooth scrolling for anchor links
            document.addEventListener('DOMContentLoaded', function() {
                document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                    anchor.addEventListener('click', function (e) {
                        e.preventDefault();
                        const target = document.querySelector(this.getAttribute('href'));
                        if (target) {
                            target.scrollIntoView({
                                behavior: 'smooth'
                            });
                        }
                    });
                });
            });
        </script>
    </x-slot>
</x-guest1-layout>
