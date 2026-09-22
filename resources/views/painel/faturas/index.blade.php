@extends('layouts.painel')

@section('title', 'Faturas — Painel | QNB-Imobiliaria')

@section('content')
<div class="ul-painel-head">
    <div>
        <h3 class="ul-painel-card-titulo" style="margin-bottom:4px;">Faturas</h3>
        <p class="ul-painel-card-subtitulo" style="margin-bottom:0;">Historico de faturas da sua imobiliaria.</p>
    </div>
</div>

<div class="ul-painel-card">
    @if($faturas->count())
    <div style="overflow-x:auto;">
        <table class="ul-painel-tabela">
            <thead>
                <tr>
                    <th>Numero</th>
                    <th>Data</th>
                    <th>Total</th>
                    <th>Estado</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($faturas as $f)
                <tr>
                    <td data-label="Número"><strong>{{ $f->numero }}</strong></td>
                    <td data-label="Data">{{ $f->emitida_em ? $f->emitida_em->format('d/m/Y H:i') : '—' }}</td>
                    <td data-label="Total"><strong>{{ number_format($f->total, 2, ',', '.') }}</strong> {{ $f->moeda }}</td>
                    <td data-label="Estado">
                        @php
                            $badge = match($f->estado) {
                                'paga' => 'ul-badge--sucesso',
                                'pendente' => 'ul-badge--aviso',
                                'aguarda_aprovacao' => 'ul-badge--info',
                                'rejeitada' => 'ul-badge--perigo',
                                'cancelada', 'expirada' => 'ul-badge--cinza',
                                default => 'ul-badge--cinza',
                            };
                            $label = match($f->estado) {
                                'paga' => 'Paga',
                                'pendente' => 'Pendente',
                                'aguarda_aprovacao' => 'Aguarda Aprovação',
                                'rejeitada' => 'Rejeitada',
                                'cancelada' => 'Cancelada',
                                'expirada' => 'Expirada',
                                default => ucfirst($f->estado),
                            };
                        @endphp
                        <span class="ul-badge {{ $badge }}">{{ $label }}</span>
                    </td>
                    <td data-label="Ações">
                        <div style="display:flex;gap:6px;flex-wrap:wrap;">
                            <a href="{{ route('painel.faturas.show', $f) }}" class="ul-btn ul-btn--sm">Ver</a>
                            <a href="{{ route('painel.faturas.download', $f) }}" class="ul-btn ul-btn--sm ul-btn--azul">PDF</a>
                            @if($f->isPaga() && $f->recibo_pdf_path)
                            <a href="{{ route('painel.faturas.recibo', $f) }}" class="ul-btn ul-btn--sm ul-btn--verde">Recibo</a>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div style="margin-top:15px;">
        {{ $faturas->links() }}
    </div>
    @else
    <div class="ul-painel-vazio">
        <i class="bi bi-receipt" style="font-size:48px;color:#ccc;margin-bottom:15px;display:block;"></i>
        <p>Nenhuma fatura registada ainda.</p>
    </div>
    @endif
</div>
@endsection
