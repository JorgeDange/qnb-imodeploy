<?php $__env->startSection('title', 'Configurações — Admin | QNB-Imobiliária'); ?>
<?php $__env->startSection('pageTitle', 'Configurações do Site'); ?>

<?php $__env->startSection('content'); ?>
<div class="ul-painel-card">
    <h3 class="ul-painel-card-titulo">Informações do Site</h3>

    <form action="<?php echo e(route('admin.settings.salvar')); ?>" method="POST" class="ul-painel-form">
        <?php echo csrf_field(); ?>
        <div class="ul-painel-form-seccao">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nome do Site</label>
                        <input type="text" name="site_nome" value="<?php echo e(old('site_nome', $settings->get('site_nome'))); ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Email Principal</label>
                        <input type="email" name="email_principal" value="<?php echo e(old('email_principal', $settings->get('email_principal'))); ?>">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Telefone Principal</label>
                        <input type="text" name="telefone_principal" value="<?php echo e(old('telefone_principal', $settings->get('telefone_principal'))); ?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>WhatsApp</label>
                        <input type="text" name="whatsapp" value="<?php echo e(old('whatsapp', $settings->get('whatsapp'))); ?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Endereço</label>
                        <input type="text" name="endereco" value="<?php echo e(old('endereco', $settings->get('endereco'))); ?>">
                    </div>
                </div>
            </div>
        </div>

        <div class="ul-painel-form-seccao">
            <h3>Redes Sociais</h3>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Facebook</label>
                        <input type="url" name="facebook" value="<?php echo e(old('facebook', $settings->get('facebook'))); ?>" placeholder="https://facebook.com/...">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Instagram</label>
                        <input type="url" name="instagram" value="<?php echo e(old('instagram', $settings->get('instagram'))); ?>" placeholder="https://instagram.com/...">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>LinkedIn</label>
                        <input type="url" name="linkedin" value="<?php echo e(old('linkedin', $settings->get('linkedin'))); ?>" placeholder="https://linkedin.com/...">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>YouTube</label>
                        <input type="url" name="youtube" value="<?php echo e(old('youtube', $settings->get('youtube'))); ?>" placeholder="https://youtube.com/...">
                    </div>
                </div>
            </div>
        </div>

        <button type="submit" class="ul-btn">Salvar Configurações</button>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\JORGE DANGE\Documents\PROGRAMACAO\WEB\QND\PageWeb\imobiliaria\qnb-imobiliaria\resources\views/admin/conteudo/settings.blade.php ENDPATH**/ ?>