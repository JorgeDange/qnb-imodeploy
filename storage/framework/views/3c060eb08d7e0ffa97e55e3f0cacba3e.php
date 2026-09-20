<?php $__env->startSection('title', 'Denúncia #' . $denuncia->id . ' — Admin'); ?>

<?php $__env->startSection('content'); ?>
<div class="ul-painel-cabecalho">
    <div>
        <h1 class="ul-painel-titulo">Denúncia #<?php echo e($denuncia->id); ?></h1>
    </div>
    <a href="<?php echo e(route('admin.denuncias')); ?>" class="ul-painel-btn ul-painel-btn--cinza"><i class="bi bi-arrow-left"></i> Voltar</a>
</div>

<div class="ul-painel-dash-cols">
    <div class="ul-painel-card">
        <h3 class="ul-painel-card-titulo" style="font-size:16px;margin-bottom:14px;">Informações</h3>
        <div class="ul-painel-grid-dados">
            <div class="ul-painel-dado">
                <span class="ul-painel-dado-rotulo">Imóvel</span>
                <span class="ul-painel-dado-valor"><?php echo e($denuncia->imovel->titulo ?? '—'); ?></span>
            </div>
            <div class="ul-painel-dado">
                <span class="ul-painel-dado-rotulo">Imobiliária</span>
                <span class="ul-painel-dado-valor"><?php echo e($denuncia->imobiliaria->nome ?? '—'); ?></span>
            </div>
            <div class="ul-painel-dado">
                <span class="ul-painel-dado-rotulo">Autor</span>
                <span class="ul-painel-dado-valor"><?php echo e($denuncia->autor_nome); ?></span>
            </div>
            <div class="ul-painel-dado">
                <span class="ul-painel-dado-rotulo">Email</span>
                <span class="ul-painel-dado-valor"><?php echo e($denuncia->autor_email); ?></span>
            </div>
            <div class="ul-painel-dado">
                <span class="ul-painel-dado-rotulo">Telefone</span>
                <span class="ul-painel-dado-valor"><?php echo e($denuncia->autor_telefone ?? '—'); ?></span>
            </div>
            <div class="ul-painel-dado">
                <span class="ul-painel-dado-rotulo">Motivo</span>
                <span class="ul-painel-dado-valor"><?php echo e(str_replace('_', ' ', ucfirst($denuncia->motivo))); ?></span>
            </div>
            <div class="ul-painel-dado">
                <span class="ul-painel-dado-rotulo">Estado</span>
                <span class="ul-painel-dado-valor">
                    <?php if($denuncia->estado === 'pendente'): ?>
                        <span class="ul-badge ul-badge--pendente">Pendente</span>
                    <?php elseif($denuncia->estado === 'em_analise'): ?>
                        <span class="ul-badge ul-badge--destaque">Em análise</span>
                    <?php elseif($denuncia->estado === 'resolvida'): ?>
                        <span class="ul-badge ul-badge--aprovado">Resolvida</span>
                    <?php else: ?>
                        <span class="ul-badge ul-badge--cinza">Arquivada</span>
                    <?php endif; ?>
                </span>
            </div>
            <div class="ul-painel-dado">
                <span class="ul-painel-dado-rotulo">Data</span>
                <span class="ul-painel-dado-valor"><?php echo e($denuncia->created_at->format('d/m/Y H:i')); ?></span>
            </div>
        </div>

        <div style="margin-top:16px;">
            <strong style="font-size:13px;color:var(--ul-gray2);">Descrição:</strong>
            <p style="margin-top:6px;font-size:14px;color:var(--ul-secondary);"><?php echo e($denuncia->descricao); ?></p>
        </div>

        <?php if($denuncia->resolucao): ?>
        <div style="margin-top:16px;padding:14px;background:#F7F7FD;border-radius:10px;">
            <strong style="font-size:13px;color:var(--ul-gray2);">Resolução:</strong>
            <p style="margin-top:6px;font-size:14px;color:var(--ul-secondary);"><?php echo e($denuncia->resolucao); ?></p>
            <small style="color:var(--ul-gray2);">Por <?php echo e($denuncia->resolvidoPor->nome ?? '—'); ?> em <?php echo e($denuncia->resolvido_em?->format('d/m/Y H:i')); ?></small>
        </div>
        <?php endif; ?>
    </div>

    <div class="ul-painel-card">
        <h3 class="ul-painel-card-titulo" style="font-size:16px;margin-bottom:14px;">Ações</h3>

        <?php if($denuncia->estado !== 'resolvida' && $denuncia->estado !== 'arquivada'): ?>
        <form action="<?php echo e(route('admin.denuncias.resolver', $denuncia)); ?>" method="POST" style="margin-bottom:16px;">
            <?php echo csrf_field(); ?>
            <div class="ul-painel-form">
                <div class="form-group">
                    <label for="resolucao">Resolução</label>
                    <textarea name="resolucao" id="resolucao" rows="4" placeholder="Descreva como a denúncia foi resolvida..." required></textarea>
                </div>
                <button type="submit" class="ul-painel-btn ul-painel-btn--primario"><i class="bi bi-check-lg"></i> Marcar como Resolvida</button>
            </div>
        </form>

        <form id="denunc-arquivar-<?php echo e($denuncia->id); ?>" action="<?php echo e(route('admin.denuncias.arquivar', $denuncia)); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <button type="button" class="ul-painel-btn ul-painel-btn--cinza" onclick="modalConfirmar('Arquivar Denúncia', 'Arquivar esta denúncia?', function(){ document.getElementById('denunc-arquivar-<?php echo e($denuncia->id); ?>').submit(); })"><i class="bi bi-x-lg"></i> Arquivar</button>
        </form>
        <?php else: ?>
        <p style="color:var(--ul-gray2);font-size:14px;">Esta denúncia já foi <?php echo e($denuncia->estado === 'resolvida' ? 'resolvida' : 'arquivada'); ?>.</p>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\JORGE DANGE\Documents\PROGRAMACAO\WEB\QND\PageWeb\imobiliaria\qnb-imobiliaria\resources\views\admin\denuncias\show.blade.php ENDPATH**/ ?>