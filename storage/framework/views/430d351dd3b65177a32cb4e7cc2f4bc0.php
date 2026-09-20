<?php $__env->startSection('title', 'Parceiros - Admin'); ?>
<?php $__env->startSection('pageTitle', 'Parceiros'); ?>

<?php $__env->startSection('content'); ?>
<!-- form novo parceiro -->
<div class="ul-painel-card">
    <h3 class="ul-painel-card-titulo">Novo Parceiro</h3>

    <form action="<?php echo e(route('admin.parceiros.salvar')); ?>" method="POST" enctype="multipart/form-data" class="ul-painel-form">
        <?php echo csrf_field(); ?>
        <div class="row g-3 align-items-end">
            <div class="col-md-3">
                <div class="form-group">
                    <label>Nome</label>
                    <input type="text" name="nome" value="<?php echo e(old('nome')); ?>" required>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>URL</label>
                    <input type="url" name="url" value="<?php echo e(old('url')); ?>" placeholder="https://...">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Logótipo</label>
                    <input type="file" name="logo" accept="image/*">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>Ativo</label>
                    <select name="ativo">
                        <option value="1" <?php echo e(old('ativo', 1) == 1 ? 'selected' : ''); ?>>Sim</option>
                        <option value="0" <?php echo e(old('ativo') == 0 ? 'selected' : ''); ?>>Não</option>
                    </select>
                </div>
            </div>
            <div class="col-md-1">
                <button type="submit" class="ul-btn ul-btn--primary w-100">Adicionar</button>
            </div>
        </div>
    </form>
</div>

<!-- lista -->
<div class="ul-painel-card">
    <h3 class="ul-painel-card-titulo">Lista de Parceiros</h3>

    <?php if($parceiros->count()): ?>
    <?php $__currentLoopData = $parceiros; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $parceiro): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="ul-painel-imovel">
        <?php if($parceiro->logo): ?>
        <div class="ul-painel-imovel-foto">
            <img src="<?php echo e(asset('storage/' . $parceiro->logo)); ?>" alt="<?php echo e($parceiro->nome); ?>">
        </div>
        <?php endif; ?>
        <div class="ul-painel-imovel-info">
            <div class="ul-painel-imovel-titulo"><?php echo e($parceiro->nome); ?></div>
            <?php if($parceiro->url): ?>
            <span class="ul-painel-imovel-local">
                <a href="<?php echo e($parceiro->url); ?>" target="_blank" rel="noopener" style="color:var(--ul-primary);"><?php echo e(Str::limit($parceiro->url, 50)); ?></a>
            </span>
            <?php endif; ?>
        </div>
        <div class="ul-painel-imovel-acoes">
            <span class="ul-badge ul-badge--<?php echo e($parceiro->ativo ? 'aprovado' : 'rejeitado'); ?>">
                <?php echo e($parceiro->ativo ? 'Ativo' : 'Inativo'); ?>

            </span>
            <form id="parc-del-<?php echo e($parceiro->id); ?>" action="<?php echo e(route('admin.parceiros.apagar', $parceiro->id)); ?>" method="POST" class="d-inline">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <button type="button" class="ul-btn ul-btn--sm ul-btn--outline" onclick="modalPerigo('Eliminar Parceiro', 'Eliminar este parceiro?', function(){ document.getElementById('parc-del-<?php echo e($parceiro->id); ?>').submit(); })">Eliminar</button>
            </form>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php else: ?>
    <div class="ul-painel-vazio">
        <p>Nenhum parceiro registado.</p>
    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\JORGE DANGE\Documents\PROGRAMACAO\WEB\QND\PageWeb\imobiliaria\qnb-imobiliaria\resources\views/admin/conteudo/parceiros.blade.php ENDPATH**/ ?>