<?php $__env->startSection('cliente-content'); ?>
<div class="favoritos-page">
    <div class="page-header">
        <h1><i class="bi bi-heart me-2"></i>Meus Favoritos</h1>
    </div>
    
    <?php if($favoritos->isEmpty()): ?>
    <div class="empty-state">
        <i class="bi bi-heartbreak bi-3x mb-3 opacity-50"></i>
        <h3>Nenhum imóvel nos favoritos</h3>
        <p>Não tem nenhum imóvel marcado como favorito ainda.</p>
        <a href="<?php echo e(route('imoveis.index')); ?>" class="btn btn-primary">Ver Imóveis</a>
    </div>
    <?php else: ?>
    <div class="favoritos-grid">
        <?php $__currentLoopData = $favoritos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $favorito): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="favorito-card">
            <div class="favorito-img">
                <?php $capa = $favorito->imovel->capaFoto(); ?>
                <?php if($capa): ?>
                    <img src="<?php echo e(asset('storage/' . $capa->caminho)); ?>" alt="<?php echo e($favorito->imovel->titulo); ?>">
                <?php else: ?>
                    <img src="<?php echo e(asset('assets/img/property-1.jpg')); ?>" alt="<?php echo e($favorito->imovel->titulo); ?>">
                <?php endif; ?>
            </div>
            <div class="favorito-info">
                <h3><a href="<?php echo e(route('imoveis.show', $favorito->imovel->referencia)); ?>"><?php echo e(substr($favorito->imovel->titulo, 0, 50)); ?></a></h3>
                <div class="favorito-preco">
                    <span class="price"><?php echo e(number_format($favorito->imovel->preco, 0, ',', ' ')); ?> Kz</span>
                    <span class="type"><?php echo e($favorito->imovel->tipo); ?></span>
                </div>
                <div class="favorito-location">
                    <i class="bi bi-geo-alt me-1"></i><?php echo e(substr($favorito->imovel->localizacao, 0, 30)); ?>

                </div>
            </div>
            <div class="favorito-actions">
                <form id="fav-form-<?php echo e($favorito->imovel->id); ?>" action="<?php echo e(route('cliente.favoritos.destroy', $favorito->imovel->id)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="button" class="btn-remover-favorito" onclick="modalPerigo('Remover Favorito', 'Tem certeza que deseja remover este imóvel dos favoritos?', function(){ document.getElementById('fav-form-<?php echo e($favorito->imovel->id); ?>').submit(); })">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </form>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('cliente.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\JORGE DANGE\Documents\PROGRAMACAO\WEB\QND\PageWeb\imobiliaria\qnb-imobiliaria\resources\views\cliente\favoritos.blade.php ENDPATH**/ ?>