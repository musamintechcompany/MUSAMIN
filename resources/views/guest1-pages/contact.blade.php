<x-guest1-layout>
    <x-slot name="title">{{ config('app.name') }} | Contact Us</x-slot>
    <!-- Contact Section -->
    <section class="min-h-screen py-16 bg-gray-50">
        <div class="container px-4 mx-auto max-w-7xl">
            <div class="flex flex-col items-center lg:flex-row lg:items-start">
                <div class="w-full mb-10 lg:w-1/2 lg:mb-0 lg:pr-10">
                    <h2 class="mb-4 text-3xl font-bold text-gray-800 md:text-4xl">Get In Touch</h2>
                    <p class="mb-8 text-lg text-gray-600">Our team is here to help you find the perfect website solution.</p>

                    <div class="space-y-8">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 mt-1 mr-5 text-purple-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-semibold text-gray-800">Email Us</h3>
                                <p class="text-lg text-gray-700">support@webmarket.com</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="flex-shrink-0 mt-1 mr-5 text-purple-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-semibold text-gray-800">Call Us</h3>
                                <p class="text-lg text-gray-700">+1 (555) 123-4567</p>
                                <p class="text-sm text-gray-500">Mon-Fri, 9am-5pm EST</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="flex-shrink-0 mt-1 mr-5 text-purple-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-semibold text-gray-800">Live Chat</h3>
                                <p class="text-lg text-gray-700">Available 24/7 on our platform</p>
                                <p class="text-sm text-gray-500">Click the chat icon in the corner</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="w-full lg:w-1/2">
                    <div class="overflow-hidden bg-white rounded-lg shadow-lg">
                        <div class="p-8">
                            <h3 class="mb-6 text-2xl font-bold text-gray-800">Send Us a Message</h3>
                            <form>
                                <div class="mb-6">
                                    <label for="name" class="block mb-2 text-lg font-medium text-gray-700">Your Name</label>
                                    <input type="text" id="name" class="w-full px-4 py-3 text-gray-700 bg-gray-100 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500" required>
                                </div>
                                <div class="mb-6">
                                    <label for="email" class="block mb-2 text-lg font-medium text-gray-700">Email Address</label>
                                    <input type="email" id="email" class="w-full px-4 py-3 text-gray-700 bg-gray-100 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500" required>
                                </div>
                                <div class="mb-6">
                                    <label for="subject" class="block mb-2 text-lg font-medium text-gray-700">Subject</label>
                                    <select id="subject" class="w-full px-4 py-3 text-gray-700 bg-gray-100 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500" required>
                                        <option value="" selected disabled>Select a subject</option>
                                        <option>General Inquiry</option>
                                        <option>Listing Questions</option>
                                        <option>Technical Support</option>
                                        <option>Billing Questions</option>
                                        <option>Other</option>
                                    </select>
                                </div>
                                <div class="mb-6">
                                    <label for="message" class="block mb-2 text-lg font-medium text-gray-700">Message</label>
                                    <textarea id="message" rows="5" class="w-full px-4 py-3 text-gray-700 bg-gray-100 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500" required></textarea>
                                </div>
                                <button type="submit" class="w-full px-6 py-4 text-lg font-medium text-white bg-purple-600 rounded-lg hover:bg-purple-700 focus:ring-4 focus:ring-purple-300">Send Message</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-16 bg-gray-100">
        <div class="container px-4 mx-auto max-w-7xl">
            <h2 class="mb-4 text-3xl font-bold text-center text-gray-800 md:text-4xl">Frequently Asked Questions</h2>
            <p class="mb-12 text-lg text-center text-gray-600">Find answers to common questions about our platform</p>

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div x-data="{ openFaq: 1 }" class="space-y-4">
                    <!-- FAQ 1 -->
                    <div class="overflow-hidden bg-white rounded-lg shadow">
                        <button @click="openFaq = (openFaq === 1 ? null : 1)" class="flex items-center justify-between w-full px-6 py-4 text-left focus:outline-none">
                            <span class="text-xl font-semibold text-gray-800">How does the website verification process work?</span>
                            <svg :class="{'rotate-180': openFaq === 1}" class="w-5 h-5 text-purple-500 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div x-show="openFaq === 1" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform -translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0" class="px-6 pb-4">
                            <p class="text-gray-700">We thoroughly verify all website statistics including traffic sources, revenue claims, and technical infrastructure. Our team checks Google Analytics, server logs, and payment processors to ensure all information is accurate before listing.</p>
                        </div>
                    </div>

                    <!-- FAQ 2 -->
                    <div class="overflow-hidden bg-white rounded-lg shadow">
                        <button @click="openFaq = (openFaq === 2 ? null : 2)" class="flex items-center justify-between w-full px-6 py-4 text-left focus:outline-none">
                            <span class="text-xl font-semibold text-gray-800">What payment methods do you accept?</span>
                            <svg :class="{'rotate-180': openFaq === 2}" class="w-5 h-5 text-purple-500 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div x-show="openFaq === 2" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform -translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0" class="px-6 pb-4">
                            <p class="text-gray-700">We accept all major credit cards, PayPal, bank transfers, and cryptocurrency. All transactions are processed through our secure escrow system to protect both buyers and sellers.</p>
                        </div>
                    </div>

                    <!-- FAQ 3 -->
                    <div class="overflow-hidden bg-white rounded-lg shadow">
                        <button @click="openFaq = (openFaq === 3 ? null : 3)" class="flex items-center justify-between w-full px-6 py-4 text-left focus:outline-none">
                            <span class="text-xl font-semibold text-gray-800">Can I try a website before buying?</span>
                            <svg :class="{'rotate-180': openFaq === 3}" class="w-5 h-5 text-purple-500 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div x-show="openFaq === 3" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform -translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0" class="px-6 pb-4">
                            <p class="text-gray-700">Yes! Many of our listings offer a 7-14 day trial period for a small fee. This allows you to test the website's performance and verify all claims before committing to a purchase.</p>
                        </div>
                    </div>
                </div>

                <div x-data="{ openFaq: 4 }" class="space-y-4">
                    <!-- FAQ 4 -->
                    <div class="overflow-hidden bg-white rounded-lg shadow">
                        <button @click="openFaq = (openFaq === 4 ? null : 4)" class="flex items-center justify-between w-full px-6 py-4 text-left focus:outline-none">
                            <span class="text-xl font-semibold text-gray-800">How does the transfer process work?</span>
                            <svg :class="{'rotate-180': openFaq === 4}" class="w-5 h-5 text-purple-500 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div x-show="openFaq === 4" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform -translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0" class="px-6 pb-4">
                            <p class="text-gray-700">Our transfer team handles the entire process from start to finish. We ensure smooth domain transfer, content migration, and training if needed. Most transfers are completed within 3-5 business days.</p>
                        </div>
                    </div>

                    <!-- FAQ 5 -->
                    <div class="overflow-hidden bg-white rounded-lg shadow">
                        <button @click="openFaq = (openFaq === 5 ? null : 5)" class="flex items-center justify-between w-full px-6 py-4 text-left focus:outline-none">
                            <span class="text-xl font-semibold text-gray-800">What if I'm not satisfied with my purchase?</span>
                            <svg :class="{'rotate-180': openFaq === 5}" class="w-5 h-5 text-purple-500 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div x-show="openFaq === 5" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform -translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0" class="px-6 pb-4">
                            <p class="text-gray-700">We offer a 14-day money back guarantee on all purchases if the website doesn't match the listing description. For rentals, you can cancel at any time with 30 days notice.</p>
                        </div>
                    </div>

                    <!-- FAQ 6 -->
                    <div class="overflow-hidden bg-white rounded-lg shadow">
                        <button @click="openFaq = (openFaq === 6 ? null : 6)" class="flex items-center justify-between w-full px-6 py-4 text-left focus:outline-none">
                            <span class="text-xl font-semibold text-gray-800">Can I list my website for sale or rent?</span>
                            <svg :class="{'rotate-180': openFaq === 6}" class="w-5 h-5 text-purple-500 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div x-show="openFaq === 6" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform -translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0" class="px-6 pb-4">
                            <p class="text-gray-700">Absolutely! We welcome new listings after they pass our verification process. You can choose to sell outright, rent, or offer rent-to-own options. Our commission is only 10% per successful transaction.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-12 text-center">
                <a href="{{ url('/contact') }}" class="inline-block px-8 py-4 text-lg font-medium text-white bg-purple-600 rounded-lg hover:bg-purple-700 focus:ring-4 focus:ring-purple-300">Still Have Questions? Contact Us</a>
            </div>
        </div>
    </section>
</x-guest1-layout>
