@extends('admin.layouts.admin')

@section('title', 'Faturas — Admin')

@section('content')
<div class="ul-painel-cabecalho">
    <h1 class="ul-painel-titulo">Faturas</h1>
</div>

<div class="ul-painel-tabela-wrap">
    <table class="ul-painel-tabela">
        <thead>
            <tr>
                <th>Número</th>
                <th>Imobiliária</th>
                <th>Valor</th>
                <th>IVA</th>
                <th>Total</th>
                <th>Data</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse($faturas as $f)
            <tr>
                <td><strong>{{ $f->numero }}</strong></td>
                <td>{{ $f->imobiliaria->nome ?? '—' }}</td>
                <td>{{ number_format($f->valor, 2, ',', '.') }} {{ $f->moeda }}</td>
                <td>{{ number_format($f->iva, 2, ',', '.') }}</td>
                <td><strong>{{ number_format($f->total, 2, ',', '.') }}</strong> {{ $f->moeda }}</td>
                <td>{{ $f->emitida_em->format('d/m/Y H:i') }}</td>
                <td><a href="{{ route('admin.faturas.download', $f) }}" class="ul-painel-btn ul-painel-btn--pequeno">PDF</a></td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align:center;padding:40px;color:#888;">Nenhuma fatura encontrada.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{ $faturas->links() }}
@endsection
