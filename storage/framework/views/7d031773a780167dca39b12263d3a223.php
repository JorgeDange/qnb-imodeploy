<?php $__env->startSection('title', 'Relatórios - Admin'); ?>
<?php $__env->startSection('pageTitle', 'Relatórios'); ?>

<?php $__env->startSection('content'); ?>
<div class="ul-painel-head">
    <h2 class="ul-painel-card-titulo">Relatórios</h2>
</div>

<div class="row">
    <!-- imóveis por estado -->
    <div class="col-md-6">
        <div class="ul-painel-card">
            <div class="ul-painel-head">
                <h3 class="ul-painel-card-titulo">Imóveis por Estado</h3>
            </div>
            <?php if(isset($imoveisPorEstado) && count($imoveisPorEstado)): ?>
                <?php $__currentLoopData = $imoveisPorEstado; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="ul-painel-imovel">
                    <div class="ul-painel-imovel-info">
                        <span class="ul-painel-imovel-titulo"><?php echo e(ucfirst($item->estado)); ?></span>
                        <span class="ul-badge ul-badge--<?php echo e($item->estado); ?>"><?php echo e(ucfirst($item->estado)); ?></span>
                    </div>
                    <div class="ul-painel-imovel-acoes">
                        <span class="ul-painel-imovel-stat"><strong><?php echo e($item->total); ?></strong></span>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
                <div class="ul-painel-vazio">
                    <p>Sem dados disponíveis.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- imóveis por tipo -->
    <div class="col-md-6">
        <div class="ul-painel-card">
            <div class="ul-painel-head">
                <h3 class="ul-painel-card-titulo">Imóveis por Tipo</h3>
            </div>
            <?php if(isset($imoveisPorTipo) && count($imoveisPorTipo)): ?>
                <?php $__currentLoopData = $imoveisPorTipo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="ul-painel-imovel">
                    <div class="ul-painel-imovel-info">
                        <span class="ul-painel-imovel-titulo"><?php echo e($item->tipo); ?></span>
                    </div>
                    <div class="ul-painel-imovel-acoes">
                        <span class="ul-painel-imovel-stat"><strong><?php echo e($item->total); ?></strong></span>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
                <div class="ul-painel-vazio">
                    <p>Sem dados disponíveis.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="row">
    <!-- imóveis por província -->
    <div class="col-md-6">
        <div class="ul-painel-card">
            <div class="ul-painel-head">
                <h3 class="ul-painel-card-titulo">Imóveis por Província</h3>
            </div>
            <?php if(isset($imoveisPorProvincia) && count($imoveisPorProvincia)): ?>
                <?php $__currentLoopData = $imoveisPorProvincia; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="ul-painel-imovel">
                    <div class="ul-painel-imovel-info">
                        <span class="ul-painel-imovel-titulo"><?php echo e($item->provincia); ?></span>
                    </div>
                    <div class="ul-painel-imovel-acoes">
                        <span class="ul-painel-imovel-stat"><strong><?php echo e($item->total); ?></strong></span>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
                <div class="ul-painel-vazio">
                    <p>Sem dados disponíveis.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- imobiliárias por estado -->
    <div class="col-md-6">
        <div class="ul-painel-card">
            <div class="ul-painel-head">
                <h3 class="ul-painel-card-titulo">Imobiliárias por Estado</h3>
            </div>
            <?php if(isset($imobiliariasPorEstado) && count($imobiliariasPorEstado)): ?>
                <?php $__currentLoopData = $imobiliariasPorEstado; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="ul-painel-imovel">
                    <div class="ul-painel-imovel-info">
                        <span class="ul-painel-imovel-titulo"><?php echo e(ucfirst($item->estado)); ?></span>
                        <span class="ul-badge ul-badge--<?php echo e($item->estado === 'aprovada' ? 'aprovado' : ($item->estado === 'pendente' ? 'pendente' : 'cancelado')); ?>"><?php echo e(ucfirst($item->estado)); ?></span>
                    </div>
                    <div class="ul-painel-imovel-acoes">
                        <span class="ul-painel-imovel-stat"><strong><?php echo e($item->total); ?></strong></span>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
                <div class="ul-painel-vazio">
                    <p>Sem dados disponíveis.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- mensagens por mês -->
<div class="ul-painel-card">
    <div class="ul-painel-head">
        <h3 class="ul-painel-card-titulo">Mensagens por Mês</h3>
    </div>
    <?php if(isset($mensagensPorMes) && count($mensagensPorMes)): ?>
        <?php $__currentLoopData = $mensagensPorMes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="ul-painel-imovel">
            <div class="ul-painel-imovel-info">
                <span class="ul-painel-imovel-titulo"><?php echo e($item->mes); ?></span>
            </div>
            <div class="ul-painel-imovel-acoes">
                <span class="ul-painel-imovel-stat"><strong><?php echo e($item->total); ?></strong></span>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php else: ?>
        <div class="ul-painel-vazio">
            <p>Sem dados disponíveis.</p>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\JORGE DANGE\Documents\PROGRAMACAO\WEB\QND\PageWeb\imobiliaria\qnb-imobiliaria\resources\views\admin\relatorios\index.blade.php ENDPATH**/ ?>