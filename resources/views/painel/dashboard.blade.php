@extends('layouts.painel')

@section('title', 'Visão Geral — Painel | QNB-Imobiliária')

@section('content')
<div class="ul-painel-head">
    <div>
        <h3 class="ul-painel-card-titulo ul-mb-4">Visão Geral</h3>
        <p class="ul-painel-card-subtitulo ul-mb-0">Acompanhe o desempenho dos seus anúncios de forma rápida.</p>
    </div>
    <a href="{{ route('painel.imoveis.novo') }}" class="ul-painel-btn"><i class="bi bi-house"></i> Adicionar Imóvel</a>
</div>

<!-- estatísticas -->
<div class="ul-painel-stats">
    <div class="ul-painel-stat"><span class="ul-painel-stat-numero">{{ $stats['total'] }}</span><span class="ul-painel-stat-rotulo">Imóveis no total</span></div>
    <div class="ul-painel-stat"><span class="ul-painel-stat-numero">{{ $stats['aprovados'] }}</span><span class="ul-painel-stat-rotulo">Aprovados</span></div>
    <div class="ul-painel-stat"><span class="ul-painel-stat-numero">{{ $stats['pendentes'] }}</span><span class="ul-painel-stat-rotulo">Pendentes</span></div>
    <div class="ul-painel-stat"><span class="ul-painel-stat-numero">{{ $stats['destaques'] }}</span><span class="ul-painel-stat-rotulo">Em destaque</span></div>
    <div class="ul-painel-stat"><span class="ul-painel-stat-numero">{{ $stats['visualizacoes'] }}</span><span class="ul-painel-stat-rotulo">Visualizações</span></div>
    <div class="ul-painel-stat"><span class="ul-painel-stat-numero">{{ $stats['contactos'] }}</span><span class="ul-painel-stat-rotulo">Contactos</span></div>
    <div class="ul-painel-stat"><span class="ul-painel-stat-numero">{{ $mensagensNaoLidas }}</span><span class="ul-painel-stat-rotulo">Mensagens não lidas</span></div>
</div>

<!-- plano ativo -->
@if($plano)
    @if($plano->data_expiracao && $plano->data_expiracao->isPast())
    <div class="ul-painel-aviso ul-painel-aviso--destaque ul-painel-aviso--perigo">
        <div class="ul-painel-aviso-icone"><i class="bi bi-info-circle"></i></div>
        <div class="ul-painel-aviso-texto">
            <h4 class="ul-painel-aviso-titulo">Plano Expirado</h4>
            <p>O seu plano {{ $plano->plano->nome }} expirou em {{ $plano->data_expiracao->format('d/m/Y') }}. <a href="{{ route('painel.ativar-plano') }}">Renove agora</a>.</p>
        </div>
    </div>
    @elseif($plano->data_expiracao && (int) $plano->data_expiracao->diffInDays(now()) <= 7)
    <div class="ul-painel-aviso ul-painel-aviso--aviso">
        <div class="ul-painel-aviso-icone"><i class="bi bi-info-circle"></i></div>
        <div class="ul-painel-aviso-texto">
            <h4 class="ul-painel-aviso-titulo">Plano a Expirar</h4>
            <p>O seu plano {{ $plano->plano->nome }} expira em {{ $plano->data_expiracao->format('d/m/Y') }} ({{ (int) $plano->data_expiracao->diffInDays(now()) }} dia(s)). <a href="{{ route('painel.ativar-plano') }}">Renove agora</a>.</p>
        </div>
    </div>
    @else
    <div class="ul-painel-aviso">
        <div class="ul-painel-aviso-icone"><i class="bi bi-star"></i></div>
        <div class="ul-painel-aviso-texto">
            <h4 class="ul-painel-aviso-titulo">Plano Ativo: {{ $plano->plano->nome }}</h4>
            <p>Posts: {{ $plano->posts_usados }} / {{ $plano->plano->posts_limite }} | Expira: {{ $plano->data_expiracao ? $plano->data_expiracao->format('d/m/Y') : 'Indefinida' }}</p>
        </div>
    </div>
    @endif
@else
<div class="ul-painel-aviso ul-painel-aviso--cinza">
    <div class="ul-painel-aviso-icone"><i class="bi bi-info-circle"></i></div>
    <div class="ul-painel-aviso-texto">
        <h4 class="ul-painel-aviso-titulo">Nenhum plano ativo</h4>
        <p><a href="{{ route('painel.ativar-plano') }}">Ative um plano</a> para publicar imóveis.</p>
    </div>
</div>
@endif

<div class="ul-painel-dash-cols">
    <!-- imóveis recentes -->
    <div class="ul-painel-card">
        <h3 class="ul-painel-card-titulo">Imóveis Recentes</h3>
        <p class="ul-painel-card-subtitulo">Os seus últimos anúncios cadastrados.</p>
        @if($imoveis->count())
            @foreach($imoveis->take(5) as $imovel)
            <div class="ul-painel-imovel">
                @if($imovel->fotos->count())
                <div class="ul-painel-imovel-foto"><img src="{{ asset('storage/' . $imovel->fotos->first()->caminho) }}" alt="{{ $imovel->titulo }}"></div>
                @endif
                <div class="ul-painel-imovel-info">
                    <h4 class="ul-painel-imovel-titulo">{{ $imovel->titulo }}</h4>
                    <span class="ul-painel-imovel-ref">Ref: {{ $imovel->referencia }}</span>
                    <span class="ul-painel-imovel-local">{{ $imovel->bairro }}, {{ $imovel->municipio }}</span>
                    <span class="ul-painel-imovel-preco">{{ number_format($imovel->preco, 0, ',', '.') }} {{ $imovel->moeda }}</span>
                    <div class="ul-painel-imovel-acoes">
                        <span class="ul-badge ul-badge--{{ $imovel->estado }}">{{ ucfirst($imovel->estado) }}</span>
                        <a href="{{ route('painel.imoveis.editar', $imovel->id) }}" class="ul-painel-btn ul-painel-btn--pequeno">Editar</a>
                    </div>
                </div>
            </div>
            @endforeach
        @else
        <p class="ul-painel-vazio">Nenhum imóvel cadastrado ainda.</p>
        @endif
    </div>

    <!-- últimas mensagens -->
    <div class="ul-painel-card">
        <h3 class="ul-painel-card-titulo">Últimas Mensagens</h3>
        <p class="ul-painel-card-subtitulo">Leads mais recentes recebidos do site.</p>
        @if($mensagens->count())
            @foreach($mensagens as $mensagem)
            <div class="ul-painel-mensagem {{ !$mensagem->lida ? 'ul-painel-mensagem--naolida' : '' }}">
                <div class="ul-painel-mensagem-cab">
                    <span class="ul-painel-mensagem-nome">{{ $mensagem->nome }}</span>
                    <span class="ul-painel-mensagem-data">{{ $mensagem->created_at->format('d/m/Y H:i') }}</span>
                </div>
                <p class="ul-painel-mensagem-texto">{{ Str::limit($mensagem->texto, 100) }}</p>
                <div class="ul-painel-mensagem-rodape">
                    <span class="ul-painel-mensagem-contacto"><i class="bi bi-envelope"></i> {{ $mensagem->contacto }}</span>
                </div>
            </div>
            @endforeach
        @else
        <p class="ul-painel-vazio">Nenhuma mensagem recebida.</p>
        @endif
    </div>
</div>
@endsection
