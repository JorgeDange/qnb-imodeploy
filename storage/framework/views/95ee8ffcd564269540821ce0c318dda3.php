<?php $__env->startSection('title', 'Alterar Password — Painel'); ?>

<?php $__env->startSection('content'); ?>
<div class="ul-painel-cabecalho">
    <h1 class="ul-painel-titulo">Alterar Palavra-passe</h1>
    <a href="<?php echo e(route('painel.perfil')); ?>" class="ul-painel-btn ul-painel-btn--cinza"><i class="bi bi-arrow-left"></i> Voltar</a>
</div>

<div class="ul-painel-card" style="max-width:500px;">
    <form action="<?php echo e(route('painel.perfil.password.salvar')); ?>" method="POST" class="ul-painel-form">
        <?php echo csrf_field(); ?>
        <div class="form-group">
            <label for="password_atual">Palavra-passe atual</label>
            <input type="password" name="password_atual" id="password_atual" required>
            <?php $__errorArgs = ['password_atual'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <small style="color:#dc3545;"><?php echo e($message); ?></small>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div class="form-group">
            <label for="password">Nova palavra-passe</label>
            <input type="password" name="password" id="password" required minlength="6">
            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <small style="color:#dc3545;"><?php echo e($message); ?></small>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div class="form-group">
            <label for="password_confirmation">Confirmar nova palavra-passe</label>
            <input type="password" name="password_confirmation" id="password_confirmation" required minlength="6">
        </div>
        <button type="submit" class="ul-painel-btn ul-painel-btn--primario">Alterar Palavra-passe</button>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.painel', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\JORGE DANGE\Documents\PROGRAMACAO\WEB\QND\PageWeb\imobiliaria\qnb-imobiliaria\resources\views\painel\password.blade.php ENDPATH**/ ?>