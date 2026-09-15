/* Template 2 behaviour (replaces Thomson's demo script.js). */
(function ($) {
    'use strict';

    if (window.AOS) AOS.init({ once: true, duration: 700 });

    // Nav shadow once the page scrolls.
    var $nav = $('#navbar');
    function onScroll() { $nav.toggleClass('is-scrolled', window.scrollY > 10); }
    $(window).on('scroll', onScroll);
    onScroll();

    // Close the mobile menu after picking a section.
    $('#t2-nav .nav-link').on('click', function () { $('#t2-nav').collapse('hide'); });

    // Highlight the section in view.
    var links = document.querySelectorAll('#t2-nav .nav-link');
    if ('IntersectionObserver' in window && links.length) {
        var observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (!entry.isIntersecting) return;
                links.forEach(function (link) {
                    link.classList.toggle('active', link.getAttribute('href').split('#')[1] === entry.target.id);
                });
            });
        }, { rootMargin: '-45% 0px -50% 0px' });

        links.forEach(function (link) {
            var target = document.getElementById(link.getAttribute('href').split('#')[1]);
            if (target && link.getAttribute('href').charAt(0) === '#') observer.observe(target);
        });
    }

    // Blog post image carousel.
    $('.t2-gallery').owlCarousel({
        items: 1,
        loop: true,
        nav: true,
        dots: true,
        autoplay: false,
        navText: ['<i class="ti-angle-left"></i>', '<i class="ti-angle-right"></i>']
    });
})(jQuery);
