document.addEventListener('DOMContentLoaded', function () {
    var html = document.documentElement;
    var body = document.body;
    var stickyHeader = document.querySelector('.header-sticky');
    var menuToggle = document.querySelector('.hamburger-menu');
    var mobileMenu = document.querySelector('.popup-mobilemenu-area');
    var mobileClose = document.querySelector('.mobile-close');
    var mobileSearchToggle = document.querySelector('.search-mobile-icon button');
    var mobileSearch = document.querySelector('.large-mobile-blog-search');

    function setStickyState() {
        if (!stickyHeader) {
            return;
        }

        if (window.scrollY > 250) {
            stickyHeader.classList.add('sticky');
            body.classList.add('header-sticky-now');
        } else {
            stickyHeader.classList.remove('sticky');
            body.classList.remove('header-sticky-now');
        }
    }

    function openMobileMenu() {
        if (!mobileMenu) {
            return;
        }

        body.classList.add('popup-mobile-menu-show');
        html.style.overflow = 'hidden';

        if (menuToggle) {
            menuToggle.setAttribute('aria-expanded', 'true');
        }

        mobileMenu.setAttribute('aria-hidden', 'false');
    }

    function closeMobileMenu() {
        if (!mobileMenu) {
            return;
        }

        body.classList.remove('popup-mobile-menu-show');
        html.style.overflow = '';

        if (menuToggle) {
            menuToggle.setAttribute('aria-expanded', 'false');
        }

        mobileMenu.setAttribute('aria-hidden', 'true');

        mobileMenu.querySelectorAll('.mainmenu-item .menu-item-has-children > a.open').forEach(function (link) {
            link.classList.remove('open');
        });

        mobileMenu.querySelectorAll('.mainmenu-item .sub-menu.active').forEach(function (submenu) {
            submenu.classList.remove('active');
        });
    }

    if (menuToggle) {
        menuToggle.addEventListener('click', function (event) {
            event.preventDefault();
            openMobileMenu();
        });
    }

    if (mobileClose) {
        mobileClose.addEventListener('click', function (event) {
            event.preventDefault();
            closeMobileMenu();
        });
    }

    if (mobileMenu) {
        mobileMenu.addEventListener('click', function (event) {
            if (event.target === mobileMenu) {
                closeMobileMenu();
            }
        });
    }

    if (mobileSearchToggle && mobileSearch) {
        mobileSearchToggle.addEventListener('click', function (event) {
            if (window.innerWidth >= 576) {
                return;
            }

            event.preventDefault();
            mobileSearch.classList.toggle('active');
            mobileSearchToggle.setAttribute('aria-expanded', mobileSearch.classList.contains('active') ? 'true' : 'false');
        });
    }

    document.querySelectorAll('.mainmenu-item .menu-item-has-children > a').forEach(function (link) {
        link.addEventListener('click', function (event) {
            if (window.innerWidth >= 1200) {
                return;
            }

            var submenu = link.nextElementSibling;

            if (!submenu || !submenu.classList.contains('sub-menu')) {
                return;
            }

            event.preventDefault();
            link.classList.toggle('open');
            submenu.classList.toggle('active');
        });
    });

    window.addEventListener('scroll', setStickyState, { passive: true });
    window.addEventListener('resize', function () {
        if (window.innerWidth >= 1200) {
            closeMobileMenu();
        }

        if (window.innerWidth >= 576 && mobileSearch) {
            mobileSearch.classList.remove('active');

            if (mobileSearchToggle) {
                mobileSearchToggle.setAttribute('aria-expanded', 'false');
            }
        }
    });

    setStickyState();
});
