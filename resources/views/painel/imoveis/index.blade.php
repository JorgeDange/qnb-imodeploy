@extends('layouts.painel')

@section('title', 'Meus Imóveis — Painel | QNB-Imobiliária')

@section('content')
<div class="ul-painel-head">
    <div>
        <h3 class="ul-painel-card-titulo" style="margin-bottom:4px;">Meus Imóveis</h3>
        <p class="ul-painel-card-subtitulo" style="margin-bottom:0;">Gerencie todos os seus anúncios.</p>
    </div>
    @if($plano && $plano->posts_usados < $plano->plano->posts_limite)
    <a href="{{ route('painel.imoveis.novo') }}" class="ul-btn"><i class="bi bi-plus-lg"></i> Novo Imóvel</a>
    @endif
</div>

@if($plano)
<div class="ul-painel-aviso ul-painel-aviso--cinza">
    <div class="ul-painel-aviso-icone"><i class="bi bi-list-ul"></i></div>
    <div class="ul-painel-aviso-texto">
        <h4 class="ul-painel-aviso-titulo">Limite de Posts</h4>
        <p>Posts utilizados: <strong>{{ $plano->posts_usados }} / {{ $plano->plano->posts_limite }}</strong></p>
    </div>
</div>
@endif

@if($imoveis->count())
    @foreach($imoveis as $imovel)
    <div class="ul-painel-imovel">
        @if($imovel->capaFoto())
        <div class="ul-painel-imovel-foto"><img src="{{ asset('storage/' . $imovel->capaFoto()->caminho) }}" alt="{{ $imovel->titulo }}"></div>
        @else
        <div class="ul-painel-imovel-foto"><img src="{{ asset('assets/img/project-1.jpg') }}" alt="{{ $imovel->titulo }}"></div>
        @endif
        <div class="ul-painel-imovel-info">
            <h4 class="ul-painel-imovel-titulo">{{ $imovel->titulo }}</h4>
            <span class="ul-painel-imovel-ref">Ref: {{ $imovel->referencia }}</span>
            <span class="ul-painel-imovel-local">{{ $imovel->bairro }}, {{ $imovel->municipio }}</span>
            <span class="ul-painel-imovel-preco">{{ number_format($imovel->preco, 0, ',', '.') }} {{ $imovel->moeda }}</span>
            <div class="ul-painel-imovel-acoes">
                <span class="ul-badge ul-badge--{{ $imovel->estado }}">{{ ucfirst($imovel->estado) }}</span>
                @if($imovel->destaque)<span class="ul-badge ul-badge--destaque"><i class="bi bi-star"></i> Destaque</span>@endif
                <a href="{{ route('painel.imoveis.editar', $imovel->id) }}" class="ul-btn ul-btn--sm">Editar</a>
                <form id="imovel-del-{{ $imovel->id }}" action="{{ route('painel.imoveis.deletar', $imovel->id) }}" method="POST" class="d-inline">
                    @csrf @method('DELETE')
                    <button type="button" class="ul-btn ul-btn--sm" style="background:#e74c3c;color:#fff;" onclick="modalPerigo('Remover Imóvel', 'Tem certeza que deseja remover este imóvel?', function(){ document.getElementById('imovel-del-{{ $imovel->id }}').submit(); })">Remover</button>
                </form>
                @if($imovel->estado === 'aprovado')
                <form action="{{ route('painel.imoveis.destaque', $imovel->id) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="ul-btn ul-btn--sm">{{ $imovel->destaque ? '★ Destaque' : '☆ Destaque' }}</button>
                </form>
                @endif
            </div>
            <div class="ul-painel-imovel-stats">
                <span class="ul-painel-imovel-stat"><i class="bi bi-info-circle"></i> {{ $imovel->visualizacoes }}</span>
                <span class="ul-painel-imovel-stat"><i class="bi bi-telephone"></i> {{ $imovel->contactos }}</span>
            </div>
        </div>
    </div>
    @endforeach
@else
<div class="ul-painel-vazio">
    <i class="bi bi-house" style="font-size:48px;color:#ccc;margin-bottom:15px;display:block;"></i>
    <p>Nenhum imóvel cadastrado ainda.</p>
    <a href="{{ route('painel.imoveis.novo') }}" class="ul-btn">Cadastrar Primeiro Imóvel</a>
</div>
@endif
@endsection
