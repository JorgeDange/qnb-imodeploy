<?php $__env->startSection('title', 'Detalhe do Pagamento — Admin'); ?>

<?php $__env->startSection('content'); ?>
<div class="ul-painel-cabecalho">
    <h1 class="ul-painel-titulo">Pagamento #<?php echo e($pagamento->id); ?></h1>
    <a href="<?php echo e(route('admin.pagamentos')); ?>" class="ul-painel-btn ul-painel-btn--cinza">Voltar</a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="ul-painel-card">
            <h3 class="ul-painel-card-titulo">Dados do Pagamento</h3>
            <table class="ul-painel-tabela" style="margin:0;">
                <tr><td style="width:200px;font-weight:bold;">Imobiliária</td><td><?php echo e($pagamento->imobiliaria->nome ?? '—'); ?></td></tr>
                <tr><td style="font-weight:bold;">Plano</td><td><?php echo e($pagamento->subscricao->plano->nome ?? '—'); ?></td></tr>
                <tr><td style="font-weight:bold;">Valor</td><td><strong><?php echo e(number_format($pagamento->valor, 2, ',', '.')); ?></strong> <?php echo e($pagamento->moeda); ?></td></tr>
                <tr><td style="font-weight:bold;">Método</td><td><?php echo e(ucfirst(str_replace('_', ' ', $pagamento->metodo))); ?></td></tr>
                <tr><td style="font-weight:bold;">Referência</td><td><?php echo e($pagamento->referencia ?? '—'); ?></td></tr>
                <tr><td style="font-weight:bold;">Data Submissão</td><td><?php echo e($pagamento->created_at->format('d/m/Y H:i')); ?></td></tr>
                <tr>
                    <td style="font-weight:bold;">Estado</td>
                    <td>
                        <?php
                            $badge = match($pagamento->estado) {
                                'confirmado' => 'ul-badge--sucesso',
                                'pendente' => 'ul-badge--aviso',
                                'rejeitado' => 'ul-badge--perigo',
                                default => 'ul-badge--cinza',
                            };
                        ?>
                        <span class="ul-badge <?php echo e($badge); ?>"><?php echo e(ucfirst($pagamento->estado)); ?></span>
                    </td>
                </tr>
                <?php if($pagamento->confirmado_em): ?>
                <tr><td style="font-weight:bold;">Confirmado em</td><td><?php echo e($pagamento->confirmado_em->format('d/m/Y H:i')); ?></td></tr>
                <tr><td style="font-weight:bold;">Confirmado por</td><td><?php echo e($pagamento->confirmadoPor->name ?? '—'); ?></td></tr>
                <?php endif; ?>
                <?php if($pagamento->motivo_rejeicao): ?>
                <tr><td style="font-weight:bold;">Motivo Rejeição</td><td class="ul-painel-texto-perigo"><?php echo e($pagamento->motivo_rejeicao); ?></td></tr>
                <?php endif; ?>
            </table>
        </div>

        <?php if($pagamento->comprovativo): ?>
        <div class="ul-painel-card">
            <h3 class="ul-painel-card-titulo">Comprovativo</h3>
            <div style="padding:10px 0;">
                <img src="<?php echo e(asset('storage/' . $pagamento->comprovativo)); ?>" alt="Comprovativo" style="max-width:100%;max-height:500px;border-radius:8px;border:1px solid #eee;">
            </div>
        </div>
        <?php endif; ?>
    </div>

    <div class="col-lg-4">
        <?php if($pagamento->fatura): ?>
        <div class="ul-painel-card">
            <h3 class="ul-painel-card-titulo">Fatura Gerada</h3>
            <table class="ul-painel-tabela" style="margin:0;">
                <tr><td style="font-weight:bold;">Número</td><td><?php echo e($pagamento->fatura->numero); ?></td></tr>
                <tr><td style="font-weight:bold;">Total</td><td><?php echo e(number_format($pagamento->fatura->total, 2, ',', '.')); ?> <?php echo e($pagamento->fatura->moeda); ?></td></tr>
                <tr><td style="font-weight:bold;">Emitida</td><td><?php echo e($pagamento->fatura->emitida_em ? $pagamento->fatura->emitida_em->format('d/m/Y') : '—'); ?></td></tr>
            </table>
        </div>
        <?php endif; ?>

        <?php if($pagamento->estado === 'pendente'): ?>
        <div class="ul-painel-card">
            <h3 class="ul-painel-card-titulo">Ações</h3>

            <form id="pag-confirm-<?php echo e($pagamento->id); ?>" action="<?php echo e(route('admin.pagamentos.confirmar', $pagamento)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <button type="button" class="ul-painel-btn ul-painel-btn--sucesso-bloco" onclick="modalConfirmar('Confirmar Pagamento', 'Confirmar este pagamento? O plano será ativado automaticamente.', function(){ document.getElementById('pag-confirm-<?php echo e($pagamento->id); ?>').submit(); })">Confirmar Pagamento</button>
            </form>

            <form id="pag-rejeitar-<?php echo e($pagamento->id); ?>" action="<?php echo e(route('admin.pagamentos.rejeitar', $pagamento)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="ul-painel-form-campo">
                    <label class="ul-painel-form-label">Motivo da Rejeição (opcional)</label>
                    <textarea name="motivo" class="ul-painel-form-input" rows="3" placeholder="Descreva o motivo..."></textarea>
                </div>
                <button type="button" class="ul-painel-btn ul-painel-btn--perigo" style="width:100%;" onclick="modalPerigo('Rejeitar Pagamento', 'Rejeitar este pagamento?', function(){ document.getElementById('pag-rejeitar-<?php echo e($pagamento->id); ?>').submit(); })">Rejeitar Pagamento</button>
            </form>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\JORGE DANGE\Documents\PROGRAMACAO\WEB\QND\PageWeb\imobiliaria\qnb-imobiliaria\resources\views\admin\pagamentos\show.blade.php ENDPATH**/ ?>