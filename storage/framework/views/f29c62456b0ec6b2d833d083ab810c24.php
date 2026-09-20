<?php $__env->startSection('title', 'Pagamentos — Admin'); ?>

<?php $__env->startSection('content'); ?>
<div class="ul-painel-cabecalho">
    <h1 class="ul-painel-titulo">Pagamentos</h1>
</div>

<div class="ul-painel-card" style="margin-bottom:20px;">
    <form method="GET" style="display:flex;gap:12px;align-items:end;">
        <div class="ul-painel-form-campo" style="margin-bottom:0;">
            <label class="ul-painel-form-label">Estado</label>
            <select name="estado" class="ul-painel-form-input">
                <option value="">Todos</option>
                <option value="pendente" <?php echo e(request('estado') === 'pendente' ? 'selected' : ''); ?>>Pendente</option>
                <option value="confirmado" <?php echo e(request('estado') === 'confirmado' ? 'selected' : ''); ?>>Confirmado</option>
                <option value="rejeitado" <?php echo e(request('estado') === 'rejeitado' ? 'selected' : ''); ?>>Rejeitado</option>
            </select>
        </div>
        <button type="submit" class="ul-painel-btn ul-painel-btn--cinza">Filtrar</button>
    </form>
</div>

<div class="ul-painel-tabela-wrap">
    <table class="ul-painel-tabela">
        <thead>
            <tr>
                <th>Imobiliária</th>
                <th>Plano</th>
                <th>Valor</th>
                <th>Método</th>
                <th>Estado</th>
                <th>Data</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $pagamentos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td><?php echo e($pag->imobiliaria->nome ?? '—'); ?></td>
                <td><?php echo e($pag->subscricao->plano->nome ?? '—'); ?></td>
                <td><strong><?php echo e(number_format($pag->valor, 2, ',', '.')); ?></strong> <?php echo e($pag->moeda); ?></td>
                <td><?php echo e(ucfirst(str_replace('_', ' ', $pag->metodo))); ?></td>
                <td>
                    <?php
                        $badge = match($pag->estado) {
                            'confirmado' => 'ul-badge--sucesso',
                            'pendente' => 'ul-badge--aviso',
                            'rejeitado' => 'ul-badge--perigo',
                            default => 'ul-badge--cinza',
                        };
                    ?>
                    <span class="ul-badge <?php echo e($badge); ?>"><?php echo e(ucfirst($pag->estado)); ?></span>
                </td>
                <td><?php echo e($pag->created_at->format('d/m/Y H:i')); ?></td>
                <td>
                    <?php if($pag->estado === 'pendente'): ?>
                    <div style="display:inline-flex;gap:6px;">
                        <a href="<?php echo e(route('admin.pagamentos.show', $pag)); ?>" class="ul-painel-btn ul-painel-btn--pequeno">Ver</a>
                    </div>
                    <?php else: ?>
                    <a href="<?php echo e(route('admin.pagamentos.show', $pag)); ?>" class="ul-painel-btn ul-painel-btn--pequeno">Ver</a>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="7" style="text-align:center;padding:40px;color:#888;">Nenhum pagamento encontrado.</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php echo e($pagamentos->links()); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\JORGE DANGE\Documents\PROGRAMACAO\WEB\QND\PageWeb\imobiliaria\qnb-imobiliaria\resources\views\admin\pagamentos\index.blade.php ENDPATH**/ ?>