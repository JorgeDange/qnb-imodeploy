<?php $__env->startSection('cliente-content'); ?>
<div class="avaliacoes-page">
    <div class="page-header">
        <h1><i class="bi bi-star me-2"></i>Minhas Avaliações</h1>
    </div>

    
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title"><i class="bi bi-plus-circle me-2"></i>Nova Avaliação</h5>
            <form action="<?php echo e(route('cliente.avaliacoes.store')); ?>" method="POST">
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
                    <label class="form-label">Estrelas <span class="text-danger">*</span></label>
                    <div class="estrelas-input">
                        <?php for($i = 1; $i <= 5; $i++): ?>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="estrelas" id="estrelas-<?php echo e($i); ?>" value="<?php echo e($i); ?>" <?php echo e(old('estrelas') == $i ? 'checked' : ''); ?> required>
                            <label class="form-check-label" for="estrelas-<?php echo e($i); ?>"><?php echo e($i); ?> ★</label>
                        </div>
                        <?php endfor; ?>
                    </div>
                    <?php $__errorArgs = ['estrelas'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="text-danger small"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="mb-3">
                    <label for="comentario" class="form-label">Comentário</label>
                    <textarea name="comentario" id="comentario" rows="4" class="form-control <?php $__errorArgs = ['comentario'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                        placeholder="Partilhe a sua experiência..."><?php echo e(old('comentario')); ?></textarea>
                    <?php $__errorArgs = ['comentario'];
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
                    <i class="bi bi-send me-1"></i>Enviar Avaliação
                </button>
            </form>
        </div>
    </div>

    
    <?php if($avaliacoes->isEmpty()): ?>
    <div class="empty-state">
        <i class="bi bi-star bi-3x mb-3 opacity-50"></i>
        <h3>Sem avaliações</h3>
        <p>Não enviou nenhuma avaliação ainda.</p>
    </div>
    <?php else: ?>
    <div class="avaliacoes-lista">
        <?php $__currentLoopData = $avaliacoes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $avaliacao): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="avaliacao-item">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="fw-bold">
                        <?php if($avaliacao->imovel): ?>
                        <a href="<?php echo e(route('imoveis.show', $avaliacao->imovel->referencia)); ?>">
                            <?php echo e(substr($avaliacao->imovel->titulo, 0, 50)); ?>

                        </a>
                        <?php else: ?>
                        Imóvel removido
                        <?php endif; ?>
                    </div>
                    <div class="text-warning">
                        <?php for($i = 1; $i <= 5; $i++): ?>
                        <i class="bi bi-star <?php echo e($i <= $avaliacao->estrelas ? '' : 'opacity-25'); ?>"></i>
                        <?php endfor; ?>
                    </div>
                    <div class="mt-1"><?php echo e(Str::limit($avaliacao->comentario, 150)); ?></div>
                    <div class="text-muted small"><?php echo e($avaliacao->created_at->format('d/m/Y H:i')); ?></div>
                </div>
                <div class="text-end">
                    <span class="badge <?php echo e($avaliacao->estado === 'aprovada' ? 'bg-success' : ($avaliacao->estado === 'pendente' ? 'bg-warning text-dark' : 'bg-danger')); ?>">
                        <?php echo e(ucfirst($avaliacao->estado)); ?>

                    </span>
                    <?php if($avaliacao->estado === 'rejeitada'): ?>
                    <form action="<?php echo e(route('cliente.avaliacoes.reenviar', $avaliacao->id)); ?>" method="POST" class="mt-2">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="btn btn-sm btn-outline-primary" title="Corrigir e reenviar">
                            <i class="bi bi-arrow-clockwise me-1"></i>Reenviar
                        </button>
                    </form>
                    <?php endif; ?>
                </div>
            </div>
            <?php if($avaliacao->motivo_rejeicao): ?>
            <div class="mt-2 p-2 bg-light rounded small">
                <strong>Motivo da rejeição:</strong> <?php echo e($avaliacao->motivo_rejeicao); ?>

            </div>
            <?php endif; ?>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('cliente.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\JORGE DANGE\Documents\PROGRAMACAO\WEB\QND\PageWeb\imobiliaria\qnb-imobiliaria\resources\views\cliente\avaliacoes.blade.php ENDPATH**/ ?>