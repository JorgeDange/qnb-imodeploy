<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Painel - QNB-Imobiliária')</title>

    <!-- libraries CSS -->
    <link rel="stylesheet" href="{{ asset('assets/icon/flaticon_real_estate.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/animate-wow/animate.min.css') }}">

    <!-- custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('painel-assets/css/painel.css') }}">
    <link rel="icon" type="image/svg+xml" href="{{ asset('assets/img/logo-c.svg') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    @stack('styles')
</head>

<body data-pagina="painel">
    <div class="preloader" id="preloader">
        <div class="loader"></div>
    </div>

    <div class="ul-painel">

        <!-- TOPBAR -->
        <div class="ul-painel-topbar">
            <div class="ul-painel-topbar-left">
                <a href="{{ route('home') }}"><img src="{{ asset('assets/img/logo.svg') }}" alt="QNB-Imobiliária" class="logo"></a>
            </div>
            <div class="ul-painel-topbar-right">
                <button class="ul-painel-sidebar-toggle" aria-label="Menu">
                    <i class="bi bi-list"></i>
                </button>
                <span class="ul-badge-estado">{{ ucfirst(Auth::guard('imobiliaria')->user()->estado) }}</span>
                <a href="{{ route('home') }}" class="ul-painel-ver-site">Ver site público</a>
            </div>
        </div>

        <div class="ul-painel-corpo">

            <!-- SIDEBAR -->
            <aside class="ul-painel-sidebar">
                <button class="ul-painel-sidebar-fechar" aria-label="Fechar menu">
                    <i class="bi bi-x-lg"></i>
                </button>
                <div class="ul-painel-sidebar-perfil">
                    <div class="ul-painel-avatar">
                        @php $imob = Auth::guard('imobiliaria')->user(); @endphp
                        @if($imob->foto)
                            <img src="{{ str_starts_with($imob->foto, 'assets/') ? asset($imob->foto) : asset('storage/' . $imob->foto) }}" alt="{{ $imob->nome }}">
                        @else
                            <img src="{{ asset('assets/img/logo-c.svg') }}" alt="{{ $imob->nome }}">
                        @endif
                    </div>
                    <h3 class="ul-painel-nome">{{ $imob->nome }}</h3>
                    <span class="ul-painel-email">{{ $imob->email }}</span>
                </div>
                <ul class="ul-painel-nav">
                    <li class="{{ request()->routeIs('painel.dashboard') ? 'active' : '' }}">
                        <a href="{{ route('painel.dashboard') }}"><i class="bi bi-speedometer2"></i> Dashboard</a>
                    </li>

                    {{-- ═══ GESTÃO ═══ --}}
                    <li class="ul-painel-nav-seccao">GESTÃO</li>

                    <li class="{{ request()->routeIs('painel.imoveis*') ? 'active' : '' }}">
                        <a href="{{ route('painel.imoveis') }}"><i class="bi bi-house-door"></i> Meus Imóveis
                            @if($imoveisCount > 0)<span class="ul-painel-nav-badge">{{ $imoveisCount }}</span>@endif
                        </a>
                    </li>

                    <li class="{{ request()->routeIs('painel.destaques*') ? 'active' : '' }}">
                        <a href="{{ route('painel.destaques') }}"><i class="bi bi-star"></i> Destaques
                            @if($destaquesCount > 0)<span class="ul-painel-nav-badge">{{ $destaquesCount }}</span>@endif
                        </a>
                    </li>

                    {{-- ═══ COMUNICAÇÃO ═══ --}}
                    <li class="ul-painel-nav-seccao">COMUNICAÇÃO</li>

                    <li class="{{ request()->routeIs('painel.mensagens*') ? 'active' : '' }}">
                        <a href="{{ route('painel.mensagens') }}"><i class="bi bi-envelope"></i> Mensagens
                            @if($msgsNaoLidas > 0)<span class="ul-painel-nav-badge">{{ $msgsNaoLidas }}</span>@endif
                        </a>
                    </li>

                    <li class="{{ request()->routeIs('painel.admin-mensagens*') ? 'active' : '' }}">
                        <a href="{{ route('painel.admin-mensagens') }}"><i class="bi bi-shield-lock"></i> Mensagens Admin
                        </a>
                    </li>

                    <li class="{{ request()->routeIs('painel.visitas*') ? 'active' : '' }}">
                        <a href="{{ route('painel.visitas') }}"><i class="bi bi-calendar-event"></i> Visitas
                            @if($visitasPend > 0)<span class="ul-painel-nav-badge">{{ $visitasPend }}</span>@endif
                        </a>
                    </li>

                    {{-- ═══ CONTA ═══ --}}
                    <li class="ul-painel-nav-seccao">CONTA</li>

                    <li class="{{ request()->routeIs('painel.ativar-plano') ? 'active' : '' }}">
                        <a href="{{ route('painel.ativar-plano') }}"><i class="bi bi-gem"></i> Meu Plano
                            @if(!$planoAtivo)
                                <span class="ul-painel-nav-badge ul-painel-nav-badge--perigo">!</span>
                            @elseif($planoAtivo->data_expiracao && $planoAtivo->data_expiracao->isPast())
                                <span class="ul-painel-nav-badge ul-painel-nav-badge--perigo">!</span>
                            @elseif($planoAtivo->data_expiracao && $diasRestantes <= 7)
                                <span class="ul-painel-nav-badge ul-painel-nav-badge--aviso">{{ $diasRestantes }}d</span>
                            @endif
                        </a>
                    </li>

                    <li class="{{ request()->routeIs('painel.faturas*') ? 'active' : '' }}">
                        <a href="{{ route('painel.faturas') }}"><i class="bi bi-receipt"></i> Faturas</a>
                    </li>

                    <li class="{{ request()->routeIs('painel.estatisticas*') ? 'active' : '' }}">
                        <a href="{{ route('painel.estatisticas') }}"><i class="bi bi-bar-chart"></i> Estatísticas</a>
                    </li>

                    <li class="{{ request()->routeIs('painel.perfil*') ? 'active' : '' }}">
                        <a href="{{ route('painel.perfil') }}"><i class="bi bi-person-circle"></i> Perfil</a>
                    </li>

                    <li>
                        <form action="{{ route('painel.logout') }}" method="POST" class="ul-painel-nav-form">
                            @csrf
                            <button type="submit" class="ul-painel-nav-btn">
                                <i class="bi bi-box-arrow-right"></i> Sair
                            </button>
                        </form>
                    </li>
                </ul>
            </aside>

            <!-- OVERLAY (mobile) -->
            <div class="ul-painel-sidebar-overlay"></div>

            <!-- CONTEÚDO -->
            <div class="ul-painel-conteudo">
                <div class="ul-painel-conteudo-inner">

                    @include('components.flash')

                    @yield('content')
                </div>
            </div>
        </div>

        <!-- RODAPÉ -->
        <footer class="ul-painel-rodape">
            <span>© 2026 QNB-Imobiliária. Todos os direitos reservados.</span>
            <span><a href="{{ route('home') }}">Voltar ao site</a></span>
        </footer>
    </div>

    <!-- BOTTOM NAV (mobile ≤767px) -->
    <nav class="ul-painel-bottomnav">
        <a href="{{ route('painel.dashboard') }}" class="ul-painel-bottomnav-item {{ request()->routeIs('painel.dashboard') ? 'active' : '' }}">
            <i class="bi bi-house-door"></i>
            <span>Início</span>
        </a>
        <a href="{{ route('painel.imoveis') }}" class="ul-painel-bottomnav-item {{ request()->routeIs('painel.imoveis*') ? 'active' : '' }}">
            <i class="bi bi-building"></i>
            <span>Imóveis</span>
        </a>
        <a href="{{ route('painel.mensagens') }}" class="ul-painel-bottomnav-item {{ request()->routeIs('painel.mensagens*') ? 'active' : '' }}">
            <i class="bi bi-envelope"></i>
            <span>Msgs</span>
            @if($msgsNaoLidas > 0)<span class="ul-painel-bottomnav-badge">{{ $msgsNaoLidas }}</span>@endif
        </a>
        <a href="{{ route('painel.visitas') }}" class="ul-painel-bottomnav-item {{ request()->routeIs('painel.visitas*') ? 'active' : '' }}">
            <i class="bi bi-calendar-check"></i>
            <span>Visitas</span>
            @if($visitasPend > 0)<span class="ul-painel-bottomnav-badge">{{ $visitasPend }}</span>@endif
        </a>
        <a href="{{ route('painel.perfil') }}" class="ul-painel-bottomnav-item {{ request()->routeIs('painel.perfil*') ? 'active' : '' }}">
            <i class="bi bi-person-circle"></i>
            <span>Perfil</span>
        </a>
    </nav>

    <!-- scripts -->
    <script src="{{ asset('assets/vendor/bootstrap/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/animate-wow/wow.min.js') }}"></script>
    <script src="{{ asset('painel-assets/js/painel-loader.js') }}"></script>
    <script src="{{ asset('painel-assets/js/painel.js') }}"></script>
    @include('components.modal-global')
    @stack('scripts')
</body>

</html>
