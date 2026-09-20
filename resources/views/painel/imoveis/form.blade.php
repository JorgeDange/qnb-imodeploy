@extends('layouts.painel')

@section('title', ($imovel ? 'Editar' : 'Novo') . ' Imóvel — Painel | QNB-Imobiliária')

@section('content')
@if($errors->any())
<div class="ul-painel-aviso ul-painel-aviso--destaque">
    <div class="ul-painel-aviso-icone"><i class="bi bi-info-circle"></i></div>
    <div class="ul-painel-aviso-texto">
        <h4 class="ul-painel-aviso-titulo">Erros de validação</h4>
        @foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach
    </div>
</div>
@endif

<form action="{{ $imovel ? route('painel.imoveis.update', $imovel->id) : route('painel.imoveis.store') }}" method="POST" enctype="multipart/form-data" class="ul-painel-form">
    @csrf
    @if($imovel) @method('PUT') @endif

    <!-- Dados Gerais -->
    <div class="ul-painel-card">
        <h3 class="ul-painel-card-titulo">Dados Gerais</h3>
        <div class="ul-painel-form-seccao">
            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        <label>Título *</label>
                        <input type="text" name="titulo" value="{{ old('titulo', $imovel->titulo ?? '') }}" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Referência</label>
                        <input type="text" value="{{ $imovel->referencia ?? 'Auto-gerada' }}" disabled>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label>Descrição</label>
                        <textarea name="descricao" rows="4">{{ old('descricao', $imovel->descricao ?? '') }}</textarea>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Preço *</label>
                        <input type="number" name="preco" value="{{ old('preco', $imovel->preco ?? '') }}" min="0" step="0.01" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Moeda *</label>
                        <select name="moeda" required>
                            <option value="Kz" {{ old('moeda', $imovel->moeda ?? '') == 'Kz' ? 'selected' : '' }}>Kz (Kwanza)</option>
                            <option value="USD" {{ old('moeda', $imovel->moeda ?? '') == 'USD' ? 'selected' : '' }}>USD (Dólar)</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Finalidade *</label>
                        <select name="finalidade" required>
                            <option value="arrendar" {{ old('finalidade', $imovel->finalidade ?? '') == 'arrendar' ? 'selected' : '' }}>Arrendar</option>
                            <option value="vender" {{ old('finalidade', $imovel->finalidade ?? '') == 'vender' ? 'selected' : '' }}>Vender</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Tipo *</label>
                        <select name="tipo" required>
                            @foreach(['apartamento' => 'Apartamento', 'vivenda' => 'Vivenda', 'terreno' => 'Terreno', 'loja' => 'Loja', 'escritorio' => 'Escritório', 'armazem' => 'Armazém', 'quintal' => 'Quintal'] as $val => $label)
                            <option value="{{ $val }}" {{ old('tipo', $imovel->tipo ?? '') == $val ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Características -->
    <div class="ul-painel-card">
        <h3 class="ul-painel-card-titulo">Características</h3>
        <div class="ul-painel-form-seccao">
            <div class="row">
                <div class="col-md-4"><div class="form-group"><label>Área (m²)</label><input type="number" name="area" value="{{ old('area', $imovel->area ?? '') }}" min="0"></div></div>
                <div class="col-md-4"><div class="form-group"><label>Quartos</label><input type="number" name="quartos" value="{{ old('quartos', $imovel->quartos ?? '') }}" min="0"></div></div>
                <div class="col-md-4"><div class="form-group"><label>WC</label><input type="number" name="wc" value="{{ old('wc', $imovel->wc ?? '') }}" min="0"></div></div>
                <div class="col-md-4"><div class="form-group"><label>Estacionamento</label><input type="number" name="estacionamento" value="{{ old('estacionamento', $imovel->estacionamento ?? '') }}" min="0"></div></div>
                <div class="col-md-4"><div class="form-group"><label>Ano Construção</label><input type="number" name="ano_construcao" value="{{ old('ano_construcao', $imovel->ano_construcao ?? '') }}" min="1900" max="{{ date('Y') }}"></div></div>
                <div class="col-md-4"><div class="form-group"><label>Estado *</label><select name="estado_imovel" required><option value="novo" {{ old('estado_imovel', $imovel->estado_imovel ?? '') == 'novo' ? 'selected' : '' }}>Novo</option><option value="usado" {{ old('estado_imovel', $imovel->estado_imovel ?? '') == 'usado' ? 'selected' : '' }}>Usado</option></select></div></div>
            </div>
        </div>
    </div>

    <!-- Localização -->
    <div class="ul-painel-card">
        <h3 class="ul-painel-card-titulo">Localização</h3>
        <div class="ul-painel-form-seccao">
            <div class="row">
                <div class="col-md-4"><div class="form-group"><label>Província *</label><select name="provincia" required><option value="">Selecione</option>@foreach(['Luanda','Benguela','Huambo','Huíla','Cabinda','Malanje','Namibe','Uíge','Cuanza-Norte','Cuanza-Sul','Bengo','Icolo-e-Bengo','Cunene','Cuando-Cubango','Moxico','Zaire'] as $prov)<option value="{{ $prov }}" {{ old('provincia', $imovel->provincia ?? '') == $prov ? 'selected' : '' }}>{{ $prov }}</option>@endforeach</select></div></div>
                <div class="col-md-4"><div class="form-group"><label>Município *</label><input type="text" name="municipio" value="{{ old('municipio', $imovel->municipio ?? '') }}" required></div></div>
                <div class="col-md-4"><div class="form-group"><label>Bairro</label><input type="text" name="bairro" value="{{ old('bairro', $imovel->bairro ?? '') }}"></div></div>
                <div class="col-md-6"><div class="form-group"><label>Endereço</label><input type="text" name="endereco" value="{{ old('endereco', $imovel->endereco ?? '') }}"></div></div>
            </div>
        </div>
    </div>

    <!-- Fotos -->
    <div class="ul-painel-card">
        <h3 class="ul-painel-card-titulo">Fotos {{ $imovel ? '(deixe vazio para manter as atuais)' : '' }}</h3>
        <div class="ul-painel-form-seccao">
            @if($imovel && $imovel->fotos->count())
            <div class="ul-fotos-preview mb-3">
                @foreach($imovel->fotos->sortBy('ordem') as $foto)
                <div class="ul-fotos-preview-img" style="position:relative;display:inline-block;margin:5px;">
                    <img src="{{ asset('storage/' . $foto->caminho) }}" alt="{{ $foto->legenda }}" style="width:100px;height:75px;object-fit:cover;border-radius:6px;">
                    @if($foto->capa)<span style="position:absolute;top:2px;left:2px;background:var(--ul-primary);color:#fff;font-size:10px;padding:2px 6px;border-radius:10px;">Capa</span>@endif
                </div>
                @endforeach
            </div>
            @endif
            <div class="form-group">
                <label>{{ $imovel ? 'Novas Fotos (mínimo 5, máximo 10)' : 'Fotos (mínimo 5, máximo 10)' }} *</label>
                <input type="file" name="fotos[]" multiple accept="image/jpeg,image/png,image/webp" {{ $imovel ? '' : 'required' }}>
                <small style="color:#999;">JPEG, PNG ou WebP. Máximo 5MB cada. Primeira foto será a capa.</small>
            </div>
        </div>
    </div>

    <!-- Amenidades -->
    <div class="ul-painel-card">
        <h3 class="ul-painel-card-titulo">Amenidades</h3>
        <div class="ul-painel-form-seccao">
            <div class="ul-amenidades-grid">
                @foreach($amenidades as $amenidade)
                <div class="ul-checkbox">
                    <input type="checkbox" name="amenidades[]" value="{{ $amenidade->id }}" id="amenidade-{{ $amenidade->id }}" {{ in_array($amenidade->id, old('amenidades', $imovel ? $imovel->amenidades->pluck('id')->toArray() : [])) ? 'checked' : '' }}>
                    <label for="amenidade-{{ $amenidade->id }}">{{ $amenidade->nome }}</label>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Submit -->
    <div class="ul-painel-card">
        <div class="ul-painel-form-seccao">
            <button type="submit" class="ul-btn"><i class="bi bi-check-lg"></i> {{ $imovel ? 'Salvar Alterações' : 'Cadastrar Imóvel' }}</button>
            <a href="{{ route('painel.imoveis') }}" class="ul-btn" style="margin-left:10px;">Cancelar</a>
        </div>
    </div>
</form>
@endsection
