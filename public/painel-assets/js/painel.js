/* ============================
   QNB-Imobiliária — Painel JS
   ============================ */

document.addEventListener('DOMContentLoaded', function () {
    // Sidebar toggle (mobile)
    const toggle = document.querySelector('.ul-painel-sidebar-toggle');
    const sidebar = document.querySelector('.ul-painel-sidebar');
    const overlay = document.querySelector('.ul-painel-sidebar-overlay');
    const fechar = document.querySelector('.ul-painel-sidebar-fechar');

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

    // Close on overlay click
    if (overlay) {
        overlay.addEventListener('click', closeSidebar);
    }

    // Close on X button
    if (fechar) {
        fechar.addEventListener('click', closeSidebar);
    }

    // Close on click outside sidebar
    document.addEventListener('click', function (e) {
        if (sidebar && sidebar.classList.contains('open') &&
            !sidebar.contains(e.target) &&
            !toggle.contains(e.target)) {
            closeSidebar();
        }
    });

    // Close sidebar when clicking a nav link (mobile)
    sidebar.querySelectorAll('.ul-painel-nav a').forEach(function (link) {
        link.addEventListener('click', function () {
            if (window.innerWidth <= 991) {
                closeSidebar();
            }
        });
    });

    // Close alerts after 5s
    document.querySelectorAll('.alert-success').forEach(function (alert) {
        setTimeout(function () {
            alert.style.transition = 'opacity 0.3s';
            alert.style.opacity = '0';
            setTimeout(function () { alert.remove(); }, 300);
        }, 5000);
    });

    // Confirm delete
    document.querySelectorAll('form[onsubmit]').forEach(function (form) {
        // Handled inline
    });

    // Photo preview on file input change
    document.querySelectorAll('input[name="fotos[]"]').forEach(function (input) {
        input.addEventListener('change', function () {
            var container = input.closest('.ul-painel-card');
            var preview = container ? container.querySelector('.ul-painel-photos-preview') : null;
            if (!preview) {
                preview = document.createElement('div');
                preview.className = 'ul-painel-photos-preview mb-3';
                if (container) {
                    var formGroup = input.closest('.form-group');
                    if (formGroup) {
                        formGroup.parentNode.insertBefore(preview, formGroup);
                    }
                }
            }
            preview.innerHTML = '';

            Array.from(input.files).forEach(function (file, i) {
                if (!file.type.startsWith('image/')) return;
                var reader = new FileReader();
                reader.onload = function (e) {
                    var thumb = document.createElement('div');
                    thumb.className = 'ul-painel-photo-thumb';
                    thumb.innerHTML = '<img src="' + e.target.result + '" alt="Preview">';
                    if (i === 0) {
                        thumb.innerHTML += '<span class="ul-painel-photo-badge">Capa</span>';
                    }
                    preview.appendChild(thumb);
                };
                reader.readAsDataURL(file);
            });
        });
    });
});
