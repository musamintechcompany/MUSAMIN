<x-app-layout>
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

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: var(--bg-color);
            color: var(--text-color);
            line-height: 1.6;
        }

        .notification {
            position: fixed;
            top: -100px;
            right: 20px;
            background-color: var(--notification);
            color: white;
            padding: 8px 16px;
            border-radius: 8px;
            z-index: 999999;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            transition: all 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            max-width: 90%;
            text-align: center;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.85rem;
        }

        .notification.show {
            top: 20px;
        }

        .notification-icon {
            font-size: 1.2rem;
            color: var(--favorite-heart);
        }

        .hero {
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('https://images.unsplash.com/photo-1499951360447-b19be8fe80f5?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 3rem 2rem;
            text-align: center;
            height: 300px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .hero h1 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }

        .hero p {
            font-size: 1.1rem;
            max-width: 700px;
            margin: 0 auto 2rem;
        }

        .main-container {
            display: flex;
            gap: 30px;
            position: sticky;
            top: 0;
            z-index: 100;
            background-color: var(--bg-color);
            padding: 20px;
        }

        .category-sidebar {
            width: 200px;
            flex-shrink: 0;
            background-color: var(--card-bg);
            border-radius: 8px;
            padding: 10px;
            transition: background-color 0.3s;
            height: fit-content;
        }

        .search-container {
            display: flex;
            flex: 1;
            position: relative;
            margin-bottom: 20px;
        }

        .search-container input {
            flex: 1;
            padding: 0.8rem 1rem;
            border: 1px solid var(--border-color);
            border-radius: 30px;
            font-size: 1rem;
            outline: none;
            padding-right: 40px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            background-color: var(--card-bg);
            color: var(--text-color);
        }

        .mobile-search {
            display: none;
            flex: 1;
            position: relative;
        }

        .mobile-search input {
            flex: 1;
            padding: 0.8rem 1rem;
            border: 1px solid var(--border-color);
            border-radius: 30px;
            font-size: 1rem;
            outline: none;
            padding-right: 40px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            background-color: var(--card-bg);
            color: var(--text-color);
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
            position: relative;
            text-decoration: none;
            display: block;
        }

        .category-item:hover {
            background-color: var(--light);
        }

        .category-item.active, .category-item.category-active {
            background-color: var(--primary);
            color: white;
        }

        .category-item.has-subcategory::after {
            content: '›';
            position: absolute;
            right: 1rem;
            transition: transform 0.3s ease;
        }

        .category-item.has-subcategory.active::after {
            transform: rotate(90deg);
        }

        .desktop-sub-categories {
            max-height: 0;
            overflow: hidden;
            padding-left: 1rem;
            border-left: 2px solid var(--primary);
            margin-top: 0;
            transition: max-height 0.4s ease, opacity 0.4s ease;
            opacity: 0;
        }

        .desktop-sub-categories.open {
            max-height: 500px;
            opacity: 1;
        }

        .content-area {
            flex: 1;
        }

        .filters-container {
            display: none;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            background-color: var(--card-bg);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-bottom: 1px solid var(--border-color);
        }

        .categories-dropdown {
            position: relative;
            flex-shrink: 0;
        }

        .mobile-filters-row {
            display: flex;
            gap: 1rem;
            align-items: center;
            width: 100%;
        }

        @media (max-width: 768px) {
            .main-container {
                display: none;
            }

            .mobile-filters-row {
                display: flex !important;
                padding: 10px 15px;
                gap: 0.8rem;
                align-items: center;
                position: sticky;
                top: 0;
                z-index: 1001;
                background-color: var(--bg-color);
                width: 100%;
                box-sizing: border-box;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            }

            .categories-dropdown {
                flex-shrink: 0;
            }

            .mobile-search {
                display: flex;
                flex: 1;
                min-width: 0;
            }

            .mobile-search input {
                width: 100%;
                min-width: 0;
            }


        }

        .categories-btn {
            padding: 0.8rem 1.5rem;
            background-color: var(--primary);
            color: white;
            border: none;
            border-radius: 30px;
            cursor: pointer;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            white-space: nowrap;
            transition: all 0.3s ease;
        }

        .categories-btn .dropdown-icon {
            transition: transform 0.3s ease;
        }

        .categories-dropdown.active .categories-btn .dropdown-icon {
            transform: rotate(90deg);
        }

        .categories-content {
            display: none;
            position: absolute;
            background-color: var(--card-bg);
            min-width: 250px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
            border-radius: 8px;
            z-index: 1000;
            padding: 0.5rem 0;
            max-height: 400px;
            overflow-y: auto;
            border: 1px solid var(--border-color);
            opacity: 0;
            transform: translateY(-10px);
            transition: all 0.3s ease;
            scrollbar-width: thin;
            scrollbar-color: var(--primary) var(--bg-color);
        }

        .categories-dropdown.active .categories-content {
            display: block;
            opacity: 1;
            transform: translateY(0);
        }

        .categories-content::-webkit-scrollbar {
            width: 4px;
        }

        .categories-content::-webkit-scrollbar-track {
            background: var(--bg-color);
        }

        .categories-content::-webkit-scrollbar-thumb {
            background-color: var(--primary);
            border-radius: 10px;
        }

        .categories-content a {
            color: var(--text-color);
            padding: 0.8rem 1rem;
            text-decoration: none;
            display: block;
            transition: background-color 0.2s;
            position: relative;
        }

        .categories-content a:hover {
            background-color: var(--light);
        }

        .sub-categories {
            max-height: 0;
            overflow: hidden;
            padding-left: 1rem;
            border-left: 2px solid var(--primary);
            margin-top: 0;
            transition: max-height 0.4s ease, opacity 0.4s ease;
            opacity: 0;
        }

        .sub-categories.open {
            max-height: 500px;
            opacity: 1;
        }

        .has-subcategory::after {
            content: '›';
            position: absolute;
            right: 1rem;
            transition: transform 0.3s ease;
        }

        .has-subcategory.active::after {
            transform: rotate(90deg);
        }

        .category-active {
            animation: pulse 2s infinite;
            position: relative;
            z-index: 1;
        }

        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(99, 102, 241, 0.2); }
            70% { box-shadow: 0 0 0 6px rgba(99, 102, 241, 0); }
            100% { box-shadow: 0 0 0 0 rgba(99, 102, 241, 0); }
        }



        .search-btn {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            background-color: var(--primary);
            color: white;
            border: none;
            border-radius: 20px;
            padding: 0.3rem 0.8rem;
            font-size: 0.8rem;
            cursor: pointer;
        }

        .container {
            padding: 2rem 1rem;
        }

        .no-results {
            text-align: center;
            padding: 3rem;
            color: #666;
            font-size: 1.2rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1rem;
        }

        .no-results-icon {
            font-size: 3rem;
            color: #ccc;
        }
            color: #666;
            font-size: 1.2rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1rem;
        }

        .no-results-icon {
            font-size: 3rem;
            color: #ccc;
        }

        .section-title {
            text-align: center;
            margin-bottom: 2rem;
            position: relative;
        }

        .section-title::after {
            content: '';
            display: block;
            width: 80px;
            height: 4px;
            background-color: var(--accent);
            margin: 0.5rem auto;
            border-radius: 2px;
        }

        .digitalassets-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
        }

        @media (min-width: 1400px) {
            .digitalassets-grid {
                grid-template-columns: repeat(4, 1fr);
            }
        }

        @media (min-width: 1200px) and (max-width: 1399px) {
            .digitalassets-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (min-width: 900px) and (max-width: 1199px) {
            .digitalassets-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .digitalasset-card {
            background-color: var(--card-bg);
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            position: relative;
            cursor: pointer;
            display: flex;
            flex-direction: column;
            border: 1px solid var(--border-color);
        }

        .digitalasset-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
        }

        .digitalasset-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: var(--warning);
            color: white;
            padding: 0.3rem 0.6rem;
            border-radius: 4px;
            font-size: 0.8rem;
            font-weight: bold;
            z-index: 1;
        }

        .digitalasset-media {
            height: 200px;
            overflow: hidden;
            position: relative;
        }

        .digitalasset-media img, .digitalasset-media video {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .digitalasset-card:hover .digitalasset-media img,
        .digitalasset-card:hover .digitalasset-media video {
            transform: scale(1.05);
        }

        .digitalasset-info {
            padding: 1rem;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .seller-avatar {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--border-color);
        }

        .seller-info {
            display: flex;
            align-items: center;
            gap: 0.4rem;
            margin-bottom: 0.6rem;
            font-size: 0.75rem;
            color: var(--text-color);
            opacity: 0.7;
        }

        .seller-avatar-container {
            position: relative;
            display: inline-block;
        }

        .verification-badge {
            position: absolute;
            bottom: -2px;
            right: -2px;
            width: 12px;
            height: 12px;
            background: linear-gradient(135deg, #1da1f2 0%, #0d8bd9 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 8px;
            color: white;
            box-shadow: 0 2px 8px rgba(29, 161, 242, 0.3);
            z-index: 2;
        }

        .verification-badge::before {
            content: '✓';
            font-weight: bold;
        }

        .verification-badge-inline {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 14px;
            height: 14px;
            background: linear-gradient(135deg, #1da1f2 0%, #0d8bd9 100%);
            border-radius: 50%;
            font-size: 9px;
            color: white;
            margin-left: 0.3rem;
        }

        .verification-badge-inline::before {
            content: '✓';
            font-weight: bold;
        }

        .digitalasset-type {
            color: var(--accent);
            font-size: 0.75rem;
            font-weight: 600;
            margin-bottom: 0.3rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            text-transform: uppercase;
        }

        .price-badges {
            display: flex;
            gap: 0.5rem;
        }

        .price-badge {
            font-size: 0.7rem;
            padding: 0.15rem 0.4rem;
            border-radius: 3px;
            font-weight: 600;
            white-space: nowrap;
        }

        .price-badge.buy {
            background-color: rgba(72, 187, 120, 0.3);
            color: var(--success);
        }

        .price-badge.rent {
            background-color: rgba(66, 153, 225, 0.3);
            color: var(--rent);
        }

        .price-badge .old-price {
            text-decoration: line-through;
            opacity: 0.6;
            margin-right: 0.2rem;
        }

        .digitalasset-title {
            font-size: 1.1rem;
            margin-bottom: 0.4rem;
            font-weight: 600;
            line-height: 1.3;
        }

        .digitalasset-description {
            color: var(--text-color);
            opacity: 0.7;
            font-size: 0.85rem;
            margin-bottom: 0.6rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .digitalasset-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: auto;
        }

        .digitalasset-price {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--primary);
            display: flex;
            align-items: center;
            transition: font-size 0.3s;
        }

        .digitalasset-price .old-price {
            font-size: 0.9rem;
            color: #999;
            text-decoration: line-through;
            margin-right: 0.5rem;
        }

        .digitalasset-rating {
            display: flex;
            align-items: center;
        }

        .favorite-btn {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 1.2rem;
            color: #ccc;
            transition: all 0.2s;
            padding: 5px;
        }

        .favorite-btn.active {
            color: var(--favorite-heart);
        }

        .star {
            color: var(--star);
            font-size: 0.9rem;
            margin-right: 0.2rem;
        }

        /* DigitalAsset Detail Modal */
        .digitalasset-detail-modal {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.8);
            z-index: 100000;
            display: none;
            overflow-y: auto;
            padding: 1rem;
        }

        .digitalasset-detail-container {
            max-width: 1000px;
            margin: 0 auto;
            background-color: var(--card-bg);
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        .digitalasset-detail-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem;
            border-bottom: 1px solid var(--border-color);
        }

        .close-detail {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: #999;
        }

        .digitalasset-detail-content {
            display: flex;
            flex-direction: column;
        }

        .digitalasset-detail-gallery {
            height: 400px;
            overflow: hidden;
            position: relative;
            touch-action: pan-y;
        }

        .digitalasset-detail-gallery img,
        .digitalasset-detail-gallery video {
            width: 100%;
            height: 100%;
            object-fit: cover;
            user-select: none;
        }

        .gallery-thumbnails {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
            overflow-x: auto;
            padding-bottom: 1rem;
            scrollbar-width: none;
            touch-action: pan-y;
        }

        .gallery-thumbnails::-webkit-scrollbar {
            display: none;
        }

        .thumbnail {
            width: 80px;
            height: 60px;
            border-radius: 4px;
            overflow: hidden;
            cursor: pointer;
            border: 2px solid transparent;
            transition: all 0.3s ease;
            flex-shrink: 0;
        }

        .thumbnail.active {
            border-color: var(--primary);
        }

        .thumbnail img, .thumbnail video {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .digitalasset-detail-info {
            padding: 2rem;
        }

        .digitalasset-detail-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.5rem;
        }

        .digitalasset-detail-type {
            color: var(--accent);
            font-size: 1rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .digitalasset-detail-rating {
            display: flex;
            align-items: center;
        }

        .digitalasset-detail-rating .stars {
            display: flex;
            margin-right: 0.5rem;
        }

        .digitalasset-detail-rating .star {
            font-size: 1.2rem;
        }

        .digitalasset-detail-rating .review-count {
            color: #666;
            font-size: 0.9rem;
        }

        .digitalasset-detail-title {
            font-size: 1.8rem;
            margin-bottom: 1rem;
            font-weight: 700;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
        }

        .price-badges {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .detail-price-badge {
            font-size: 0.9rem;
            padding: 0.3rem 0.6rem;
            border-radius: 4px;
            font-weight: 600;
        }

        .detail-price-badge.buy {
            background-color: rgba(56, 178, 172, 0.3);
            color: var(--buy);
        }

        .detail-price-badge.rent {
            background-color: rgba(66, 153, 225, 0.3);
            color: var(--rent);
        }

        .digitalasset-detail-description {
            color: var(--text-color);
            opacity: 0.8;
            font-size: 1rem;
            margin-bottom: 1.5rem;
            line-height: 1.7;
        }

        .description-divider {
            height: 1px;
            background: var(--border-color);
            margin: 1.5rem 0;
        }

        .hashtags {
            display: flex;
            flex-wrap: nowrap;
            gap: 0.5rem;
            margin-bottom: 2rem;
            overflow-x: auto;
            padding-bottom: 0.5rem;
            scrollbar-width: none;
        }

        .hashtags::-webkit-scrollbar {
            display: none;
        }

        .hashtag {
            background-color: var(--light);
            color: var(--primary);
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
            font-size: 0.85rem;
            white-space: nowrap;
        }

        .digitalasset-detail-actions {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
            flex-wrap: wrap;
        }

        .btn-action {
            padding: 0.8rem 1.5rem;
            border-radius: 4px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            flex: 1;
            min-width: 200px;
            justify-content: center;
        }

        .btn-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .btn-favorite {
            background-color: var(--light);
            color: var(--favorite-heart);
            border: 1px solid var(--border-color);
        }

        .btn-preview {
            background-color: #6c757d;
            color: white;
        }

        .btn-rent {
            background-color: var(--rent);
            color: white;
        }

        .btn-buy {
            background-color: var(--buy);
            color: white;
        }

        .btn-favorite:hover {
            background-color: var(--light);
            opacity: 0.9;
        }

        .btn-favorite.active {
            background-color: var(--favorite-heart);
            color: white;
            border-color: var(--favorite-heart);
        }

        .digitalasset-detail-tabs {
            margin-top: 2rem;
        }

        .tab-header {
            display: flex;
            border-bottom: 1px solid var(--border-color);
            overflow-x: auto;
            scrollbar-width: none;
            gap: 0.5rem;
            padding-bottom: 5px;
        }

        .tab-header::-webkit-scrollbar {
            display: none;
        }

        .tab-btn {
            padding: 0.8rem 1.5rem;
            background: none;
            border: none;
            cursor: pointer;
            font-weight: 600;
            color: var(--text-color);
            opacity: 0.7;
            position: relative;
            white-space: nowrap;
            flex-shrink: 0;
        }

        .tab-btn.active {
            color: var(--primary);
            opacity: 1;
        }

        .tab-btn.active::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0;
            width: 100%;
            height: 3px;
            background-color: var(--primary);
        }

        .tab-content {
            padding: 1.5rem 0;
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        /* Features List with Checkmarks */
        .features-list {
            list-style: none;
            padding-left: 0;
        }

        .features-list li {
            position: relative;
            padding-left: 1.5rem;
            margin-bottom: 0.5rem;
        }

        .features-list li::before {
            content: "✓";
            position: absolute;
            left: 0;
            color: var(--success);
            font-weight: bold;
        }

        .digitalasset-comments {
            margin-top: 2rem;
        }

        .review-form {
            background: var(--card-bg);
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 1.5rem;
            border: 1px solid var(--border-color);
        }

        .review-form-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .rating-stars {
            display: flex;
            gap: 0.3rem;
        }

        .rating-star {
            font-size: 1.5rem;
            color: #ddd;
            cursor: pointer;
            transition: color 0.2s;
        }

        .rating-star.active {
            color: var(--star);
        }

        .review-textarea {
            width: 100%;
            padding: 1rem;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            margin-bottom: 1rem;
            resize: vertical;
            min-height: 120px;
            font-size: 1rem;
            transition: all 0.3s;
            background-color: var(--bg-color);
            color: var(--text-color);
        }

        .review-textarea:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.2);
        }

        .review-submit-btn {
            background-color: var(--primary);
            color: white;
            border: none;
            padding: 0.8rem 1.5rem;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s;
            width: 100%;
        }

        .review-submit-btn:hover {
            background-color: var(--secondary);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .comment-list {
            margin-top: 1.5rem;
        }

        .comment {
            padding: 1.5rem 0;
            border-bottom: 1px solid var(--border-color);
        }

        .comment-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5rem;
        }

        .comment-author {
            font-weight: 600;
        }

        .comment-date {
            color: #999;
            font-size: 0.9rem;
        }

        .comment-text {
            color: var(--text-color);
            opacity: 0.8;
            line-height: 1.6;
        }

        /* Related DigitalAssets Section */
        .related-digitalassets {
            margin-top: 3rem;
            padding: 0 2rem 2rem;
        }

        .related-digitalassets h3 {
            font-size: 1.3rem;
            margin-bottom: 1rem;
            color: var(--text-color);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .related-digitalassets-grid {
            display: flex;
            gap: 1.5rem;
            overflow-x: auto;
            padding-bottom: 1rem;
            scrollbar-width: none;
            width: calc(100% + 4rem);
            margin-left: -2rem;
            padding-left: 2rem;
            padding-right: 2rem;
        }

        .related-digitalassets-grid::-webkit-scrollbar {
            display: none;
        }

        .related-digitalasset-card {
            min-width: 250px;
            background-color: var(--card-bg);
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            position: relative;
            cursor: pointer;
            display: flex;
            flex-direction: column;
            border: 1px solid var(--border-color);
        }

        .related-digitalasset-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
        }

        .related-digitalasset-media {
            height: 150px;
            overflow: hidden;
            position: relative;
        }

        .related-digitalasset-media img,
        .related-digitalasset-media video {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .related-digitalasset-info {
            padding: 1rem;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .related-digitalasset-title {
            font-size: 1rem;
            margin-bottom: 0.5rem;
            font-weight: 600;
        }

        .related-digitalasset-price {
            font-size: 1rem;
            font-weight: 700;
            color: var(--primary);
            margin-top: auto;
        }

        /* Purchase/Rental Options Modal */
        .options-modal {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.8);
            z-index: 100001;
            display: none;
            overflow-y: auto;
            padding: 1rem;
        }

        .options-container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            background-color: var(--card-bg);
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            display: flex;
            flex-direction: column;
            max-height: 90vh;
        }

        .options-header {
            padding: 1.5rem;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .options-title {
            font-size: 1.5rem;
            font-weight: 600;
        }

        .close-options {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: #999;
        }

        .options-content {
            padding: 2rem;
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: var(--border-color) var(--bg-color);
        }

        .options-content::-webkit-scrollbar {
            width: 6px;
        }

        .options-content::-webkit-scrollbar-track {
            background: var(--bg-color);
        }

        .options-content::-webkit-scrollbar-thumb {
            background-color: var(--border-color);
            border-radius: 10px;
        }

        .option-card {
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            background-color: var(--card-bg);
        }

        .option-card:hover {
            border-color: var(--primary);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .option-card.active {
            border-color: var(--primary);
            background-color: rgba(66, 153, 225, 0.05);
        }

        .option-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--text-color);
        }

        .option-description {
            color: var(--text-color);
            opacity: 0.8;
            margin-bottom: 1rem;
            font-size: 0.9rem;
        }

        .option-price {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--primary);
        }

        .option-price-dollars {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--primary);
        }

        .option-price-coins {
            font-size: 0.8rem;
            color: #666;
            font-weight: 600;
            margin-top: 0.2rem;
        }

        .duration-input-container {
            margin: 1.5rem 0;
            display: none;
        }

        .duration-input-container.active {
            display: block;
        }

        .duration-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: var(--text-color);
        }

        .duration-input {
            width: 100%;
            padding: 0.8rem;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            font-size: 1rem;
            margin-bottom: 1rem;
            background-color: var(--bg-color);
            color: var(--text-color);
        }

        .duration-summary {
            padding: 1rem;
            background-color: var(--light);
            border-radius: 4px;
            text-align: center;
            font-weight: 500;
            margin-bottom: 1rem;
            color: var(--text-color);
        }

        .rental-total {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--primary);
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: font-size 0.3s;
        }

        .rental-total-coins {
            font-size: 0.8rem;
            color: #666;
            font-weight: 600;
            margin-top: 0.2rem;
            text-align: right;
            width: 100%;
        }

        .options-footer {
            padding: 1.5rem;
            border-top: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
        }

        .btn-option {
            padding: 0.8rem 1.5rem;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
        }

        .btn-back {
            background-color: var(--light);
            color: var(--text-color);
            border: 1px solid var(--border-color);
        }

        .btn-continue {
            background-color: var(--primary);
            color: white;
        }

        /* Checkout Form */
        .checkout-form {
            padding: 2rem;
            overflow-y: auto;
            max-height: 60vh;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: var(--text-color);
        }

        .form-input {
            width: 100%;
            padding: 0.8rem;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            font-size: 1rem;
            background-color: var(--bg-color);
            color: var(--text-color);
        }

        .rental-details {
            padding: 1.5rem;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            margin-bottom: 1.5rem;
            background-color: var(--light);
        }

        .rental-details-title {
            font-size: 1.2rem;
            margin-bottom: 1rem;
            color: var(--text-color);
        }

        .rental-details-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5rem;
        }

        .rental-details-label {
            color: var(--text-color);
            opacity: 0.8;
        }

        .rental-details-value {
            font-weight: 600;
            color: var(--text-color);
        }

        @media (max-width: 768px) {
            .main-container {
                display: none;
            }

            .filters-container {
                display: flex !important;
            }

            .mobile-search {
                display: flex;
            }

            .mobile-products {
                display: block !important;
            }

            .container {
                padding: 1rem;
            }

            .hero h1 {
                font-size: 2rem;
            }

            .hero p {
                font-size: 1rem;
            }

            .digitalasset-detail-content {
                flex-direction: column;
            }

            .digitalasset-detail-gallery {
                height: 300px;
            }

            .digitalasset-detail-title {
                font-size: 1.5rem;
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }

            .digitalasset-detail-actions {
                flex-direction: column;
            }

            .btn-action {
                min-width: 100%;
            }

            .checkout-form {
                max-height: 50vh;
            }

            .related-digitalassets-grid {
                width: calc(100% + 2rem);
                margin-left: -1rem;
                padding-left: 1rem;
                padding-right: 1rem;
            }

            .filters-container {
                flex-direction: row;
                flex-wrap: nowrap;
            }

            .mobile-search input {
                min-width: 100px;
            }
        }

        @media (max-width: 480px) {
            .hero {
                padding: 2rem 1rem;
                height: 250px;
            }

            .hero h1 {
                font-size: 1.5rem;
            }

            .digitalassets-grid {
                grid-template-columns: 1fr;
            }

            .digitalasset-detail-info {
                padding: 1.5rem;
            }

            .options-title {
                font-size: 1.2rem;
            }

            .tab-btn {
                padding: 0.8rem 1rem;
            }

            .filters-container {
                flex-direction: row;
                flex-wrap: nowrap;
            }



            .checkout-form {
                max-height: 40vh;
            }
        }
    </style>

    <!-- Notification System -->
    <div class="notification" id="notification">
        <span class="notification-icon">♥</span>
        <span class="notification-message"></span>
    </div>

    <section class="hero">
        <h1>Premium Digital Assets for Your Projects</h1>
        <p>Discover our collection of ready-to-use websites, apps, templates, and plugins to kickstart your online presence.</p>
    </section>

    <!-- Mobile Filters Row -->
    <div class="mobile-filters-row" style="display: none;">
        <div class="categories-dropdown">
            <button class="categories-btn">
                <span>All</span>
                <span class="dropdown-icon">></span>
            </button>
            <div class="categories-content">
                <a href="#" data-filter="all" class="category-active">All</a>
                <a href="#" data-filter="website" class="has-subcategory">Websites</a>
                <div class="sub-categories">
                    <a href="#" data-filter="ecommerce">E-Commerce</a>
                    <a href="#" data-filter="portfolio">Portfolio</a>
                    <a href="#" data-filter="blog">Blog</a>
                    <a href="#" data-filter="business">Business</a>
                </div>
                <a href="#" data-filter="app" class="has-subcategory">Apps</a>
                <div class="sub-categories">
                    <a href="#" data-filter="mobile">Mobile</a>
                    <a href="#" data-filter="webapp">Web App</a>
                    <a href="#" data-filter="desktop">Desktop</a>
                </div>
                <a href="#" data-filter="template" class="has-subcategory">Templates</a>
                <div class="sub-categories">
                    <a href="#" data-filter="html">HTML</a>
                    <a href="#" data-filter="wordpress">WordPress</a>
                    <a href="#" data-filter="shopify">Shopify</a>
                </div>
                <a href="#" data-filter="plugin" class="has-subcategory">Plugins</a>
                <div class="sub-categories">
                    <a href="#" data-filter="wordpress-plugin">WordPress</a>
                    <a href="#" data-filter="browser">Browser</a>
                    <a href="#" data-filter="premiere">Premiere Pro</a>
                </div>
                <a href="#" data-filter="service">Services</a>
                <a href="#" data-filter="ui-kit">UI Kits</a>
                <a href="#" data-filter="illustration">Illustrations</a>
                <a href="#" data-filter="icon-set">Icon Sets</a>
            </div>
        </div>
        <div class="mobile-search">
            <input type="text" id="search-input-mobile" placeholder="Search for digital assets...">
        </div>
    </div>

    <div class="main-container">
        <!-- Left Sidebar - Categories -->
        <div class="category-sidebar">
            <div class="category-list">
                <a href="#" data-filter="all" class="category-item category-active">All</a>
                <a href="#" data-filter="website" class="category-item has-subcategory">Websites</a>
                <div class="desktop-sub-categories">
                    <a href="#" data-filter="ecommerce" class="category-item">E-Commerce</a>
                    <a href="#" data-filter="portfolio" class="category-item">Portfolio</a>
                    <a href="#" data-filter="blog" class="category-item">Blog</a>
                    <a href="#" data-filter="business" class="category-item">Business</a>
                </div>
                <a href="#" data-filter="app" class="category-item has-subcategory">Apps</a>
                <div class="desktop-sub-categories">
                    <a href="#" data-filter="mobile" class="category-item">Mobile</a>
                    <a href="#" data-filter="webapp" class="category-item">Web App</a>
                    <a href="#" data-filter="desktop" class="category-item">Desktop</a>
                </div>
                <a href="#" data-filter="template" class="category-item has-subcategory">Templates</a>
                <div class="desktop-sub-categories">
                    <a href="#" data-filter="html" class="category-item">HTML</a>
                    <a href="#" data-filter="wordpress" class="category-item">WordPress</a>
                    <a href="#" data-filter="shopify" class="category-item">Shopify</a>
                </div>
                <a href="#" data-filter="plugin" class="category-item has-subcategory">Plugins</a>
                <div class="desktop-sub-categories">
                    <a href="#" data-filter="wordpress-plugin" class="category-item">WordPress</a>
                    <a href="#" data-filter="browser" class="category-item">Browser</a>
                    <a href="#" data-filter="premiere" class="category-item">Premiere Pro</a>
                </div>
                <a href="#" data-filter="service" class="category-item">Services</a>
                <a href="#" data-filter="ui-kit" class="category-item">UI Kits</a>
                <a href="#" data-filter="illustration" class="category-item">Illustrations</a>
                <a href="#" data-filter="icon-set" class="category-item">Icon Sets</a>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="content-area">
            <div class="search-container">
                <input type="text" id="search-input" placeholder="Search for digital assets...">
            </div>

            <div class="container">
                <div class="digitalassets-grid" id="digitalassets-grid">
                    <!-- DigitalAssets will be loaded here via JavaScript -->
                </div>
                <div class="no-results" id="no-results" style="display: none;">
                    <div class="no-results-icon">🔍</div>
                    <div>We couldn't find any digital assets matching your search.</div>
                    <div>Please try different keywords or browse our categories.</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Products Container -->
    <div class="mobile-products" style="display: none;">
        <div class="container">
            <div class="digitalassets-grid" id="digitalassets-grid-mobile">
                <!-- DigitalAssets will be loaded here via JavaScript -->
            </div>
            <div class="no-results" id="no-results-mobile" style="display: none;">
                <div class="no-results-icon">🔍</div>
                <div>We couldn't find any digital assets matching your search.</div>
                <div>Please try different keywords or browse our categories.</div>
            </div>
        </div>
    </div>

    <!-- DigitalAsset Detail Modal -->
    <div class="digitalasset-detail-modal" id="digitalasset-detail-modal">
        <div class="digitalasset-detail-container">
            <div class="digitalasset-detail-header">
                <h3>DigitalAsset Details</h3>
                <button class="close-detail" id="close-detail">×</button>
            </div>
            <div class="digitalasset-detail-content">
                <div class="digitalasset-detail-gallery" id="main-gallery">
                    <!-- Main digitalasset media will be loaded here -->
                </div>
                <div class="gallery-thumbnails" id="gallery-thumbnails">
                    <!-- Thumbnails will be loaded here -->
                </div>
                <div class="digitalasset-detail-info">
                    <div class="digitalasset-detail-top">
                        <span class="digitalasset-detail-type" id="detail-type">WEBSITE</span>
                        <div class="digitalasset-detail-rating">
                            <div class="stars" id="detail-stars">
                                <!-- Stars will be loaded here -->
                            </div>
                            <span class="review-count" id="detail-review-count">(24 reviews)</span>
                        </div>
                    </div>
                    <h1 class="digitalasset-detail-title" id="detail-title">
                        E-Commerce Website
                        <div class="price-badges">
                            <span class="detail-price-badge buy" id="detail-buy-price">$799.00</span>
                            <span class="detail-price-badge rent" id="detail-rent-price">$49.00</span>
                        </div>
                    </h1>
                    <p class="digitalasset-detail-description" id="detail-description">
                        Full description will be loaded here...
                    </p>

                    <div class="description-divider"></div>

                    <div class="hashtags" id="hashtags">
                        <!-- Hashtags will be generated here -->
                    </div>

                    <div class="digitalasset-detail-actions">
                        <button class="btn-action btn-favorite" id="btn-favorite">
                            ♥ Add to Favorites
                        </button>
                        <button class="btn-action btn-preview" id="btn-preview">
                            👁️ Live Preview
                        </button>
                        <button class="btn-action btn-rent" id="btn-rent">
                            Rent Now
                        </button>
                        <button class="btn-action btn-buy" id="btn-buy">
                            Buy Now
                        </button>
                    </div>

                    <div class="digitalasset-detail-tabs">
                        <div class="tab-header">
                            <button class="tab-btn active" data-tab="details">Details</button>
                            <button class="tab-btn" data-tab="features">Features</button>
                            <button class="tab-btn" data-tab="reviews">Reviews</button>
                            <button class="tab-btn" data-tab="license">License</button>
                            <button class="tab-btn" data-tab="developers">Developers</button>
                            <button class="tab-btn" data-tab="requirements">Requirements</button>
                        </div>
                        <div class="tab-content active" id="tab-details">
                            <p>Detailed information about the digital asset will be displayed here.</p>
                        </div>
                        <div class="tab-content" id="tab-features">
                            <ul class="features-list">
                                <!-- Features will be loaded here -->
                            </ul>
                        </div>
                        <div class="tab-content" id="tab-reviews">
                            <div class="digitalasset-comments">
                                <div class="review-form">
                                    <div class="review-form-header">
                                        <h4>Add Your Review</h4>
                                        <div class="rating-stars" id="review-stars">
                                            <span class="rating-star">☆</span>
                                            <span class="rating-star">☆</span>
                                            <span class="rating-star">☆</span>
                                            <span class="rating-star">☆</span>
                                            <span class="rating-star">☆</span>
                                        </div>
                                    </div>
                                    <textarea class="review-textarea" placeholder="Share your thoughts about this digital asset..."></textarea>
                                    <button class="review-submit-btn" id="submit-review">Submit Review</button>
                                </div>
                                <div class="comment-list" id="comment-list">
                                    <!-- Comments will be loaded here -->
                                </div>
                            </div>
                        </div>
                        <div class="tab-content" id="tab-license">
                            <h4>License Information</h4>
                            <p id="license-info">License details will be displayed here.</p>
                        </div>
                        <div class="tab-content" id="tab-developers">
                            <h4>Development Team</h4>
                            <div class="seller-info" style="margin-top: 1rem; font-size: 1rem;">
                                <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&auto=format&fit=crop&w=100&q=80" alt="Developer" class="seller-avatar" style="width: 40px; height: 40px;">
                                <div>
                                    <div style="font-weight: 600; display: flex; align-items: center;">John Developer <div class="verification-badge-inline"></div></div>
                                    <div style="opacity: 0.7; font-size: 0.9rem;">Senior Full Stack Developer</div>
                                </div>
                            </div>
                            <p style="margin-top: 1rem;">Experienced developer with 8+ years in web development, specializing in modern frameworks and scalable solutions.</p>
                        </div>
                        <div class="tab-content" id="tab-requirements">
                            <h4>System Requirements</h4>
                            <p>Technical requirements will be displayed here.</p>
                        </div>
                    </div>

                    <!-- Sponsored DigitalAssets Section -->
                    <div class="related-digitalassets" id="sponsored-section">
                        <h3>Sponsored</h3>
                        <div class="related-digitalassets-grid" id="sponsored-digitalassets">
                            <!-- Sponsored digital assets will be loaded here -->
                        </div>
                    </div>

                    <!-- Featured DigitalAssets Section -->
                    <div class="related-digitalassets" id="featured-section">
                        <h3>Featured</h3>
                        <div class="related-digitalassets-grid" id="featured-digitalassets">
                            <!-- Featured digital assets will be loaded here -->
                        </div>
                    </div>

                    <!-- Suggested DigitalAssets Section -->
                    <div class="related-digitalassets" id="suggested-section">
                        <h3>Suggested</h3>
                        <div class="related-digitalassets-grid" id="suggested-digitalassets">
                            <!-- Suggested digital assets will be loaded here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Purchase Options Modal -->
    <div class="options-modal" id="purchase-options-modal">
        <div class="options-container">
            <div class="options-header">
                <h3 class="options-title" id="purchase-title">Purchase Options</h3>
                <button class="close-options" id="close-purchase">×</button>
            </div>
            <div class="options-content" id="purchase-options">
                <!-- Purchase options will be loaded here -->
            </div>
            <div class="options-footer">
                <button class="btn-option btn-back" id="purchase-back">Back</button>
                <button class="btn-option btn-continue" id="purchase-continue">Continue</button>
            </div>
        </div>
    </div>

    <!-- Rental Options Modal -->
    <div class="options-modal" id="rental-options-modal">
        <div class="options-container">
            <div class="options-header">
                <h3 class="options-title" id="rental-title">Rental Options</h3>
                <button class="close-options" id="close-rental">×</button>
            </div>
            <div class="options-content" id="rental-options">
                <!-- Rental options will be loaded here -->
            </div>
        </div>
    </div>

    <!-- Rental Duration Modal -->
    <div class="options-modal" id="rental-duration-modal">
        <div class="options-container">
            <div class="options-header">
                <h3 class="options-title" id="rental-duration-title">Rental Duration</h3>
                <button class="close-options" id="close-rental-duration">×</button>
            </div>
            <div class="options-content">
                <div class="rental-details">
                    <h4 class="rental-details-title" id="rental-option-title">Daily Rental</h4>
                    <div class="rental-details-info">
                        <span class="rental-details-label">Price per day:</span>
                        <span class="rental-details-value" id="price-per-unit">$10.00/day</span>
                    </div>
                    <div class="form-group">
                        <label class="duration-label" id="duration-label">How many days would you like to rent?</label>
                        <input type="number" min="1" value="1" class="duration-input" id="duration-input">
                    </div>
                    <div class="rental-total">
                        <span>Total:</span>
                        <span id="rental-total-amount">$10.00</span>
                    </div>
                    <div class="rental-total-coins" id="rental-total-coins">$10.00 = 100 coins</div>
                </div>
            </div>
            <div class="options-footer">
                <button class="btn-option btn-back" id="rental-duration-back">Back</button>
                <button class="btn-option btn-continue" id="confirm-rental">Confirm Rental</button>
            </div>
        </div>
    </div>

    <!-- Checkout Form Modal -->
    <div class="options-modal" id="checkout-modal">
        <div class="options-container">
            <div class="options-header">
                <h3 class="options-title">Complete Your Purchase</h3>
                <button class="close-options" id="close-checkout">×</button>
            </div>
            <div class="checkout-form">
                <div class="form-group">
                    <label class="form-label">Full Name</label>
                    <input type="text" class="form-input" id="name-input">
                </div>
                <div class="form-group">
                    <label class="form-label">Email Address</label>
                    <input type="email" class="form-input" id="email-input">
                </div>
                <div class="form-group">
                    <label class="form-label">Special Instructions</label>
                    <textarea class="form-input" id="instructions" rows="3"></textarea>
                </div>
            </div>
            <div class="options-footer">
                <button class="btn-option btn-back" id="checkout-back">Back</button>
                <button class="btn-option btn-continue" id="checkout-submit">Submit Order</button>
            </div>
        </div>
    </div>

    <script>
        // Extensive DigitalAsset Data
        const digitalassets = [
            {
                id: 1,
                title: "E-Commerce Platform",
                description: "Complete e-commerce solution with product pages, cart, checkout, and admin dashboard. Built with React and Node.js. Includes payment integration and inventory management.",
                type: "website",
                subType: "ecommerce",
                price: 799,
                oldPrice: 999,
                rentPrice: 49,
                rentPeriod: "month",
                rating: 4.5,
                reviews: 24,
                media: [
                    { type: "image", url: "https://images.unsplash.com/photo-1555529669-e69e7aa0ba9a?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" },
                    { type: "image", url: "https://images.unsplash.com/photo-1486401899868-0e435ed85128?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" },
                    { type: "video", url: "https://example.com/videos/ecommerce-demo.mp4", thumbnail: "https://images.unsplash.com/photo-1555529669-e69e7aa0ba9a?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" }
                ],
                badge: "BESTSELLER",
                details: "This e-commerce platform comes with everything you need to start selling online. It includes a responsive design that works on all devices, secure payment processing, product management, order tracking, and customer accounts. The admin dashboard allows you to manage inventory, process orders, and view sales analytics.",
                features: [
                    "Responsive design for all devices",
                    "Secure payment processing",
                    "Product management system",
                    "Order tracking",
                    "Customer accounts",
                    "Admin dashboard",
                    "Sales analytics",
                    "SEO optimized"
                ],
                license: {
                    rental: "Monthly subscription includes updates and basic support. Cancel anytime.",
                    purchase: "One-time payment includes 1 year of updates and support. Source code included."
                }
            },
            {
                id: 2,
                title: "Portfolio Showcase",
                description: "Modern portfolio template for creatives with smooth animations and responsive design. Perfect for photographers, designers, and artists.",
                type: "template",
                subType: "html",
                price: 49,
                oldPrice: 79,
                rentPrice: 9,
                rentPeriod: "month",
                rating: 4.8,
                reviews: 42,
                media: [
                    { type: "image", url: "https://images.unsplash.com/photo-1499678329028-101435549a4e?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" },
                    { type: "image", url: "https://images.unsplash.com/photo-1499951360447-b19be8fe80f5?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" }
                ],
                badge: "NEW",
                details: "Showcase your creative work with this elegant portfolio template. It features smooth animations, responsive design, and multiple layout options. The template is easy to customize with your own content and comes with documentation to help you get started quickly.",
                features: [
                    "Smooth animations",
                    "Responsive design",
                    "Multiple layout options",
                    "Easy customization",
                    "Documentation included",
                    "Light/dark mode",
                    "Contact form",
                    "Social media integration"
                ],
                license: {
                    rental: "Monthly subscription includes access to all template features and updates.",
                    purchase: "One-time payment includes lifetime use and 6 months of updates."
                }
            },
            {
                id: 3,
                title: "Restaurant Website",
                description: "Beautiful restaurant website with menu, reservation system, gallery, and contact form. Ready to deploy with your content.",
                type: "website",
                subType: "business",
                price: 449,
                oldPrice: 599,
                rentPrice: 39,
                rentPeriod: "month",
                rating: 4.3,
                reviews: 18,
                media: [
                    { type: "image", url: "https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" },
                    { type: "image", url: "https://images.unsplash.com/photo-1555396273-367ea4eb4db5?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" },
                    { type: "video", url: "https://example.com/videos/restaurant-demo.mp4", thumbnail: "https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" }
                ],
                details: "This restaurant website template includes all the essential features for a food business. It has an elegant design that showcases your menu items beautifully, an online reservation system, photo gallery, and contact form. The website is optimized for speed and mobile devices.",
                features: [
                    "Online reservation system",
                    "Menu display",
                    "Photo gallery",
                    "Contact form",
                    "Mobile optimized",
                    "Google Maps integration",
                    "Opening hours display",
                    "Special offers section"
                ],
                license: {
                    rental: "Monthly subscription includes hosting and maintenance.",
                    purchase: "One-time payment includes source code and 1 year of support."
                }
            },
            {
                id: 4,
                title: "Social Media Dashboard",
                description: "Comprehensive dashboard for managing multiple social media accounts with analytics and scheduling.",
                type: "app",
                subType: "webapp",
                price: 299,
                oldPrice: 399,
                rentPrice: 29,
                rentPeriod: "month",
                rating: 4.6,
                reviews: 35,
                media: [
                    { type: "image", url: "https://images.unsplash.com/photo-1551288049-bebda4e38f71?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" },
                    { type: "image", url: "https://images.unsplash.com/photo-1460925895917-afdab827c52f?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" }
                ],
                badge: "POPULAR",
                details: "Manage all your social media accounts from one place with this powerful dashboard. Schedule posts, track engagement, and analyze performance across platforms. The intuitive interface makes it easy to manage your social media presence efficiently.",
                features: [
                    "Multi-platform integration",
                    "Post scheduling",
                    "Analytics dashboard",
                    "Engagement tracking",
                    "Team collaboration",
                    "Content calendar",
                    "Performance reports",
                    "Mobile responsive"
                ],
                license: {
                    rental: "Monthly subscription includes all features and regular updates.",
                    purchase: "One-time payment includes source code and 6 months of support."
                }
            },
            {
                id: 5,
                title: "Fitness Mobile App",
                description: "Complete fitness app with workout plans, nutrition tracking, and progress analytics for iOS and Android.",
                type: "app",
                subType: "mobile",
                price: 599,
                oldPrice: 799,
                rentPrice: 49,
                rentPeriod: "month",
                rating: 4.7,
                reviews: 28,
                media: [
                    { type: "image", url: "https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" },
                    { type: "image", url: "https://images.unsplash.com/photo-1571019614242-c5c5dee9f50b?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" }
                ],
                details: "This comprehensive fitness app helps users track their workouts, nutrition, and progress. It includes customizable workout plans, exercise demonstrations, meal planning, and progress tracking. The app is built with React Native for cross-platform compatibility.",
                features: [
                    "Custom workout plans",
                    "Exercise library",
                    "Nutrition tracking",
                    "Progress analytics",
                    "Meal planning",
                    "Water intake tracking",
                    "Dark mode",
                    "Offline functionality"
                ],
                license: {
                    rental: "Monthly subscription includes all features and regular updates.",
                    purchase: "One-time payment includes source code and 1 year of support."
                }
            },
            {
                id: 6,
                title: "WordPress SEO Plugin",
                description: "Advanced SEO plugin for WordPress with keyword optimization, content analysis, and schema markup.",
                type: "plugin",
                subType: "wordpress-plugin",
                price: 129,
                oldPrice: 199,
                rentPrice: 15,
                rentPeriod: "month",
                rating: 4.9,
                reviews: 56,
                media: [
                    { type: "image", url: "https://images.unsplash.com/photo-1547658719-da2b51169166?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" },
                    { type: "image", url: "https://images.unsplash.com/photo-1559028012-481c04fa702d?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" }
                ],
                badge: "BESTSELLER",
                details: "Boost your WordPress site's search engine rankings with this powerful SEO plugin. It provides comprehensive tools for keyword optimization, content analysis, schema markup, and performance tracking. The plugin is regularly updated to follow the latest SEO best practices.",
                features: [
                    "Keyword optimization",
                    "Content analysis",
                    "Schema markup",
                    "XML sitemaps",
                    "Social media integration",
                    "Performance tracking",
                    "Readability analysis",
                    "Bulk editing"
                ],
                license: {
                    rental: "Monthly subscription includes updates and support.",
                    purchase: "One-time payment includes lifetime updates for one site."
                }
            },
            {
                id: 7,
                title: "Premium UI Kit",
                description: "Comprehensive UI kit with 100+ components for modern web applications. Includes buttons, forms, cards, and more.",
                type: "ui-kit",
                price: 99,
                oldPrice: 149,
                rentPrice: null, // Not rentable
                rentPeriod: null,
                rating: 4.7,
                reviews: 32,
                media: [
                    { type: "image", url: "https://images.unsplash.com/photo-1551650975-87deedd944c3?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" }
                ],
                details: "This premium UI kit includes everything you need to build modern web applications. With over 100 components, you'll have access to beautifully designed buttons, forms, cards, modals, and more. The kit is fully customizable and comes with detailed documentation.",
                features: [
                    "100+ components",
                    "Fully customizable",
                    "Dark/light mode",
                    "Responsive design",
                    "Detailed documentation",
                    "Regular updates",
                    "SVG icons included",
                    "Easy to implement"
                ],
                license: {
                    rental: "This product is not available for rental.",
                    purchase: "One-time payment includes lifetime updates and use on unlimited projects."
                }
            },
            {
                id: 8,
                title: "Video Editing Template",
                description: "Professional video editing template for Premiere Pro with customizable transitions and effects.",
                type: "template",
                subType: "premiere",
                price: null, // Not buyable
                oldPrice: null,
                rentPrice: 19,
                rentPeriod: "month",
                rating: 4.4,
                reviews: 21,
                media: [
                    { type: "image", url: "https://images.unsplash.com/photo-1579373903781-fd5c0c30c4cd?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" },
                    { type: "video", url: "https://example.com/videos/premiere-template.mp4", thumbnail: "https://images.unsplash.com/photo-1579373903781-fd5c0c30c4cd?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" }
                ],
                details: "This professional video editing template for Premiere Pro includes customizable transitions, effects, and title animations. Perfect for content creators looking to enhance their videos with professional-grade effects without the steep learning curve.",
                features: [
                    "10 customizable transitions",
                    "5 title animations",
                    "Color grading presets",
                    "Easy to customize",
                    "Works with Premiere Pro CC+",
                    "Regular updates",
                    "Detailed tutorial",
                    "Royalty-free use"
                ],
                license: {
                    rental: "Monthly subscription includes access to all template features and updates.",
                    purchase: "This product is only available for rental."
                }
            },
            {
                id: 9,
                title: "Enterprise CRM System",
                description: "Complete customer relationship management solution for large businesses with sales automation and analytics.",
                type: "app",
                subType: "webapp",
                price: 2500000,
                oldPrice: 3000000,
                rentPrice: 25000,
                rentPeriod: "month",
                rating: 4.9,
                reviews: 89,
                media: [
                    { type: "image", url: "https://images.unsplash.com/photo-1551288049-bebda4e38f71?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" }
                ],
                badge: "PREMIUM",
                details: "This enterprise-grade CRM system helps large businesses manage customer relationships, sales pipelines, and marketing campaigns. It includes advanced analytics, AI-powered recommendations, and integration with popular business tools.",
                features: [
                    "Sales pipeline management",
                    "Customer segmentation",
                    "Marketing automation",
                    "AI-powered recommendations",
                    "Advanced analytics",
                    "Custom reporting",
                    "API integrations",
                    "Role-based access control"
                ],
                license: {
                    rental: "Monthly subscription includes all features, support, and updates.",
                    purchase: "One-time payment includes source code and 5 years of support."
                }
            },
            {
                id: 10,
                title: "Blockchain Exchange Platform",
                description: "Complete cryptocurrency exchange platform with wallet integration and trading engine.",
                type: "app",
                subType: "webapp",
                price: 5000000,
                oldPrice: 6000000,
                rentPrice: null,
                rentPeriod: null,
                rating: 4.8,
                reviews: 42,
                media: [
                    { type: "image", url: "https://images.unsplash.com/photo-1621761191319-c6fb62004040?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" }
                ],
                details: "This complete cryptocurrency exchange platform includes a high-performance trading engine, wallet integration, KYC/AML compliance tools, and admin dashboard. Built with security as the top priority.",
                features: [
                    "High-performance trading engine",
                    "Multi-currency wallet",
                    "KYC/AML compliance",
                    "Admin dashboard",
                    "Security monitoring",
                    "API for developers",
                    "Liquidity management",
                    "Multi-language support"
                ],
                license: {
                    rental: "This product is not available for rental.",
                    purchase: "One-time payment includes source code and 3 years of support."
                }
            },
            {
                id: 11,
                title: "AI Content Generator",
                description: "Advanced AI-powered content generation tool for marketers and content creators.",
                type: "app",
                subType: "webapp",
                price: 1500000,
                oldPrice: 2000000,
                rentPrice: 15000,
                rentPeriod: "month",
                rating: 4.7,
                reviews: 56,
                media: [
                    { type: "image", url: "https://images.unsplash.com/photo-1620712943543-bcc4688e7485?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" }
                ],
                badge: "HOT",
                details: "This AI-powered content generator helps marketers and content creators produce high-quality articles, product descriptions, and marketing copy in seconds. It learns from your brand voice and improves over time.",
                features: [
                    "AI-powered content generation",
                    "Brand voice customization",
                    "SEO optimization",
                    "Content templates",
                    "Plagiarism checker",
                    "Multi-language support",
                    "Team collaboration",
                    "API access"
                ],
                license: {
                    rental: "Monthly subscription includes all features and regular updates.",
                    purchase: "One-time payment includes source code and 2 years of support."
                }
            },
            {
                id: 12,
                title: "E-Learning Platform",
                description: "Complete online learning management system with course builder and student management.",
                type: "website",
                subType: "ecommerce",
                price: 1200000,
                oldPrice: 1500000,
                rentPrice: 12000,
                rentPeriod: "month",
                rating: 4.8,
                reviews: 67,
                media: [
                    { type: "image", url: "https://images.unsplash.com/photo-1546410531-bb4caa6b424d?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" }
                ],
                details: "This comprehensive e-learning platform includes everything you need to create, sell, and manage online courses. It features a course builder, student management, quizzes, certificates, and payment integration.",
                features: [
                    "Drag-and-drop course builder",
                    "Student management",
                    "Quizzes and assessments",
                    "Certificates",
                    "Payment integration",
                    "Drip content",
                    "Discussion forums",
                    "Mobile responsive"
                ],
                license: {
                    rental: "Monthly subscription includes hosting and support.",
                    purchase: "One-time payment includes source code and 3 years of support."
                }
            }
        ];

        // Sample comments data
        const sampleComments = [
            {
                id: 1,
                author: "Alex Johnson",
                date: "2 days ago",
                text: "This digital asset exceeded my expectations! The quality is amazing and it was exactly what I needed for my project.",
                rating: 5
            },
            {
                id: 2,
                author: "Sarah Miller",
                date: "1 week ago",
                text: "Very good digital asset but the documentation could be more detailed. Overall I'm satisfied with my purchase.",
                rating: 4
            },
            {
                id: 3,
                author: "Michael Chen",
                date: "3 weeks ago",
                text: "Excellent digital asset with great support. The team helped me with customization and answered all my questions quickly.",
                rating: 5
            }
        ];

        // Purchase options data
        const purchaseOptions = [
            {
                id: "source",
                title: "Buy Source Code",
                description: "Get full access to the source code and documentation to deploy on your own servers.",
                price: 4990
            },
            {
                id: "hosting",
                title: "Buy + Hosting Package",
                description: "We'll host the digital asset for you with premium support and automatic updates.",
                price: 6990,
                badge: "Save 15%"
            },
            {
                id: "enterprise",
                title: "Enterprise License",
                description: "Unlimited usage across your organization with priority support and customization options.",
                price: 14970
            },
            {
                id: "whitelabel",
                title: "White Label Solution",
                description: "Rebrand the digital asset as your own and resell to your clients.",
                price: 24950
            }
        ];

        // Rental options data
        const rentalOptions = [
            {
                id: "daily",
                title: "Daily Rental",
                description: "Standard rental with basic support and documentation.",
                price: 10,
                period: "day",
                unit: "day"
            },
            {
                id: "weekly",
                title: "Weekly Rental",
                description: "Includes priority support and access to premium features.",
                price: 16,
                period: "week",
                unit: "week"
            },
            {
                id: "monthly",
                title: "Monthly Rental",
                description: "Includes priority support and access to premium features.",
                price: 22,
                period: "month",
                unit: "month"
            },
            {
                id: "yearly",
                title: "Yearly Rental",
                description: "Best value with full support and all features included.",
                price: 200,
                period: "year",
                unit: "year"
            }
        ];

        // DOM Elements
        const digitalassetsGrid = document.getElementById('digitalassets-grid');
        const digitalassetsGridMobile = document.getElementById('digitalassets-grid-mobile');
        const searchInput = document.getElementById('search-input');
        const searchInputMobile = document.getElementById('search-input-mobile');
        const digitalassetDetailModal = document.getElementById('digitalasset-detail-modal');
        const closeDetail = document.getElementById('close-detail');
        const detailType = document.getElementById('detail-type');
        const detailTitle = document.getElementById('detail-title');
        const detailDescription = document.getElementById('detail-description');
        const detailStars = document.getElementById('detail-stars');
        const detailReviewCount = document.getElementById('detail-review-count');
        const btnFavorite = document.getElementById('btn-favorite');
        const btnPreview = document.getElementById('btn-preview');
        const btnRent = document.getElementById('btn-rent');
        const btnBuy = document.getElementById('btn-buy');
        const mainGallery = document.getElementById('main-gallery');
        const galleryThumbnails = document.getElementById('gallery-thumbnails');
        const commentList = document.getElementById('comment-list');
        const tabBtns = document.querySelectorAll('.tab-btn');
        const tabContents = document.querySelectorAll('.tab-content');
        const licenseInfo = document.getElementById('license-info');
        const hashtagsContainer = document.getElementById('hashtags');
        const notification = document.getElementById('notification');
        const notificationMessage = document.querySelector('.notification-message');
        const noResults = document.getElementById('no-results');
        const submitReviewBtn = document.getElementById('submit-review');
        const sponsoredDigitalassets = document.getElementById('sponsored-digitalassets');
        const featuredDigitalassets = document.getElementById('featured-digitalassets');
        const suggestedDigitalassets = document.getElementById('suggested-digitalassets');
        const sponsoredSection = document.getElementById('sponsored-section');
        const featuredSection = document.getElementById('featured-section');
        const suggestedSection = document.getElementById('suggested-section');
        const detailBuyPrice = document.getElementById('detail-buy-price');
        const detailRentPrice = document.getElementById('detail-rent-price');
        const categoriesDropdown = document.querySelector('.categories-dropdown');
        const categoriesBtn = document.querySelector('.categories-btn');

        // Modals
        const purchaseOptionsModal = document.getElementById('purchase-options-modal');
        const rentalOptionsModal = document.getElementById('rental-options-modal');
        const rentalDurationModal = document.getElementById('rental-duration-modal');
        const checkoutModal = document.getElementById('checkout-modal');
        const closePurchase = document.getElementById('close-purchase');
        const closeRental = document.getElementById('close-rental');
        const closeRentalDuration = document.getElementById('close-rental-duration');
        const closeCheckout = document.getElementById('close-checkout');
        const purchaseOptionsContainer = document.getElementById('purchase-options');
        const rentalOptionsContainer = document.getElementById('rental-options');
        const purchaseBackBtn = document.getElementById('purchase-back');
        const rentalBackBtn = document.getElementById('rental-duration-back');
        const checkoutBackBtn = document.getElementById('checkout-back');
        const confirmRentalBtn = document.getElementById('confirm-rental');
        const purchaseContinueBtn = document.getElementById('purchase-continue');
        const checkoutSubmitBtn = document.getElementById('checkout-submit');
        const durationInput = document.getElementById('duration-input');
        const purchaseTitle = document.getElementById('purchase-title');
        const rentalTitle = document.getElementById('rental-title');
        const rentalDurationTitle = document.getElementById('rental-duration-title');
        const rentalOptionTitle = document.getElementById('rental-option-title');
        const pricePerUnit = document.getElementById('price-per-unit');
        const rentalTotalAmount = document.getElementById('rental-total-amount');
        const rentalTotalCoins = document.getElementById('rental-total-coins');
        const durationLabel = document.getElementById('duration-label');

        // Review stars
        const reviewStars = document.getElementById('review-stars');

        // State variables
        let favorites = JSON.parse(localStorage.getItem('favorites')) || [];
        let currentDigitalasset = null;
        let selectedRentalOption = null;
        let selectedPurchaseOption = null;
        let currentRating = 0;
        let currentComments = [...sampleComments];
        let currentMediaIndex = 0;
        let touchStartX = 0;
        let touchEndX = 0;

        // Initialize the page
        document.addEventListener('DOMContentLoaded', () => {
            renderDigitalAssets(digitalassets);
            setupEventListeners();
            setupReviewStars();
            setupSubCategories();
        });

        // Format price for display
        function formatPrice(price) {
            if (price === null || price === undefined) return '';

            if (price < 1000) {
                return `$${price.toFixed(2)}`;
            } else if (price < 10000) {
                return `$${(price/1000).toFixed(1)}k`;
            } else if (price < 1000000) {
                return `$${Math.round(price/1000)}k`;
            } else if (price < 10000000) {
                return `$${(price/1000000).toFixed(2)}M`;
            } else if (price < 1000000000) {
                return `$${Math.round(price/1000000)}M`;
            } else {
                return `$${(price/1000000000).toFixed(1)}B`;
            }
        }

        // Format price with full decimals for detail view
        function formatPriceFull(price) {
            if (price === null || price === undefined) return '';
            return new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: 'USD',
                minimumFractionDigits: 2
            }).format(price);
        }

        // Convert dollars to coins (1 dollar = 100 coins)
        function dollarsToCoins(dollars) {
            return Math.round(dollars * 100);
        }

        // Format coins for display
        function formatCoins(coins) {
            return new Intl.NumberFormat('en-US').format(coins) + ' coins';
        }

        // Render all digitalassets
        function renderDigitalAssets(digitalassetsToRender) {
            // Clear both grids
            digitalassetsGrid.innerHTML = '';
            if (digitalassetsGridMobile) {
                digitalassetsGridMobile.innerHTML = '';
            }

            if (digitalassetsToRender.length === 0) {
                noResults.style.display = 'flex';
                const noResultsMobile = document.getElementById('no-results-mobile');
                if (noResultsMobile) {
                    noResultsMobile.style.display = 'flex';
                }
                return;
            }

            noResults.style.display = 'none';
            const noResultsMobile = document.getElementById('no-results-mobile');
            if (noResultsMobile) {
                noResultsMobile.style.display = 'none';
            }

            digitalassetsToRender.forEach(digitalasset => {
                const digitalassetCard = createDigitalAssetCard(digitalasset);
                const digitalassetCardMobile = createDigitalAssetCard(digitalasset);
                
                digitalassetsGrid.appendChild(digitalassetCard);
                if (digitalassetsGridMobile) {
                    digitalassetsGridMobile.appendChild(digitalassetCardMobile);
                }
            });
        }

        // Create digitalasset card HTML
        function createDigitalAssetCard(digitalasset) {
            const card = document.createElement('div');
            card.className = 'digitalasset-card';
            card.dataset.id = digitalasset.id;
            card.dataset.type = digitalasset.type;
            if (digitalasset.subType) {
                card.dataset.subtype = digitalasset.subType;
            }

            let badgeHTML = '';
            if (digitalasset.badge) {
                badgeHTML = `<span class="digitalasset-badge">${digitalasset.badge}</span>`;
            }

            // Determine media type (use first media item for card)
            const primaryMedia = digitalasset.media[0];
            let mediaHTML = '';
            if (primaryMedia.type === 'video') {
                mediaHTML = `<video src="${primaryMedia.url}" poster="${primaryMedia.thumbnail}" muted loop></video>`;
            } else {
                mediaHTML = `<img src="${primaryMedia.url}" alt="${digitalasset.title}">`;
            }

            // Create stars HTML
            const starsHTML = createStarsHTML(digitalasset.rating);

            // Check if digitalasset is favorite
            const isFavorite = favorites.includes(digitalasset.id);

            // Create price badges
            let priceBadgesHTML = '';
            if (digitalasset.price !== null) {
                priceBadgesHTML += `<span class="price-badge buy">${formatPrice(digitalasset.price)}</span>`;
            }
            if (digitalasset.rentPrice !== null) {
                priceBadgesHTML += `<span class="price-badge rent">${formatPrice(digitalasset.rentPrice)}</span>`;
            }

            card.innerHTML = `
                ${badgeHTML}
                <div class="digitalasset-media">
                    ${mediaHTML}
                </div>
                <div class="digitalasset-info">
                    <div class="digitalasset-type">
                        ${digitalasset.type.toUpperCase()}
                        ${priceBadgesHTML ? `<div class="price-badges">${priceBadgesHTML}</div>` : ''}
                    </div>
                    <h3 class="digitalasset-title">${digitalasset.title}</h3>
                    <p class="digitalasset-description">${digitalasset.description}</p>
                    <div class="digitalasset-footer">
                        <div class="seller-avatar-container">
                            <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&auto=format&fit=crop&w=100&q=80" alt="Seller" class="seller-avatar">
                            ${Math.random() > 0.5 ? '<div class="verification-badge"></div>' : ''}
                        </div>
                        <div class="digitalasset-rating">
                            ${starsHTML}
                            <span>(${digitalasset.reviews})</span>
                        </div>
                        <button class="favorite-btn ${isFavorite ? 'active' : ''}" data-id="${digitalasset.id}">
                            ${isFavorite ? '♥' : '♡'}
                        </button>
                    </div>
                </div>
            `;

            // Add click event to show digitalasset details
            card.addEventListener('click', (e) => {
                if (!e.target.closest('.favorite-btn')) {
                    showDigitalAssetDetail(digitalasset);
                }
            });

            // Add favorite event
            const favBtn = card.querySelector('.favorite-btn');
            favBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                toggleFavorite(digitalasset, favBtn);
            });

            return card;
        }

        // Create related digitalasset card HTML
        function createRelatedDigitalAssetCard(digitalasset) {
            const card = document.createElement('div');
            card.className = 'related-digitalasset-card';
            card.dataset.id = digitalasset.id;

            // Determine media type (use first media item for card)
            const primaryMedia = digitalasset.media[0];
            let mediaHTML = '';
            if (primaryMedia.type === 'video') {
                mediaHTML = `<video src="${primaryMedia.url}" poster="${primaryMedia.thumbnail}" muted loop></video>`;
            } else {
                mediaHTML = `<img src="${primaryMedia.url}" alt="${digitalasset.title}">`;
            }

            // Create price badges
            let priceBadgesHTML = '';
            if (digitalasset.price !== null) {
                priceBadgesHTML += `<span class="price-badge buy">${formatPrice(digitalasset.price)}</span>`;
            }
            if (digitalasset.rentPrice !== null) {
                priceBadgesHTML += `<span class="price-badge rent">${formatPrice(digitalasset.rentPrice)}</span>`;
            }

            card.innerHTML = `
                <div class="related-digitalasset-media">
                    ${mediaHTML}
                </div>
                <div class="related-digitalasset-info">
                    <h3 class="related-digitalasset-title">${digitalasset.title}</h3>
                    ${priceBadgesHTML ? `<div class="price-badges">${priceBadgesHTML}</div>` : ''}
                </div>
            `;

            card.addEventListener('click', () => {
                showDigitalAssetDetail(digitalasset);
                // Scroll to top of detail modal
                digitalassetDetailModal.scrollTo(0, 0);
            });

            return card;
        }

        // Toggle favorite status
        function toggleFavorite(digitalasset, btn) {
            const index = favorites.indexOf(digitalasset.id);
            const isFavorite = index !== -1;

            if (isFavorite) {
                favorites.splice(index, 1);
                btn.classList.remove('active');
                btn.innerHTML = '♡';
                showNotification(`${digitalasset.title} removed from favorites`);
            } else {
                favorites.push(digitalasset.id);
                btn.classList.add('active');
                btn.innerHTML = '♥';
                showNotification(`${digitalasset.title} added to favorites`);
            }

            localStorage.setItem('favorites', JSON.stringify(favorites));
        }

        // Show notification
        function showNotification(message) {
            notificationMessage.textContent = message;
            notification.classList.add('show');

            setTimeout(() => {
                notification.classList.remove('show');
            }, 3000);
        }

        // Create stars HTML based on rating
        function createStarsHTML(rating) {
            const fullStars = Math.floor(rating);
            const hasHalfStar = rating % 1 >= 0.5;
            let starsHTML = '';

            // Add full stars
            for (let i = 0; i < fullStars; i++) {
                starsHTML += '<span class="star">★</span>';
            }

            // Add half star if needed
            if (hasHalfStar) {
                starsHTML += '<span class="star">☆</span>';
            }

            // Add empty stars
            const emptyStars = 5 - fullStars - (hasHalfStar ? 1 : 0);
            for (let i = 0; i < emptyStars; i++) {
                starsHTML += '<span class="star">☆</span>';
            }

            return starsHTML;
        }

        // Show digitalasset detail modal
        function showDigitalAssetDetail(digitalasset) {
            currentDigitalasset = digitalasset;
            currentMediaIndex = 0;

            // Set basic digitalasset info
            detailType.textContent = digitalasset.type.toUpperCase();

            // Create price badges for detail title
            let priceBadgesHTML = '';
            if (digitalasset.price !== null) {
                priceBadgesHTML += `<span class="detail-price-badge buy">${formatPriceFull(digitalasset.price)}</span>`;
            }
            if (digitalasset.rentPrice !== null) {
                priceBadgesHTML += `<span class="detail-price-badge rent">${formatPriceFull(digitalasset.rentPrice)}</span>`;
            }

            detailTitle.innerHTML = `
                ${digitalasset.title}
                ${priceBadgesHTML ? `<div class="price-badges">${priceBadgesHTML}</div>` : ''}
            `;

            detailDescription.textContent = digitalasset.description;

            // Set rating
            detailStars.innerHTML = createStarsHTML(digitalasset.rating);
            detailReviewCount.textContent = `(${digitalasset.reviews} reviews)`;

            // Set favorite button state
            const isFavorite = favorites.includes(digitalasset.id);
            btnFavorite.classList.toggle('active', isFavorite);
            btnFavorite.innerHTML = isFavorite ? '♥ Added to Favorites' : '♥ Add to Favorites';

            // Show/hide rent and buy buttons based on availability
            btnRent.style.display = digitalasset.rentPrice !== null ? 'flex' : 'none';
            btnBuy.style.display = digitalasset.price !== null ? 'flex' : 'none';

            // Generate hashtags
            generateHashtags(digitalasset);

            // Clear previous gallery
            mainGallery.innerHTML = '';
            galleryThumbnails.innerHTML = '';

            // Create gallery
            digitalasset.media.forEach((media, index) => {
                if (index === 0) {
                    // Main media
                    if (media.type === 'video') {
                        mainGallery.innerHTML = `
                            <video src="${media.url}" autoplay muted loop controls></video>
                        `;
                    } else {
                        mainGallery.innerHTML = `
                            <img src="${media.url}" alt="${digitalasset.title}">
                        `;
                    }
                }

                // Thumbnails
                const thumbnail = document.createElement('div');
                thumbnail.className = `thumbnail ${index === 0 ? 'active' : ''}`;
                thumbnail.dataset.index = index;

                if (media.type === 'video') {
                    thumbnail.innerHTML = `
                        <video src="${media.url}" poster="${media.thumbnail}" muted></video>
                    `;
                } else {
                    thumbnail.innerHTML = `
                        <img src="${media.url}" alt="${digitalasset.title}">
                    `;
                }

                thumbnail.addEventListener('click', () => {
                    currentMediaIndex = index;
                    updateMainGallery(digitalasset);
                    // Update active thumbnail
                    document.querySelectorAll('.thumbnail').forEach(t => t.classList.remove('active'));
                    thumbnail.classList.add('active');
                });

                galleryThumbnails.appendChild(thumbnail);
            });

            // Set tab content
            document.getElementById('tab-details').innerHTML = `
                <p>${digitalasset.details}</p>
            `;

            let featuresHTML = '';
            digitalasset.features.forEach(feature => {
                featuresHTML += `<li>${feature}</li>`;
            });

            document.getElementById('tab-features').innerHTML = `
                <ul class="features-list">
                    ${featuresHTML}
                </ul>
            `;

            // Set license info
            licenseInfo.innerHTML = `
                <p><strong>Rental License:</strong> ${digitalasset.license.rental}</p>
                <p><strong>Purchase License:</strong> ${digitalasset.license.purchase}</p>
            `;

            // Set comments
            renderComments();

            // Render featured and suggested digitalassets
            renderSponsoredDigitalAssets();
            renderFeaturedDigitalAssets();
            renderSuggestedDigitalAssets();

            // Show/hide featured/suggested sections based on content
            const featuredCount = Math.min(4, digitalassets.filter(da => da.id !== digitalasset.id).length);
            const suggestedCount = Math.min(4, digitalassets.filter(da => da.id !== digitalasset.id && da.type === digitalasset.type).length);

            sponsoredSection.style.display = featuredCount > 0 ? 'block' : 'none';
            featuredSection.style.display = featuredCount > 0 ? 'block' : 'none';
            suggestedSection.style.display = suggestedCount > 0 ? 'block' : 'none';

            // Set digitalasset ID on container for actions
            document.querySelector('.digitalasset-detail-container').dataset.id = digitalasset.id;

            // Show modal
            digitalassetDetailModal.style.display = 'block';
            document.body.style.overflow = 'hidden';

            // Setup swipe events for main gallery
            setupSwipeEvents(digitalasset);
        }

        // Update main gallery with current media
        function updateMainGallery(digitalasset) {
            const media = currentDigitalasset.media[currentMediaIndex];
            mainGallery.innerHTML = media.type === 'video' ?
                `<video src="${media.url}" autoplay muted loop controls></video>` :
                `<img src="${media.url}" alt="${digitalasset.title}">`;
        }

        // Setup swipe events for main gallery
        function setupSwipeEvents(digitalasset) {
            mainGallery.addEventListener('touchstart', (e) => {
                touchStartX = e.changedTouches[0].screenX;
            }, false);

            mainGallery.addEventListener('touchend', (e) => {
                touchEndX = e.changedTouches[0].screenX;
                handleSwipe(digitalasset);
            }, false);
        }

        // Handle swipe gesture
        function handleSwipe(digitalasset) {
            const threshold = 50; // Minimum swipe distance
            const diff = touchStartX - touchEndX;

            if (diff > threshold) {
                // Swipe left - next image
                currentMediaIndex = (currentMediaIndex + 1) % digitalasset.media.length;
            } else if (diff < -threshold) {
                // Swipe right - previous image
                currentMediaIndex = (currentMediaIndex - 1 + digitalasset.media.length) % digitalasset.media.length;
            } else {
                return; // Not a significant swipe
            }

            updateMainGallery(digitalasset);

            // Update active thumbnail
            document.querySelectorAll('.thumbnail').forEach(t => t.classList.remove('active'));
            document.querySelector(`.thumbnail[data-index="${currentMediaIndex}"]`).classList.add('active');
        }

        // Render sponsored digitalassets
        function renderSponsoredDigitalAssets() {
            sponsoredDigitalassets.innerHTML = '';
            // Get 4 random digitalassets (excluding current one)
            const sponsored = digitalassets
                .filter(da => da.id !== currentDigitalasset.id)
                .sort(() => 0.5 - Math.random())
                .slice(0, 4);

            sponsored.forEach(digitalasset => {
                const card = createRelatedDigitalAssetCard(digitalasset);
                sponsoredDigitalassets.appendChild(card);
            });
        }

        // Render featured digitalassets
        function renderFeaturedDigitalAssets() {
            featuredDigitalassets.innerHTML = '';
            // Get 4 random digitalassets (excluding current one)
            const featured = digitalassets
                .filter(da => da.id !== currentDigitalasset.id)
                .sort(() => 0.5 - Math.random())
                .slice(0, 4);

            featured.forEach(digitalasset => {
                const card = createRelatedDigitalAssetCard(digitalasset);
                featuredDigitalassets.appendChild(card);
            });
        }

        // Render suggested digitalassets
        function renderSuggestedDigitalAssets() {
            suggestedDigitalassets.innerHTML = '';
            // Get digitalassets of same type (excluding current one)
            const suggested = digitalassets
                .filter(da => da.id !== currentDigitalasset.id && da.type === currentDigitalasset.type)
                .sort(() => 0.5 - Math.random())
                .slice(0, 4);

            suggested.forEach(digitalasset => {
                const card = createRelatedDigitalAssetCard(digitalasset);
                suggestedDigitalassets.appendChild(card);
            });
        }

        // Render comments
        function renderComments() {
            commentList.innerHTML = '';
            currentComments.forEach(comment => {
                const commentEl = document.createElement('div');
                commentEl.className = 'comment';
                commentEl.innerHTML = `
                    <div class="comment-header">
                        <span class="comment-author">${comment.author}</span>
                        <span class="comment-date">${comment.date}</span>
                    </div>
                    <div class="comment-rating">
                        ${createStarsHTML(comment.rating)}
                    </div>
                    <p class="comment-text">${comment.text}</p>
                `;
                commentList.appendChild(commentEl);
            });
        }

        // Generate hashtags for digitalasset
        function generateHashtags(digitalasset) {
            hashtagsContainer.innerHTML = '';

            // Create hashtags based on digitalasset type and title
            const hashtags = [
                `#${digitalasset.type}`,
                `#${digitalasset.title.replace(/\s+/g, '')}`,
                '#digitalasset',
                '#premium',
                '#code'
            ];

            if (digitalasset.subType) {
                hashtags.push(`#${digitalasset.subType}`);
            }

            hashtags.forEach(tag => {
                const span = document.createElement('span');
                span.className = 'hashtag';
                span.textContent = tag;
                hashtagsContainer.appendChild(span);
            });
        }

        // Setup review stars
        function setupReviewStars() {
            const stars = reviewStars.querySelectorAll('.rating-star');

            stars.forEach((star, index) => {
                star.addEventListener('click', () => {
                    // Reset all stars
                    stars.forEach(s => s.classList.remove('active'));

                    // Activate clicked star and previous stars
                    for (let i = 0; i <= index; i++) {
                        stars[i].classList.add('active');
                    }

                    currentRating = index + 1;
                });
            });
        }

        // Setup sub-categories toggle and filtering
        function setupSubCategories() {
            // Handle main categories with subcategories (both mobile and desktop)
            document.querySelectorAll('.has-subcategory').forEach(item => {
                item.addEventListener('click', (e) => {
                    e.preventDefault();
                    const subMenu = item.nextElementSibling;
                    const filter = item.dataset.filter;

                    // Toggle submenu (works for both mobile sub-categories and desktop-sub-categories)
                    if (subMenu && (subMenu.classList.contains('sub-categories') || subMenu.classList.contains('desktop-sub-categories'))) {
                        item.classList.toggle('active');
                        subMenu.classList.toggle('open');
                    }

                    // Filter by main category
                    const filteredDigitalAssets = digitalassets.filter(digitalasset =>
                        digitalasset.type === filter ||
                        (digitalasset.subType && digitalasset.subType.startsWith(filter.split('-')[0]))
                    );

                    renderDigitalAssets(filteredDigitalAssets);

                    // Update active states
                    document.querySelectorAll('.categories-content a, .category-item').forEach(a => {
                        a.classList.remove('category-active', 'active');
                    });
                    item.classList.add('category-active');
                });
            });

            // Handle subcategory and regular category clicks (both mobile and desktop)
            document.querySelectorAll('.categories-content a:not(.has-subcategory), .category-item:not([data-filter="all"]):not(.has-subcategory)').forEach(item => {
                item.addEventListener('click', (e) => {
                    e.preventDefault();
                    const filter = item.dataset.filter;

                    // Update active states
                    document.querySelectorAll('.categories-content a, .category-item').forEach(a => {
                        a.classList.remove('category-active', 'active');
                    });
                    item.classList.add('category-active', 'active');

                    if (filter === 'all') {
                        renderDigitalAssets(digitalassets);
                    } else {
                        // Filter by type or subType
                        const filteredDigitalAssets = digitalassets.filter(digitalasset =>
                            digitalasset.type === filter || digitalasset.subType === filter
                        );
                        renderDigitalAssets(filteredDigitalAssets);
                    }
                });
            });
        }

        // Render purchase options
        function renderPurchaseOptions() {
            purchaseOptionsContainer.innerHTML = '';

            purchaseOptions.forEach(option => {
                const optionCard = document.createElement('div');
                optionCard.className = 'option-card';
                optionCard.dataset.id = option.id;

                let badgeHTML = '';
                if (option.badge) {
                    badgeHTML = `<span class="option-badge">${option.badge}</span>`;
                }

                const dollars = option.price / 100;
                const coins = option.price;

                optionCard.innerHTML = `
                    <div class="option-title">${option.title}</div>
                    <div class="option-description">${option.description}</div>
                    <div class="option-price-dollars">${formatPriceFull(dollars)}</div>
                    <div class="option-price-coins">${formatPriceFull(dollars)} = ${formatCoins(coins)}</div>
                    ${badgeHTML}
                `;

                optionCard.addEventListener('click', () => {
                    document.querySelectorAll('.option-card').forEach(c => c.classList.remove('active'));
                    optionCard.classList.add('active');
                    selectedPurchaseOption = option;
                });

                purchaseOptionsContainer.appendChild(optionCard);
            });
        }

        // Render rental options
        function renderRentalOptions() {
            rentalOptionsContainer.innerHTML = '';

            rentalOptions.forEach(option => {
                const optionCard = document.createElement('div');
                optionCard.className = 'option-card';
                optionCard.dataset.id = option.id;

                const dollars = option.price;
                const coins = dollarsToCoins(dollars);

                optionCard.innerHTML = `
                    <div class="option-title">${option.title}</div>
                    <div class="option-description">${option.description}</div>
                    <div class="option-price-dollars">${formatPriceFull(dollars)}/${option.unit}</div>
                    <div class="option-price-coins">${formatPriceFull(dollars)} = ${formatCoins(coins)}</div>
                `;

                optionCard.addEventListener('click', () => {
                    selectedRentalOption = option;
                    showRentalDurationModal(option);
                });

                rentalOptionsContainer.appendChild(optionCard);
            });
        }

        // Show rental duration modal
        function showRentalDurationModal(option) {
            rentalOptionTitle.textContent = option.title;
            pricePerUnit.textContent = `${formatPriceFull(option.price)}/${option.unit}`;

            if (option.id === 'daily' || option.id === 'weekly') {
                durationLabel.textContent = `How many ${option.unit}s would you like to rent?`;
                durationInput.min = 1;
                durationInput.value = 1;
                updateRentalTotal();
            } else {
                // For monthly and yearly rentals, we don't need duration input
                rentalTotalAmount.textContent = formatPriceFull(option.price);
                const coins = dollarsToCoins(option.price);
                rentalTotalCoins.textContent = `${formatPriceFull(option.price)} = ${formatCoins(coins)}`;
            }

            rentalOptionsModal.style.display = 'none';
            rentalDurationModal.style.display = 'block';
        }

        // Update rental total amount
        function updateRentalTotal() {
            if (!selectedRentalOption) return;

            const quantity = parseInt(durationInput.value) || 0;
            const total = quantity * selectedRentalOption.price;
            const coins = dollarsToCoins(total);

            rentalTotalAmount.textContent = formatPriceFull(total);
            rentalTotalCoins.textContent = `${formatPriceFull(total)} = ${formatCoins(coins)}`;

            // Auto-resize text based on length
            const amountLength = rentalTotalAmount.textContent.length;
            if (amountLength > 15) {
                rentalTotalAmount.style.fontSize = '1rem';
            } else if (amountLength > 10) {
                rentalTotalAmount.style.fontSize = '1.1rem';
            } else {
                rentalTotalAmount.style.fontSize = '1.3rem';
            }
        }

        // Submit review
        function submitReview() {
            const reviewText = document.querySelector('.review-textarea').value;
            if (!reviewText || currentRating === 0) {
                alert('Please provide both a rating and review text');
                return;
            }

            const newReview = {
                id: currentComments.length + 1,
                author: "You",
                date: "Just now",
                text: reviewText,
                rating: currentRating
            };

            currentComments.unshift(newReview);
            renderComments();

            // Reset form
            document.querySelector('.review-textarea').value = '';
            const stars = reviewStars.querySelectorAll('.rating-star');
            stars.forEach(star => star.classList.remove('active'));
            currentRating = 0;

            showNotification('Thank you for your review!');
        }

        // Perform search
        function performSearch(query) {
            if (query.trim() === '') {
                // If search is empty, show all digitalassets
                renderDigitalAssets(digitalassets);
                return;
            }

            const filteredDigitalAssets = digitalassets.filter(digitalasset => {
                const searchFields = [
                    digitalasset.title.toLowerCase(),
                    digitalasset.description.toLowerCase(),
                    digitalasset.type.toLowerCase(),
                    digitalasset.subType ? digitalasset.subType.toLowerCase() : '',
                    digitalasset.badge ? digitalasset.badge.toLowerCase() : '',
                    ...digitalasset.features.map(f => f.toLowerCase())
                ].join(' ');

                return searchFields.includes(query.toLowerCase());
            });

            renderDigitalAssets(filteredDigitalAssets);
        }

        // Setup event listeners
        function setupEventListeners() {
            // Categories dropdown toggle
            const categoriesBtns = document.querySelectorAll('.categories-btn');
            const categoriesDropdowns = document.querySelectorAll('.categories-dropdown');
            
            categoriesBtns.forEach((btn, index) => {
                btn.addEventListener('click', () => {
                    categoriesDropdowns[index].classList.toggle('active');
                });
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', (e) => {
                categoriesDropdowns.forEach(dropdown => {
                    if (!dropdown.contains(e.target)) {
                        dropdown.classList.remove('active');
                    }
                });
            });

            // All categories links (both desktop sidebar and mobile dropdown)
            document.querySelectorAll('[data-filter="all"]').forEach(link => {
                link.addEventListener('click', (e) => {
                    e.preventDefault();
                    document.querySelectorAll('.categories-content a, .category-item').forEach(a => {
                        a.classList.remove('category-active', 'active');
                    });
                    document.querySelectorAll('[data-filter="all"]').forEach(a => {
                        a.classList.add('category-active', 'active');
                    });
                    renderDigitalAssets(digitalassets);
                });
            });

            // Real-time search for both desktop and mobile
            searchInput.addEventListener('input', () => {
                performSearch(searchInput.value);
                // Sync with mobile search
                if (searchInputMobile) {
                    searchInputMobile.value = searchInput.value;
                }
            });

            if (searchInputMobile) {
                searchInputMobile.addEventListener('input', () => {
                    performSearch(searchInputMobile.value);
                    // Sync with desktop search
                    searchInput.value = searchInputMobile.value;
                });
            }

            // Close digitalasset detail modal
            closeDetail.addEventListener('click', () => {
                digitalassetDetailModal.style.display = 'none';
                document.body.style.overflow = '';
            });

            // Favorite button in detail
            btnFavorite.addEventListener('click', () => {
                const digitalassetId = parseInt(document.querySelector('.digitalasset-detail-container').dataset.id);
                const digitalasset = digitalassets.find(da => da.id === digitalassetId);

                const index = favorites.indexOf(digitalassetId);
                const isFavorite = index !== -1;

                if (isFavorite) {
                    favorites.splice(index, 1);
                    btnFavorite.classList.remove('active');
                    btnFavorite.innerHTML = '♥ Add to Favorites';
                    showNotification(`${digitalasset.title} removed from favorites`);
                } else {
                    favorites.push(digitalassetId);
                    btnFavorite.classList.add('active');
                    btnFavorite.innerHTML = '♥ Added to Favorites';
                    showNotification(`${digitalasset.title} added to favorites`);
                }

                localStorage.setItem('favorites', JSON.stringify(favorites));
            });

            // Live preview button
            btnPreview.addEventListener('click', () => {
                alert(`Live preview of "${currentDigitalasset.title}" would open in a new tab`);
            });

            // Rent button
            btnRent.addEventListener('click', () => {
                rentalTitle.textContent = `Rental Options for ${currentDigitalasset.title}`;
                renderRentalOptions();
                rentalOptionsModal.style.display = 'block';
                document.body.style.overflow = 'hidden';
            });

            // Buy button
            btnBuy.addEventListener('click', () => {
                purchaseTitle.textContent = `Purchase Options for ${currentDigitalasset.title}`;
                renderPurchaseOptions();
                purchaseOptionsModal.style.display = 'block';
                document.body.style.overflow = 'hidden';
            });

            // Tab switching
            tabBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    const tabId = btn.dataset.tab;

                    // Update active tab button
                    tabBtns.forEach(b => b.classList.remove('active'));
                    btn.classList.add('active');

                    // Update active tab content
                    tabContents.forEach(content => content.classList.remove('active'));
                    document.getElementById(`tab-${tabId}`).classList.add('active');
                });
            });

            // Submit review
            submitReviewBtn.addEventListener('click', submitReview);

            // Close modals
            closePurchase.addEventListener('click', () => {
                purchaseOptionsModal.style.display = 'none';
                document.body.style.overflow = '';
            });

            closeRental.addEventListener('click', () => {
                rentalOptionsModal.style.display = 'none';
                document.body.style.overflow = '';
            });

            closeRentalDuration.addEventListener('click', () => {
                rentalDurationModal.style.display = 'none';
                document.body.style.overflow = '';
            });

            closeCheckout.addEventListener('click', () => {
                checkoutModal.style.display = 'none';
                document.body.style.overflow = '';
            });

            purchaseBackBtn.addEventListener('click', () => {
                purchaseOptionsModal.style.display = 'none';
                document.body.style.overflow = '';
            });

            rentalBackBtn.addEventListener('click', () => {
                rentalDurationModal.style.display = 'none';
                rentalOptionsModal.style.display = 'block';
            });

            checkoutBackBtn.addEventListener('click', () => {
                checkoutModal.style.display = 'none';
                document.body.style.overflow = '';
            });

            // Duration input
            durationInput.addEventListener('input', updateRentalTotal);

            // Confirm rental button
            confirmRentalBtn.addEventListener('click', () => {
                const quantity = parseInt(durationInput.value) || 0;
                if (quantity <= 0) {
                    alert('Please enter a valid duration');
                    return;
                }
                rentalDurationModal.style.display = 'none';
                checkoutModal.style.display = 'block';
            });

            purchaseContinueBtn.addEventListener('click', () => {
                if (!selectedPurchaseOption) {
                    alert('Please select a purchase option');
                    return;
                }
                purchaseOptionsModal.style.display = 'none';
                checkoutModal.style.display = 'block';
            });

            // Submit checkout
            checkoutSubmitBtn.addEventListener('click', () => {
                const name = document.getElementById('name-input').value;
                const email = document.getElementById('email-input').value;

                if (!name || !email) {
                    alert('Please fill in all required fields');
                    return;
                }

                alert('Order submitted successfully!');
                checkoutModal.style.display = 'none';
                document.body.style.overflow = '';
            });
        }
    </script>
</x-app-layout>
