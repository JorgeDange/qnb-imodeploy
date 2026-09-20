<?php $__env->startSection('title', 'Visitas — Painel'); ?>

<?php $__env->startSection('content'); ?>
<div class="ul-painel-cabecalho">
    <h1 class="ul-painel-titulo">Visitas</h1>
</div>

<div class="ul-painel-stats" style="margin-bottom:20px;">
    <div class="ul-painel-stat">
        <span class="ul-painel-stat-numero"><?php echo e($estatisticas['hoje']); ?></span>
        <span class="ul-painel-stat-rotulo">Hoje</span>
    </div>
    <div class="ul-painel-stat">
        <span class="ul-painel-stat-numero"><?php echo e($estatisticas['pendente']); ?></span>
        <span class="ul-painel-stat-rotulo">Pendentes</span>
    </div>
    <div class="ul-painel-stat">
        <span class="ul-painel-stat-numero"><?php echo e($estatisticas['confirmada']); ?></span>
        <span class="ul-painel-stat-rotulo">Confirmadas</span>
    </div>
    <div class="ul-painel-stat">
        <span class="ul-painel-stat-numero"><?php echo e($estatisticas['concluida'] ?? 0); ?></span>
        <span class="ul-painel-stat-rotulo">Concluídas</span>
    </div>
</div>

<div class="ul-painel-tabela-wrap">
    <table class="ul-painel-tabela">
        <thead>
            <tr>
                <th>Imóvel</th>
                <th>Cliente</th>
                <th>Contacto</th>
                <th>Data/Hora</th>
                <th>Estado</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $visitas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $visita): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td><?php echo e($visita->imovel->titulo ?? '—'); ?></td>
                <td><?php echo e($visita->cliente_nome); ?></td>
                <td>
                    <?php if($visita->cliente_email && str_contains($visita->cliente_email, '@')): ?>
                        <a href="mailto:<?php echo e($visita->cliente_email); ?>" style="color:var(--ul-blue);text-decoration:none;"><?php echo e($visita->cliente_email); ?></a>
                    <?php elseif($visita->cliente_telefone): ?>
                        <a href="tel:<?php echo e($visita->cliente_telefone); ?>" style="color:var(--ul-blue);text-decoration:none;"><?php echo e($visita->cliente_telefone); ?></a>
                    <?php else: ?>
                        —
                    <?php endif; ?>
                </td>
                <td><?php echo e($visita->data_visita->format('d/m/Y H:i')); ?></td>
                <td>
                    <?php if($visita->estado === 'pendente'): ?>
                        <span class="ul-badge ul-badge--pendente">Pendente</span>
                    <?php elseif($visita->estado === 'confirmada'): ?>
                        <span class="ul-badge ul-badge--aprovado">Confirmada</span>
                    <?php elseif($visita->estado === 'concluida'): ?>
                        <span class="ul-badge ul-badge--aviso">Concluída</span>
                    <?php else: ?>
                        <span class="ul-badge ul-badge--rejeitado">Cancelada</span>
                    <?php endif; ?>
                </td>
                <td>
                    <div style="display:flex;gap:6px;flex-wrap:wrap;">
                        <?php if($visita->estado === 'pendente'): ?>
                            <form action="<?php echo e(route('painel.visitas.estado', $visita)); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="estado" value="confirmada">
                                <button type="submit" class="ul-painel-btn ul-painel-btn--pequeno" style="color:#10b981;" title="Aceitar"><i class="bi bi-check-lg"></i> Aceitar</button>
                            </form>
                            <button type="button" class="ul-painel-btn ul-painel-btn--perigo ul-painel-btn--pequeno" title="Recusar" onclick="abrirMotivo(<?php echo e($visita->id); ?>)"><i class="bi bi-x-lg"></i> Recusar</button>
                        <?php elseif($visita->estado === 'confirmada'): ?>
                            <form action="<?php echo e(route('painel.visitas.estado', $visita)); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="estado" value="concluida">
                                <button type="submit" class="ul-painel-btn ul-painel-btn--pequeno" style="color:#1a5276;" title="Concluir"><i class="bi bi-check-lg"></i> Concluir</button>
                            </form>
                            <button type="button" class="ul-painel-btn ul-painel-btn--perigo ul-painel-btn--pequeno" title="Cancelar" onclick="abrirMotivo(<?php echo e($visita->id); ?>)"><i class="bi bi-x-lg"></i> Cancelar</button>
                        <?php else: ?>
                            <span style="font-size:12px;color:var(--ul-gray2);">—</span>
                        <?php endif; ?>
                    </div>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="6" class="ul-painel-vazio">Nenhuma visita encontrada.</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php echo e($visitas->withQueryString()->links()); ?>


<div id="motivoModal" style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.5);z-index:9999;align-items:center;justify-content:center;">
    <div style="background:#fff;border-radius:10px;padding:30px;max-width:450px;width:90%;box-shadow:0 10px 30px rgba(0,0,0,0.3);">
        <h3 style="margin:0 0 10px;">Motivo da Recusa/Cancelamento</h3>
        <form id="motivoForm" method="POST">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="estado" value="cancelada">
            <textarea name="motivo" rows="3" class="ul-input" placeholder="Ex: Imóvel já alugado, dia indisponível..." required></textarea>
            <div style="display:flex;gap:8px;margin-top:15px;justify-content:flex-end;">
                <button type="button" class="ul-painel-btn" onclick="fecharMotivo()">Cancelar</button>
                <button type="submit" class="ul-painel-btn ul-painel-btn--perigo">Confirmar</button>
            </div>
        </form>
    </div>
</div>

<script>
function abrirMotivo(id) {
    document.getElementById('motivoForm').action = '/painel/visitas/' + id + '/estado';
    document.getElementById('motivoModal').style.display = 'flex';
}
function fecharMotivo() {
    document.getElementById('motivoModal').style.display = 'none';
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.painel', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\JORGE DANGE\Documents\PROGRAMACAO\WEB\QND\PageWeb\imobiliaria\qnb-imobiliaria\resources\views\painel\visitas.blade.php ENDPATH**/ ?>