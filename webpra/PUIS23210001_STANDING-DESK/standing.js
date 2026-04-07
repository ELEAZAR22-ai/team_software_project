
document.addEventListener('DOMContentLoaded', () => {
    // NAV HIGHLIGHT
    const navLinks = document.querySelectorAll('header nav a');
    const current = window.location.pathname.split('/').pop();
    navLinks.forEach(a => {
        if (a.getAttribute('href') === current) a.classList.add('active');
        a.addEventListener('click', () => {
            navLinks.forEach(n => n.classList.remove('active'));
            a.classList.add('active');
        });
    });

    // LIGHTBOX / IMAGE MODAL
    const images = document.querySelectorAll('.card img');
    const modal = document.createElement('div');
    modal.id = 'image-modal';
    Object.assign(modal.style, {
        position: 'fixed', inset: '0', display: 'none', alignItems: 'center', justifyContent: 'center',
        background: 'rgba(0,0,0,0.7)', zIndex: 9999, padding: '24px'
    });
    const modalInner = document.createElement('div');
    Object.assign(modalInner.style, { maxWidth: '920px', width: '100%', textAlign: 'center' });
    const modalImg = document.createElement('img');
    Object.assign(modalImg.style, { maxWidth: '100%', maxHeight: '80vh', borderRadius: '8px', boxShadow: '0 10px 30px rgba(0,0,0,.5)' });
    const modalCap = document.createElement('div');
    Object.assign(modalCap.style, { color: '#fff', marginTop: '10px', fontSize: '0.95rem' });
    modalInner.appendChild(modalImg);
    modalInner.appendChild(modalCap);
    modal.appendChild(modalInner);
    document.body.appendChild(modal);

    images.forEach(img => {
        img.style.cursor = 'zoom-in';
        img.addEventListener('click', () => {
            modalImg.src = img.src;
            modalCap.textContent = img.closest('.card')?.querySelector('h3')?.textContent || '';
            modal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
            modal.focus();
        });
    });

    modal.addEventListener('click', (e) => {
        if (e.target === modal) closeModal();
    });
    function closeModal() {
        modal.style.display = 'none';
        document.body.style.overflow = '';
    }
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            closeModal();
            closeCart();
        }
    });

    // CART PANEL (simple)
    const cartBtn = document.querySelector('.cart');
    const cartPanel = document.createElement('aside');
    cartPanel.id = 'cart-panel';
    Object.assign(cartPanel.style, {
        position: 'fixed', right: '-360px', top: 0, height: '100%', width: '340px', background: '#fff',
        boxShadow: '-8px 0 30px rgba(0,0,0,.12)', transition: 'right .28s ease', zIndex: 9998, padding: '18px', overflowY: 'auto'
    });
    cartPanel.innerHTML = '<h3 style="margin-top:0">Cart</h3><div id="cart-items" style="min-height:120px">No items</div><div style="margin-top:12px"><button id="clear-cart" style="background:#ef4444;color:#fff;border:0;padding:8px 12px;border-radius:8px;cursor:pointer">Clear</button></div>';
    document.body.appendChild(cartPanel);

    cartBtn?.addEventListener('click', toggleCart);

    function toggleCart() {
        if (cartPanel.style.right === '0px') closeCart(); else openCart();
    }
    function openCart() { cartPanel.style.right = '0px'; }
    function closeCart() { cartPanel.style.right = '-360px'; }

    document.getElementById('clear-cart')?.addEventListener('click', () => {
        document.getElementById('cart-items').textContent = 'No items';
    });

    // Add-to-cart by double-clicking a card (demo)
    document.querySelectorAll('.card').forEach(card => {
        card.addEventListener('dblclick', () => {
            const title = card.querySelector('h3')?.textContent || 'Item';
            addToCart(title);
            openCart();
        });
    });

    function addToCart(title) {
        const items = document.getElementById('cart-items');
        if (!items) return;
        if (items.textContent === 'No items') items.innerHTML = '';
        const li = document.createElement('div');
        li.textContent = title;
        li.style.padding = '8px 0';
        items.appendChild(li);
    }

    // Improve accessibility: allow Enter on focused card image to open modal
    images.forEach(img => img.tabIndex = 0);

});
