@extends('cliente.layout')

@section('cliente-content')
<div class="notificacoes-page">
    <div class="page-header">
        <h1><i class="bi bi-bell me-2"></i>Notificações</h1>
        @if($naoLidas > 0)
        <form action="{{ route('cliente.notificacoes.ler-todas') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-sm btn-outline-primary">
                <i class="bi bi-check2-all me-1"></i>Marcar todas como lidas
            </button>
        </form>
        @endif
    </div>

    @if($notificacoes->isEmpty())
    <div class="empty-state">
        <i class="bi bi-bell-slash bi-3x mb-3 opacity-50"></i>
        <h3>Sem notificações</h3>
        <p>Não recebeu nenhuma notificação ainda.</p>
    </div>
    @else
    <div class="notificacoes-lista">
        @foreach($notificacoes as $notificacao)
        <div class="notificacao-item {{ $notificacao->lida ? 'lida' : 'nao-lida' }}">
            <div class="notificacao-icon">
                @if($notificacao->tipo === 'visita')
                <i class="bi bi-calendar-check"></i>
                @elseif($notificacao->tipo === 'mensagem')
                <i class="bi bi-envelope"></i>
                @elseif($notificacao->tipo === 'avaliacao')
                <i class="bi bi-star"></i>
                @elseif($notificacao->tipo === 'denuncia')
                <i class="bi bi-flag"></i>
                @else
                <i class="bi bi-info-circle"></i>
                @endif
            </div>
            <div class="notificacao-corpo">
                <div class="notificacao-titulo">
                    {{ $notificacao->titulo }}
                    @if(!$notificacao->lida)
                    <span class="badge bg-primary ms-1">Nova</span>
                    @endif
                </div>
                <div class="notificacao-mensagem">{{ $notificacao->mensagem }}</div>
                <div class="notificacao-data">{{ $notificacao->created_at->format('d/m/Y H:i') }}</div>
            </div>
            <div class="notificacao-acoes">
                @if($notificacao->url)
                <a href="{{ $notificacao->url }}" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-arrow-right"></i>
                </a>
                @endif
                @if(!$notificacao->lida)
                <form action="{{ route('cliente.notificacoes.ler', $notificacao->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-primary" title="Marcar como lida">
                        <i class="bi bi-check-lg"></i>
                    </button>
                </form>
                @endif
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection
