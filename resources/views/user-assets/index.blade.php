<x-app-layout>
    @push('styles')
        <style>
            :root {
                --primary-color: #3498db;
                --primary-hover: #2980b9;
                --success-color: #2ecc71;
                --warning-color: #f39c12;
                --danger-color: #e74c3c;
                --text-color: #2c3e50;
                --light-text: #7f8c8d;
                --border-color: #ecf0f1;
                --card-bg: white;
            }

            .dark {
                --text-color: #ecf0f1;
                --light-text: #bdc3c7;
                --border-color: #34495e;
                --card-bg: #1e1e1e;
            }

            .transactions-page {
                background-color: var(--card-bg);
                color: var(--text-color);
                min-height: 100vh;
                transition: all 0.3s ease;
            }

            .transactions-container {
                max-width: 1200px;
                margin: 0 auto;
                padding: 2rem;
            }

            .page-header {
                margin-bottom: 2.5rem;
                text-align: center;
            }

            .page-title {
                font-size: 2.2rem;
                font-weight: 700;
                margin-bottom: 0.5rem;
                color: var(--text-color);
            }

            .page-subtitle {
                font-size: 1.1rem;
                color: var(--light-text);
                max-width: 700px;
                margin: 0 auto;
            }

            .transactions-grid {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
                gap: 1.5rem;
                margin-top: 2rem;
            }

            .transaction-card {
                background: var(--card-bg);
                border-radius: 10px;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
                padding: 1.5rem;
                border: 1px solid var(--border-color);
                transition: transform 0.3s ease, box-shadow 0.3s ease;
            }

            .transaction-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
            }

            .transaction-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 1rem;
                padding-bottom: 1rem;
                border-bottom: 1px solid var(--border-color);
            }

            .transaction-title {
                font-size: 1.2rem;
                font-weight: 600;
                margin: 0;
            }

            .transaction-status {
                padding: 0.25rem 0.75rem;
                border-radius: 20px;
                font-size: 0.85rem;
                font-weight: 600;
            }

            .status-completed {
                background-color: rgba(46, 204, 113, 0.1);
                color: var(--success-color);
            }

            .status-pending {
                background-color: rgba(243, 156, 18, 0.1);
                color: var(--warning-color);
            }

            .status-cancelled {
                background-color: rgba(231, 76, 60, 0.1);
                color: var(--danger-color);
            }

            .transaction-details {
                margin-bottom: 1.5rem;
            }

            .detail-row {
                display: flex;
                justify-content: space-between;
                margin-bottom: 0.5rem;
            }

            .detail-label {
                color: var(--light-text);
                font-size: 0.9rem;
            }

            .detail-value {
                font-weight: 500;
            }

            .transaction-actions {
                display: flex;
                gap: 0.75rem;
            }

            .action-btn {
                padding: 0.5rem 1rem;
                border-radius: 6px;
                font-size: 0.9rem;
                font-weight: 500;
                cursor: pointer;
                transition: all 0.2s ease;
                border: none;
            }

            .view-btn {
                background-color: var(--primary-color);
                color: white;
            }

            .view-btn:hover {
                background-color: var(--primary-hover);
            }

            .download-btn {
                background-color: transparent;
                border: 1px solid var(--border-color);
                color: var(--text-color);
            }

            .download-btn:hover {
                background-color: rgba(0, 0, 0, 0.05);
            }

            .empty-state {
                text-align: center;
                padding: 3rem;
                grid-column: 1 / -1;
            }

            .empty-icon {
                font-size: 3rem;
                color: var(--light-text);
                margin-bottom: 1rem;
            }

            .empty-title {
                font-size: 1.5rem;
                margin-bottom: 0.5rem;
            }

            .empty-text {
                color: var(--light-text);
                max-width: 500px;
                margin: 0 auto 1.5rem;
            }

            .explore-btn {
                display: inline-block;
                padding: 0.75rem 1.5rem;
                background-color: var(--primary-color);
                color: white;
                border-radius: 6px;
                font-weight: 500;
                text-decoration: none;
                transition: background-color 0.2s ease;
            }

            .explore-btn:hover {
                background-color: var(--primary-hover);
            }

            @media (max-width: 768px) {
                .transactions-grid {
                    grid-template-columns: 1fr;
                }

                .page-title {
                    font-size: 1.8rem;
                }
            }
        </style>
    @endpush

    <div class="transactions-page">
        <div class="transactions-container">
            <div class="page-header">
                <h1 class="page-title">Your Purchases & Rentals</h1>
                <p class="page-subtitle">This is where all your transaction history will be displayed. Manage your purchases and rentals here.</p>
            </div>

            <div class="transactions-grid">
                <!-- Example Transaction Card 1 -->
                <div class="transaction-card">
                    <div class="transaction-header">
                        <h3 class="transaction-title">Premium Software License</h3>
                        <span class="transaction-status status-completed">Completed</span>
                    </div>
                    <div class="transaction-details">
                        <div class="detail-row">
                            <span class="detail-label">Order ID:</span>
                            <span class="detail-value">#ORD-78945</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Date:</span>
                            <span class="detail-value">May 15, 2023</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Amount:</span>
                            <span class="detail-value">$149.99</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Type:</span>
                            <span class="detail-value">Purchase</span>
                        </div>
                    </div>
                    <div class="transaction-actions">
                        <button class="action-btn view-btn">View Details</button>
                        <button class="action-btn download-btn">Download</button>
                    </div>
                </div>

                <!-- Example Transaction Card 2 -->
                <div class="transaction-card">
                    <div class="transaction-header">
                        <h3 class="transaction-title">Video Editing Suite</h3>
                        <span class="transaction-status status-pending">Pending</span>
                    </div>
                    <div class="transaction-details">
                        <div class="detail-row">
                            <span class="detail-label">Order ID:</span>
                            <span class="detail-value">#ORD-78231</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Date:</span>
                            <span class="detail-value">June 2, 2023</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Amount:</span>
                            <span class="detail-value">$29.99/mo</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Type:</span>
                            <span class="detail-value">Rental</span>
                        </div>
                    </div>
                    <div class="transaction-actions">
                        <button class="action-btn view-btn">View Details</button>
                        <button class="action-btn download-btn">Cancel</button>
                    </div>
                </div>

                <!-- Example Transaction Card 3 -->
                <div class="transaction-card">
                    <div class="transaction-header">
                        <h3 class="transaction-title">Design Template Pack</h3>
                        <span class="transaction-status status-completed">Completed</span>
                    </div>
                    <div class="transaction-details">
                        <div class="detail-row">
                            <span class="detail-label">Order ID:</span>
                            <span class="detail-value">#ORD-77654</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Date:</span>
                            <span class="detail-value">April 28, 2023</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Amount:</span>
                            <span class="detail-value">$49.99</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Type:</span>
                            <span class="detail-value">Purchase</span>
                        </div>
                    </div>
                    <div class="transaction-actions">
                        <button class="action-btn view-btn">View Details</button>
                        <button class="action-btn download-btn">Download</button>
                    </div>
                </div>

                <!-- Empty State (uncomment to show when no transactions exist) -->
                <!--
                <div class="empty-state">
                    <div class="empty-icon">📭</div>
                    <h3 class="empty-title">No Transactions Yet</h3>
                    <p class="empty-text">You haven't made any purchases or rentals yet. When you do, they'll appear here.</p>
                    <a href="/products" class="explore-btn">Explore Products</a>
                </div>
                -->
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Transaction interaction handlers
                document.querySelectorAll('.view-btn').forEach(button => {
                    button.addEventListener('click', function() {
                        alert('View details functionality would go here');
                    });
                });

                document.querySelectorAll('.download-btn').forEach(button => {
                    button.addEventListener('click', function() {
                        if (button.textContent === 'Download') {
                            alert('Download functionality would go here');
                        } else if (button.textContent === 'Cancel') {
                            if (confirm('Are you sure you want to cancel this rental?')) {
                                alert('Cancellation functionality would go here');
                            }
                        }
                    });
                });

                // Theme initialization
                @auth
                    const userTheme = '{{ auth()->user()->theme }}';
                    if (userTheme) {
                        document.documentElement.classList.add(userTheme);
                        localStorage.setItem('theme', userTheme);
                    }
                @endauth

                // Listen for theme changes
                Livewire.on('themeChanged', (theme) => {
                    document.documentElement.classList.remove('light', 'dark');
                    document.documentElement.classList.add(theme);
                    localStorage.setItem('theme', theme);
                });
            });
        </script>
    @endpush
</x-app-layout>
