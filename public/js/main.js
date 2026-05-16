document.addEventListener('DOMContentLoaded', () => {
    // ===================== NAV TOGGLE MOBILE =====================
    const toggle = document.querySelector('.nav-toggle');
    const menu = document.querySelector('#primary-menu');

    if (toggle && menu) {
        toggle.addEventListener('click', () => {
            const isOpen = menu.classList.toggle('open');
            toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        });

        document.addEventListener('click', (e) => {
            if (!toggle.contains(e.target) && !menu.contains(e.target)) {
                menu.classList.remove('open');
                toggle.setAttribute('aria-expanded', 'false');
            }
        });
    }

    // ===================== USER DROPDOWN =====================
    const dropdownToggle = document.querySelector('.dropdown-toggle');
    const dropdownMenu = document.querySelector('.dropdown-menu');

    if (dropdownToggle && dropdownMenu) {
        dropdownToggle.addEventListener('click', (e) => {
            e.preventDefault();
            const isOpen = dropdownMenu.classList.toggle('open');
            dropdownToggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        });

        document.addEventListener('click', (e) => {
            if (!dropdownToggle.contains(e.target) && !dropdownMenu.contains(e.target)) {
                dropdownMenu.classList.remove('open');
                dropdownToggle.setAttribute('aria-expanded', 'false');
            }
        });
    }

    // ===================== CART COUNT UPDATE =====================
    function updateCartCount() {
        const badge = document.querySelector('#cart-count-badge');
        if (!badge) return;

        fetch(app_url('cart/count'))
            .then(res => res.json())
            .then(data => {
                const count = parseInt(data.count) || 0;
                badge.textContent = count;
                badge.style.display = count > 0 ? 'flex' : 'none';
            })
            .catch(() => {});
    }

    // ===================== ADD TO CART HANDLER =====================
    document.addEventListener('submit', (e) => {
        const form = e.target.closest('form[action*="cart/add"]');
        if (!form) return;

        e.preventDefault();
        const formData = new FormData(form);

        fetch(form.action, { method: 'POST', body: formData })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    updateCartCount();
                    showToast(data.message || 'Producto agregado al carrito', 'success');
                } else {
                    showToast(data.error || 'Error al agregar al carrito', 'error');
                }
            })
            .catch(() => {
                showToast('Error de conexión', 'error');
            });
    });

    // ===================== WHATSAPP CLICK TRACKING =====================
    const whatsappBtn = document.querySelector('#whatsapp-button');
    if (whatsappBtn) {
        whatsappBtn.addEventListener('click', () => {
            if (typeof gtag === 'function') {
                gtag('event', 'click', {
                    event_category: 'contact',
                    event_label: 'whatsapp_float'
                });
            }
        });
    }

    // ===================== COOKIE CONSENT =====================
    const cookieBanner = document.querySelector('#cookie-consent');
    const cookieAccept = document.querySelector('#cookie-accept');

    if (cookieBanner && cookieAccept) {
        if (!localStorage.getItem('cookie_consent')) {
            cookieBanner.style.display = 'flex';
        }

        cookieAccept.addEventListener('click', () => {
            localStorage.setItem('cookie_consent', 'accepted');
            cookieBanner.style.display = 'none';
        });
    }

    // ===================== SMOOTH SCROLL =====================
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', (e) => {
            const targetId = anchor.getAttribute('href');
            if (targetId === '#') return;

            const target = document.querySelector(targetId);
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });

    // ===================== CONTACT FORM VALIDATION =====================
    const contactForm = document.querySelector('form[action*="contact"]');
    if (contactForm) {
        contactForm.addEventListener('submit', (e) => {
            const name = contactForm.querySelector('[name="nombre"]');
            const email = contactForm.querySelector('[name="email"]');
            const message = contactForm.querySelector('[name="mensaje"]');
            let isValid = true;

            contactForm.querySelectorAll('.field-error').forEach(el => el.remove());

            if (name && !name.value.trim()) {
                showFieldError(name, 'El nombre es obligatorio');
                isValid = false;
            }

            if (email && !isValidEmail(email.value)) {
                showFieldError(email, 'Ingresa un correo válido');
                isValid = false;
            }

            if (message && !message.value.trim()) {
                showFieldError(message, 'El mensaje no puede estar vacío');
                isValid = false;
            }

            if (!isValid) e.preventDefault();
        });
    }

    // ===================== TOAST NOTIFICATIONS =====================
    function showToast(message, type) {
        const existing = document.querySelector('.toast-notification');
        if (existing) existing.remove();

        const toast = document.createElement('div');
        toast.className = 'toast-notification toast-' + (type || 'info');
        toast.textContent = message;
        toast.setAttribute('role', 'alert');
        document.body.appendChild(toast);

        toast.classList.add('toast-show');

        setTimeout(() => {
            toast.classList.remove('toast-show');
            setTimeout(() => toast.remove(), 300);
        }, 3500);
    }

    function showFieldError(field, message) {
        const error = document.createElement('span');
        error.className = 'field-error';
        error.textContent = message;
        field.parentNode.insertBefore(error, field.nextSibling);
        field.classList.add('input-error');
    }

    function isValidEmail(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }

    // ===================== CHECKOUT TOTALS =====================
    const totalNode = document.querySelector('#checkout-total');
    const servicesNode = document.querySelector('#services-total');
    const serviceChecks = document.querySelectorAll('input[name="servicios[]"]');

    if (totalNode && servicesNode && serviceChecks.length) {
        const formatter = new Intl.NumberFormat('es-PE', {
            style: 'currency',
            currency: 'PEN'
        });

        const updateTotals = () => {
            const base = Number(totalNode.dataset.base || 0);
            let services = 0;

            serviceChecks.forEach((check) => {
                if (check.checked) {
                    services += Number(check.dataset.price || 0);
                }
            });

            servicesNode.textContent = formatter.format(services).replace('PEN', 'S/.');
            totalNode.textContent = formatter.format(base + services).replace('PEN', 'S/.');
        };

        serviceChecks.forEach((check) => check.addEventListener('change', updateTotals));
        updateTotals();
    }

    // ===================== MODAL =====================
    function openModal(html) {
        const overlay = document.createElement('div');
        overlay.className = 'modal-overlay';
        overlay.innerHTML = `<div class="modal relative">${html}</div>`;
        overlay.addEventListener('click', (e) => {
            if (e.target === overlay) closeModal(overlay);
        });
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') closeModal(overlay);
        }, { once: true });
        document.body.appendChild(overlay);
        document.body.style.overflow = 'hidden';
    }

    function closeModal(overlay) {
        overlay.style.animation = 'fadeIn 0.2s ease-out reverse';
        setTimeout(() => {
            overlay.remove();
            document.body.style.overflow = '';
        }, 200);
    }

    window.openModal = openModal;
    window.closeModal = closeModal;

    // ===================== INIT =====================
    updateCartCount();

    // Initialize Lucide icons
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
});
