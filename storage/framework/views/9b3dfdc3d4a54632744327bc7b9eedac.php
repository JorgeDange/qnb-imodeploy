<?php $__env->startSection('title', 'Planos — Admin'); ?>

<?php $__env->startSection('content'); ?>
<div class="ul-painel-cabecalho">
    <h1 class="ul-painel-titulo">Planos de Publicação</h1>
    <a href="<?php echo e(route('admin.planos.novo')); ?>" class="ul-painel-btn ul-painel-btn--primario">
        <i class="bi bi-plus-lg"></i> Novo Plano
    </a>
</div>

<div class="ul-painel-tabela-wrap">
    <table class="ul-painel-tabela">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Preço</th>
                <th>Posts</th>
                <th>Duração</th>
                <th>Subscrições</th>
                <th>Estado</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $planos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plano): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td>
                    <strong><?php echo e($plano->nome); ?></strong>
                    <?php if($plano->destaque): ?>
                        <span class="ul-badge ul-badge--destaque">Destaque</span>
                    <?php endif; ?>
                    <?php if($plano->descricao): ?>
                        <br><small style="color:#888;"><?php echo e(Str::limit($plano->descricao, 60)); ?></small>
                    <?php endif; ?>
                </td>
                <td>
                    <strong><?php echo e(number_format($plano->preco, 0, ',', '.')); ?></strong>
                    <small><?php echo e($plano->moeda); ?></small>
                </td>
                <td><?php echo e($plano->posts_limite); ?></td>
                <td><?php echo e($plano->dias_validade); ?> dias</td>
                <td><?php echo e($plano->imobiliarias_count); ?></td>
                <td>
                    <form action="<?php echo e(route('admin.planos.toggle', $plano)); ?>" method="POST" style="display:inline;">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="ul-badge <?php echo e($plano->ativo ? 'ul-badge--sucesso' : 'ul-badge--cinza'); ?>" style="cursor:pointer;border:none;">
                            <?php echo e($plano->ativo ? 'Ativo' : 'Inativo'); ?>

                        </button>
                    </form>
                </td>
                <td>
                    <div class="ul-painel-imovel-acoes" style="display:inline-flex;gap:6px;align-items:center;">
                        <a href="<?php echo e(route('admin.planos.editar', $plano)); ?>" class="ul-painel-btn ul-painel-btn--pequeno" title="Editar">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        <form id="plano-del-<?php echo e($plano->id); ?>" action="<?php echo e(route('admin.planos.apagar', $plano)); ?>" method="POST" style="display:inline;">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="button" class="ul-painel-btn ul-painel-btn--perigo ul-painel-btn--pequeno" title="Apagar" onclick="modalPerigo('Apagar Plano', 'Tem certeza que deseja apagar este plano?', function(){ document.getElementById('plano-del-<?php echo e($plano->id); ?>').submit(); })">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="7" style="text-align:center;padding:40px;color:#888;">Nenhum plano encontrado.</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\JORGE DANGE\Documents\PROGRAMACAO\WEB\QND\PageWeb\imobiliaria\qnb-imobiliaria\resources\views/admin/planos/index.blade.php ENDPATH**/ ?>