<x-app-layout>
    <div class="py-12">
        <div class="mx-auto max-w-6xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center py-2 mb-8">
                        <button onclick="window.history.back()" class="mr-4 text-gray-500 hover:text-gray-700">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M15 18L9 12L15 6" stroke="currentColor" stroke-width="2"/>
                            </svg>
                        </button>
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Help Center</h1>
                    </div>

                    <!-- Search -->
                    <div class="mb-8">
                        <form action="{{ route('help.search') }}" method="GET" class="max-w-md mx-auto">
                            <div class="relative">
                                <input type="text" name="q" placeholder="Search help articles..." 
                                       class="w-full px-4 py-3 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                <svg class="absolute left-3 top-3.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                        </form>
                    </div>

                    <!-- Categories -->
                    <div class="mb-12">
                        <h2 class="text-xl font-semibold mb-6 text-gray-900 dark:text-white">Browse by Category</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($categories as $cat)
                                <a href="{{ route('help.category', $cat->category) }}" 
                                   class="p-4 border border-gray-200 rounded-lg hover:border-blue-500 hover:shadow-md transition-all dark:border-gray-600 dark:hover:border-blue-400">
                                    <h3 class="font-medium text-gray-900 dark:text-white capitalize">{{ str_replace('-', ' ', $cat->category) }}</h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $cat->count }} articles</p>
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- Featured Articles -->
                    @if($featured->count() > 0)
                        <div>
                            <h2 class="text-xl font-semibold mb-6 text-gray-900 dark:text-white">Popular Articles</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                @foreach($featured as $article)
                                    <a href="{{ route('help.article', $article->slug) }}" 
                                       class="block p-6 border border-gray-200 rounded-lg hover:border-blue-500 hover:shadow-md transition-all dark:border-gray-600 dark:hover:border-blue-400">
                                        <h3 class="font-medium text-gray-900 dark:text-white mb-2">{{ $article->title }}</h3>
                                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-3">{{ Str::limit(strip_tags($article->content), 100) }}</p>
                                        <div class="flex items-center text-xs text-gray-400">
                                            <span class="capitalize">{{ str_replace('-', ' ', $article->category) }}</span>
                                            <span class="mx-2">•</span>
                                            <span>{{ $article->views }} views</span>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>