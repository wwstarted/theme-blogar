/**
 * Mega Menu — Blogar Theme  v2
 * js/mega-menu.js
 *
 * FIX 3: closeItem(activeItem, true) — bug signature cũ nhận (li, link, instant)
 *         Khi gọi closeItem(activeItem, true), tham số thứ 2 "true" bị assign
 *         cho param "link", dẫn đến true.setAttribute() → TypeError → JS crash
 *         → mọi mega menu tiếp theo không mở được.
 *
 *         Fix: openItem(li) và closeItem(li, instant) không nhận "link" nữa.
 *         Link được query nội bộ trong hàm bằng :scope > a.
 *
 * FIX 4 (hỗ trợ): initDesktopHover giờ init bất kể window width vì
 *         resize handler cần event listeners đã được gắn sẵn.
 */

(function () {
  'use strict';

  var CLOSE_DELAY = 150; // ms
  var closeTimer  = null;
  var activeItem  = null; // li.blogar-has-mega đang mở

  /* ===========================================================
     HELPERS — query link nội bộ, không nhận qua tham số
     =========================================================== */

  function getLinkOf(li) {
    return li ? li.querySelector(':scope > a') : null;
  }

  /* FIX 3: openItem không còn nhận link param */
  function openItem(li) {
    li.classList.add('is-mega-open');
    var link = getLinkOf(li);
    if (link) link.setAttribute('aria-expanded', 'true');
  }

  /* FIX 3: closeItem(li, instant) — không còn param "link"
     instant=true → close ngay không animation (dùng khi switch sang item khác) */
  function closeItem(li, instant) {
    var link = getLinkOf(li);

    if (instant) {
      var panel = li.querySelector(':scope > .blogar-mega-panel');
      if (panel) {
        panel.style.transition = 'none';
        li.classList.remove('is-mega-open');
        requestAnimationFrame(function () {
          panel.style.transition = '';
        });
      } else {
        li.classList.remove('is-mega-open');
      }
    } else {
      li.classList.remove('is-mega-open');
    }

    if (link) link.setAttribute('aria-expanded', 'false');
  }

  function closeAll(instant) {
    document.querySelectorAll('.mainmenu > li.blogar-has-mega.is-mega-open')
      .forEach(function (li) { closeItem(li, instant); });
    activeItem = null;
  }

  /* ===========================================================
     DESKTOP HOVER
     =========================================================== */

  function initDesktopHover() {
    var items = document.querySelectorAll('.mainmenu > li.blogar-has-mega');
    if (!items.length) return;

    items.forEach(function (li) {
      var panel = li.querySelector(':scope > .blogar-mega-panel');

      /* mouseenter li → mở */
      li.addEventListener('mouseenter', function () {
        if (window.innerWidth < 1200) return; // guard: chỉ chạy ở desktop

        clearTimeout(closeTimer);

        /* Đóng item khác instant trước khi mở item mới */
        if (activeItem && activeItem !== li) {
          closeItem(activeItem, true); // FIX 3: chỉ pass li, không pass link
        }

        openItem(li); // FIX 3: chỉ pass li
        activeItem = li;
      });

      /* mouseleave li → đóng sau delay */
      li.addEventListener('mouseleave', function () {
        if (window.innerWidth < 1200) return;

        closeTimer = setTimeout(function () {
          closeItem(li); // FIX 3: chỉ pass li
          if (activeItem === li) activeItem = null;
        }, CLOSE_DELAY);
      });

      /* mouseenter panel → cancel close timer */
      if (panel) {
        panel.addEventListener('mouseenter', function () {
          if (window.innerWidth < 1200) return;
          clearTimeout(closeTimer);
        });

        panel.addEventListener('mouseleave', function () {
          if (window.innerWidth < 1200) return;
          closeTimer = setTimeout(function () {
            closeItem(li);
            if (activeItem === li) activeItem = null;
          }, CLOSE_DELAY);
        });
      }
    });
  }

  /* ===========================================================
     TAB SWITCHING (Type 1)
     click .mega-cat-tab → show .mega-posts-panel tương ứng
     =========================================================== */

  function initTabSwitching() {
    // Event delegation: handle click trên toàn bộ mainmenu
    var mainmenu = document.querySelector('.mainmenu');
    if (!mainmenu) return;

    mainmenu.addEventListener('click', function (e) {
      var tab = e.target.closest('.mega-cat-tab[data-mega-panel]');
      if (!tab) return;

      e.preventDefault(); // Tab switch panel, không navigate

      var panelId     = tab.getAttribute('data-mega-panel');
      var targetPanel = document.getElementById(panelId);
      if (!targetPanel) return;

      var sidebar   = tab.closest('.mega-cats-sidebar');
      var postsArea = sidebar ? sidebar.nextElementSibling : null;
      if (!postsArea || !postsArea.classList.contains('mega-posts-area')) return;

      /* Deactivate tất cả */
      sidebar.querySelectorAll('.mega-cat-tab').forEach(function (t) {
        t.classList.remove('is-active');
      });
      postsArea.querySelectorAll('.mega-posts-panel').forEach(function (p) {
        p.classList.remove('is-active');
      });

      /* Activate target */
      tab.classList.add('is-active');
      targetPanel.classList.add('is-active');
    });
  }

  /* ===========================================================
     KEYBOARD NAVIGATION
     =========================================================== */

  function initKeyboardNav() {
    /* Escape → đóng tất cả */
    document.addEventListener('keydown', function (e) {
      if (e.key !== 'Escape') return;
      if (!activeItem) return;

      var link = getLinkOf(activeItem);
      closeItem(activeItem);
      activeItem = null;
      clearTimeout(closeTimer);
      if (link) link.focus();
    });

    /* ArrowUp/Down trong tab sidebar */
    document.addEventListener('keydown', function (e) {
      if (e.key !== 'ArrowDown' && e.key !== 'ArrowUp') return;
      var focused = document.activeElement;
      if (!focused || !focused.classList.contains('mega-cat-tab')) return;

      var sidebar = focused.closest('.mega-cats-sidebar');
      if (!sidebar) return;

      var tabs = Array.from(sidebar.querySelectorAll('.mega-cat-tab'));
      var idx  = tabs.indexOf(focused);
      if (idx === -1) return;

      e.preventDefault();
      var next;
      if (e.key === 'ArrowDown') {
        next = tabs[idx + 1] || tabs[0];
      } else {
        next = tabs[idx - 1] || tabs[tabs.length - 1];
      }
      next.focus();
      next.click();
    });
  }

  /* ===========================================================
     OUTSIDE CLICK
     =========================================================== */

  function initOutsideClick() {
    document.addEventListener('click', function (e) {
      if (e.target.closest('.mainmenu > li.blogar-has-mega')) return;
      closeAll(false);
    });
  }

  /* ===========================================================
     MOBILE TOGGLE (trong off-canvas)
     =========================================================== */

  function initMobileToggle() {
    var offCanvas = document.querySelector('.popup-mobilemenu-area');
    if (!offCanvas) return;

    offCanvas.addEventListener('click', function (e) {
      var btn = e.target.closest('.mega-mobile-toggle');
      if (!btn) return;

      var li          = btn.closest('.blogar-has-mega');
      var mobilePanel = li ? li.querySelector('.mega-mobile-panel') : null;
      if (!mobilePanel) return;

      var isOpen = btn.getAttribute('aria-expanded') === 'true';
      btn.setAttribute('aria-expanded', isOpen ? 'false' : 'true');
      mobilePanel.classList.toggle('is-open', !isOpen);
    });
  }

  /* ===========================================================
     RESET KHI OFF-CANVAS ĐÓNG
     =========================================================== */

  function initMobileReset() {
    var observer = new MutationObserver(function (mutations) {
      mutations.forEach(function (mutation) {
        if (
          mutation.type === 'attributes' &&
          mutation.attributeName === 'class' &&
          !document.body.classList.contains('popup-mobile-menu-show')
        ) {
          document.querySelectorAll('.mega-mobile-toggle[aria-expanded="true"]')
            .forEach(function (btn) { btn.setAttribute('aria-expanded', 'false'); });
          document.querySelectorAll('.mega-mobile-panel.is-open')
            .forEach(function (p) { p.classList.remove('is-open'); });
        }
      });
    });
    observer.observe(document.body, { attributes: true });
  }

  /* ===========================================================
     RESIZE HANDLER
     =========================================================== */

  function initResizeHandler() {
    var resizeTimer;
    window.addEventListener('resize', function () {
      clearTimeout(resizeTimer);
      resizeTimer = setTimeout(function () {
        if (window.innerWidth < 1200) {
          closeAll(true);
        }
      }, 100);
    });
  }

  /* ===========================================================
     INIT
     =========================================================== */

  document.addEventListener('DOMContentLoaded', function () {
    /* FIX 3: initDesktopHover luôn được gọi để gắn event listeners
       Guard window.innerWidth nằm trong từng handler */
    if (document.querySelector('.mainmenu > li.blogar-has-mega')) {
      initDesktopHover();
      initTabSwitching();
      initKeyboardNav();
      initOutsideClick();
      initResizeHandler();
    }

    initMobileToggle();
    initMobileReset();
  });

})();