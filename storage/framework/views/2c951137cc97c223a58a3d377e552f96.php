<?php $__env->startSection('title', 'Administradores — Admin'); ?>

<?php $__env->startSection('content'); ?>
<div class="ul-painel-cabecalho">
    <h1 class="ul-painel-titulo">Administradores</h1>
    <a href="<?php echo e(route('admin.admins.novo')); ?>" class="ul-painel-btn ul-painel-btn--primario">
        <i class="bi bi-plus-lg"></i> Novo Admin
    </a>
</div>

<div class="ul-painel-tabela-wrap">
    <table class="ul-painel-tabela">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Email</th>
                <th>Papel</th>
                <th>Último Login</th>
                <th>Estado</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $admins; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td><strong><?php echo e($a->nome); ?></strong></td>
                <td><?php echo e($a->email); ?></td>
                <td>
                    <?php
                        $roleBadge = match($a->role) {
                            'super_admin' => 'ul-badge--destaque',
                            'comercial' => 'ul-badge--sucesso',
                            'moderador' => 'ul-badge--aviso',
                            default => 'ul-badge--cinza',
                        };
                    ?>
                    <span class="ul-badge <?php echo e($roleBadge); ?>"><?php echo e($a->role); ?></span>
                </td>
                <td><?php echo e($a->ultimo_login?->diffForHumans() ?? 'Nunca'); ?></td>
                <td>
                    <form action="<?php echo e(route('admin.admins.toggle', $a)); ?>" method="POST" style="display:inline;">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="ul-badge <?php echo e($a->ativo ? 'ul-badge--sucesso' : 'ul-badge--cinza'); ?>" style="cursor:pointer;border:none;">
                            <?php echo e($a->ativo ? 'Ativo' : 'Inativo'); ?>

                        </button>
                    </form>
                </td>
                <td>
                    <div class="ul-painel-imovel-acoes" style="display:inline-flex;gap:6px;align-items:center;">
                        <a href="<?php echo e(route('admin.admins.editar', $a)); ?>" class="ul-painel-btn ul-painel-btn--pequeno" title="Editar">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        <?php if($a->id !== Auth::guard('admin')->id()): ?>
                        <form id="admin-del-<?php echo e($a->id); ?>" action="<?php echo e(route('admin.admins.apagar', $a)); ?>" method="POST" style="display:inline;">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="button" class="ul-painel-btn ul-painel-btn--perigo ul-painel-btn--pequeno" title="Apagar" onclick="modalPerigo('Apagar Administrador', 'Apagar este administrador?', function(){ document.getElementById('admin-del-<?php echo e($a->id); ?>').submit(); })">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </form>
                        <?php endif; ?>
                    </div>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="6" style="text-align:center;padding:40px;color:#888;">Nenhum administrador encontrado.</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\JORGE DANGE\Documents\PROGRAMACAO\WEB\QND\PageWeb\imobiliaria\qnb-imobiliaria\resources\views/admin/admins/index.blade.php ENDPATH**/ ?>