<?php $__env->startSection('title', 'Thread — Admin'); ?>

<?php $__env->startSection('content'); ?>
<div class="ul-painel-cabecalho">
    <h1 class="ul-painel-titulo"><?php echo e($thread->assunto); ?></h1>
    <div style="display:flex;gap:8px;">
        <a href="<?php echo e(route('admin.mensagens')); ?>" class="ul-painel-btn ul-painel-btn--cinza">
            <i class="bi bi-arrow-left"></i> Voltar
        </a>
        <form action="<?php echo e(route('admin.mensagens.fechar', $thread)); ?>" method="POST" style="display:inline;">
            <?php echo csrf_field(); ?>
            <button type="submit" class="ul-painel-btn ul-painel-btn--aviso">
                <i class="bi bi-x-lg"></i> Fechar Thread
            </button>
        </form>
    </div>
</div>

<div class="ul-painel-card">
    <div style="margin-bottom:12px;color:#888;">
        <strong>Imobiliária:</strong> <?php echo e($thread->imobiliaria->nome ?? '—'); ?> |
        <strong>Criada:</strong> <?php echo e($thread->created_at->format('d/m/Y H:i')); ?>

    </div>

    <div style="border-top:1px solid #e2e8f0;padding-top:16px;">
        <!-- Mensagem original -->
        <div style="margin-bottom:20px;padding:16px;background:#f8fafc;border-radius:8px;">
            <div style="margin-bottom:8px;">
                <strong><?php echo e($thread->admin->nome ?? 'Admin'); ?></strong>
                <small style="color:#888;"> — <?php echo e($thread->created_at->format('d/m/Y H:i')); ?></small>
            </div>
            <p><?php echo nl2br(e($thread->texto)); ?></p>
        </div>

        <!-- Respostas -->
        <?php $__empty_1 = true; $__currentLoopData = $respostas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div style="margin-bottom:16px;padding:16px;background:<?php echo e($r->autor_tipo === 'admin' ? '#eff6ff' : '#f0fdf4'); ?>;border-radius:8px;">
            <div style="margin-bottom:8px;">
                <strong><?php echo e($r->autor_tipo === 'admin' ? ($r->admin->nome ?? 'Admin') : ($r->imobiliaria->nome ?? 'Imobiliária')); ?></strong>
                <small style="color:#888;"> — <?php echo e($r->created_at->format('d/m/Y H:i')); ?></small>
            </div>
            <p><?php echo nl2br(e($r->texto)); ?></p>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <p style="color:#888;text-align:center;padding:20px;">Nenhuma resposta ainda.</p>
        <?php endif; ?>
    </div>

    <!-- Responder -->
    <div style="border-top:1px solid #e2e8f0;padding-top:16px;margin-top:16px;">
        <form action="<?php echo e(route('admin.mensagens.responder', $thread)); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div class="ul-painel-form-campo">
                <label class="ul-painel-form-label">Responder</label>
                <textarea name="texto" class="ul-painel-form-input" rows="4" required placeholder="Escreva a sua resposta..."></textarea>
                <?php $__errorArgs = ['texto'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="ul-painel-form-erro"><?php echo e($message); ?></span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <button type="submit" class="ul-painel-btn ul-painel-btn--primario" style="margin-top:8px;">
                <i class="bi bi-send"></i> Enviar Resposta
            </button>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\JORGE DANGE\Documents\PROGRAMACAO\WEB\QND\PageWeb\imobiliaria\qnb-imobiliaria\resources\views\admin\mensagens\show.blade.php ENDPATH**/ ?>