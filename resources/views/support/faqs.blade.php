<x-app-layout>
    <div class="py-12">
        <div class="mx-auto max-w-4xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                    <div class="flex items-center py-2 mb-6">
                        <button onclick="window.history.back()" class="mr-4 back-button">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M15 18L9 12L15 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                        <h2 class="text-2xl font-semibold text-gray-900 dark:text-white">Frequently Asked Questions</h2>
                    </div>

                    <div class="mb-6">
                        <input type="text" id="searchFaq" placeholder="Search FAQs..." 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>

                    @forelse($faqs as $category => $categoryFaqs)
                        <div class="mb-8">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4 capitalize">{{ $category }}</h3>
                            <div class="space-y-4">
                                @foreach($categoryFaqs as $faq)
                                    <div class="faq-item border border-gray-200 dark:border-gray-600 rounded-lg">
                                        <button class="faq-question w-full px-4 py-3 text-left bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 rounded-lg focus:outline-none">
                                            <div class="flex justify-between items-center">
                                                <span class="font-medium text-gray-900 dark:text-white">{{ $faq->question }}</span>
                                                <svg class="faq-icon w-5 h-5 text-gray-500 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                </svg>
                                            </div>
                                        </button>
                                        <div class="faq-answer hidden px-4 py-3 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800">
                                            {!! nl2br(e($faq->answer)) !!}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <p class="text-gray-500 dark:text-gray-400">No FAQs available at the moment.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // FAQ Toggle
            document.querySelectorAll('.faq-question').forEach(button => {
                button.addEventListener('click', function() {
                    const answer = this.nextElementSibling;
                    const icon = this.querySelector('.faq-icon');
                    
                    answer.classList.toggle('hidden');
                    icon.classList.toggle('rotate-180');
                });
            });

            // Search functionality
            document.getElementById('searchFaq').addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                document.querySelectorAll('.faq-item').forEach(item => {
                    const question = item.querySelector('.faq-question span').textContent.toLowerCase();
                    const answer = item.querySelector('.faq-answer').textContent.toLowerCase();
                    
                    if (question.includes(searchTerm) || answer.includes(searchTerm)) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });
    </script>
    @endpush
</x-app-layout>