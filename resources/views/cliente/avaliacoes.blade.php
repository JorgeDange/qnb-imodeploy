@extends('cliente.layout')

@section('cliente-content')
<div class="avaliacoes-page">
    <div class="page-header">
        <h1><i class="bi bi-star me-2"></i>Minhas Avaliações</h1>
    </div>

    {{-- Formulário de nova avaliação --}}
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title"><i class="bi bi-plus-circle me-2"></i>Nova Avaliação</h5>
            <form action="{{ route('cliente.avaliacoes.store') }}" method="POST">
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
                    <label class="form-label">Estrelas <span class="text-danger">*</span></label>
                    <div class="estrelas-input">
                        @for($i = 1; $i <= 5; $i++)
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="estrelas" id="estrelas-{{ $i }}" value="{{ $i }}" {{ old('estrelas') == $i ? 'checked' : '' }} required>
                            <label class="form-check-label" for="estrelas-{{ $i }}">{{ $i }} ★</label>
                        </div>
                        @endfor
                    </div>
                    @error('estrelas')
                    <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="comentario" class="form-label">Comentário</label>
                    <textarea name="comentario" id="comentario" rows="4" class="form-control @error('comentario') is-invalid @enderror"
                        placeholder="Partilhe a sua experiência...">{{ old('comentario') }}</textarea>
                    @error('comentario')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-send me-1"></i>Enviar Avaliação
                </button>
            </form>
        </div>
    </div>

    {{-- Lista de avaliações --}}
    @if($avaliacoes->isEmpty())
    <div class="empty-state">
        <i class="bi bi-star bi-3x mb-3 opacity-50"></i>
        <h3>Sem avaliações</h3>
        <p>Não enviou nenhuma avaliação ainda.</p>
    </div>
    @else
    <div class="avaliacoes-lista">
        @foreach($avaliacoes as $avaliacao)
        <div class="avaliacao-item">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="fw-bold">
                        @if($avaliacao->imovel)
                        <a href="{{ route('imoveis.show', $avaliacao->imovel->referencia) }}">
                            {{ substr($avaliacao->imovel->titulo, 0, 50) }}
                        </a>
                        @else
                        Imóvel removido
                        @endif
                    </div>
                    <div class="text-warning">
                        @for($i = 1; $i <= 5; $i++)
                        <i class="bi bi-star {{ $i <= $avaliacao->estrelas ? '' : 'opacity-25' }}"></i>
                        @endfor
                    </div>
                    <div class="mt-1">{{ Str::limit($avaliacao->comentario, 150) }}</div>
                    <div class="text-muted small">{{ $avaliacao->created_at->format('d/m/Y H:i') }}</div>
                </div>
                <div class="text-end">
                    <span class="badge {{ $avaliacao->estado === 'aprovada' ? 'bg-success' : ($avaliacao->estado === 'pendente' ? 'bg-warning text-dark' : 'bg-danger') }}">
                        {{ ucfirst($avaliacao->estado) }}
                    </span>
                    @if($avaliacao->estado === 'rejeitada')
                    <form action="{{ route('cliente.avaliacoes.reenviar', $avaliacao->id) }}" method="POST" class="mt-2">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-primary" title="Corrigir e reenviar">
                            <i class="bi bi-arrow-clockwise me-1"></i>Reenviar
                        </button>
                    </form>
                    @endif
                </div>
            </div>
            @if($avaliacao->motivo_rejeicao)
            <div class="mt-2 p-2 bg-light rounded small">
                <strong>Motivo da rejeição:</strong> {{ $avaliacao->motivo_rejeicao }}
            </div>
            @endif
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection
