/* Blogar Front Page — Vanilla JS (no jQuery, no Slick, no Font Awesome) */
(function () {
  "use strict";

  /* ================================================================
     HERO SLIDER
     ================================================================ */
  function initSlider() {
    var section = document.querySelector(".slider-area");
    if (!section) return;
    var track = section.querySelector("[data-slider]");
    if (!track) return;
    var wrap = track.closest(".slider-activation-wrap");
    var slides = Array.prototype.slice.call(track.children);
    var total = slides.length;
    if (total < 2) return;
    var current = 0,
      timer = null;
    var DURATION = 5000;

    var SVG_PREV =
      '<svg viewBox="0 0 24 24" focusable="false" aria-hidden="true"><path d="M19 12H5M12 5l-7 7 7 7" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>';
    var SVG_NEXT =
      '<svg viewBox="0 0 24 24" focusable="false" aria-hidden="true"><path d="M5 12h14M12 5l7 7-7 7" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>';

    var prevBtn = wrap ? wrap.querySelector(".slide-arrow.prev-arrow") : null;
    var nextBtn = wrap ? wrap.querySelector(".slide-arrow.next-arrow") : null;
    if (!prevBtn) {
      prevBtn = document.createElement("button");
      prevBtn.type = "button";
      prevBtn.className = "slide-arrow prev-arrow";
      prevBtn.setAttribute("aria-label", "Previous slide");
      wrap && wrap.appendChild(prevBtn);
    }
    if (!nextBtn) {
      nextBtn = document.createElement("button");
      nextBtn.type = "button";
      nextBtn.className = "slide-arrow next-arrow";
      nextBtn.setAttribute("aria-label", "Next slide");
      wrap && wrap.appendChild(nextBtn);
    }
    prevBtn.innerHTML = SVG_PREV;
    nextBtn.innerHTML = SVG_NEXT;

    track.setAttribute("aria-live", "polite");
    slides.forEach(function (s, i) {
      s.setAttribute("aria-hidden", i === 0 ? "false" : "true");
    });

    function goTo(index) {
      current = (index + total) % total;
      track.style.transform = "translateX(-" + current * 100 + "%)";
      slides.forEach(function (s, i) {
        s.setAttribute("aria-hidden", i !== current ? "true" : "false");
      });
    }
    function startAutoplay() {
      stopAutoplay();
      timer = setInterval(function () {
        goTo(current + 1);
      }, DURATION);
    }
    function stopAutoplay() {
      if (timer) {
        clearInterval(timer);
        timer = null;
      }
    }

    nextBtn.addEventListener("click", function () {
      goTo(current + 1);
      startAutoplay();
    });
    prevBtn.addEventListener("click", function () {
      goTo(current - 1);
      startAutoplay();
    });
    if (wrap) {
      wrap.addEventListener("mouseenter", stopAutoplay);
      wrap.addEventListener("mouseleave", startAutoplay);
    }

    var touchStartX = 0;
    track.addEventListener(
      "touchstart",
      function (e) {
        touchStartX = e.touches[0].clientX;
      },
      { passive: true },
    );
    track.addEventListener(
      "touchend",
      function (e) {
        var diff = touchStartX - e.changedTouches[0].clientX;
        if (Math.abs(diff) > 50) {
          diff > 0 ? goTo(current + 1) : goTo(current - 1);
          startAutoplay();
        }
      },
      { passive: true },
    );

    goTo(0);
    startAutoplay();
  }

  /* ================================================================
     GENERIC CAROUSEL FACTORY
     Shared by the tab section and the categories section.

     options = {
       slideSelector:  CSS selector for each slide within .carousel-track
       gap:            pixel gap between slides (must match CSS gap value)
       slidesToShowFn: function() → int  (how many slides visible now)
     }
     Returns { reset(), resize() } or null on failure.
     ================================================================ */
  function createCarousel(wrapper, options) {
    options = options || {};
    var slideSelector = options.slideSelector || ".slick-single-layout";
    var gap = options.gap !== undefined ? options.gap : 30;
    var slidesToShowFn =
      options.slidesToShowFn ||
      function () {
        var w = window.innerWidth;
        return w >= 992 ? 3 : w >= 768 ? 2 : 1;
      };

    var viewport = wrapper.querySelector(".carousel-viewport");
    var track = wrapper.querySelector(".carousel-track");
    if (!track || !viewport) return null;

    var slides = Array.prototype.slice.call(
      track.querySelectorAll(slideSelector),
    );
    var total = slides.length;
    if (!total) return null;

    var prevBtn = wrapper.querySelector(".slide-arrow.prev-arrow");
    var nextBtn = wrapper.querySelector(".slide-arrow.next-arrow");
    var current = 0;

    function applyWidths() {
      var show = slidesToShowFn();
      var w = (viewport.offsetWidth - gap * (show - 1)) / show;
      slides.forEach(function (s) {
        s.style.width = w + "px";
      });
      return w;
    }

    function goTo(index) {
      var show = slidesToShowFn();
      var max = Math.max(0, total - show);
      current = Math.max(0, Math.min(index, max));
      var w = applyWidths();
      track.style.transform = "translateX(-" + current * (w + gap) + "px)";
      if (prevBtn) prevBtn.disabled = current === 0;
      if (nextBtn) nextBtn.disabled = current >= max;
    }

    if (prevBtn)
      prevBtn.addEventListener("click", function () {
        goTo(current - 1);
      });
    if (nextBtn)
      nextBtn.addEventListener("click", function () {
        goTo(current + 1);
      });

    var tx = 0;
    track.addEventListener(
      "touchstart",
      function (e) {
        tx = e.touches[0].clientX;
      },
      { passive: true },
    );
    track.addEventListener(
      "touchend",
      function (e) {
        var d = tx - e.changedTouches[0].clientX;
        if (Math.abs(d) > 40) d > 0 ? goTo(current + 1) : goTo(current - 1);
      },
      { passive: true },
    );

    return {
      reset: function () {
        goTo(0);
      },
      resize: function () {
        track.style.transition = "none";
        goTo(current);
        requestAnimationFrame(function () {
          track.style.transition = "";
        });
      },
    };
  }

  /* ================================================================
     TAB CAROUSEL — Innovation & Tech (3 slides desktop, 2 tablet, 1 mobile)
     ================================================================ */
  function initTabs() {
    var carouselMap = {};

    function syncTrendPanel(panel) {
      if (!panel || !panel.classList.contains("trend-tab-content")) return;
      var items = panel.querySelectorAll(".trend-post");
      if (!items.length) return;
      var active = panel.querySelector(".trend-post.is-active") || items[0];
      items.forEach(function (item) {
        item.classList.toggle("is-active", item === active);
      });
    }

    document.querySelectorAll(".trend-tab-content").forEach(function (panel) {
      syncTrendPanel(panel);
      panel.addEventListener(
        "mouseenter",
        function (e) {
          var item = e.target.closest(".trend-post");
          if (!item || !panel.contains(item)) return;
          panel.querySelectorAll(".trend-post").forEach(function (node) {
            node.classList.toggle("is-active", node === item);
          });
        },
        true,
      );
      panel.addEventListener("focusin", function (e) {
        var item = e.target.closest(".trend-post");
        if (!item || !panel.contains(item)) return;
        panel.querySelectorAll(".trend-post").forEach(function (node) {
          node.classList.toggle("is-active", node === item);
        });
      });
    });

    document
      .querySelectorAll("[data-tab-carousel]")
      .forEach(function (wrapper) {
        var panel = wrapper.closest("[id]");
        var carousel = createCarousel(wrapper, {
          slideSelector: ".slick-single-layout",
          gap: 30,
          slidesToShowFn: function () {
            var w = window.innerWidth;
            return w >= 992 ? 3 : w >= 768 ? 2 : 1;
          },
        });
        if (panel && carousel) carouselMap[panel.id] = carousel;
      });

    /* Init active carousel */
    Object.keys(carouselMap).forEach(function (id) {
      var p = document.getElementById(id);
      if (p && p.classList.contains("active")) carouselMap[id].reset();
    });

    /* Tab clicks */
    document.querySelectorAll(".axil-tab-button").forEach(function (ul) {
      var links = ul.querySelectorAll(".tab-link");
      var section = ul.closest("section") || ul.parentElement;
      var content = section ? section.querySelector(".tab-content") : null;
      if (!content) return;
      var panels = content.querySelectorAll(
        ".single-tab-content, .trend-tab-content",
      );

      links.forEach(function (link) {
        link.addEventListener("click", function (e) {
          e.preventDefault();
          var tid = link.getAttribute("data-tab");
          if (!tid) return;
          links.forEach(function (l) {
            l.classList.remove("active");
            l.setAttribute("aria-selected", "false");
          });
          panels.forEach(function (p) {
            p.classList.remove("active");
          });
          link.classList.add("active");
          link.setAttribute("aria-selected", "true");
          var target = content.querySelector(tid);
          if (target) {
            target.classList.add("active");
            syncTrendPanel(target);
            var pid = target.id;
            if (pid && carouselMap[pid])
              requestAnimationFrame(function () {
                carouselMap[pid].reset();
              });
          }
        });
      });
    });

    /* Resize */
    var rt;
    window.addEventListener("resize", function () {
      clearTimeout(rt);
      rt = setTimeout(function () {
        Object.keys(carouselMap).forEach(function (id) {
          if (carouselMap[id]) carouselMap[id].resize();
        });
      }, 120);
    });
  }

  /* ================================================================
     CATEGORY CAROUSEL — Trending Topics
     Source: 8 items, Slick shows 6 at desktop.
     Our implementation: 6 at ≥1200px, 4 at ≥992px, 3 at ≥576px, 2 mobile.
     ================================================================ */
  function initCategoryCarousel() {
    var wrapper = document.querySelector("[data-cat-carousel]");
    if (!wrapper) return;

    var carousel = createCarousel(wrapper, {
      slideSelector: ".single-cat",
      gap: 20,
      slidesToShowFn: function () {
        var w = window.innerWidth;
        if (w >= 1200) return 6;
        if (w >= 992) return 4;
        if (w >= 576) return 3;
        return 2;
      },
    });

    if (!carousel) return;
    carousel.reset();

    var rt;
    window.addEventListener("resize", function () {
      clearTimeout(rt);
      rt = setTimeout(function () {
        carousel.resize();
      }, 120);
    });
  }

  /* ================================================================
     COPY LINK
     ================================================================ */
  function initCopyLinks() {
    document.addEventListener("click", function (e) {
      var btn = e.target.closest(".axilcopyLink");
      if (!btn) return;
      var url = btn.getAttribute("data-link") || window.location.href;
      if (navigator.clipboard && navigator.clipboard.writeText) {
        navigator.clipboard
          .writeText(url)
          .then(function () {
            showCopyFeedback(btn);
          })
          .catch(function () {
            fallbackCopy(url, btn);
          });
      } else {
        fallbackCopy(url, btn);
      }
    });
  }

  function fallbackCopy(text, btn) {
    var ta = document.createElement("textarea");
    ta.value = text;
    ta.style.cssText = "position:fixed;top:-9999px;left:-9999px;opacity:0";
    document.body.appendChild(ta);
    ta.focus();
    ta.select();
    try {
      document.execCommand("copy");
      showCopyFeedback(btn);
    } catch (e) {}
    document.body.removeChild(ta);
  }

  function showCopyFeedback(btn) {
    var orig = btn.getAttribute("title") || "";
    btn.setAttribute("title", "Copied!");
    btn.classList.add("copied");
    setTimeout(function () {
      btn.setAttribute("title", orig);
      btn.classList.remove("copied");
    }, 1500);
  }

  /* ================================================================
     BOOT
     ================================================================ */
  function boot() {
    initSlider();
    initTabs();
    initCategoryCarousel();
    initCopyLinks();
  }

  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", boot);
  } else {
    boot();
  }
})();
