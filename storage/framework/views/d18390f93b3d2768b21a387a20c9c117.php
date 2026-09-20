<?php $__env->startSection('title', 'Nova Mensagem — Admin'); ?>

<?php $__env->startSection('content'); ?>
<div class="ul-painel-cabecalho">
    <h1 class="ul-painel-titulo">Nova Mensagem</h1>
    <a href="<?php echo e(route('admin.mensagens')); ?>" class="ul-painel-btn ul-painel-btn--cinza">
        <i class="bi bi-arrow-left"></i> Voltar
    </a>
</div>

<div class="ul-painel-card" style="max-width:700px;">
    <form action="<?php echo e(route('admin.mensagens.enviar')); ?>" method="POST">
        <?php echo csrf_field(); ?>

        <div class="ul-painel-form-campo">
            <label class="ul-painel-form-label">Imobiliária *</label>
            <select name="imobiliaria_id" class="ul-painel-form-input" required>
                <option value="">Selecione...</option>
                <?php $__currentLoopData = $imobiliarias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $imob): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($imob->id); ?>" <?php echo e(old('imobiliaria_id') == $imob->id ? 'selected' : ''); ?>>
                        <?php echo e($imob->nome); ?> — <?php echo e($imob->email); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <?php $__errorArgs = ['imobiliaria_id'];
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

        <div class="ul-painel-form-campo">
            <label class="ul-painel-form-label">Assunto *</label>
            <input type="text" name="assunto" class="ul-painel-form-input" value="<?php echo e(old('assunto')); ?>" required>
            <?php $__errorArgs = ['assunto'];
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

        <div class="ul-painel-form-campo">
            <label class="ul-painel-form-label">Mensagem *</label>
            <textarea name="texto" class="ul-painel-form-input" rows="6" required><?php echo e(old('texto')); ?></textarea>
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

        <div style="margin-top:24px;">
            <button type="submit" class="ul-painel-btn ul-painel-btn--primario">
                <i class="bi bi-send"></i> Enviar Mensagem
            </button>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\JORGE DANGE\Documents\PROGRAMACAO\WEB\QND\PageWeb\imobiliaria\qnb-imobiliaria\resources\views\admin\mensagens\form.blade.php ENDPATH**/ ?>