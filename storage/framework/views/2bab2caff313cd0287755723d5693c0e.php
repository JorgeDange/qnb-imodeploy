<?php $__env->startSection('title', 'Faturas — Admin'); ?>

<?php $__env->startSection('content'); ?>
<div class="ul-painel-cabecalho">
    <h1 class="ul-painel-titulo">Faturas</h1>
</div>

<div class="ul-painel-tabela-wrap">
    <table class="ul-painel-tabela">
        <thead>
            <tr>
                <th>Número</th>
                <th>Imobiliária</th>
                <th>Valor</th>
                <th>IVA</th>
                <th>Total</th>
                <th>Data</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $faturas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td><strong><?php echo e($f->numero); ?></strong></td>
                <td><?php echo e($f->imobiliaria->nome ?? '—'); ?></td>
                <td><?php echo e(number_format($f->valor, 2, ',', '.')); ?> <?php echo e($f->moeda); ?></td>
                <td><?php echo e(number_format($f->iva, 2, ',', '.')); ?></td>
                <td><strong><?php echo e(number_format($f->total, 2, ',', '.')); ?></strong> <?php echo e($f->moeda); ?></td>
                <td><?php echo e($f->emitida_em->format('d/m/Y H:i')); ?></td>
                <td><a href="<?php echo e(route('admin.faturas.download', $f)); ?>" class="ul-painel-btn ul-painel-btn--pequeno">PDF</a></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="7" style="text-align:center;padding:40px;color:#888;">Nenhuma fatura encontrada.</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php echo e($faturas->links()); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\JORGE DANGE\Documents\PROGRAMACAO\WEB\QND\PageWeb\imobiliaria\qnb-imobiliaria\resources\views\admin\faturas\index.blade.php ENDPATH**/ ?>