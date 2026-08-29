import './bootstrap';

document.addEventListener('DOMContentLoaded', () => {
    let cart = 0;
    const cartCount = document.getElementById('cartCount');
    const drawer = document.getElementById('drawer');
    const drawerContent = document.getElementById('drawerContent');
    const drawerTitle = document.getElementById('drawerTitle');
    const toast = document.getElementById('toast');

    function showToast(message) {
        if (!toast) return;
        toast.textContent = message;
        toast.classList.add('show');
        clearTimeout(window.toastTimer);
        window.toastTimer = setTimeout(() => toast.classList.remove('show'), 1800);
    }

    document.querySelectorAll('.add-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            cart++;
            if (cartCount) cartCount.textContent = cart;
            const product = btn.dataset.product;
            if (drawerTitle) drawerTitle.textContent = 'Your cart';
            if (drawerContent) {
                drawerContent.innerHTML = `<strong>${cart} item${cart > 1 ? 's' : ''} in cart</strong><p style="margin-top:10px">${product} was added successfully.</p><button class="btn" style="background:#123522;color:#fff;margin-top:10px;width:100%">View cart</button>`;
            }
            showToast(product + ' added to cart');
        });
    });

    document.querySelectorAll('.wish').forEach(btn => {
        btn.addEventListener('click', () => {
            const icon = btn.querySelector('i');
            if (icon) {
                icon.classList.toggle('fa-regular');
                icon.classList.toggle('fa-solid');
                showToast(icon.classList.contains('fa-solid') ? 'Saved to wishlist' : 'Removed from wishlist');
            }
        });
    });

    const cartBtn = document.getElementById('cartBtn');
    if (cartBtn && drawer) {
        cartBtn.addEventListener('click', () => {
            if (drawerTitle) drawerTitle.textContent = 'Your cart';
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
            if (drawerTitle) drawerTitle.textContent = 'Navigation';
            if (drawerContent) {
                drawerContent.innerHTML = `
                    <div style="display:grid;gap:14px;font-weight:700">
                        <a href="#shop">Shop</a>
                        <a href="#plants">Plants</a>
                        <a href="#nurseries">Nurseries</a>
                        <a href="#problems">Plant Doctor</a>
                        <a href="#guides">Guides</a>
                        <a href="#news">News</a>
                    </div>`;
            }
            drawer.classList.add('open');
        });
    }

    const searchBtn = document.getElementById('searchBtn');
    if (searchBtn) {
        searchBtn.addEventListener('click', () => {
            const input = document.getElementById('mainSearch');
            const value = input ? input.value.trim() : '';
            showToast(value ? `Searching for "${value}"` : 'Choose a plant, product or guide');
        });
    }

    document.querySelectorAll('.problem-card').forEach(card => {
        card.addEventListener('click', () => {
            showToast(card.innerText.trim() + ' diagnosis selected');
        });
    });

    const subscribeForm = document.getElementById('subscribeForm');
    if (subscribeForm) {
        subscribeForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const emailInput = document.getElementById('emailInput');
            showToast('Thanks! Newsletter signup received.');
            if (emailInput) emailInput.value = '';
        });
    }

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && drawer) drawer.classList.remove('open');
    });
});
