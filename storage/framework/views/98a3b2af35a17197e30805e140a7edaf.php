<?php $__env->startSection('title', 'Subscrições — Admin'); ?>

<?php $__env->startSection('content'); ?>
<div class="ul-painel-cabecalho">
    <h1 class="ul-painel-titulo">Subscrições</h1>
    <a href="<?php echo e(route('admin.subscricoes.nova')); ?>" class="ul-painel-btn ul-painel-btn--primario">
        <i class="bi bi-plus-lg"></i> Nova Subscrição
    </a>
</div>

<div class="ul-painel-card" style="margin-bottom:20px;">
    <form method="GET" style="display:flex;gap:12px;align-items:end;flex-wrap:wrap;">
        <div class="ul-painel-form-campo" style="margin-bottom:0;">
            <label class="ul-painel-form-label">Estado</label>
            <select name="estado" class="ul-painel-form-input">
                <option value="">Todos</option>
                <option value="ativa" <?php echo e(request('estado') === 'ativa' ? 'selected' : ''); ?>>Ativa</option>
                <option value="pendente" <?php echo e(request('estado') === 'pendente' ? 'selected' : ''); ?>>Pendente</option>
                <option value="expirada" <?php echo e(request('estado') === 'expirada' ? 'selected' : ''); ?>>Expirada</option>
                <option value="cancelada" <?php echo e(request('estado') === 'cancelada' ? 'selected' : ''); ?>>Cancelada</option>
            </select>
        </div>
        <div class="ul-painel-form-campo" style="margin-bottom:0;">
            <label class="ul-painel-form-label">Imobiliária</label>
            <select name="imobiliaria_id" class="ul-painel-form-input">
                <option value="">Todas</option>
                <?php $__currentLoopData = $imobiliarias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $imob): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($imob->id); ?>" <?php echo e(request('imobiliaria_id') == $imob->id ? 'selected' : ''); ?>><?php echo e($imob->nome); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <button type="submit" class="ul-painel-btn ul-painel-btn--cinza">Filtrar</button>
    </form>
</div>

<div class="ul-painel-tabela-wrap">
    <table class="ul-painel-tabela">
        <thead>
            <tr>
                <th>Imobiliária</th>
                <th>Plano</th>
                <th>Início</th>
                <th>Expiração</th>
                <th>Posts</th>
                <th>Estado</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $subscricoes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td><?php echo e($sub->imobiliaria->nome ?? '—'); ?></td>
                <td><?php echo e($sub->plano->nome ?? '—'); ?></td>
                <td><?php echo e($sub->data_inicio?->format('d/m/Y') ?? '—'); ?></td>
                <td>
                    <?php echo e($sub->data_expiracao?->format('d/m/Y') ?? '—'); ?>

                    <?php if($sub->data_expiracao && $sub->data_expiracao->isPast()): ?>
                        <br><small class="ul-painel-texto-perigo">Expirado</small>
                    <?php endif; ?>
                </td>
                <td><?php echo e($sub->posts_usados); ?> / <?php echo e($sub->plano->posts_limite ?? '—'); ?></td>
                <td>
                    <?php
                        $badgeClass = match($sub->estado) {
                            'ativa' => 'ul-badge--sucesso',
                            'pendente' => 'ul-badge--aviso',
                            'expirada' => 'ul-badge--cinza',
                            'cancelada' => 'ul-badge--perigo',
                            default => 'ul-badge--cinza',
                        };
                    ?>
                    <span class="ul-badge <?php echo e($badgeClass); ?>"><?php echo e(ucfirst($sub->estado)); ?></span>
                </td>
                <td>
                    <div class="ul-painel-imovel-acoes" style="display:inline-flex;gap:6px;align-items:center;">
                        <?php if($sub->estado === 'ativa' || $sub->estado === 'pendente'): ?>
                        <form action="<?php echo e(route('admin.subscricoes.renovar', $sub)); ?>" method="POST" style="display:inline;">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="ul-painel-btn ul-painel-btn--pequeno ul-painel-btn--sucesso-texto" title="Renovar">
                                <i class="bi bi-arrow-repeat"></i>
                            </button>
                        </form>
                        <form id="sub-cancel-<?php echo e($sub->id); ?>" action="<?php echo e(route('admin.subscricoes.cancelar', $sub)); ?>" method="POST" style="display:inline;">
                            <?php echo csrf_field(); ?>
                            <button type="button" class="ul-painel-btn ul-painel-btn--pequeno ul-painel-btn--aviso-texto" title="Cancelar" onclick="modalPerigo('Cancelar Subscrição', 'Cancelar esta subscrição?', function(){ document.getElementById('sub-cancel-<?php echo e($sub->id); ?>').submit(); })">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </form>
                        <?php endif; ?>
                        <a href="<?php echo e(route('admin.subscricoes.editar', $sub)); ?>" class="ul-painel-btn ul-painel-btn--pequeno" title="Editar">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        <form id="sub-del-<?php echo e($sub->id); ?>" action="<?php echo e(route('admin.subscricoes.apagar', $sub)); ?>" method="POST" style="display:inline;">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="button" class="ul-painel-btn ul-painel-btn--perigo ul-painel-btn--pequeno" title="Apagar" onclick="modalPerigo('Apagar Subscrição', 'Apagar esta subscrição?', function(){ document.getElementById('sub-del-<?php echo e($sub->id); ?>').submit(); })">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="7" style="text-align:center;padding:40px;color:#888;">Nenhuma subscrição encontrada.</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php echo e($subscricoes->withQueryString()->links()); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\JORGE DANGE\Documents\PROGRAMACAO\WEB\QND\PageWeb\imobiliaria\qnb-imobiliaria\resources\views\admin\subscricoes\index.blade.php ENDPATH**/ ?>