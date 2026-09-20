@extends('layouts.painel')

@section('title', 'Pagamento Submetido — Painel | QNB-Imobiliária')

@section('content')
<div class="ul-painel-head">
    <div>
        <h3 class="ul-painel-card-titulo" style="margin-bottom:4px;">Pagamento Submetido</h3>
        <p class="ul-painel-card-subtitulo" style="margin-bottom:0;">O seu pagamento está a ser analisado pela equipa QNB.</p>
    </div>
</div>

<div class="ul-painel-card" style="text-align:center;padding:40px 20px;">
    <div style="font-size:64px;color:var(--ul-primary);margin-bottom:15px;">
        <i class="bi bi-check-circle"></i>
    </div>
    <h3 style="margin-bottom:10px;">Pagamento Recebido!</h3>
    <p style="color:#666;max-width:500px;margin:0 auto 20px;">
        O seu pagamento foi submetido com sucesso e está a ser analisado pela nossa equipa.
        Receberá uma notificação por email assim que o pagamento for validado.
    </p>
    <div class="ul-painel-grid-dados" style="max-width:400px;margin:20px auto;">
        <div class="ul-painel-dado"><span class="ul-painel-dado-rotulo">Estado</span><span class="ul-painel-dado-valor"><span class="ul-badge ul-badge--pendente">Pendente</span></span></div>
        <div class="ul-painel-dado"><span class="ul-painel-dado-rotulo">Prazo</span><span class="ul-painel-dado-valor">1-2 dias úteis</span></div>
    </div>
    <div style="margin-top:25px;">
        <a href="{{ route('painel.pagamentos') }}" class="ul-btn"><i class="bi bi-list-ul"></i> Ver Pagamentos</a>
        <a href="{{ route('painel.dashboard') }}" class="ul-btn" style="margin-left:10px;"><i class="bi bi-house"></i> Dashboard</a>
    </div>
</div>
@endsection
