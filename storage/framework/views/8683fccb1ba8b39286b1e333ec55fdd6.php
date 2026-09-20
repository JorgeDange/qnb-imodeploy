<?php $__env->startSection('title', 'Avaliações — Admin'); ?>

<?php $__env->startSection('content'); ?>
<div class="ul-painel-cabecalho">
    <h1 class="ul-painel-titulo">Avaliações</h1>
</div>

<div class="ul-painel-stats" style="margin-bottom:20px;">
    <div class="ul-painel-stat">
        <span class="ul-painel-stat-numero"><?php echo e($estatisticas['pendente']); ?></span>
        <span class="ul-painel-stat-rotulo">Pendentes</span>
    </div>
    <div class="ul-painel-stat">
        <span class="ul-painel-stat-numero"><?php echo e($estatisticas['aprovada']); ?></span>
        <span class="ul-painel-stat-rotulo">Aprovadas</span>
    </div>
    <div class="ul-painel-stat">
        <span class="ul-painel-stat-numero"><?php echo e($estatisticas['rejeitada']); ?></span>
        <span class="ul-painel-stat-rotulo">Rejeitadas</span>
    </div>
</div>

<div class="ul-painel-tabela-wrap">
    <table class="ul-painel-tabela">
        <thead>
            <tr>
                <th>ID</th>
                <th>Imóvel</th>
                <th>Autor</th>
                <th>Estrelas</th>
                <th>Comentário</th>
                <th>Estado</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $avaliacoes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $avaliacao): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td><strong>#<?php echo e($avaliacao->id); ?></strong></td>
                <td><?php echo e($avaliacao->imovel->titulo ?? '—'); ?></td>
                <td><?php echo e($avaliacao->autor_nome); ?></td>
                <td>
                    <?php for($i = 1; $i <= 5; $i++): ?>
                        <i class="bi bi-star" style="font-size:12px;color:<?php echo e($i <= $avaliacao->estrelas ? '#FFA41B' : '#ccc'); ?>;opacity:<?php echo e($i <= $avaliacao->estrelas ? 1 : 0.3); ?>;"></i>
                    <?php endfor; ?>
                </td>
                <td style="max-width:200px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;"><?php echo e($avaliacao->comentario ?? '—'); ?></td>
                <td>
                    <?php if($avaliacao->estado === 'pendente'): ?>
                        <span class="ul-badge ul-badge--pendente">Pendente</span>
                    <?php elseif($avaliacao->estado === 'aprovada'): ?>
                        <span class="ul-badge ul-badge--aprovado">Aprovada</span>
                    <?php else: ?>
                        <span class="ul-badge ul-badge--rejeitado">Rejeitada</span>
                    <?php endif; ?>
                </td>
                <td>
                    <div style="display:flex;gap:6px;">
                        <?php if($avaliacao->estado === 'pendente'): ?>
                        <form action="<?php echo e(route('admin.avaliacoes.aprovar', $avaliacao)); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="ul-painel-btn ul-painel-btn--pequeno ul-painel-btn--sucesso-texto" title="Aprovar"><i class="bi bi-check-lg"></i></button>
                        </form>
                        <form id="aval-rejeitar-<?php echo e($avaliacao->id); ?>" action="<?php echo e(route('admin.avaliacoes.rejeitar', $avaliacao)); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <button type="button" class="ul-painel-btn ul-painel-btn--pequeno ul-painel-btn--aviso-texto" title="Rejeitar" onclick="modalPerigo('Rejeitar Avaliação', 'Rejeitar esta avaliação?', function(){ document.getElementById('aval-rejeitar-<?php echo e($avaliacao->id); ?>').submit(); })"><i class="bi bi-x-lg"></i></button>
                        </form>
                        <?php endif; ?>
                        <form id="aval-del-<?php echo e($avaliacao->id); ?>" action="<?php echo e(route('admin.avaliacoes.apagar', $avaliacao)); ?>" method="POST">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button type="button" class="ul-painel-btn ul-painel-btn--perigo ul-painel-btn--pequeno" title="Apagar" onclick="modalPerigo('Apagar Avaliação', 'Apagar esta avaliação?', function(){ document.getElementById('aval-del-<?php echo e($avaliacao->id); ?>').submit(); })"><i class="bi bi-x-lg"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="7" style="text-align:center;padding:40px;color:#888;">Nenhuma avaliação encontrada.</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php echo e($avaliacoes->withQueryString()->links()); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\JORGE DANGE\Documents\PROGRAMACAO\WEB\QND\PageWeb\imobiliaria\qnb-imobiliaria\resources\views/admin/avaliacoes/index.blade.php ENDPATH**/ ?>