<?php $__env->startSection('cliente-content'); ?>
<div class="mensagens-page">
    <div class="page-header">
        <h1><i class="bi bi-envelope me-2"></i>Minhas Mensagens</h1>
    </div>
    
    <?php if($mensagens->isEmpty()): ?>
    <div class="empty-state">
        <i class="bi bi-inbox bi-3x mb-3 opacity-50"></i>
        <h3>Sem mensagens</h3>
        <p>Não tem mensagens recebidas no momento.</p>
        <a href="<?php echo e(route('cliente.dashboard')); ?>" class="btn btn-primary" style="display: block; margin-top: 1rem;">Ir ao Dashboard</a>
    </div>
    <?php else: ?>
    <div class="mensagens-list">
        <?php $__currentLoopData = $mensagens; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mensagem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="mensagem-item">
            <div class="mensagem-header">
                <h3><?php echo e(substr($mensagem->nome, 0, 40)); ?></h3>
                <span class="mensagem-origem <?php echo e($mensagem->origem); ?>"><?php echo e(ucfirst($mensagem->origem)); ?></span>
            </div>
            <p class="mensagem-texto"><?php echo e(substr(strip_tags($mensagem->texto), 0, 150)); ?><?php echo e(strlen($mensagem->texto) > 150 ? '...' : ''); ?></p>
            <div class="mensagem-meta">
                <span><?php echo e($mensagem->created_at->diffForHumans()); ?></span>
                <?php if($mensagem->lida): ?>
                <span class="badge bg-success ms-2">Lida</span>
                <?php else: ?>
                <span class="badge bg-warning text-dark ms-2">Não lida</span>
                <?php endif; ?>
            </div>
            <a href="<?php echo e(route('cliente.mensagens.show', $mensagem->id)); ?>" class="btn-ver-mais">Ver mensagem completa</a>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('cliente.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\JORGE DANGE\Documents\PROGRAMACAO\WEB\QND\PageWeb\imobiliaria\qnb-imobiliaria\resources\views\cliente\mensagens.blade.php ENDPATH**/ ?>