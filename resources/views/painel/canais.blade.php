@extends('layouts.painel')

@section('title', 'Canais de Contacto — Painel')

@section('content')
<div class="ul-painel-cabecalho">
    <h1 class="ul-painel-titulo">Canais de Contacto</h1>
    <a href="{{ route('painel.perfil') }}" class="ul-painel-btn ul-painel-btn--cinza"><i class="bi bi-arrow-left"></i> Voltar</a>
</div>

<div class="ul-painel-card">
    <p style="font-size:13.5px;color:var(--ul-gray2);margin-bottom:18px;">Defina os canais de contacto que são apresentados nos seus imóveis.</p>

    <form action="{{ route('painel.perfil.canais.salvar') }}" method="POST" class="ul-painel-form">
        @csrf
        <div id="canais-container">
            @forelse($canais as $i => $canal)
            <div class="canal-row" style="display:flex;gap:10px;align-items:end;margin-bottom:10px;">
                <div class="form-group" style="flex:1;margin-bottom:0;">
                    <label>Tipo</label>
                    <select name="canais[{{ $i }}][tipo]" class="ul-painel-form-input">
                        <option value="telefone" {{ $canal->tipo === 'telefone' ? 'selected' : '' }}>Telefone</option>
                        <option value="whatsapp" {{ $canal->tipo === 'whatsapp' ? 'selected' : '' }}>WhatsApp</option>
                        <option value="email" {{ $canal->tipo === 'email' ? 'selected' : '' }}>Email</option>
                        <option value="facebook" {{ $canal->tipo === 'facebook' ? 'selected' : '' }}>Facebook</option>
                        <option value="instagram" {{ $canal->tipo === 'instagram' ? 'selected' : '' }}>Instagram</option>
                        <option value="linkedin" {{ $canal->tipo === 'linkedin' ? 'selected' : '' }}>LinkedIn</option>
                        <option value="outro" {{ $canal->tipo === 'outro' ? 'selected' : '' }}>Outro</option>
                    </select>
                </div>
                <div class="form-group" style="flex:2;margin-bottom:0;">
                    <label>Valor</label>
                    <input type="text" name="canais[{{ $i }}][valor]" class="ul-painel-form-input" value="{{ $canal->valor }}" placeholder="Ex: +244 921 852 727">
                </div>
                <button type="button" class="ul-painel-btn ul-painel-btn--perigo ul-painel-btn--pequeno remover-canal" title="Remover"><i class="bi bi-x-lg"></i></button>
            </div>
            @empty
            <div class="canal-row" style="display:flex;gap:10px;align-items:end;margin-bottom:10px;">
                <div class="form-group" style="flex:1;margin-bottom:0;">
                    <label>Tipo</label>
                    <select name="canais[0][tipo]" class="ul-painel-form-input">
                        <option value="telefone">Telefone</option>
                        <option value="whatsapp">WhatsApp</option>
                        <option value="email">Email</option>
                        <option value="facebook">Facebook</option>
                        <option value="instagram">Instagram</option>
                        <option value="linkedin">LinkedIn</option>
                        <option value="outro">Outro</option>
                    </select>
                </div>
                <div class="form-group" style="flex:2;margin-bottom:0;">
                    <label>Valor</label>
                    <input type="text" name="canais[0][valor]" class="ul-painel-form-input" placeholder="Ex: +244 921 852 727">
                </div>
                <button type="button" class="ul-painel-btn ul-painel-btn--perigo ul-painel-btn--pequeno remover-canal" title="Remover"><i class="bi bi-x-lg"></i></button>
            </div>
            @endforelse
        </div>

        <button type="button" id="add-canal" class="ul-painel-btn ul-painel-btn--cinza" style="margin-bottom:18px;"><i class="bi bi-plus-lg"></i> Adicionar Canal</button>

        <div>
            <button type="submit" class="ul-painel-btn ul-painel-btn--primario">Guardar</button>
        </div>
    </form>
</div>

@push('scripts')
<script>
document.getElementById('add-canal').addEventListener('click', function() {
    var container = document.getElementById('canais-container');
    var index = container.querySelectorAll('.canal-row').length;
    var html = '<div class="canal-row" style="display:flex;gap:10px;align-items:end;margin-bottom:10px;">';
    html += '<div class="form-group" style="flex:1;margin-bottom:0;"><label>Tipo</label>';
    html += '<select name="canais[' + index + '][tipo]" class="ul-painel-form-input">';
    html += '<option value="telefone">Telefone</option><option value="whatsapp">WhatsApp</option>';
    html += '<option value="email">Email</option><option value="facebook">Facebook</option>';
    html += '<option value="instagram">Instagram</option><option value="linkedin">LinkedIn</option>';
    html += '<option value="outro">Outro</option></select></div>';
    html += '<div class="form-group" style="flex:2;margin-bottom:0;"><label>Valor</label>';
    html += '<input type="text" name="canais[' + index + '][valor]" class="ul-painel-form-input" placeholder="Ex: +244 921 852 727"></div>';
    html += '<button type="button" class="ul-painel-btn ul-painel-btn--perigo ul-painel-btn--pequeno remover-canal" title="Remover"><i class="bi bi-x-lg"></i></button></div>';
    container.insertAdjacentHTML('beforeend', html);
});

document.addEventListener('click', function(e) {
    if (e.target.closest('.remover-canal')) {
        e.target.closest('.canal-row').remove();
    }
});
</script>
@endpush
@endsection
