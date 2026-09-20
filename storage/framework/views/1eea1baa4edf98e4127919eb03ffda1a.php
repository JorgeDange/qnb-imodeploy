<?php $__env->startSection('title', 'Denúncias — Admin'); ?>

<?php $__env->startSection('content'); ?>
<div class="ul-painel-cabecalho">
    <h1 class="ul-painel-titulo">Denúncias</h1>
</div>

<div class="ul-painel-stats" style="margin-bottom:20px;">
    <div class="ul-painel-stat">
        <span class="ul-painel-stat-numero"><?php echo e($estatisticas['pendente']); ?></span>
        <span class="ul-painel-stat-rotulo">Pendentes</span>
    </div>
    <div class="ul-painel-stat">
        <span class="ul-painel-stat-numero"><?php echo e($estatisticas['em_analise']); ?></span>
        <span class="ul-painel-stat-rotulo">Em análise</span>
    </div>
    <div class="ul-painel-stat">
        <span class="ul-painel-stat-numero"><?php echo e($estatisticas['resolvida']); ?></span>
        <span class="ul-painel-stat-rotulo">Resolvidas</span>
    </div>
</div>

<div class="ul-painel-tabela-wrap">
    <table class="ul-painel-tabela">
        <thead>
            <tr>
                <th>ID</th>
                <th>Imóvel</th>
                <th>Autor</th>
                <th>Motivo</th>
                <th>Estado</th>
                <th>Data</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $denuncias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $denuncia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td><strong>#<?php echo e($denuncia->id); ?></strong></td>
                <td><?php echo e($denuncia->imovel->titulo ?? '—'); ?></td>
                <td><?php echo e($denuncia->autor_nome); ?></td>
                <td><span class="ul-badge ul-badge--aviso"><?php echo e(str_replace('_', ' ', $denuncia->motivo)); ?></span></td>
                <td>
                    <?php if($denuncia->estado === 'pendente'): ?>
                        <span class="ul-badge ul-badge--pendente">Pendente</span>
                    <?php elseif($denuncia->estado === 'em_analise'): ?>
                        <span class="ul-badge ul-badge--destaque">Em análise</span>
                    <?php elseif($denuncia->estado === 'resolvida'): ?>
                        <span class="ul-badge ul-badge--aprovado">Resolvida</span>
                    <?php else: ?>
                        <span class="ul-badge ul-badge--cinza">Arquivada</span>
                    <?php endif; ?>
                </td>
                <td><?php echo e($denuncia->created_at->format('d/m/Y H:i')); ?></td>
                <td>
                    <a href="<?php echo e(route('admin.denuncias.show', $denuncia)); ?>" class="ul-painel-btn ul-painel-btn--pequeno" title="Ver detalhes">
                        <i class="bi bi-info-circle"></i>
                    </a>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="7" style="text-align:center;padding:40px;color:#888;">Nenhuma denúncia encontrada.</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php echo e($denuncias->withQueryString()->links()); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\JORGE DANGE\Documents\PROGRAMACAO\WEB\QND\PageWeb\imobiliaria\qnb-imobiliaria\resources\views/admin/denuncias/index.blade.php ENDPATH**/ ?>