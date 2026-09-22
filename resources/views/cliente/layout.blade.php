@extends('layouts.site')

@section('title', 'Área do Cliente - QNB Imobiliária')
@section('pagina', 'cliente')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/cliente.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('assets/js/cliente.js') }}"></script>
@endpush

@section('content')
<!-- BREADCRUMB -->
<div class="ul-breadcrumb">
    <div class="wow animate__fadeInUp">
        <h2 class="ul-breadcrumb-title">Área do Cliente</h2>
        <div class="ul-breadcrumb-nav">
            <a href="{{ route('home') }}">Início</a>
            <span class="separator"><i class="bi bi-chevron-left"></i></span>
            <span class="current-page">Painel</span>
        </div>
    </div>
</div>

<div class="ul-inner-page-content-wrapper">
    <div class="ul-inner-page-container">
        @include('cliente.flash_messages')
        <div class="cliente-layout">
            <!-- Hamburger (mobile) -->
            <button class="cliente-sidebar-toggle" aria-label="Menu">
                <i class="bi bi-list"></i> Menu
            </button>
            <!-- Overlay (mobile) -->
            <div class="cliente-sidebar-overlay"></div>
            @include('cliente.partials._sidebar')
            <div class="cliente-content">
                @yield('cliente-content')
            </div>
        </div>
    </div>
</div>

<!-- BOTTOM NAV (mobile) -->
<nav class="cliente-bottomnav">
    <a href="{{ route('cliente.dashboard') }}" class="cliente-bottomnav-item">
        <i class="bi bi-house-door"></i>
        <span>Início</span>
    </a>
    <a href="{{ route('cliente.favoritos') }}" class="cliente-bottomnav-item">
        <i class="bi bi-heart"></i>
        <span>Favoritos</span>
    </a>
    <a href="{{ route('cliente.mensagens') }}" class="cliente-bottomnav-item">
        <i class="bi bi-envelope"></i>
        <span>Msgs</span>
    </a>
    <a href="{{ route('cliente.visitas') }}" class="cliente-bottomnav-item">
        <i class="bi bi-calendar-check"></i>
        <span>Visitas</span>
    </a>
    <a href="{{ route('cliente.perfil') }}" class="cliente-bottomnav-item">
        <i class="bi bi-person-circle"></i>
        <span>Perfil</span>
    </a>
</nav>
@endsection
