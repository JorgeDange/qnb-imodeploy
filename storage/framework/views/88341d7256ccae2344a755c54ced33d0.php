<?php $__env->startSection('title', 'Depoimentos - Admin'); ?>
<?php $__env->startSection('pageTitle', 'Depoimentos'); ?>

<?php $__env->startSection('content'); ?>
<!-- form novo depoimento -->
<div class="ul-painel-card">
    <h3 class="ul-painel-card-titulo">Novo Depoimento</h3>

    <form action="<?php echo e(route('admin.depoimentos.salvar')); ?>" method="POST" class="ul-painel-form">
        <?php echo csrf_field(); ?>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label>Nome</label>
                    <input type="text" name="nome" value="<?php echo e(old('nome')); ?>" required>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Cargo</label>
                    <input type="text" name="cargo" value="<?php echo e(old('cargo')); ?>">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Estrelas (1-5)</label>
                    <select name="estrelas">
                        <?php for($i = 5; $i >= 1; $i--): ?>
                        <option value="<?php echo e($i); ?>" <?php echo e(old('estrelas', 5) == $i ? 'selected' : ''); ?>><?php echo e($i); ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Ativo</label>
                    <select name="ativo">
                        <option value="1" <?php echo e(old('ativo', 1) == 1 ? 'selected' : ''); ?>>Sim</option>
                        <option value="0" <?php echo e(old('ativo') == 0 ? 'selected' : ''); ?>>Não</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-10">
                <div class="form-group">
                    <label>Texto</label>
                    <textarea name="texto" rows="3" required><?php echo e(old('texto')); ?></textarea>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>&nbsp;</label>
                    <button type="submit" class="ul-btn ul-btn--primary w-100">Adicionar</button>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- lista -->
<div class="ul-painel-card">
    <h3 class="ul-painel-card-titulo">Lista de Depoimentos</h3>

    <?php if($depoimentos->count()): ?>
    <?php $__currentLoopData = $depoimentos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $depoimento): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="ul-painel-imovel" style="flex-wrap:wrap;">
        <div class="ul-painel-imovel-info" style="min-width:0;">
            <div class="ul-painel-imovel-titulo"><?php echo e($depoimento->nome); ?></div>
            <span class="ul-painel-imovel-local"><?php echo e($depoimento->cargo ?? '—'); ?></span>
            <p class="ul-painel-mensagem-texto"><?php echo e(Str::limit($depoimento->texto, 120)); ?></p>
            <div style="margin-top:6px;">
                <?php for($i = 1; $i <= 5; $i++): ?>
                    <?php if($i <= $depoimento->estrelas): ?>
                        &#9733;
                    <?php else: ?>
                        &#9734;
                    <?php endif; ?>
                <?php endfor; ?>
            </div>
        </div>
        <div class="ul-painel-imovel-acoes">
            <span class="ul-badge ul-badge--<?php echo e($depoimento->ativo ? 'aprovado' : 'rejeitado'); ?>">
                <?php echo e($depoimento->ativo ? 'Ativo' : 'Inativo'); ?>

            </span>
            <form id="depo-del-<?php echo e($depoimento->id); ?>" action="<?php echo e(route('admin.depoimentos.apagar', $depoimento->id)); ?>" method="POST" class="d-inline">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <button type="button" class="ul-btn ul-btn--sm ul-btn--outline" onclick="modalPerigo('Eliminar Depoimento', 'Eliminar este depoimento?', function(){ document.getElementById('depo-del-<?php echo e($depoimento->id); ?>').submit(); })">Eliminar</button>
            </form>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php else: ?>
    <div class="ul-painel-vazio">
        <p>Nenhum depoimento registado.</p>
    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\JORGE DANGE\Documents\PROGRAMACAO\WEB\QND\PageWeb\imobiliaria\qnb-imobiliaria\resources\views/admin/conteudo/depoimentos.blade.php ENDPATH**/ ?>