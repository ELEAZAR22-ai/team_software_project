
document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('form');
    const nameInput = form.querySelector('input[type="text"]:first-of-type');
    const emailInput = form.querySelector('input[type="text"]:nth-of-type(2)');
    const phoneInput = form.querySelector('input[type="number"]');
    const genderInputs = form.querySelectorAll('input[name="gender"]');
    const STORAGE_KEY = 'sd_contacts_v1';

    // Nav highlight
    document.querySelectorAll('.header nav a').forEach(a => {
        try {
            if (a.getAttribute('href') === location.pathname.split('/').pop()) a.classList.add('active');
        } catch (e) { }
    });

    // Simple modal helper
    function showModal(title, message) {
        let modal = document.getElementById('simple-modal');
        if (!modal) {
            modal = document.createElement('div');
            modal.id = 'simple-modal';
            Object.assign(modal.style, {
                position: 'fixed', inset: '0', display: 'flex', alignItems: 'center', justifyContent: 'center',
                background: 'rgba(0,0,0,0.5)', zIndex: 9999, padding: '12px'
            });
            modal.innerHTML = '<div id="simple-modal-box" style="max-width:520px;width:100%;background:#fff;padding:18px;border-radius:10px;box-shadow:0 10px 30px rgba(0,0,0,.2)"></div>';
            modal.addEventListener('click', (e) => { if (e.target === modal) modal.remove(); });
            document.body.appendChild(modal);
        }
        const box = document.getElementById('simple-modal-box');
        box.innerHTML = `<h3 style="margin:0 0 8px">${title}</h3><div style="margin-bottom:12px">${message}</div><div style="text-align:right"><button id="modal-close" style="padding:8px 12px;border-radius:8px;border:0;background:#ef4444;color:#fff;cursor:pointer">Close</button></div>`;
        modal.style.display = 'flex';
        document.getElementById('modal-close').onclick = () => modal.remove();
    }

    function getSelectedGender() {
        for (const g of genderInputs) if (g.checked) return g.value;
        return '';
    }

    function validEmail(v) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v);
    }

    form.addEventListener('submit', (e) => {
        e.preventDefault();
        const name = (nameInput.value || '').trim();
        const email = (emailInput.value || '').trim();
        const phone = (phoneInput.value || '').toString().trim();
        const gender = getSelectedGender();

        if (!name) { alert('Please enter your full name.'); nameInput.focus(); return; }
        if (!email || !validEmail(email)) { alert('Please enter a valid email.'); emailInput.focus(); return; }
        if (!phone || phone.length < 7) { alert('Please enter a valid telephone number.'); phoneInput.focus(); return; }
        if (!gender) { alert('Please select gender.'); return; }

        const contacts = JSON.parse(localStorage.getItem(STORAGE_KEY) || '[]');
        const record = { id: Date.now(), name, email, phone, gender, createdAt: new Date().toISOString() };
        contacts.unshift(record);
        localStorage.setItem(STORAGE_KEY, JSON.stringify(contacts));

        showModal('Contact saved', `<strong>${name}</strong> — your contact was saved locally.<div class="small" style="margin-top:8px">You can view stored records in browser devtools (localStorage).</div>`);
        form.reset();
    });

    // optional: expose a quick console helper to view stored contacts
    window.getSavedContacts = () => JSON.parse(localStorage.getItem(STORAGE_KEY) || '[]');
});
