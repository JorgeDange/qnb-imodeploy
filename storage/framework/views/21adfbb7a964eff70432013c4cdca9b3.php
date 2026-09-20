<?php $__env->startSection('title', 'Imóveis - Admin'); ?>
<?php $__env->startSection('pageTitle', 'Imóveis'); ?>

<?php $__env->startSection('content'); ?>
<div class="ul-painel-head">
    <div>
        <h2 class="ul-painel-card-titulo">Imóveis</h2>
        <p class="ul-painel-card-subtitulo"><?php echo e($imoveis->total()); ?> registo(s)</p>
    </div>
</div>

<!-- filters -->
<div class="ul-painel-card">
    <form method="GET" action="<?php echo e(route('admin.imoveis')); ?>" class="ul-painel-form row g-3 align-items-end">
        <div class="col-md-3">
            <div class="form-group">
                <label>Pesquisar</label>
                <input type="text" name="search" placeholder="Ref, título..." value="<?php echo e(request('search')); ?>">
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label>Estado</label>
                <select name="estado">
                    <option value="">Todos</option>
                    <option value="pendente" <?php echo e(request('estado') === 'pendente' ? 'selected' : ''); ?>>Pendente</option>
                    <option value="aprovado" <?php echo e(request('estado') === 'aprovado' ? 'selected' : ''); ?>>Aprovado</option>
                    <option value="rejeitado" <?php echo e(request('estado') === 'rejeitado' ? 'selected' : ''); ?>>Rejeitado</option>
                </select>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label>Tipo</label>
                <select name="tipo">
                    <option value="">Todos</option>
                    <?php $__currentLoopData = $tipos ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($tipo); ?>" <?php echo e(request('tipo') === $tipo ? 'selected' : ''); ?>><?php echo e($tipo); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>Província</label>
                <select name="provincia">
                    <option value="">Todas</option>
                    <?php $__currentLoopData = $provincias ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prov): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($prov); ?>" <?php echo e(request('provincia') === $prov ? 'selected' : ''); ?>><?php echo e($prov); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
        </div>
        <div class="col-md-2">
            <button type="submit" class="ul-btn ul-btn--sm w-100" style="background: var(--ul-primary); color: #fff;">Filtrar</button>
        </div>
    </form>
</div>

<!-- listing -->
<div class="ul-painel-card">
    <?php if($imoveis->count()): ?>
        <?php $__currentLoopData = $imoveis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $imovel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="ul-painel-imovel">
            <?php if($imovel->fotos->count()): ?>
            <div class="ul-painel-imovel-foto">
                <img src="<?php echo e(asset('storage/' . $imovel->fotos->first()->caminho)); ?>" alt="<?php echo e($imovel->titulo); ?>">
            </div>
            <?php endif; ?>
            <div class="ul-painel-imovel-info">
                <div>
                    <span class="ul-painel-imovel-ref">Ref: <?php echo e($imovel->referencia); ?></span>
                    <span class="ul-badge ul-badge--<?php echo e($imovel->estado); ?>"><?php echo e(ucfirst($imovel->estado)); ?></span>
                </div>
                <h4 class="ul-painel-imovel-titulo"><?php echo e($imovel->titulo); ?></h4>
                <span class="ul-painel-imovel-local"><?php echo e($imovel->tipo); ?> &middot; <?php echo e($imovel->municipio); ?>, <?php echo e($imovel->provincia); ?></span>
                <span class="ul-painel-imovel-preco"><?php echo e(number_format($imovel->preco, 0, ',', '.')); ?> <?php echo e($imovel->moeda); ?></span>
                <span style="font-size:12.5px;color:var(--ul-gray2);">&middot; <?php echo e($imovel->imobiliaria->nome ?? '—'); ?></span>
            </div>
            <div class="ul-painel-imovel-acoes">
                <a href="<?php echo e(route('admin.imoveis.show', $imovel->id)); ?>" class="ul-btn ul-btn--sm" style="background:var(--ul-primary);color:#fff;">Ver</a>
                <?php if($imovel->estado === 'pendente'): ?>
                <form id="imov-aprovar-<?php echo e($imovel->id); ?>" action="<?php echo e(route('admin.imoveis.aprovar', $imovel->id)); ?>" method="POST" class="d-inline">
                    <?php echo csrf_field(); ?>
                    <button type="button" class="ul-btn ul-btn--sm ul-btn--sucesso" onclick="modalConfirmar('Aprovar Imóvel', 'Aprovar este imóvel?', function(){ document.getElementById('imov-aprovar-<?php echo e($imovel->id); ?>').submit(); })">Aprovar</button>
                </form>
                <form id="imov-rejeitar-<?php echo e($imovel->id); ?>" action="<?php echo e(route('admin.imoveis.rejeitar', $imovel->id)); ?>" method="POST" class="d-inline">
                    <?php echo csrf_field(); ?>
                    <button type="button" class="ul-btn ul-btn--sm ul-btn--perigo" onclick="modalPerigo('Rejeitar Imóvel', 'Rejeitar este imóvel?', function(){ document.getElementById('imov-rejeitar-<?php echo e($imovel->id); ?>').submit(); })">Rejeitar</button>
                </form>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        <div class="mt-3">
            <?php echo e($imoveis->withQueryString()->links()); ?>

        </div>
    <?php else: ?>
        <div class="ul-painel-vazio">
            <p>Nenhum imóvel encontrado.</p>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\JORGE DANGE\Documents\PROGRAMACAO\WEB\QND\PageWeb\imobiliaria\qnb-imobiliaria\resources\views/admin/imoveis/index.blade.php ENDPATH**/ ?>