<?php $__env->startSection('title', ($subscricao ? 'Editar' : 'Nova') . ' Subscrição — Admin'); ?>

<?php $__env->startSection('content'); ?>
<div class="ul-painel-cabecalho">
    <h1 class="ul-painel-titulo"><?php echo e($subscricao ? 'Editar Subscrição' : 'Nova Subscrição'); ?></h1>
    <a href="<?php echo e(route('admin.subscricoes')); ?>" class="ul-painel-btn ul-painel-btn--cinza">
        <i class="bi bi-arrow-left"></i> Voltar
    </a>
</div>

<div class="ul-painel-card" style="max-width:700px;">
    <form action="<?php echo e($subscricao ? route('admin.subscricoes.atualizar', $subscricao) : route('admin.subscricoes.salvar')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <?php if($subscricao): ?>
            <?php echo method_field('PUT'); ?>
        <?php endif; ?>

        <div class="ul-painel-form-campo">
            <label class="ul-painel-form-label">Imobiliária *</label>
            <select name="imobiliaria_id" class="ul-painel-form-input" required>
                <option value="">Selecione...</option>
                <?php $__currentLoopData = $imobiliarias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $imob): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($imob->id); ?>" <?php echo e(old('imobiliaria_id', $subscricao->imobiliaria_id ?? '') == $imob->id ? 'selected' : ''); ?>>
                        <?php echo e($imob->nome); ?>

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
            <label class="ul-painel-form-label">Plano *</label>
            <select name="plano_id" class="ul-painel-form-input" required>
                <option value="">Selecione...</option>
                <?php $__currentLoopData = $planos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($p->id); ?>" <?php echo e(old('plano_id', $subscricao->plano_id ?? '') == $p->id ? 'selected' : ''); ?>>
                        <?php echo e($p->nome); ?> — <?php echo e(number_format($p->preco, 0, ',', '.')); ?> <?php echo e($p->moeda); ?> (<?php echo e($p->posts_limite); ?> posts, <?php echo e($p->dias_validade); ?> dias)
                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <?php $__errorArgs = ['plano_id'];
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
                <label class="ul-painel-form-label">Data de Início *</label>
                <input type="date" name="data_inicio" class="ul-painel-form-input" value="<?php echo e(old('data_inicio', $subscricao->data_inicio?->format('Y-m-d') ?? date('Y-m-d'))); ?>" required>
                <?php $__errorArgs = ['data_inicio'];
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
                <label class="ul-painel-form-label">Data de Expiração *</label>
                <input type="date" name="data_expiracao" class="ul-painel-form-input" value="<?php echo e(old('data_expiracao', $subscricao->data_expiracao?->format('Y-m-d') ?? date('Y-m-d', strtotime('+30 days')))); ?>" required>
                <?php $__errorArgs = ['data_expiracao'];
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
                <label class="ul-painel-form-label">Posts Usados</label>
                <input type="number" name="posts_usados" class="ul-painel-form-input" value="<?php echo e(old('posts_usados', $subscricao->posts_usados ?? 0)); ?>" min="0">
            </div>

            <div class="ul-painel-form-campo">
                <label class="ul-painel-form-label">Estado *</label>
                <select name="estado" class="ul-painel-form-input" required>
                    <?php $__currentLoopData = ['ativa', 'pendente', 'expirada', 'cancelada']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $est): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($est); ?>" <?php echo e(old('estado', $subscricao->estado ?? 'ativa') === $est ? 'selected' : ''); ?>>
                            <?php echo e(ucfirst($est)); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
        </div>

        <div style="margin-top:12px;">
            <label class="ul-painel-form-label" style="display:flex;align-items:center;gap:6px;cursor:pointer;">
                <input type="checkbox" name="renovacao_automatica" value="1" <?php echo e(old('renovacao_automatica', $subscricao->renovacao_automatica ?? false) ? 'checked' : ''); ?>>
                Renovação automática
            </label>
        </div>

        <div style="margin-top:24px;">
            <button type="submit" class="ul-painel-btn ul-painel-btn--primario">
                <i class="bi bi-check-lg"></i> <?php echo e($subscricao ? 'Guardar Alterações' : 'Criar Subscrição'); ?>

            </button>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\JORGE DANGE\Documents\PROGRAMACAO\WEB\QND\PageWeb\imobiliaria\qnb-imobiliaria\resources\views\admin\subscricoes\form.blade.php ENDPATH**/ ?>