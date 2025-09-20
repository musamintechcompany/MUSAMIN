<x-app-layout>
    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                    <div class="sticky top-0 flex items-center py-2 mb-6 bg-white dark:bg-gray-800">
                        <button onclick="window.history.back()" class="mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-500 dark:text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                        </button>
                        <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">Today's Rate</h2>
                    </div>

                    <div class="space-y-4">
                        <div class="p-4 transition-colors duration-300 rounded-lg bg-gray-50 dark:bg-gray-700">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <span class="text-lg font-medium text-gray-900 dark:text-gray-100">10 coins</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="text-lg font-medium text-gray-900 dark:text-gray-100">= 1 USD</span>
                                    <span class="ml-2 text-xl">🇺🇸</span>
                                </div>
                            </div>
                        </div>

                        <div class="p-4 transition-colors duration-300 rounded-lg bg-gray-50 dark:bg-gray-700">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <span class="text-lg font-medium text-gray-900 dark:text-gray-100">10 coins</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="text-lg font-medium text-gray-900 dark:text-gray-100">= 0.85 EUR</span>
                                    <span class="ml-2 text-xl">🇪🇺</span>
                                </div>
                            </div>
                        </div>

                        <div class="p-4 transition-colors duration-300 rounded-lg bg-gray-50 dark:bg-gray-700">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <span class="text-lg font-medium text-gray-900 dark:text-gray-100">10 coins</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="text-lg font-medium text-gray-900 dark:text-gray-100">= 0.75 GBP</span>
                                    <span class="ml-2 text-xl">🇬🇧</span>
                                </div>
                            </div>
                        </div>

                        <div class="p-4 transition-colors duration-300 rounded-lg bg-gray-50 dark:bg-gray-700">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <span class="text-lg font-medium text-gray-900 dark:text-gray-100">10 coins</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="text-lg font-medium text-gray-900 dark:text-gray-100">= 110 JPY</span>
                                    <span class="ml-2 text-xl">🇯🇵</span>
                                </div>
                            </div>
                        </div>

                        <div class="p-4 transition-colors duration-300 rounded-lg bg-gray-50 dark:bg-gray-700">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <span class="text-lg font-medium text-gray-900 dark:text-gray-100">10 coins</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="text-lg font-medium text-gray-900 dark:text-gray-100">= 7.5 CNY</span>
                                    <span class="ml-2 text-xl">🇨🇳</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Initialize theme from database on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Get theme from database (injected via Blade)
            const dbTheme = "{{ auth()->user()->theme }}";

            // Apply the theme if it exists
            if (dbTheme) {
                applyTheme(dbTheme);
                localStorage.setItem('theme', dbTheme);
            }
        });

        function applyTheme(theme) {
            const html = document.documentElement;
            html.classList.remove('light', 'dark');
            html.classList.add(theme);
        }
    </script>
    @endpush
</x-app-layout>
