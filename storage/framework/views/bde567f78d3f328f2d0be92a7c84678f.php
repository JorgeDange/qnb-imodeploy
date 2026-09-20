<?php $__env->startSection('title', 'Novo Pagamento — Painel | QNB-Imobiliária'); ?>

<?php $__env->startSection('content'); ?>
<div class="ul-painel-head">
    <div>
        <h3 class="ul-painel-card-titulo" style="margin-bottom:4px;">Submeter Pagamento</h3>
        <p class="ul-painel-card-subtitulo" style="margin-bottom:0;">Escolha o plano e submeta o comprovativo de pagamento.</p>
    </div>
</div>

<?php if($errors->any()): ?>
<div class="ul-painel-aviso ul-painel-aviso--destaque">
    <div class="ul-painel-aviso-icone"><i class="bi bi-info-circle"></i></div>
    <div class="ul-painel-aviso-texto">
        <h4 class="ul-painel-aviso-titulo">Erros de validação</h4>
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><p><?php echo e($error); ?></p><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>
<?php endif; ?>

<form action="<?php echo e(route('painel.pagamento.salvar')); ?>" method="POST" enctype="multipart/form-data" class="ul-painel-form">
    <?php echo csrf_field(); ?>

    <!-- Escolher Plano -->
    <div class="ul-painel-card">
        <h3 class="ul-painel-card-titulo">1. Escolher Plano</h3>
        <div class="ul-painel-form-seccao">
            <div class="row">
                <?php $__currentLoopData = $planos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plano): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-lg-4 col-md-6 mb-3">
                    <label style="display:block;cursor:pointer;">
                        <input type="radio" name="plano_id" value="<?php echo e($plano->id); ?>" <?php echo e($loop->first ? 'checked' : ''); ?> style="display:none;" required>
                        <div class="ul-painel-card" style="text-align:center;transition:all 0.2s;<?php echo e($planoAtual && $planoAtual->plano_id == $plano->id ? 'border:2px solid var(--ul-primary);opacity:0.6;' : ''); ?>" onclick="this.querySelector('input').checked=true;document.querySelectorAll('.ul-painel-card[style*=border]').forEach(c=>{if(c!==this)c.style.border='';});this.style.border='2px solid var(--ul-primary)';">
                            <h4 style="margin:0 0 8px;"><?php echo e($plano->nome); ?></h4>
                            <div style="font-size:28px;font-weight:700;color:var(--ul-primary);"><?php echo e(number_format($plano->preco, 0, ',', '.')); ?> <small style="font-size:14px;color:#999;"><?php echo e($plano->moeda); ?></small></div>
                            <div style="font-size:13px;color:#666;margin:8px 0;"><?php echo e($plano->dias_validade); ?> dias · <?php echo e($plano->posts_limite); ?> posts</div>
                            <?php if($planoAtual && $planoAtual->plano_id == $plano->id): ?>
                            <span class="ul-badge ul-badge--success" style="margin-top:5px;">Plano Atual</span>
                            <?php endif; ?>
                        </div>
                    </label>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>

    <!-- Dados do Pagamento -->
    <div class="ul-painel-card">
        <h3 class="ul-painel-card-titulo">2. Dados do Pagamento</h3>
        <div class="ul-painel-form-seccao">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Método de Pagamento *</label>
                        <select name="metodo" required>
                            <option value="">Selecione</option>
                            <option value="transferencia" <?php echo e(old('metodo') == 'transferencia' ? 'selected' : ''); ?>>Transferência Bancária</option>
                            <option value="multicaixa" <?php echo e(old('metodo') == 'multicaixa' ? 'selected' : ''); ?>>Multicaixa Express</option>
                            <option value="dinheiro" <?php echo e(old('metodo') == 'dinheiro' ? 'selected' : ''); ?>>Dinheiro</option>
                            <option value="outro" <?php echo e(old('metodo') == 'outro' ? 'selected' : ''); ?>>Outro</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Referência / Nº Documento</label>
                        <input type="text" name="referencia" value="<?php echo e(old('referencia')); ?>" placeholder="Nº da transferência, recibo, etc.">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Comprovativo (opcional)</label>
                        <input type="file" name="comprovativo" accept="image/jpeg,image/png,image/webp">
                        <small style="color:#999;">JPEG, PNG ou WebP. Máximo 5MB.</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Dados Bancários (info) -->
    <div class="ul-painel-card">
        <h3 class="ul-painel-card-titulo">Dados Bancários para Transferência</h3>
        <div class="ul-painel-form-seccao">
            <div class="ul-painel-grid-dados">
                <div class="ul-painel-dado"><span class="ul-painel-dado-rotulo">Banco</span><span class="ul-painel-dado-valor">BFA</span></div>
                <div class="ul-painel-dado"><span class="ul-painel-dado-rotulo">IBAN</span><span class="ul-painel-dado-valor">AO06 0040 0000 8857 2019 1019 5</span></div>
                <div class="ul-painel-dado"><span class="ul-painel-dado-rotulo">Titular</span><span class="ul-painel-dado-valor">QNB Imobiliária, Lda</span></div>
                <div class="ul-painel-dado"><span class="ul-painel-dado-rotulo">Referência</span><span class="ul-painel-dado-valor">Plano + Nome da Imobiliária</span></div>
            </div>
        </div>
    </div>

    <!-- Submit -->
    <div class="ul-painel-card">
        <div class="ul-painel-form-seccao">
            <button type="submit" class="ul-btn"><i class="bi bi-check-lg"></i> Submeter Pagamento</button>
            <a href="<?php echo e(route('painel.ativar-plano')); ?>" class="ul-btn" style="margin-left:10px;">Cancelar</a>
        </div>
    </div>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.painel', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\JORGE DANGE\Documents\PROGRAMACAO\WEB\QND\PageWeb\imobiliaria\qnb-imobiliaria\resources\views/painel/pagamento/novo.blade.php ENDPATH**/ ?>