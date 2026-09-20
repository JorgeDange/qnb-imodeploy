<?php $__env->startSection('cliente-content'); ?>
<div class="ver-mensagem-page">
    <div class="page-header">
        <h1><i class="bi bi-envelope me-2"></i>Mensagem</h1>
        <a href="<?php echo e(route('cliente.mensagens')); ?>" class="btn-voltar">Voltar</a>
    </div>
    
    <?php if($mensagem): ?>
    <div class="mensagem-detalhe">
        <div class="mensagem-autor">
            <div class="autor-info">
                <h3><?php echo e($mensagem->nome); ?></h3>
                <p><i class="bi bi-envelope"></i> <?php echo e($mensagem->contacto); ?></p>
                <p><small><?php echo e($mensagem->created_at ? $mensagem->created_at->format('d/m/Y H:i') : '—'); ?></small></p>
            </div>
            <?php if($mensagem->origem): ?>
            <span class="origem-badge <?php echo e($mensagem->origem); ?>"><?php echo e(ucfirst($mensagem->origem)); ?></span>
            <?php endif; ?>
        </div>
        
        <div class="mensagem-texto">
            <p><?php echo e(nl2br($mensagem->texto)); ?></p>
        </div>
        
        <?php if(auth()->guard('cliente')->user()->id === $mensagem->cliente_id || auth()->guard('admin')->check()): ?>
        <div class="acao-responder">
            <form method="POST" action="<?php echo e(route('cliente.mensagens.responder', $mensagem->id)); ?>">
                <?php echo csrf_field(); ?>
                <div class="form-group">
                    <textarea name="texto" rows="3" placeholder="Sua resposta..." class="form-control" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary mt-3">Enviar resposta</button>
            </form>
        </div>
        <?php endif; ?>
    </div>
    <?php else: ?>
    <div class="empty-state">
        <i class="bi bi-exclamation-triangle bi-3x mb-3 opacity-50"></i>
        <h3>Mensagem não encontrada</h3>
        <p>A mensagem solicitada não existe ou não tem permissão para visualizar.</p>
        <a href="<?php echo e(route('cliente.mensagens')); ?>" class="btn btn-primary">Voltar</a>
    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('cliente.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\JORGE DANGE\Documents\PROGRAMACAO\WEB\QND\PageWeb\imobiliaria\qnb-imobiliaria\resources\views\cliente\ver-mensagem.blade.php ENDPATH**/ ?>