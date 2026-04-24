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
     Source: 8 items.
     Our implementation: 4 at desktop, 3 at tablet, 2 on mobile.
     ================================================================ */
  function initCategoryCarousel() {
    var wrapper = document.querySelector("[data-cat-carousel]");
    if (!wrapper) return;

    var carousel = createCarousel(wrapper, {
      slideSelector: ".single-cat",
      gap: 24,
      slidesToShowFn: function () {
        var w = window.innerWidth;
        if (w >= 992) return 4;
        if (w >= 768) return 3;
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
     NEWS HIGHLIGHT TICKER
     ================================================================ */
  function initNewsHighlightTicker() {
    document.querySelectorAll("[data-news-ticker]").forEach(function (ticker) {
      var items = Array.prototype.slice.call(
        ticker.querySelectorAll(".blogar-news-highlight-ticker-item"),
      );
      if (!items.length) return;

      var prevBtn = ticker.querySelector(".blogar-news-highlight-ticker-prev");
      var nextBtn = ticker.querySelector(".blogar-news-highlight-ticker-next");
      var current = 0;
      var timer = null;
      var delay = parseInt(ticker.getAttribute("data-autotime"), 10) || 3000;

      items.forEach(function (item, index) {
        if (item.classList.contains("is-active")) current = index;
      });

      function goTo(index) {
        current = (index + items.length) % items.length;

        items.forEach(function (item, itemIndex) {
          var active = itemIndex === current;
          var link = item.querySelector("a");

          item.classList.toggle("is-active", active);
          item.setAttribute("aria-hidden", active ? "false" : "true");

          if (link) {
            link.setAttribute("tabindex", active ? "0" : "-1");
          }
        });
      }

      function stopAutoplay() {
        if (timer) {
          clearInterval(timer);
          timer = null;
        }
      }

      function startAutoplay() {
        if (items.length < 2) return;

        stopAutoplay();
        timer = setInterval(function () {
          goTo(current + 1);
        }, delay);
      }

      if (items.length < 2) {
        if (prevBtn) prevBtn.disabled = true;
        if (nextBtn) nextBtn.disabled = true;
        goTo(0);
        return;
      }

      if (prevBtn) {
        prevBtn.addEventListener("click", function () {
          goTo(current - 1);
          startAutoplay();
        });
      }

      if (nextBtn) {
        nextBtn.addEventListener("click", function () {
          goTo(current + 1);
          startAutoplay();
        });
      }

      ticker.addEventListener("mouseenter", stopAutoplay);
      ticker.addEventListener("mouseleave", startAutoplay);
      ticker.addEventListener("focusin", stopAutoplay);
      ticker.addEventListener("focusout", function () {
        setTimeout(function () {
          if (!ticker.contains(document.activeElement)) {
            startAutoplay();
          }
        }, 0);
      });

      var touchStartX = 0;
      ticker.addEventListener(
        "touchstart",
        function (e) {
          touchStartX = e.touches[0].clientX;
        },
        { passive: true },
      );
      ticker.addEventListener(
        "touchend",
        function (e) {
          var diff = touchStartX - e.changedTouches[0].clientX;
          if (Math.abs(diff) > 40) {
            diff > 0 ? goTo(current + 1) : goTo(current - 1);
            startAutoplay();
          }
        },
        { passive: true },
      );

      goTo(current);
      startAutoplay();
    });
  }

  /* ================================================================
     DUAL LATEST LISTS
     ================================================================ */
  function initDualLatestLists() {
    document.querySelectorAll("[data-dual-list]").forEach(function (wrapper) {
      var tabs = Array.prototype.slice.call(
        wrapper.querySelectorAll(".blogar-dual-latest-tab-link"),
      );
      var panels = Array.prototype.slice.call(
        wrapper.querySelectorAll(".blogar-dual-latest-panel"),
      );
      var prevBtn = wrapper.querySelector(".blogar-dual-latest-nav-prev");
      var nextBtn = wrapper.querySelector(".blogar-dual-latest-nav-next");
      var current = 0;

      if (!tabs.length || !panels.length) return;

      tabs.forEach(function (tab, index) {
        if (tab.classList.contains("is-active")) current = index;
      });

      function setActive(index) {
        current = Math.max(0, Math.min(index, tabs.length - 1));

        tabs.forEach(function (tab, tabIndex) {
          var active = tabIndex === current;
          var panel = panels[tabIndex];

          tab.classList.toggle("is-active", active);
          tab.setAttribute("aria-selected", active ? "true" : "false");
          tab.setAttribute("tabindex", active ? "0" : "-1");

          if (panel) {
            panel.classList.toggle("is-active", active);
            panel.hidden = !active;
          }
        });

        if (prevBtn) prevBtn.disabled = current === 0;
        if (nextBtn) nextBtn.disabled = current === tabs.length - 1;
      }

      tabs.forEach(function (tab, index) {
        tab.addEventListener("click", function () {
          setActive(index);
        });

        tab.addEventListener("keydown", function (e) {
          if (e.key === "ArrowRight") {
            e.preventDefault();
            setActive(Math.min(current + 1, tabs.length - 1));
            tabs[current].focus();
          } else if (e.key === "ArrowLeft") {
            e.preventDefault();
            setActive(Math.max(current - 1, 0));
            tabs[current].focus();
          } else if (e.key === "Home") {
            e.preventDefault();
            setActive(0);
            tabs[current].focus();
          } else if (e.key === "End") {
            e.preventDefault();
            setActive(tabs.length - 1);
            tabs[current].focus();
          }
        });
      });

      if (prevBtn) {
        prevBtn.addEventListener("click", function () {
          setActive(current - 1);
        });
      }

      if (nextBtn) {
        nextBtn.addEventListener("click", function () {
          setActive(current + 1);
        });
      }

      setActive(current);
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
    initNewsHighlightTicker();
    initDualLatestLists();
    initCopyLinks();
  }

  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", boot);
  } else {
    boot();
  }
})();

/**
 * BLOGAR S15 — Category Slider JavaScript
 * File: js/s15-slider.js  (enqueue conditionally on front-page)
 *
 * Behaviour:
 *  - Category tab click → show first slide of that category
 *  - Prev / Next click  → step through slides of current category
 *  - All state is DOM-driven (no AJAX needed — PHP pre-renders all slides)
 */

(function () {
  "use strict";

  function setButtonState(button, disabled) {
    if (!button) return;
    button.disabled = !!disabled;
    button.setAttribute("aria-disabled", disabled ? "true" : "false");
    button.classList.toggle("s15-btn-disable", !!disabled);
  }

  function initS11p(slider) {
    var slides = Array.prototype.slice.call(
      slider.querySelectorAll(".penci-feat-slide"),
    );
    var prev = slider.querySelector(".penci-feat-prev");
    var next = slider.querySelector(".penci-feat-next");
    var current = 0;

    if (!slides.length) return;

    slides.some(function (slide, index) {
      if (slide.classList.contains("active")) {
        current = index;
        return true;
      }
      return false;
    });

    function render(index) {
      current = (index + slides.length) % slides.length;

      slides.forEach(function (slide, slideIndex) {
        var isActive = slideIndex === current;
        slide.classList.toggle("active", isActive);
        slide.hidden = !isActive;
        slide.setAttribute("aria-hidden", isActive ? "false" : "true");
      });
    }

    render(current);

    if (slides.length < 2) return;

    if (prev) {
      prev.addEventListener("click", function (e) {
        e.preventDefault();
        render(current - 1);
      });
    }

    if (next) {
      next.addEventListener("click", function (e) {
        e.preventDefault();
        render(current + 1);
      });
    }
  }

  function syncS15Tabs(tabs, currentCat) {
    tabs.forEach(function (tab) {
      var isActive = tab.getAttribute("data-cat") === currentCat;
      tab.classList.toggle("s15-active", isActive);
      tab.setAttribute("aria-selected", isActive ? "true" : "false");
      tab.tabIndex = isActive ? 0 : -1;
    });
  }

  function initS15(section) {
    var catTabs = Array.prototype.slice.call(
      section.querySelectorAll(".s15-tab"),
    );
    var btnPrev = section.querySelector(".s15-btn-prev");
    var btnNext = section.querySelector(".s15-btn-next");
    var slidesWrap = section.querySelector(".blogar-s15-slides");

    if (!slidesWrap) return;

    var currentCat = section.getAttribute("data-initial-cat") || "all";
    var currentSlide = 0;

    /* ── Category tab click ── */
    catTabs.forEach(function (tab) {
      tab.addEventListener("click", function (e) {
        e.preventDefault();
        var cat = this.getAttribute("data-cat");
        if (cat === currentCat) return;

        currentCat = getMaxSlide(slidesWrap, cat) >= 0 ? cat : "all";
        currentSlide = 0;
        syncS15Tabs(catTabs, currentCat);
        showSlide(slidesWrap, currentCat, currentSlide, btnPrev, btnNext);
      });
    });

    /* ── Prev button ── */
    if (btnPrev) {
      btnPrev.addEventListener("click", function (e) {
        e.preventDefault();
        if (this.classList.contains("s15-btn-disable")) return;
        currentSlide = Math.max(0, currentSlide - 1);
        showSlide(slidesWrap, currentCat, currentSlide, btnPrev, btnNext);
      });
    }

    /* ── Next button ── */
    if (btnNext) {
      btnNext.addEventListener("click", function (e) {
        e.preventDefault();
        if (this.classList.contains("s15-btn-disable")) return;
        var max = getMaxSlide(slidesWrap, currentCat);
        currentSlide = Math.min(max, currentSlide + 1);
        showSlide(slidesWrap, currentCat, currentSlide, btnPrev, btnNext);
      });
    }

    syncS15Tabs(catTabs, currentCat);

    /* ── Init: ensure first slide visible ── */
    showSlide(slidesWrap, currentCat, currentSlide, btnPrev, btnNext);
  }

  /**
   * Show a specific slide for a category, hide all others.
   * Update prev/next button states.
   */
  function showSlide(wrap, cat, slideIndex, btnPrev, btnNext) {
    var allSlides = Array.prototype.slice.call(
      wrap.querySelectorAll(".blogar-s15-slide"),
    );

    allSlides.forEach(function (slide) {
      var slideCat = slide.getAttribute("data-cat");
      var slideIdx = parseInt(slide.getAttribute("data-slide"), 10);
      var isTarget = slideCat === cat && slideIdx === slideIndex;

      slide.classList.toggle("s15-slide-active", isTarget);
      slide.hidden = !isTarget;
      slide.setAttribute("aria-hidden", isTarget ? "false" : "true");
    });

    var maxSlide = getMaxSlide(wrap, cat);

    if (maxSlide < 0) {
      setButtonState(btnPrev, true);
      setButtonState(btnNext, true);
      return;
    }

    /* Update PREV button */
    setButtonState(btnPrev, slideIndex <= 0);

    /* Update NEXT button */
    setButtonState(btnNext, slideIndex >= maxSlide);
  }

  /**
   * Get the highest slide index available for a category.
   */
  function getMaxSlide(wrap, cat) {
    var slides = wrap.querySelectorAll(
      '.blogar-s15-slide[data-cat="' + cat + '"]',
    );
    return slides.length - 1;
  }

  /* ─────────────────────────────────────────────────────────────
   * S16 — Money Category Grid Slider
   * Same state machine as S15, scoped to .s16-* class names.
   * Each slide = 12 posts (4 cols × 3 rows).
   * ───────────────────────────────────────────────────────────── */

  function setButtonState16(btn, disabled) {
    if (!btn) return;
    btn.disabled = !!disabled;
    btn.setAttribute("aria-disabled", disabled ? "true" : "false");
    btn.classList.toggle("s16-btn-disable", !!disabled);
  }

  function getMaxSlide16(wrap, cat) {
    return (
      wrap.querySelectorAll('.blogar-s16-slide[data-cat="' + cat + '"]')
        .length - 1
    );
  }

  function showSlide16(wrap, cat, slideIndex, btnPrev, btnNext) {
    Array.prototype.forEach.call(
      wrap.querySelectorAll(".blogar-s16-slide"),
      function (slide) {
        var slideCat = slide.getAttribute("data-cat");
        var slideIdx = parseInt(slide.getAttribute("data-slide"), 10);
        var isTarget = slideCat === cat && slideIdx === slideIndex;
        slide.classList.toggle("s16-slide-active", isTarget);
        slide.hidden = !isTarget;
        slide.setAttribute("aria-hidden", isTarget ? "false" : "true");
      },
    );

    var max = getMaxSlide16(wrap, cat);
    if (max < 0) {
      setButtonState16(btnPrev, true);
      setButtonState16(btnNext, true);
      return;
    }
    setButtonState16(btnPrev, slideIndex <= 0);
    setButtonState16(btnNext, slideIndex >= max);
  }

  function syncS16Tabs(tabs, currentCat) {
    tabs.forEach(function (tab) {
      var isActive = tab.getAttribute("data-cat") === currentCat;
      tab.classList.toggle("s16-active", isActive);
      tab.setAttribute("aria-selected", isActive ? "true" : "false");
      tab.tabIndex = isActive ? 0 : -1;
    });
  }

  function initS16(section) {
    var catTabs = Array.prototype.slice.call(
      section.querySelectorAll(".s16-tab"),
    );
    var btnPrev = section.querySelector(".s16-btn-prev");
    var btnNext = section.querySelector(".s16-btn-next");
    var slidesWrap = section.querySelector(".blogar-s16-slides");

    if (!slidesWrap) return;

    var currentCat = section.getAttribute("data-initial-cat") || "all";
    var currentSlide = 0;

    catTabs.forEach(function (tab) {
      tab.addEventListener("click", function (e) {
        e.preventDefault();
        var cat = this.getAttribute("data-cat");
        if (cat === currentCat) return;
        currentCat =
          getMaxSlide16(slidesWrap, cat) >= 0 ? cat : "all";
        currentSlide = 0;
        syncS16Tabs(catTabs, currentCat);
        showSlide16(slidesWrap, currentCat, currentSlide, btnPrev, btnNext);
      });
    });

    if (btnPrev) {
      btnPrev.addEventListener("click", function (e) {
        e.preventDefault();
        if (this.classList.contains("s16-btn-disable")) return;
        currentSlide = Math.max(0, currentSlide - 1);
        showSlide16(slidesWrap, currentCat, currentSlide, btnPrev, btnNext);
      });
    }

    if (btnNext) {
      btnNext.addEventListener("click", function (e) {
        e.preventDefault();
        if (this.classList.contains("s16-btn-disable")) return;
        var max = getMaxSlide16(slidesWrap, currentCat);
        currentSlide = Math.min(max, currentSlide + 1);
        showSlide16(slidesWrap, currentCat, currentSlide, btnPrev, btnNext);
      });
    }

    syncS16Tabs(catTabs, currentCat);
    showSlide16(slidesWrap, currentCat, currentSlide, btnPrev, btnNext);
  }

  function getPanel17(wrap, cat) {
    return wrap.querySelector('.blogar-s17-slide[data-cat="' + cat + '"]');
  }

  function syncS17Tabs(tabs, currentCat) {
    tabs.forEach(function (tab) {
      var isActive = tab.getAttribute("data-cat") === currentCat;
      tab.classList.toggle("s17-active", isActive);
      tab.setAttribute("aria-selected", isActive ? "true" : "false");
      tab.tabIndex = isActive ? 0 : -1;
    });
  }

  function showPanel17(wrap, cat) {
    Array.prototype.forEach.call(
      wrap.querySelectorAll(".blogar-s17-slide"),
      function (slide) {
        var isTarget = slide.getAttribute("data-cat") === cat;
        slide.classList.toggle("s17-slide-active", isTarget);
        slide.hidden = !isTarget;
        slide.setAttribute("aria-hidden", isTarget ? "false" : "true");
      },
    );
  }

  function initS17(section) {
    var catTabs = Array.prototype.slice.call(
      section.querySelectorAll(".s17-tab"),
    );
    var slidesWrap = section.querySelector(".blogar-s17-slides");

    if (!slidesWrap) return;

    var currentCat = section.getAttribute("data-initial-cat") || "all";
    if (!getPanel17(slidesWrap, currentCat)) {
      var firstPanel = slidesWrap.querySelector(".blogar-s17-slide");
      currentCat = firstPanel ? firstPanel.getAttribute("data-cat") : currentCat;
    }

    catTabs.forEach(function (tab) {
      tab.addEventListener("click", function (e) {
        e.preventDefault();
        var cat = this.getAttribute("data-cat");
        if (cat === currentCat || !getPanel17(slidesWrap, cat)) return;
        currentCat = cat;
        syncS17Tabs(catTabs, currentCat);
        showPanel17(slidesWrap, currentCat);
      });
    });

    syncS17Tabs(catTabs, currentCat);
    showPanel17(slidesWrap, currentCat);
  }

  function getPanel18(wrap, cat) {
    return wrap.querySelector('.blogar-s18-slide[data-cat="' + cat + '"]');
  }

  function syncS18Tabs(tabs, currentCat) {
    tabs.forEach(function (tab) {
      var isActive = tab.getAttribute("data-cat") === currentCat;
      tab.classList.toggle("s18-active", isActive);
      tab.setAttribute("aria-selected", isActive ? "true" : "false");
      tab.tabIndex = isActive ? 0 : -1;
    });
  }

  function showPanel18(wrap, cat) {
    Array.prototype.forEach.call(
      wrap.querySelectorAll(".blogar-s18-slide"),
      function (slide) {
        var isTarget = slide.getAttribute("data-cat") === cat;
        slide.classList.toggle("s18-slide-active", isTarget);
        slide.hidden = !isTarget;
        slide.setAttribute("aria-hidden", isTarget ? "false" : "true");
      },
    );
  }

  function initS18(section) {
    var catTabs = Array.prototype.slice.call(
      section.querySelectorAll(".s18-tab"),
    );
    var slidesWrap = section.querySelector(".blogar-s18-slides");

    if (!slidesWrap) return;

    var currentCat = section.getAttribute("data-initial-cat") || "all";
    if (!getPanel18(slidesWrap, currentCat)) {
      var firstPanel = slidesWrap.querySelector(".blogar-s18-slide");
      currentCat = firstPanel ? firstPanel.getAttribute("data-cat") : currentCat;
    }

    catTabs.forEach(function (tab) {
      tab.addEventListener("click", function (e) {
        e.preventDefault();
        var cat = this.getAttribute("data-cat");
        if (cat === currentCat || !getPanel18(slidesWrap, cat)) return;
        currentCat = cat;
        syncS18Tabs(catTabs, currentCat);
        showPanel18(slidesWrap, currentCat);
      });
    });

    syncS18Tabs(catTabs, currentCat);
    showPanel18(slidesWrap, currentCat);
  }

  function getSlides19(wrap, cat) {
    return Array.prototype.slice.call(
      wrap.querySelectorAll('.blogar-s19-slide[data-cat="' + cat + '"]'),
    );
  }

  function getMaxSlide19(wrap, cat) {
    var slides = getSlides19(wrap, cat);
    return slides.length ? slides.length - 1 : 0;
  }

  function syncS19Tabs(tabs, currentCat) {
    tabs.forEach(function (tab) {
      var isActive = tab.getAttribute("data-cat") === currentCat;
      tab.classList.toggle("s19-active", isActive);
      tab.setAttribute("aria-selected", isActive ? "true" : "false");
      tab.tabIndex = isActive ? 0 : -1;
    });
  }

  function syncS19Pager(btnPrev, btnNext, currentSlide, maxSlide) {
    if (btnPrev) {
      var disablePrev = currentSlide <= 0;
      btnPrev.classList.toggle("s19-btn-disable", disablePrev);
      btnPrev.disabled = disablePrev;
      btnPrev.setAttribute("aria-disabled", disablePrev ? "true" : "false");
    }

    if (btnNext) {
      var disableNext = currentSlide >= maxSlide;
      btnNext.classList.toggle("s19-btn-disable", disableNext);
      btnNext.disabled = disableNext;
      btnNext.setAttribute("aria-disabled", disableNext ? "true" : "false");
    }
  }

  function showSlide19(wrap, cat, index, btnPrev, btnNext) {
    Array.prototype.forEach.call(
      wrap.querySelectorAll(".blogar-s19-slide"),
      function (slide) {
        var slideCat = slide.getAttribute("data-cat");
        var slideIndex = parseInt(slide.getAttribute("data-slide") || "0", 10);
        var isTarget = slideCat === cat && slideIndex === index;

        slide.classList.toggle("s19-slide-active", isTarget);
        slide.hidden = !isTarget;
        slide.setAttribute("aria-hidden", isTarget ? "false" : "true");
      },
    );

    syncS19Pager(btnPrev, btnNext, index, getMaxSlide19(wrap, cat));
  }

  function initS19Block(block) {
    var catTabs = Array.prototype.slice.call(block.querySelectorAll(".s19-tab"));
    var slidesWrap = block.querySelector(".blogar-s19-block-slides");
    var btnPrev = block.querySelector(".s19-btn-prev");
    var btnNext = block.querySelector(".s19-btn-next");

    if (!slidesWrap) return;

    var currentCat = block.getAttribute("data-initial-cat") || "all";
    var currentSlide = 0;
    if (!getSlides19(slidesWrap, currentCat).length) {
      var firstPanel = slidesWrap.querySelector(".blogar-s19-slide");
      if (firstPanel) {
        currentCat = firstPanel.getAttribute("data-cat") || currentCat;
        currentSlide = parseInt(
          firstPanel.getAttribute("data-slide") || "0",
          10,
        );
      }
    }

    catTabs.forEach(function (tab) {
      tab.addEventListener("click", function (e) {
        e.preventDefault();
        var cat = this.getAttribute("data-cat");
        if (cat === currentCat || !getSlides19(slidesWrap, cat).length) return;
        currentCat = cat;
        currentSlide = 0;
        syncS19Tabs(catTabs, currentCat);
        showSlide19(slidesWrap, currentCat, currentSlide, btnPrev, btnNext);
      });
    });

    if (btnPrev) {
      btnPrev.addEventListener("click", function (e) {
        e.preventDefault();
        if (this.classList.contains("s19-btn-disable")) return;
        currentSlide = Math.max(0, currentSlide - 1);
        showSlide19(slidesWrap, currentCat, currentSlide, btnPrev, btnNext);
      });
    }

    if (btnNext) {
      btnNext.addEventListener("click", function (e) {
        e.preventDefault();
        if (this.classList.contains("s19-btn-disable")) return;
        var max = getMaxSlide19(slidesWrap, currentCat);
        currentSlide = Math.min(max, currentSlide + 1);
        showSlide19(slidesWrap, currentCat, currentSlide, btnPrev, btnNext);
      });
    }

    syncS19Tabs(catTabs, currentCat);
    showSlide19(slidesWrap, currentCat, currentSlide, btnPrev, btnNext);
  }

  function initS19(section) {
    Array.prototype.slice
      .call(section.querySelectorAll(".blogar-s19-block"))
      .forEach(initS19Block);
  }

  function getSlides20(wrap, cat) {
    return Array.prototype.slice.call(
      wrap.querySelectorAll('.blogar-s20-slide[data-cat="' + cat + '"]'),
    );
  }

  function getMaxSlide20(wrap, cat) {
    var slides = getSlides20(wrap, cat);
    return slides.length ? slides.length - 1 : 0;
  }

  function syncS20Tabs(tabs, currentCat) {
    tabs.forEach(function (tab) {
      var isActive = tab.getAttribute("data-cat") === currentCat;
      tab.classList.toggle("s20-active", isActive);
      tab.setAttribute("aria-selected", isActive ? "true" : "false");
      tab.tabIndex = isActive ? 0 : -1;
    });
  }

  function syncS20Pager(btnPrev, btnNext, currentSlide, maxSlide) {
    if (btnPrev) {
      var disablePrev = currentSlide <= 0;
      btnPrev.classList.toggle("s20-btn-disable", disablePrev);
      btnPrev.disabled = disablePrev;
      btnPrev.setAttribute("aria-disabled", disablePrev ? "true" : "false");
    }
    if (btnNext) {
      var disableNext = currentSlide >= maxSlide;
      btnNext.classList.toggle("s20-btn-disable", disableNext);
      btnNext.disabled = disableNext;
      btnNext.setAttribute("aria-disabled", disableNext ? "true" : "false");
    }
  }

  function showSlide20(wrap, cat, index, btnPrev, btnNext) {
    Array.prototype.forEach.call(
      wrap.querySelectorAll(".blogar-s20-slide"),
      function (slide) {
        var slideCat   = slide.getAttribute("data-cat");
        var slideIndex = parseInt(slide.getAttribute("data-slide") || "0", 10);
        var isTarget   = slideCat === cat && slideIndex === index;

        slide.classList.toggle("s20-slide-active", isTarget);
        slide.hidden = !isTarget;
        slide.setAttribute("aria-hidden", isTarget ? "false" : "true");
      },
    );

    syncS20Pager(btnPrev, btnNext, index, getMaxSlide20(wrap, cat));
  }

  function initS20Block(block) {
    var catTabs   = Array.prototype.slice.call(block.querySelectorAll(".s20-tab"));
    var slidesWrap = block.querySelector(".blogar-s20-block-slides");
    var btnPrev   = block.querySelector(".s20-btn-prev");
    var btnNext   = block.querySelector(".s20-btn-next");

    if (!slidesWrap) return;

    var currentCat   = block.getAttribute("data-initial-cat") || "all";
    var currentSlide = 0;
    if (!getSlides20(slidesWrap, currentCat).length) {
      var firstPanel = slidesWrap.querySelector(".blogar-s20-slide");
      if (firstPanel) {
        currentCat   = firstPanel.getAttribute("data-cat") || currentCat;
        currentSlide = parseInt(firstPanel.getAttribute("data-slide") || "0", 10);
      }
    }

    catTabs.forEach(function (tab) {
      tab.addEventListener("click", function (e) {
        e.preventDefault();
        var cat = this.getAttribute("data-cat");
        if (cat === currentCat || !getSlides20(slidesWrap, cat).length) return;
        currentCat   = cat;
        currentSlide = 0;
        syncS20Tabs(catTabs, currentCat);
        showSlide20(slidesWrap, currentCat, currentSlide, btnPrev, btnNext);
      });
    });

    if (btnPrev) {
      btnPrev.addEventListener("click", function (e) {
        e.preventDefault();
        if (this.classList.contains("s20-btn-disable")) return;
        currentSlide = Math.max(0, currentSlide - 1);
        showSlide20(slidesWrap, currentCat, currentSlide, btnPrev, btnNext);
      });
    }

    if (btnNext) {
      btnNext.addEventListener("click", function (e) {
        e.preventDefault();
        if (this.classList.contains("s20-btn-disable")) return;
        var max = getMaxSlide20(slidesWrap, currentCat);
        currentSlide = Math.min(max, currentSlide + 1);
        showSlide20(slidesWrap, currentCat, currentSlide, btnPrev, btnNext);
      });
    }

    syncS20Tabs(catTabs, currentCat);
    showSlide20(slidesWrap, currentCat, currentSlide, btnPrev, btnNext);
  }

  function initS20(section) {
    Array.prototype.slice
      .call(section.querySelectorAll(".blogar-s20-block"))
      .forEach(initS20Block);
  }

  function bootSections() {
    document
      .querySelectorAll(".blogar-s11p .penci-feat-slider")
      .forEach(initS11p);
    document.querySelectorAll(".blogar-s15").forEach(initS15);
    document.querySelectorAll(".blogar-s16").forEach(initS16);
    document.querySelectorAll(".blogar-s17").forEach(initS17);
    document.querySelectorAll(".blogar-s18").forEach(initS18);
    document.querySelectorAll(".blogar-s19").forEach(initS19);
    document.querySelectorAll(".blogar-s20").forEach(initS20);
  }

  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", bootSections);
  } else {
    bootSections();
  }
})();
