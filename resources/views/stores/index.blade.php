<x-app-layout>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop</title>
    <style>
        :root {
            --primary: #4299e1;
            --secondary: #3182ce;
            --accent: #63b3ed;
            --light: #f7fafc;
            --dark: #2d3748;
            --success: #48bb78;
            --warning: #f56565;
            --star: #ecc94b;
            --rent: #4299e1;
            --buy: #38b2ac;
            --notification: #4299e1;
            --bg-color: #f8f9fa;
            --text-color: #2d3748;
            --card-bg: #ffffff;
            --border-color: #e2e8f0;
            --favorite-heart: #f56565;
        }

        .dark {
            --bg-color: #1a202c;
            --text-color: #e2e8f0;
            --card-bg: #2d3748;
            --border-color: #4a5568;
            --light: #2d3748;
        }

        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: var(--bg-color);
            color: var(--text-color);
            transition: background-color 0.3s, color 0.3s;
        }

        .header {
            background-color: var(--dark);
            color: white;
            padding: 20px 0;
            text-align: center;
            transition: background-color 0.3s, color 0.3s;
        }

        .main-container {
            display: flex;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            gap: 30px;
        }

        .category-sidebar {
            width: 250px;
            flex-shrink: 0;
            background-color: var(--card-bg);
            border-radius: 8px;
            padding: 10px;
            transition: background-color 0.3s;
        }

        .content-area {
            flex: 1;
        }

        .search-bar {
            display: flex;
            margin-bottom: 20px;
        }

        .search-bar input {
            flex: 1;
            padding: 10px;
            font-size: 16px;
            border: 1px solid var(--border-color);
            border-radius: 4px 0 0 4px;
            background-color: var(--card-bg);
            color: var(--text-color);
            transition: all 0.3s;
        }

        .search-bar button {
            padding: 10px 20px;
            background-color: var(--primary);
            color: white;
            border: none;
            border-radius: 0 4px 4px 0;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .category-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .category-item {
            padding: 12px 15px;
            cursor: pointer;
            transition: all 0.3s;
            border-radius: 4px;
            margin-bottom: 5px;
            color: var(--text-color);
        }

        .category-item:hover {
            background-color: var(--light);
        }

        .category-item.active {
            background-color: var(--primary);
            color: white;
        }

        .stores-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }

        .store-card {
            background-color: var(--card-bg);
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            transition: transform 0.3s, box-shadow 0.3s, background-color 0.3s;
            border: 1px solid var(--border-color);
        }

        .store-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .store-image {
            height: 150px;
            background-color: var(--light);
            background-size: cover;
            background-position: center;
        }

        .store-info {
            padding: 15px;
        }

        .store-name {
            font-weight: bold;
            margin-bottom: 5px;
            font-size: 18px;
            color: var(--text-color);
        }

        .store-category {
            color: var(--text-color);
            opacity: 0.8;
            font-size: 14px;
            margin-bottom: 10px;
            transition: color 0.3s;
        }

        .store-description {
            color: var(--text-color);
            opacity: 0.7;
            font-size: 13px;
            margin-bottom: 15px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            transition: color 0.3s;
        }

        .visit-btn {
            display: block;
            width: 100%;
            padding: 10px 15px;
            background-color: var(--success);
            color: white;
            text-decoration: none;
            border-radius: 4px;
            font-size: 14px;
            transition: background-color 0.3s;
            text-align: center;
            border: none;
            cursor: pointer;
        }

        .visit-btn:hover {
            background-color: #27ae60;
        }

        .no-results {
            grid-column: 1 / -1;
            text-align: center;
            padding: 40px;
            color: var(--text-color);
        }

        @media (max-width: 1024px) {
            .stores-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 768px) {
            .main-container {
                flex-direction: column;
            }

            .category-sidebar {
                width: 100%;
                padding: 10px 0;
            }

            .category-list {
                display: flex;
                overflow-x: auto;
                padding-bottom: 10px;
                scrollbar-width: none;
            }

            .category-list::-webkit-scrollbar {
                display: none;
            }

            .category-item {
                white-space: nowrap;
                margin-right: 10px;
                margin-bottom: 0;
            }

            .stores-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 480px) {
            .stores-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Shop</h1>
    </div>

    <div class="main-container">
        <!-- Left Sidebar - Categories -->
        <div class="category-sidebar">
            <ul class="category-list">
                <li class="category-item active" data-category="all">All</li>
                <li class="category-item" data-category="custom">Custom Category</li>
                <li class="category-item" data-category="courses">Courses</li>
                <li class="category-item" data-category="physical">Physical Products</li>
                <li class="category-item" data-category="ticket">Ticket & Masterclass</li>
                <li class="category-item" data-category="membership">Membership Course</li>
                <li class="category-item" data-category="digital">Digital Product (Ebooks)</li>
                <li class="category-item" data-category="flexible">Flexible Subscription</li>
                <li class="category-item" data-category="subscription">Subscription</li>
                <li class="category-item" data-category="service">Service</li>
                <li class="category-item" data-category="stream">Stream Online Only</li>
                <li class="category-item" data-category="product">Physical Product</li>
            </ul>
        </div>

        <!-- Main Content Area -->
        <div class="content-area">
            <div class="search-bar">
                <input type="text" id="searchInput" placeholder="Search stores...">
                <button id="searchBtn">Search</button>
            </div>

            <div class="stores-grid" id="storesContainer">
                <!-- Store 1 -->
                <div class="store-card" data-categories="physical" data-search="Urban Outfitters Fashion clothing apparel trendy">
                    <div class="store-image" style="background-image: url('https://images.unsplash.com/photo-1489987707025-afc232f7ea0f?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&h=150&q=80')"></div>
                    <div class="store-info">
                        <div class="store-name">Urban Outfitters</div>
                        <div class="store-category">Fashion & Apparel</div>
                        <div class="store-description">Trendy clothing and accessories for young adults</div>
                        <a href="#" class="visit-btn">Visit Store</a>
                    </div>
                </div>

                <!-- Store 2 -->
                <div class="store-card" data-categories="digital" data-search="Tech Haven Electronics gadgets tech devices">
                    <div class="store-image" style="background-image: url('https://images.unsplash.com/photo-1518770660439-4636190af475?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&h=150&q=80')"></div>
                    <div class="store-info">
                        <div class="store-name">Tech Haven</div>
                        <div class="store-category">Electronics</div>
                        <div class="store-description">Latest gadgets and tech devices at competitive prices</div>
                        <a href="#" class="visit-btn">Visit Store</a>
                    </div>
                </div>

                <!-- Store 3 -->
                <div class="store-card" data-categories="physical" data-search="Green Living Home garden furniture plants">
                    <div class="store-image" style="background-image: url('https://images.unsplash.com/photo-1583845112203-454c8087f9f8?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&h=150&q=80')"></div>
                    <div class="store-info">
                        <div class="store-name">Green Living</div>
                        <div class="store-category">Home & Garden</div>
                        <div class="store-description">Eco-friendly home and garden products</div>
                        <a href="#" class="visit-btn">Visit Store</a>
                    </div>
                </div>

                <!-- Store 4 -->
                <div class="store-card" data-categories="physical" data-search="Extreme Sports Sports equipment outdoor gear">
                    <div class="store-image" style="background-image: url('https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&h=150&q=80')"></div>
                    <div class="store-info">
                        <div class="store-name">Extreme Sports</div>
                        <div class="store-category">Sports Equipment</div>
                        <div class="store-description">High-quality gear for outdoor enthusiasts</div>
                        <a href="#" class="visit-btn">Visit Store</a>
                    </div>
                </div>

                <!-- Store 5 -->
                <div class="store-card" data-categories="physical" data-search="Fresh Market Grocery food organic healthy">
                    <div class="store-image" style="background-image: url('https://images.unsplash.com/photo-1550583724-b2692b85b150?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&h=150&q=80')"></div>
                    <div class="store-info">
                        <div class="store-name">Fresh Market</div>
                        <div class="store-category">Grocery & Food</div>
                        <div class="store-description">Organic and healthy food options</div>
                        <a href="#" class="visit-btn">Visit Store</a>
                    </div>
                </div>

                <!-- Store 6 -->
                <div class="store-card" data-categories="service" data-search="Beauty Spot Health beauty skincare makeup">
                    <div class="store-image" style="background-image: url('https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&h=150&q=80')"></div>
                    <div class="store-info">
                        <div class="store-name">Beauty Spot</div>
                        <div class="store-category">Health & Beauty</div>
                        <div class="store-description">Premium skincare and makeup products</div>
                        <a href="#" class="visit-btn">Visit Store</a>
                    </div>
                </div>

                <!-- Store 7 -->
                <div class="store-card" data-categories="courses" data-search="Book Worm Books stationery reading literature">
                    <div class="store-image" style="background-image: url('https://images.unsplash.com/photo-1544947950-fa07a98d237f?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&h=150&q=80')"></div>
                    <div class="store-info">
                        <div class="store-name">Book Worm</div>
                        <div class="store-category">Books & Stationery</div>
                        <div class="store-description">Wide selection of books and writing materials</div>
                        <a href="#" class="visit-btn">Visit Store</a>
                    </div>
                </div>

                <!-- Store 8 -->
                <div class="store-card" data-categories="subscription" data-search="Toy Kingdom Toys games children kids">
                    <div class="store-image" style="background-image: url('https://images.unsplash.com/photo-1596461404969-9ae70f2830c1?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&h=150&q=80')"></div>
                    <div class="store-info">
                        <div class="store-name">Toy Kingdom</div>
                        <div class="store-category">Toys & Games</div>
                        <div class="store-description">Educational and fun toys for children</div>
                        <a href="#" class="visit-btn">Visit Store</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Category Filtering
        const categoryItems = document.querySelectorAll('.category-item');
        const storesContainer = document.getElementById('storesContainer');
        const storeCards = document.querySelectorAll('.store-card');

        categoryItems.forEach(item => {
            item.addEventListener('click', function() {
                // Update active category
                document.querySelector('.category-item.active').classList.remove('active');
                this.classList.add('active');

                const category = this.dataset.category;
                filterStores(category, document.getElementById('searchInput').value);
            });
        });

        // Search Functionality
        const searchInput = document.getElementById('searchInput');
        const searchBtn = document.getElementById('searchBtn');

        searchInput.addEventListener('input', () => {
            const activeCategory = document.querySelector('.category-item.active').dataset.category;
            filterStores(activeCategory, searchInput.value);
        });

        searchBtn.addEventListener('click', () => {
            const activeCategory = document.querySelector('.category-item.active').dataset.category;
            filterStores(activeCategory, searchInput.value);
        });

        // Combined Filter Function
        function filterStores(category, searchTerm) {
            let hasResults = false;

            storeCards.forEach(card => {
                const matchesCategory = category === 'all' || card.dataset.categories.includes(category);
                const matchesSearch = searchTerm === '' ||
                                    card.dataset.search.toLowerCase().includes(searchTerm.toLowerCase());

                if (matchesCategory && matchesSearch) {
                    card.style.display = 'block';
                    hasResults = true;
                } else {
                    card.style.display = 'none';
                }
            });

            // Show no results message if needed
            const noResults = document.getElementById('noResults');
            if (!hasResults) {
                if (!noResults) {
                    const noResultsDiv = document.createElement('div');
                    noResultsDiv.id = 'noResults';
                    noResultsDiv.className = 'no-results';
                    noResultsDiv.textContent = 'No stores match your search criteria.';
                    storesContainer.appendChild(noResultsDiv);
                }
            } else if (noResults) {
                noResults.remove();
            }
        }

        // Initialize with all stores visible
        filterStores('all', '');

        document.addEventListener('DOMContentLoaded', function() {
            const dbTheme = "{{ auth()->user()->theme }}";
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
</body>
</x-app-layout>
