<?php $__env->startSection('title', 'Visitas — Admin'); ?>

<?php $__env->startSection('content'); ?>
<div class="ul-painel-cabecalho">
    <h1 class="ul-painel-titulo">Visitas</h1>
</div>

<div class="ul-painel-stats" style="margin-bottom:20px;">
    <div class="ul-painel-stat">
        <span class="ul-painel-stat-numero"><?php echo e($estatisticas['hoje']); ?></span>
        <span class="ul-painel-stat-rotulo">Hoje</span>
    </div>
    <div class="ul-painel-stat">
        <span class="ul-painel-stat-numero"><?php echo e($estatisticas['semana']); ?></span>
        <span class="ul-painel-stat-rotulo">Esta semana</span>
    </div>
    <div class="ul-painel-stat">
        <span class="ul-painel-stat-numero"><?php echo e($estatisticas['pendente']); ?></span>
        <span class="ul-painel-stat-rotulo">Pendentes</span>
    </div>
</div>

<div class="ul-painel-tabela-wrap">
    <table class="ul-painel-tabela">
        <thead>
            <tr>
                <th>ID</th>
                <th>Imóvel</th>
                <th>Cliente</th>
                <th>Data/Hora</th>
                <th>Estado</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $visitas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $visita): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td><strong>#<?php echo e($visita->id); ?></strong></td>
                <td><?php echo e($visita->imovel->titulo ?? '—'); ?></td>
                <td><?php echo e($visita->cliente_nome); ?></td>
                <td><?php echo e($visita->data_visita->format('d/m/Y H:i')); ?></td>
                <td>
                    <?php if($visita->estado === 'pendente'): ?>
                        <span class="ul-badge ul-badge--pendente">Pendente</span>
                    <?php elseif($visita->estado === 'confirmada'): ?>
                        <span class="ul-badge ul-badge--destaque">Confirmada</span>
                    <?php elseif($visita->estado === 'concluida'): ?>
                        <span class="ul-badge ul-badge--aprovado">Concluída</span>
                    <?php else: ?>
                        <span class="ul-badge ul-badge--rejeitado">Cancelada</span>
                    <?php endif; ?>
                </td>
                <td>
                    <div style="display:flex;gap:6px;">
                        <?php if($visita->estado === 'pendente'): ?>
                        <form action="<?php echo e(route('admin.visitas.estado', $visita)); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="estado" value="confirmada">
                            <button type="submit" class="ul-painel-btn ul-painel-btn--pequeno ul-painel-btn--sucesso-texto" title="Confirmar"><i class="bi bi-check-lg"></i></button>
                        </form>
                        <?php endif; ?>
                        <?php if($visita->estado === 'confirmada'): ?>
                        <form action="<?php echo e(route('admin.visitas.estado', $visita)); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="estado" value="concluida">
                            <button type="submit" class="ul-painel-btn ul-painel-btn--pequeno ul-painel-btn--sucesso-texto" title="Concluir"><i class="bi bi-check-lg"></i></button>
                        </form>
                        <?php endif; ?>
                        <?php if($visita->estado !== 'cancelada' && $visita->estado !== 'concluida'): ?>
                        <form id="visita-cancel-<?php echo e($visita->id); ?>" action="<?php echo e(route('admin.visitas.estado', $visita)); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="estado" value="cancelada">
                            <button type="button" class="ul-painel-btn ul-painel-btn--perigo ul-painel-btn--pequeno" title="Cancelar" onclick="modalPerigo('Cancelar Visita', 'Cancelar esta visita?', function(){ document.getElementById('visita-cancel-<?php echo e($visita->id); ?>').submit(); })"><i class="bi bi-x-lg"></i></button>
                        </form>
                        <?php endif; ?>
                    </div>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="6" style="text-align:center;padding:40px;color:#888;">Nenhuma visita encontrada.</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php echo e($visitas->withQueryString()->links()); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\JORGE DANGE\Documents\PROGRAMACAO\WEB\QND\PageWeb\imobiliaria\qnb-imobiliaria\resources\views/admin/visitas/index.blade.php ENDPATH**/ ?>