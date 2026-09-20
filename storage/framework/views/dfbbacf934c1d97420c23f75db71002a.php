<?php $__env->startSection('cliente-content'); ?>
<div class="dashboard-container">
    <div class="dashboard-header">
        <h1>Bem-vindo, <?php echo e(Auth::guard('cliente')->user()->nome); ?></h1>
        <small>Área do Cliente - QNB Imobiliária</small>
    </div>
    
    <div class="dashboard-grid">
        <!-- Favoritos -->
        <div class="dashboard-card favoritos-card">
            <div class="card-header">
                <h3><i class="bi bi-heart"></i> Favoritos</h3>
            </div>
            <div class="card-body">
                <p>Imóveis que marcou como favorito</p>
                <a href="<?php echo e(route('cliente.favoritos')); ?>" class="btn-ver-todos">Ver todos</a>
            </div>
        </div>
        
        <!-- Mensagens -->
        <div class="dashboard-card mensagens-card">
            <div class="card-header">
                <h3><i class="bi bi-envelope"></i> Mensagens</h3>
            </div>
            <div class="card-body">
                <p>Mensagens recebidas de imobiliárias</p>
                <a href="<?php echo e(route('cliente.mensagens')); ?>" class="btn-ver-todos">Ver todas</a>
            </div>
        </div>
        
        <!-- Agendar Visita -->
        <div class="dashboard-card visitas-card">
            <div class="card-header">
                <h3><i class="bi bi-calendar"></i> Agendar Visita</h3>
            </div>
            <div class="card-body">
                <p>Agende uma visita aos seus imóveis favoritos</p>
                <a href="<?php echo e(route('cliente.visitas')); ?>" class="btn-ver-todos">Agendar visita</a>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('cliente.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\JORGE DANGE\Documents\PROGRAMACAO\WEB\QND\PageWeb\imobiliaria\qnb-imobiliaria\resources\views\cliente\dashboard.blade.php ENDPATH**/ ?>