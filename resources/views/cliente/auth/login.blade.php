@extends('layouts.site')

@section('title', 'Área do Cliente - QNB Imobiliária')
@section('pagina', 'cliente')

@section('content')
<!-- BREADCRUMB SECTION -->
<div class="ul-breadcrumb">
    <div class="wow animate__fadeInUp">
        <h2 class="ul-breadcrumb-title">Área do Cliente</h2>
        <div class="ul-breadcrumb-nav">
            <a href="{{ route('home') }}">Início</a>
            <span class="separator"><i class="bi bi-chevron-left"></i></span>
            <span class="current-page">Login</span>
        </div>
    </div>
</div>

<div class="ul-inner-page-content-wrapper">
    <div class="ul-inner-page-container">
        <div class="ul-auth-wrapper">
            <div class="ul-auth-card">
                <h2 class="ul-auth-title">Bem-vindo de volta</h2>
                <p class="ul-auth-descr">Faça login para aceder à sua Área do Cliente</p>

                @if(session('error'))
                <div class="ul-auth-note">{{ session('error') }}</div>
                @endif

                @if(session('sucesso'))
                <div class="ul-auth-note" style="background-color:#E8F5E9;border-left-color:#2E7D32;">{{ session('sucesso') }}</div>
                @endif

                @if($errors->any())
                <div class="ul-auth-note">
                    @foreach($errors->all() as $error)
                    <p style="margin:0;">{{ $error }}</p>
                    @endforeach
                </div>
                @endif

                <form class="ul-auth-form" method="POST" action="{{ route('cliente.login') }}">
                    @csrf

                    <div class="form-group">
                        <label for="email">E-mail</label>
                        <input type="email" name="email" id="email" placeholder="O seu email" value="{{ old('email') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" placeholder="A sua palavra-passe" required>
                    </div>

                    <div class="form-group">
                        <label class="ul-checkbox">
                            <input type="checkbox" name="remember" id="remember">
                            Manter sessão aberta
                        </label>
                    </div>

                    <button type="submit" class="ul-btn w-100">Entrar</button>
                </form>

                <p class="ul-auth-alt">Não tem uma conta? <a href="{{ route('cliente.registo') }}">Registe-se</a></p>
            </div>
        </div>
    </div>
</div>
@endsection
