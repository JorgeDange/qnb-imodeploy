<?php $__env->startSection('title', ($admin ? 'Editar' : 'Novo') . ' Administrador — Admin'); ?>

<?php $__env->startSection('content'); ?>
<div class="ul-painel-cabecalho">
    <h1 class="ul-painel-titulo"><?php echo e($admin ? 'Editar Administrador' : 'Novo Administrador'); ?></h1>
    <a href="<?php echo e(route('admin.admins')); ?>" class="ul-painel-btn ul-painel-btn--cinza">
        <i class="bi bi-arrow-left"></i> Voltar
    </a>
</div>

<div class="ul-painel-card" style="max-width:700px;">
    <form action="<?php echo e($admin ? route('admin.admins.atualizar', $admin) : route('admin.admins.salvar')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <?php if($admin): ?>
            <?php echo method_field('PUT'); ?>
        <?php endif; ?>

        <div class="ul-painel-form-campo">
            <label class="ul-painel-form-label">Nome *</label>
            <input type="text" name="nome" class="ul-painel-form-input" value="<?php echo e(old('nome', $admin->nome ?? '')); ?>" required>
            <?php $__errorArgs = ['nome'];
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
            <label class="ul-painel-form-label">Email *</label>
            <input type="email" name="email" class="ul-painel-form-input" value="<?php echo e(old('email', $admin->email ?? '')); ?>" required>
            <?php $__errorArgs = ['email'];
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
            <label class="ul-painel-form-label"><?php echo e($admin ? 'Password (deixe vazio para manter)' : 'Password *'); ?></label>
            <input type="password" name="password" class="ul-painel-form-input" <?php echo e($admin ? '' : 'required'); ?> minlength="8">
            <?php $__errorArgs = ['password'];
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
            <label class="ul-painel-form-label">Confirmar Password <?php echo e($admin ? '' : '*'); ?></label>
            <input type="password" name="password_confirmation" class="ul-painel-form-input" minlength="8">
        </div>

        <div class="ul-painel-form-campo">
            <label class="ul-painel-form-label">Papel *</label>
            <select name="role" class="ul-painel-form-input" required>
                <?php $__currentLoopData = ['super_admin' => 'Super Admin', 'comercial' => 'Comercial', 'moderador' => 'Moderador']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($val); ?>" <?php echo e(old('role', $admin->role ?? '') === $val ? 'selected' : ''); ?>><?php echo e($label); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <small style="color:#888;">
                <strong>Super Admin:</strong> acesso total |
                <strong>Comercial:</strong> imobiliárias e imóveis |
                <strong>Moderador:</strong> conteúdo
            </small>
            <?php $__errorArgs = ['role'];
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

        <div style="margin-top:12px;">
            <label class="ul-painel-form-label" style="display:flex;align-items:center;gap:6px;cursor:pointer;">
                <input type="checkbox" name="ativo" value="1" <?php echo e(old('ativo', $admin->ativo ?? true) ? 'checked' : ''); ?>>
                Ativo
            </label>
        </div>

        <div style="margin-top:24px;">
            <button type="submit" class="ul-painel-btn ul-painel-btn--primario">
                <i class="bi bi-check-lg"></i> <?php echo e($admin ? 'Guardar Alterações' : 'Criar Administrador'); ?>

            </button>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\JORGE DANGE\Documents\PROGRAMACAO\WEB\QND\PageWeb\imobiliaria\qnb-imobiliaria\resources\views\admin\admins\form.blade.php ENDPATH**/ ?>