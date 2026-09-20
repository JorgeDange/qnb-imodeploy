<?php $__env->startSection('title', $imovel->titulo . ' - Admin'); ?>
<?php $__env->startSection('pageTitle', $imovel->titulo); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-3">
    <a href="<?php echo e(route('admin.imoveis')); ?>" class="ul-btn ul-btn--sm">
        <i class="bi bi-arrow-left"></i> Voltar
    </a>
</div>

<!-- info card -->
<div class="ul-painel-card">
    <div class="ul-painel-head">
        <h3 class="ul-painel-card-titulo">Informações do Imóvel</h3>
        <span class="ul-badge ul-badge--<?php echo e($imovel->estado); ?>"><?php echo e(ucfirst($imovel->estado)); ?></span>
    </div>
    <div class="ul-painel-grid-dados">
        <div class="ul-painel-dado">
            <span class="ul-painel-dado-rotulo">Referência</span>
            <span class="ul-painel-dado-valor"><?php echo e($imovel->referencia); ?></span>
        </div>
        <div class="ul-painel-dado">
            <span class="ul-painel-dado-rotulo">Título</span>
            <span class="ul-painel-dado-valor"><?php echo e($imovel->titulo); ?></span>
        </div>
        <div class="ul-painel-dado">
            <span class="ul-painel-dado-rotulo">Tipo</span>
            <span class="ul-painel-dado-valor"><?php echo e($imovel->tipo); ?></span>
        </div>
        <div class="ul-painel-dado">
            <span class="ul-painel-dado-rotulo">Preço</span>
            <span class="ul-painel-dado-valor"><?php echo e(number_format($imovel->preco, 0, ',', '.')); ?> <?php echo e($imovel->moeda); ?></span>
        </div>
        <div class="ul-painel-dado">
            <span class="ul-painel-dado-rotulo">Província</span>
            <span class="ul-painel-dado-valor"><?php echo e($imovel->provincia); ?></span>
        </div>
        <div class="ul-painel-dado">
            <span class="ul-painel-dado-rotulo">Município</span>
            <span class="ul-painel-dado-valor"><?php echo e($imovel->municipio); ?></span>
        </div>
        <div class="ul-painel-dado">
            <span class="ul-painel-dado-rotulo">Quartos</span>
            <span class="ul-painel-dado-valor"><?php echo e($imovel->quartos ?? '—'); ?></span>
        </div>
        <div class="ul-painel-dado">
            <span class="ul-painel-dado-rotulo">Casas de Banho</span>
            <span class="ul-painel-dado-valor"><?php echo e($imovel->casas_banho ?? '—'); ?></span>
        </div>
        <div class="ul-painel-dado">
            <span class="ul-painel-dado-rotulo">Área</span>
            <span class="ul-painel-dado-valor"><?php echo e($imovel->area ? $imovel->area . ' m²' : '—'); ?></span>
        </div>
        <div class="ul-painel-dado">
            <span class="ul-painel-dado-rotulo">Imobiliária</span>
            <span class="ul-painel-dado-valor"><?php echo e($imovel->imobiliaria->nome ?? '—'); ?></span>
        </div>
        <div class="ul-painel-dado">
            <span class="ul-painel-dado-rotulo">Data Registo</span>
            <span class="ul-painel-dado-valor"><?php echo e($imovel->created_at->format('d/m/Y H:i')); ?></span>
        </div>
    </div>
    <div style="margin-top:18px;">
        <span class="ul-painel-dado-rotulo">Descrição</span>
        <p style="font-size:14px;color:var(--ul-gray2);margin:6px 0 0;"><?php echo e($imovel->descricao ?? 'Sem descrição'); ?></p>
    </div>
</div>

<!-- fotos -->
<div class="ul-painel-card">
    <h3 class="ul-painel-card-titulo">Fotos</h3>
    <?php if($imovel->fotos->count()): ?>
    <div class="ul-fotos-preview">
        <?php $__currentLoopData = $imovel->fotos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $foto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div style="position:relative;display:inline-block;">
            <img src="<?php echo e(asset('storage/' . $foto->caminho)); ?>" alt="<?php echo e($imovel->titulo); ?>">
            <?php if($foto->principal): ?>
            <span class="ul-badge ul-badge--destaque" style="position:absolute;top:6px;left:6px;">Principal</span>
            <?php endif; ?>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <?php else: ?>
    <div class="ul-painel-vazio">
        <p>Nenhuma foto disponível.</p>
    </div>
    <?php endif; ?>
</div>

<!-- amenities -->
<?php if($imovel->amenidades->count()): ?>
<div class="ul-painel-card">
    <h3 class="ul-painel-card-titulo">Comodidades</h3>
    <div class="ul-amenidades-grid">
        <?php $__currentLoopData = $imovel->amenidades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $amenity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <span class="ul-badge ul-badge--aprovado"><?php echo e($amenity->nome); ?></span>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>
<?php endif; ?>

<!-- actions -->
<?php if($imovel->estado === 'pendente'): ?>
<div class="ul-painel-card">
    <h3 class="ul-painel-card-titulo">Ações</h3>
    <div style="display:flex;gap:10px;flex-wrap:wrap;">
        <form id="imov-aprovar-<?php echo e($imovel->id); ?>" action="<?php echo e(route('admin.imoveis.aprovar', $imovel->id)); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <button type="button" class="ul-btn ul-btn--sm ul-btn--sucesso" onclick="modalConfirmar('Aprovar Imóvel', 'Aprovar este imóvel?', function(){ document.getElementById('imov-aprovar-<?php echo e($imovel->id); ?>').submit(); })">Aprovar Imóvel</button>
        </form>
        <form id="imov-rejeitar-<?php echo e($imovel->id); ?>" action="<?php echo e(route('admin.imoveis.rejeitar', $imovel->id)); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <button type="button" class="ul-btn ul-btn--sm ul-btn--perigo" onclick="modalPerigo('Rejeitar Imóvel', 'Rejeitar este imóvel?', function(){ document.getElementById('imov-rejeitar-<?php echo e($imovel->id); ?>').submit(); })">Rejeitar Imóvel</button>
        </form>
    </div>
</div>
<?php else: ?>
<div class="ul-painel-aviso ul-painel-aviso--cinza">
    <div class="ul-painel-aviso-texto">
        <p>Este imóvel já foi <?php echo e($imovel->estado); ?>.</p>
    </div>
</div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\JORGE DANGE\Documents\PROGRAMACAO\WEB\QND\PageWeb\imobiliaria\qnb-imobiliaria\resources\views\admin\imoveis\show.blade.php ENDPATH**/ ?>