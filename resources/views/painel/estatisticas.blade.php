@extends('layouts.painel')

@section('title', 'Estatísticas — Painel')

@section('content')
<div class="ul-painel-cabecalho">
    <h1 class="ul-painel-titulo">Estatísticas</h1>
</div>

<div class="ul-painel-stats" style="margin-bottom:20px;">
    <div class="ul-painel-stat">
        <span class="ul-painel-stat-numero">{{ $stats['total_visualizacoes'] }}</span>
        <span class="ul-painel-stat-rotulo">Visualizações</span>
    </div>
    <div class="ul-painel-stat">
        <span class="ul-painel-stat-numero">{{ $stats['total_contactos'] }}</span>
        <span class="ul-painel-stat-rotulo">Contactos gerados</span>
    </div>
    <div class="ul-painel-stat">
        <span class="ul-painel-stat-numero">{{ $stats['total_imoveis'] }}</span>
        <span class="ul-painel-stat-rotulo">Total imóveis</span>
    </div>
    <div class="ul-painel-stat">
        <span class="ul-painel-stat-numero">{{ $stats['aprovados'] }}</span>
        <span class="ul-painel-stat-rotulo">Publicados</span>
    </div>
    <div class="ul-painel-stat">
        <span class="ul-painel-stat-numero">{{ $stats['pendentes'] }}</span>
        <span class="ul-painel-stat-rotulo">Pendentes</span>
    </div>
</div>

<div class="ul-painel-dash-cols">
    <div class="ul-painel-card">
        <h3 class="ul-painel-card-titulo" style="font-size:16px;margin-bottom:14px;">Imóveis Mais Vistos</h3>
        @forelse($maisVistos as $imovel)
        <div class="ul-painel-lista-item">
            <div class="ul-painel-lista-info">
                <strong>{{ $imovel->titulo }}</strong>
                <small>{{ $imovel->municipio }}, {{ $imovel->provincia }}</small>
            </div>
            <span style="font-weight:700;color:var(--ul-primary);">{{ $imovel->visualizacoes }} <small style="font-weight:400;color:var(--ul-gray2);">vistos</small></span>
        </div>
        @empty
        <p style="color:#888;text-align:center;padding:20px;">Sem dados ainda.</p>
        @endforelse
    </div>

    <div class="ul-painel-card">
        <h3 class="ul-painel-card-titulo" style="font-size:16px;margin-bottom:14px;">Imóveis Mais Contactados</h3>
        @forelse($maisContactados as $imovel)
        <div class="ul-painel-lista-item">
            <div class="ul-painel-lista-info">
                <strong>{{ $imovel->titulo }}</strong>
                <small>{{ $imovel->municipio }}, {{ $imovel->provincia }}</small>
            </div>
            <span style="font-weight:700;color:var(--ul-primary);">{{ $imovel->contactos }} <small style="font-weight:400;color:var(--ul-gray2);">contactos</small></span>
        </div>
        @empty
        <p style="color:#888;text-align:center;padding:20px;">Sem dados ainda.</p>
        @endforelse
    </div>
</div>
@endsection
