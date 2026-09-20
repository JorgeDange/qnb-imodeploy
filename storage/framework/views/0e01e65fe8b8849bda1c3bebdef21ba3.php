
<?php if(session('success')): ?>
<div class="ul-painel-aviso ul-painel-aviso--sucesso" style="margin-bottom:20px;">
    <div class="ul-painel-aviso-icone"><i class="flaticon-check"></i></div>
    <div class="ul-painel-aviso-texto"><p><?php echo e(session('success')); ?></p></div>
</div>
<?php endif; ?>

<?php if(session('warning')): ?>
<div class="ul-painel-aviso ul-painel-aviso--aviso" style="margin-bottom:20px;">
    <div class="ul-painel-aviso-icone"><i class="flaticon-info"></i></div>
    <div class="ul-painel-aviso-texto"><p><?php echo e(session('warning')); ?></p></div>
</div>
<?php endif; ?>

<?php if(session('error')): ?>
<div class="ul-painel-aviso ul-painel-aviso--perigo" style="margin-bottom:20px;">
    <div class="ul-painel-aviso-icone"><i class="flaticon-info"></i></div>
    <div class="ul-painel-aviso-texto"><p><?php echo e(session('error')); ?></p></div>
</div>
<?php endif; ?>
<?php /**PATH C:\Users\JORGE DANGE\Documents\PROGRAMACAO\WEB\QND\PageWeb\imobiliaria\qnb-imobiliaria\resources\views/components/flash.blade.php ENDPATH**/ ?>