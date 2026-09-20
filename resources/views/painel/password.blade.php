@extends('layouts.painel')

@section('title', 'Alterar Password — Painel')

@section('content')
<div class="ul-painel-cabecalho">
    <h1 class="ul-painel-titulo">Alterar Palavra-passe</h1>
    <a href="{{ route('painel.perfil') }}" class="ul-painel-btn ul-painel-btn--cinza"><i class="bi bi-arrow-left"></i> Voltar</a>
</div>

<div class="ul-painel-card" style="max-width:500px;">
    <form action="{{ route('painel.perfil.password.salvar') }}" method="POST" class="ul-painel-form">
        @csrf
        <div class="form-group">
            <label for="password_atual">Palavra-passe atual</label>
            <input type="password" name="password_atual" id="password_atual" required>
            @error('password_atual')
                <small style="color:#dc3545;">{{ $message }}</small>
            @enderror
        </div>
        <div class="form-group">
            <label for="password">Nova palavra-passe</label>
            <input type="password" name="password" id="password" required minlength="6">
            @error('password')
                <small style="color:#dc3545;">{{ $message }}</small>
            @enderror
        </div>
        <div class="form-group">
            <label for="password_confirmation">Confirmar nova palavra-passe</label>
            <input type="password" name="password_confirmation" id="password_confirmation" required minlength="6">
        </div>
        <button type="submit" class="ul-painel-btn ul-painel-btn--primario">Alterar Palavra-passe</button>
    </form>
</div>
@endsection
