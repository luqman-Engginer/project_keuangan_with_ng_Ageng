/* ============================================================
   Pencatatan Keuangan: interaksi dasar
   ============================================================ */

// ---------- Dark mode (disimpan di localStorage) ----------
(function initTheme() {
    let saved = null;
    try { saved = localStorage.getItem('theme'); } catch (e) {}
    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    if (saved === 'dark' || (!saved && prefersDark)) {
        document.documentElement.classList.add('dark');
    }
})();

document.addEventListener('DOMContentLoaded', () => {
    // ---------- Tombol ganti tema ----------
    document.querySelectorAll('[data-theme-toggle]').forEach((btn) => {
        btn.addEventListener('click', () => {
            const isDark = document.documentElement.classList.toggle('dark');
            try { localStorage.setItem('theme', isDark ? 'dark' : 'light'); } catch (e) {}
        });
    });

    // ---------- Sidebar mobile ----------
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebar-overlay');
    const open = () => { sidebar?.classList.remove('-translate-x-full'); overlay?.classList.remove('hidden'); };
    const close = () => { sidebar?.classList.add('-translate-x-full'); overlay?.classList.add('hidden'); };
    document.getElementById('sidebar-toggle')?.addEventListener('click', open);
    overlay?.addEventListener('click', close);

    // ---------- Toast (dari pesan flash server) ----------
    const stack = document.getElementById('toast-stack');
    const icons = {
        success: '<svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>',
        error: '<svg class="w-5 h-5 text-rose-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
    };
    const showToast = (type, title, body) => {
        if (!stack) return;
        const t = document.createElement('div');
        t.className = `toast toast-${type}`;
        t.setAttribute('role', 'status');
        const wrap = document.createElement('div');
        wrap.className = 'min-w-0 flex-1 text-sm';
        const h = document.createElement('p');
        h.className = 'font-semibold';
        h.textContent = title;
        wrap.appendChild(h);
        if (body) {
            const p = document.createElement('p');
            p.className = 'mt-0.5';
            p.style.color = 'var(--muted)';
            p.textContent = body;
            wrap.appendChild(p);
        }
        t.insertAdjacentHTML('afterbegin', icons[type] || icons.success);
        t.appendChild(wrap);
        t.insertAdjacentHTML('beforeend', '<span class="bar"></span>');
        stack.appendChild(t);
        const dismiss = () => { t.classList.add('out'); setTimeout(() => t.remove(), 200); };
        t.addEventListener('click', dismiss);
        setTimeout(dismiss, 4500);
    };
    document.querySelectorAll('[data-flash]').forEach((el) => {
        showToast(el.dataset.flash, el.dataset.title || '', el.dataset.body || '');
        el.remove();
    });

    // ---------- Modal konfirmasi pengganti confirm() ----------
    const confirmModal = (message) => new Promise((resolve) => {
        const back = document.createElement('div');
        back.className = 'modal-backdrop';
        back.innerHTML = `
            <div class="modal-box" role="dialog" aria-modal="true">
                <div class="mb-4 flex h-11 w-11 items-center justify-center rounded-lg bg-rose-50 text-rose-600">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.3 3.4c-.87 1.5.22 3.37 1.95 3.37h14.7c1.73 0 2.81-1.87 1.95-3.37L13.95 3.38c-.87-1.5-3.03-1.5-3.9 0L2.7 16.13zM12 15.75h.01"/></svg>
                </div>
                <h3 class="text-base font-semibold">Konfirmasi</h3>
                <p class="mt-1.5 text-sm" style="color:var(--muted)"></p>
                <div class="mt-6 flex justify-end gap-2">
                    <button type="button" data-no class="btn-secondary btn-sm">Batal</button>
                    <button type="button" data-yes class="btn-danger btn-sm">Ya, lanjutkan</button>
                </div>
            </div>`;
        back.querySelector('p').textContent = message;
        const done = (v) => { back.remove(); document.removeEventListener('keydown', onKey); resolve(v); };
        const onKey = (e) => { if (e.key === 'Escape') done(false); };
        back.addEventListener('click', (e) => { if (e.target === back) done(false); });
        back.querySelector('[data-no]').addEventListener('click', () => done(false));
        back.querySelector('[data-yes]').addEventListener('click', () => done(true));
        document.addEventListener('keydown', onKey);
        document.body.appendChild(back);
        back.querySelector('[data-yes]').focus();
    });

    document.querySelectorAll('[data-confirm]').forEach((btn) => {
        btn.addEventListener('click', async (e) => {
            e.preventDefault();
            const form = btn.closest('form');
            if (await confirmModal(btn.getAttribute('data-confirm'))) {
                if (form) { form.requestSubmit ? form.requestSubmit() : form.submit(); }
            }
        });
    });

    // ---------- Tombol loading saat submit (cegah klik ganda) ----------
    document.querySelectorAll('form').forEach((form) => {
        form.addEventListener('submit', () => {
            const submit = form.querySelector('button[type="submit"]:not([data-confirm])');
            if (submit && form.checkValidity()) {
                setTimeout(() => submit.classList.add('is-loading'), 0);
            }
        });
    });
});

// ---------- Tampilkan / sembunyikan kata sandi ----------
document.addEventListener('click', (e) => {
    const btn = e.target.closest('[data-toggle-pw]');
    if (!btn) return;
    const input = document.getElementById(btn.dataset.togglePw);
    if (!input) return;
    const show = input.type === 'password';
    input.type = show ? 'text' : 'password';
    btn.setAttribute('aria-label', show ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi');
    btn.classList.toggle('text-indigo-600', show);
});
