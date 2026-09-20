<?php $__env->startSection('title', 'Imobiliárias - Admin'); ?>
<?php $__env->startSection('pageTitle', 'Imobiliárias'); ?>

<?php $__env->startSection('content'); ?>
<!-- filters -->
<div class="ul-painel-card">
    <form method="GET" action="<?php echo e(route('admin.imobiliarias')); ?>" class="ul-painel-form row g-3 align-items-end">
        <div class="col-md-6">
            <div class="form-group">
                <label>Pesquisar</label>
                <input type="text" name="search" placeholder="Nome, email ou telefone..." value="<?php echo e(request('search')); ?>">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>Estado</label>
                <select name="estado">
                    <option value="">Todos</option>
                    <option value="pendente" <?php echo e(request('estado') === 'pendente' ? 'selected' : ''); ?>>Pendente</option>
                    <option value="aprovada" <?php echo e(request('estado') === 'aprovada' ? 'selected' : ''); ?>>Aprovada</option>
                    <option value="suspensa" <?php echo e(request('estado') === 'suspensa' ? 'selected' : ''); ?>>Suspensa</option>
                </select>
            </div>
        </div>
        <div class="col-md-2">
            <button type="submit" class="ul-btn ul-btn--sm w-100" style="background:var(--ul-primary);color:var(--white);">Filtrar</button>
        </div>
    </form>
</div>

<!-- header -->
<div class="ul-painel-head">
    <div>
        <h2 class="ul-painel-card-titulo">Lista de Imobiliárias</h2>
        <p class="ul-painel-card-subtitulo"><?php echo e($imobiliarias->total()); ?> registo(s)</p>
    </div>
</div>

<!-- list -->
<?php if($imobiliarias->count()): ?>
    <?php $__currentLoopData = $imobiliarias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $imobiliaria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="ul-painel-imovel">
        <div class="ul-painel-imovel-info">
            <span class="ul-painel-imovel-titulo"><?php echo e($imobiliaria->nome); ?></span>
            <span class="ul-painel-imovel-ref">ID #<?php echo e($imobiliaria->id); ?></span>
            <div style="margin-top:6px;font-size:13px;color:var(--ul-gray2);">
                <span style="margin-right:14px;"><i class="bi bi-envelope" style="color:var(--ul-primary);margin-right:4px;"></i><?php echo e($imobiliaria->email); ?></span>
                <span><i class="bi bi-telephone" style="color:var(--ul-primary);margin-right:4px;"></i><?php echo e($imobiliaria->telefone); ?></span>
            </div>
            <div style="margin-top:4px;font-size:12px;color:var(--ul-gray2);">
                Registo: <?php echo e($imobiliaria->created_at->format('d/m/Y')); ?>

            </div>
        </div>
        <div class="ul-painel-imovel-acoes">
            <span class="ul-badge ul-badge--<?php echo e($imobiliaria->estado === 'aprovada' ? 'aprovado' : ($imobiliaria->estado === 'pendente' ? 'pendente' : 'rejeitado')); ?>">
                <?php echo e(ucfirst($imobiliaria->estado)); ?>

            </span>
            <a href="<?php echo e(route('admin.imobiliarias.show', $imobiliaria->id)); ?>" class="ul-btn ul-btn--sm" style="background:var(--ul-primary);color:var(--white);">Ver</a>
            <?php if($imobiliaria->estado === 'pendente'): ?>
            <form id="imob-aprovar-<?php echo e($imobiliaria->id); ?>" action="<?php echo e(route('admin.imobiliarias.aprovar', $imobiliaria->id)); ?>" method="POST" class="d-inline">
                <?php echo csrf_field(); ?>
                <button type="button" class="ul-btn ul-btn--sm" style="background:var(--ul-primary);color:var(--white);" onclick="modalConfirmar('Aprovar Imobiliária', 'Aprovar esta imobiliária?', function(){ document.getElementById('imob-aprovar-<?php echo e($imobiliaria->id); ?>').submit(); })">Aprovar</button>
            </form>
            <?php endif; ?>
            <?php if($imobiliaria->estado === 'aprovada'): ?>
            <form id="imob-suspender-<?php echo e($imobiliaria->id); ?>" action="<?php echo e(route('admin.imobiliarias.suspender', $imobiliaria->id)); ?>" method="POST" class="d-inline">
                <?php echo csrf_field(); ?>
                <button type="button" class="ul-btn ul-btn--sm ul-btn--aviso" onclick="modalPerigo('Suspender Imobiliária', 'Suspender esta imobiliária?', function(){ document.getElementById('imob-suspender-<?php echo e($imobiliaria->id); ?>').submit(); })">Suspender</button>
            </form>
            <?php endif; ?>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <div class="mt-3">
        <?php echo e($imobiliarias->withQueryString()->links()); ?>

    </div>
<?php else: ?>
    <div class="ul-painel-vazio">
        <p>Nenhuma imobiliária encontrada.</p>
    </div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\JORGE DANGE\Documents\PROGRAMACAO\WEB\QND\PageWeb\imobiliaria\qnb-imobiliaria\resources\views\admin\imobiliarias\index.blade.php ENDPATH**/ ?>