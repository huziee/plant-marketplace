<div class="nav-wrap">
    <div class="container">
        <nav>
            <a class="brand" href="{{ url('/') }}">
                <span class="brand-mark"><i class="fa-solid fa-seedling"></i></span>
                Plantaric
            </a>

            <div class="nav-links">
                <a href="{{ route('shop.index') }}">Shop</a>
                <a href="{{ route('plants.index') }}">Plants</a>
                <a href="{{ route('problems.index') }}">Plant Doctor</a>
                <a href="{{ route('articles.index') }}">Articles</a>
                <a href="{{ route('guides.index') }}">Guides</a>
                <a href="{{ route('news.index') }}">News</a>
            </div>

            <div class="nav-actions">
                <button class="icon-btn" id="openSearchBtn" aria-label="Search"><i class="fa-solid fa-magnifying-glass"></i></button>
                
                @auth
                    <!-- Authenticated User Dropdown -->
                    <div class="dropdown">
                        <button class="icon-btn dropdown-toggle border-0" type="button" id="userHeaderDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="padding:0">
                            <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}" class="rounded-circle" style="width:36px;height:36px;object-fit:cover">
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0" style="border-radius:18px;padding:12px;min-width:220px;margin-top:10px">
                            <li class="px-2 py-1 mb-2 border-bottom">
                                <div class="fw-bold text-truncate" style="font-size:14px">{{ auth()->user()->name }}</div>
                                <div class="text-muted text-truncate" style="font-size:12px">{{ auth()->user()->email }}</div>
                                <span class="badge bg-success-subtle text-success mt-1" style="font-size:10px;text-transform:uppercase">{{ auth()->user()->role }}</span>
                            </li>
                            @if(auth()->user()->isAdmin())
                                <li><a class="dropdown-item fw-bold" href="{{ route('admin.dashboard') }}" style="border-radius:8px"><i class="fa-solid fa-chart-line text-success me-2"></i> Admin Panel</a></li>
                            @endif
                            <li><a class="dropdown-item fw-bold" href="#" style="border-radius:8px" onclick="alert('Account settings module will be expanded in Phase 2'); return false;"><i class="fa-regular fa-user me-2"></i> My Profile</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger fw-bold" style="border-radius:8px"><i class="fa-solid fa-right-from-bracket me-2"></i> Sign Out</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <!-- Guest User Auth Link -->
                    <a href="{{ route('login') }}" class="icon-btn" aria-label="Account" title="Sign In"><i class="fa-regular fa-user"></i></a>
                @endauth

                <button class="icon-btn" id="cartBtn" aria-label="Cart">
                    <i class="fa-solid fa-bag-shopping"></i><span class="cart-count" id="cartCount">0</span>
                </button>
                <button class="icon-btn menu-btn" id="menuBtn" aria-label="Menu"><i class="fa-solid fa-bars"></i></button>
            </div>
        </nav>
    </div>
</div>
