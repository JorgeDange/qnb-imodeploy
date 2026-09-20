@extends('layouts.painel')

@section('title', 'Destaques — Painel')

@section('content')
<div class="ul-painel-cabecalho">
    <h1 class="ul-painel-titulo">Destaques</h1>
    <a href="{{ route('painel.imoveis.novo') }}" class="ul-painel-btn ul-painel-btn--primario"><i class="bi bi-plus-lg"></i> Novo Imóvel</a>
</div>

@if($plano)
<div class="ul-painel-aviso ul-painel-aviso--cinza" style="margin-bottom:20px;">
    <div class="ul-painel-aviso-texto">
        <p>Imóveis em destaque: <strong>{{ $imoveis->count() }}</strong></p>
    </div>
</div>
@endif

@if($imoveis->count())
    @foreach($imoveis as $imovel)
    <div class="ul-painel-imovel">
        <div class="ul-painel-imovel-foto">
            @if($imovel->fotos->count())
                <img src="{{ asset('storage/' . $imovel->fotos->first()->caminho) }}" alt="{{ $imovel->titulo }}">
            @else
                <div style="width:100%;height:100%;background:#f1f5f9;display:grid;place-items:center;color:#aaa;"><i class="bi bi-house"></i></div>
            @endif
        </div>
        <div class="ul-painel-imovel-info">
            <span class="ul-painel-imovel-titulo">{{ $imovel->titulo }}</span>
            <span class="ul-painel-imovel-ref">{{ $imovel->referencia }}</span>
            <span class="ul-painel-imovel-local"><i class="bi bi-geo-alt"></i> {{ $imovel->municipio }}, {{ $imovel->provincia }}</span>
            <span class="ul-painel-imovel-preco">{{ number_format($imovel->preco, 0, ',', '.') }} {{ $imovel->moeda }}</span>
            <div class="ul-painel-imovel-stats">
                <span class="ul-painel-imovel-stat"><i class="bi bi-eye"></i> {{ $imovel->visualizacoes }}</span>
                <span class="ul-painel-imovel-stat"><i class="bi bi-telephone"></i> {{ $imovel->contactos }}</span>
            </div>
        </div>
        <div class="ul-painel-imovel-acoes">
            <span class="ul-badge ul-badge--destaque"><i class="bi bi-star"></i> Destaque</span>
            <form id="destaque-form-{{ $imovel->id }}" action="{{ route('painel.imoveis.destaque', $imovel) }}" method="POST" style="display:inline;">
                @csrf
                <button type="button" class="ul-painel-btn ul-painel-btn--pequeno" style="color:#ef4444;" title="Remover destaque" onclick="modalPerigo('Remover Destaque', 'Remover este imóvel dos destaques?', function(){ document.getElementById('destaque-form-{{ $imovel->id }}').submit(); })"><i class="bi bi-x-lg"></i></button>
            </form>
        </div>
    </div>
    @endforeach
@else
    <div class="ul-painel-vazio">
        <p>Nenhum imóvel em destaque.</p>
        <p style="font-size:13px;margin-top:8px;">Destaque os seus melhores imóveis na página de imóveis.</p>
    </div>
@endif
@endsection
