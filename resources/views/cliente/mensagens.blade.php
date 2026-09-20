@extends('cliente.layout')

@section('cliente-content')
<div class="mensagens-page">
    <div class="page-header">
        <h1><i class="bi bi-envelope me-2"></i>Minhas Mensagens</h1>
    </div>
    
    @if($mensagens->isEmpty())
    <div class="empty-state">
        <i class="bi bi-inbox bi-3x mb-3 opacity-50"></i>
        <h3>Sem mensagens</h3>
        <p>Não tem mensagens recebidas no momento.</p>
        <a href="{{ route('cliente.dashboard') }}" class="btn btn-primary" style="display: block; margin-top: 1rem;">Ir ao Dashboard</a>
    </div>
    @else
    <div class="mensagens-list">
        @foreach($mensagens as $mensagem)
        <div class="mensagem-item">
            <div class="mensagem-header">
                <h3>{{ substr($mensagem->nome, 0, 40) }}</h3>
                <span class="mensagem-origem {{ $mensagem->origem }}">{{ ucfirst($mensagem->origem) }}</span>
            </div>
            <p class="mensagem-texto">{{ substr(strip_tags($mensagem->texto), 0, 150) }}{{ strlen($mensagem->texto) > 150 ? '...' : '' }}</p>
            <div class="mensagem-meta">
                <span>{{ $mensagem->created_at->diffForHumans() }}</span>
                @if($mensagem->lida)
                <span class="badge bg-success ms-2">Lida</span>
                @else
                <span class="badge bg-warning text-dark ms-2">Não lida</span>
                @endif
            </div>
            <a href="{{ route('cliente.mensagens.show', $mensagem->id) }}" class="btn-ver-mais">Ver mensagem completa</a>
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection