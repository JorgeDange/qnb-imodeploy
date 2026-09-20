<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'Painel - QNB-Imobiliária'); ?></title>

    <!-- libraries CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/icon/flaticon_real_estate.css')); ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="<?php echo e(asset('assets/vendor/bootstrap/bootstrap.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/vendor/animate-wow/animate.min.css')); ?>">

    <!-- custom CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/style.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('painel-assets/css/painel.css')); ?>">
    <link rel="icon" type="image/svg+xml" href="<?php echo e(asset('assets/img/logo-c.svg')); ?>">
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>

<body data-pagina="painel">
    <div class="preloader" id="preloader">
        <div class="loader"></div>
    </div>

    <div class="ul-painel">

        <!-- TOPBAR -->
        <div class="ul-painel-topbar">
            <div class="ul-painel-topbar-left">
                <a href="<?php echo e(route('home')); ?>"><img src="<?php echo e(asset('assets/img/logo.svg')); ?>" alt="QNB-Imobiliária" class="logo"></a>
            </div>
            <div class="ul-painel-topbar-right">
                <span class="ul-badge-estado"><?php echo e(ucfirst(Auth::guard('imobiliaria')->user()->estado)); ?></span>
                <a href="<?php echo e(route('home')); ?>" class="ul-painel-ver-site">Ver site público</a>
            </div>
        </div>

        <div class="ul-painel-corpo">

            <!-- SIDEBAR -->
            <aside class="ul-painel-sidebar">
                <div class="ul-painel-sidebar-perfil">
                    <div class="ul-painel-avatar">
                        <?php $imob = Auth::guard('imobiliaria')->user(); ?>
                        <?php if($imob->foto): ?>
                            <img src="<?php echo e(str_starts_with($imob->foto, 'assets/') ? asset($imob->foto) : asset('storage/' . $imob->foto)); ?>" alt="<?php echo e($imob->nome); ?>">
                        <?php else: ?>
                            <img src="<?php echo e(asset('assets/img/logo-c.svg')); ?>" alt="<?php echo e($imob->nome); ?>">
                        <?php endif; ?>
                    </div>
                    <h3 class="ul-painel-nome"><?php echo e($imob->nome); ?></h3>
                    <span class="ul-painel-email"><?php echo e($imob->email); ?></span>
                </div>
                <ul class="ul-painel-nav">
                    <li class="<?php echo e(request()->routeIs('painel.dashboard') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('painel.dashboard')); ?>"><i class="bi bi-speedometer2"></i> Dashboard</a>
                    </li>

                    
                    <li class="ul-painel-nav-seccao">GESTÃO</li>

                    <li class="<?php echo e(request()->routeIs('painel.imoveis*') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('painel.imoveis')); ?>"><i class="bi bi-house-door"></i> Meus Imóveis
                            <?php if($imoveisCount > 0): ?><span class="ul-painel-nav-badge"><?php echo e($imoveisCount); ?></span><?php endif; ?>
                        </a>
                    </li>

                    <li class="<?php echo e(request()->routeIs('painel.destaques*') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('painel.destaques')); ?>"><i class="bi bi-star"></i> Destaques
                            <?php if($destaquesCount > 0): ?><span class="ul-painel-nav-badge"><?php echo e($destaquesCount); ?></span><?php endif; ?>
                        </a>
                    </li>

                    
                    <li class="ul-painel-nav-seccao">COMUNICAÇÃO</li>

                    <li class="<?php echo e(request()->routeIs('painel.mensagens*') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('painel.mensagens')); ?>"><i class="bi bi-envelope"></i> Mensagens
                            <?php if($msgsNaoLidas > 0): ?><span class="ul-painel-nav-badge"><?php echo e($msgsNaoLidas); ?></span><?php endif; ?>
                        </a>
                    </li>

                    <li class="<?php echo e(request()->routeIs('painel.visitas*') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('painel.visitas')); ?>"><i class="bi bi-calendar-event"></i> Visitas
                            <?php if($visitasPend > 0): ?><span class="ul-painel-nav-badge"><?php echo e($visitasPend); ?></span><?php endif; ?>
                        </a>
                    </li>

                    
                    <li class="ul-painel-nav-seccao">CONTA</li>

                    <li class="<?php echo e(request()->routeIs('painel.ativar-plano') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('painel.ativar-plano')); ?>"><i class="bi bi-gem"></i> Meu Plano
                            <?php if(!$planoAtivo): ?>
                                <span class="ul-painel-nav-badge ul-painel-nav-badge--perigo">!</span>
                            <?php elseif($planoAtivo->data_expiracao && $planoAtivo->data_expiracao->isPast()): ?>
                                <span class="ul-painel-nav-badge ul-painel-nav-badge--perigo">!</span>
                            <?php elseif($planoAtivo->data_expiracao && $diasRestantes <= 7): ?>
                                <span class="ul-painel-nav-badge ul-painel-nav-badge--aviso"><?php echo e($diasRestantes); ?>d</span>
                            <?php endif; ?>
                        </a>
                    </li>

                    <li class="<?php echo e(request()->routeIs('painel.estatisticas*') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('painel.estatisticas')); ?>"><i class="bi bi-bar-chart"></i> Estatísticas</a>
                    </li>

                    <li class="<?php echo e(request()->routeIs('painel.perfil*') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('painel.perfil')); ?>"><i class="bi bi-person-circle"></i> Perfil</a>
                    </li>

                    <li>
                        <a href="<?php echo e(route('painel.logout')); ?>" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="bi bi-box-arrow-right"></i> Sair</a>
                        <form id="logout-form" action="<?php echo e(route('painel.logout')); ?>" method="POST" style="display:none;"><?php echo csrf_field(); ?></form>
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

        <!-- RODAPÉ -->
        <footer class="ul-painel-rodape">
            <span>© 2026 QNB-Imobiliária. Todos os direitos reservados.</span>
            <span><a href="<?php echo e(route('home')); ?>">Voltar ao site</a></span>
        </footer>
    </div>

    <!-- scripts -->
    <script src="<?php echo e(asset('assets/vendor/bootstrap/bootstrap.bundle.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/vendor/animate-wow/wow.min.js')); ?>"></script>
    <script src="<?php echo e(asset('painel-assets/js/painel-loader.js')); ?>"></script>
    <script src="<?php echo e(asset('painel-assets/js/painel.js')); ?>"></script>
    <?php echo $__env->make('components.modal-global', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>

</html>
<?php /**PATH C:\Users\JORGE DANGE\Documents\PROGRAMACAO\WEB\QND\PageWeb\imobiliaria\qnb-imobiliaria\resources\views\layouts\painel.blade.php ENDPATH**/ ?>