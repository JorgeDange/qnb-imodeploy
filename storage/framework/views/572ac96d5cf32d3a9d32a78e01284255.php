

<?php $__env->startSection('title', 'Meu Perfil — Painel | QNB-Imobiliária'); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-lg-8">
        <!-- Dados da Empresa -->
        <div class="ul-painel-card">
            <h3 class="ul-painel-card-titulo">Dados da Empresa</h3>
            <form action="<?php echo e(route('painel.perfil.update')); ?>" method="POST" class="ul-painel-form" enctype="multipart/form-data">
                <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                <div class="ul-painel-form-seccao">
                    <div class="row">
                        <div class="col-md-6"><div class="form-group"><label>Nome *</label><input type="text" name="nome" value="<?php echo e($imobiliaria->nome); ?>" required></div></div>
                        <div class="col-md-6"><div class="form-group"><label>NIF</label><input type="text" name="nif" value="<?php echo e($imobiliaria->nif); ?>"></div></div>
                        <div class="col-md-6"><div class="form-group"><label>Email *</label><input type="email" name="email" value="<?php echo e($imobiliaria->email); ?>" required></div></div>
                        <div class="col-md-6"><div class="form-group"><label>Telefone *</label><input type="text" name="telefone" value="<?php echo e($imobiliaria->telefone); ?>" required></div></div>
                        <div class="col-md-6"><div class="form-group"><label>Província</label><select name="provincia"><option value="">Selecione</option><?php $__currentLoopData = ['Luanda','Benguela','Huambo','Huíla','Cabinda','Malanje','Namibe','Uíge']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prov): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($prov); ?>" <?php echo e($imobiliaria->provincia == $prov ? 'selected' : ''); ?>><?php echo e($prov); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></div></div>
                        <div class="col-md-6"><div class="form-group"><label>Município</label><input type="text" name="municipio" value="<?php echo e($imobiliaria->municipio); ?>"></div></div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Foto de Perfil</label>
                                <div class="ul-painel-foto-upload">
                                    <?php if($imobiliaria->foto): ?>
                                        <img src="<?php echo e(str_starts_with($imobiliaria->foto, 'assets/') ? asset($imobiliaria->foto) : asset('storage/' . $imobiliaria->foto)); ?>" alt="<?php echo e($imobiliaria->nome); ?>" class="ul-painel-foto-preview" id="fotoPreview">
                                    <?php else: ?>
                                        <div class="ul-painel-foto-placeholder" id="fotoPreview">
                                            <i class="bi bi-camera"></i>
                                        </div>
                                    <?php endif; ?>
                                    <div class="ul-painel-foto-actions">
                                        <input type="file" name="foto" id="fotoInput" accept="image/*" style="display:none">
                                        <button type="button" class="ul-btn ul-btn--outline" onclick="document.getElementById('fotoInput').click()">Escolher Foto</button>
                                        <small class="ul-painel-foto-info">JPEG, PNG ou WebP. Máx. 2MB.</small>
                                    </div>
                                </div>
                                <?php $__errorArgs = ['foto'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="text-danger"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="ul-btn">Salvar Alterações</button>
                </div>
            </form>
        </div>
    </div>

    <div class="col-lg-4">
        <!-- Estado da Conta -->
        <div class="ul-painel-card">
            <h3 class="ul-painel-card-titulo">Estado da Conta</h3>
            <div class="ul-painel-grid-dados">
                <div class="ul-painel-dado">
                    <span class="ul-painel-dado-rotulo">Estado</span>
                    <span class="ul-painel-dado-valor"><span class="ul-badge ul-badge--<?php echo e($imobiliaria->estado); ?>"><?php echo e(ucfirst($imobiliaria->estado)); ?></span></span>
                </div>
            </div>
            <?php if($imobiliaria->estado === 'pendente'): ?>
            <div class="ul-painel-aviso ul-painel-aviso--cinza" style="margin-top:15px;">
                <div class="ul-painel-aviso-icone"><i class="bi bi-calendar"></i></div>
                <div class="ul-painel-aviso-texto"><p>A sua conta aguarda aprovação da equipa QNB.</p></div>
            </div>
            <?php elseif($imobiliaria->estado === 'aprovada' && !$plano): ?>
            <div class="ul-painel-aviso" style="margin-top:15px;">
                <div class="ul-painel-aviso-icone"><i class="bi bi-star"></i></div>
                <div class="ul-painel-aviso-texto"><p><a href="<?php echo e(route('painel.ativar-plano')); ?>">Ative o seu plano</a> para começar a publicar imóveis.</p></div>
            </div>
            <?php endif; ?>
        </div>

        <!-- Plano -->
        <?php if($plano): ?>
        <div class="ul-painel-card" style="margin-top:15px;">
            <h3 class="ul-painel-card-titulo">Plano Ativo</h3>
            <div class="ul-painel-grid-dados">
                <div class="ul-painel-dado"><span class="ul-painel-dado-rotulo">Tipo</span><span class="ul-painel-dado-valor"><?php echo e($plano->plano->nome); ?></span></div>
                <div class="ul-painel-dado"><span class="ul-painel-dado-rotulo">Posts</span><span class="ul-painel-dado-valor"><?php echo e($plano->posts_usados); ?> / <?php echo e($plano->plano->posts_limite); ?></span></div>
                <div class="ul-painel-dado"><span class="ul-painel-dado-rotulo">Validade</span><span class="ul-painel-dado-valor"><?php echo e($plano->data_expiracao ? $plano->data_expiracao->format('d/m/Y') : 'Indefinida'); ?></span></div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Atalhos -->
        <div class="ul-painel-card" style="margin-top:15px;">
            <h3 class="ul-painel-card-titulo">Configurações</h3>
            <div class="ul-painel-contactos">
                <a href="<?php echo e(route('painel.perfil.canais')); ?>" class="ul-painel-contacto">
                    <div class="ul-painel-contacto-icone"><i class="bi bi-diagram-3"></i></div>
                    <span>Canais de Contacto</span>
                </a>
                <a href="<?php echo e(route('painel.perfil.password')); ?>" class="ul-painel-contacto">
                    <div class="ul-painel-contacto-icone"><i class="bi bi-key"></i></div>
                    <span>Alterar Password</span>
                </a>
            </div>
        </div>
    </div>
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
                img.className = 'ul-painel-foto-preview';
                img.id = 'fotoPreview';
                preview.replaceWith(img);
            }
        };
        reader.readAsDataURL(file);
    }
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.painel', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\JORGE DANGE\Documents\PROGRAMACAO\WEB\QND\PageWeb\imobiliaria\qnb-imobiliaria\resources\views\painel\perfil.blade.php ENDPATH**/ ?>