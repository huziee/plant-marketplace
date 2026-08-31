<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') — {{ setting('site_name', 'Plantaric') }}</title>
    
    <!-- Favicon & Brand Icons -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">
    <meta name="theme-color" content="#123522">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        :root {
            --admin-sidebar-width: 260px;
            --admin-topbar-height: 64px;
        }
        body.admin-body {
            background-color: #f4f6f5;
            font-family: "DM Sans", sans-serif;
            color: var(--text);
            margin: 0;
        }
        .admin-sidebar {
            width: var(--admin-sidebar-width);
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            background: var(--green-950);
            color: #dbe8df;
            z-index: 1000;
            overflow-y: auto;
            transition: transform 0.3s ease;
        }
        .admin-brand {
            height: var(--admin-topbar-height);
            display: flex;
            align-items: center;
            padding: 0 20px;
            font-weight: 800;
            font-size: 20px;
            color: #ffffff;
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }
        .admin-nav {
            padding: 16px 12px;
        }
        .admin-nav-header {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #799786;
            margin: 18px 12px 6px;
        }
        .admin-nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 14px;
            border-radius: 12px;
            color: #c5d7cc;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s;
            margin-bottom: 3px;
        }
        .admin-nav-item:hover, .admin-nav-item.active {
            background: rgba(215, 239, 105, 0.12);
            color: var(--accent);
        }
        .admin-nav-item i {
            font-size: 16px;
            width: 20px;
            text-align: center;
        }
        .admin-header {
            position: fixed;
            top: 0;
            right: 0;
            left: var(--admin-sidebar-width);
            height: var(--admin-topbar-height);
            background: #ffffff;
            border-bottom: 1px solid var(--line);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 28px;
            z-index: 990;
            transition: left 0.3s ease;
        }
        .admin-main {
            margin-left: var(--admin-sidebar-width);
            margin-top: var(--admin-topbar-height);
            padding: 28px;
            min-height: calc(100vh - var(--admin-topbar-height));
            transition: margin-left 0.3s ease;
        }
        .user-dropdown-btn {
            display: flex;
            align-items: center;
            gap: 10px;
            border: none;
            background: transparent;
            cursor: pointer;
        }
        .user-avatar-sm {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            object-fit: cover;
        }
        .badge-role {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            padding: 3px 8px;
            border-radius: 999px;
            background: var(--green-100);
            color: var(--green-800);
        }
        .card-custom {
            background: #ffffff;
            border: 1px solid var(--line);
            border-radius: 20px;
            box-shadow: var(--shadow-sm);
            padding: 24px;
            margin-bottom: 24px;
        }
        @media (max-width: 992px) {
            .admin-sidebar {
                transform: translateX(-100%);
            }
            .admin-sidebar.show {
                transform: translateX(0);
            }
            .admin-header {
                left: 0;
            }
            .admin-main {
                margin-left: 0;
            }
        }
    </style>
    @stack('admin_styles')
</head>
<body class="admin-body">

    <!-- Sidebar -->
    <aside class="admin-sidebar" id="adminSidebar">
        <div class="admin-brand">
            <span class="brand-mark me-2" style="width:32px;height:32px;font-size:16px"><i class="fa-solid fa-seedling"></i></span>
            Plantaric Admin
        </div>
        <div class="admin-nav">
            <a href="{{ route('admin.dashboard') }}" class="admin-nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-chart-line"></i> Dashboard
            </a>

            <div class="admin-nav-header">PLANTS & CARE</div>
            <a href="{{ route('admin.plants.index') }}" class="admin-nav-item {{ request()->routeIs('admin.plants.*') ? 'active' : '' }}">
                <i class="fa-solid fa-leaf"></i> All Plants
            </a>
            <a href="{{ route('admin.plant-categories.index') }}" class="admin-nav-item {{ request()->routeIs('admin.plant-categories.*') ? 'active' : '' }}">
                <i class="fa-solid fa-layer-group"></i> Categories
            </a>
            <a href="{{ route('admin.plant-problems.index') }}" class="admin-nav-item {{ request()->routeIs('admin.plant-problems.*') ? 'active' : '' }}">
                <i class="fa-solid fa-user-doctor"></i> Plant Problems
            </a>

            <div class="admin-nav-header">CONTENT & PAGES</div>
            <a href="{{ route('admin.posts.index') }}" class="admin-nav-item {{ request()->routeIs('admin.posts.*') ? 'active' : '' }}">
                <i class="fa-regular fa-newspaper"></i> All Content & Posts
            </a>
            <a href="{{ route('admin.pages.index') }}" class="admin-nav-item {{ request()->routeIs('admin.pages.*') ? 'active' : '' }}">
                <i class="fa-solid fa-file-contract"></i> Pages & Policy CMS
            </a>
            <a href="{{ route('admin.content-categories.index') }}" class="admin-nav-item {{ request()->routeIs('admin.content-categories.*') ? 'active' : '' }}">
                <i class="fa-solid fa-folder-tree"></i> Content Categories
            </a>
            <a href="{{ route('admin.tags.index') }}" class="admin-nav-item {{ request()->routeIs('admin.tags.*') ? 'active' : '' }}">
                <i class="fa-solid fa-tags"></i> Content Tags
            </a>

            <div class="admin-nav-header">SHOP</div>
            <a href="{{ route('admin.products.index') }}" class="admin-nav-item {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                <i class="fa-solid fa-box-open"></i> Products Catalog
            </a>
            <a href="{{ route('admin.product-categories.index') }}" class="admin-nav-item {{ request()->routeIs('admin.product-categories.*') ? 'active' : '' }}">
                <i class="fa-solid fa-tags"></i> Product Categories
            </a>
            <a href="{{ route('admin.orders.index') }}" class="admin-nav-item {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                <i class="fa-solid fa-cart-shopping"></i> Customer Orders
            </a>
            <a href="{{ route('admin.inventory.index') }}" class="admin-nav-item {{ request()->routeIs('admin.inventory.*') ? 'active' : '' }}">
                <i class="fa-solid fa-warehouse"></i> Inventory Movements
            </a>
            <a href="{{ route('admin.coupons.index') }}" class="admin-nav-item {{ request()->routeIs('admin.coupons.*') ? 'active' : '' }}">
                <i class="fa-solid fa-ticket"></i> Coupons & Discounts
            </a>
            <a href="{{ route('admin.reviews.index') }}" class="admin-nav-item {{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}">
                <i class="fa-solid fa-star"></i> Product Reviews
            </a>
            <a href="{{ route('admin.shipping-methods.index') }}" class="admin-nav-item {{ request()->routeIs('admin.shipping-methods.*') ? 'active' : '' }}">
                <i class="fa-solid fa-truck"></i> Shipping Methods
            </a>
            <a href="{{ route('admin.product-collections.index') }}" class="admin-nav-item {{ request()->routeIs('admin.product-collections.*') ? 'active' : '' }}">
                <i class="fa-solid fa-layer-group"></i> Collections
            </a>

            <div class="admin-nav-header">NURSERIES</div>
            <a href="#" class="admin-nav-item text-muted opacity-50" onclick="alert('Nursery Marketplace will be implemented in Phase 4'); return false;">
                <i class="fa-solid fa-location-dot"></i> Nursery Sellers
            </a>

            <div class="admin-nav-header">MARKETING & INQUIRIES</div>
            <a href="{{ route('admin.contact-messages.index') }}" class="admin-nav-item {{ request()->routeIs('admin.contact-messages.*') ? 'active' : '' }}">
                <i class="fa-solid fa-inbox"></i> Contact Messages
            </a>
            <a href="{{ route('admin.subscribers.index') }}" class="admin-nav-item {{ request()->routeIs('admin.subscribers.*') ? 'active' : '' }}">
                <i class="fa-regular fa-envelope"></i> Subscribers
            </a>

            <div class="admin-nav-header">SYSTEM</div>
            <a href="{{ route('admin.users.index') }}" class="admin-nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <i class="fa-solid fa-users"></i> Users
            </a>
            <a href="{{ route('admin.media.index') }}" class="admin-nav-item {{ request()->routeIs('admin.media.*') ? 'active' : '' }}">
                <i class="fa-regular fa-images"></i> Media Library
            </a>
            <a href="{{ route('admin.settings.index') }}" class="admin-nav-item {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                <i class="fa-solid fa-gear"></i> Settings
            </a>
        </div>
    </aside>

    <!-- Topbar Header -->
    <header class="admin-header">
        <div class="d-flex align-items-center gap-3">
            <button class="btn btn-light d-lg-none" id="toggleSidebarBtn"><i class="fa-solid fa-bars"></i></button>
            <a href="{{ route('frontend.home') }}" target="_blank" class="btn btn-sm btn-outline-success border-radius-sm" style="border-radius:10px;font-size:13px;font-weight:700">
                <i class="fa-solid fa-arrow-up-right-from-square me-1"></i> Visit Website
            </a>
        </div>

        <div class="dropdown">
            <button class="user-dropdown-btn dropdown-toggle" type="button" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}" class="user-avatar-sm">
                <div class="text-start d-none d-md-block">
                    <div style="font-size:14px;font-weight:700;line-height:1.2">{{ auth()->user()->name }}</div>
                    <span class="badge-role">{{ auth()->user()->role }}</span>
                </div>
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow border-0" style="border-radius:14px;padding:10px">
                <li><a class="dropdown-item" href="{{ route('admin.users.show', auth()->id()) }}"><i class="fa-regular fa-user me-2"></i> Profile</a></li>
                <li><a class="dropdown-item" href="{{ route('admin.settings.index') }}"><i class="fa-solid fa-gear me-2"></i> Settings</a></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger"><i class="fa-solid fa-right-from-bracket me-2"></i> Logout</button>
                    </form>
                </li>
            </ul>
        </div>
    </header>

    <!-- Main Content -->
    <main class="admin-main">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" style="border-radius:14px;background:#e8f3ea;color:#1c4d31" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" style="border-radius:14px" role="alert">
                <i class="fa-solid fa-triangle-exclamation me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Bootstrap 5 Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('toggleSidebarBtn')?.addEventListener('click', function() {
            document.getElementById('adminSidebar').classList.toggle('show');
        });
    </script>
    @stack('admin_scripts')
</body>
</html>
