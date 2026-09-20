

<?php $__env->startSection('title', 'Meus Imóveis — Painel | QNB-Imobiliária'); ?>

<?php $__env->startSection('content'); ?>
<div class="ul-painel-head">
    <div>
        <h3 class="ul-painel-card-titulo" style="margin-bottom:4px;">Meus Imóveis</h3>
        <p class="ul-painel-card-subtitulo" style="margin-bottom:0;">Gerencie todos os seus anúncios.</p>
    </div>
    <?php if($plano && $plano->posts_usados < $plano->plano->posts_limite): ?>
    <a href="<?php echo e(route('painel.imoveis.novo')); ?>" class="ul-btn"><i class="bi bi-plus-lg"></i> Novo Imóvel</a>
    <?php endif; ?>
</div>

<?php if($plano): ?>
<div class="ul-painel-aviso ul-painel-aviso--cinza">
    <div class="ul-painel-aviso-icone"><i class="bi bi-list-ul"></i></div>
    <div class="ul-painel-aviso-texto">
        <h4 class="ul-painel-aviso-titulo">Limite de Posts</h4>
        <p>Posts utilizados: <strong><?php echo e($plano->posts_usados); ?> / <?php echo e($plano->plano->posts_limite); ?></strong></p>
    </div>
</div>
<?php endif; ?>

<?php if($imoveis->count()): ?>
    <?php $__currentLoopData = $imoveis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $imovel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="ul-painel-imovel">
        <?php if($imovel->capaFoto()): ?>
        <div class="ul-painel-imovel-foto"><img src="<?php echo e(asset('storage/' . $imovel->capaFoto()->caminho)); ?>" alt="<?php echo e($imovel->titulo); ?>"></div>
        <?php else: ?>
        <div class="ul-painel-imovel-foto"><img src="<?php echo e(asset('assets/img/project-1.jpg')); ?>" alt="<?php echo e($imovel->titulo); ?>"></div>
        <?php endif; ?>
        <div class="ul-painel-imovel-info">
            <h4 class="ul-painel-imovel-titulo"><?php echo e($imovel->titulo); ?></h4>
            <span class="ul-painel-imovel-ref">Ref: <?php echo e($imovel->referencia); ?></span>
            <span class="ul-painel-imovel-local"><?php echo e($imovel->bairro); ?>, <?php echo e($imovel->municipio); ?></span>
            <span class="ul-painel-imovel-preco"><?php echo e(number_format($imovel->preco, 0, ',', '.')); ?> <?php echo e($imovel->moeda); ?></span>
            <div class="ul-painel-imovel-acoes">
                <span class="ul-badge ul-badge--<?php echo e($imovel->estado); ?>"><?php echo e(ucfirst($imovel->estado)); ?></span>
                <?php if($imovel->destaque): ?><span class="ul-badge ul-badge--destaque"><i class="bi bi-star"></i> Destaque</span><?php endif; ?>
                <a href="<?php echo e(route('painel.imoveis.editar', $imovel->id)); ?>" class="ul-btn ul-btn--sm">Editar</a>
                <form id="imovel-del-<?php echo e($imovel->id); ?>" action="<?php echo e(route('painel.imoveis.deletar', $imovel->id)); ?>" method="POST" class="d-inline">
                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                    <button type="button" class="ul-btn ul-btn--sm" style="background:#e74c3c;color:#fff;" onclick="modalPerigo('Remover Imóvel', 'Tem certeza que deseja remover este imóvel?', function(){ document.getElementById('imovel-del-<?php echo e($imovel->id); ?>').submit(); })">Remover</button>
                </form>
                <?php if($imovel->estado === 'aprovado'): ?>
                <form action="<?php echo e(route('painel.imoveis.destaque', $imovel->id)); ?>" method="POST" class="d-inline">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="ul-btn ul-btn--sm"><?php echo e($imovel->destaque ? '★ Destaque' : '☆ Destaque'); ?></button>
                </form>
                <?php endif; ?>
            </div>
            <div class="ul-painel-imovel-stats">
                <span class="ul-painel-imovel-stat"><i class="bi bi-info-circle"></i> <?php echo e($imovel->visualizacoes); ?></span>
                <span class="ul-painel-imovel-stat"><i class="bi bi-telephone"></i> <?php echo e($imovel->contactos); ?></span>
            </div>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php else: ?>
<div class="ul-painel-vazio">
    <i class="bi bi-house" style="font-size:48px;color:#ccc;margin-bottom:15px;display:block;"></i>
    <p>Nenhum imóvel cadastrado ainda.</p>
    <a href="<?php echo e(route('painel.imoveis.novo')); ?>" class="ul-btn">Cadastrar Primeiro Imóvel</a>
</div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.painel', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\JORGE DANGE\Documents\PROGRAMACAO\WEB\QND\PageWeb\imobiliaria\qnb-imobiliaria\resources\views\painel\imoveis\index.blade.php ENDPATH**/ ?>