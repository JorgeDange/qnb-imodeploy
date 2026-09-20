<?php $__env->startSection('title', 'Mensagens — Painel | QNB-Imobiliária'); ?>

<?php $__env->startSection('content'); ?>
<div class="ul-painel-head">
    <div>
        <h3 class="ul-painel-card-titulo ul-mb-4">Mensagens Recebidas</h3>
        <p class="ul-painel-card-subtitulo ul-mb-0"><?php echo e($mensagens->count()); ?> mensagem(ns) no total.</p>
    </div>
</div>

<?php if($mensagens->count()): ?>
    <?php $__currentLoopData = $mensagens; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mensagem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="ul-painel-mensagem <?php echo e(!$mensagem->lida ? 'ul-painel-mensagem--naolida' : ''); ?>">
        <div class="ul-painel-mensagem-cab">
            <span class="ul-painel-mensagem-nome"><?php echo e($mensagem->nome); ?></span>
            <span class="ul-painel-mensagem-data"><?php echo e($mensagem->created_at->format('d/m/Y H:i')); ?></span>
        </div>
        <p class="ul-painel-mensagem-texto"><?php echo e($mensagem->texto); ?></p>

        <div style="display:flex;flex-wrap:wrap;gap:12px;margin:10px 0;font-size:13px;color:var(--ul-gray2);">
            <?php if($mensagem->contacto): ?>
                <span><i class="bi bi-diagram-3"></i> <?php echo e($mensagem->contacto); ?></span>
            <?php endif; ?>
            <?php if($mensagem->imovel): ?>
                <span><i class="bi bi-house"></i> <?php echo e($mensagem->imovel->titulo); ?></span>
                <?php if($mensagem->imovel->estado === 'aprovado'): ?>
                    <span style="color:#10b981;"><i class="bi bi-check-lg"></i> Disponível</span>
                <?php else: ?>
                    <span style="color:#e74c3c;"><i class="bi bi-x-lg"></i> Indisponível</span>
                <?php endif; ?>
            <?php endif; ?>
        </div>

        <div class="ul-painel-mensagem-rodape">
            <div class="ul-painel-mensagem-acoes">
                <?php if(!$mensagem->lida): ?>
                <form action="<?php echo e(route('painel.mensagens.lida', $mensagem->id)); ?>" method="POST" style="display:inline;">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="ul-painel-btn ul-painel-btn--pequeno" title="Marcar como lida"><i class="bi bi-check-lg"></i> Lida</button>
                </form>
                <?php endif; ?>

                <?php if(str_contains($mensagem->contacto, '@')): ?>
                    <a href="mailto:<?php echo e($mensagem->contacto); ?>" class="ul-painel-btn ul-painel-btn--pequeno" title="Responder por email"><i class="bi bi-envelope"></i> Contactar</a>
                <?php else: ?>
                    <a href="tel:<?php echo e($mensagem->contacto); ?>" class="ul-painel-btn ul-painel-btn--pequeno" title="Ligar"><i class="bi bi-diagram-3"></i> Contactar</a>
                <?php endif; ?>

                <?php if($mensagem->imovel_id): ?>
                    <a href="https://wa.me/<?php echo e(ltrim(preg_replace('/[^0-9]/', '', $mensagem->contacto), '0')); ?>" target="_blank" class="ul-painel-btn ul-painel-btn--pequeno" title="WhatsApp" style="color:#25D366;"><i class="bi bi-diagram-3"></i> WhatsApp</a>

                    <?php if($mensagem->imovel && $mensagem->imovel->estado === 'aprovado'): ?>
                        <button type="button" class="ul-painel-btn ul-painel-btn--pequeno" style="color:#1a5276;" title="Notificar disponibilidade" onclick="notificarDisp(<?php echo e($mensagem->id); ?>, 1)"><i class="bi bi-house"></i> Disp.</button>
                    <?php endif; ?>
                    <?php if($mensagem->imovel && $mensagem->imovel->estado !== 'aprovado'): ?>
                        <button type="button" class="ul-painel-btn ul-painel-btn--pequeno" style="color:#e67e22;" title="Notificar indisponibilidade" onclick="notificarDisp(<?php echo e($mensagem->id); ?>, 0)"><i class="bi bi-house"></i> Indisp.</button>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php else: ?>
<div class="ul-painel-vazio">
    <i class="bi bi-envelope" style="font-size:48px;color:#ccc;margin-bottom:15px;display:block;"></i>
    <p>Nenhuma mensagem recebida ainda.</p>
</div>
<?php endif; ?>

<form id="notificarForm" method="POST" style="display:none;">
    <?php echo csrf_field(); ?>
    <input type="hidden" name="disponivel" id="notificarDisponivel">
</form>

<script>
function notificarDisp(id, disponivel) {
    var form = document.getElementById('notificarForm');
    form.action = '/painel/mensagens/' + id + '/notificar';
    document.getElementById('notificarDisponivel').value = disponivel;
    form.submit();
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.painel', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\JORGE DANGE\Documents\PROGRAMACAO\WEB\QND\PageWeb\imobiliaria\qnb-imobiliaria\resources\views\painel\mensagens.blade.php ENDPATH**/ ?>