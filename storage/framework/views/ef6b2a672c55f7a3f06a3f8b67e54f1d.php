<?php $__env->startSection('title', 'Área do Cliente - QNB Imobiliária'); ?>
<?php $__env->startSection('pagina', 'cliente'); ?>

<?php $__env->startSection('content'); ?>
<!-- BREADCRUMB SECTION -->
<div class="ul-breadcrumb">
    <div class="wow animate__fadeInUp">
        <h2 class="ul-breadcrumb-title">Área do Cliente</h2>
        <div class="ul-breadcrumb-nav">
            <a href="<?php echo e(route('home')); ?>">Início</a>
            <span class="separator"><i class="bi bi-chevron-left"></i></span>
            <span class="current-page">Login</span>
        </div>
    </div>
</div>

<div class="ul-inner-page-content-wrapper">
    <div class="ul-inner-page-container">
        <div class="ul-auth-wrapper">
            <div class="ul-auth-card">
                <h2 class="ul-auth-title">Bem-vindo de volta</h2>
                <p class="ul-auth-descr">Faça login para aceder à sua Área do Cliente</p>

                <?php if(session('error')): ?>
                <div class="ul-auth-note"><?php echo e(session('error')); ?></div>
                <?php endif; ?>

                <?php if(session('sucesso')): ?>
                <div class="ul-auth-note" style="background-color:#E8F5E9;border-left-color:#2E7D32;"><?php echo e(session('sucesso')); ?></div>
                <?php endif; ?>

                <?php if($errors->any()): ?>
                <div class="ul-auth-note">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <p style="margin:0;"><?php echo e($error); ?></p>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php endif; ?>

                <form class="ul-auth-form" method="POST" action="<?php echo e(route('cliente.login')); ?>">
                    <?php echo csrf_field(); ?>

                    <div class="form-group">
                        <label for="email">E-mail</label>
                        <input type="email" name="email" id="email" placeholder="O seu email" value="<?php echo e(old('email')); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" placeholder="A sua palavra-passe" required>
                    </div>

                    <div class="form-group">
                        <label class="ul-checkbox">
                            <input type="checkbox" name="remember" id="remember">
                            Manter sessão aberta
                        </label>
                    </div>

                    <button type="submit" class="ul-btn w-100">Entrar</button>
                </form>

                <p class="ul-auth-alt">Não tem uma conta? <a href="<?php echo e(route('cliente.registo')); ?>">Registe-se</a></p>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.site', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\JORGE DANGE\Documents\PROGRAMACAO\WEB\QND\PageWeb\imobiliaria\qnb-imobiliaria\resources\views\cliente\auth\login.blade.php ENDPATH**/ ?>