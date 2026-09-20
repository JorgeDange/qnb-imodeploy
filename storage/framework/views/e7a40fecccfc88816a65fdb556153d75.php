

<?php $__env->startSection('title', 'Visão Geral — Painel | QNB-Imobiliária'); ?>

<?php $__env->startSection('content'); ?>
<div class="ul-painel-head">
    <div>
        <h3 class="ul-painel-card-titulo ul-mb-4">Visão Geral</h3>
        <p class="ul-painel-card-subtitulo ul-mb-0">Acompanhe o desempenho dos seus anúncios de forma rápida.</p>
    </div>
    <a href="<?php echo e(route('painel.imoveis.novo')); ?>" class="ul-painel-btn"><i class="bi bi-house"></i> Adicionar Imóvel</a>
</div>

<!-- estatísticas -->
<div class="ul-painel-stats">
    <div class="ul-painel-stat"><span class="ul-painel-stat-numero"><?php echo e($stats['total']); ?></span><span class="ul-painel-stat-rotulo">Imóveis no total</span></div>
    <div class="ul-painel-stat"><span class="ul-painel-stat-numero"><?php echo e($stats['aprovados']); ?></span><span class="ul-painel-stat-rotulo">Aprovados</span></div>
    <div class="ul-painel-stat"><span class="ul-painel-stat-numero"><?php echo e($stats['pendentes']); ?></span><span class="ul-painel-stat-rotulo">Pendentes</span></div>
    <div class="ul-painel-stat"><span class="ul-painel-stat-numero"><?php echo e($stats['destaques']); ?></span><span class="ul-painel-stat-rotulo">Em destaque</span></div>
    <div class="ul-painel-stat"><span class="ul-painel-stat-numero"><?php echo e($stats['visualizacoes']); ?></span><span class="ul-painel-stat-rotulo">Visualizações</span></div>
    <div class="ul-painel-stat"><span class="ul-painel-stat-numero"><?php echo e($stats['contactos']); ?></span><span class="ul-painel-stat-rotulo">Contactos</span></div>
    <div class="ul-painel-stat"><span class="ul-painel-stat-numero"><?php echo e($mensagensNaoLidas); ?></span><span class="ul-painel-stat-rotulo">Mensagens não lidas</span></div>
</div>

<!-- plano ativo -->
<?php if($plano): ?>
    <?php if($plano->data_expiracao && $plano->data_expiracao->isPast()): ?>
    <div class="ul-painel-aviso ul-painel-aviso--destaque ul-painel-aviso--perigo">
        <div class="ul-painel-aviso-icone"><i class="bi bi-info-circle"></i></div>
        <div class="ul-painel-aviso-texto">
            <h4 class="ul-painel-aviso-titulo">Plano Expirado</h4>
            <p>O seu plano <?php echo e($plano->plano->nome); ?> expirou em <?php echo e($plano->data_expiracao->format('d/m/Y')); ?>. <a href="<?php echo e(route('painel.ativar-plano')); ?>">Renove agora</a>.</p>
        </div>
    </div>
    <?php elseif($plano->data_expiracao && (int) $plano->data_expiracao->diffInDays(now()) <= 7): ?>
    <div class="ul-painel-aviso ul-painel-aviso--aviso">
        <div class="ul-painel-aviso-icone"><i class="bi bi-info-circle"></i></div>
        <div class="ul-painel-aviso-texto">
            <h4 class="ul-painel-aviso-titulo">Plano a Expirar</h4>
            <p>O seu plano <?php echo e($plano->plano->nome); ?> expira em <?php echo e($plano->data_expiracao->format('d/m/Y')); ?> (<?php echo e((int) $plano->data_expiracao->diffInDays(now())); ?> dia(s)). <a href="<?php echo e(route('painel.ativar-plano')); ?>">Renove agora</a>.</p>
        </div>
    </div>
    <?php else: ?>
    <div class="ul-painel-aviso">
        <div class="ul-painel-aviso-icone"><i class="bi bi-star"></i></div>
        <div class="ul-painel-aviso-texto">
            <h4 class="ul-painel-aviso-titulo">Plano Ativo: <?php echo e($plano->plano->nome); ?></h4>
            <p>Posts: <?php echo e($plano->posts_usados); ?> / <?php echo e($plano->plano->posts_limite); ?> | Expira: <?php echo e($plano->data_expiracao ? $plano->data_expiracao->format('d/m/Y') : 'Indefinida'); ?></p>
        </div>
    </div>
    <?php endif; ?>
<?php else: ?>
<div class="ul-painel-aviso ul-painel-aviso--cinza">
    <div class="ul-painel-aviso-icone"><i class="bi bi-info-circle"></i></div>
    <div class="ul-painel-aviso-texto">
        <h4 class="ul-painel-aviso-titulo">Nenhum plano ativo</h4>
        <p><a href="<?php echo e(route('painel.ativar-plano')); ?>">Ative um plano</a> para publicar imóveis.</p>
    </div>
</div>
<?php endif; ?>

<div class="ul-painel-dash-cols">
    <!-- imóveis recentes -->
    <div class="ul-painel-card">
        <h3 class="ul-painel-card-titulo">Imóveis Recentes</h3>
        <p class="ul-painel-card-subtitulo">Os seus últimos anúncios cadastrados.</p>
        <?php if($imoveis->count()): ?>
            <?php $__currentLoopData = $imoveis->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $imovel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="ul-painel-imovel">
                <?php if($imovel->fotos->count()): ?>
                <div class="ul-painel-imovel-foto"><img src="<?php echo e(asset('storage/' . $imovel->fotos->first()->caminho)); ?>" alt="<?php echo e($imovel->titulo); ?>"></div>
                <?php endif; ?>
                <div class="ul-painel-imovel-info">
                    <h4 class="ul-painel-imovel-titulo"><?php echo e($imovel->titulo); ?></h4>
                    <span class="ul-painel-imovel-ref">Ref: <?php echo e($imovel->referencia); ?></span>
                    <span class="ul-painel-imovel-local"><?php echo e($imovel->bairro); ?>, <?php echo e($imovel->municipio); ?></span>
                    <span class="ul-painel-imovel-preco"><?php echo e(number_format($imovel->preco, 0, ',', '.')); ?> <?php echo e($imovel->moeda); ?></span>
                    <div class="ul-painel-imovel-acoes">
                        <span class="ul-badge ul-badge--<?php echo e($imovel->estado); ?>"><?php echo e(ucfirst($imovel->estado)); ?></span>
                        <a href="<?php echo e(route('painel.imoveis.editar', $imovel->id)); ?>" class="ul-painel-btn ul-painel-btn--pequeno">Editar</a>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php else: ?>
        <p class="ul-painel-vazio">Nenhum imóvel cadastrado ainda.</p>
        <?php endif; ?>
    </div>

    <!-- últimas mensagens -->
    <div class="ul-painel-card">
        <h3 class="ul-painel-card-titulo">Últimas Mensagens</h3>
        <p class="ul-painel-card-subtitulo">Leads mais recentes recebidos do site.</p>
        <?php if($mensagens->count()): ?>
            <?php $__currentLoopData = $mensagens; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mensagem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="ul-painel-mensagem <?php echo e(!$mensagem->lida ? 'ul-painel-mensagem--naolida' : ''); ?>">
                <div class="ul-painel-mensagem-cab">
                    <span class="ul-painel-mensagem-nome"><?php echo e($mensagem->nome); ?></span>
                    <span class="ul-painel-mensagem-data"><?php echo e($mensagem->created_at->format('d/m/Y H:i')); ?></span>
                </div>
                <p class="ul-painel-mensagem-texto"><?php echo e(Str::limit($mensagem->texto, 100)); ?></p>
                <div class="ul-painel-mensagem-rodape">
                    <span class="ul-painel-mensagem-contacto"><i class="bi bi-envelope"></i> <?php echo e($mensagem->contacto); ?></span>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php else: ?>
        <p class="ul-painel-vazio">Nenhuma mensagem recebida.</p>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.painel', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\JORGE DANGE\Documents\PROGRAMACAO\WEB\QND\PageWeb\imobiliaria\qnb-imobiliaria\resources\views\painel\dashboard.blade.php ENDPATH**/ ?>