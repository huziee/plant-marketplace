<aside class="drawer" id="drawer">
    <div class="drawer-head">
        <h3 id="drawerTitle" style="font-family:'Playfair Display',serif;font-weight:700">Your Cart</h3>
        <button class="drawer-close" id="drawerClose"><i class="fa-solid fa-xmark"></i></button>
    </div>

    <!-- Free Shipping Progress Bar -->
    <div class="shipping-progress-wrap mt-3 mb-4 p-3 rounded-3" style="background:var(--green-50);border:1px solid var(--line)">
        <div class="d-flex justify-content-between small fw-bold mb-1" id="shippingText">
            <span><i class="fa-solid fa-truck-fast text-success me-1"></i> Free Shipping</span>
            <span id="shippingDiffText">Add Rs. 5,000 for FREE delivery</span>
        </div>
        <div class="shipping-progress-bar">
            <div class="shipping-progress-fill" id="shippingFill" style="width: 0%"></div>
        </div>
    </div>

    <div class="drawer-content" id="drawerContent">
        <div class="text-center py-5 text-muted">
            <i class="fa-solid fa-bag-shopping fa-3x mb-3 text-secondary opacity-50"></i>
            <p class="mb-0">Your cart is currently empty.</p>
            <a href="{{ route('shop.index') }}" class="btn btn-sm btn-outline-success mt-3" style="border-radius:12px;font-weight:700">Explore Shop</a>
        </div>
    </div>

    <div class="drawer-footer border-top pt-3 mt-auto d-none" id="drawerFooter">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <span class="text-muted fw-bold">Subtotal:</span>
            <strong class="fs-5" id="cartSubtotal">Rs. 0</strong>
        </div>
        <a href="{{ route('shop.index') }}" class="btn btn-primary w-100 py-3 fw-bold" style="border-radius:14px;background:var(--green-900);color:#fff">
            Proceed to Checkout <i class="fa-solid fa-arrow-right me-1"></i>
        </a>
    </div>
</aside>
