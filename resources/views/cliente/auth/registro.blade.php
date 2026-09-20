@extends('layouts.site')

@section('title', 'Registo - Área do Cliente - QNB Imobiliária')
@section('pagina', 'cliente')

@section('content')
<!-- BREADCRUMB SECTION -->
<div class="ul-breadcrumb">
    <div class="wow animate__fadeInUp">
        <h2 class="ul-breadcrumb-title">Área do Cliente</h2>
        <div class="ul-breadcrumb-nav">
            <a href="{{ route('home') }}">Início</a>
            <span class="separator"><i class="bi bi-chevron-left"></i></span>
            <span class="current-page">Registo</span>
        </div>
    </div>
</div>

<div class="ul-inner-page-content-wrapper">
    <div class="ul-inner-page-container">
        <div class="ul-auth-wrapper">
            <div class="ul-auth-card">
                <h2 class="ul-auth-title">Registo de conta</h2>
                <p class="ul-auth-descr">Crie a sua conta cliente gratuitamente</p>

                @if(session('error'))
                <div class="ul-auth-note">{{ session('error') }}</div>
                @endif

                @if($errors->any())
                <div class="ul-auth-note">
                    @foreach($errors->all() as $error)
                    <p style="margin:0;">{{ $error }}</p>
                    @endforeach
                </div>
                @endif

                <form class="ul-auth-form" method="POST" action="{{ route('cliente.registo') }}">
                    @csrf

                    <div class="form-group">
                        <label for="nome">Nome completo</label>
                        <input type="text" name="nome" id="nome" placeholder="O seu nome completo" value="{{ old('nome') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="email">E-mail</label>
                        <input type="email" name="email" id="email" placeholder="O seu email" value="{{ old('email') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="telefone">Telefone</label>
                        <input type="tel" name="telefone" id="telefone" placeholder="Ex: 923 456 789" value="{{ old('telefone') }}">
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" placeholder="Mínimo 8 caracteres" required>
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Confirmar password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Repita a password" required>
                    </div>

                    <button type="submit" class="ul-btn w-100">Criar conta</button>
                </form>

                <p class="ul-auth-alt">Já tem uma conta? <a href="{{ route('cliente.login') }}">Faça login</a></p>
            </div>
        </div>
    </div>
</div>
@endsection
