<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel — Registo | QNB-Imobiliária</title>

    <!-- libraries CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/icon/flaticon_real_estate.css')); ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="<?php echo e(asset('assets/vendor/bootstrap/bootstrap.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/vendor/animate-wow/animate.min.css')); ?>">

    <!-- custom CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/style.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('painel-assets/css/painel.css')); ?>">
    <link rel="icon" type="image/svg+xml" href="<?php echo e(asset('assets/img/logo-c.svg')); ?>">
</head>

<body>
    <div class="preloader" id="preloader">
        <div class="loader"></div>
    </div>

    <div class="ul-painel">

        <!-- TOPBAR -->
        <div class="ul-painel-topbar">
            <div class="ul-painel-topbar-left">
                <a href="<?php echo e(route('home')); ?>"><img src="<?php echo e(asset('assets/img/logo.svg')); ?>" alt="QNB-Imobiliária" class="logo"></a>
            </div>
            <div class="ul-painel-topbar-right">
                <a href="<?php echo e(route('home')); ?>" class="ul-painel-ver-site">Ver site público</a>
            </div>
        </div>

        <!-- AUTH -->
        <div class="ul-auth">
            <div class="ul-auth-card">
                <a href="<?php echo e(route('painel.login')); ?>" class="ul-auth-voltar"><i class="bi bi-arrow-left"></i> Voltar ao login</a>
                <div class="ul-auth-logo">
                    <img src="<?php echo e(asset('assets/img/logo-c.svg')); ?>" alt="QNB-Imobiliária">
                </div>
                <h2 class="ul-auth-titulo">Registe a sua conta</h2>
                <p class="ul-auth-subtitulo">Crie a sua conta para aceder ao painel.</p>

                <?php if($errors->any()): ?>
                <div class="ul-auth-erro" style="display:block;">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <p><?php echo e($error); ?></p>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php endif; ?>

                <form class="ul-painel-form" id="ul-form-registo" method="POST" action="<?php echo e(route('painel.registo.post')); ?>">
                    <?php echo csrf_field(); ?>
                    <div class="ul-auth-campos imobiliaria">
                        <div class="form-group">
                            <label for="nome">Nome da Imobiliária*</label>
                            <input type="text" id="nome" name="nome" placeholder="Nome da empresa" value="<?php echo e(old('nome')); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="nif">NIF</label>
                            <input type="text" id="nif" name="nif" placeholder="Número de identificação fiscal" value="<?php echo e(old('nif')); ?>">
                        </div>
                        <div class="form-group">
                            <label for="email">Email*</label>
                            <input type="email" id="email" name="email" placeholder="Email de contacto" value="<?php echo e(old('email')); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="telefone">Telefone*</label>
                            <input type="tel" id="telefone" name="telefone" placeholder="Número de telefone" value="<?php echo e(old('telefone')); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="provincia">Província</label>
                            <select id="provincia" name="provincia">
                                <option value="">Selecione</option>
                                <option value="Luanda" <?php echo e(old('provincia') == 'Luanda' ? 'selected' : ''); ?>>Luanda</option>
                                <option value="Benguela" <?php echo e(old('provincia') == 'Benguela' ? 'selected' : ''); ?>>Benguela</option>
                                <option value="Huambo" <?php echo e(old('provincia') == 'Huambo' ? 'selected' : ''); ?>>Huambo</option>
                                <option value="Huíla" <?php echo e(old('provincia') == 'Huíla' ? 'selected' : ''); ?>>Huíla</option>
                                <option value="Cabinda" <?php echo e(old('provincia') == 'Cabinda' ? 'selected' : ''); ?>>Cabinda</option>
                                <option value="Malanje" <?php echo e(old('provincia') == 'Malanje' ? 'selected' : ''); ?>>Malanje</option>
                                <option value="Namibe" <?php echo e(old('provincia') == 'Namibe' ? 'selected' : ''); ?>>Namibe</option>
                                <option value="Uíge" <?php echo e(old('provincia') == 'Uíge' ? 'selected' : ''); ?>>Uíge</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="municipio">Município</label>
                            <input type="text" id="municipio" name="municipio" placeholder="Município" value="<?php echo e(old('municipio')); ?>">
                        </div>
                        <div class="form-group">
                            <label for="password">Palavra-passe*</label>
                            <input type="password" id="password" name="password" placeholder="Crie uma palavra-passe" required>
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">Confirmar Palavra-passe*</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Repita a palavra-passe" required>
                        </div>
                        <p class="ul-auth-subtitulo" style="text-align:left;font-size:12.5px;">Depois do registo, a sua conta fica <strong>pendente</strong> até aprovação da equipa QNB. Só poderá publicar imóveis depois de ativar um plano.</p>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="ul-btn w-100"><i class="bi bi-house-check"></i> Criar Conta</button>
                    </div>
                </form>

                <p class="ul-auth-alternativa">Já tem conta? <a href="<?php echo e(route('painel.login')); ?>">Entrar</a></p>
            </div>
        </div>

        <!-- RODAPÉ SIMPLIFICADO -->
        <footer class="ul-painel-rodape">
            <span>© 2026 QNB-Imobiliária. Todos os direitos reservados.</span>
            <span><a href="<?php echo e(route('home')); ?>">Voltar ao site</a></span>
        </footer>
    </div>

    <!-- scripts -->
    <script src="<?php echo e(asset('assets/vendor/bootstrap/bootstrap.bundle.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/qnb-api.js')); ?>"></script>
    <script src="<?php echo e(asset('painel-assets/js/painel-auth.js')); ?>"></script>
    <script src="<?php echo e(asset('painel-assets/js/painel-loader.js')); ?>"></script>
</body>

</html>
<?php /**PATH C:\Users\JORGE DANGE\Documents\PROGRAMACAO\WEB\QND\PageWeb\imobiliaria\qnb-imobiliaria\resources\views\painel\auth\registo.blade.php ENDPATH**/ ?>