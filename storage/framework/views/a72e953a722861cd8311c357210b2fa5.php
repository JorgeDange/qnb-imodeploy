<?php $__env->startSection('title', 'Estatísticas — Painel'); ?>

<?php $__env->startSection('content'); ?>
<div class="ul-painel-cabecalho">
    <h1 class="ul-painel-titulo">Estatísticas</h1>
</div>

<div class="ul-painel-stats" style="margin-bottom:20px;">
    <div class="ul-painel-stat">
        <span class="ul-painel-stat-numero"><?php echo e($stats['total_visualizacoes']); ?></span>
        <span class="ul-painel-stat-rotulo">Visualizações</span>
    </div>
    <div class="ul-painel-stat">
        <span class="ul-painel-stat-numero"><?php echo e($stats['total_contactos']); ?></span>
        <span class="ul-painel-stat-rotulo">Contactos gerados</span>
    </div>
    <div class="ul-painel-stat">
        <span class="ul-painel-stat-numero"><?php echo e($stats['total_imoveis']); ?></span>
        <span class="ul-painel-stat-rotulo">Total imóveis</span>
    </div>
    <div class="ul-painel-stat">
        <span class="ul-painel-stat-numero"><?php echo e($stats['aprovados']); ?></span>
        <span class="ul-painel-stat-rotulo">Publicados</span>
    </div>
    <div class="ul-painel-stat">
        <span class="ul-painel-stat-numero"><?php echo e($stats['pendentes']); ?></span>
        <span class="ul-painel-stat-rotulo">Pendentes</span>
    </div>
</div>

<div class="ul-painel-dash-cols">
    <div class="ul-painel-card">
        <h3 class="ul-painel-card-titulo" style="font-size:16px;margin-bottom:14px;">Imóveis Mais Vistos</h3>
        <?php $__empty_1 = true; $__currentLoopData = $maisVistos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $imovel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="ul-painel-lista-item">
            <div class="ul-painel-lista-info">
                <strong><?php echo e($imovel->titulo); ?></strong>
                <small><?php echo e($imovel->municipio); ?>, <?php echo e($imovel->provincia); ?></small>
            </div>
            <span style="font-weight:700;color:var(--ul-primary);"><?php echo e($imovel->visualizacoes); ?> <small style="font-weight:400;color:var(--ul-gray2);">vistos</small></span>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <p style="color:#888;text-align:center;padding:20px;">Sem dados ainda.</p>
        <?php endif; ?>
    </div>

    <div class="ul-painel-card">
        <h3 class="ul-painel-card-titulo" style="font-size:16px;margin-bottom:14px;">Imóveis Mais Contactados</h3>
        <?php $__empty_1 = true; $__currentLoopData = $maisContactados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $imovel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="ul-painel-lista-item">
            <div class="ul-painel-lista-info">
                <strong><?php echo e($imovel->titulo); ?></strong>
                <small><?php echo e($imovel->municipio); ?>, <?php echo e($imovel->provincia); ?></small>
            </div>
            <span style="font-weight:700;color:var(--ul-primary);"><?php echo e($imovel->contactos); ?> <small style="font-weight:400;color:var(--ul-gray2);">contactos</small></span>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <p style="color:#888;text-align:center;padding:20px;">Sem dados ainda.</p>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.painel', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\JORGE DANGE\Documents\PROGRAMACAO\WEB\QND\PageWeb\imobiliaria\qnb-imobiliaria\resources\views\painel\estatisticas.blade.php ENDPATH**/ ?>