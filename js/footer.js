/**
 * Blogar — footer.js
 * Handles: back-to-top button visibility & smooth scroll
 */
(function ($) {
  "use strict";

  const $btn = $("#backto-top");

  /* Show / hide on scroll */
  $(window).on("scroll", function () {
    if ($(this).scrollTop() > 300) {
      $btn.addClass("is-visible");
    } else {
      $btn.removeClass("is-visible");
    }
  });

  /* Smooth scroll to top */
  $btn.on("click", function (e) {
    e.preventDefault();
    $("html, body").animate({ scrollTop: 0 }, 500, "swing");
  });
})(jQuery);
