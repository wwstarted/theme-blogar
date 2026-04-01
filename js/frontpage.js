/* Blogar Front Page — Vanilla JS (no jQuery, no Slick, no Font Awesome) */
(function () {
    'use strict';

    var SVG_PREV = '<svg viewBox="0 0 24 24" focusable="false" aria-hidden="true"><path d="M19 12H5M12 5l-7 7 7 7" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>';
    var SVG_NEXT = '<svg viewBox="0 0 24 24" focusable="false" aria-hidden="true"><path d="M5 12h14M12 5l7 7-7 7" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>';

    function initSlider() {
        var shell = document.querySelector('.blogar-front-page-shell');
        if (!shell) return;
        var track = shell.querySelector('[data-slider]');
        if (!track) return;
        var wrap   = track.closest('.slider-activation-wrap');
        var slides = Array.prototype.slice.call(track.children);
        var total  = slides.length;
        if (total < 2) return;
        var current = 0, timer = null, DURATION = 5000;

        var prevBtn = wrap ? wrap.querySelector('.slide-arrow.prev-arrow') : null;
        var nextBtn = wrap ? wrap.querySelector('.slide-arrow.next-arrow') : null;
        if (!prevBtn) { prevBtn = document.createElement('button'); prevBtn.type = 'button'; prevBtn.className = 'slide-arrow prev-arrow'; prevBtn.setAttribute('aria-label', 'Previous slide'); wrap && wrap.appendChild(prevBtn); }
        if (!nextBtn) { nextBtn = document.createElement('button'); nextBtn.type = 'button'; nextBtn.className = 'slide-arrow next-arrow'; nextBtn.setAttribute('aria-label', 'Next slide'); wrap && wrap.appendChild(nextBtn); }
        prevBtn.innerHTML = SVG_PREV;
        nextBtn.innerHTML = SVG_NEXT;

        var dotsWrap = wrap ? wrap.querySelector('.slider-dots') : null;
        if (!dotsWrap) { dotsWrap = document.createElement('div'); dotsWrap.className = 'slider-dots'; dotsWrap.setAttribute('role', 'tablist'); wrap && wrap.appendChild(dotsWrap); }
        dotsWrap.innerHTML = '';
        var dots = [];
        for (var i = 0; i < total; i++) {
            var dot = document.createElement('button');
            dot.type = 'button';
            dot.className = 'slider-dot' + (i === 0 ? ' active' : '');
            dot.setAttribute('role', 'tab');
            dot.setAttribute('aria-label', 'Go to slide ' + (i + 1));
            dot.setAttribute('aria-selected', i === 0 ? 'true' : 'false');
            dot.dataset.index = i;
            dotsWrap.appendChild(dot);
            dots.push(dot);
        }

        function goTo(index) {
            current = (index + total) % total;
            track.style.transform = 'translateX(-' + (current * 100) + '%)';
            dots.forEach(function (d, idx) { var a = idx === current; d.classList.toggle('active', a); d.setAttribute('aria-selected', a ? 'true' : 'false'); });
            slides.forEach(function (s, idx) { s.setAttribute('aria-hidden', idx !== current ? 'true' : 'false'); });
        }
        function startAutoplay() { stopAutoplay(); timer = setInterval(function () { goTo(current + 1); }, DURATION); }
        function stopAutoplay() { if (timer) { clearInterval(timer); timer = null; } }

        nextBtn.addEventListener('click', function () { goTo(current + 1); startAutoplay(); });
        prevBtn.addEventListener('click', function () { goTo(current - 1); startAutoplay(); });
        dots.forEach(function (d) { d.addEventListener('click', function () { goTo(parseInt(d.dataset.index, 10)); startAutoplay(); }); });
        if (wrap) { wrap.addEventListener('mouseenter', stopAutoplay); wrap.addEventListener('mouseleave', startAutoplay); }

        var touchStartX = 0;
        track.addEventListener('touchstart', function (e) { touchStartX = e.touches[0].clientX; }, { passive: true });
        track.addEventListener('touchend', function (e) { var diff = touchStartX - e.changedTouches[0].clientX; if (Math.abs(diff) > 50) { diff > 0 ? goTo(current + 1) : goTo(current - 1); startAutoplay(); } }, { passive: true });

        goTo(0);
        startAutoplay();
    }

    function initTabs() {
        var tabButtons = document.querySelectorAll('.axil-tab-button');
        tabButtons.forEach(function (ul) {
            var links      = ul.querySelectorAll('.tab-link');
            var section    = ul.closest('section') || ul.parentElement;
            var tabContent = section ? section.querySelector('.tab-content') : null;
            if (!tabContent) return;
            var panels = tabContent.querySelectorAll('.single-tab-content, .trend-tab-content');
            links.forEach(function (link) {
                link.addEventListener('click', function (e) {
                    e.preventDefault();
                    var targetId = link.getAttribute('data-tab');
                    if (!targetId) return;
                    links.forEach(function (l) { l.classList.remove('active'); l.setAttribute('aria-selected', 'false'); });
                    panels.forEach(function (p) { p.classList.remove('active'); });
                    link.classList.add('active');
                    link.setAttribute('aria-selected', 'true');
                    var target = tabContent.querySelector(targetId);
                    if (target) { target.classList.add('active'); }
                });
            });
        });
    }

    function initCopyLinks() {
        document.addEventListener('click', function (e) {
            var btn = e.target.closest('.axilcopyLink');
            if (!btn) return;
            var url = btn.getAttribute('data-link') || window.location.href;
            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(url).then(function () { showCopyFeedback(btn); }).catch(function () { fallbackCopy(url, btn); });
            } else { fallbackCopy(url, btn); }
        });
    }

    function fallbackCopy(text, btn) {
        var ta = document.createElement('textarea');
        ta.value = text;
        ta.style.cssText = 'position:fixed;top:-9999px;left:-9999px;opacity:0';
        document.body.appendChild(ta);
        ta.focus(); ta.select();
        try { document.execCommand('copy'); showCopyFeedback(btn); } catch (err) {}
        document.body.removeChild(ta);
    }

    function showCopyFeedback(btn) {
        var orig = btn.getAttribute('title') || '';
        btn.setAttribute('title', 'Copied!');
        btn.classList.add('copied');
        setTimeout(function () { btn.setAttribute('title', orig); btn.classList.remove('copied'); }, 1500);
    }

    function boot() { initSlider(); initTabs(); initCopyLinks(); }
    if (document.readyState === 'loading') { document.addEventListener('DOMContentLoaded', boot); } else { boot(); }
}());
