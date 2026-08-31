/**
 * Admin Panel Asynchronous Operations (AJAX / Fetch)
 */

document.addEventListener('DOMContentLoaded', () => {
    // --- Admin Toast Notification System ---
    let adminToastContainer = document.getElementById('adminToastContainer');
    if (!adminToastContainer) {
        adminToastContainer = document.createElement('div');
        adminToastContainer.id = 'adminToastContainer';
        adminToastContainer.style.cssText = 'position:fixed;bottom:24px;right:24px;z-index:9999;display:flex;flex-direction:column;gap:10px;pointer-events:none;';
        document.body.appendChild(adminToastContainer);
    }

    function showAdminToast(message, type = 'success') {
        const toast = document.createElement('div');
        toast.style.cssText = `
            background: ${type === 'success' ? '#0f392b' : '#991b1b'};
            color: #ffffff;
            padding: 12px 20px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.18);
            font-size: 14px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            pointer-events: auto;
        `;

        const icon = document.createElement('i');
        icon.className = type === 'success' ? 'fa-solid fa-circle-check text-success' : 'fa-solid fa-triangle-exclamation text-warning';
        toast.appendChild(icon);

        const textSpan = document.createElement('span');
        textSpan.innerHTML = message;
        toast.appendChild(textSpan);

        adminToastContainer.appendChild(toast);

        requestAnimationFrame(() => {
            toast.style.opacity = '1';
            toast.style.transform = 'translateY(0)';
        });

        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transform = 'translateY(20px)';
            setTimeout(() => toast.remove(), 300);
        }, 3500);
    }

    window.showAdminToast = showAdminToast;

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

    // --- 1. Admin Delete Forms (AJAX / Fetch) ---
    document.body.addEventListener('submit', async (e) => {
        const form = e.target.closest('form');
        if (!form) return;

        // Intercept delete forms or forms marked with .ajax-delete-form
        const methodInput = form.querySelector('input[name="_method"]');
        const isDelete = (methodInput && methodInput.value.toUpperCase() === 'DELETE') || form.classList.contains('ajax-delete-form');

        if (isDelete) {
            e.preventDefault();

            if (!confirm('Are you sure you want to delete this record? This action cannot be undone.')) {
                return;
            }

            const action = form.action;
            const row = form.closest('tr') || form.closest('.card-custom') || form.closest('.list-group-item');

            try {
                const response = await fetch(action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: new URLSearchParams(new FormData(form))
                });

                const data = await response.json();

                if (response.ok && data.success !== false) {
                    showAdminToast(data.message || 'Record deleted successfully.');

                    if (row) {
                        row.style.transition = 'all 0.35s ease';
                        row.style.opacity = '0';
                        row.style.transform = 'scale(0.95)';
                        setTimeout(() => row.remove(), 350);
                    }
                } else {
                    showAdminToast(data.message || 'Failed to delete record.', 'error');
                }
            } catch (err) {
                // If endpoint didn't return JSON, fallback to standard submit
                form.submit();
            }
        }
    });

    // --- 2. Order Status Quick Dropdown (AJAX / Fetch) ---
    document.body.addEventListener('change', async (e) => {
        const select = e.target.closest('.ajax-order-status-select');
        if (!select) return;

        const orderId = select.dataset.orderId;
        const newStatus = select.value;

        if (!orderId || !newStatus) return;

        try {
            const response = await fetch(`/admin/orders/${orderId}/status`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    _method: 'PATCH',
                    status: newStatus
                })
            });

            const data = await response.json();

            if (response.ok && data.success) {
                showAdminToast(data.message || 'Order status updated.');
                // Update badge color if badge element exists
                const badge = select.closest('tr')?.querySelector('.status-badge');
                if (badge && data.status_badge) {
                    badge.className = `badge ${data.status_badge} status-badge`;
                    badge.textContent = data.status_label || newStatus;
                }
            } else {
                showAdminToast(data.message || 'Failed to update status.', 'error');
            }
        } catch (err) {
            showAdminToast('Network error updating status.', 'error');
        }
    });

    // --- 3. Review Status Moderation Quick Switch (AJAX / Fetch) ---
    document.body.addEventListener('change', async (e) => {
        const select = e.target.closest('.ajax-review-status-select');
        if (!select) return;

        const reviewId = select.dataset.reviewId;
        const newStatus = select.value;

        if (!reviewId || !newStatus) return;

        try {
            const response = await fetch(`/admin/reviews/${reviewId}/status`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    _method: 'PATCH',
                    status: newStatus
                })
            });

            const data = await response.json();

            if (response.ok && data.success) {
                showAdminToast(data.message || 'Review status updated.');
            } else {
                showAdminToast(data.message || 'Failed to update review status.', 'error');
            }
        } catch (err) {
            showAdminToast('Error updating review status.', 'error');
        }
    });

    // --- 4. Plant & Post Quick Duplicate (AJAX / Fetch) ---
    document.body.addEventListener('click', async (e) => {
        const btn = e.target.closest('.ajax-duplicate-btn');
        if (!btn) return;

        e.preventDefault();
        const url = btn.href || btn.dataset.url;

        if (!url) return;

        btn.disabled = true;
        const origText = btn.innerHTML;
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-1"></i> Duplicating...';

        try {
            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                }
            });

            const data = await response.json();

            if (response.ok && data.success) {
                showAdminToast(data.message + ` <a href="${data.edit_url}" class="text-white text-decoration-underline ms-1">Edit Draft ➔</a>`);
            } else {
                showAdminToast(data.message || 'Duplication failed.', 'error');
            }
        } catch (err) {
            window.location.href = url; // Fallback to normal navigation
        } finally {
            btn.disabled = false;
            btn.innerHTML = origText;
        }
    });
});
