<?php $__env->startSection('title', 'Mensagens — Admin'); ?>

<?php $__env->startSection('content'); ?>
<div class="ul-painel-cabecalho">
    <h1 class="ul-painel-titulo">Mensagens Diretas</h1>
    <a href="<?php echo e(route('admin.mensagens.nova')); ?>" class="ul-painel-btn ul-painel-btn--primario">
        <i class="bi bi-plus-lg"></i> Nova Mensagem
    </a>
</div>

<div class="ul-painel-tabela-wrap">
    <table class="ul-painel-tabela">
        <thead>
            <tr>
                <th>Imobiliária</th>
                <th>Assunto</th>
                <th>Enviada por</th>
                <th>Data</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $threads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td><strong><?php echo e($t->imobiliaria->nome ?? '—'); ?></strong></td>
                <td><?php echo e($t->assunto); ?></td>
                <td><?php echo e($t->admin->nome ?? '—'); ?></td>
                <td><?php echo e($t->created_at->format('d/m/Y H:i')); ?></td>
                <td>
                    <a href="<?php echo e(route('admin.mensagens.thread', $t)); ?>" class="ul-painel-btn ul-painel-btn--pequeno">
                        <i class="bi bi-info-circle"></i> Ver
                    </a>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="5" style="text-align:center;padding:40px;color:#888;">Nenhuma mensagem.</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php echo e($threads->links()); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\JORGE DANGE\Documents\PROGRAMACAO\WEB\QND\PageWeb\imobiliaria\qnb-imobiliaria\resources\views/admin/mensagens/index.blade.php ENDPATH**/ ?>