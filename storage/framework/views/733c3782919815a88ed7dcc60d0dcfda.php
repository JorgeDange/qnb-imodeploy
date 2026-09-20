<?php $__env->startSection('cliente-content'); ?>
<div class="visitas-page">
    <div class="page-header">
        <h1><i class="bi bi-calendar me-2"></i>Minhas Visitas Agendadas</h1>
    </div>

    <?php if(session('sucesso')): ?>
    <div class="alert alert-success"><?php echo e(session('sucesso')); ?></div>
    <?php endif; ?>

    <?php if($visitas->isEmpty()): ?>
    <div class="empty-state">
        <i class="bi bi-calendar-week bi-3x mb-3 opacity-50"></i>
        <h3>Nenhuma visita agendada</h3>
        <p>Não tem visitas agendadas no momento.</p>
        <a href="<?php echo e(route('imoveis.index')); ?>" class="btn btn-primary">Ver Imóveis Disponíveis</a>
    </div>
    <?php else: ?>
    <div class="visitas-list">
        <?php $__currentLoopData = $visitas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $visita): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="visita-item" style="border-left: 4px solid
            <?php if($visita->estado === 'pendente'): ?> #e67e22
            <?php elseif($visita->estado === 'confirmada'): ?> #10b981
            <?php elseif($visita->estado === 'concluida'): ?> #1a5276
            <?php else: ?> #e74c3c
            <?php endif; ?>;
        ">
            <div class="visita-header">
                <h3><?php echo e($visita->imovel->titulo ?? 'Imóvel removido'); ?></h3>
                <span class="visita-estado <?php echo e(strtolower($visita->estado)); ?>">
                    <?php if($visita->estado === 'pendente'): ?>
                        Pendente
                    <?php elseif($visita->estado === 'confirmada'): ?>
                        Confirmada
                    <?php elseif($visita->estado === 'concluida'): ?>
                        Concluída
                    <?php else: ?>
                        Cancelada
                    <?php endif; ?>
                </span>
            </div>
            <div class="visita-meta">
                <div class="meta-item">
                    <i class="bi bi-calendar me-1"></i>
                    <span><?php echo e($visita->data_visita ? $visita->data_visita->format('d/m/Y H:i') : '—'); ?></span>
                </div>
                <div class="meta-item">
                    <i class="bi bi-telephone me-1"></i>
                    <span><?php echo e($visita->cliente_telefone); ?></span>
                </div>
                <?php if($visita->observacoes): ?>
                <div class="meta-item" style="color:#e67e22;">
                    <i class="bi bi-info-circle me-1"></i>
                    <span><?php echo e($visita->observacoes); ?></span>
                </div>
                <?php endif; ?>
            </div>
            <div class="visita-actions">
                <?php if($visita->estado === 'pendente'): ?>
                <form method="POST" action="<?php echo e(route('cliente.visitas.cancelar', $visita->id)); ?>" style="display:inline;">
                    <?php echo csrf_field(); ?>
                    <button type="button" class="btn btn-danger btn-sm" onclick="modalPerigo('Cancelar Visita', 'Tem certeza que deseja cancelar esta visita?', function(){ this.closest('form').submit(); }.bind(this))">Cancelar</button>
                </form>
                <?php elseif($visita->estado === 'confirmada'): ?>
                <form method="POST" action="<?php echo e(route('cliente.visitas.cancelar', $visita->id)); ?>" style="display:inline;">
                    <?php echo csrf_field(); ?>
                    <button type="button" class="btn btn-warning btn-sm" onclick="modalPerigo('Cancelar Visita', 'Deseja cancelar esta visita confirmada?', function(){ this.closest('form').submit(); }.bind(this))">Cancelar</button>
                </form>
                <?php elseif($visita->estado === 'cancelada' && $visita->imovel): ?>
                <a href="<?php echo e(route('imoveis.show', $visita->imovel->referencia)); ?>" class="btn btn-primary btn-sm">Reagendar</a>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('cliente.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\JORGE DANGE\Documents\PROGRAMACAO\WEB\QND\PageWeb\imobiliaria\qnb-imobiliaria\resources\views\cliente\visitas.blade.php ENDPATH**/ ?>