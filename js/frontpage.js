/**
 * Blogar — frontpage.js
 * Handles: Hero Slick slider, Category slider,
 *          Tech tab slider, Bootstrap tab init,
 *          Trending tab switching
 */
(function ($) {
  "use strict";

  /* ── Hero Slider ────────────────────────────────────────── */
  if ($("#blg-hero-slider").length) {
    $("#blg-hero-slider").slick({
      slidesToShow: 1,
      slidesToScroll: 1,
      arrows: true,
      dots: true,
      autoplay: true,
      autoplaySpeed: 5000,
      speed: 800,
      infinite: true,
      fade: true,
      cssEase: "ease-in-out",
      pauseOnHover: true,
      prevArrow:
        '<button type="button" class="slick-prev" aria-label="Previous"><i class="fal fa-angle-left"></i></button>',
      nextArrow:
        '<button type="button" class="slick-next" aria-label="Next"><i class="fal fa-angle-right"></i></button>',
      responsive: [
        {
          breakpoint: 768,
          settings: {
            arrows: false,
            dots: true,
          },
        },
      ],
    });
  }

  /* ── Category Slider (Trending Topics) ──────────────────── */
  if ($("#blg-categories-slider").length) {
    $("#blg-categories-slider").slick({
      slidesToShow: 6,
      slidesToScroll: 1,
      arrows: true,
      dots: false,
      infinite: true,
      speed: 500,
      prevArrow:
        '<button type="button" class="slick-prev" aria-label="Previous"><i class="fal fa-angle-left"></i></button>',
      nextArrow:
        '<button type="button" class="slick-next" aria-label="Next"><i class="fal fa-angle-right"></i></button>',
      responsive: [
        {
          breakpoint: 1199,
          settings: { slidesToShow: 5 },
        },
        {
          breakpoint: 991,
          settings: { slidesToShow: 4 },
        },
        {
          breakpoint: 767,
          settings: { slidesToShow: 3 },
        },
        {
          breakpoint: 575,
          settings: { slidesToShow: 2 },
        },
      ],
    });
  }

  /* ── Tech Tab: Init Slick for active tab, re-init on switch ─ */
  function initTechSlider($tabPane) {
    const $slider = $tabPane.find(".modern-post-activation");

    if ($slider.length && !$slider.hasClass("slick-initialized")) {
      $slider.slick({
        slidesToShow: 4,
        slidesToScroll: 1,
        arrows: true,
        dots: false,
        infinite: true,
        speed: 500,
        prevArrow:
          '<button type="button" class="slick-prev" aria-label="Previous"><i class="fal fa-angle-left"></i></button>',
        nextArrow:
          '<button type="button" class="slick-next" aria-label="Next"><i class="fal fa-angle-right"></i></button>',
        responsive: [
          {
            breakpoint: 1199,
            settings: { slidesToShow: 3 },
          },
          {
            breakpoint: 991,
            settings: { slidesToShow: 2 },
          },
          {
            breakpoint: 575,
            settings: { slidesToShow: 1 },
          },
        ],
      });
    }
  }

  // Init on first active tab
  initTechSlider($("#blg-tech-section .tab-pane.active"));

  // Re-init when tab changes
  $("#blg-tech-tabs").on("click", ".nav-link", function () {
    const targetId = $(this).attr("href");
    // Short delay to allow Bootstrap to show the pane
    setTimeout(function () {
      initTechSlider($(targetId));
    }, 50);
  });

  /* ── Bootstrap Tab Switching (custom, no jQuery-migrate dep) */
  function initBootstrapTabs($tabList) {
    $tabList.on("click", ".nav-link", function (e) {
      e.preventDefault();

      const $this = $(this);
      const $parent = $this.closest('[role="tablist"]');
      const target = $this.attr("href");

      // Deactivate all
      $parent
        .find(".nav-link")
        .removeClass("active")
        .attr("aria-selected", "false");

      // Get the corresponding tab-content wrapper
      const $contentWrapper = $parent
        .closest(".col-lg-12, section")
        .find(".tab-content, .grid-tab-content");
      $contentWrapper.find(".tab-pane").removeClass("show active");

      // Activate this tab
      $this.addClass("active").attr("aria-selected", "true");
      const $pane = $(target);
      $pane.addClass("show active");
    });
  }

  // Apply to all tab lists on the page
  $('[role="tablist"]').each(function () {
    initBootstrapTabs($(this));
  });

  /* ── Sticky scroll reveal for section headings ──────────── */
  // Simple intersection observer for fade-in on scroll
  if ("IntersectionObserver" in window) {
    const sectionObserver = new IntersectionObserver(
      function (entries) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting) {
            entry.target.classList.add("blg-in-view");
            sectionObserver.unobserve(entry.target);
          }
        });
      },
      { threshold: 0.1 },
    );

    document
      .querySelectorAll(".section-title, .content-block")
      .forEach(function (el) {
        sectionObserver.observe(el);
      });
  }
})(jQuery);
