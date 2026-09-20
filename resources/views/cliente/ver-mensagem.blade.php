@extends('cliente.layout')

@section('cliente-content')
<div class="ver-mensagem-page">
    <div class="page-header">
        <h1><i class="bi bi-envelope me-2"></i>Mensagem</h1>
        <a href="{{ route('cliente.mensagens') }}" class="btn-voltar">Voltar</a>
    </div>
    
    @if($mensagem)
    <div class="mensagem-detalhe">
        <div class="mensagem-autor">
            <div class="autor-info">
                <h3>{{ $mensagem->nome }}</h3>
                <p><i class="bi bi-envelope"></i> {{ $mensagem->contacto }}</p>
                <p><small>{{ $mensagem->created_at ? $mensagem->created_at->format('d/m/Y H:i') : '—' }}</small></p>
            </div>
            @if($mensagem->origem)
            <span class="origem-badge {{ $mensagem->origem }}">{{ ucfirst($mensagem->origem) }}</span>
            @endif
        </div>
        
        <div class="mensagem-texto">
            <p>{{ nl2br($mensagem->texto) }}</p>
        </div>
        
        @if(auth()->guard('cliente')->user()->id === $mensagem->cliente_id || auth()->guard('admin')->check())
        <div class="acao-responder">
            <form method="POST" action="{{ route('cliente.mensagens.responder', $mensagem->id) }}">
                @csrf
                <div class="form-group">
                    <textarea name="texto" rows="3" placeholder="Sua resposta..." class="form-control" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary mt-3">Enviar resposta</button>
            </form>
        </div>
        @endif
    </div>
    @else
    <div class="empty-state">
        <i class="bi bi-exclamation-triangle bi-3x mb-3 opacity-50"></i>
        <h3>Mensagem não encontrada</h3>
        <p>A mensagem solicitada não existe ou não tem permissão para visualizar.</p>
        <a href="{{ route('cliente.mensagens') }}" class="btn btn-primary">Voltar</a>
    </div>
    @endif
</div>
@endsection