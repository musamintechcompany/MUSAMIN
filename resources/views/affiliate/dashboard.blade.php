<x-affiliate-layout>
    <div class="py-6">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <!-- Asset Stats Widgets -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <x-widgets.affiliate.assets.my-assets />
                <x-widgets.affiliate.assets.live-assets />
                <x-widgets.affiliate.assets.total-earnings />
            </div>
            
            <!-- Store Stats Widgets -->
            @if(auth()->user()->store)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <x-widgets.affiliate.store.store-visits />
                <x-widgets.affiliate.store.active-products />
            </div>
            @endif

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 gap-6 mb-6 md:grid-cols-2 lg:grid-cols-4">
                <div class="bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-lg shadow-sm p-6 transition-all duration-300 hover:-translate-y-1 hover:shadow-lg">
                    <h6 class="text-sm font-medium text-indigo-100 uppercase">Total Clicks</h6>
                    <h3 class="text-2xl font-bold text-white mb-2">1,248</h3>
                    <div class="flex items-center">
                        <span class="inline-flex items-center px-2 py-1 text-xs font-medium text-green-800 bg-green-100 rounded-full">
                            <i class="fas fa-arrow-up mr-1"></i> 12.5%
                        </span>
                        <span class="ml-2 text-sm text-indigo-100">vs last month</span>
                    </div>
                </div>
                
                <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-lg shadow-sm p-6 transition-all duration-300 hover:-translate-y-1 hover:shadow-lg">
                    <h6 class="text-sm font-medium text-emerald-100 uppercase">Conversions</h6>
                    <h3 class="text-2xl font-bold text-white mb-2">84</h3>
                    <div class="flex items-center">
                        <span class="inline-flex items-center px-2 py-1 text-xs font-medium text-green-800 bg-green-100 rounded-full">
                            <i class="fas fa-arrow-up mr-1"></i> 8.3%
                        </span>
                        <span class="ml-2 text-sm text-emerald-100">vs last month</span>
                    </div>
                </div>
                
                <div class="bg-gradient-to-br from-amber-500 to-amber-600 rounded-lg shadow-sm p-6 transition-all duration-300 hover:-translate-y-1 hover:shadow-lg">
                    <h6 class="text-sm font-medium text-amber-100 uppercase">Conversion Rate</h6>
                    <h3 class="text-2xl font-bold text-white mb-2">6.73%</h3>
                    <div class="flex items-center">
                        <span class="inline-flex items-center px-2 py-1 text-xs font-medium text-red-800 bg-red-100 rounded-full">
                            <i class="fas fa-arrow-down mr-1"></i> 1.2%
                        </span>
                        <span class="ml-2 text-sm text-amber-100">vs last month</span>
                    </div>
                </div>
                
                <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg shadow-sm p-6 transition-all duration-300 hover:-translate-y-1 hover:shadow-lg">
                    <h6 class="text-sm font-medium text-purple-100 uppercase">Earnings</h6>
                    <h3 class="text-2xl font-bold text-white mb-2">$1,284.50</h3>
                    <div class="flex items-center">
                        <span class="inline-flex items-center px-2 py-1 text-xs font-medium text-green-800 bg-green-100 rounded-full">
                            <i class="fas fa-arrow-up mr-1"></i> 18.7%
                        </span>
                        <span class="ml-2 text-sm text-purple-100">vs last month</span>
                    </div>
                </div>
            </div>

            <!-- Charts Row -->
            <div class="grid grid-cols-1 gap-6 mb-6 lg:grid-cols-3">
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-lg shadow-sm p-6 h-96 dark:bg-gray-800">
                        <h5 class="mb-4 text-lg font-semibold text-gray-900 dark:text-white">Performance Overview</h5>
                        <div class="relative h-80">
                            <canvas id="performanceChart" class="w-full h-full"></canvas>
                        </div>
                    </div>
                </div>
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-sm p-6 h-96 dark:bg-gray-800">
                        <h5 class="mb-4 text-lg font-semibold text-gray-900 dark:text-white">Traffic Sources</h5>
                        <div class="relative h-80">
                            <canvas id="trafficChart" class="w-full h-full"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="bg-white rounded-lg shadow-sm dark:bg-gray-800">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h5 class="text-lg font-semibold text-gray-900 dark:text-white">Recent Conversions</h5>
                        <a href="#" class="px-4 py-2 text-sm font-medium text-indigo-600 border border-indigo-600 rounded-md hover:bg-indigo-50 dark:text-indigo-400 dark:border-indigo-400 dark:hover:bg-indigo-900">View All</a>
                    </div>

                    <div class="space-y-3" id="activityList">
                        <!-- Items will be added dynamically -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
            // Chart Data and Initialization
            document.addEventListener('DOMContentLoaded', function() {
                const performanceData = {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
                    clicks: [120, 190, 170, 220, 280, 310, 380],
                    conversions: [8, 12, 10, 15, 18, 22, 28],
                    earnings: [160, 240, 200, 300, 360, 440, 560]
                };

                const trafficData = {
                    labels: ['Social Media', 'Email', 'Direct', 'Referral', 'Other'],
                    values: [35, 25, 20, 15, 5],
                    colors: ['#4361ee', '#4895ef', '#4cc9f0', '#3f37c9', '#f72585']
                };

                const recentConversions = [
                    { name: 'Sarah Johnson', amount: 49.99, product: 'Premium Plan', time: '10 min ago', status: 'completed' },
                    { name: 'Mike Peterson', amount: 99.99, product: 'Business Plan', time: '25 min ago', status: 'completed' },
                    { name: 'Emily Chen', amount: 29.99, product: 'Basic Plan', time: '1 hour ago', status: 'pending' },
                    { name: 'David Wilson', amount: 49.99, product: 'Premium Plan', time: '2 hours ago', status: 'completed' },
                    { name: 'Lisa Kim', amount: 99.99, product: 'Business Plan', time: '3 hours ago', status: 'completed' }
                ];

                // Performance Chart
                const perfCtx = document.getElementById('performanceChart');
                new Chart(perfCtx, {
                    type: 'line',
                    data: {
                        labels: performanceData.labels,
                        datasets: [
                            {
                                label: 'Clicks',
                                data: performanceData.clicks,
                                borderColor: '#4361ee',
                                backgroundColor: 'rgba(67, 97, 238, 0.1)',
                                tension: 0.3,
                                fill: true,
                                yAxisID: 'y'
                            },
                            {
                                label: 'Conversions',
                                data: performanceData.conversions,
                                borderColor: '#4cc9f0',
                                backgroundColor: 'rgba(76, 201, 240, 0.1)',
                                tension: 0.3,
                                fill: true,
                                yAxisID: 'y'
                            },
                            {
                                label: 'Earnings ($)',
                                data: performanceData.earnings,
                                borderColor: '#f72585',
                                backgroundColor: 'rgba(247, 37, 133, 0.1)',
                                tension: 0.3,
                                fill: true,
                                yAxisID: 'y1'
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: {
                            mode: 'index',
                            intersect: false,
                        },
                        scales: {
                            y: {
                                type: 'linear',
                                display: true,
                                position: 'left',
                                beginAtZero: true,
                                title: { display: true, text: 'Clicks & Conversions' }
                            },
                            y1: {
                                type: 'linear',
                                display: true,
                                position: 'right',
                                beginAtZero: true,
                                grid: { drawOnChartArea: false },
                                title: { display: true, text: 'Earnings ($)' },
                                suggestedMin: 0,
                                suggestedMax: Math.max(...performanceData.earnings) * 1.2
                            }
                        }
                    }
                });

                // Traffic Chart
                const trafficCtx = document.getElementById('trafficChart');
                new Chart(trafficCtx, {
                    type: 'doughnut',
                    data: {
                        labels: trafficData.labels,
                        datasets: [{
                            data: trafficData.values,
                            backgroundColor: trafficData.colors,
                            borderWidth: 0
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { position: 'bottom' }
                        },
                        cutout: '70%'
                    }
                });

                // Populate activity list
                const activityList = document.getElementById('activityList');
                recentConversions.forEach(item => {
                    const statusClass = item.status === 'completed' ? 'text-green-600' : 'text-yellow-600';
                    const statusIcon = item.status === 'completed' ? 'fas fa-check-circle' : 'fas fa-clock';

                    const activityItem = document.createElement('div');
                    activityItem.className = 'flex items-center justify-between p-4 border-l-4 border-indigo-500 bg-gray-50 rounded-r-lg dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors cursor-pointer';
                    activityItem.innerHTML = `
                        <div class="flex-1">
                            <h6 class="font-medium text-gray-900 dark:text-white">${item.name}</h6>
                            <p class="text-sm text-gray-500 dark:text-gray-400">${item.product}</p>
                        </div>
                        <div class="text-right">
                            <p class="font-semibold text-gray-900 dark:text-white">$${item.amount}</p>
                            <p class="text-sm ${statusClass}">
                                <i class="${statusIcon} mr-1"></i> ${item.time}
                            </p>
                        </div>
                    `;
                    activityList.appendChild(activityItem);
                });
            });
    </script>
    @endpush
</x-affiliate-layout>
