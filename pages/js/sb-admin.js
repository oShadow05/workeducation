jQuery.noConfict();
(function(jQuery) {
  "use strict"; // Start of use strict

  // Toggle the side navigation
  jQuery("#sidebarToggle").on('click',function(e) {
    e.preventDefault();
    jQuery("body").toggleClass("sidebar-toggled");
    jQuery(".sidebar").toggleClass("toggled");
  });

  // Prevent the content wrapper from scrolling when the fixed side navigation hovered over
  jQuery('body.fixed-nav .sidebar').on('mousewheel DOMMouseScroll wheel', function(e) {
    if (jQuery(window).width() > 768) {
      var e0 = e.originalEvent,
        delta = e0.wheelDelta || -e0.detail;
      this.scrollTop += (delta < 0 ? 1 : -1) * 30;
      e.preventDefault();
    }
  });

  // Scroll to top button appear
  jQuery(document).on('scroll',function() {
    var scrollDistance = $(this).scrollTop();
    if (scrollDistance > 100) {
      jQuery('.scroll-to-top').fadeIn();
    } else {
      jQuery('.scroll-to-top').fadeOut();
    }
  });

  // Smooth scrolling using jQuery easing
  jQuery(document).on('click', 'a.scroll-to-top', function(event) {
    var $anchor = $(this);
    console.log($anchor);
    jQuery('html, body').stop().animate({
      scrollTop: ($($anchor.attr('href')).offset().top)
    }, 1000, 'easeInOutExpo');
    event.preventDefault();
  });

})(jQuery); // End of use strict
