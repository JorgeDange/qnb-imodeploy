<?php $__env->startSection('title', ($imovel ? 'Editar' : 'Novo') . ' Imóvel — Painel | QNB-Imobiliária'); ?>

<?php $__env->startSection('content'); ?>
<?php if($errors->any()): ?>
<div class="ul-painel-aviso ul-painel-aviso--destaque">
    <div class="ul-painel-aviso-icone"><i class="bi bi-info-circle"></i></div>
    <div class="ul-painel-aviso-texto">
        <h4 class="ul-painel-aviso-titulo">Erros de validação</h4>
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><p><?php echo e($error); ?></p><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>
<?php endif; ?>

<form action="<?php echo e($imovel ? route('painel.imoveis.update', $imovel->id) : route('painel.imoveis.store')); ?>" method="POST" enctype="multipart/form-data" class="ul-painel-form">
    <?php echo csrf_field(); ?>
    <?php if($imovel): ?> <?php echo method_field('PUT'); ?> <?php endif; ?>

    <!-- Dados Gerais -->
    <div class="ul-painel-card">
        <h3 class="ul-painel-card-titulo">Dados Gerais</h3>
        <div class="ul-painel-form-seccao">
            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        <label>Título *</label>
                        <input type="text" name="titulo" value="<?php echo e(old('titulo', $imovel->titulo ?? '')); ?>" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Referência</label>
                        <input type="text" value="<?php echo e($imovel->referencia ?? 'Auto-gerada'); ?>" disabled>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label>Descrição</label>
                        <textarea name="descricao" rows="4"><?php echo e(old('descricao', $imovel->descricao ?? '')); ?></textarea>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Preço *</label>
                        <input type="number" name="preco" value="<?php echo e(old('preco', $imovel->preco ?? '')); ?>" min="0" step="0.01" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Moeda *</label>
                        <select name="moeda" required>
                            <option value="Kz" <?php echo e(old('moeda', $imovel->moeda ?? '') == 'Kz' ? 'selected' : ''); ?>>Kz (Kwanza)</option>
                            <option value="USD" <?php echo e(old('moeda', $imovel->moeda ?? '') == 'USD' ? 'selected' : ''); ?>>USD (Dólar)</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Finalidade *</label>
                        <select name="finalidade" required>
                            <option value="arrendar" <?php echo e(old('finalidade', $imovel->finalidade ?? '') == 'arrendar' ? 'selected' : ''); ?>>Arrendar</option>
                            <option value="vender" <?php echo e(old('finalidade', $imovel->finalidade ?? '') == 'vender' ? 'selected' : ''); ?>>Vender</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Tipo *</label>
                        <select name="tipo" required>
                            <?php $__currentLoopData = ['apartamento' => 'Apartamento', 'vivenda' => 'Vivenda', 'terreno' => 'Terreno', 'loja' => 'Loja', 'escritorio' => 'Escritório', 'armazem' => 'Armazém', 'quintal' => 'Quintal']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($val); ?>" <?php echo e(old('tipo', $imovel->tipo ?? '') == $val ? 'selected' : ''); ?>><?php echo e($label); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Características -->
    <div class="ul-painel-card">
        <h3 class="ul-painel-card-titulo">Características</h3>
        <div class="ul-painel-form-seccao">
            <div class="row">
                <div class="col-md-4"><div class="form-group"><label>Área (m²)</label><input type="number" name="area" value="<?php echo e(old('area', $imovel->area ?? '')); ?>" min="0"></div></div>
                <div class="col-md-4"><div class="form-group"><label>Quartos</label><input type="number" name="quartos" value="<?php echo e(old('quartos', $imovel->quartos ?? '')); ?>" min="0"></div></div>
                <div class="col-md-4"><div class="form-group"><label>WC</label><input type="number" name="wc" value="<?php echo e(old('wc', $imovel->wc ?? '')); ?>" min="0"></div></div>
                <div class="col-md-4"><div class="form-group"><label>Estacionamento</label><input type="number" name="estacionamento" value="<?php echo e(old('estacionamento', $imovel->estacionamento ?? '')); ?>" min="0"></div></div>
                <div class="col-md-4"><div class="form-group"><label>Ano Construção</label><input type="number" name="ano_construcao" value="<?php echo e(old('ano_construcao', $imovel->ano_construcao ?? '')); ?>" min="1900" max="<?php echo e(date('Y')); ?>"></div></div>
                <div class="col-md-4"><div class="form-group"><label>Estado *</label><select name="estado_imovel" required><option value="novo" <?php echo e(old('estado_imovel', $imovel->estado_imovel ?? '') == 'novo' ? 'selected' : ''); ?>>Novo</option><option value="usado" <?php echo e(old('estado_imovel', $imovel->estado_imovel ?? '') == 'usado' ? 'selected' : ''); ?>>Usado</option></select></div></div>
            </div>
        </div>
    </div>

    <!-- Localização -->
    <div class="ul-painel-card">
        <h3 class="ul-painel-card-titulo">Localização</h3>
        <div class="ul-painel-form-seccao">
            <div class="row">
                <div class="col-md-4"><div class="form-group"><label>Província *</label><select name="provincia" required><option value="">Selecione</option><?php $__currentLoopData = ['Luanda','Benguela','Huambo','Huíla','Cabinda','Malanje','Namibe','Uíge','Cuanza-Norte','Cuanza-Sul','Bengo','Icolo-e-Bengo','Cunene','Cuando-Cubango','Moxico','Zaire']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prov): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($prov); ?>" <?php echo e(old('provincia', $imovel->provincia ?? '') == $prov ? 'selected' : ''); ?>><?php echo e($prov); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></div></div>
                <div class="col-md-4"><div class="form-group"><label>Município *</label><input type="text" name="municipio" value="<?php echo e(old('municipio', $imovel->municipio ?? '')); ?>" required></div></div>
                <div class="col-md-4"><div class="form-group"><label>Bairro</label><input type="text" name="bairro" value="<?php echo e(old('bairro', $imovel->bairro ?? '')); ?>"></div></div>
                <div class="col-md-6"><div class="form-group"><label>Endereço</label><input type="text" name="endereco" value="<?php echo e(old('endereco', $imovel->endereco ?? '')); ?>"></div></div>
            </div>
        </div>
    </div>

    <!-- Fotos -->
    <div class="ul-painel-card">
        <h3 class="ul-painel-card-titulo">Fotos <?php echo e($imovel ? '(deixe vazio para manter as atuais)' : ''); ?></h3>
        <div class="ul-painel-form-seccao">
            <?php if($imovel && $imovel->fotos->count()): ?>
            <div class="ul-fotos-preview mb-3">
                <?php $__currentLoopData = $imovel->fotos->sortBy('ordem'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $foto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="ul-fotos-preview-img" style="position:relative;display:inline-block;margin:5px;">
                    <img src="<?php echo e(asset('storage/' . $foto->caminho)); ?>" alt="<?php echo e($foto->legenda); ?>" style="width:100px;height:75px;object-fit:cover;border-radius:6px;">
                    <?php if($foto->capa): ?><span style="position:absolute;top:2px;left:2px;background:var(--ul-primary);color:#fff;font-size:10px;padding:2px 6px;border-radius:10px;">Capa</span><?php endif; ?>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <?php endif; ?>
            <div class="form-group">
                <label><?php echo e($imovel ? 'Novas Fotos (mínimo 5, máximo 10)' : 'Fotos (mínimo 5, máximo 10)'); ?> *</label>
                <input type="file" name="fotos[]" multiple accept="image/jpeg,image/png,image/webp" <?php echo e($imovel ? '' : 'required'); ?>>
                <small style="color:#999;">JPEG, PNG ou WebP. Máximo 5MB cada. Primeira foto será a capa.</small>
            </div>
        </div>
    </div>

    <!-- Amenidades -->
    <div class="ul-painel-card">
        <h3 class="ul-painel-card-titulo">Amenidades</h3>
        <div class="ul-painel-form-seccao">
            <div class="ul-amenidades-grid">
                <?php $__currentLoopData = $amenidades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $amenidade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="ul-checkbox">
                    <input type="checkbox" name="amenidades[]" value="<?php echo e($amenidade->id); ?>" id="amenidade-<?php echo e($amenidade->id); ?>" <?php echo e(in_array($amenidade->id, old('amenidades', $imovel ? $imovel->amenidades->pluck('id')->toArray() : [])) ? 'checked' : ''); ?>>
                    <label for="amenidade-<?php echo e($amenidade->id); ?>"><?php echo e($amenidade->nome); ?></label>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>

    <!-- Submit -->
    <div class="ul-painel-card">
        <div class="ul-painel-form-seccao">
            <button type="submit" class="ul-btn"><i class="bi bi-check-lg"></i> <?php echo e($imovel ? 'Salvar Alterações' : 'Cadastrar Imóvel'); ?></button>
            <a href="<?php echo e(route('painel.imoveis')); ?>" class="ul-btn" style="margin-left:10px;">Cancelar</a>
        </div>
    </div>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.painel', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\JORGE DANGE\Documents\PROGRAMACAO\WEB\QND\PageWeb\imobiliaria\qnb-imobiliaria\resources\views\painel\imoveis\form.blade.php ENDPATH**/ ?>