<div class="search-modal-overlay" id="searchModal">
    <div class="search-modal-container">
        <div class="search-modal-header">
            <div class="search-input-wrap">
                <i class="fa-solid fa-magnifying-glass search-modal-icon"></i>
                <input type="text" id="liveSearchInput" placeholder="Search plants, seeds, articles, plant doctor... (Press ESC to close)" autocomplete="off">
                <button class="search-clear-btn" id="searchClearBtn"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <button class="search-modal-close" id="searchModalClose"><i class="fa-solid fa-xmark"></i></button>
        </div>

        <div class="search-modal-body">
            <!-- Popular Category Quick Chips -->
            <div class="mb-4">
                <div class="text-muted small fw-bold mb-2">QUICK CATEGORIES</div>
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('shop.index') }}" class="search-chip"><i class="fa-solid fa-house-plant me-1"></i> Indoor Plants</a>
                    <a href="{{ route('shop.index') }}" class="search-chip"><i class="fa-solid fa-sun-plant-wilt me-1"></i> Outdoor Plants</a>
                    <a href="{{ route('shop.index') }}" class="search-chip"><i class="fa-solid fa-seedling me-1"></i> Seeds & Bulbs</a>
                    <a href="{{ route('shop.index') }}" class="search-chip"><i class="fa-solid fa-jar me-1"></i> Pots & Planters</a>
                    <a href="{{ route('shop.index') }}" class="search-chip"><i class="fa-solid fa-spray-can me-1"></i> Plant Care</a>
                </div>
            </div>

            <!-- Instant Search Suggestions / Results -->
            <div id="liveSearchResults">
                <div class="text-muted small fw-bold mb-2">SUGGESTED SEARCHES</div>
                <div class="search-suggestion-list">
                    <a href="{{ route('search.index', ['q' => 'Monstera Deliciosa']) }}" class="search-suggestion-item">
                        <i class="fa-solid fa-arrow-trend-up me-2 text-success"></i> Monstera Deliciosa <span class="badge bg-light text-dark ms-auto">Plant</span>
                    </a>
                    <a href="{{ route('search.index', ['q' => 'Snake Plant']) }}" class="search-suggestion-item">
                        <i class="fa-solid fa-arrow-trend-up me-2 text-success"></i> Snake Plant Laurentii <span class="badge bg-light text-dark ms-auto">Low Light</span>
                    </a>
                    <a href="{{ route('search.index', ['q' => 'Yellow Leaves']) }}" class="search-suggestion-item">
                        <i class="fa-solid fa-user-doctor me-2 text-warning"></i> Yellow Leaves Diagnosis <span class="badge bg-light text-dark ms-auto">Plant Doctor</span>
                    </a>
                    <a href="{{ route('search.index', ['q' => 'Soil Health']) }}" class="search-suggestion-item">
                        <i class="fa-solid fa-newspaper me-2 text-primary"></i> Soil Health & Plant Growth <span class="badge bg-light text-dark ms-auto">Article</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
