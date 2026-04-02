document.addEventListener("DOMContentLoaded", function () {
  var html = document.documentElement;
  var body = document.body;
  var stickyHeader = document.querySelector(".header-sticky");
  var menuToggle = document.querySelector(".hamburger-menu");
  var mobileMenu = document.querySelector(".popup-mobilemenu-area");
  var mobileClose = document.querySelector(".mobile-close");
  var mobileSearchToggle = document.querySelector(".search-mobile-icon button");
  var mobileSearch = document.querySelector(".large-mobile-blog-search");

  /* ------------------------------------------------------------------
       STICKY HEADER
       Adds/removes 'sticky' class and body helper class on scroll.
    ------------------------------------------------------------------ */
  function setStickyState() {
    if (!stickyHeader) return;

    if (window.scrollY > 10) {
      stickyHeader.classList.add("sticky");
      body.classList.add("header-sticky-now");
    } else {
      stickyHeader.classList.remove("sticky");
      body.classList.remove("header-sticky-now");
    }
  }

  /* ------------------------------------------------------------------
       MOBILE MENU — OPEN / CLOSE
    ------------------------------------------------------------------ */
  function openMobileMenu() {
    if (!mobileMenu) return;

    body.classList.add("popup-mobile-menu-show");
    html.style.overflow = "hidden";

    if (menuToggle) {
      menuToggle.setAttribute("aria-expanded", "true");
    }

    mobileMenu.setAttribute("aria-hidden", "false");
  }

  function closeMobileMenu() {
    if (!mobileMenu) return;

    body.classList.remove("popup-mobile-menu-show");
    html.style.overflow = "";

    if (menuToggle) {
      menuToggle.setAttribute("aria-expanded", "false");
    }

    mobileMenu.setAttribute("aria-hidden", "true");

    /* Reset any open submenus */
    mobileMenu
      .querySelectorAll(".mainmenu-item .menu-item-has-children > a.open")
      .forEach(function (link) {
        link.classList.remove("open");
      });

    mobileMenu
      .querySelectorAll(".mainmenu-item .sub-menu.active")
      .forEach(function (submenu) {
        submenu.classList.remove("active");
      });
  }

  /* Hamburger open */
  if (menuToggle) {
    menuToggle.addEventListener("click", function (e) {
      e.preventDefault();
      openMobileMenu();
    });
  }

  /* Close button */
  if (mobileClose) {
    mobileClose.addEventListener("click", function (e) {
      e.preventDefault();
      closeMobileMenu();
    });
  }

  /* Click on backdrop overlay */
  if (mobileMenu) {
    mobileMenu.addEventListener("click", function (e) {
      if (e.target === mobileMenu) {
        closeMobileMenu();
      }
    });
  }

  /* ------------------------------------------------------------------
       MOBILE SEARCH TOGGLE
       FIX: Guard changed from >= 768 to >= 576 to match CSS breakpoint.
       The search icon is only visible at ≤ 575px (via CSS), so the toggle
       should only fire in that same range.
    ------------------------------------------------------------------ */
  function closeSearchDropdown() {
    if (!mobileSearch) return;
    mobileSearch.classList.remove("active");
    if (mobileSearchToggle) {
      mobileSearchToggle.setAttribute("aria-expanded", "false");
    }
  }

  if (mobileSearchToggle && mobileSearch) {
    mobileSearchToggle.addEventListener("click", function (e) {
      /* FIX: was >= 768 — now correctly guards at >= 576 */
      if (window.innerWidth >= 576) return;

      e.preventDefault();
      var isOpen = mobileSearch.classList.toggle("active");
      mobileSearchToggle.setAttribute(
        "aria-expanded",
        isOpen ? "true" : "false",
      );
    });
  }

  /* ------------------------------------------------------------------
       MOBILE SUBMENU TOGGLE (inside off-canvas panel)
    ------------------------------------------------------------------ */
  document
    .querySelectorAll(".mainmenu-item .menu-item-has-children > a")
    .forEach(function (link) {
      link.addEventListener("click", function (e) {
        /* Only intercept on tablet/mobile */
        if (window.innerWidth >= 1200) return;

        var submenu = link.nextElementSibling;
        if (!submenu || !submenu.classList.contains("sub-menu")) return;

        e.preventDefault();
        link.classList.toggle("open");
        submenu.classList.toggle("active");
      });
    });

  /* ------------------------------------------------------------------
       RESIZE HANDLER
       - Close mobile menu when resizing to desktop
       - FIX: Close search dropdown when resizing out of XS mobile (>= 576)
    ------------------------------------------------------------------ */
  var resizeTimer;
  window.addEventListener("resize", function () {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(function () {
      /* Close mobile menu if now in desktop range */
      if (window.innerWidth >= 1200) {
        closeMobileMenu();
      }

      /* FIX: was >= 768 — close search dropdown when no longer in XS range */
      if (window.innerWidth >= 576) {
        closeSearchDropdown();
      }
    }, 100);
  });

  /* ------------------------------------------------------------------
       INIT
    ------------------------------------------------------------------ */
  setStickyState();
  window.addEventListener("scroll", setStickyState, { passive: true });
});
