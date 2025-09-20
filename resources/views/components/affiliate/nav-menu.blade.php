<header class="bg-white shadow-sm dark:bg-gray-800">
    <style>
        .header-shadow {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .dark .header-shadow {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        #sidebarToggle {
            background: none;
            border: none;
            font-size: 1.25rem;
            color: #4b5563;
            cursor: pointer;
            padding: 0.5rem;
            transition: all 0.3s ease;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
        }

        #sidebarToggle:hover {
            background-color: rgba(0,0,0,0.05);
        }

        .dark #sidebarToggle {
            color: #d1d5db;
        }

        .dark #sidebarToggle:hover {
            background-color: rgba(255,255,255,0.05);
        }

        #sidebarToggle i {
            transition: transform 0.3s ease;
        }
    </style>

    <div class="flex items-center justify-between p-4">
        <div class="flex items-center gap-4">
            <button id="sidebarToggle">
                <i class="fas fa-bars"></i>
            </button>
        </div>

        <div class="flex items-center gap-4">
            <div class="relative">
                <button id="affiliateNotificationButton" class="relative p-2 text-gray-600 rounded-full dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                    <i class="fas fa-bell"></i>
                    <span id="affiliateNotificationBadge" class="absolute -top-1 -right-1 bg-purple-500 text-white rounded-full h-5 w-5 flex items-center justify-center text-xs font-bold" style="display: none">
                        0
                    </span>
                </button>
                <div id="affiliateNotificationDropdown" class="absolute right-0 z-50 hidden mt-2 bg-white border border-gray-200 rounded-md shadow-lg w-80 dark:bg-gray-800 dark:border-gray-700">
                    <div class="p-3 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex items-center justify-between">
                            <h3 class="font-medium text-gray-900 dark:text-white">Affiliate Notifications</h3>
                            <button id="affiliateMarkAllRead" class="text-xs text-purple-600 dark:text-purple-400 hover:underline">Mark all read</button>
                        </div>
                    </div>
                    <div id="affiliateNotificationList" class="overflow-y-auto max-h-96">
                        <div class="p-4 text-center text-gray-500 dark:text-gray-400">
                            <i class="fas fa-bell-slash text-2xl mb-2"></i>
                            <p>No notifications</p>
                        </div>
                    </div>
                    <div class="p-2 text-center border-t border-gray-200 dark:border-gray-700">
                        <a href="{{ route('affiliate.notifications.index') }}" class="text-sm text-purple-600 dark:text-purple-400 hover:underline">View all</a>
                    </div>
                </div>
            </div>

            <a href="{{ route('profile.show') }}" class="flex text-sm transition border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300">
                <img class="w-10 h-10 rounded-full" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
            </a>
        </div>
    </div>
</header>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const notificationButton = document.getElementById('affiliateNotificationButton');
        const notificationDropdown = document.getElementById('affiliateNotificationDropdown');
        const notificationBadge = document.getElementById('affiliateNotificationBadge');
        const notificationList = document.getElementById('affiliateNotificationList');
        const markAllRead = document.getElementById('affiliateMarkAllRead');
        const notificationSound = new Audio('/sounds/notification.mp3');

        // Load initial notifications
        loadAffiliateNotifications();

        // Listen for real-time notifications
        window.Echo.private(`App.Models.User.{{ auth()->id() }}`)
            .notification((notification) => {
                playNotificationSound();
                showToast(notification);
                loadAffiliateNotifications();
            });

        notificationButton.addEventListener('click', function() {
            notificationDropdown.classList.toggle('hidden');
            if (!notificationDropdown.classList.contains('hidden')) {
                loadAffiliateNotifications();
            }
        });

        markAllRead.addEventListener('click', function() {
            // Instant UI update
            updateNotificationBadge(0);
            notificationList.innerHTML = `
                <div class="p-4 text-center text-gray-500 dark:text-gray-400">
                    <i class="fas fa-bell-slash text-2xl mb-2"></i>
                    <p>No notifications</p>
                </div>`;
            
            // Background API call
            fetch('/affiliate-notifications/mark-all-read', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json'
                }
            }).catch(() => {
                // Revert on error
                loadAffiliateNotifications();
            });
        });

        document.addEventListener('click', function(event) {
            if (!notificationButton.contains(event.target) && !notificationDropdown.contains(event.target)) {
                notificationDropdown.classList.add('hidden');
            }
        });

        function loadAffiliateNotifications() {
            fetch('/affiliate-notifications/unread')
                .then(response => response.json())
                .then(data => {
                    updateNotificationBadge(data.count);
                    renderNotifications(data.notifications);
                });
        }

        function updateNotificationBadge(count) {
            if (count > 0) {
                notificationBadge.textContent = count > 99 ? '99+' : count;
                notificationBadge.style.display = 'flex';
            } else {
                notificationBadge.style.display = 'none';
            }
        }

        function renderNotifications(notifications) {
            if (notifications.length === 0) {
                notificationList.innerHTML = `
                    <div class="p-4 text-center text-gray-500 dark:text-gray-400">
                        <i class="fas fa-bell-slash text-2xl mb-2"></i>
                        <p>No notifications</p>
                    </div>`;
                return;
            }

            notificationList.innerHTML = notifications.map(notification => {
                const data = notification.data;
                const iconClass = getIconClass(data.icon, data.color);
                return `
                    <div class="p-3 border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer" onclick="markAsRead('${notification.id}')">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 pt-0.5">
                                <i class="${iconClass}"></i>
                            </div>
                            <div class="ml-3 flex-1">
                                <p class="text-sm font-medium text-gray-900 dark:text-white">${data.message}</p>
                                <p class="text-xs text-gray-400">${formatDate(notification.created_at)}</p>
                            </div>
                        </div>
                    </div>`;
            }).join('');
        }

        function getIconClass(icon, color) {
            const colorClass = {
                'green': 'text-green-500',
                'blue': 'text-blue-500',
                'yellow': 'text-yellow-500',
                'red': 'text-red-500',
                'purple': 'text-purple-500'
            }[color] || 'text-gray-500';
            return `fas fa-${icon} ${colorClass}`;
        }

        function formatDate(dateString) {
            return new Date(dateString).toLocaleString();
        }

        function markAsRead(notificationId) {
            // Instant UI update
            const currentCount = parseInt(notificationBadge.textContent) || 0;
            if (currentCount > 0) {
                updateNotificationBadge(currentCount - 1);
            }
            
            // Remove notification from dropdown instantly
            const notificationElement = document.querySelector(`[onclick*="${notificationId}"]`);
            if (notificationElement) {
                notificationElement.style.opacity = '0.5';
                notificationElement.style.pointerEvents = 'none';
            }
            
            // Background API call
            fetch(`/affiliate-notifications/${notificationId}/read`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            }).catch(() => {
                // Revert on error
                if (notificationElement) {
                    notificationElement.style.opacity = '1';
                    notificationElement.style.pointerEvents = 'auto';
                }
                updateNotificationBadge(currentCount);
            });
        }

        function playNotificationSound() {
            notificationSound.play().catch(() => {});
        }

        function showToast(notification) {
            const toast = document.createElement('div');
            toast.className = 'fixed top-4 right-4 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-lg p-4 z-50 max-w-sm';
            toast.innerHTML = `
                <div class="flex items-start">
                    <i class="fas fa-${notification.icon} ${getIconClass(notification.icon, notification.color)} mr-3 mt-1"></i>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-900 dark:text-white">${notification.message}</p>
                    </div>
                    <button onclick="this.parentElement.parentElement.remove()" class="ml-2 text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>`;
            document.body.appendChild(toast);
            setTimeout(() => toast.remove(), 5000);
        }
    });
</script>
@endpush


