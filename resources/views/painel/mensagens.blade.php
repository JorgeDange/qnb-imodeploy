@extends('layouts.painel')

@section('title', 'Mensagens — Painel | QNB-Imobiliária')

@section('content')
<div class="ul-painel-head">
    <div>
        <h3 class="ul-painel-card-titulo ul-mb-4">Mensagens Recebidas</h3>
        <p class="ul-painel-card-subtitulo ul-mb-0">{{ $mensagens->count() }} mensagem(ns) no total.</p>
    </div>
</div>

@if($mensagens->count())
    @foreach($mensagens as $mensagem)
    <div class="ul-painel-mensagem {{ !$mensagem->lida ? 'ul-painel-mensagem--naolida' : '' }}">
        <div class="ul-painel-mensagem-cab">
            <span class="ul-painel-mensagem-nome">{{ $mensagem->nome }}</span>
            <span class="ul-painel-mensagem-data">{{ $mensagem->created_at->format('d/m/Y H:i') }}</span>
        </div>
        <p class="ul-painel-mensagem-texto">{{ $mensagem->texto }}</p>

        <div style="display:flex;flex-wrap:wrap;gap:12px;margin:10px 0;font-size:13px;color:var(--ul-gray2);">
            @if($mensagem->contacto)
                <span><i class="bi bi-diagram-3"></i> {{ $mensagem->contacto }}</span>
            @endif
            @if($mensagem->imovel)
                <span><i class="bi bi-house"></i> {{ $mensagem->imovel->titulo }}</span>
                @if($mensagem->imovel->estado === 'aprovado')
                    <span style="color:#10b981;"><i class="bi bi-check-lg"></i> Disponível</span>
                @else
                    <span style="color:#e74c3c;"><i class="bi bi-x-lg"></i> Indisponível</span>
                @endif
            @endif
        </div>

        <div class="ul-painel-mensagem-rodape">
            <div class="ul-painel-mensagem-acoes">
                @if(!$mensagem->lida)
                <form action="{{ route('painel.mensagens.lida', $mensagem->id) }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="ul-painel-btn ul-painel-btn--pequeno" title="Marcar como lida"><i class="bi bi-check-lg"></i> Lida</button>
                </form>
                @endif

                @if(str_contains($mensagem->contacto, '@'))
                    <a href="mailto:{{ $mensagem->contacto }}" class="ul-painel-btn ul-painel-btn--pequeno" title="Responder por email"><i class="bi bi-envelope"></i> Contactar</a>
                @else
                    <a href="tel:{{ $mensagem->contacto }}" class="ul-painel-btn ul-painel-btn--pequeno" title="Ligar"><i class="bi bi-diagram-3"></i> Contactar</a>
                @endif

                @if($mensagem->imovel_id)
                    <a href="https://wa.me/{{ ltrim(preg_replace('/[^0-9]/', '', $mensagem->contacto), '0') }}" target="_blank" class="ul-painel-btn ul-painel-btn--pequeno" title="WhatsApp" style="color:#25D366;"><i class="bi bi-diagram-3"></i> WhatsApp</a>

                    @if($mensagem->imovel && $mensagem->imovel->estado === 'aprovado')
                        <button type="button" class="ul-painel-btn ul-painel-btn--pequeno" style="color:#1a5276;" title="Notificar disponibilidade" onclick="notificarDisp({{ $mensagem->id }}, 1)"><i class="bi bi-house"></i> Disp.</button>
                    @endif
                    @if($mensagem->imovel && $mensagem->imovel->estado !== 'aprovado')
                        <button type="button" class="ul-painel-btn ul-painel-btn--pequeno" style="color:#e67e22;" title="Notificar indisponibilidade" onclick="notificarDisp({{ $mensagem->id }}, 0)"><i class="bi bi-house"></i> Indisp.</button>
                    @endif
                @endif
            </div>
        </div>
    </div>
    @endforeach
@else
<div class="ul-painel-vazio">
    <i class="bi bi-envelope" style="font-size:48px;color:#ccc;margin-bottom:15px;display:block;"></i>
    <p>Nenhuma mensagem recebida ainda.</p>
</div>
@endif

<form id="notificarForm" method="POST" style="display:none;">
    @csrf
    <input type="hidden" name="disponivel" id="notificarDisponivel">
</form>

<script>
function notificarDisp(id, disponivel) {
    var form = document.getElementById('notificarForm');
    form.action = '/painel/mensagens/' + id + '/notificar';
    document.getElementById('notificarDisponivel').value = disponivel;
    form.submit();
}
</script>
@endsection
