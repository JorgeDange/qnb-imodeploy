<?php $__env->startSection('title', 'Pagamentos — Painel | QNB-Imobiliária'); ?>

<?php $__env->startSection('content'); ?>
<div class="ul-painel-head">
    <div>
        <h3 class="ul-painel-card-titulo" style="margin-bottom:4px;">Pagamentos</h3>
        <p class="ul-painel-card-subtitulo" style="margin-bottom:0;">Histórico de pagamentos da sua imobiliária.</p>
    </div>
    <a href="<?php echo e(route('painel.pagamento.novo')); ?>" class="ul-btn"><i class="bi bi-plus-lg"></i> Novo Pagamento</a>
</div>

<div class="ul-painel-card">
    <?php if($pagamentos->count()): ?>
    <div style="overflow-x:auto;">
        <table class="ul-painel-tabela">
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Plano</th>
                    <th>Valor</th>
                    <th>Método</th>
                    <th>Estado</th>
                    <th>Fatura</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $pagamentos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pagamento): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($pagamento->created_at->format('d/m/Y H:i')); ?></td>
                    <td><?php echo e($pagamento->subscricao->plano->nome ?? '—'); ?></td>
                    <td><?php echo e(number_format($pagamento->valor, 2, ',', '.')); ?> <?php echo e($pagamento->moeda); ?></td>
                    <td><?php echo e(ucfirst($pagamento->metodo)); ?></td>
                    <td>
                        <?php if($pagamento->estado === 'confirmado'): ?>
                        <span class="ul-badge ul-badge--success">Confirmado</span>
                        <?php elseif($pagamento->estado === 'rejeitado'): ?>
                        <span class="ul-badge ul-badge--danger">Rejeitado</span>
                        <?php else: ?>
                        <span class="ul-badge ul-badge--pendente">Pendente</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if($pagamento->fatura): ?>
                        <span class="ul-badge ul-badge--info"><?php echo e($pagamento->fatura->numero); ?></span>
                        <?php else: ?>
                        —
                        <?php endif; ?>
                    </td>
                    <td><a href="<?php echo e(route('painel.pagamentos.show', $pagamento->id)); ?>" class="ul-btn ul-btn--sm">Ver</a></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
    <div style="margin-top:15px;">
        <?php echo e($pagamentos->links()); ?>

    </div>
    <?php else: ?>
    <div class="ul-painel-vazio">
        <i class="bi bi-wallet2" style="font-size:48px;color:#ccc;margin-bottom:15px;display:block;"></i>
        <p>Nenhum pagamento registado ainda.</p>
        <a href="<?php echo e(route('painel.pagamento.novo')); ?>" class="ul-btn" style="margin-top:10px;">Submeter Pagamento</a>
    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.painel', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\JORGE DANGE\Documents\PROGRAMACAO\WEB\QND\PageWeb\imobiliaria\qnb-imobiliaria\resources\views/painel/pagamentos/index.blade.php ENDPATH**/ ?>