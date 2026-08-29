import './bootstrap';

document.addEventListener('DOMContentLoaded', () => {
    // --- Cart & Free Shipping State ---
    let cartItems = [];
    const cartCount = document.getElementById('cartCount');
    const drawer = document.getElementById('drawer');
    const drawerContent = document.getElementById('drawerContent');
    const drawerFooter = document.getElementById('drawerFooter');
    const cartSubtotal = document.getElementById('cartSubtotal');
    const shippingFill = document.getElementById('shippingFill');
    const shippingDiffText = document.getElementById('shippingDiffText');
    const toast = document.getElementById('toast');

    function showToast(message) {
        if (!toast) return;
        toast.textContent = message;
        toast.classList.add('show');
        clearTimeout(window.toastTimer);
        window.toastTimer = setTimeout(() => toast.classList.remove('show'), 2000);
    }

    function parsePrice(priceStr) {
        if (!priceStr) return 0;
        return parseInt(priceStr.replace(/[^0-9]/g, '')) || 0;
    }

    function formatPrice(amount) {
        return 'Rs. ' + amount.toLocaleString();
    }

    function updateCartUI() {
        const totalItems = cartItems.reduce((acc, item) => acc + item.qty, 0);
        const subtotal = cartItems.reduce((acc, item) => acc + (item.price * item.qty), 0);

        if (cartCount) {
            cartCount.textContent = totalItems;
            cartCount.classList.add('bump');
            setTimeout(() => cartCount.classList.remove('bump'), 200);
        }

        // Free Shipping Target: Rs. 5,000
        const freeShippingTarget = 5000;
        const progressPercentage = Math.min(100, (subtotal / freeShippingTarget) * 100);
        
        if (shippingFill) {
            shippingFill.style.width = `${progressPercentage}%`;
        }

        if (shippingDiffText) {
            if (subtotal >= freeShippingTarget) {
                shippingDiffText.innerHTML = '<span class="text-success"><i class="fa-solid fa-circle-check me-1"></i> You unlocked FREE Delivery!</span>';
            } else {
                const diff = freeShippingTarget - subtotal;
                shippingDiffText.textContent = `Add ${formatPrice(diff)} more for FREE delivery`;
            }
        }

        if (cartSubtotal) {
            cartSubtotal.textContent = formatPrice(subtotal);
        }

        if (cartItems.length === 0) {
            if (drawerContent) {
                drawerContent.innerHTML = `
                    <div class="text-center py-5 text-muted">
                        <i class="fa-solid fa-bag-shopping fa-3x mb-3 text-secondary opacity-50"></i>
                        <p class="mb-0">Your cart is currently empty.</p>
                        <a href="/shop" class="btn btn-sm btn-outline-success mt-3" style="border-radius:12px;font-weight:700">Explore Shop</a>
                    </div>`;
            }
            if (drawerFooter) drawerFooter.classList.add('d-none');
        } else {
            if (drawerContent) {
                let html = '<div class="cart-items-list">';
                cartItems.forEach((item, index) => {
                    html += `
                        <div class="cart-item-row">
                            <img src="${item.image}" alt="${item.name}" class="cart-item-img">
                            <div class="flex-grow-1">
                                <div class="fw-bold" style="font-size:14px">${item.name}</div>
                                <div class="text-success fw-bold" style="font-size:13px">${formatPrice(item.price)}</div>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <button class="qty-btn dec-qty" data-index="${index}">-</button>
                                <span class="fw-bold" style="font-size:13px">${item.qty}</span>
                                <button class="qty-btn inc-qty" data-index="${index}">+</button>
                            </div>
                            <button class="btn btn-link text-danger p-0 ms-2 remove-item" data-index="${index}"><i class="fa-solid fa-trash-can"></i></button>
                        </div>`;
                });
                html += '</div>';
                drawerContent.innerHTML = html;
            }
            if (drawerFooter) drawerFooter.classList.remove('d-none');
        }
    }

    function addToCart(name, priceStr, imageStr) {
        const price = parsePrice(priceStr);
        const image = imageStr || 'https://images.unsplash.com/photo-1614594575810-7a6f1ee5f7f4?auto=format&fit=crop&w=700&q=85';
        
        const existing = cartItems.find(item => item.name === name);
        if (existing) {
            existing.qty++;
        } else {
            cartItems.push({ name, price, image, qty: 1 });
        }

        updateCartUI();
        showToast(`${name} added to cart!`);
    }

    document.querySelectorAll('.add-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const product = btn.dataset.product || 'Monstera Deliciosa';
            const card = btn.closest('.product-card') || btn.closest('.quick-view-container');
            const priceEl = card ? card.querySelector('.price strong') : null;
            const priceStr = priceEl ? priceEl.textContent : 'Rs. 2,450';
            const imgEl = card ? card.querySelector('img') : null;
            const imageStr = imgEl ? imgEl.src : '';

            addToCart(product, priceStr, imageStr);
        });
    });

    if (drawerContent) {
        drawerContent.addEventListener('click', (e) => {
            if (e.target.closest('.inc-qty')) {
                const index = e.target.closest('.inc-qty').dataset.index;
                cartItems[index].qty++;
                updateCartUI();
            } else if (e.target.closest('.dec-qty')) {
                const index = e.target.closest('.dec-qty').dataset.index;
                if (cartItems[index].qty > 1) {
                    cartItems[index].qty--;
                } else {
                    cartItems.splice(index, 1);
                }
                updateCartUI();
            } else if (e.target.closest('.remove-item')) {
                const index = e.target.closest('.remove-item').dataset.index;
                cartItems.splice(index, 1);
                updateCartUI();
            }
        });
    }

    // --- Wishlist Toggle ---
    document.querySelectorAll('.wish').forEach(btn => {
        btn.addEventListener('click', () => {
            const icon = btn.querySelector('i');
            if (icon) {
                icon.classList.toggle('fa-regular');
                icon.classList.toggle('fa-solid');
                icon.style.color = icon.classList.contains('fa-solid') ? '#e63946' : '';
                showToast(icon.classList.contains('fa-solid') ? 'Saved to wishlist ❤️' : 'Removed from wishlist');
            }
        });
    });

    // --- Cart & Menu Drawer Toggles ---
    const cartBtn = document.getElementById('cartBtn');
    if (cartBtn && drawer) {
        cartBtn.addEventListener('click', () => {
            const drawerTitle = document.getElementById('drawerTitle');
            if (drawerTitle) drawerTitle.textContent = 'Your Cart';
            drawer.classList.add('open');
        });
    }

    const drawerClose = document.getElementById('drawerClose');
    if (drawerClose && drawer) {
        drawerClose.addEventListener('click', () => drawer.classList.remove('open'));
    }

    const menuBtn = document.getElementById('menuBtn');
    if (menuBtn && drawer) {
        menuBtn.addEventListener('click', () => {
            const drawerTitle = document.getElementById('drawerTitle');
            if (drawerTitle) drawerTitle.textContent = 'Navigation';
            if (drawerContent) {
                drawerContent.innerHTML = `
                    <div style="display:grid;gap:14px;font-weight:700">
                        <a href="/shop">Shop</a>
                        <a href="/#plants">Plants</a>
                        <a href="/#nurseries">Nurseries</a>
                        <a href="/#problems">Plant Doctor</a>
                        <a href="/#guides">Guides</a>
                        <a href="/#news">News</a>
                    </div>`;
            }
            if (drawerFooter) drawerFooter.classList.add('d-none');
            drawer.classList.add('open');
        });
    }

    // --- Live Search Modal ---
    const searchModal = document.getElementById('searchModal');
    const openSearchBtn = document.getElementById('openSearchBtn');
    const searchModalClose = document.getElementById('searchModalClose');
    const liveSearchInput = document.getElementById('liveSearchInput');
    const searchClearBtn = document.getElementById('searchClearBtn');

    function openSearchModal() {
        if (!searchModal) return;
        searchModal.classList.add('active');
        setTimeout(() => liveSearchInput?.focus(), 100);
    }

    function closeSearchModal() {
        if (!searchModal) return;
        searchModal.classList.remove('active');
    }

    if (openSearchBtn) openSearchBtn.addEventListener('click', openSearchModal);
    if (searchModalClose) searchModalClose.addEventListener('click', closeSearchModal);

    if (searchClearBtn && liveSearchInput) {
        searchClearBtn.addEventListener('click', () => {
            liveSearchInput.value = '';
            liveSearchInput.focus();
        });
    }

    // --- Quick View Modal ---
    const quickViewModal = document.getElementById('quickViewModal');
    const quickViewClose = document.getElementById('quickViewClose');

    document.querySelectorAll('.quick-view-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const name = btn.dataset.name || 'Plant Variety';
            const price = btn.dataset.price || 'Rs. 2,450';
            const oldprice = btn.dataset.oldprice || '';
            const image = btn.dataset.image || '';
            const light = btn.dataset.light || 'Medium Light';
            const water = btn.dataset.water || 'Weekly Water';
            const reviews = btn.dataset.reviews || '128';

            document.getElementById('qvTitle').textContent = name;
            document.getElementById('qvPrice').textContent = price;
            const oldPriceEl = document.getElementById('qvOldPrice');
            if (oldPriceEl) {
                oldPriceEl.textContent = oldprice;
                oldPriceEl.style.display = oldprice ? 'inline' : 'none';
            }
            document.getElementById('qvImage').src = image;
            document.getElementById('qvLight').textContent = light;
            document.getElementById('qvWater').textContent = water;
            document.getElementById('qvRatingText').textContent = `(${reviews} reviews)`;
            
            const qvAddBtn = document.getElementById('qvAddBtn');
            if (qvAddBtn) qvAddBtn.dataset.product = name;

            if (quickViewModal) quickViewModal.classList.add('active');
        });
    });

    if (quickViewClose && quickViewModal) {
        quickViewClose.addEventListener('click', () => quickViewModal.classList.remove('active'));
    }

    // Size Selector Buttons
    document.querySelectorAll('.size-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            btn.closest('.quick-view-container').querySelectorAll('.size-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
        });
    });

    // --- Keyboard Shortcuts & Backdrop Listeners ---
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            drawer?.classList.remove('open');
            searchModal?.classList.remove('active');
            quickViewModal?.classList.remove('active');
        }
        // Press '/' to open search modal if not inside an input
        if (e.key === '/' && document.activeElement.tagName !== 'INPUT' && document.activeElement.tagName !== 'TEXTAREA') {
            e.preventDefault();
            openSearchModal();
        }
    });

    searchModal?.addEventListener('click', (e) => {
        if (e.target === searchModal) closeSearchModal();
    });

    quickViewModal?.addEventListener('click', (e) => {
        if (e.target === quickViewModal) quickViewModal.classList.remove('active');
    });

    // --- Newsletter Form Submission ---
    const subscribeForm = document.getElementById('subscribeForm');
    if (subscribeForm) {
        subscribeForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const emailInput = document.getElementById('emailInput');
            const email = emailInput ? emailInput.value.trim() : '';

            if (!email) return;

            try {
                const response = await fetch(subscribeForm.action, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ email })
                });
                const data = await response.json();
                showToast(data.message || 'Thanks for subscribing!');
                if (emailInput) emailInput.value = '';
            } catch (err) {
                showToast('Thanks! Newsletter subscription received.');
                if (emailInput) emailInput.value = '';
            }
        });
    }

    // --- Image Skeleton Loaders ---
    document.querySelectorAll('.skeleton-img').forEach(img => {
        if (!img.complete) {
            img.classList.add('loading');
            img.addEventListener('load', () => img.classList.remove('loading'));
        }
    });
});
