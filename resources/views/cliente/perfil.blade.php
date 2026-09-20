@extends('cliente.layout')

@section('cliente-content')
<div class="page-header">
    <h1><i class="bi bi-person me-2"></i>Meu Perfil</h1>
</div>

@if(session('sucesso'))
<div class="ul-auth-note" style="background-color:#E8F5E9;border-left-color:#2E7D32;">{{ session('sucesso') }}</div>
@endif

@if($errors->any())
<div class="ul-auth-note">
    @foreach($errors->all() as $error)
    <p style="margin:0;">{{ $error }}</p>
    @endforeach
</div>
@endif

<!-- Foto de perfil -->
<div class="perfil-card">
    <h3 class="perfil-card-title">Foto de Perfil</h3>

    <div class="perfil-foto-area">
        <div class="perfil-foto-preview">
            @if($cliente->foto)
                <img src="{{ str_starts_with($cliente->foto, 'assets/') ? asset($cliente->foto) : asset('storage/' . $cliente->foto) }}" alt="{{ $cliente->nome }}" id="fotoPreview">
            @else
                @php
                    $nome = trim($cliente->nome);
                    $palavras = explode(' ', $nome);
                    $primeiro = strtoupper(mb_substr($palavras[0], 0, 1));
                    $ultimo = strtoupper(mb_substr(end($palavras), -1, 1));
                @endphp
                <div class="perfil-foto-initials" id="fotoPreview">{{ $primeiro }}{{ $ultimo }}</div>
            @endif
        </div>

        @if($cliente->podeUploadFoto())
        <form action="{{ route('cliente.perfil.foto') }}" method="POST" enctype="multipart/form-data" class="perfil-foto-form">
            @csrf
            @method('POST')
            <input type="file" name="foto" id="fotoInput" accept="image/jpeg,image/png,image/webp" style="display:none">
            <button type="button" class="ul-btn ul-btn--outline" onclick="document.getElementById('fotoInput').click()">Escolher Foto</button>
            <small class="perfil-foto-info">JPEG, PNG ou WebP. Máx. 2MB.</small>
            <button type="submit" class="ul-btn" id="btnUpload" style="display:none;">Salvar Foto</button>
        </form>
        @else
        <div class="perfil-foto-bloqueado">
            <p><i class="bi bi-lock"></i> Pode voltar a alterar a foto em <strong>{{ $cliente->diasParaProximoUpload() }} dia(s)</strong>.</p>
            <small>Limite: 1 alteração por mês.</small>
        </div>
        @endif
    </div>
</div>

<!-- Dados pessoais -->
<div class="perfil-card" style="margin-top: clamp(20px, 1.58vw, 30px);">
    <h3 class="perfil-card-title">Dados Pessoais</h3>

    <form class="ul-auth-form" method="POST" action="{{ route('cliente.perfil.update') }}">
        @csrf
        @method('PUT')

        <div class="perfil-field">
            <label for="nome">Nome completo</label>
            <input type="text" name="nome" id="nome" value="{{ old('nome', $cliente->nome) }}" required>
        </div>

        <div class="perfil-field">
            <label for="email">E-mail</label>
            <input type="email" name="email" id="email" value="{{ old('email', $cliente->email) }}" required>
        </div>

        <div class="perfil-field">
            <label for="telefone">Telefone</label>
            <input type="tel" name="telefone" id="telefone" value="{{ old('telefone', $cliente->telefone) }}">
        </div>

        <button type="submit" class="ul-btn">Guardar Alterações</button>
    </form>
</div>

<!-- Mudar password -->
<div class="perfil-card" style="margin-top: clamp(20px, 1.58vw, 30px);">
    <h3 class="perfil-card-title">Alterar Password</h3>

    <form class="ul-auth-form" method="POST" action="{{ route('cliente.perfil.password') }}">
        @csrf
        @method('PUT')

        <div class="perfil-field">
            <label for="password_atual">Password atual</label>
            <input type="password" name="password_atual" id="password_atual" required>
        </div>

        <div class="perfil-field">
            <label for="password">Nova password</label>
            <input type="password" name="password" id="password" required>
        </div>

        <div class="perfil-field">
            <label for="password_confirmation">Confirmar nova password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" required>
        </div>

        <button type="submit" class="ul-btn">Atualizar Password</button>
    </form>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('fotoInput')?.addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(ev) {
            const preview = document.getElementById('fotoPreview');
            if (preview.tagName === 'IMG') {
                preview.src = ev.target.result;
            } else {
                const img = document.createElement('img');
                img.src = ev.target.result;
                img.alt = 'Preview';
                img.id = 'fotoPreview';
                img.style.cssText = 'width:100px;height:100px;border-radius:50%;object-fit:cover;';
                preview.replaceWith(img);
            }
            document.getElementById('btnUpload').style.display = 'inline-block';
        };
        reader.readAsDataURL(file);
    }
});
</script>
@endpush
