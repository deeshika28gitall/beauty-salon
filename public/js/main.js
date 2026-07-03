document.addEventListener('DOMContentLoaded', () => {
    const navbar = document.querySelector('.site-navbar');

    const syncNavbar = () => {
        navbar?.classList.toggle('nav-scrolled', window.scrollY > 20);
    };

    syncNavbar();
    window.addEventListener('scroll', syncNavbar, { passive: true });

    document.querySelectorAll('.navbar-nav .nav-link, .navbar-nav .btn').forEach((link) => {
        link.addEventListener('click', () => {
            const menu = document.querySelector('#mainNavbar');
            const collapse = bootstrap.Collapse.getInstance(menu);

            if (collapse) {
                collapse.hide();
            }
        });
    });
});
