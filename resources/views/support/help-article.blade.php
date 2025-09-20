<x-app-layout>
    <div class="py-12">
        <div class="mx-auto max-w-4xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center py-2 mb-6">
                        <button onclick="window.history.back()" class="mr-4 text-gray-500 hover:text-gray-700">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M15 18L9 12L15 6" stroke="currentColor" stroke-width="2"/>
                            </svg>
                        </button>
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $article->title }}</h1>
                            <div class="flex items-center mt-2 text-sm text-gray-500 dark:text-gray-400">
                                <span class="capitalize">{{ str_replace('-', ' ', $article->category) }}</span>
                                <span class="mx-2">•</span>
                                <span>{{ $article->views }} views</span>
                                <span class="mx-2">•</span>
                                <span>{{ $article->updated_at->format('M j, Y') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="prose prose-lg max-w-none dark:prose-invert">
                        {!! nl2br(e($article->content)) !!}
                    </div>

                    @if($related->count() > 0)
                        <div class="mt-12 pt-8 border-t border-gray-200 dark:border-gray-600">
                            <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white">Related Articles</h3>
                            <div class="space-y-3">
                                @foreach($related as $relatedArticle)
                                    <a href="{{ route('help.article', $relatedArticle->slug) }}" 
                                       class="block p-3 border border-gray-200 rounded-lg hover:border-blue-500 transition-colors dark:border-gray-600">
                                        <h4 class="font-medium text-gray-900 dark:text-white">{{ $relatedArticle->title }}</h4>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ Str::limit(strip_tags($relatedArticle->content), 80) }}</p>
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