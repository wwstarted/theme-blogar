/**
 * Blogar — header.js
 * Handles: custom cursor, dark/light mode, sticky header,
 *          mobile menu drawer, mobile search toggle,
 *          desktop dropdown accessibility, mobile submenu accordion
 */
(function ($) {
  "use strict";

  /* ── Custom Cursor ─────────────────────────────────────── */
  if (window.innerWidth > 1199) {
    const $outer = $(".cursor-outer");
    const $inner = $(".cursor-inner");

    $(document).on("mousemove", function (e) {
      $outer.css({ left: e.clientX, top: e.clientY });
      $inner.css({ left: e.clientX, top: e.clientY });
    });

    $("a, button")
      .on("mouseenter", function () {
        $outer.addClass("cursor-hover");
        $outer.css({ transform: "translate(-50%, -50%) scale(1.6)" });
      })
      .on("mouseleave", function () {
        $outer.removeClass("cursor-hover");
        $outer.css({ transform: "translate(-50%, -50%) scale(1)" });
      });
  }

  /* ── Dark / Light Mode ──────────────────────────────────── */
  const THEME_KEY = "blg_color_mode";

  function applyTheme(mode) {
    if (mode === "dark") {
      $("body").addClass("dark-mode");
    } else {
      $("body").removeClass("dark-mode");
    }
    // Update active state on switcher links
    $(".setColor").removeClass("active");
    $('.setColor[data-theme="' + mode + '"]').addClass("active");
    localStorage.setItem(THEME_KEY, mode);
  }

  // Apply saved theme on load
  const savedTheme = localStorage.getItem(THEME_KEY) || "light";
  applyTheme(savedTheme);

  // Switcher click
  $(document).on("click", ".setColor", function (e) {
    e.preventDefault();
    applyTheme($(this).data("theme"));
  });

  /* ── Sticky Header ─────────────────────────────────────── */
  const $header = $(".axil-header");
  const headerH = $header.outerHeight();

  $(window).on("scroll", function () {
    if ($(this).scrollTop() > 100) {
      $header.addClass("header-sticky");
    } else {
      $header.removeClass("header-sticky");
    }
  });

  /* ── Mobile Menu Drawer ─────────────────────────────────── */
  const $mobileMenu = $("#blg-mobile-menu");
  const $hamburgers = $("#blg-hamburger, #blg-hamburger-mobile");
  const $mobileClose = $("#blg-mobile-close");

  function openMobileMenu() {
    $mobileMenu.addClass("is-open").attr("aria-hidden", "false");
    $("body").css("overflow", "hidden");
    $hamburgers.attr("aria-expanded", "true");
  }

  function closeMobileMenu() {
    $mobileMenu.removeClass("is-open").attr("aria-hidden", "true");
    $("body").css("overflow", "");
    $hamburgers.attr("aria-expanded", "false");
  }

  $hamburgers.on("click", openMobileMenu);
  $mobileClose.on("click", closeMobileMenu);

  // Close on backdrop click (outside inner drawer)
  $mobileMenu.on("click", function (e) {
    if (!$(e.target).closest(".inner").length) {
      closeMobileMenu();
    }
  });

  // Close on Escape key
  $(document).on("keydown", function (e) {
    if (e.key === "Escape") closeMobileMenu();
  });

  /* ── Mobile Submenu Accordion ───────────────────────────── */
  $(document).on("click", ".mainmenu-item .has-children > a", function (e) {
    const $li = $(this).parent();

    // Only intercept if the submenu has items
    if ($li.find(".submenu").length) {
      e.preventDefault();
      const isOpen = $li.hasClass("open");

      // Close siblings
      $li
        .siblings(".has-children")
        .removeClass("open")
        .find(".submenu")
        .slideUp(250);

      // Toggle current
      if (isOpen) {
        $li.removeClass("open").find(".submenu").slideUp(250);
      } else {
        $li.addClass("open").find("> .submenu").slideDown(250);
      }
    }
  });

  /* ── Mobile Search Toggle ───────────────────────────────── */
  $("#blg-mobile-search-toggle").on("click", function () {
    const $form = $("#blg-mobile-search");
    $form.toggleClass("is-open");
    if ($form.hasClass("is-open")) {
      $form.find('input[name="s"]').focus();
    }
  });

  /* ── Desktop: Keyboard Navigation for Dropdowns ────────── */
  $(".mainmenu .has-dropdown").on("keydown", function (e) {
    if (e.key === "Enter" || e.key === " ") {
      e.preventDefault();
      $(this).toggleClass("keyboard-open");
      $(this).find(".axil-submenu").first().toggleClass("keyboard-visible");
    }
    if (e.key === "Escape") {
      $(this).removeClass("keyboard-open");
      $(this).find(".axil-submenu").first().removeClass("keyboard-visible");
    }
  });

  /* ── Mega Menu: Vertical Tab Navigation ─────────────────── */
  $(document).on("click", ".vertical-nav-item a", function (e) {
    e.preventDefault();
    const target = $(this).attr("href"); // e.g. "#tab-abc"

    // Deactivate all in this mega menu
    const $parent = $(this).closest(".vertical-tab-with-post-area");
    $parent.find(".vertical-nav-item").removeClass("active");
    $parent.find(".axil-vertical-inner").hide();

    // Activate clicked
    $(this).closest(".vertical-nav-item").addClass("active");
    $parent.find(target).show();
  });
})(jQuery);
