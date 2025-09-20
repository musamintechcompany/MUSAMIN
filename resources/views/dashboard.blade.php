<x-app-layout>
    <div class="container p-4 mx-auto">
        <!-- Status Banners -->
        @auth
            @if(!auth()->user()->isActive())
                <div @class([
                    'mb-4 p-4 rounded-xl',
                    'bg-gradient-to-r from-yellow-400 to-yellow-500' => auth()->user()->isPending(),
                    'bg-gradient-to-r from-red-500 to-red-600' => auth()->user()->isBlocked(),
                    'bg-gradient-to-r from-red-400 to-red-500' => auth()->user()->isSuspended(),
                    'bg-gradient-to-r from-orange-400 to-orange-500' => auth()->user()->isOnHold(),
                    'bg-gradient-to-r from-purple-400 to-purple-500' => auth()->user()->isWarning()
                ])>
                    <div class="flex items-center">
                        @if(auth()->user()->isPending())
                            <svg class="w-5 h-5 mr-2 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            <p class="text-white font-medium">Please verify your email address to activate your account</p>
                        @elseif(auth()->user()->isBlocked())
                            <svg class="w-5 h-5 mr-2 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M13.477 14.89A6 6 0 015.11 6.524l8.367 8.368zm1.414-1.414L6.524 5.11a6 6 0 018.367 8.367zM18 10a8 8 0 11-16 0 8 8 0 0116 0z" clip-rule="evenodd"/>
                            </svg>
                            <p class="text-white font-medium">Your account has been blocked. Please contact support</p>
                        @elseif(auth()->user()->isSuspended())
                            <svg class="w-5 h-5 mr-2 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M13.477 14.89A6 6 0 015.11 6.524l8.367 8.368zm1.414-1.414L6.524 5.11a6 6 0 018.367 8.367zM18 10a8 8 0 11-16 0 8 8 0 0116 0z" clip-rule="evenodd"/>
                            </svg>
                            <p class="text-white font-medium">Your account is temporarily suspended</p>
                        @elseif(auth()->user()->isOnHold())
                            <svg class="w-5 h-5 mr-2 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            <p class="text-white font-medium">Your account is on hold. Please complete verification</p>
                        @elseif(auth()->user()->isWarning())
                            <svg class="w-5 h-5 mr-2 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            <p class="text-white font-medium">Your account has warnings. Please review your account</p>
                        @endif
                    </div>
                </div>
            @endif
        @endauth

        <!-- Mobile Wallets -->
        <div class="block md:hidden">
            <div x-data="mobileCarousel()" class="relative overflow-hidden">
                <div class="flex transition-transform duration-300"
                     x-ref="slider"
                     @touchstart="startTouch($event)"
                     @touchend="endTouch($event)"
                     :style="`transform: translateX(-${activeSlide * 100}%)`">

                    <!-- Wallet 1 -->
                    <div class="flex-shrink-0 w-full p-1">
                        <div class="flex items-center justify-between p-2 rounded-md bg-gradient-to-br from-blue-500 to-blue-600 shadow-sm">
                            <div class="flex items-center min-w-0 space-x-1">
                                <i class="fas fa-coins text-yellow-400 text-sm"></i>
                                <span class="truncate text-xs sm:text-sm md:text-base lg:text-lg font-semibold text-white">
                                    {{ number_format(auth()->user()->spendable_coins ?? 0) }}
                                </span>
                            </div>
                            <i class="fas fa-wallet text-white text-base"></i>
                        </div>
                    </div>

                    <!-- Wallet 2 -->
                    <div class="flex-shrink-0 w-full p-1">
                        <div class="flex items-center justify-between p-2 rounded-md bg-gradient-to-br from-green-500 to-green-600 shadow-sm">
                            <div class="flex items-center min-w-0 space-x-1">
                                <i class="fas fa-coins text-yellow-400 text-sm"></i>
                                <span class="truncate text-xs sm:text-sm md:text-base lg:text-lg font-semibold text-white">
                                    {{ number_format(auth()->user()->earned_coins ?? 0) }}
                                </span>
                            </div>
                            <i class="fas fa-trophy text-white text-base"></i>
                        </div>
                    </div>
                </div>

                <!-- Carousel Dots -->
                <div class="flex justify-center mt-1 space-x-2">
                    <button @click="goToSlide(0)" class="w-2 h-2 rounded-full transition" :class="activeSlide === 0 ? 'bg-blue-500 w-4' : 'bg-gray-300'"></button>
                    <button @click="goToSlide(1)" class="w-2 h-2 rounded-full transition" :class="activeSlide === 1 ? 'bg-green-500 w-4' : 'bg-gray-300'"></button>
                </div>
            </div>
        </div>

        <!-- Desktop Wallets -->
        <div class="hidden grid-cols-1 gap-2 md:grid md:grid-cols-2">
            <div class="flex items-center justify-between p-2 rounded-md bg-gradient-to-br from-blue-500 to-blue-600 shadow-sm">
                <div class="flex items-center min-w-0 space-x-1">
                    <i class="fas fa-coins text-yellow-400 text-sm"></i>
                    <span class="truncate text-xs sm:text-sm md:text-base lg:text-lg font-semibold text-white">
                        {{ number_format(auth()->user()->spendable_coins ?? 0) }}
                    </span>
                </div>
                <i class="fas fa-wallet text-white text-base"></i>
            </div>
            <div class="flex items-center justify-between p-2 rounded-md bg-gradient-to-br from-green-500 to-green-600 shadow-sm">
                <div class="flex items-center min-w-0 space-x-1">
                    <i class="fas fa-coins text-yellow-400 text-sm"></i>
                    <span class="truncate text-xs sm:text-sm md:text-base lg:text-lg font-semibold text-white">
                        {{ number_format(auth()->user()->earned_coins ?? 0) }}
                    </span>
                </div>
                <i class="fas fa-trophy text-white text-base"></i>
            </div>
        </div>

        <!-- Suggestions Section -->
        <div class="mt-6 px-4">
            <div class="text-[15px] font-semibold text-[#eef1f4] opacity-90 tracking-wide">Suggestions For You</div>
        </div>
        <div class="mt-2 px-4 overflow-x-auto flex gap-3 hide-scrollbar" id="suggestions">
            <div class="min-w-[330px] h-[86px] rounded-2xl p-[14px_16px] flex items-center justify-between gap-2.5 shadow-lg snap-start"
                 style="background: radial-gradient(110% 140% at 88% 18%, rgba(255,255,255,.12) 0%, transparent 54%), linear-gradient(135deg, #2546e6, #1135d0);">
                <div>
                    <h4 class="m-0 mb-1.5 text-[15px] font-extrabold text-white tracking-wide leading-tight">Check your H1 2025<br/>W.A.E.C Report</h4>
                    <button class="appearance-none border-0 bg-[#0b1a7a] text-[#dbe3ff] rounded-full py-2 px-3.5 font-extrabold text-[11px] tracking-wide shadow-[inset_0_0_0_1px_rgba(255,255,255,.06)] cursor-pointer">CHECK YOUR RESULT</button>
                </div>
                <div class="w-20 h-16 relative opacity-90" aria-hidden="true">
                    <div class="absolute w-16 h-12 right-1.5 top-1.5 rounded-xl rotate-2 filter saturate-110"
                         style="background: radial-gradient(80% 80% at 60% 40%, rgba(255,255,255,.18) 0%, rgba(255,255,255,.04) 35%, transparent 60%), linear-gradient(145deg, #5ad3ff 0%, #33b5ff 35%, #0e83f1 100%);"></div>
                    <div class="absolute w-10 h-9 right-6 bottom-0 rounded-xl opacity-88 rotate-2 filter saturate-110"
                         style="background: radial-gradient(80% 80% at 60% 40%, rgba(255,255,255,.18) 0%, rgba(255,255,255,.04) 35%, transparent 60%), linear-gradient(145deg, #5ad3ff 0%, #33b5ff 35%, #0e83f1 100%);"></div>
                </div>
            </div>

            <div class="min-w-[330px] h-[86px] rounded-2xl p-[14px_16px] flex items-center justify-between gap-2.5 shadow-lg snap-start"
                 style="background: radial-gradient(110% 140% at 88% 18%, rgba(255,255,255,.10) 0%, transparent 54%), linear-gradient(135deg, #2f7bff, #1730ae);">
                <div>
                    <h4 class="m-0 mb-1.5 text-[15px] font-extrabold text-white tracking-wide leading-tight">BR • Fintech<br/>Weekly Digest</h4>
                    <button class="appearance-none border-0 bg-[#0b1a7a] text-[#dbe3ff] rounded-full py-2 px-3.5 font-extrabold text-[11px] tracking-wide shadow-[inset_0_0_0_1px_rgba(255,255,255,.06)] cursor-pointer">READ NOW</button>
                </div>
                <div class="w-20 h-16 relative opacity-90" aria-hidden="true">
                    <div class="absolute w-16 h-12 right-1.5 top-1.5 rounded-xl rotate-2 filter saturate-110"
                         style="background: radial-gradient(80% 80% at 60% 40%, rgba(255,255,255,.18) 0%, rgba(255,255,255,.04) 35%, transparent 60%), linear-gradient(145deg, #5ad3ff 0%, #33b5ff 35%, #0e83f1 100%);"></div>
                    <div class="absolute w-10 h-9 right-6 bottom-0 rounded-xl opacity-88 rotate-2 filter saturate-110"
                         style="background: radial-gradient(80% 80% at 60% 40%, rgba(255,255,255,.18) 0%, rgba(255,255,255,.04) 35%, transparent 60%), linear-gradient(145deg, #5ad3ff 0%, #33b5ff 35%, #0e83f1 100%);"></div>
                </div>
            </div>
        </div>

        <!-- Savings Plans Section -->
        <div class="mt-6 px-4">
            <div class="flex items-center justify-between mb-3">
                <div class="text-[15px] font-semibold text-[#eef1f4] tracking-wide">My Savings Plans</div>
                <a class="text-[#b7c3ff] font-semibold text-[13px] no-underline" href="#">View All ▸</a>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div class="relative rounded-2xl p-4 overflow-hidden shadow-xl min-h-[120px]"
                     style="background: linear-gradient(180deg, rgba(255,255,255,.02), rgba(255,255,255,.01)), radial-gradient(120% 120% at 100% 0%, rgba(255,255,255,.06) 0%, transparent 60%), #0f2130;">
                    <div class="absolute top-2.5 right-2.5 bg-gradient-to-br from-[#2546e6] to-[#1730ae] text-[#dfe7ff] rounded-full py-1.5 px-2.5 font-extrabold text-xs shadow-lg">₦8.6M</div>
                    <div class="mt-10 font-bold text-[#eef1f4] tracking-wide">SafeLock</div>
                    <div class="h-1 rounded-full bg-[#23384a] overflow-hidden my-2">
                        <div class="h-full w-7/20 bg-gradient-to-r from-[#6dd3ff] to-[#2ea7ff]"></div>
                    </div>
                    <div class="text-[#b8c1cc] text-xs opacity-90">Lock funds to avoid temptations</div>
                </div>
                <div class="relative rounded-2xl p-4 overflow-hidden shadow-xl min-h-[120px]"
                     style="background: linear-gradient(180deg, rgba(255,255,255,.02), rgba(255,255,255,.01)), radial-gradient(120% 120% at 100% 0%, rgba(255,255,255,.06) 0%, transparent 60%), #0f1f2d;">
                    <div class="absolute top-2.5 right-2.5 bg-gradient-to-br from-[#1d52ff] to-[#0e36bd] text-[#dfe7ff] rounded-full py-1.5 px-2.5 font-extrabold text-xs shadow-lg">₦2.2M</div>
                    <div class="mt-10 font-bold text-[#eef1f4] tracking-wide">PiggyBank</div>
                    <div class="h-1 rounded-full bg-[#23384a] overflow-hidden my-2">
                        <div class="h-full w-[22%] bg-gradient-to-r from-[#6dd3ff] to-[#2ea7ff]"></div>
                    </div>
                    <div class="text-[#b8c1cc] text-xs opacity-90">Automatic daily, weekly or monthly savings</div>
                </div>
            </div>
        </div>

        <!-- Vetted Opportunities Section -->
        <div class="mt-6 px-4">
            <div class="flex items-center justify-between mb-3">
                <div class="text-[15px] font-semibold text-[#eef1f4] tracking-wide">Vetted Opportunities</div>
                <a class="text-[#b7c3ff] font-semibold text-[13px] no-underline" href="#">Find More ▸</a>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div class="relative rounded-2xl p-4 min-h-[190px] text-[#f4f6ff] shadow-xl overflow-hidden"
                     style="background: radial-gradient(100% 120% at 90% 0%, rgba(255,255,255,.10) 0%, transparent 60%), linear-gradient(160deg, #bc69ff 0%, #9020d7 45%, #7017ae 100%);">
                    <div class="absolute top-2.5 left-2.5 bg-gradient-to-br from-[#ff7a7a] to-[#ef4444] text-white font-black text-[11px] py-1.5 px-2.5 rounded-full tracking-wide shadow-lg">₦5K • SOLD OUT</div>
                    <div class="mt-9 text-3xl font-black text-center text-shadow-lg">19% <span class="text-sm font-extrabold opacity-90">per annum</span></div>
                    <div class="absolute left-0 right-0 bottom-2 px-3 text-[#e9ecf8]">
                        <div class="text-[11.5px] text-[#d8dcf0] opacity-90 tracking-wide">INVESTORS: 1,513 ⚡</div>
                        <div class="my-1 font-extrabold text-[13px] truncate">CORPORATE DEBT NO...</div>
                        <div class="text-xs text-[#e8ebf6] opacity-95">4.7% • returns in 3 months</div>
                    </div>
                </div>
                <div class="relative rounded-2xl p-4 min-h-[190px] text-[#f4f6ff] shadow-xl overflow-hidden"
                     style="background: radial-gradient(100% 120% at 90% 0%, rgba(255,255,255,.10) 0%, transparent 60%), linear-gradient(160deg, #60a5ff 0%, #2546e6 45%, #1135d0 100%);">
                    <div class="absolute top-2.5 left-2.5 bg-gradient-to-br from-[#ff7a7a] to-[#ef4444] text-white font-black text-[11px] py-1.5 px-2.5 rounded-full tracking-wide shadow-lg">₦5K • SOLD OUT</div>
                    <div class="mt-9 text-3xl font-black text-center text-shadow-lg">21% <span class="text-sm font-extrabold opacity-90">per annum</span></div>
                    <div class="absolute left-0 right-0 bottom-2 px-3 text-[#e9ecf8]">
                        <div class="text-[11.5px] text-[#d8dcf0] opacity-90 tracking-wide">INVESTORS: 1,784 ⚡</div>
                        <div class="my-1 font-extrabold text-[13px] truncate">CORPORATE DEBT NO...</div>
                        <div class="text-xs text-[#e8ebf6] opacity-95">15.5% • returns in 9 months</div>
                    </div>
                </div>
                <div class="relative rounded-2xl p-4 min-h-[190px] text-[#f4f6ff] shadow-xl overflow-hidden"
                     style="background: radial-gradient(100% 120% at 90% 0%, rgba(255,255,255,.10) 0%, transparent 60%), linear-gradient(160deg, #7b8cff 0%, #4666ff 45%, #1730ae 100%);">
                    <div class="absolute top-2.5 left-2.5 bg-gradient-to-br from-[#ff7a7a] to-[#ef4444] text-white font-black text-[11px] py-1.5 px-2.5 rounded-full tracking-wide shadow-lg">₦5K • SOLD OUT</div>
                    <div class="mt-9 text-3xl font-black text-center text-shadow-lg">20% <span class="text-sm font-extrabold opacity-90">per annum</span></div>
                    <div class="absolute left-0 right-0 bottom-2 px-3 text-[#e9ecf8]">
                        <div class="text-[11.5px] text-[#d8dcf0] opacity-90 tracking-wide">INVESTORS: 1,206 ⚡</div>
                        <div class="my-1 font-extrabold text-[13px] truncate">CORPORATE DEBT NO...</div>
                        <div class="text-xs text-[#e8ebf6] opacity-95">6.0% • returns in 6 months</div>
                    </div>
                </div>
                <div class="h-px"></div>
            </div>
        </div>
    </div>



    <style>
        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .text-shadow-lg {
            text-shadow: 0 6px 16px rgba(0,0,0,.25);
        }
    </style>

    @push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('mobileCarousel', () => ({
                activeSlide: 0,
                touchStartX: 0,
                touchEndX: 0,

                goToSlide(i) {
                    this.activeSlide = i;
                },
                startTouch(e) {
                    this.touchStartX = e.changedTouches[0].screenX;
                },
                endTouch(e) {
                    this.touchEndX = e.changedTouches[0].screenX;
                    this.handleSwipe();
                },
                handleSwipe() {
                    if (this.touchEndX < this.touchStartX - 50) {
                        if (this.activeSlide < 1) this.activeSlide++;
                    }
                    if (this.touchEndX > this.touchStartX + 50) {
                        if (this.activeSlide > 0) this.activeSlide--;
                    }
                }
            }));
        });

        // Scroll the suggestions to the first card on load
        const suggestions = document.getElementById('suggestions');
        window.addEventListener('load', () => {
            if (suggestions) {
                suggestions.scrollTo({left: 0, behavior: 'smooth'});
            }
        });

        // Ripple-like feedback for the FAB
        const fab = document.querySelector('.fixed button');
        if (fab) {
            fab.addEventListener('click', (e) => {
                const circle = document.createElement('span');
                const size = 120;
                circle.style.position = 'absolute';
                circle.style.width = circle.style.height = size + 'px';
                circle.style.left = (e.offsetX - size/2) + 'px';
                circle.style.top = (e.offsetY - size/2) + 'px';
                circle.style.borderRadius = '50%';
                circle.style.background = 'rgba(255,255,255,.25)';
                circle.style.pointerEvents = 'none';
                circle.style.transform = 'scale(0.2)';
                circle.style.transition = 'transform .35s ease, opacity .4s ease';
                fab.appendChild(circle);
                requestAnimationFrame(() => {
                    circle.style.transform = 'scale(1)';
                    circle.style.opacity = '0';
                });
                setTimeout(() => circle.remove(), 420);
            });
        }
    </script>
    @endpush
</x-app-layout>
