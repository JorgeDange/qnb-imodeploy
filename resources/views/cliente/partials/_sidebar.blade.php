@if(Auth::guard('cliente')->check())
    @php $user = Auth::guard('cliente')->user(); @endphp
    <div class="cliente-sidebar">
        <div class="sidebar-user">
            <div class="user-avatar">
                @if($user->foto)
                <img src="{{ str_starts_with($user->foto, 'assets/') ? asset($user->foto) : asset('storage/' . $user->foto) }}" alt="{{ $user->nome }}">
                @else
                @php
                    $nome = trim($user->nome);
                    $palavras = explode(' ', $nome);
                    $primeiro = strtoupper(mb_substr($palavras[0], 0, 1));
                    $ultimo = strtoupper(mb_substr(end($palavras), -1, 1));
                @endphp
                <div class="avatar-initials">{{ $primeiro }}{{ $ultimo }}</div>
                @endif
            </div>
            <div class="user-info">
                <h4>{{ $user->nome }}</h4>
                <small>{{ $user->email }}</small>
            </div>
        </div>
        
        <nav class="sidebar-nav">
            <ul>
                <li>
                    <a href="{{ route('cliente.dashboard') }}">
                        <i class="bi bi-speedometer2"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('cliente.perfil') }}">
                        <i class="bi bi-person-circle"></i>
                        <span>Perfil</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('cliente.favoritos') }}">
                        <i class="bi bi-heart"></i>
                        <span>Favoritos</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('cliente.mensagens') }}">
                        <i class="bi bi-envelope"></i>
                        <span>Mensagens</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('cliente.visitas') }}">
                        <i class="bi bi-calendar-event"></i>
                        <span>Visitas</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('cliente.pesquisas') }}">
                        <i class="bi bi-search"></i>
                        <span>Pesquisas</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('cliente.notificacoes') }}">
                        <i class="bi bi-bell"></i>
                        <span>Notificações</span>
                        @php $notificacoesNaoLidas = \App\Models\ClienteNotificacao::where('cliente_id', $user->id)->where('lida', false)->count(); @endphp
                        @if($notificacoesNaoLidas > 0)
                        <span class="badge bg-danger ms-auto">{{ $notificacoesNaoLidas }}</span>
                        @endif
                    </a>
                </li>
            </ul>
        </nav>
        
        <div class="sidebar-footer">
            <a href="{{ route('cliente.logout') }}" class="sidebar-logout">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sair</span>
            </a>
        </div>
    </div>
@endif