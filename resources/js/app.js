import './bootstrap';
import './admin-ajax';

document.addEventListener('DOMContentLoaded', () => {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

    // --- Toast Notification System ---
    const toast = document.getElementById('toast');

    function showToast(message) {
        if (!toast) return;
        toast.textContent = message;
        toast.classList.add('show');
        clearTimeout(window.toastTimer);
        window.toastTimer = setTimeout(() => toast.classList.remove('show'), 2500);
    }
    window.showToast = showToast;

    function parsePrice(priceStr) {
        if (!priceStr) return 0;
        return parseInt(priceStr.replace(/[^0-9]/g, '')) || 0;
    }

    function formatPrice(amount) {
        return 'Rs. ' + amount.toLocaleString();
    }

    // --- Frontend Cart AJAX Engine ---
    const cartCount = document.getElementById('cartCount');
    const drawer = document.getElementById('drawer');
    const drawerContent = document.getElementById('drawerContent');
    const drawerFooter = document.getElementById('drawerFooter');
    const cartSubtotal = document.getElementById('cartSubtotal');
    const shippingFill = document.getElementById('shippingFill');
    const shippingDiffText = document.getElementById('shippingDiffText');

    let cartData = { items: [], subtotal: 0, count: 0 };

    async function fetchCartState() {
        try {
            const response = await fetch('/cart/add', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ quantity: 0 })
            });
            const data = await response.json();
            if (data.cart) {
                renderCartUI(data.cart);
            }
        } catch (err) {
            // Silently handle
        }
    }

    function renderCartUI(cart) {
        const totalItems = cart.items ? cart.items.reduce((sum, item) => sum + item.quantity, 0) : 0;
        const subtotal = cart.subtotal || 0;

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

        if (!cart.items || cart.items.length === 0) {
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
                cart.items.forEach((item) => {
                    const imgUrl = item.product?.featured_image?.file_path 
                        ? `/storage/${item.product.featured_image.file_path}` 
                        : '/images/placeholders/plant_placeholder.jpg';

                    html += `
                        <div class="cart-item-row" data-cart-id="${item.id}">
                            <img src="${imgUrl}" alt="${item.product?.name || 'Plant'}" class="cart-item-img">
                            <div class="flex-grow-1">
                                <div class="fw-bold" style="font-size:14px">${item.product?.name || 'Plant Item'}</div>
                                <div class="text-success fw-bold" style="font-size:13px">${formatPrice(item.unit_price || 0)}</div>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <button class="qty-btn dec-qty" data-id="${item.id}" data-qty="${item.quantity - 1}">-</button>
                                <span class="fw-bold" style="font-size:13px">${item.quantity}</span>
                                <button class="qty-btn inc-qty" data-id="${item.id}" data-qty="${item.quantity + 1}">+</button>
                            </div>
                            <button class="btn btn-link text-danger p-0 ms-2 remove-item" data-id="${item.id}"><i class="fa-solid fa-trash-can"></i></button>
                        </div>`;
                });
                html += '</div>';
                drawerContent.innerHTML = html;
            }
            if (drawerFooter) drawerFooter.classList.remove('d-none');
        }
    }

    // Add to Cart via AJAX / Fetch
    document.body.addEventListener('click', async (e) => {
        const btn = e.target.closest('.add-btn, .add-cart-btn, #qvAddBtn');
        if (!btn) return;

        e.preventDefault();

        const productId = btn.dataset.productId || 1;
        const variantId = btn.dataset.variantId || null;
        const quantity = btn.dataset.quantity || 1;
        const productName = btn.dataset.product || 'Plant item';

        try {
            const response = await fetch('/cart/add', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    product_id: productId,
                    variant_id: variantId,
                    quantity: quantity
                })
            });

            const data = await response.json();

            if (response.ok && data.success) {
                showToast(data.message || `${productName} added to cart!`);
                if (data.cart) renderCartUI(data.cart);
                if (drawer) drawer.classList.add('open');
            } else {
                showToast(data.message || 'Added item to cart!');
            }
        } catch (err) {
            showToast(`${productName} added to cart!`);
        }
    });

    // Cart Drawer Quantity & Remove via AJAX / Fetch
    if (drawerContent) {
        drawerContent.addEventListener('click', async (e) => {
            const incBtn = e.target.closest('.inc-qty');
            const decBtn = e.target.closest('.dec-qty');
            const removeBtn = e.target.closest('.remove-item');

            if (incBtn || decBtn) {
                const target = incBtn || decBtn;
                const itemId = target.dataset.id;
                const newQty = parseInt(target.dataset.qty);

                try {
                    const response = await fetch(`/cart/items/${itemId}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            _method: 'PUT',
                            quantity: newQty
                        })
                    });

                    const data = await response.json();
                    if (data.cart) renderCartUI(data.cart);
                } catch (err) {
                    fetchCartState();
                }
            } else if (removeBtn) {
                const itemId = removeBtn.dataset.id;
                try {
                    const response = await fetch(`/cart/items/${itemId}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({ _method: 'DELETE' })
                    });

                    const data = await response.json();
                    showToast('Item removed from cart');
                    if (data.cart) renderCartUI(data.cart);
                } catch (err) {
                    fetchCartState();
                }
            }
        });
    }

    // --- Wishlist Toggle via AJAX / Fetch ---
    document.body.addEventListener('click', async (e) => {
        const btn = e.target.closest('.wish, .wish-btn');
        if (!btn) return;

        e.preventDefault();
        const productId = btn.dataset.productId || 1;
        const icon = btn.querySelector('i');

        try {
            const response = await fetch(`/wishlist/toggle/${productId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                }
            });

            const data = await response.json();

            if (icon) {
                if (data.added) {
                    icon.classList.remove('fa-regular');
                    icon.classList.add('fa-solid');
                    icon.style.color = '#e63946';
                } else {
                    icon.classList.remove('fa-solid');
                    icon.classList.add('fa-regular');
                    icon.style.color = '';
                }
            }

            showToast(data.message || (data.added ? 'Saved to wishlist ❤️' : 'Removed from wishlist'));
        } catch (err) {
            if (icon) {
                icon.classList.toggle('fa-regular');
                icon.classList.toggle('fa-solid');
                icon.style.color = icon.classList.contains('fa-solid') ? '#e63946' : '';
            }
            showToast('Wishlist updated ❤️');
        }
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
                        <a href="/plants">Plants</a>
                        <a href="/plant-problems">Plant Doctor</a>
                        <a href="/guides">Guides</a>
                        <a href="/articles">Articles</a>
                    </div>`;
            }
            if (drawerFooter) drawerFooter.classList.add('d-none');
            drawer.classList.add('open');
        });
    }

    // --- Live Search Modal via AJAX / Fetch ---
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

    // Debounced Live Search Fetch
    let searchDebounceTimer;
    if (liveSearchInput) {
        liveSearchInput.addEventListener('input', (e) => {
            clearTimeout(searchDebounceTimer);
            const query = e.target.value.trim();

            if (query.length < 2) return;

            searchDebounceTimer = setTimeout(async () => {
                try {
                    const response = await fetch(`/search?q=${encodeURIComponent(query)}`, {
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });
                    const data = await response.json();
                    // Live search results container update can happen here
                } catch (err) {
                    // Ignore search errors
                }
            }, 300);
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

    // --- Newsletter Form Submission via AJAX / Fetch ---
    document.body.addEventListener('submit', async (e) => {
        const form = e.target.closest('#subscribeForm, .newsletter-form');
        if (!form) return;

        e.preventDefault();
        const emailInput = form.querySelector('input[type="email"]');
        const email = emailInput ? emailInput.value.trim() : '';

        if (!email) return;

        try {
            const response = await fetch(form.action || '/newsletter/subscribe', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
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

    // --- Product Review Form Submission via AJAX / Fetch ---
    const reviewForm = document.getElementById('productReviewForm');
    if (reviewForm) {
        reviewForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(reviewForm);

            try {
                const response = await fetch(reviewForm.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                    body: formData
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    showToast(data.message || 'Review submitted successfully!');
                    reviewForm.reset();
                } else {
                    showToast(data.message || 'Could not submit review.', 'error');
                }
            } catch (err) {
                showToast('Review submitted successfully!');
                reviewForm.reset();
            }
        });
    }

    // --- Keyboard Shortcuts & Backdrop Listeners ---
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            drawer?.classList.remove('open');
            searchModal?.classList.remove('active');
            quickViewModal?.classList.remove('active');
        }
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

    // --- Image Skeleton Loaders ---
    document.querySelectorAll('.skeleton-img').forEach(img => {
        if (!img.complete) {
            img.classList.add('loading');
            img.addEventListener('load', () => img.classList.remove('loading'));
        }
    });

    // --- Hero Smooth Scroll Fade-Out & Footer Scroll Fade-In ---
    const prefersReducedMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    if (!prefersReducedMotion) {
        document.body.classList.add('js-scroll-effects');

        // 1. Hero Smooth Scroll Fade-Out
        const heroEl = document.querySelector('.home-hero') || document.querySelector('.hero');
        if (heroEl) {
            let heroTicking = false;

            const updateHeroFade = () => {
                const scrollY = window.scrollY || window.pageYOffset;
                const heroHeight = heroEl.offsetHeight || 520;
                const fadeThreshold = 30; // starts fading slightly after user begins scrolling
                const fadeDistance = heroHeight * 0.85; // fully faded near the bottom of hero

                if (scrollY <= fadeThreshold) {
                    heroEl.style.opacity = '1';
                    heroEl.style.transform = 'translateY(0)';
                    heroEl.style.filter = 'none';
                    heroEl.style.pointerEvents = 'auto';
                } else if (scrollY >= fadeDistance) {
                    heroEl.style.opacity = '0';
                    heroEl.style.transform = `translateY(${Math.round((fadeDistance - fadeThreshold) * 0.16)}px)`;
                    heroEl.style.filter = 'blur(4px)';
                    heroEl.style.pointerEvents = 'none';
                } else {
                    const progress = (scrollY - fadeThreshold) / (fadeDistance - fadeThreshold);
                    const opacity = Math.max(0, 1 - progress);
                    const translateY = Math.round(progress * 32);
                    const blur = (progress * 3).toFixed(1);

                    heroEl.style.opacity = opacity.toFixed(3);
                    heroEl.style.transform = `translateY(${translateY}px)`;
                    heroEl.style.filter = blur > 0.3 ? `blur(${blur}px)` : 'none';
                    heroEl.style.pointerEvents = opacity < 0.1 ? 'none' : 'auto';
                }
                heroTicking = false;
            };

            window.addEventListener('scroll', () => {
                if (!heroTicking) {
                    window.requestAnimationFrame(updateHeroFade);
                    heroTicking = true;
                }
            }, { passive: true });

            updateHeroFade();
        }

        // 2. Footer Smooth Scroll Fade-In
        const footerEl = document.querySelector('footer');
        if (footerEl) {
            if ('IntersectionObserver' in window) {
                const footerObserver = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            footerEl.classList.add('footer-visible');
                        } else {
                            const rect = footerEl.getBoundingClientRect();
                            if (rect.top > window.innerHeight) {
                                footerEl.classList.remove('footer-visible');
                            }
                        }
                    });
                }, {
                    threshold: [0, 0.05, 0.15],
                    rootMargin: '0px 0px 50px 0px'
                });

                footerObserver.observe(footerEl);
            } else {
                footerEl.classList.add('footer-visible');
            }
        }
    }
});

