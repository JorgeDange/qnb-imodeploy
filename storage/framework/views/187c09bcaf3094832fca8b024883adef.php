<?php $__env->startSection('cliente-content'); ?>
<div class="page-header">
    <h1><i class="bi bi-search me-2"></i>Minhas Pesquisas</h1>
</div>

<?php if($pesquisas->isEmpty()): ?>
<div class="empty-state">
    <i class="bi bi-search bi-3x mb-3 opacity-50"></i>
    <h3>Nenhuma pesquisa guardada</h3>
    <p>As suas pesquisas de imóveis aparecerão aqui.</p>
    <a href="<?php echo e(route('imoveis.index')); ?>" class="ul-btn">Pesquisar Imóveis</a>
</div>
<?php else: ?>
<div class="mensagens-list">
    <?php $__currentLoopData = $pesquisas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pesquisa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="mensagem-item">
        <div class="mensagem-header">
            <h3><i class="bi bi-search" style="color:var(--ul-primary);margin-right:8px;"></i><?php echo e($pesquisa->termo); ?></h3>
        </div>
        <div class="mensagem-meta">
            <span><?php echo e($pesquisa->created_at->diffForHumans()); ?></span>
        </div>
        <div class="favorito-actions">
            <form id="pesq-form-<?php echo e($pesquisa->id); ?>" method="POST" action="<?php echo e(route('cliente.pesquisas.destroy', $pesquisa->id)); ?>">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <button type="button" class="btn-remover-favorito" onclick="modalPerigo('Remover Pesquisa', 'Remover esta pesquisa guardada?', function(){ document.getElementById('pesq-form-<?php echo e($pesquisa->id); ?>').submit(); })"><i class="bi bi-x-lg"></i></button>
            </form>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('cliente.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\JORGE DANGE\Documents\PROGRAMACAO\WEB\QND\PageWeb\imobiliaria\qnb-imobiliaria\resources\views\cliente\pesquisas.blade.php ENDPATH**/ ?>