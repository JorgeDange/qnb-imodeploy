<?php $__env->startSection('title', 'Destaques — Painel'); ?>

<?php $__env->startSection('content'); ?>
<div class="ul-painel-cabecalho">
    <h1 class="ul-painel-titulo">Destaques</h1>
    <a href="<?php echo e(route('painel.imoveis.novo')); ?>" class="ul-painel-btn ul-painel-btn--primario"><i class="bi bi-plus-lg"></i> Novo Imóvel</a>
</div>

<?php if($plano): ?>
<div class="ul-painel-aviso ul-painel-aviso--cinza" style="margin-bottom:20px;">
    <div class="ul-painel-aviso-texto">
        <p>Imóveis em destaque: <strong><?php echo e($imoveis->count()); ?></strong></p>
    </div>
</div>
<?php endif; ?>

<?php if($imoveis->count()): ?>
    <?php $__currentLoopData = $imoveis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $imovel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="ul-painel-imovel">
        <div class="ul-painel-imovel-foto">
            <?php if($imovel->fotos->count()): ?>
                <img src="<?php echo e(asset('storage/' . $imovel->fotos->first()->caminho)); ?>" alt="<?php echo e($imovel->titulo); ?>">
            <?php else: ?>
                <div style="width:100%;height:100%;background:#f1f5f9;display:grid;place-items:center;color:#aaa;"><i class="bi bi-house"></i></div>
            <?php endif; ?>
        </div>
        <div class="ul-painel-imovel-info">
            <span class="ul-painel-imovel-titulo"><?php echo e($imovel->titulo); ?></span>
            <span class="ul-painel-imovel-ref"><?php echo e($imovel->referencia); ?></span>
            <span class="ul-painel-imovel-local"><i class="bi bi-geo-alt"></i> <?php echo e($imovel->municipio); ?>, <?php echo e($imovel->provincia); ?></span>
            <span class="ul-painel-imovel-preco"><?php echo e(number_format($imovel->preco, 0, ',', '.')); ?> <?php echo e($imovel->moeda); ?></span>
            <div class="ul-painel-imovel-stats">
                <span class="ul-painel-imovel-stat"><i class="bi bi-eye"></i> <?php echo e($imovel->visualizacoes); ?></span>
                <span class="ul-painel-imovel-stat"><i class="bi bi-telephone"></i> <?php echo e($imovel->contactos); ?></span>
            </div>
        </div>
        <div class="ul-painel-imovel-acoes">
            <span class="ul-badge ul-badge--destaque"><i class="bi bi-star"></i> Destaque</span>
            <form id="destaque-form-<?php echo e($imovel->id); ?>" action="<?php echo e(route('painel.imoveis.destaque', $imovel)); ?>" method="POST" style="display:inline;">
                <?php echo csrf_field(); ?>
                <button type="button" class="ul-painel-btn ul-painel-btn--pequeno" style="color:#ef4444;" title="Remover destaque" onclick="modalPerigo('Remover Destaque', 'Remover este imóvel dos destaques?', function(){ document.getElementById('destaque-form-<?php echo e($imovel->id); ?>').submit(); })"><i class="bi bi-x-lg"></i></button>
            </form>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php else: ?>
    <div class="ul-painel-vazio">
        <p>Nenhum imóvel em destaque.</p>
        <p style="font-size:13px;margin-top:8px;">Destaque os seus melhores imóveis na página de imóveis.</p>
    </div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.painel', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\JORGE DANGE\Documents\PROGRAMACAO\WEB\QND\PageWeb\imobiliaria\qnb-imobiliaria\resources\views\painel\destaques.blade.php ENDPATH**/ ?>