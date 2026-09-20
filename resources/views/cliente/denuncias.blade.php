@extends('cliente.layout')

@section('cliente-content')
<div class="denuncias-page">
    <div class="page-header">
        <h1><i class="bi bi-flag me-2"></i>Minhas Denúncias</h1>
    </div>

    {{-- Formulário de nova denúncia --}}
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title"><i class="bi bi-plus-circle me-2"></i>Nova Denúncia</h5>
            <form action="{{ route('cliente.denuncias.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="imovel_id" class="form-label">Imóvel <span class="text-danger">*</span></label>
                    <select name="imovel_id" id="imovel_id" class="form-select @error('imovel_id') is-invalid @enderror" required>
                        <option value="">-- Escolha o imóvel --</option>
                        @foreach($imoveis as $imovel)
                        <option value="{{ $imovel->id }}" {{ old('imovel_id') == $imovel->id ? 'selected' : '' }}>
                            {{ substr($imovel->titulo, 0, 60) }} ({{ $imovel->referencia }})
                        </option>
                        @endforeach
                    </select>
                    @error('imovel_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="motivo" class="form-label">Motivo <span class="text-danger">*</span></label>
                    <select name="motivo" id="motivo" class="form-select @error('motivo') is-invalid @enderror" required>
                        <option value="">-- Escolha o motivo --</option>
                        <option value="spam" {{ old('motivo') === 'spam' ? 'selected' : '' }}>Spam</option>
                        <option value="informacao_falsa" {{ old('motivo') === 'informacao_falsa' ? 'selected' : '' }}>Informação falsa</option>
                        <option value="imovel_inexistente" {{ old('motivo') === 'imovel_inexistente' ? 'selected' : '' }}>Imóvel inexistente</option>
                        <option value="preco_incorreto" {{ old('motivo') === 'preco_incorreto' ? 'selected' : '' }}>Preço incorreto</option>
                        <option value="violacao" {{ old('motivo') === 'violacao' ? 'selected' : '' }}>Violação de regras</option>
                        <option value="outro" {{ old('motivo') === 'outro' ? 'selected' : '' }}>Outro</option>
                    </select>
                    @error('motivo')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="descricao" class="form-label">Descrição <span class="text-danger">*</span></label>
                    <textarea name="descricao" id="descricao" rows="4" class="form-control @error('descricao') is-invalid @enderror"
                        placeholder="Descreva o problema com o imóvel..." required>{{ old('descricao') }}</textarea>
                    @error('descricao')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-send me-1"></i>Enviar Denúncia
                </button>
            </form>
        </div>
    </div>

    {{-- Lista de denúncias --}}
    @if($denuncias->isEmpty())
    <div class="empty-state">
        <i class="bi bi-flag bi-3x mb-3 opacity-50"></i>
        <h3>Sem denúncias</h3>
        <p>Não enviou nenhuma denúncia ainda.</p>
    </div>
    @else
    <div class="denuncias-lista">
        @foreach($denuncias as $denuncia)
        <div class="denuncia-item">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="fw-bold">
                        @if($denuncia->imovel)
                        <a href="{{ route('imoveis.show', $denuncia->imovel->referencia) }}">
                            {{ substr($denuncia->imovel->titulo, 0, 50) }}
                        </a>
                        @else
                        Imóvel removido
                        @endif
                    </div>
                    <div class="text-muted small">
                        Motivo: <strong>{{ $denuncia->motivo }}</strong> ·
                        {{ $denuncia->created_at->format('d/m/Y H:i') }}
                    </div>
                    <div class="mt-1">{{ Str::limit($denuncia->descricao, 120) }}</div>
                </div>
                <span class="badge {{ $denuncia->estado === 'pendente' ? 'bg-warning text-dark' : ($denuncia->estado === 'em_analise' ? 'bg-info text-dark' : ($denuncia->estado === 'resolvida' ? 'bg-success' : 'bg-secondary')) }}">
                    {{ ucfirst($denuncia->estado) }}
                </span>
            </div>
            @if($denuncia->resolucao)
            <div class="mt-2 p-2 bg-light rounded small">
                <strong>Resolução:</strong> {{ $denuncia->resolucao }}
            </div>
            @endif
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection
