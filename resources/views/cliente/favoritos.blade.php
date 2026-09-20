@extends('cliente.layout')

@section('cliente-content')
<div class="favoritos-page">
    <div class="page-header">
        <h1><i class="bi bi-heart me-2"></i>Meus Favoritos</h1>
    </div>
    
    @if($favoritos->isEmpty())
    <div class="empty-state">
        <i class="bi bi-heartbreak bi-3x mb-3 opacity-50"></i>
        <h3>Nenhum imóvel nos favoritos</h3>
        <p>Não tem nenhum imóvel marcado como favorito ainda.</p>
        <a href="{{ route('imoveis.index') }}" class="btn btn-primary">Ver Imóveis</a>
    </div>
    @else
    <div class="favoritos-grid">
        @foreach($favoritos as $favorito)
        <div class="favorito-card">
            <div class="favorito-img">
                @php $capa = $favorito->imovel->capaFoto(); @endphp
                @if($capa)
                    <img src="{{ asset('storage/' . $capa->caminho) }}" alt="{{ $favorito->imovel->titulo }}">
                @else
                    <img src="{{ asset('assets/img/property-1.jpg') }}" alt="{{ $favorito->imovel->titulo }}">
                @endif
            </div>
            <div class="favorito-info">
                <h3><a href="{{ route('imoveis.show', $favorito->imovel->referencia) }}">{{ substr($favorito->imovel->titulo, 0, 50) }}</a></h3>
                <div class="favorito-preco">
                    <span class="price">{{ number_format($favorito->imovel->preco, 0, ',', ' ') }} Kz</span>
                    <span class="type">{{ $favorito->imovel->tipo }}</span>
                </div>
                <div class="favorito-location">
                    <i class="bi bi-geo-alt me-1"></i>{{ substr($favorito->imovel->localizacao, 0, 30) }}
                </div>
            </div>
            <div class="favorito-actions">
                <form id="fav-form-{{ $favorito->imovel->id }}" action="{{ route('cliente.favoritos.destroy', $favorito->imovel->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn-remover-favorito" onclick="modalPerigo('Remover Favorito', 'Tem certeza que deseja remover este imóvel dos favoritos?', function(){ document.getElementById('fav-form-{{ $favorito->imovel->id }}').submit(); })">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection