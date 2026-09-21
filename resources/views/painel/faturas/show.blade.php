@extends('layouts.painel')

@section('title', 'Fatura ' . $fatura->numero . ' — Painel')

@section('content')
<div class="ul-painel-head">
    <div>
        <h3 class="ul-painel-card-titulo" style="margin-bottom:4px;">Fatura {{ $fatura->numero }}</h3>
        <p class="ul-painel-card-subtitulo" style="margin-bottom:0;">Detalhes da fatura.</p>
    </div>
    <div>
        <a href="{{ route('painel.faturas') }}" class="ul-btn ul-btn--cinza">Voltar</a>
        <a href="{{ route('painel.faturas.download', $fatura) }}" class="ul-btn ul-btn--azul">Download PDF</a>
        @if($fatura->isPaga() && $fatura->recibo_numero)
        <a href="{{ route('painel.faturas.recibo', $fatura) }}" class="ul-btn ul-btn--verde">Download Recibo</a>
        @endif
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="ul-painel-card">
            <h3 class="ul-painel-card-titulo">Dados da Fatura</h3>
            <table class="ul-painel-tabela" style="margin:0;">
                <tr><td style="width:200px;font-weight:bold;">Número</td><td>{{ $fatura->numero }}</td></tr>
                <tr><td style="font-weight:bold;">Data Emissão</td><td>{{ $fatura->emitida_em ? $fatura->emitida_em->format('d/m/Y H:i') : '—' }}</td></tr>
                <tr><td style="font-weight:bold;">Plano</td><td>{{ $fatura->pagamento->subscricao->plano->nome ?? '—' }}</td></tr>
                <tr>
                    <td style="font-weight:bold;">Estado</td>
                    <td>
                        @php
                            $badge = match($fatura->estado) {
                                'paga' => 'ul-badge--sucesso',
                                'pendente' => 'ul-badge--aviso',
                                'aguarda_aprovacao' => 'ul-badge--info',
                                'rejeitada' => 'ul-badge--perigo',
                                'cancelada', 'expirada' => 'ul-badge--cinza',
                                default => 'ul-badge--cinza',
                            };
                        @endphp
                        <span class="ul-badge {{ $badge }}">{{ ucfirst(str_replace('_', ' ', $fatura->estado)) }}</span>
                    </td>
                </tr>
                @if($fatura->recibo_numero)
                <tr><td style="font-weight:bold;">Recibo</td><td>{{ $fatura->recibo_numero }}</td></tr>
                @endif
                @if($fatura->motivo_rejeicao)
                <tr><td style="font-weight:bold;">Observação</td><td style="color:#dc3545;">{{ $fatura->motivo_rejeicao }}</td></tr>
                @endif
            </table>
        </div>

        {{-- Comprovativo Submetido --}}
        @if($fatura->comprovativo_path)
        <div class="ul-painel-card">
            <h3 class="ul-painel-card-titulo">Comprovativo Submetido</h3>
            <p style="color:#888;font-size:12px;">Enviado em {{ $fatura->comprovativo_enviado_em ? $fatura->comprovativo_enviado_em->format('d/m/Y H:i') : '—' }}</p>
            @if(in_array(pathinfo($fatura->comprovativo_path, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'webp']))
            <img src="{{ asset('storage/' . $fatura->comprovativo_path) }}" alt="Comprovativo" style="max-width:100%;max-height:400px;border-radius:8px;border:1px solid #eee;margin-top:10px;">
            @else
            <a href="{{ asset('storage/' . $fatura->comprovativo_path) }}" target="_blank" class="ul-btn ul-btn--azul ul-btn--sm">Ver Comprovativo PDF</a>
            @endif
        </div>
        @endif

        {{-- Upload Comprovativo --}}
        @if($fatura->isPendente() || $fatura->isRejeitada())
        <div class="ul-painel-card" style="border:2px solid #27ae60;">
            <h3 class="ul-painel-card-titulo">Submeter Comprovativo de Pagamento</h3>
            <p style="color:#888;font-size:12px;">Aceita JPG, PNG, WebP ou PDF. Máximo 5MB.</p>
            <form action="{{ route('painel.faturas.comprovativo', $fatura) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="ul-painel-form-campo">
                    <input type="file" name="comprovativo" accept="image/jpeg,image/png,image/webp,application/pdf" required style="width:100%;">
                </div>
                @error('comprovativo')
                <p style="color:#dc3545;font-size:12px;">{{ $message }}</p>
                @enderror
                <button type="submit" class="ul-btn ul-btn--sucesso" style="margin-top:10px;">Submeter Comprovativo</button>
            </form>
        </div>
        @endif

        <div class="ul-painel-card">
            <h3 class="ul-painel-card-titulo">Linhas da Fatura</h3>
            <table class="ul-painel-tabela">
                <thead>
                    <tr>
                        <th>Descrição</th>
                        <th>Qtd</th>
                        <th>Valor Unit.</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($fatura->linhas as $linha)
                    <tr>
                        <td>{{ $linha->descricao }}</td>
                        <td>{{ $linha->quantidade }}</td>
                        <td>{{ number_format($linha->valor_unitario, 2, ',', '.') }}</td>
                        <td><strong>{{ number_format($linha->subtotal, 2, ',', '.') }}</strong></td>
                    </tr>
                    @empty
                    <tr><td colspan="4" style="text-align:center;color:#888;">Sem linhas registadas.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="ul-painel-card">
            <h3 class="ul-painel-card-titulo">Valores</h3>
            <table class="ul-painel-tabela" style="margin:0;">
                <tr><td style="font-weight:bold;">Subtotal</td><td style="text-align:right;">{{ number_format($fatura->subtotal, 2, ',', '.') }} {{ $fatura->moeda }}</td></tr>
                <tr><td style="font-weight:bold;">IVA</td><td style="text-align:right;">{{ number_format($fatura->iva, 2, ',', '.') }} {{ $fatura->moeda }}</td></tr>
                @if($fatura->desconto > 0)
                <tr><td style="font-weight:bold;">Desconto</td><td style="text-align:right;color:#dc3545;">-{{ number_format($fatura->desconto, 2, ',', '.') }} {{ $fatura->moeda }}</td></tr>
                @endif
                @if($fatura->retencao > 0)
                <tr><td style="font-weight:bold;">Retenção na Fonte</td><td style="text-align:right;color:#dc3545;">-{{ number_format($fatura->retencao, 2, ',', '.') }} {{ $fatura->moeda }}</td></tr>
                @endif
                <tr style="border-top:2px solid #333;"><td style="font-weight:bold;font-size:1.1em;">TOTAL</td><td style="text-align:right;font-weight:bold;font-size:1.1em;">{{ number_format($fatura->total, 2, ',', '.') }} {{ $fatura->moeda }}</td></tr>
            </table>
        </div>

        @if($fatura->nota)
        <div class="ul-painel-card">
            <h3 class="ul-painel-card-titulo">Nota</h3>
            <p>{{ $fatura->nota }}</p>
        </div>
        @endif
    </div>

    <div class="col-lg-4">
        <div class="ul-painel-card">
            <h3 class="ul-painel-card-titulo">Dados da Empresa</h3>
            <table class="ul-painel-tabela" style="margin:0;">
                <tr><td style="font-weight:bold;">Nome</td><td>{{ $fatura->empresa_nome ?? '—' }}</td></tr>
                <tr><td style="font-weight:bold;">NIF</td><td>{{ $fatura->empresa_nif ?? '—' }}</td></tr>
                <tr><td style="font-weight:bold;">Endereço</td><td>{{ $fatura->empresa_endereco ?? '—' }}</td></tr>
                <tr><td style="font-weight:bold;">Telefone</td><td>{{ $fatura->empresa_telefone ?? '—' }}</td></tr>
                <tr><td style="font-weight:bold;">Email</td><td>{{ $fatura->empresa_email ?? '—' }}</td></tr>
            </table>
        </div>

        <div class="ul-painel-card">
            <h3 class="ul-painel-card-titulo">Dados Bancários</h3>
            <table class="ul-painel-tabela" style="margin:0;">
                <tr><td style="font-weight:bold;">Banco</td><td>{{ $fatura->banco_nome ?? '—' }}</td></tr>
                <tr><td style="font-weight:bold;">IBAN</td><td>{{ $fatura->banco_iban ?? '—' }}</td></tr>
                <tr><td style="font-weight:bold;">Titular</td><td>{{ $fatura->banco_titular ?? '—' }}</td></tr>
            </table>
        </div>

        @if($fatura->pdf_path)
        <div class="ul-painel-card">
            <h3 class="ul-painel-card-titulo">PDF</h3>
            <a href="{{ route('painel.faturas.download', $fatura) }}" class="ul-btn ul-btn--azul" style="width:100%;">Download Fatura PDF</a>
            @if($fatura->isPaga() && $fatura->recibo_pdf_path)
            <a href="{{ route('painel.faturas.recibo', $fatura) }}" class="ul-btn ul-btn--verde" style="width:100%;margin-top:8px;">Download Recibo PDF</a>
            @endif
        </div>
        @endif
    </div>
</div>
@endsection
