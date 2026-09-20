@extends('cliente.layout')

@section('cliente-content')
<div class="visitas-page">
    <div class="page-header">
        <h1><i class="bi bi-calendar me-2"></i>Minhas Visitas Agendadas</h1>
    </div>

    @if(session('sucesso'))
    <div class="alert alert-success">{{ session('sucesso') }}</div>
    @endif

    @if($visitas->isEmpty())
    <div class="empty-state">
        <i class="bi bi-calendar-week bi-3x mb-3 opacity-50"></i>
        <h3>Nenhuma visita agendada</h3>
        <p>Não tem visitas agendadas no momento.</p>
        <a href="{{ route('imoveis.index') }}" class="btn btn-primary">Ver Imóveis Disponíveis</a>
    </div>
    @else
    <div class="visitas-list">
        @foreach($visitas as $visita)
        <div class="visita-item" style="border-left: 4px solid
            @if($visita->estado === 'pendente') #e67e22
            @elseif($visita->estado === 'confirmada') #10b981
            @elseif($visita->estado === 'concluida') #1a5276
            @else #e74c3c
            @endif;
        ">
            <div class="visita-header">
                <h3>{{ $visita->imovel->titulo ?? 'Imóvel removido' }}</h3>
                <span class="visita-estado {{ strtolower($visita->estado) }}">
                    @if($visita->estado === 'pendente')
                        Pendente
                    @elseif($visita->estado === 'confirmada')
                        Confirmada
                    @elseif($visita->estado === 'concluida')
                        Concluída
                    @else
                        Cancelada
                    @endif
                </span>
            </div>
            <div class="visita-meta">
                <div class="meta-item">
                    <i class="bi bi-calendar me-1"></i>
                    <span>{{ $visita->data_visita ? $visita->data_visita->format('d/m/Y H:i') : '—' }}</span>
                </div>
                <div class="meta-item">
                    <i class="bi bi-telephone me-1"></i>
                    <span>{{ $visita->cliente_telefone }}</span>
                </div>
                @if($visita->observacoes)
                <div class="meta-item" style="color:#e67e22;">
                    <i class="bi bi-info-circle me-1"></i>
                    <span>{{ $visita->observacoes }}</span>
                </div>
                @endif
            </div>
            <div class="visita-actions">
                @if($visita->estado === 'pendente')
                <form method="POST" action="{{ route('cliente.visitas.cancelar', $visita->id) }}" style="display:inline;">
                    @csrf
                    <button type="button" class="btn btn-danger btn-sm" onclick="modalPerigo('Cancelar Visita', 'Tem certeza que deseja cancelar esta visita?', function(){ this.closest('form').submit(); }.bind(this))">Cancelar</button>
                </form>
                @elseif($visita->estado === 'confirmada')
                <form method="POST" action="{{ route('cliente.visitas.cancelar', $visita->id) }}" style="display:inline;">
                    @csrf
                    <button type="button" class="btn btn-warning btn-sm" onclick="modalPerigo('Cancelar Visita', 'Deseja cancelar esta visita confirmada?', function(){ this.closest('form').submit(); }.bind(this))">Cancelar</button>
                </form>
                @elseif($visita->estado === 'cancelada' && $visita->imovel)
                <a href="{{ route('imoveis.show', $visita->imovel->referencia) }}" class="btn btn-primary btn-sm">Reagendar</a>
                @endif
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection
