<?php $__env->startSection('title', 'Pedido #' . $pedido->id . ' - Admin'); ?>
<?php $__env->startSection('pageTitle', 'Pedido #' . $pedido->id); ?>

<?php $__env->startSection('content'); ?>
<div class="ul-painel-head">
    <div>
        <h2>Pedido #<?php echo e($pedido->id); ?></h2>
    </div>
    <a href="<?php echo e(route('admin.pedidos')); ?>" class="ul-btn ul-btn--sm">
        <i class="bi bi-arrow-left"></i> Voltar
    </a>
</div>

<!-- info card -->
<div class="ul-painel-card mb-3">
    <div class="ul-painel-card-titulo">
        Informações do Pedido
        <span class="ul-badge ul-badge--<?php echo e($pedido->estado === 'fechado' ? 'aprovado' : ($pedido->estado === 'perdido' ? 'rejeitado' : 'pendente')); ?> ms-2">
            <?php echo e(ucfirst(str_replace('_', ' ', $pedido->estado))); ?>

        </span>
    </div>

    <div class="ul-painel-grid-dados">
        <div class="ul-painel-dado">
            <span class="ul-painel-dado-rotulo">Imobiliária</span>
            <span class="ul-painel-dado-valor"><?php echo e($pedido->imobiliaria->nome ?? '—'); ?></span>
        </div>
        <div class="ul-painel-dado">
            <span class="ul-painel-dado-rotulo">Email</span>
            <span class="ul-painel-dado-valor"><?php echo e($pedido->imobiliaria->email ?? '—'); ?></span>
        </div>
        <div class="ul-painel-dado">
            <span class="ul-painel-dado-rotulo">Telefone</span>
            <span class="ul-painel-dado-valor"><?php echo e($pedido->imobiliaria->telefone ?? '—'); ?></span>
        </div>
        <div class="ul-painel-dado">
            <span class="ul-painel-dado-rotulo">Plano Pretendido</span>
            <span class="ul-painel-dado-valor"><?php echo e($pedido->plano_pretendido ?? '—'); ?></span>
        </div>
        <div class="ul-painel-dado">
            <span class="ul-painel-dado-rotulo">Estado</span>
            <span class="ul-painel-dado-valor"><?php echo e(ucfirst(str_replace('_', ' ', $pedido->estado))); ?></span>
        </div>
        <div class="ul-painel-dado">
            <span class="ul-painel-dado-rotulo">Data</span>
            <span class="ul-painel-dado-valor"><?php echo e($pedido->created_at->format('d/m/Y H:i')); ?></span>
        </div>
    </div>

    <?php if($pedido->mensagem): ?>
    <div class="ul-painel-aviso ul-painel-aviso--cinza m-3">
        <strong>Mensagem:</strong>
        <p class="mb-0 mt-1"><?php echo e($pedido->mensagem); ?></p>
    </div>
    <?php endif; ?>
</div>

<!-- alterar estado -->
<div class="ul-painel-card mb-3">
    <div class="ul-painel-card-titulo">Alterar Estado</div>
    <form action="<?php echo e(route('admin.pedidos.estado', $pedido->id)); ?>" method="POST" class="ul-painel-form p-3">
        <?php echo csrf_field(); ?>
        <div class="row g-3 align-items-end">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Novo Estado</label>
                    <select name="estado" required>
                        <option value="novo" <?php echo e($pedido->estado === 'novo' ? 'selected' : ''); ?>>Novo</option>
                        <option value="em_negociacao" <?php echo e($pedido->estado === 'em_negociacao' ? 'selected' : ''); ?>>Em Negociação</option>
                        <option value="proposta_enviada" <?php echo e($pedido->estado === 'proposta_enviada' ? 'selected' : ''); ?>>Proposta Enviada</option>
                        <option value="fechado" <?php echo e($pedido->estado === 'fechado' ? 'selected' : ''); ?>>Fechado</option>
                        <option value="perdido" <?php echo e($pedido->estado === 'perdido' ? 'selected' : ''); ?>>Perdido</option>
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <button type="submit" class="ul-btn ul-btn--primary w-100">Salvar</button>
            </div>
        </div>
    </form>
</div>

<!-- liberar plano -->
<div class="ul-painel-card mb-3">
    <div class="ul-painel-card-titulo">Liberar Plano</div>
    <form id="pedido-liberar-<?php echo e($pedido->id); ?>" action="<?php echo e(route('admin.pedidos.liberar', $pedido->id)); ?>" method="POST" class="ul-painel-form p-3">
        <?php echo csrf_field(); ?>
        <div class="row g-3 align-items-end">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Plano</label>
                    <select name="plano_id" required>
                        <option value="">Selecionar plano...</option>
                        <?php $__currentLoopData = $planos ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plano): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($plano->id); ?>"><?php echo e($plano->nome); ?> — <?php echo e(number_format($plano->preco, 0, ',', '.')); ?> <?php echo e($plano->moeda); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Dias de Validade</label>
                    <input type="number" name="dias_validade" value="30" min="1" required>
                </div>
            </div>
            <div class="col-md-2">
                <button type="button" class="ul-btn ul-btn--primary w-100" onclick="modalConfirmar('Liberar Plano', 'Liberar este plano para a imobiliária?', function(){ document.getElementById('pedido-liberar-<?php echo e($pedido->id); ?>').submit(); })">
                    Liberar Plano
                </button>
            </div>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\JORGE DANGE\Documents\PROGRAMACAO\WEB\QND\PageWeb\imobiliaria\qnb-imobiliaria\resources\views\admin\pedidos\show.blade.php ENDPATH**/ ?>