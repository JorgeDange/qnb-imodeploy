<?php $__env->startSection('title', 'Notificações — Admin'); ?>

<?php $__env->startSection('content'); ?>
<div class="ul-painel-cabecalho">
    <h1 class="ul-painel-titulo">Notificações</h1>
    <form action="<?php echo e(route('admin.notificacoes.ler-todas')); ?>" method="POST" style="display:inline;">
        <?php echo csrf_field(); ?>
        <button type="submit" class="ul-painel-btn ul-painel-btn--cinza">
            <i class="bi bi-check-lg"></i> Marcar todas como lidas
        </button>
    </form>
</div>

<div class="ul-painel-tabela-wrap">
    <table class="ul-painel-tabela">
        <thead>
            <tr>
                <th style="width:40px;"></th>
                <th>Data</th>
                <th>Tipo</th>
                <th>Título</th>
                <th>Mensagem</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $notificacoes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $n): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr <?php echo e(!$n->lida ? 'class="ul-linha-nao-lida"' : ''); ?>>
                <td>
                    <?php if(!$n->lida): ?>
                        <span class="ul-ponto-sucesso"></span>
                    <?php endif; ?>
                </td>
                <td><?php echo e($n->created_at->format('d/m/Y H:i')); ?></td>
                <td><span class="ul-badge ul-badge--cinza"><?php echo e($n->tipo); ?></span></td>
                <td>
                    <?php if($n->url): ?>
                        <a href="<?php echo e(route('admin.notificacoes.ler', $n)); ?>"><?php echo e($n->titulo); ?></a>
                    <?php else: ?>
                        <?php echo e($n->titulo); ?>

                    <?php endif; ?>
                </td>
                <td><small><?php echo e(Str::limit($n->mensagem, 80)); ?></small></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="5" style="text-align:center;padding:40px;color:#888;">Nenhuma notificação.</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php echo e($notificacoes->links()); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\JORGE DANGE\Documents\PROGRAMACAO\WEB\QND\PageWeb\imobiliaria\qnb-imobiliaria\resources\views/admin/notificacoes/index.blade.php ENDPATH**/ ?>