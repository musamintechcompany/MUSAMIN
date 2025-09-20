<x-admin-layout title="Revenue Analytics">
<div class="p-4 lg:p-6">
    <div class="space-y-4 overflow-hidden">
        <div class="flex flex-col sm:flex-row lg:justify-between lg:items-center gap-4">
            <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-900">Revenue Analytics</h1>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-dollar-sign text-green-600 text-xl"></i>
                    </div>
                    <div class="flex-grow-1">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Total Revenue</p>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white">${{ number_format($totalRevenue, 2) }}</h3>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-calendar-day text-blue-600 text-xl"></i>
                    </div>
                    <div class="flex-grow-1">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Today</p>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white">${{ number_format($todayRevenue, 2) }}</h3>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-calendar-alt text-purple-600 text-xl"></i>
                    </div>
                    <div class="flex-grow-1">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">This Month</p>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white">${{ number_format($monthRevenue, 2) }}</h3>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-calendar-minus text-orange-600 text-xl"></i>
                    </div>
                    <div class="flex-grow-1">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Last Month</p>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white">${{ number_format($lastMonthRevenue, 2) }}</h3>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-calendar-times text-red-600 text-xl"></i>
                    </div>
                    <div class="flex-grow-1">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Last Year</p>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white">${{ number_format($lastYearRevenue, 2) }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</x-admin-layout>