<?php $__env->startSection('title', ($plano ? 'Editar' : 'Novo') . ' Plano — Admin'); ?>

<?php $__env->startSection('content'); ?>
<div class="ul-painel-cabecalho">
    <h1 class="ul-painel-titulo"><?php echo e($plano ? 'Editar Plano' : 'Novo Plano'); ?></h1>
    <a href="<?php echo e(route('admin.planos')); ?>" class="ul-painel-btn ul-painel-btn--cinza">
        <i class="bi bi-arrow-left"></i> Voltar
    </a>
</div>

<div class="ul-painel-card" style="max-width:700px;">
    <form action="<?php echo e($plano ? route('admin.planos.atualizar', $plano) : route('admin.planos.salvar')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <?php if($plano): ?>
            <?php echo method_field('PUT'); ?>
        <?php endif; ?>

        <div class="ul-painel-form-campo">
            <label class="ul-painel-form-label">Nome *</label>
            <input type="text" name="nome" class="ul-painel-form-input" value="<?php echo e(old('nome', $plano->nome ?? '')); ?>" required>
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
            <label class="ul-painel-form-label">Descrição</label>
            <textarea name="descricao" class="ul-painel-form-input" rows="3"><?php echo e(old('descricao', $plano->descricao ?? '')); ?></textarea>
            <?php $__errorArgs = ['descricao'];
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

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
            <div class="ul-painel-form-campo">
                <label class="ul-painel-form-label">Limite de Posts *</label>
                <input type="number" name="posts_limite" class="ul-painel-form-input" value="<?php echo e(old('posts_limite', $plano->posts_limite ?? 5)); ?>" min="1" required>
                <?php $__errorArgs = ['posts_limite'];
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
                <label class="ul-painel-form-label">Dias de Validade *</label>
                <input type="number" name="dias_validade" class="ul-painel-form-input" value="<?php echo e(old('dias_validade', $plano->dias_validade ?? 30)); ?>" min="1" required>
                <?php $__errorArgs = ['dias_validade'];
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
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
            <div class="ul-painel-form-campo">
                <label class="ul-painel-form-label">Preço *</label>
                <input type="number" name="preco" class="ul-painel-form-input" value="<?php echo e(old('preco', $plano->preco ?? 0)); ?>" min="0" step="0.01" required>
                <?php $__errorArgs = ['preco'];
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
                <label class="ul-painel-form-label">Moeda *</label>
                <select name="moeda" class="ul-painel-form-input" required>
                    <option value="Kz" <?php echo e(old('moeda', $plano->moeda ?? 'Kz') === 'Kz' ? 'selected' : ''); ?>>Kz (Kwanza)</option>
                    <option value="USD" <?php echo e(old('moeda', $plano->moeda ?? '') === 'USD' ? 'selected' : ''); ?>>USD (Dólar)</option>
                </select>
                <?php $__errorArgs = ['moeda'];
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
        </div>

        <div class="ul-painel-form-campo">
            <label class="ul-painel-form-label">Ordem</label>
            <input type="number" name="ordem" class="ul-painel-form-input" value="<?php echo e(old('ordem', $plano->ordem ?? 0)); ?>" min="0">
        </div>

        <div style="display:flex;gap:20px;margin-top:12px;">
            <label class="ul-painel-form-label" style="display:flex;align-items:center;gap:6px;cursor:pointer;">
                <input type="checkbox" name="ativo" value="1" <?php echo e(old('ativo', $plano->ativo ?? true) ? 'checked' : ''); ?>>
                Ativo
            </label>
            <label class="ul-painel-form-label" style="display:flex;align-items:center;gap:6px;cursor:pointer;">
                <input type="checkbox" name="destaque" value="1" <?php echo e(old('destaque', $plano->destaque ?? false) ? 'checked' : ''); ?>>
                Destaque
            </label>
        </div>

        <div style="margin-top:24px;">
            <button type="submit" class="ul-painel-btn ul-painel-btn--primario">
                <i class="bi bi-check-lg"></i> <?php echo e($plano ? 'Guardar Alterações' : 'Criar Plano'); ?>

            </button>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\JORGE DANGE\Documents\PROGRAMACAO\WEB\QND\PageWeb\imobiliaria\qnb-imobiliaria\resources\views\admin\planos\form.blade.php ENDPATH**/ ?>