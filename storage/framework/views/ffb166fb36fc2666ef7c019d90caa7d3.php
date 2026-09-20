<?php $__env->startSection('cliente-content'); ?>
<div class="page-header">
    <h1><i class="bi bi-person me-2"></i>Meu Perfil</h1>
</div>

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

<!-- Foto de perfil -->
<div class="perfil-card">
    <h3 class="perfil-card-title">Foto de Perfil</h3>

    <div class="perfil-foto-area">
        <div class="perfil-foto-preview">
            <?php if($cliente->foto): ?>
                <img src="<?php echo e(str_starts_with($cliente->foto, 'assets/') ? asset($cliente->foto) : asset('storage/' . $cliente->foto)); ?>" alt="<?php echo e($cliente->nome); ?>" id="fotoPreview">
            <?php else: ?>
                <?php
                    $nome = trim($cliente->nome);
                    $palavras = explode(' ', $nome);
                    $primeiro = strtoupper(mb_substr($palavras[0], 0, 1));
                    $ultimo = strtoupper(mb_substr(end($palavras), -1, 1));
                ?>
                <div class="perfil-foto-initials" id="fotoPreview"><?php echo e($primeiro); ?><?php echo e($ultimo); ?></div>
            <?php endif; ?>
        </div>

        <?php if($cliente->podeUploadFoto()): ?>
        <form action="<?php echo e(route('cliente.perfil.foto')); ?>" method="POST" enctype="multipart/form-data" class="perfil-foto-form">
            <?php echo csrf_field(); ?>
            <?php echo method_field('POST'); ?>
            <input type="file" name="foto" id="fotoInput" accept="image/jpeg,image/png,image/webp" style="display:none">
            <button type="button" class="ul-btn ul-btn--outline" onclick="document.getElementById('fotoInput').click()">Escolher Foto</button>
            <small class="perfil-foto-info">JPEG, PNG ou WebP. Máx. 2MB.</small>
            <button type="submit" class="ul-btn" id="btnUpload" style="display:none;">Salvar Foto</button>
        </form>
        <?php else: ?>
        <div class="perfil-foto-bloqueado">
            <p><i class="bi bi-lock"></i> Pode voltar a alterar a foto em <strong><?php echo e($cliente->diasParaProximoUpload()); ?> dia(s)</strong>.</p>
            <small>Limite: 1 alteração por mês.</small>
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- Dados pessoais -->
<div class="perfil-card" style="margin-top: clamp(20px, 1.58vw, 30px);">
    <h3 class="perfil-card-title">Dados Pessoais</h3>

    <form class="ul-auth-form" method="POST" action="<?php echo e(route('cliente.perfil.update')); ?>">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <div class="perfil-field">
            <label for="nome">Nome completo</label>
            <input type="text" name="nome" id="nome" value="<?php echo e(old('nome', $cliente->nome)); ?>" required>
        </div>

        <div class="perfil-field">
            <label for="email">E-mail</label>
            <input type="email" name="email" id="email" value="<?php echo e(old('email', $cliente->email)); ?>" required>
        </div>

        <div class="perfil-field">
            <label for="telefone">Telefone</label>
            <input type="tel" name="telefone" id="telefone" value="<?php echo e(old('telefone', $cliente->telefone)); ?>">
        </div>

        <button type="submit" class="ul-btn">Guardar Alterações</button>
    </form>
</div>

<!-- Mudar password -->
<div class="perfil-card" style="margin-top: clamp(20px, 1.58vw, 30px);">
    <h3 class="perfil-card-title">Alterar Password</h3>

    <form class="ul-auth-form" method="POST" action="<?php echo e(route('cliente.perfil.password')); ?>">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <div class="perfil-field">
            <label for="password_atual">Password atual</label>
            <input type="password" name="password_atual" id="password_atual" required>
        </div>

        <div class="perfil-field">
            <label for="password">Nova password</label>
            <input type="password" name="password" id="password" required>
        </div>

        <div class="perfil-field">
            <label for="password_confirmation">Confirmar nova password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" required>
        </div>

        <button type="submit" class="ul-btn">Atualizar Password</button>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.getElementById('fotoInput')?.addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(ev) {
            const preview = document.getElementById('fotoPreview');
            if (preview.tagName === 'IMG') {
                preview.src = ev.target.result;
            } else {
                const img = document.createElement('img');
                img.src = ev.target.result;
                img.alt = 'Preview';
                img.id = 'fotoPreview';
                img.style.cssText = 'width:100px;height:100px;border-radius:50%;object-fit:cover;';
                preview.replaceWith(img);
            }
            document.getElementById('btnUpload').style.display = 'inline-block';
        };
        reader.readAsDataURL(file);
    }
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('cliente.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\JORGE DANGE\Documents\PROGRAMACAO\WEB\QND\PageWeb\imobiliaria\qnb-imobiliaria\resources\views\cliente\perfil.blade.php ENDPATH**/ ?>