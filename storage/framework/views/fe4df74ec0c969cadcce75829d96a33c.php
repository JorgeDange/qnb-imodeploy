<?php $__env->startSection('cliente-content'); ?>
<div class="notificacoes-page">
    <div class="page-header">
        <h1><i class="bi bi-bell me-2"></i>Notificações</h1>
        <?php if($naoLidas > 0): ?>
        <form action="<?php echo e(route('cliente.notificacoes.ler-todas')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <button type="submit" class="btn btn-sm btn-outline-primary">
                <i class="bi bi-check2-all me-1"></i>Marcar todas como lidas
            </button>
        </form>
        <?php endif; ?>
    </div>

    <?php if($notificacoes->isEmpty()): ?>
    <div class="empty-state">
        <i class="bi bi-bell-slash bi-3x mb-3 opacity-50"></i>
        <h3>Sem notificações</h3>
        <p>Não recebeu nenhuma notificação ainda.</p>
    </div>
    <?php else: ?>
    <div class="notificacoes-lista">
        <?php $__currentLoopData = $notificacoes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notificacao): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="notificacao-item <?php echo e($notificacao->lida ? 'lida' : 'nao-lida'); ?>">
            <div class="notificacao-icon">
                <?php if($notificacao->tipo === 'visita'): ?>
                <i class="bi bi-calendar-check"></i>
                <?php elseif($notificacao->tipo === 'mensagem'): ?>
                <i class="bi bi-envelope"></i>
                <?php elseif($notificacao->tipo === 'avaliacao'): ?>
                <i class="bi bi-star"></i>
                <?php elseif($notificacao->tipo === 'denuncia'): ?>
                <i class="bi bi-flag"></i>
                <?php else: ?>
                <i class="bi bi-info-circle"></i>
                <?php endif; ?>
            </div>
            <div class="notificacao-corpo">
                <div class="notificacao-titulo">
                    <?php echo e($notificacao->titulo); ?>

                    <?php if(!$notificacao->lida): ?>
                    <span class="badge bg-primary ms-1">Nova</span>
                    <?php endif; ?>
                </div>
                <div class="notificacao-mensagem"><?php echo e($notificacao->mensagem); ?></div>
                <div class="notificacao-data"><?php echo e($notificacao->created_at->format('d/m/Y H:i')); ?></div>
            </div>
            <div class="notificacao-acoes">
                <?php if($notificacao->url): ?>
                <a href="<?php echo e($notificacao->url); ?>" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-arrow-right"></i>
                </a>
                <?php endif; ?>
                <?php if(!$notificacao->lida): ?>
                <form action="<?php echo e(route('cliente.notificacoes.ler', $notificacao->id)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="btn btn-sm btn-outline-primary" title="Marcar como lida">
                        <i class="bi bi-check-lg"></i>
                    </button>
                </form>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('cliente.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\JORGE DANGE\Documents\PROGRAMACAO\WEB\QND\PageWeb\imobiliaria\qnb-imobiliaria\resources\views/cliente/notificacoes.blade.php ENDPATH**/ ?>