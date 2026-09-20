@extends('layouts.painel')

@section('title', 'Detalhe do Pagamento — Painel | QNB-Imobiliária')

@section('content')
<div class="ul-painel-head">
    <div>
        <h3 class="ul-painel-card-titulo" style="margin-bottom:4px;">Detalhe do Pagamento</h3>
        <p class="ul-painel-card-subtitulo" style="margin-bottom:0;">{{ $pagamento->fatura ? $pagamento->fatura->numero : 'Pagamento #' . $pagamento->id }}</p>
    </div>
    <a href="{{ route('painel.pagamentos') }}" class="ul-btn"><i class="bi bi-arrow-left"></i> Voltar</a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="ul-painel-card">
            <h3 class="ul-painel-card-titulo">Dados do Pagamento</h3>
            <div class="ul-painel-grid-dados">
                <div class="ul-painel-dado"><span class="ul-painel-dado-rotulo">Data</span><span class="ul-painel-dado-valor">{{ $pagamento->created_at->format('d/m/Y H:i') }}</span></div>
                <div class="ul-painel-dado"><span class="ul-painel-dado-rotulo">Plano</span><span class="ul-painel-dado-valor">{{ $pagamento->subscricao->plano->nome ?? '—' }}</span></div>
                <div class="ul-painel-dado"><span class="ul-painel-dado-rotulo">Valor</span><span class="ul-painel-dado-valor">{{ number_format($pagamento->valor, 2, ',', '.') }} {{ $pagamento->moeda }}</span></div>
                <div class="ul-painel-dado"><span class="ul-painel-dado-rotulo">Método</span><span class="ul-painel-dado-valor">{{ ucfirst($pagamento->metodo) }}</span></div>
                <div class="ul-painel-dado"><span class="ul-painel-dado-rotulo">Referência</span><span class="ul-painel-dado-valor">{{ $pagamento->referencia ?? '—' }}</span></div>
                <div class="ul-painel-dado"><span class="ul-painel-dado-rotulo">Estado</span><span class="ul-painel-dado-valor">
                    @if($pagamento->estado === 'confirmado')
                    <span class="ul-badge ul-badge--success">Confirmado</span>
                    @elseif($pagamento->estado === 'rejeitado')
                    <span class="ul-badge ul-badge--danger">Rejeitado</span>
                    @else
                    <span class="ul-badge ul-badge--pendente">Pendente</span>
                    @endif
                </span></div>
            </div>

            @if($pagamento->confirmado_em)
            <div class="ul-painel-grid-dados" style="margin-top:15px;">
                <div class="ul-painel-dado"><span class="ul-painel-dado-rotulo">Confirmado em</span><span class="ul-painel-dado-valor">{{ $pagamento->confirmado_em->format('d/m/Y H:i') }}</span></div>
            </div>
            @endif
        </div>

        @if($pagamento->comprovativo)
        <div class="ul-painel-card">
            <h3 class="ul-painel-card-titulo">Comprovativo</h3>
            <div style="padding:10px 0;">
                <img src="{{ asset('storage/' . $pagamento->comprovativo) }}" alt="Comprovativo" style="max-width:100%;border-radius:8px;border:1px solid #eee;">
            </div>
        </div>
        @endif
    </div>

    <div class="col-lg-4">
        @if($pagamento->fatura)
        <div class="ul-painel-card">
            <h3 class="ul-painel-card-titulo">Fatura</h3>
            <div class="ul-painel-grid-dados">
                <div class="ul-painel-dado"><span class="ul-painel-dado-rotulo">Número</span><span class="ul-painel-dado-valor">{{ $pagamento->fatura->numero }}</span></div>
                <div class="ul-painel-dado"><span class="ul-painel-dado-rotulo">Total</span><span class="ul-painel-dado-valor">{{ number_format($pagamento->fatura->total, 2, ',', '.') }} {{ $pagamento->fatura->moeda }}</span></div>
                <div class="ul-painel-dado"><span class="ul-painel-dado-rotulo">Emitida</span><span class="ul-painel-dado-valor">{{ $pagamento->fatura->emitida_em ? $pagamento->fatura->emitida_em->format('d/m/Y') : '—' }}</span></div>
            </div>
            <a href="{{ route('painel.faturas.download', $pagamento->fatura->id) }}" class="ul-btn" style="margin-top:10px;"><i class="bi bi-download"></i> Descarregar Fatura (PDF)</a>
        </div>
        @endif

        @if($pagamento->estado === 'pendente')
        <div class="ul-painel-card">
            <div class="ul-painel-aviso">
                <div class="ul-painel-aviso-icone"><i class="bi bi-info-circle"></i></div>
                <div class="ul-painel-aviso-texto">
                    <p style="margin:0;">O seu pagamento está a ser analisado. Receberá uma notificação por email quando for processado.</p>
                </div>
            </div>
        </div>
        @endif

        @if($pagamento->estado === 'rejeitado')
        <div class="ul-painel-card">
            <div class="ul-painel-aviso ul-painel-aviso--destaque">
                <div class="ul-painel-aviso-icone"><i class="bi bi-info-circle"></i></div>
                <div class="ul-painel-aviso-texto">
                    <p style="margin:0;">Pagamento rejeitado. Contacte-nos para mais informações ou submeta um novo pagamento.</p>
                </div>
            </div>
            <a href="{{ route('painel.pagamento.novo') }}" class="ul-btn" style="margin-top:10px;">Novo Pagamento</a>
        </div>
        @endif
    </div>
</div>
@endsection
