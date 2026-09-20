@extends('cliente.layout')

@section('cliente-content')
<div class="page-header">
    <h1><i class="bi bi-search me-2"></i>Minhas Pesquisas</h1>
</div>

@if($pesquisas->isEmpty())
<div class="empty-state">
    <i class="bi bi-search bi-3x mb-3 opacity-50"></i>
    <h3>Nenhuma pesquisa guardada</h3>
    <p>As suas pesquisas de imóveis aparecerão aqui.</p>
    <a href="{{ route('imoveis.index') }}" class="ul-btn">Pesquisar Imóveis</a>
</div>
@else
<div class="mensagens-list">
    @foreach($pesquisas as $pesquisa)
    <div class="mensagem-item">
        <div class="mensagem-header">
            <h3><i class="bi bi-search" style="color:var(--ul-primary);margin-right:8px;"></i>{{ $pesquisa->termo }}</h3>
        </div>
        <div class="mensagem-meta">
            <span>{{ $pesquisa->created_at->diffForHumans() }}</span>
        </div>
        <div class="favorito-actions">
            <form id="pesq-form-{{ $pesquisa->id }}" method="POST" action="{{ route('cliente.pesquisas.destroy', $pesquisa->id) }}">
                @csrf
                @method('DELETE')
                <button type="button" class="btn-remover-favorito" onclick="modalPerigo('Remover Pesquisa', 'Remover esta pesquisa guardada?', function(){ document.getElementById('pesq-form-{{ $pesquisa->id }}').submit(); })"><i class="bi bi-x-lg"></i></button>
            </form>
        </div>
    </div>
    @endforeach
</div>
@endif
@endsection
