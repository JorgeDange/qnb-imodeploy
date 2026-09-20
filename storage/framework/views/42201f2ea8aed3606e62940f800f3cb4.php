<?php $__env->startSection('title', 'Logs de Atividade — Admin'); ?>

<?php $__env->startSection('content'); ?>
<div class="ul-painel-cabecalho">
    <h1 class="ul-painel-titulo">Logs de Atividade</h1>
</div>

<div class="ul-painel-card" style="margin-bottom:20px;">
    <form method="GET" style="display:flex;gap:12px;align-items:end;flex-wrap:wrap;">
        <div class="ul-painel-form-campo" style="margin-bottom:0;">
            <label class="ul-painel-form-label">Admin</label>
            <select name="admin_id" class="ul-painel-form-input">
                <option value="">Todos</option>
                <?php $__currentLoopData = $admins; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($a->id); ?>" <?php echo e(request('admin_id') == $a->id ? 'selected' : ''); ?>><?php echo e($a->nome); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="ul-painel-form-campo" style="margin-bottom:0;">
            <label class="ul-painel-form-label">Ação</label>
            <input type="text" name="acao" class="ul-painel-form-input" value="<?php echo e(request('acao')); ?>" placeholder="Ex: criar_plano">
        </div>
        <div class="ul-painel-form-campo" style="margin-bottom:0;">
            <label class="ul-painel-form-label">Data Início</label>
            <input type="date" name="data_inicio" class="ul-painel-form-input" value="<?php echo e(request('data_inicio')); ?>">
        </div>
        <div class="ul-painel-form-campo" style="margin-bottom:0;">
            <label class="ul-painel-form-label">Data Fim</label>
            <input type="date" name="data_fim" class="ul-painel-form-input" value="<?php echo e(request('data_fim')); ?>">
        </div>
        <button type="submit" class="ul-painel-btn ul-painel-btn--cinza">Filtrar</button>
    </form>
</div>

<div class="ul-painel-tabela-wrap">
    <table class="ul-painel-tabela">
        <thead>
            <tr>
                <th>Data</th>
                <th>Admin</th>
                <th>Ação</th>
                <th>Modelo</th>
                <th>IP</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td><?php echo e($log->created_at->format('d/m/Y H:i')); ?></td>
                <td><?php echo e($log->admin->nome ?? 'Sistema'); ?></td>
                <td><span class="ul-badge ul-badge--cinza"><?php echo e($log->acao); ?></span></td>
                <td>
                    <?php if($log->modelo): ?>
                        <?php echo e(class_basename($log->modelo)); ?>

                        <?php if($log->modelo_id): ?>
                            #<?php echo e($log->modelo_id); ?>

                        <?php endif; ?>
                    <?php else: ?>
                        —
                    <?php endif; ?>
                </td>
                <td><small><?php echo e($log->ip_address ?? '—'); ?></small></td>
                <td>
                    <a href="<?php echo e(route('admin.logs.show', $log)); ?>" class="ul-painel-btn ul-painel-btn--pequeno" title="Ver detalhe">
                        <i class="bi bi-info-circle"></i>
                    </a>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="6" style="text-align:center;padding:40px;color:#888;">Nenhum log encontrado.</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php echo e($logs->withQueryString()->links()); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\JORGE DANGE\Documents\PROGRAMACAO\WEB\QND\PageWeb\imobiliaria\qnb-imobiliaria\resources\views\admin\logs\index.blade.php ENDPATH**/ ?>