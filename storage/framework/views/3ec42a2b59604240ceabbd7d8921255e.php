<?php if(Auth::guard('cliente')->check()): ?>
    <?php $user = Auth::guard('cliente')->user(); ?>
    <div class="cliente-sidebar">
        <div class="sidebar-user">
            <div class="user-avatar">
                <?php if($user->foto): ?>
                <img src="<?php echo e(str_starts_with($user->foto, 'assets/') ? asset($user->foto) : asset('storage/' . $user->foto)); ?>" alt="<?php echo e($user->nome); ?>">
                <?php else: ?>
                <?php
                    $nome = trim($user->nome);
                    $palavras = explode(' ', $nome);
                    $primeiro = strtoupper(mb_substr($palavras[0], 0, 1));
                    $ultimo = strtoupper(mb_substr(end($palavras), -1, 1));
                ?>
                <div class="avatar-initials"><?php echo e($primeiro); ?><?php echo e($ultimo); ?></div>
                <?php endif; ?>
            </div>
            <div class="user-info">
                <h4><?php echo e($user->nome); ?></h4>
                <small><?php echo e($user->email); ?></small>
            </div>
        </div>
        
        <nav class="sidebar-nav">
            <ul>
                <li>
                    <a href="<?php echo e(route('cliente.dashboard')); ?>">
                        <i class="bi bi-speedometer2"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo e(route('cliente.perfil')); ?>">
                        <i class="bi bi-person-circle"></i>
                        <span>Perfil</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo e(route('cliente.favoritos')); ?>">
                        <i class="bi bi-heart"></i>
                        <span>Favoritos</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo e(route('cliente.mensagens')); ?>">
                        <i class="bi bi-envelope"></i>
                        <span>Mensagens</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo e(route('cliente.visitas')); ?>">
                        <i class="bi bi-calendar-event"></i>
                        <span>Visitas</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo e(route('cliente.pesquisas')); ?>">
                        <i class="bi bi-search"></i>
                        <span>Pesquisas</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo e(route('cliente.notificacoes')); ?>">
                        <i class="bi bi-bell"></i>
                        <span>Notificações</span>
                        <?php $notificacoesNaoLidas = \App\Models\ClienteNotificacao::where('cliente_id', $user->id)->where('lida', false)->count(); ?>
                        <?php if($notificacoesNaoLidas > 0): ?>
                        <span class="badge bg-danger ms-auto"><?php echo e($notificacoesNaoLidas); ?></span>
                        <?php endif; ?>
                    </a>
                </li>
            </ul>
        </nav>
        
        <div class="sidebar-footer">
            <a href="<?php echo e(route('cliente.logout')); ?>" class="sidebar-logout">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sair</span>
            </a>
        </div>
    </div>
<?php endif; ?><?php /**PATH C:\Users\JORGE DANGE\Documents\PROGRAMACAO\WEB\QND\PageWeb\imobiliaria\qnb-imobiliaria\resources\views/cliente/partials/_sidebar.blade.php ENDPATH**/ ?>