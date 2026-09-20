@extends('layouts.painel')

@section('title', 'Pagamentos — Painel | QNB-Imobiliária')

@section('content')
<div class="ul-painel-head">
    <div>
        <h3 class="ul-painel-card-titulo" style="margin-bottom:4px;">Pagamentos</h3>
        <p class="ul-painel-card-subtitulo" style="margin-bottom:0;">Histórico de pagamentos da sua imobiliária.</p>
    </div>
    <a href="{{ route('painel.pagamento.novo') }}" class="ul-btn"><i class="bi bi-plus-lg"></i> Novo Pagamento</a>
</div>

<div class="ul-painel-card">
    @if($pagamentos->count())
    <div style="overflow-x:auto;">
        <table class="ul-painel-tabela">
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Plano</th>
                    <th>Valor</th>
                    <th>Método</th>
                    <th>Estado</th>
                    <th>Fatura</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($pagamentos as $pagamento)
                <tr>
                    <td>{{ $pagamento->created_at->format('d/m/Y H:i') }}</td>
                    <td>{{ $pagamento->subscricao->plano->nome ?? '—' }}</td>
                    <td>{{ number_format($pagamento->valor, 2, ',', '.') }} {{ $pagamento->moeda }}</td>
                    <td>{{ ucfirst($pagamento->metodo) }}</td>
                    <td>
                        @if($pagamento->estado === 'confirmado')
                        <span class="ul-badge ul-badge--success">Confirmado</span>
                        @elseif($pagamento->estado === 'rejeitado')
                        <span class="ul-badge ul-badge--danger">Rejeitado</span>
                        @else
                        <span class="ul-badge ul-badge--pendente">Pendente</span>
                        @endif
                    </td>
                    <td>
                        @if($pagamento->fatura)
                        <span class="ul-badge ul-badge--info">{{ $pagamento->fatura->numero }}</span>
                        @else
                        —
                        @endif
                    </td>
                    <td><a href="{{ route('painel.pagamentos.show', $pagamento->id) }}" class="ul-btn ul-btn--sm">Ver</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div style="margin-top:15px;">
        {{ $pagamentos->links() }}
    </div>
    @else
    <div class="ul-painel-vazio">
        <i class="bi bi-wallet2" style="font-size:48px;color:#ccc;margin-bottom:15px;display:block;"></i>
        <p>Nenhum pagamento registado ainda.</p>
        <a href="{{ route('painel.pagamento.novo') }}" class="ul-btn" style="margin-top:10px;">Submeter Pagamento</a>
    </div>
    @endif
</div>
@endsection
