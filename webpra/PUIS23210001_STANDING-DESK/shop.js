document.addEventListener('DOMContentLoaded', () => {
    const STORAGE_KEY = 'sd_shop_cart_v1';

    // Read persisted cart or start empty
    let cart = JSON.parse(localStorage.getItem(STORAGE_KEY) || '[]');

    // Helpers
    const toNumber = s => {
        if (s == null) return 0;
        const m = String(s).match(/[\d,.]+/);
        if (!m) return 0;
        return parseFloat(m[0].replace(/,/g, '')) || 0;
    };

    const formatGHS = n => `GHS ${Number(n).toFixed(2)}`;

    // Find product cards and build product list
    const productCards = Array.from(document.querySelectorAll('.product-card'));

    if (productCards.length === 0) {
        console.warn('No product cards found. Check your HTML structure.');
    }

    const products = productCards.map((card, idx) => {
        const titleEl = card.querySelector('h1') || card.querySelector('h2') || card.querySelector('h3');
        const desc = titleEl ? titleEl.textContent.trim() : `Product ${idx + 1}`;
        const imgEl = card.querySelector('img');
        const img = imgEl ? imgEl.getAttribute('src') : '';

        // Parse price from data-price first
        let price = card.dataset.price ? toNumber(card.dataset.price) : 0;

        // If no price found, try p tags
        if (!price) {
            const pTags = card.querySelectorAll('p');
            pTags.forEach(p => {
                const parsed = toNumber(p.textContent);
                if (parsed > 0) price = parsed;
            });
        }

        return {
            id: `p${idx}`,
            title: desc,
            price: price || 0,
            img,
            node: card
        };
    });

    console.log('Products loaded:', products);

    // Build small floating cart panel
    let panel = document.getElementById('sd-cart-panel');
    if (!panel) {
        panel = document.createElement('aside');
        panel.id = 'sd-cart-panel';
        Object.assign(panel.style, {
            position: 'fixed',
            right: '18px',
            bottom: '18px',
            width: '320px',
            maxHeight: '60vh',
            overflowY: 'auto',
            background: '#fff',
            borderRadius: '12px',
            boxShadow: '0 10px 30px rgba(0,0,0,0.12)',
            padding: '12px',
            zIndex: '9999',
            fontFamily: 'Inter, Arial, sans-serif',
            border: '1px solid #e6e6e6'
        });
        document.body.appendChild(panel);
    }

    function saveCart() {
        try {
            localStorage.setItem(STORAGE_KEY, JSON.stringify(cart));
        } catch (e) {
            console.error('Failed to save cart:', e);
        }
    }

    function addToCart(productId, qty = 1) {
        const prod = products.find(p => p.id === productId);
        if (!prod) {
            console.error('Product not found:', productId);
            return;
        }

        const item = cart.find(c => c.id === productId);
        if (item) {
            item.qty += qty;
        } else {
            cart.push({
                id: prod.id,
                title: prod.title,
                price: prod.price,
                img: prod.img,
                qty
            });
        }
        saveCart();
        renderCart();
        flashToast(`${prod.title} added to cart`);
    }

    function removeFromCart(productId) {
        cart = cart.filter(i => i.id !== productId);
        saveCart();
        renderCart();
    }

    function clearCart() {
        cart = [];
        saveCart();
        renderCart();
    }

    function cartTotals() {
        const count = cart.reduce((s, i) => s + (i.qty || 0), 0);
        const total = cart.reduce((s, i) => s + (i.qty || 0) * (i.price || 0), 0);
        return { count, total };
    }

    // Update all cart-count and total-price elements
    function updateSummaryFields() {
        const { count, total } = cartTotals();
        const countEls = document.querySelectorAll('#cart-count');
        const totalEls = document.querySelectorAll('#total-price');

        countEls.forEach(el => {
            if (el) el.textContent = count;
        });
        totalEls.forEach(el => {
            if (el) el.textContent = formatGHS(total);
        });
    }

    function renderCart() {
        if (!panel) return;

        updateSummaryFields();
        panel.innerHTML = `
      <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;padding-bottom:8px;border-bottom:1px solid #f1f1f1">
        <strong style="font-size:1.1rem">Shopping Cart</strong>
        <button id="sd-clear-cart" style="background:#ef4444;border:none;color:#fff;padding:6px 10px;border-radius:6px;cursor:pointer;font-size:0.85rem">Clear</button>
      </div>`;

        if (cart.length === 0) {
            panel.innerHTML += '<div style="color:#999;font-size:0.95rem;text-align:center;padding:20px 0">Cart is empty</div>';
        } else {
            cart.forEach(item => {
                const row = document.createElement('div');
                row.style.cssText = 'display:flex;gap:8px;align-items:flex-start;padding:8px 0;border-bottom:1px solid #f9f9f9';

                row.innerHTML = `
          <div style="width:50px;height:50px;flex:0 0 50px;border-radius:6px;overflow:hidden;background:#f6f6f6">
            ${item.img ? `<img src="${item.img}" alt="${item.title}" style="width:100%;height:100%;object-fit:cover">` : '<div style="width:100%;height:100%;background:#ddd"></div>'}
          </div>
          <div style="flex:1;min-width:0">
            <div style="font-weight:600;font-size:0.95rem;word-break:break-word">${item.title}</div>
            <div style="font-size:0.85rem;color:#666;margin-top:4px">${item.qty} × ${formatGHS(item.price)}</div>
          </div>
          <div style="text-align:right;flex:0 0 auto">
            <div style="font-weight:700;font-size:0.95rem">${formatGHS(item.qty * item.price)}</div>
            <button data-remove="${item.id}" style="background:transparent;border:none;color:#ef4444;cursor:pointer;margin-top:4px;font-size:0.85rem;text-decoration:underline">Remove</button>
          </div>`;

                panel.appendChild(row);
            });
        }

        const { total } = cartTotals();
        const footer = document.createElement('div');
        footer.style.cssText = 'border-top:2px solid #f1f1f1;padding-top:10px;margin-top:8px';
        footer.innerHTML = `
      <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:10px;font-weight:700">
        <span>Total</span>
        <span style="color:#e74c3c;font-size:1.1rem">${formatGHS(total)}</span>
      </div>
      <div style="display:flex;gap:6px">
        <button id="sd-checkout" style="flex:1;padding:10px;border-radius:6px;border:0;background:#10b981;color:#fff;cursor:pointer;font-weight:600">Checkout</button>
        <button id="sd-close-panel" style="padding:10px;border-radius:6px;border:1px solid #e6e6e6;background:#fff;cursor:pointer;font-weight:600">Close</button>
      </div>`;

        panel.appendChild(footer);

        // Wire up event listeners
        const clearBtn = document.getElementById('sd-clear-cart');
        if (clearBtn) clearBtn.addEventListener('click', clearCart);

        const checkoutBtn = document.getElementById('sd-checkout');
        if (checkoutBtn) checkoutBtn.addEventListener('click', simulatePayment);

        const closeBtn = document.getElementById('sd-close-panel');
        if (closeBtn) closeBtn.addEventListener('click', () => {
            panel.style.display = 'none';
        });

        panel.querySelectorAll('[data-remove]').forEach(btn => {
            btn.addEventListener('click', () => {
                removeFromCart(btn.dataset.remove);
            });
        });

        panel.style.display = 'block';
    }

    // Attach add-to-cart to each product card button
    productCards.forEach((card, idx) => {
        const btn = card.querySelector('button');
        const prod = products[idx];

        if (!btn || !prod) {
            console.warn(`Product ${idx} missing button or product data`);
            return;
        }

        btn.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();

            // Re-parse price if not found initially
            if (!prod.price || prod.price === 0) {
                const priceStr = card.dataset.price || '';
                if (priceStr) prod.price = toNumber(priceStr);
            }

            if (prod.price === 0) {
                console.warn(`Product ${idx} has no price set`, prod);
            }

            addToCart(prod.id, 1);
        });
    });

    // Simulated payment
    function simulatePayment() {
        if (cart.length === 0) {
            alert('Cart is empty');
            return;
        }

        const { total } = cartTotals();
        const ticketNo = 'SB-' + Math.floor(100000 + Math.random() * 900000);
        const time = new Date().toLocaleString();
        const itemsList = cart.map(i =>
            `<li>${i.qty} × ${i.title} — ${formatGHS(i.price * i.qty)}</li>`
        ).join('');

        const receiptHtml = `
      <div style="padding:12px">
        <h3 style="margin:0 0 8px;color:#10b981">Payment successful ✓</h3>
        <div style="margin-bottom:8px"><strong>Reference:</strong> ${ticketNo}</div>
        <div style="margin-bottom:6px"><strong>Items:</strong></div>
        <ul style="padding-left:18px;margin:0;margin-bottom:8px">${itemsList}</ul>
        <div style="margin-bottom:8px"><strong>Total paid:</strong> <span style="color:#e74c3c;font-weight:700">${formatGHS(total)}</span></div>
        <div style="color:#666;font-size:0.9rem">Time: ${time}</div>
      </div>`;

        showModal('Receipt', receiptHtml);
        clearCart();
    }

    // Modal helper
    let modalRoot = document.getElementById('sd-modal-root');
    if (!modalRoot) {
        modalRoot = document.createElement('div');
        modalRoot.id = 'sd-modal-root';
        Object.assign(modalRoot.style, {
            position: 'fixed',
            inset: '0',
            display: 'none',
            alignItems: 'center',
            justifyContent: 'center',
            background: 'rgba(0,0,0,0.5)',
            zIndex: '10000',
            padding: '12px'
        });

        const box = document.createElement('div');
        box.id = 'sd-modal-box';
        box.style.cssText = 'background:#fff;border-radius:12px;max-width:560px;width:100%;padding:20px;box-shadow:0 20px 60px rgba(0,0,0,0.3)';

        modalRoot.appendChild(box);
        document.body.appendChild(modalRoot);

        modalRoot.addEventListener('click', (e) => {
            if (e.target === modalRoot) modalRoot.style.display = 'none';
        });
    }

    function showModal(title, bodyHtml) {
        const box = document.getElementById('sd-modal-box');
        if (!box) return;

        box.innerHTML = `
      <h3 style="margin:0 0 12px">${title}</h3>
      ${bodyHtml}
      <div style="text-align:right;margin-top:16px">
        <button id="sd-modal-close" style="padding:10px 16px;border-radius:6px;border:0;background:#ef4444;color:#fff;cursor:pointer;font-weight:600">Close</button>
      </div>`;

        const closeBtn = document.getElementById('sd-modal-close');
        if (closeBtn) {
            closeBtn.addEventListener('click', () => {
                modalRoot.style.display = 'none';
            });
        }

        modalRoot.style.display = 'flex';
    }

    // Toast notification
    function flashToast(msg) {
        const id = 'sd-toast';
        let t = document.getElementById(id);

        if (!t) {
            t = document.createElement('div');
            t.id = id;
            Object.assign(t.style, {
                position: 'fixed',
                left: '50%',
                transform: 'translateX(-50%)',
                bottom: '24px',
                background: '#111',
                color: '#fff',
                padding: '10px 16px',
                borderRadius: '6px',
                zIndex: '11000',
                fontSize: '0.95rem',
                opacity: '1',
                transition: 'opacity 0.3s ease'
            });
            document.body.appendChild(t);
        }

        t.textContent = msg;
        t.style.opacity = '1';

        clearTimeout(t.timeoutId);
        t.timeoutId = setTimeout(() => {
            t.style.opacity = '0';
        }, 2500);
    }

    // Expose helpers for debugging
    window.sdShop = {
        addToCart,
        removeFromCart,
        clearCart,
        getCart: () => JSON.parse(JSON.stringify(cart)),
        getProducts: () => products
    };

    console.log('Shop initialized. Use window.sdShop for debugging.');

    // Initial render
    renderCart();
});