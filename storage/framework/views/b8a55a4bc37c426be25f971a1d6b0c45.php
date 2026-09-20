<?php $__env->startSection('title', 'Registo - Área do Cliente - QNB Imobiliária'); ?>
<?php $__env->startSection('pagina', 'cliente'); ?>

<?php $__env->startSection('content'); ?>
<!-- BREADCRUMB SECTION -->
<div class="ul-breadcrumb">
    <div class="wow animate__fadeInUp">
        <h2 class="ul-breadcrumb-title">Área do Cliente</h2>
        <div class="ul-breadcrumb-nav">
            <a href="<?php echo e(route('home')); ?>">Início</a>
            <span class="separator"><i class="bi bi-chevron-left"></i></span>
            <span class="current-page">Registo</span>
        </div>
    </div>
</div>

<div class="ul-inner-page-content-wrapper">
    <div class="ul-inner-page-container">
        <div class="ul-auth-wrapper">
            <div class="ul-auth-card">
                <h2 class="ul-auth-title">Registo de conta</h2>
                <p class="ul-auth-descr">Crie a sua conta cliente gratuitamente</p>

                <?php if(session('error')): ?>
                <div class="ul-auth-note"><?php echo e(session('error')); ?></div>
                <?php endif; ?>

                <?php if($errors->any()): ?>
                <div class="ul-auth-note">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <p style="margin:0;"><?php echo e($error); ?></p>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php endif; ?>

                <form class="ul-auth-form" method="POST" action="<?php echo e(route('cliente.registo')); ?>">
                    <?php echo csrf_field(); ?>

                    <div class="form-group">
                        <label for="nome">Nome completo</label>
                        <input type="text" name="nome" id="nome" placeholder="O seu nome completo" value="<?php echo e(old('nome')); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="email">E-mail</label>
                        <input type="email" name="email" id="email" placeholder="O seu email" value="<?php echo e(old('email')); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="telefone">Telefone</label>
                        <input type="tel" name="telefone" id="telefone" placeholder="Ex: 923 456 789" value="<?php echo e(old('telefone')); ?>">
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" placeholder="Mínimo 8 caracteres" required>
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Confirmar password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Repita a password" required>
                    </div>

                    <button type="submit" class="ul-btn w-100">Criar conta</button>
                </form>

                <p class="ul-auth-alt">Já tem uma conta? <a href="<?php echo e(route('cliente.login')); ?>">Faça login</a></p>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.site', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\JORGE DANGE\Documents\PROGRAMACAO\WEB\QND\PageWeb\imobiliaria\qnb-imobiliaria\resources\views\cliente\auth\registro.blade.php ENDPATH**/ ?>