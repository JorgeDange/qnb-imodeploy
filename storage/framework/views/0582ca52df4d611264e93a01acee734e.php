<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'Admin — QNB-Imobiliária'); ?></title>

    <link rel="stylesheet" href="<?php echo e(asset('assets/icon/flaticon_real_estate.css')); ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="<?php echo e(asset('assets/vendor/bootstrap/bootstrap.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/vendor/animate-wow/animate.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/style.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('painel-assets/css/painel.css')); ?>">
    <link rel="icon" type="image/svg+xml" href="<?php echo e(asset('assets/img/logo-c.svg')); ?>">
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>

<body data-pagina="admin">
    <div class="preloader" id="preloader">
        <div class="loader"></div>
    </div>

    <div class="ul-painel">

        <!-- TOPBAR -->
        <div class="ul-painel-topbar">
            <div class="ul-painel-topbar-left">
                <a href="<?php echo e(route('admin.dashboard')); ?>"><img src="<?php echo e(asset('assets/img/logo.svg')); ?>" alt="QNB-Imobiliária" class="logo"></a>
            </div>
            <div class="ul-painel-topbar-right">
                <span class="ul-badge-estado" style="background:rgba(255,255,255,0.15);border-color:rgba(255,255,255,0.25);">Admin</span>
                <a href="<?php echo e(route('home')); ?>" class="ul-painel-ver-site">Ver site público</a>
            </div>
        </div>

        <div class="ul-painel-corpo">

            <!-- SIDEBAR -->
            <aside class="ul-painel-sidebar">
                <div class="ul-painel-sidebar-perfil">
                    <div class="ul-painel-avatar"><img src="<?php echo e(asset('assets/img/team-1.jpg')); ?>" alt="Admin"></div>
                    <h3 class="ul-painel-nome"><?php echo e(Auth::guard('admin')->user()->nome ?? 'Admin'); ?></h3>
                    <span class="ul-painel-email"><?php echo e(Auth::guard('admin')->user()->email ?? 'admin@qnbangola.com'); ?></span>
                </div>
                <ul class="ul-painel-nav">
                    <li class="<?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('admin.dashboard')); ?>"><i class="bi bi-speedometer2"></i> Dashboard</a>
                    </li>

                    
                    <li class="ul-painel-nav-seccao">MODERAÇÃO</li>

                    <li class="<?php echo e(request()->routeIs('admin.imobiliarias*') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('admin.imobiliarias')); ?>"><i class="bi bi-buildings"></i> Imobiliárias
                            <?php if($impPend > 0): ?><span class="ul-painel-nav-badge"><?php echo e($impPend); ?></span><?php endif; ?>
                        </a>
                    </li>

                    <li class="<?php echo e(request()->routeIs('admin.imoveis*') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('admin.imoveis')); ?>"><i class="bi bi-house-door"></i> Imóveis
                            <?php if($imoPend > 0): ?><span class="ul-painel-nav-badge"><?php echo e($imoPend); ?></span><?php endif; ?>
                        </a>
                    </li>

                    <li class="<?php echo e(request()->routeIs('admin.pedidos*') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('admin.pedidos')); ?>"><i class="bi bi-inbox"></i> Pedidos
                            <?php if($pedNovos > 0): ?><span class="ul-painel-nav-badge"><?php echo e($pedNovos); ?></span><?php endif; ?>
                        </a>
                    </li>

                    <li class="<?php echo e(request()->routeIs('admin.denuncias*') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('admin.denuncias')); ?>"><i class="bi bi-flag"></i> Denúncias
                            <?php if($denPend > 0): ?><span class="ul-painel-nav-badge"><?php echo e($denPend); ?></span><?php endif; ?>
                        </a>
                    </li>

                    <li class="<?php echo e(request()->routeIs('admin.avaliacoes*') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('admin.avaliacoes')); ?>"><i class="bi bi-star"></i> Avaliações
                            <?php if($avalPend > 0): ?><span class="ul-painel-nav-badge"><?php echo e($avalPend); ?></span><?php endif; ?>
                        </a>
                    </li>

                    
                    <li class="ul-painel-nav-seccao">CLIENTES</li>

                    <li class="<?php echo e(request()->routeIs('admin.mensagens*') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('admin.mensagens')); ?>"><i class="bi bi-envelope"></i> Mensagens
                            <?php if($msgNaoLidas > 0): ?><span class="ul-painel-nav-badge"><?php echo e($msgNaoLidas); ?></span><?php endif; ?>
                        </a>
                    </li>

                    <li class="<?php echo e(request()->routeIs('admin.visitas*') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('admin.visitas')); ?>"><i class="bi bi-calendar-event"></i> Visitas
                            <?php if($visHoje > 0): ?><span class="ul-painel-nav-badge"><?php echo e($visHoje); ?></span><?php endif; ?>
                        </a>
                    </li>

                    
                    <li class="ul-painel-nav-seccao">COMERCIAL</li>

                    <li class="<?php echo e(request()->routeIs('admin.planos*') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('admin.planos')); ?>"><i class="bi bi-gem"></i> Planos</a>
                    </li>

                    <li class="<?php echo e(request()->routeIs('admin.subscricoes*') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('admin.subscricoes')); ?>"><i class="bi bi-arrow-repeat"></i> Subscrições
                            <?php if($subAtivas > 0): ?><span class="ul-painel-nav-badge ul-painel-nav-badge--info"><?php echo e($subAtivas); ?></span><?php endif; ?>
                        </a>
                    </li>

                    <li class="<?php echo e(request()->routeIs('admin.pagamentos*') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('admin.pagamentos')); ?>"><i class="bi bi-credit-card"></i> Pagamentos
                            <?php if($pagPend > 0): ?><span class="ul-painel-nav-badge"><?php echo e($pagPend); ?></span><?php endif; ?>
                        </a>
                    </li>

                    <li class="<?php echo e(request()->routeIs('admin.faturas*') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('admin.faturas')); ?>"><i class="bi bi-receipt"></i> Faturas</a>
                    </li>

                    
                    <li class="ul-painel-nav-seccao">CONTEÚDO</li>

                    <li class="<?php echo e(request()->routeIs('admin.settings') || request()->routeIs('admin.depoimentos*') || request()->routeIs('admin.parceiros*') || request()->routeIs('admin.faq*') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('admin.settings')); ?>"><i class="bi bi-collection"></i> Conteúdo</a>
                    </li>

                    
                    <li class="ul-painel-nav-seccao">ANÁLISE</li>

                    <li class="<?php echo e(request()->routeIs('admin.relatorios*') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('admin.relatorios')); ?>"><i class="bi bi-bar-chart"></i> Relatórios</a>
                    </li>

                    <li class="<?php echo e(request()->routeIs('admin.exportar*') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('admin.exportar.imoveis')); ?>"><i class="bi bi-download"></i> Exportar</a>
                    </li>

                    
                    <li class="ul-painel-nav-seccao">SISTEMA</li>

                    <li class="<?php echo e(request()->routeIs('admin.logs*') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('admin.logs')); ?>"><i class="bi bi-clock-history"></i> Logs</a>
                    </li>

                    <li class="<?php echo e(request()->routeIs('admin.compliance*') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('admin.settings')); ?>"><i class="bi bi-gear"></i> Configurações</a>
                    </li>

                    <li class="<?php echo e(request()->routeIs('admin.admins*') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('admin.admins')); ?>"><i class="bi bi-person-badge"></i> Administradores
                            <?php if($adminCount > 0): ?><span class="ul-painel-nav-badge ul-painel-nav-badge--info"><?php echo e($adminCount); ?></span><?php endif; ?>
                        </a>
                    </li>

                    <li>
                        <a href="<?php echo e(route('admin.logout')); ?>" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="bi bi-box-arrow-right"></i> Sair</a>
                        <form id="logout-form" action="<?php echo e(route('admin.logout')); ?>" method="POST" style="display:none;"><?php echo csrf_field(); ?></form>
                    </li>
                </ul>
            </aside>

            <!-- CONTEÚDO -->
            <div class="ul-painel-conteudo">
                <div class="ul-painel-conteudo-inner">

                    <?php echo $__env->make('components.flash', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

                    <?php echo $__env->yieldContent('content'); ?>
                </div>
            </div>
        </div>

        <footer class="ul-painel-rodape">
            <span>© 2026 QNB-Imobiliária — Painel Admin</span>
        </footer>
    </div>

    <script src="<?php echo e(asset('assets/vendor/bootstrap/bootstrap.bundle.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/vendor/animate-wow/wow.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/vendor/jquery.min.js')); ?>"></script>
    <!-- Chart.js carregado no dashboard via <?php $__env->startPush('scripts'); ?> -->
    <script src="<?php echo e(asset('painel-assets/js/painel-loader.js')); ?>"></script>
    <script src="<?php echo e(asset('painel-assets/js/painel.js')); ?>"></script>
    <?php echo $__env->make('components.modal-global', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>

</html>
<?php /**PATH C:\Users\JORGE DANGE\Documents\PROGRAMACAO\WEB\QND\PageWeb\imobiliaria\qnb-imobiliaria\resources\views\admin\layouts\admin.blade.php ENDPATH**/ ?>