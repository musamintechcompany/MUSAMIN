<x-app-layout>
    <div @class([
        'container p-4 mx-auto',
        'bg-gray-50' => auth()->user()->theme === 'light',
        'bg-gray-900' => auth()->user()->theme === 'dark'
    ])>
        <!-- Mobile View - Slider -->
        <div class="block md:hidden">
            <div x-data="mobileCarousel()" class="relative overflow-hidden">
                <!-- Slides Container -->
                <div class="flex transition-transform duration-300"
                     x-ref="slider"
                     :style="`transform: translateX(-${activeSlide * 100}%)`"
                     @mousedown="startDrag($event)"
                     @mousemove="handleDrag($event)"
                     @mouseup="endDrag($event)"
                     @mouseleave="endDrag($event)"
                     @touchstart.passive="startDrag($event)"
                     @touchmove.passive="handleDrag($event)"
                     @touchend.passive="endDrag($event)">

                    <!-- Spendable Coins Card -->
                    <div class="flex-shrink-0 w-full p-1">
                        <div class="h-full p-4 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center justify-between mb-2">
                                        <h3 class="text-lg font-semibold text-white">SPENDABLE</h3>
                                        <i class="text-2xl text-white fas fa-wallet opacity-90"></i>
                                    </div>

                                    <p class="text-3xl font-bold text-white my-2 flex items-center">
                                        <i class="mr-2 text-2xl text-yellow-300 fas fa-coins"></i>
                                        <span data-balance-type="spendable" class="inline-block min-w-[3rem]">
                                            {{ number_format(auth()->user()->spendable_coins ?? 0) }}
                                        </span>
                                    </p>

                                    <div class="flex items-center justify-between mt-3">
                                        <button class="wallet-id"
                                                x-data="{ copied: false }"
                                                @click="
                                                    copied = copyToClipboard('{{ auth()->user()->spending_wallet_id }}');
                                                    setTimeout(() => copied = false, 2000);
                                                "
                                                aria-label="Copy wallet ID"
                                                tabindex="0">
                                            <span x-show="!copied">{{ auth()->user()->spending_wallet_id ?? 'Not available' }}</span>
                                            <span x-show="copied" class="copy-feedback">Copied!</span>
                                            <i x-show="!copied" class="ml-1 fas fa-copy text-xs"></i>
                                        </button>
                                        <span class="text-sm font-medium text-white">
                                            ≈ ${{ number_format((auth()->user()->spendable_coins ?? 0) * 0.01, 2) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Earned Coins Card -->
                    <div class="flex-shrink-0 w-full p-1">
                        <div class="h-full p-4 rounded-xl bg-gradient-to-br from-green-500 to-green-600">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center justify-between mb-2">
                                        <h3 class="text-lg font-semibold text-white">EARNED</h3>
                                        <i class="text-2xl text-white fas fa-trophy opacity-90"></i>
                                    </div>

                                    <p class="text-3xl font-bold text-white my-2 flex items-center">
                                        <i class="mr-2 text-2xl text-yellow-300 fas fa-coins"></i>
                                        <span data-balance-type="earned" class="inline-block min-w-[3rem]">
                                            {{ number_format(auth()->user()->earned_coins ?? 0) }}
                                        </span>
                                    </p>

                                    <div class="flex items-center justify-between mt-3">
                                        <button class="wallet-id"
                                                x-data="{ copied: false }"
                                                @click="
                                                    copied = copyToClipboard('{{ auth()->user()->earned_wallet_id }}');
                                                    setTimeout(() => copied = false, 2000);
                                                "
                                                aria-label="Copy wallet ID"
                                                tabindex="0">
                                            <span x-show="!copied">{{ auth()->user()->earned_wallet_id ?? 'Not available' }}</span>
                                            <span x-show="copied" class="copy-feedback">Copied!</span>
                                            <i x-show="!copied" class="ml-1 fas fa-copy text-xs"></i>
                                        </button>
                                        <span class="text-sm font-medium text-white">
                                            ≈ ${{ number_format((auth()->user()->earned_coins ?? 0) * 0.01, 2) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Slide Indicators -->
                <div class="flex justify-center mt-3 space-x-2">
                    <button @click="goToSlide(0)"
                            class="w-2 h-2 transition-all rounded-full"
                            :class="activeSlide === 0 ? 'bg-blue-500 w-4' : 'bg-gray-300 dark:bg-gray-600'"
                            aria-label="Go to spendable coins">
                    </button>
                    <button @click="goToSlide(1)"
                            class="w-2 h-2 transition-all rounded-full"
                            :class="activeSlide === 1 ? 'bg-green-500 w-4' : 'bg-gray-300 dark:bg-gray-600'"
                            aria-label="Go to earned coins">
                    </button>
                </div>
            </div>

            <!-- Transfer Button (Mobile - Below wallets) -->
            <div class="mt-4">
                <button @class([
                    'w-full px-6 py-3 text-sm font-medium text-white rounded-lg focus:outline-none focus:ring-2 transition-colors',
                    'bg-purple-600 border border-purple-500 hover:bg-purple-700 focus:ring-purple-500' => auth()->user()->theme === 'light',
                    'bg-purple-700 border border-purple-600 hover:bg-purple-800 focus:ring-purple-400' => auth()->user()->theme === 'dark'
                ])>
                    <i class="mr-2 fas fa-exchange-alt"></i>
                    Transfer Coins
                </button>
            </div>
        </div>

        <!-- Desktop View - Grid -->
        <div class="hidden grid-cols-1 gap-4 md:grid md:grid-cols-2">
            <!-- Spendable Coins Card -->
            <div class="p-4 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="text-lg font-semibold text-white">SPENDABLE</h3>
                            <i class="text-2xl text-white fas fa-wallet opacity-90"></i>
                        </div>

                        <p class="text-3xl font-bold text-white my-2 flex items-center">
                            <i class="mr-2 text-2xl text-yellow-300 fas fa-coins"></i>
                            <span data-balance-type="spendable" class="inline-block min-w-[3rem]">
                                {{ number_format(auth()->user()->spendable_coins ?? 0) }}
                            </span>
                        </p>

                        <div class="flex items-center justify-between mt-3">
                            <button class="wallet-id"
                                    x-data="{ copied: false }"
                                    @click="
                                        copied = copyToClipboard('{{ auth()->user()->spending_wallet_id }}');
                                        setTimeout(() => copied = false, 2000);
                                    "
                                    aria-label="Copy wallet ID"
                                    tabindex="0">
                                <span x-show="!copied">{{ auth()->user()->spending_wallet_id ?? 'Not available' }}</span>
                                <span x-show="copied" class="copy-feedback">Copied!</span>
                                <i x-show="!copied" class="ml-1 fas fa-copy text-xs"></i>
                            </button>
                            <span class="text-sm font-medium text-white">
                                ≈ ${{ number_format((auth()->user()->spendable_coins ?? 0) * 0.01, 2) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Earned Coins Card -->
            <div class="p-4 rounded-xl bg-gradient-to-br from-green-500 to-green-600">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="text-lg font-semibold text-white">EARNED</h3>
                            <i class="text-2xl text-white fas fa-trophy opacity-90"></i>
                        </div>

                        <p class="text-3xl font-bold text-white my-2 flex items-center">
                            <i class="mr-2 text-2xl text-yellow-300 fas fa-coins"></i>
                            <span data-balance-type="earned" class="inline-block min-w-[3rem]">
                                {{ number_format(auth()->user()->earned_coins ?? 0) }}
                            </span>
                        </p>

                        <div class="flex items-center justify-between mt-3">
                            <button class="wallet-id"
                                    x-data="{ copied: false }"
                                    @click="
                                        copied = copyToClipboard('{{ auth()->user()->earned_wallet_id }}');
                                        setTimeout(() => copied = false, 2000);
                                    "
                                    aria-label="Copy wallet ID"
                                    tabindex="0">
                                <span x-show="!copied">{{ auth()->user()->earned_wallet_id ?? 'Not available' }}</span>
                                <span x-show="copied" class="copy-feedback">Copied!</span>
                                <i x-show="!copied" class="ml-1 fas fa-copy text-xs"></i>
                            </button>
                            <span class="text-sm font-medium text-white">
                                ≈ ${{ number_format((auth()->user()->earned_coins ?? 0) * 0.01, 2) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Transfer Button (Desktop - Below wallets) -->
        <div class="hidden md:block mt-4">
            <button @class([
                'w-full px-6 py-3 text-sm font-medium text-white rounded-lg focus:outline-none focus:ring-2 transition-colors',
                'bg-purple-600 border border-purple-500 hover:bg-purple-700 focus:ring-purple-500' => auth()->user()->theme === 'light',
                'bg-purple-700 border border-purple-600 hover:bg-purple-800 focus:ring-purple-400' => auth()->user()->theme === 'dark'
            ])>
                <i class="mr-2 fas fa-exchange-alt"></i>
                Transfer Coins
            </button>
        </div>

        <!-- Coin Activities Section -->
        <div @class([
            'mt-6 p-6 rounded-xl shadow-sm',
            'bg-white border border-gray-200' => auth()->user()->theme === 'light',
            'bg-gray-800 border border-gray-700' => auth()->user()->theme === 'dark'
        ])>
            <div class="mb-6">
                <h2 @class([
                    'text-xl font-semibold',
                    'text-gray-900' => auth()->user()->theme === 'light',
                    'text-gray-200' => auth()->user()->theme === 'dark'
                ])>Coin Activities</h2>
            </div>

            <div class="space-y-3">
                <!-- Transaction 1 - Recent Purchase -->
                <div @class([
                    'flex items-center justify-between p-4 rounded-lg transition-colors',
                    'bg-gray-100 hover:bg-gray-200' => auth()->user()->theme === 'light',
                    'bg-gray-700 hover:bg-gray-600' => auth()->user()->theme === 'dark'
                ])>
                    <div class="flex items-center space-x-3">
                        <div class="flex items-center justify-center w-10 h-10 rounded-full bg-purple-500">
                            <i class="fas fa-shopping-cart text-white"></i>
                        </div>
                        <div>
                            <p @class([
                                'font-medium',
                                'text-gray-900' => auth()->user()->theme === 'light',
                                'text-white' => auth()->user()->theme === 'dark'
                            ])>Marketplace Purchase</p>
                            <p @class([
                                'text-sm',
                                'text-gray-500' => auth()->user()->theme === 'light',
                                'text-gray-400' => auth()->user()->theme === 'dark'
                            ])>Just now</p>
                        </div>
                    </div>
                    <span @class([
                        'px-3 py-1 text-sm font-bold rounded-full',
                        'text-red-600 bg-red-100' => auth()->user()->theme === 'light',
                        'text-red-400 bg-red-900 bg-opacity-30' => auth()->user()->theme === 'dark'
                    ])>
                        -150
                    </span>
                </div>

                <!-- Transaction 2 - Daily Reward -->
                <div @class([
                    'flex items-center justify-between p-4 rounded-lg transition-colors',
                    'bg-gray-100 hover:bg-gray-200' => auth()->user()->theme === 'light',
                    'bg-gray-700 hover:bg-gray-600' => auth()->user()->theme === 'dark'
                ])>
                    <div class="flex items-center space-x-3">
                        <div class="flex items-center justify-center w-10 h-10 rounded-full bg-yellow-500">
                            <i class="fas fa-calendar-check text-white"></i>
                        </div>
                        <div>
                            <p @class([
                                'font-medium',
                                'text-gray-900' => auth()->user()->theme === 'light',
                                'text-white' => auth()->user()->theme === 'dark'
                            ])>Daily Login Bonus</p>
                            <p @class([
                                'text-sm',
                                'text-gray-500' => auth()->user()->theme === 'light',
                                'text-gray-400' => auth()->user()->theme === 'dark'
                            ])>Today at 8:30 AM</p>
                        </div>
                    </div>
                    <span @class([
                        'px-3 py-1 text-sm font-bold rounded-full',
                        'text-green-600 bg-green-100' => auth()->user()->theme === 'light',
                        'text-green-400 bg-green-900 bg-opacity-30' => auth()->user()->theme === 'dark'
                    ])>
                        +50
                    </span>
                </div>

                <!-- Transaction 3 - Referral Bonus -->
                <div @class([
                    'flex items-center justify-between p-4 rounded-lg transition-colors',
                    'bg-gray-100 hover:bg-gray-200' => auth()->user()->theme === 'light',
                    'bg-gray-700 hover:bg-gray-600' => auth()->user()->theme === 'dark'
                ])>
                    <div class="flex items-center space-x-3">
                        <div class="flex items-center justify-center w-10 h-10 rounded-full bg-blue-500">
                            <i class="fas fa-user-plus text-white"></i>
                        </div>
                        <div>
                            <p @class([
                                'font-medium',
                                'text-gray-900' => auth()->user()->theme === 'light',
                                'text-white' => auth()->user()->theme === 'dark'
                            ])>Referral Bonus</p>
                            <p @class([
                                'text-sm',
                                'text-gray-500' => auth()->user()->theme === 'light',
                                'text-gray-400' => auth()->user()->theme === 'dark'
                            ])>Yesterday at 3:45 PM</p>
                        </div>
                    </div>
                    <span @class([
                        'px-3 py-1 text-sm font-bold rounded-full',
                        'text-green-600 bg-green-100' => auth()->user()->theme === 'light',
                        'text-green-400 bg-green-900 bg-opacity-30' => auth()->user()->theme === 'dark'
                    ])>
                        +200
                    </span>
                </div>

                <!-- Transaction 4 - Withdrawal -->
                <div @class([
                    'flex items-center justify-between p-4 rounded-lg transition-colors',
                    'bg-gray-100 hover:bg-gray-200' => auth()->user()->theme === 'light',
                    'bg-gray-700 hover:bg-gray-600' => auth()->user()->theme === 'dark'
                ])>
                    <div class="flex items-center space-x-3">
                        <div class="flex items-center justify-center w-10 h-10 rounded-full bg-red-500">
                            <i class="fas fa-money-bill-wave text-white"></i>
                        </div>
                        <div>
                            <p @class([
                                'font-medium',
                                'text-gray-900' => auth()->user()->theme === 'light',
                                'text-white' => auth()->user()->theme === 'dark'
                            ])>Withdrawal Processed</p>
                            <p @class([
                                'text-sm',
                                'text-gray-500' => auth()->user()->theme === 'light',
                                'text-gray-400' => auth()->user()->theme === 'dark'
                            ])>2 days ago</p>
                        </div>
                    </div>
                    <span @class([
                        'px-3 py-1 text-sm font-bold rounded-full',
                        'text-red-600 bg-red-100' => auth()->user()->theme === 'light',
                        'text-red-400 bg-red-900 bg-opacity-30' => auth()->user()->theme === 'dark'
                    ])>
                        -500
                    </span>
                </div>

                <!-- Transaction 5 - Challenge Reward -->
                <div @class([
                    'flex items-center justify-between p-4 rounded-lg transition-colors',
                    'bg-gray-100 hover:bg-gray-200' => auth()->user()->theme === 'light',
                    'bg-gray-700 hover:bg-gray-600' => auth()->user()->theme === 'dark'
                ])>
                    <div class="flex items-center space-x-3">
                        <div class="flex items-center justify-center w-10 h-10 rounded-full bg-green-500">
                            <i class="fas fa-trophy text-white"></i>
                        </div>
                        <div>
                            <p @class([
                                'font-medium',
                                'text-gray-900' => auth()->user()->theme === 'light',
                                'text-white' => auth()->user()->theme === 'dark'
                            ])>Challenge Completed</p>
                            <p @class([
                                'text-sm',
                                'text-gray-500' => auth()->user()->theme === 'light',
                                'text-gray-400' => auth()->user()->theme === 'dark'
                            ])>3 days ago</p>
                        </div>
                    </div>
                    <span @class([
                        'px-3 py-1 text-sm font-bold rounded-full',
                        'text-green-600 bg-green-100' => auth()->user()->theme === 'light',
                        'text-green-400 bg-green-900 bg-opacity-30' => auth()->user()->theme === 'dark'
                    ])>
                        +300
                    </span>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col mt-6 space-y-3 md:flex-row md:justify-between md:space-y-0 md:gap-4">
            <button @class([
                'w-full px-6 py-3 text-sm font-medium rounded-lg border focus:outline-none focus:ring-2 transition-colors',
                'text-blue-600 border-blue-500 hover:bg-blue-50 focus:ring-blue-200' => auth()->user()->theme === 'light',
                'text-blue-400 border-blue-400 hover:bg-blue-900 hover:bg-opacity-20 focus:ring-blue-800' => auth()->user()->theme === 'dark'
            ])>
                <i class="mr-2 fas fa-eye"></i>
                View All
            </button>
            <button onclick="window.location.reload()" @class([
                'w-full px-6 py-3 text-sm font-medium rounded-lg border focus:outline-none focus:ring-2 transition-colors',
                'text-gray-600 border-gray-500 hover:bg-gray-50 focus:ring-gray-200' => auth()->user()->theme === 'light',
                'text-gray-400 border-gray-400 hover:bg-gray-700 hover:bg-opacity-20 focus:ring-gray-800' => auth()->user()->theme === 'dark'
            ])>
                <i class="mr-2 fas fa-sync-alt"></i>
                Refresh
            </button>
        </div>
    </div>

    @push('styles')
    <style>
        /* Wallet ID Styles */
        .wallet-id {
            font-size: 0.875rem;
            background: rgba(255, 255, 255, 0.15);
            padding: 6px 12px;
            border-radius: 20px;
            display: inline-flex;
            align-items: center;
            cursor: pointer;
            transition: all 0.2s ease;
            font-family: 'Courier New', monospace;
            color: white;
            border: none;
            outline: none;
            backdrop-filter: blur(2px);
        }

        .wallet-id:hover {
            background: rgba(255, 255, 255, 0.25);
            transform: translateY(-1px);
        }

        .wallet-id:active {
            transform: translateY(0);
        }

        .copy-feedback {
            font-size: 0.875rem;
            background: transparent !important;
            padding: 0 !important;
        }

        /* Animation for copy feedback */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(2px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .copy-feedback {
            animation: fadeIn 0.2s ease-out;
        }
    </style>
    @endpush

    @push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            // Global copy method
            window.copyToClipboard = function(text) {
                if (text) {
                    navigator.clipboard.writeText(text);
                    return true;
                }
                return false;
            };

            Alpine.data('mobileCarousel', () => ({
                activeSlide: 0,
                startX: 0,
                currentX: 0,
                isDragging: false,
                sliderWidth: 0,

                init() {
                    this.$nextTick(() => {
                        this.sliderWidth = this.$refs.slider.offsetWidth / 2;
                    });

                    // Auto-refresh balances
                    this.fetchBalances();
                    setInterval(() => this.fetchBalances(), 30000);
                },

                startDrag(e) {
                    this.isDragging = true;
                    this.startX = e.type === 'touchstart' ? e.touches[0].clientX : e.clientX;
                    this.$refs.slider.style.transition = 'none';
                },

                handleDrag(e) {
                    if (!this.isDragging) return;

                    this.currentX = e.type === 'touchmove' ? e.touches[0].clientX : e.clientX;
                    const diff = this.startX - this.currentX;
                    const maxDrag = this.sliderWidth * 0.5;

                    // Apply resistance at boundaries
                    let dragOffset = 0;
                    if ((this.activeSlide === 0 && diff < 0) ||
                        (this.activeSlide === 1 && diff > 0)) {
                        dragOffset = diff * 0.3; // Add resistance
                    } else {
                        dragOffset = diff;
                    }

                    this.$refs.slider.style.transform = `translateX(calc(-${this.activeSlide * 100}% - ${dragOffset}px))`;
                },

                endDrag(e) {
                    if (!this.isDragging) return;
                    this.isDragging = false;
                    this.$refs.slider.style.transition = 'transform 0.3s ease';

                    const endX = e.type === 'touchend' ? e.changedTouches[0].clientX : e.clientX;
                    const diff = this.startX - endX;
                    const threshold = 50;

                    if (diff > threshold) {
                        this.next();
                    } else if (diff < -threshold) {
                        this.prev();
                    } else {
                        this.$refs.slider.style.transform = `translateX(-${this.activeSlide * 100}%)`;
                    }
                },

                next() {
                    this.activeSlide = Math.min(this.activeSlide + 1, 1);
                },

                prev() {
                    this.activeSlide = Math.max(this.activeSlide - 1, 0);
                },

                goToSlide(index) {
                    this.activeSlide = index;
                },

                fetchBalances() {
                    fetch('/api/user/balances')
                        .then(response => response.json())
                        .then(data => {
                            document.querySelectorAll('[data-balance-type]').forEach(el => {
                                const type = el.getAttribute('data-balance-type');
                                el.textContent = data[`${type}_coins`];

                                // Update dollar conversion
                                const dollarValue = (parseInt(data[`${type}_coins`]) || 0) * 0.01;
                                const dollarElement = el.closest('.flex-1').querySelector('.text-sm.font-medium.text-white');
                                if (dollarElement) {
                                    dollarElement.textContent = `≈ $${dollarValue.toFixed(2)}`;
                                }
                            });
                        })
                        .catch(error => console.error('Error:', error));
                }
            }));
        });
    </script>
    @endpush
</x-app-layout>
