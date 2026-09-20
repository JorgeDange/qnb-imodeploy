<?php $__env->startSection('title', $imobiliaria->nome . ' - Admin'); ?>
<?php $__env->startSection('pageTitle', $imobiliaria->nome); ?>

<?php $__env->startSection('content'); ?>
<!-- back button -->
<div class="ul-painel-head">
    <a href="<?php echo e(route('admin.imobiliarias')); ?>" class="ul-btn ul-btn--sm" style="background:var(--ul-gray);color:var(--ul-secondary);">
        <i class="bi bi-arrow-left"></i> Voltar
    </a>
</div>

<!-- info card -->
<div class="ul-painel-card">
    <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;margin-bottom:18px;">
        <h2 class="ul-painel-card-titulo">Informações da Imobiliária</h2>
        <span class="ul-badge ul-badge--<?php echo e($imobiliaria->estado === 'aprovada' ? 'aprovado' : ($imobiliaria->estado === 'pendente' ? 'pendente' : 'rejeitado')); ?>">
            <?php echo e(ucfirst($imobiliaria->estado)); ?>

        </span>
    </div>
    <div class="ul-painel-grid-dados">
        <div class="ul-painel-dado">
            <span class="ul-painel-dado-rotulo">Nome</span>
            <span class="ul-painel-dado-valor"><?php echo e($imobiliaria->nome); ?></span>
        </div>
        <div class="ul-painel-dado">
            <span class="ul-painel-dado-rotulo">Email</span>
            <span class="ul-painel-dado-valor"><?php echo e($imobiliaria->email); ?></span>
        </div>
        <div class="ul-painel-dado">
            <span class="ul-painel-dado-rotulo">Telefone</span>
            <span class="ul-painel-dado-valor"><?php echo e($imobiliaria->telefone); ?></span>
        </div>
        <div class="ul-painel-dado">
            <span class="ul-painel-dado-rotulo">NIF</span>
            <span class="ul-painel-dado-valor"><?php echo e($imobiliaria->nif ?? '—'); ?></span>
        </div>
        <div class="ul-painel-dado">
            <span class="ul-painel-dado-rotulo">Província</span>
            <span class="ul-painel-dado-valor"><?php echo e($imobiliaria->provincia ?? '—'); ?></span>
        </div>
        <div class="ul-painel-dado">
            <span class="ul-painel-dado-rotulo">Município</span>
            <span class="ul-painel-dado-valor"><?php echo e($imobiliaria->municipio ?? '—'); ?></span>
        </div>
        <div class="ul-painel-dado">
            <span class="ul-painel-dado-rotulo">Data Registo</span>
            <span class="ul-painel-dado-valor"><?php echo e($imobiliaria->created_at->format('d/m/Y H:i')); ?></span>
        </div>
    </div>
</div>

<!-- plano atual -->
<div class="ul-painel-card">
    <h2 class="ul-painel-card-titulo" style="margin-bottom:14px;">Plano Atual</h2>
    <?php if($imobiliaria->planoAtivo ?? null): ?>
    <div class="ul-painel-grid-dados">
        <div class="ul-painel-dado">
            <span class="ul-painel-dado-rotulo">Plano</span>
            <span class="ul-painel-dado-valor"><?php echo e($imobiliaria->planoAtivo->plano->nome ?? '—'); ?></span>
        </div>
        <div class="ul-painel-dado">
            <span class="ul-painel-dado-rotulo">Posts Usados</span>
            <span class="ul-painel-dado-valor"><?php echo e($imobiliaria->planoAtivo->posts_usados ?? 0); ?> / <?php echo e($imobiliaria->planoAtivo->plano->posts_limite ?? '∞'); ?></span>
        </div>
        <div class="ul-painel-dado">
            <span class="ul-painel-dado-rotulo">Validade</span>
            <span class="ul-painel-dado-valor"><?php echo e($imobiliaria->planoAtivo->data_expiracao ? $imobiliaria->planoAtivo->data_expiracao->format('d/m/Y') : 'Indefinida'); ?></span>
        </div>
    </div>
    <?php else: ?>
    <div class="ul-painel-vazio">
        <p>Nenhum plano ativo.</p>
    </div>
    <?php endif; ?>
</div>

<!-- imóveis -->
<div class="ul-painel-card">
    <h2 class="ul-painel-card-titulo" style="margin-bottom:14px;">Imóveis da Imobiliária</h2>
    <?php if($imobiliaria->imoveis->count()): ?>
        <?php $__currentLoopData = $imobiliaria->imoveis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $imovel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="ul-painel-imovel">
            <div class="ul-painel-imovel-info">
                <span class="ul-painel-imovel-titulo"><?php echo e($imovel->titulo); ?></span>
                <span class="ul-painel-imovel-ref">Ref: <?php echo e($imovel->referencia); ?></span>
                <div class="ul-painel-imovel-preco"><?php echo e(number_format($imovel->preco, 0, ',', '.')); ?> <?php echo e($imovel->moeda); ?></div>
            </div>
            <div class="ul-painel-imovel-acoes">
                <span class="ul-badge ul-badge--<?php echo e($imovel->estado); ?>">
                    <?php echo e(ucfirst($imovel->estado)); ?>

                </span>
                <a href="<?php echo e(route('admin.imoveis.show', $imovel->id)); ?>" class="ul-btn ul-btn--sm" style="background:var(--ul-primary);color:var(--white);">Ver</a>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php else: ?>
    <div class="ul-painel-vazio">
        <p>Esta imobiliária ainda não tem imóveis.</p>
    </div>
    <?php endif; ?>
</div>

<!-- actions -->
<div class="ul-painel-card">
    <h2 class="ul-painel-card-titulo" style="margin-bottom:14px;">Ações</h2>
    <div style="display:flex;gap:10px;flex-wrap:wrap;">
        <?php if($imobiliaria->estado === 'pendente'): ?>
        <form id="imob-aprovar-<?php echo e($imobiliaria->id); ?>" action="<?php echo e(route('admin.imobiliarias.aprovar', $imobiliaria->id)); ?>" method="POST" class="d-inline">
            <?php echo csrf_field(); ?>
            <button type="button" class="ul-btn ul-btn--sm ul-btn--sucesso" onclick="modalConfirmar('Aprovar Imobiliária', 'Aprovar esta imobiliária?', function(){ document.getElementById('imob-aprovar-<?php echo e($imobiliaria->id); ?>').submit(); })">Aprovar Imobiliária</button>
        </form>
        <?php endif; ?>
        <?php if($imobiliaria->estado === 'aprovada'): ?>
        <form id="imob-suspender-<?php echo e($imobiliaria->id); ?>" action="<?php echo e(route('admin.imobiliarias.suspender', $imobiliaria->id)); ?>" method="POST" class="d-inline">
            <?php echo csrf_field(); ?>
            <button type="button" class="ul-btn ul-btn--sm ul-btn--aviso" onclick="modalPerigo('Suspender Imobiliária', 'Suspender esta imobiliária?', function(){ document.getElementById('imob-suspender-<?php echo e($imobiliaria->id); ?>').submit(); })">Suspender Imobiliária</button>
        </form>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\JORGE DANGE\Documents\PROGRAMACAO\WEB\QND\PageWeb\imobiliaria\qnb-imobiliaria\resources\views\admin\imobiliarias\show.blade.php ENDPATH**/ ?>