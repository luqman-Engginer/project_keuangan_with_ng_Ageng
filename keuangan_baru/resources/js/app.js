/* ============================================================
   Pencatatan Keuangan: interaksi & animasi
   ============================================================ */

const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

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

    // ---------- Reveal berurutan saat muncul di layar ----------
    const revealEls = document.querySelectorAll('[data-reveal]');
    if (reduceMotion || !('IntersectionObserver' in window)) {
        revealEls.forEach((el) => el.classList.add('is-visible'));
    } else {
        revealEls.forEach((el, i) => {
            if (!el.style.getPropertyValue('--d')) {
                el.style.setProperty('--d', `${Math.min(i, 8) * 70}ms`);
            }
        });
        const io = new IntersectionObserver((entries) => {
            entries.forEach((e) => {
                if (e.isIntersecting) {
                    e.target.classList.add('is-visible');
                    io.unobserve(e.target);
                }
            });
        }, { threshold: 0.08 });
        revealEls.forEach((el) => io.observe(el));
    }

    // ---------- Hitung naik (count-up) untuk angka Rupiah ----------
    const fmt = new Intl.NumberFormat('id-ID');
    document.querySelectorAll('[data-count]').forEach((el) => {
        const target = Number(el.dataset.count) || 0;
        const prefix = el.dataset.prefix ?? 'Rp ';
        if (reduceMotion || target === 0) { el.textContent = prefix + fmt.format(target); return; }
        const duration = 1400;
        const start = performance.now();
        const tick = (now) => {
            const p = Math.min((now - start) / duration, 1);
            const eased = 1 - Math.pow(1 - p, 4); // easeOutQuart
            el.textContent = prefix + fmt.format(Math.round(target * eased));
            if (p < 1) requestAnimationFrame(tick);
        };
        requestAnimationFrame(tick);
    });

    // ---------- Progress bar animasi ----------
    document.querySelectorAll('[data-progress]').forEach((el) => {
        const w = el.dataset.progress;
        el.style.width = '0%';
        requestAnimationFrame(() => setTimeout(() => { el.style.width = w + '%'; }, 250));
    });

    // ---------- Efek tilt 3D + cahaya mengikuti kursor ----------
    if (!reduceMotion && window.matchMedia('(hover: hover)').matches) {
        document.querySelectorAll('[data-tilt]').forEach((card) => {
            card.addEventListener('mouseenter', () => {
                card.style.transition = 'transform .18s ease-out, box-shadow .4s ease';
                card.style.transitionDelay = '0ms';
            });
            card.addEventListener('mousemove', (e) => {
                const r = card.getBoundingClientRect();
                const x = e.clientX - r.left;
                const y = e.clientY - r.top;
                const rx = ((y / r.height) - 0.5) * -10;
                const ry = ((x / r.width) - 0.5) * 12;
                card.style.transform = `perspective(900px) rotateX(${rx}deg) rotateY(${ry}deg) translateY(-4px)`;
                card.style.setProperty('--mx', x + 'px');
                card.style.setProperty('--my', y + 'px');
            });
            card.addEventListener('mouseleave', () => { card.style.transform = ''; });
        });
    }

    // ---------- Ripple pada tombol ----------
    document.addEventListener('click', (e) => {
        const btn = e.target.closest('.btn-primary, .btn-success, .btn-danger, .btn-secondary');
        if (!btn || reduceMotion) return;
        const r = btn.getBoundingClientRect();
        const size = Math.max(r.width, r.height);
        const dot = document.createElement('span');
        dot.className = 'ripple';
        dot.style.width = dot.style.height = size + 'px';
        dot.style.left = e.clientX - r.left - size / 2 + 'px';
        dot.style.top = e.clientY - r.top - size / 2 + 'px';
        btn.appendChild(dot);
        setTimeout(() => dot.remove(), 700);
    });

    // ---------- Toast (dari pesan flash server) ----------
    const stack = document.getElementById('toast-stack');
    const icons = {
        success: '<svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>',
        error: '<svg class="w-5 h-5 text-rose-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
    };
    const showToast = (type, title, body) => {
        if (!stack) return;
        const t = document.createElement('div');
        t.className = `toast toast-${type}`;
        t.setAttribute('role', 'status');
        const wrap = document.createElement('div');
        wrap.className = 'min-w-0 flex-1 text-sm';
        const h = document.createElement('p');
        h.className = 'font-bold';
        h.textContent = title;
        wrap.appendChild(h);
        if (body) {
            const p = document.createElement('p');
            p.className = 'mt-0.5 opacity-80';
            p.textContent = body;
            wrap.appendChild(p);
        }
        t.insertAdjacentHTML('afterbegin', icons[type]);
        t.appendChild(wrap);
        t.insertAdjacentHTML('beforeend', '<span class="bar"></span>');
        stack.appendChild(t);
        const dismiss = () => { t.classList.add('out'); setTimeout(() => t.remove(), 350); };
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
                <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-rose-500/15 text-rose-500">
                    <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.3 3.4c-.87 1.5.22 3.37 1.95 3.37h14.7c1.73 0 2.81-1.87 1.95-3.37L13.95 3.38c-.87-1.5-3.03-1.5-3.9 0L2.7 16.13zM12 15.75h.01"/></svg>
                </div>
                <h3 class="text-lg font-extrabold">Konfirmasi</h3>
                <p class="mt-2 text-sm" style="color:var(--muted)"></p>
                <div class="mt-6 flex gap-3">
                    <button type="button" data-no class="btn-secondary flex-1">Batal</button>
                    <button type="button" data-yes class="btn-danger flex-1">Ya, lanjutkan</button>
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

    // ---------- Transisi halus saat pindah halaman ----------
    document.querySelectorAll('a[href]').forEach((a) => {
        a.addEventListener('click', (e) => {
            const url = new URL(a.href, location.href);
            if (a.target || e.metaKey || e.ctrlKey || e.shiftKey || url.origin !== location.origin
                || (url.pathname === location.pathname && url.search === location.search) || url.hash) return;
            e.preventDefault();
            document.body.classList.add('is-leaving');
            setTimeout(() => { location.href = a.href; }, 200);
        });
    });
    window.addEventListener('pageshow', () => document.body.classList.remove('is-leaving'));
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
    btn.classList.toggle('text-white', show);
});
