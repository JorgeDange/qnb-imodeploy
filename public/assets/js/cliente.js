/* QNB-Imobiliária — Área do Cliente JS */
document.addEventListener('DOMContentLoaded', function () {
    /* Marca nav item ativo */
    var path = window.location.pathname;
    document.querySelectorAll('.sidebar-nav a').forEach(function (link) {
        if (link.getAttribute('href') === path) {
            link.closest('li').classList.add('active');
        }
    });

    /* Marca bottomnav item ativo */
    document.querySelectorAll('.cliente-bottomnav-item').forEach(function (link) {
        if (link.getAttribute('href') === path) {
            link.classList.add('active');
        }
    });

    /* Sidebar toggle (mobile) */
    var toggle = document.querySelector('.cliente-sidebar-toggle');
    var sidebar = document.querySelector('.cliente-sidebar');
    var overlay = document.querySelector('.cliente-sidebar-overlay');
    var fechar = document.querySelector('.cliente-sidebar-fechar');

    function openSidebar() {
        sidebar.classList.add('open');
        if (overlay) overlay.classList.add('active');
        document.body.style.overflow = 'hidden';
    }
    function closeSidebar() {
        sidebar.classList.remove('open');
        if (overlay) overlay.classList.remove('active');
        document.body.style.overflow = '';
    }

    if (toggle && sidebar) {
        toggle.addEventListener('click', function () {
            if (sidebar.classList.contains('open')) {
                closeSidebar();
            } else {
                openSidebar();
            }
        });
    }

    if (overlay) {
        overlay.addEventListener('click', closeSidebar);
    }

    if (fechar) {
        fechar.addEventListener('click', closeSidebar);
    }

    /* Close on click outside sidebar */
    document.addEventListener('click', function (e) {
        if (sidebar && sidebar.classList.contains('open') &&
            !sidebar.contains(e.target) &&
            !toggle.contains(e.target)) {
            closeSidebar();
        }
    });

    /* Close sidebar when clicking a nav link (mobile) */
    sidebar.querySelectorAll('.sidebar-nav a').forEach(function (link) {
        link.addEventListener('click', function () {
            if (window.innerWidth <= 767) {
                closeSidebar();
            }
        });
    });

    /* Auto-dismiss flash messages */
    document.querySelectorAll('.flash-message').forEach(function (el) {
        setTimeout(function () {
            el.style.opacity = '0';
            setTimeout(function () { el.remove(); }, 300);
        }, 5000);
    });
});
