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
            @include('cliente.partials._sidebar')
            <div class="cliente-content">
                @yield('cliente-content')
            </div>
        </div>
    </div>
</div>
@endsection
