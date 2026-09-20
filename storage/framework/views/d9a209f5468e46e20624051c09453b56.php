<?php $__env->startSection('title', 'Detalhe do Log — Admin'); ?>

<?php $__env->startSection('content'); ?>
<div class="ul-painel-cabecalho">
    <h1 class="ul-painel-titulo">Detalhe do Log #<?php echo e($log->id); ?></h1>
    <a href="<?php echo e(route('admin.logs')); ?>" class="ul-painel-btn ul-painel-btn--cinza">
        <i class="bi bi-arrow-left"></i> Voltar
    </a>
</div>

<div class="ul-painel-card" style="max-width:800px;">
    <table class="ul-painel-tabela" style="margin-bottom:0;">
        <tr>
            <td style="width:180px;"><strong>Data</strong></td>
            <td><?php echo e($log->created_at->format('d/m/Y H:i:s')); ?></td>
        </tr>
        <tr>
            <td><strong>Admin</strong></td>
            <td><?php echo e($log->admin->nome ?? 'Sistema'); ?> <?php echo e($log->admin ? '(' . $log->admin->email . ')' : ''); ?></td>
        </tr>
        <tr>
            <td><strong>Ação</strong></td>
            <td><span class="ul-badge ul-badge--cinza"><?php echo e($log->acao); ?></span></td>
        </tr>
        <tr>
            <td><strong>Modelo</strong></td>
            <td>
                <?php if($log->modelo): ?>
                    <?php echo e($log->modelo); ?>

                    <?php if($log->modelo_id): ?>
                        (ID: <?php echo e($log->modelo_id); ?>)
                    <?php endif; ?>
                <?php else: ?>
                    —
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td><strong>IP</strong></td>
            <td><?php echo e($log->ip_address ?? '—'); ?></td>
        </tr>
        <tr>
            <td><strong>User Agent</strong></td>
            <td><small><?php echo e($log->user_agent ?? '—'); ?></small></td>
        </tr>
        <?php if($log->detalhes): ?>
        <tr>
            <td><strong>Detalhes</strong></td>
            <td>
                <pre style="background:#f8f9fa;padding:12px;border-radius:6px;font-size:12px;overflow-x:auto;max-height:400px;"><?php echo e(json_encode($log->detalhes, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)); ?></pre>
            </td>
        </tr>
        <?php endif; ?>
    </table>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\JORGE DANGE\Documents\PROGRAMACAO\WEB\QND\PageWeb\imobiliaria\qnb-imobiliaria\resources\views\admin\logs\show.blade.php ENDPATH**/ ?>