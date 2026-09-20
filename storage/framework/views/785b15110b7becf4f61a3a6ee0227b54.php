<?php $__env->startSection('cliente-content'); ?>
<div class="denuncias-page">
    <div class="page-header">
        <h1><i class="bi bi-flag me-2"></i>Minhas Denúncias</h1>
    </div>

    
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title"><i class="bi bi-plus-circle me-2"></i>Nova Denúncia</h5>
            <form action="<?php echo e(route('cliente.denuncias.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="mb-3">
                    <label for="imovel_id" class="form-label">Imóvel <span class="text-danger">*</span></label>
                    <select name="imovel_id" id="imovel_id" class="form-select <?php $__errorArgs = ['imovel_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                        <option value="">-- Escolha o imóvel --</option>
                        <?php $__currentLoopData = $imoveis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $imovel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($imovel->id); ?>" <?php echo e(old('imovel_id') == $imovel->id ? 'selected' : ''); ?>>
                            <?php echo e(substr($imovel->titulo, 0, 60)); ?> (<?php echo e($imovel->referencia); ?>)
                        </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php $__errorArgs = ['imovel_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="mb-3">
                    <label for="motivo" class="form-label">Motivo <span class="text-danger">*</span></label>
                    <select name="motivo" id="motivo" class="form-select <?php $__errorArgs = ['motivo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                        <option value="">-- Escolha o motivo --</option>
                        <option value="spam" <?php echo e(old('motivo') === 'spam' ? 'selected' : ''); ?>>Spam</option>
                        <option value="informacao_falsa" <?php echo e(old('motivo') === 'informacao_falsa' ? 'selected' : ''); ?>>Informação falsa</option>
                        <option value="imovel_inexistente" <?php echo e(old('motivo') === 'imovel_inexistente' ? 'selected' : ''); ?>>Imóvel inexistente</option>
                        <option value="preco_incorreto" <?php echo e(old('motivo') === 'preco_incorreto' ? 'selected' : ''); ?>>Preço incorreto</option>
                        <option value="violacao" <?php echo e(old('motivo') === 'violacao' ? 'selected' : ''); ?>>Violação de regras</option>
                        <option value="outro" <?php echo e(old('motivo') === 'outro' ? 'selected' : ''); ?>>Outro</option>
                    </select>
                    <?php $__errorArgs = ['motivo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="mb-3">
                    <label for="descricao" class="form-label">Descrição <span class="text-danger">*</span></label>
                    <textarea name="descricao" id="descricao" rows="4" class="form-control <?php $__errorArgs = ['descricao'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                        placeholder="Descreva o problema com o imóvel..." required><?php echo e(old('descricao')); ?></textarea>
                    <?php $__errorArgs = ['descricao'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-send me-1"></i>Enviar Denúncia
                </button>
            </form>
        </div>
    </div>

    
    <?php if($denuncias->isEmpty()): ?>
    <div class="empty-state">
        <i class="bi bi-flag bi-3x mb-3 opacity-50"></i>
        <h3>Sem denúncias</h3>
        <p>Não enviou nenhuma denúncia ainda.</p>
    </div>
    <?php else: ?>
    <div class="denuncias-lista">
        <?php $__currentLoopData = $denuncias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $denuncia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="denuncia-item">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="fw-bold">
                        <?php if($denuncia->imovel): ?>
                        <a href="<?php echo e(route('imoveis.show', $denuncia->imovel->referencia)); ?>">
                            <?php echo e(substr($denuncia->imovel->titulo, 0, 50)); ?>

                        </a>
                        <?php else: ?>
                        Imóvel removido
                        <?php endif; ?>
                    </div>
                    <div class="text-muted small">
                        Motivo: <strong><?php echo e($denuncia->motivo); ?></strong> ·
                        <?php echo e($denuncia->created_at->format('d/m/Y H:i')); ?>

                    </div>
                    <div class="mt-1"><?php echo e(Str::limit($denuncia->descricao, 120)); ?></div>
                </div>
                <span class="badge <?php echo e($denuncia->estado === 'pendente' ? 'bg-warning text-dark' : ($denuncia->estado === 'em_analise' ? 'bg-info text-dark' : ($denuncia->estado === 'resolvida' ? 'bg-success' : 'bg-secondary'))); ?>">
                    <?php echo e(ucfirst($denuncia->estado)); ?>

                </span>
            </div>
            <?php if($denuncia->resolucao): ?>
            <div class="mt-2 p-2 bg-light rounded small">
                <strong>Resolução:</strong> <?php echo e($denuncia->resolucao); ?>

            </div>
            <?php endif; ?>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('cliente.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\JORGE DANGE\Documents\PROGRAMACAO\WEB\QND\PageWeb\imobiliaria\qnb-imobiliaria\resources\views\cliente\denuncias.blade.php ENDPATH**/ ?>