<x-guest1-layout>
    <x-slot name="title">{{ config('app.name') }} | Market Place</x-slot>

    <!-- Listings Section -->
    <section class="min-h-screen py-12 bg-gray-50">
        <div class="container px-4 mx-auto max-w-7xl">
            <h2 class="mb-4 text-3xl font-bold text-gray-800 md:text-4xl">Website Marketplace</h2>
            <p class="mb-8 text-lg text-gray-600">Browse our selection of premium websites available for purchase or rent</p>

            <div class="flex flex-col lg:flex-row">
                <!-- Filter Options -->
                <div class="w-full mb-8 lg:w-1/4 lg:mb-0 lg:pr-6">
                    <div class="sticky p-6 bg-white rounded-lg shadow-lg top-6">
                        <h5 class="mb-6 text-xl font-bold text-gray-800">Filter Options</h5>
                        <div class="mb-6">
                            <label class="block mb-2 font-medium text-gray-700">Category</label>
                            <select class="w-full px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                                <option selected>All Categories</option>
                                <option>E-commerce</option>
                                <option>Blog</option>
                                <option>Portfolio</option>
                                <option>SaaS</option>
                                <option>News</option>
                            </select>
                        </div>
                        <div class="mb-6">
                            <label class="block mb-2 font-medium text-gray-700">Listing Type</label>
                            <select class="w-full px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                                <option selected>All Types</option>
                                <option>For Sale</option>
                                <option>For Rent</option>
                            </select>
                        </div>
                        <div class="mb-6">
                            <label class="block mb-2 font-medium text-gray-700">Price Range</label>
                            <input type="range" class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer" min="0" max="10000" step="500">
                            <div class="flex justify-between mt-2 text-sm text-gray-600">
                                <span>$0</span>
                                <span>$10,000+</span>
                            </div>
                        </div>
                        <button class="w-full px-4 py-2 font-medium text-white bg-purple-600 rounded-lg hover:bg-purple-700 focus:ring-4 focus:ring-purple-300">Apply Filters</button>
                    </div>
                </div>

                <!-- Website Listings -->
                <div class="w-full lg:w-3/4">
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                        @foreach(range(1, 9) as $listing)
                        <div class="flex flex-col overflow-hidden transition-shadow duration-300 bg-white rounded-lg shadow-md hover:shadow-lg">
                            <div class="relative">
                                <img src="https://via.placeholder.com/400x250" class="object-cover w-full h-48" alt="Website Preview">
                                <span class="absolute top-2 right-2 px-3 py-1 text-xs font-medium text-white rounded-full {{ $listing % 2 ? 'bg-green-500' : 'bg-purple-500' }}">
                                    {{ $listing % 2 ? 'For Sale' : 'For Rent' }}
                                </span>
                            </div>
                            <div class="flex flex-col flex-grow p-4">
                                <h5 class="mb-2 text-lg font-bold text-gray-800">Website #{{ $listing }}</h5>
                                <p class="mb-4 text-gray-600">Premium website with {{ rand(100, 5000) }} monthly visitors and revenue potential.</p>
                                <div class="flex items-center justify-between mt-auto">
                                    <span class="text-lg font-bold text-purple-600">
                                        @if($listing % 2)
                                        ${{ number_format(rand(1000, 10000)) }}
                                        @else
                                        ${{ number_format(rand(100, 500)) }}/mo
                                        @endif
                                    </span>
                                    <a href="#" class="px-3 py-1 text-sm font-medium text-purple-600 transition-colors duration-200 border border-purple-600 rounded-lg hover:bg-purple-600 hover:text-white">View Details</a>
                                </div>
                            </div>
                            <div class="px-4 py-3 bg-gray-50">
                                <div class="flex justify-between text-xs text-gray-500">
                                    <span>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="inline-block w-4 h-4 mr-1 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                        </svg>
                                        {{ ['E-commerce', 'Blog', 'Portfolio'][$listing % 3] }}
                                    </span>
                                    <span>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="inline-block w-4 h-4 mr-1 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                        </svg>
                                        {{ rand(100, 5000) }} visitors/mo
                                    </span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <nav class="flex justify-center mt-8">
                        <ul class="flex items-center space-x-2">
                            <li>
                                <a href="#" class="flex items-center justify-center px-3 py-2 text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                    </svg>
                                    <span class="ml-1">Previous</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="flex items-center justify-center w-10 h-10 font-medium text-white bg-purple-600 rounded-lg">1</a>
                            </li>
                            <li>
                                <a href="#" class="flex items-center justify-center w-10 h-10 font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-100">2</a>
                            </li>
                            <li>
                                <a href="#" class="flex items-center justify-center w-10 h-10 font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-100">3</a>
                            </li>
                            <li>
                                <a href="#" class="flex items-center justify-center px-3 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-100">
                                    <span class="mr-1">Next</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </section>
</x-guest1-layout>
