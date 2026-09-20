

<?php $__env->startSection('title', 'Ativar Plano — Painel | QNB-Imobiliária'); ?>

<?php $__env->startSection('content'); ?>
<div class="ul-painel-head">
    <div>
        <h3 class="ul-painel-card-titulo ul-mb-4">Ativar Plano</h3>
        <p class="ul-painel-card-subtitulo ul-mb-0">Escolha o plano ideal para a sua imobiliária.</p>
    </div>
</div>

<div class="row">
    <?php $__empty_1 = true; $__currentLoopData = $planos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $planoItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <div class="col-lg-4">
        <div class="ul-painel-card" style="text-align:center;<?php echo e($imobiliaria->getPlanoAtivo() && $imobiliaria->getPlanoAtivo()->plano_id == $planoItem->id ? 'border:2px solid var(--ul-primary);' : ''); ?>">
            <h3 class="ul-painel-card-titulo"><?php echo e($planoItem->nome); ?></h3>
            <?php if($planoItem->destaque): ?>
            <span class="ul-badge ul-badge--destaque" style="margin-bottom:10px;">Recomendado</span>
            <?php endif; ?>
            <div style="padding:20px 0;">
                <span style="font-size:36px;font-weight:700;color:var(--ul-primary);"><?php echo e(number_format($planoItem->preco, 0, ',', '.')); ?></span>
                <span style="font-size:14px;color:#999;"><?php echo e($planoItem->moeda); ?></span>
                <span style="font-size:13px;color:#999;">/ <?php echo e($planoItem->dias_validade); ?> dias</span>
            </div>
            <div class="ul-painel-grid-dados" style="text-align:left;padding:0 15px 20px;">
                <div class="ul-painel-dado"><span class="ul-painel-dado-rotulo">Posts</span><span class="ul-painel-dado-valor"><?php echo e($planoItem->posts_limite); ?> imóveis</span></div>
                <div class="ul-painel-dado"><span class="ul-painel-dado-rotulo">Validade</span><span class="ul-painel-dado-valor"><?php echo e($planoItem->dias_validade); ?> dias</span></div>
                <div class="ul-painel-dado"><span class="ul-painel-dado-rotulo">Destaques</span><span class="ul-painel-dado-valor"><?php echo e($planoItem->destaque ? 'Permitidos' : 'Não permitidos'); ?></span></div>
            </div>
            <?php if($imobiliaria->getPlanoAtivo() && $imobiliaria->getPlanoAtivo()->plano_id == $planoItem->id): ?>
            <span class="ul-painel-btn" style="opacity:0.5;cursor:default;">Plano Atual</span>
            <?php else: ?>
            <a href="<?php echo e(route('painel.pagamento.novo')); ?>" class="ul-painel-btn" style="margin:0 15px 20px;">Ativar Agora</a>
            <?php endif; ?>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <div class="col-12">
        <div class="ul-painel-vazio">
            <p>Nenhum plano disponível no momento.</p>
        </div>
    </div>
    <?php endif; ?>
</div>

<?php if($imobiliaria->getPlanoAtivo()): ?>
<div class="ul-painel-card" style="margin-top:25px;">
    <h3 class="ul-painel-card-titulo">Plano Atual</h3>
    <div class="ul-painel-grid-dados">
        <div class="ul-painel-dado"><span class="ul-painel-dado-rotulo">Plano</span><span class="ul-painel-dado-valor"><?php echo e($imobiliaria->getPlanoAtivo()->plano->nome); ?></span></div>
        <div class="ul-painel-dado"><span class="ul-painel-dado-rotulo">Posts</span><span class="ul-painel-dado-valor"><?php echo e($imobiliaria->getPlanoAtivo()->posts_usados); ?> / <?php echo e($imobiliaria->getPlanoAtivo()->plano->posts_limite); ?></span></div>
        <div class="ul-painel-dado"><span class="ul-painel-dado-rotulo">Ativado</span><span class="ul-painel-dado-valor"><?php echo e($imobiliaria->getPlanoAtivo()->data_inicio ? $imobiliaria->getPlanoAtivo()->data_inicio->format('d/m/Y') : '—'); ?></span></div>
        <div class="ul-painel-dado"><span class="ul-painel-dado-rotulo">Expira</span><span class="ul-painel-dado-valor"><?php echo e($imobiliaria->getPlanoAtivo()->data_expiracao ? $imobiliaria->getPlanoAtivo()->data_expiracao->format('d/m/Y') : 'Indefinida'); ?></span></div>
    </div>
</div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.painel', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\JORGE DANGE\Documents\PROGRAMACAO\WEB\QND\PageWeb\imobiliaria\qnb-imobiliaria\resources\views\painel\ativar-plano.blade.php ENDPATH**/ ?>