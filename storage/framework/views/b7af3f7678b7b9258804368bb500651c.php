<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'QNB-Imobiliária - Encontre o seu imóvel'); ?></title>

    <!-- libraries CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/icon/flaticon_real_estate.css')); ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="<?php echo e(asset('assets/vendor/bootstrap/bootstrap.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/vendor/splide/splide.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/vendor/swiper/swiper-bundle.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/vendor/slim-select/slimselect.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/vendor/animate-wow/animate.min.css')); ?>">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- custom CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/style.css')); ?>">
    <link rel="icon" type="image/svg+xml" href="<?php echo e(asset('assets/img/logo-c.svg')); ?>">
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>

<body data-pagina="<?php echo $__env->yieldContent('pagina', 'index'); ?>">
    <div class="preloader" id="preloader">
        <div class="loader"></div>
    </div>

    <!-- SIDEBAR SECTION START -->
    <div class="ul-sidebar">
        <!-- header -->
        <div class="ul-sidebar-header">
            <div class="ul-sidebar-header-logo">
                <a href="<?php echo e(route('home')); ?>">
                    <img src="<?php echo e(asset('assets/img/logo-c.svg')); ?>" alt="logo" class="logo">
                </a>
            </div>
            <!-- sidebar closer -->
            <button class="ul-sidebar-closer"><i class="flaticon-close"></i></button>
        </div>

        <div class="ul-sidebar-header-nav-wrapper d-block d-lg-none"></div>

        <p class="ul-sidebar-descr d-none d-lg-flex">A QNB-Imobiliária é a plataforma digital onde empresas e imobiliárias anunciam os seus imóveis para fins comerciais. Com anúncios em Luanda, Benguela, Huambo e Huíla, o contacto com o responsável por cada anúncio é sempre direto.</p>

        <div class="ul-sidebar-slider-wrapper d-none d-lg-flex">
            <div class="ul-sidebar-slider-nav ul-slider-nav">
                <button class="prev"><i class="flaticon-arrow"></i></button>
                <button class="next"><i class="flaticon-right-arrow"></i></button>
            </div>

            <div class="slider-wrapper">
                <div class="ul-sidebar-slider swiper">
                    <div class="swiper-wrapper">
                        <!-- single project -->
                        <div class="swiper-slide">
                            <div class="ul-project">
                                <div class="ul-project-img"><img src="<?php echo e(asset('assets/img/project-3.jpg')); ?>" alt="Project Image"></div>
                                <div class="ul-project-txt">
                                    <span class="ul-project-tag">Popular</span>
                                    <div class="top">
                                        <div class="left">
                                            <span class="ul-project-price"><span class="number">450 000</span>/mês</span>
                                            <a href="<?php echo e(route('home')); ?>" class="ul-project-title">Apartamento Miramar</a>
                                            <p class="ul-project-location">Miramar, Luanda</p>
                                        </div>
                                        <div class="right">
                                            <button class="ul-project-add-to-favorites-btn"><i class="flaticon-heart"></i></button>
                                        </div>
                                    </div>

                                    <!-- bottom -->
                                    <div class="ul-project-infos ul-featured-property-infos">
                                        <!-- single info -->
                                        <div class="ul-project-info ul-featured-property-info">
                                            <span class="icon"><i class="flaticon-bed-color"></i></span>
                                            <span class="text">3 Quartos</span>
                                        </div>
                                        <!-- single info -->
                                        <div class="ul-project-info ul-featured-property-info">
                                            <span class="icon"><i class="flaticon-bath"></i></span>
                                            <span class="text">2 Casas de Banho</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- single project -->
                        <div class="swiper-slide">
                            <div class="ul-project">
                                <div class="ul-project-img"><img src="<?php echo e(asset('assets/img/project-1.jpg')); ?>" alt="Project Image"></div>
                                <div class="ul-project-txt">
                                    <span class="ul-project-tag">Popular</span>
                                    <div class="top">
                                        <div class="left">
                                            <span class="ul-project-price"><span class="number">450 000</span>/mês</span>
                                            <a href="<?php echo e(route('home')); ?>" class="ul-project-title">Vila Palm</a>
                                            <p class="ul-project-location">Miramar, Luanda</p>
                                        </div>
                                        <div class="right">
                                            <button class="ul-project-add-to-favorites-btn"><i class="flaticon-heart"></i></button>
                                        </div>
                                    </div>

                                    <!-- bottom -->
                                    <div class="ul-project-infos ul-featured-property-infos">
                                        <!-- single info -->
                                        <div class="ul-project-info ul-featured-property-info">
                                            <span class="icon"><i class="flaticon-bed-color"></i></span>
                                            <span class="text">3 Quartos</span>
                                        </div>
                                        <!-- single info -->
                                        <div class="ul-project-info ul-featured-property-info">
                                            <span class="icon"><i class="flaticon-bath"></i></span>
                                            <span class="text">2 Casas de Banho</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- single project -->
                        <div class="swiper-slide">
                            <div class="ul-project">
                                <div class="ul-project-img"><img src="<?php echo e(asset('assets/img/project-4.jpg')); ?>" alt="Project Image"></div>
                                <div class="ul-project-txt">
                                    <span class="ul-project-tag">Popular</span>
                                    <div class="top">
                                        <div class="left">
                                            <span class="ul-project-price"><span class="number">450 000</span>/mês</span>
                                            <a href="<?php echo e(route('home')); ?>" class="ul-project-title">Residencial Crystal</a>
                                            <p class="ul-project-location">Miramar, Luanda</p>
                                        </div>
                                        <div class="right">
                                            <button class="ul-project-add-to-favorites-btn"><i class="flaticon-heart"></i></button>
                                        </div>
                                    </div>

                                    <!-- bottom -->
                                    <div class="ul-project-infos ul-featured-property-infos">
                                        <!-- single info -->
                                        <div class="ul-project-info ul-featured-property-info">
                                            <span class="icon"><i class="flaticon-bed-color"></i></span>
                                            <span class="text">3 Quartos</span>
                                        </div>
                                        <!-- single info -->
                                        <div class="ul-project-info ul-featured-property-info">
                                            <span class="icon"><i class="flaticon-bath"></i></span>
                                            <span class="text">2 Casas de Banho</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- sidebar footer -->
        <div class="ul-sidebar-footer">
            <span class="ul-sidebar-footer-title">Siga-nos</span>

            <div class="ul-sidebar-footer-social">
                <a href="https://www.facebook.com/qnbangola" target="_blank" rel="noopener"><i class="flaticon-facebook"></i></a>
                <a href="#"><i class="flaticon-twitter"></i></a>
                <a href="https://www.instagram.com/qnbangola" target="_blank" rel="noopener"><i class="flaticon-instagram"></i></a>
                <a href="https://www.linkedin.com/in/qnbangola" target="_blank" rel="noopener"><i class="flaticon-linkedin"></i></a>
            </div>
        </div>
    </div>
    <!-- SIDEBAR SECTION END -->

    <!-- SEARCH MODAL SECTION START -->
    <div class="ul-search-form-wrapper flex-grow-1 flex-shrink-0">
        <button class="ul-search-closer"><i class="flaticon-close"></i></button>

        <form action="<?php echo e(route('imoveis.index')); ?>" method="GET" class="ul-search-form">
            <div class="ul-search-form-right">
                <input type="search" name="search" id="ul-search" placeholder="Pesquisar Here">
                <button type="submit"><span class="icon"><i class="flaticon-search"></i></span></button>
            </div>
        </form>
    </div>
    <!-- SEARCH MODAL SECTION END -->

    <!-- HEADER SECTION START -->
    <header class="ul-header <?php echo $__env->yieldContent('header-class', 'ul-header--home'); ?>">
        <div class="ul-header-bottom">
            <div class="ul-header-bottom-wrapper">
                <!-- header left -->
                <div class="header-bottom-left">
                    <div class="logo-container">
                        <a href="<?php echo e(route('home')); ?>" class="d-inline-block"><img src="<?php echo e(asset('assets/img/logo.svg')); ?>" alt="logo" class="logo"></a>
                    </div>
                </div>

                <!-- header nav -->
                <div class="ul-header-nav-wrapper">
                    <div class="to-go-to-sidebar-in-mobile">
                                                <nav class="ul-header-nav">
                            <a href="<?php echo e(route('home')); ?>">Início</a>
                            <div class="has-sub-menu">
                                <a role="button">Imóveis</a>

                                <div class="ul-header-submenu">
                                    <ul>
                                        <li><a href="<?php echo e(route('imoveis.index')); ?>">Ver Imóveis</a></li>
                                    </ul>
                                </div>
                            </div>
                            <a href="<?php echo e(route('sobre')); ?>">Sobre a QNB</a>
                            <a href="<?php echo e(route('como-funciona')); ?>">Como Anunciar</a>
                            <a href="<?php echo e(route('contacto')); ?>">Contacto</a>
                        </nav>
                    </div>
                </div>

                <!-- actions -->
                <div class="ul-header-actions">
                    <button class="ul-header-search-opener"><i class="flaticon-search"></i></button>
                    <a href="<?php echo e(route('painel.login')); ?>" class="add-property-btn d-xxs-none"><i class="flaticon-home"></i> Imobiliárias</a>
                    <?php if(auth()->guard('cliente')->guest()): ?>
                        <a href="<?php echo e(route('cliente.login')); ?>" class="add-property-btn d-xxs-none"><i class="fas fa-user"></i> Área do Cliente</a>
                    <?php endif; ?>
                    <?php if(auth()->guard('cliente')->check()): ?>
                        <a href="<?php echo e(route('cliente.dashboard')); ?>" class="add-property-btn d-xxs-none"><i class="fas fa-user"></i> <?php echo e(auth('cliente')->user()->nome); ?></a>
                        <form action="<?php echo e(route('cliente.logout')); ?>" method="POST" style="display:inline;">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="add-property-btn d-xxs-none" style="background:none;border:none;cursor:pointer;"><i class="fas fa-sign-out-alt"></i></button>
                        </form>
                    <?php endif; ?>
                    <button class="ul-header-sidebar-opener"><i class="flaticon-menu-button"></i></button>
                </div>

                <!-- sidebar opener -->
                <div class="d-none">
                    <button class="ul-header-sidebar-opener"><i class="flaticon-menu-button"></i></button>
                </div>
            </div>
        </div>
    </header>
    <!-- HEADER SECTION END -->


    <main>
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <!-- FOOTER SECTION START -->
    <footer class="ul-footer">
        <div class="ul-footer-top">
            <div class="ul-container">
                <div class="ul-footer-top-wrapper wow animate__fadeInUp">
                    <div class="ul-footer-about">
                        <a href="<?php echo e(route('home')); ?>"><img src="<?php echo e(asset('assets/img/logo-c.svg')); ?>" alt="logo"></a>
                        <p class="ul-footer-about-txt">A QNB-Imobiliária é a plataforma digital onde empresas e imobiliárias anunciam os seus imóveis para fins comerciais. Anúncios verificados e contacto direto em todo o território.</p>
                        <div class="ul-footer-socials">
                            <a href="https://www.facebook.com/qnbangola" target="_blank" rel="noopener"><i class="flaticon-facebook"></i></a>
                            <a href="https://www.instagram.com/qnbangola" target="_blank" rel="noopener"><i class="flaticon-instagram"></i></a>
                            <a href="#"><i class="flaticon-twitter"></i></a>
                            <a href="https://www.linkedin.com/in/qnbangola" target="_blank" rel="noopener"><i class="flaticon-linkedin"></i></a>
                        </div>
                    </div>

                                        <div class="single-column">
                        <div class="ul-footer-widget">
                            <h3 class="ul-footer-widget-title">IMÓVEIS</h3>

                            <div class="ul-footer-widget-links">
                                <a href="<?php echo e(route('imoveis.index')); ?>">Ver Imóveis</a>
                                <a href="<?php echo e(route('imoveis.index')); ?>">Anúncios Recentes</a>
                            </div>
                        </div>
                        <div class="ul-footer-widget">
                            <h3 class="ul-footer-widget-title">EMPRESA</h3>

                            <div class="ul-footer-widget-links">
                                <a href="<?php echo e(route('sobre')); ?>">Sobre a QNB</a>
                                <a href="<?php echo e(route('como-funciona')); ?>">Como Anunciar</a>
                                <a href="<?php echo e(route('contacto')); ?>">Contacto</a>
                            </div>
                        </div>
                    </div>
                    <div class="single-column">
                        <div class="ul-footer-widget">
                            <h3 class="ul-footer-widget-title">PARA IMOBILIÁRIAS</h3>

                            <div class="ul-footer-widget-links">
                                <a href="<?php echo e(route('painel.login')); ?>">Entrar</a>
                            </div>
                        </div>
                        <div class="ul-footer-widget">
                            <h3 class="ul-footer-widget-title">TERMOS</h3>

                            <div class="ul-footer-widget-links">
                                <a href="#">Termos de Serviço</a>
                                <a href="#">Política de Privacidade</a>
                            </div>
                        </div>
                    </div>
                    <div class="single-column">
                        <div class="ul-footer-widget">
                            <h3 class="ul-footer-widget-title">CONTACTO</h3>

                            <div class="ul-footer-widget-links">
                                <a href="tel:+244921852727">+244 921 852 727</a>
                                <a href="mailto:comercial@qnbangola.com">comercial@qnbangola.com</a>
                                <a href="https://maps.app.goo.gl/ZXfSYE7ThcibKAXJ6" target="_blank" rel="noopener">Morro Bento, Rua da Anghotel, Luanda</a>
                            </div>
                        </div>
                    </div>
                    </div>
            </div>
        </div>

        <!-- footer bottom -->
        <div class="ul-footer-bottom">
            <p class="copyright-txt">&copy;2026 QNB-Imobiliária. Todos os direitos reservados</p>
        </div>

        <!-- vector -->
        <div class="ul-footer-vectors">
            <img src="<?php echo e(asset('assets/img/footer-vector-img-1.png')); ?>" alt="Footer Image" class="ul-footer-vector-1">
            <img src="<?php echo e(asset('assets/img/footer-vector-img-2.png')); ?>" alt="Footer Image" class="ul-footer-vector-2">
        </div>
    </footer>
    <!-- FOOTER SECTION END -->

    <!-- libraries JS -->
    <script src="<?php echo e(asset('assets/vendor/bootstrap/bootstrap.bundle.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/vendor/splide/splide.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/vendor/splide/splide-extension-auto-scroll.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/vendor/swiper/swiper-bundle.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/vendor/slim-select/slimselect.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/vendor/animate-wow/wow.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/vendor/fslightbox/fslightbox.js')); ?>"></script>

    <!-- custom JS -->
    <script src="<?php echo e(asset('assets/js/main.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/tab.js')); ?>"></script>
    <?php echo $__env->make('components.modal-global', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>

</html>
<?php /**PATH C:\Users\JORGE DANGE\Documents\PROGRAMACAO\WEB\QND\PageWeb\imobiliaria\qnb-imobiliaria\resources\views/layouts/site.blade.php ENDPATH**/ ?>