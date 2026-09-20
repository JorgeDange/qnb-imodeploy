@extends('layouts.painel')

@section('title', 'Meu Perfil — Painel | QNB-Imobiliária')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <!-- Dados da Empresa -->
        <div class="ul-painel-card">
            <h3 class="ul-painel-card-titulo">Dados da Empresa</h3>
            <form action="{{ route('painel.perfil.update') }}" method="POST" class="ul-painel-form" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="ul-painel-form-seccao">
                    <div class="row">
                        <div class="col-md-6"><div class="form-group"><label>Nome *</label><input type="text" name="nome" value="{{ $imobiliaria->nome }}" required></div></div>
                        <div class="col-md-6"><div class="form-group"><label>NIF</label><input type="text" name="nif" value="{{ $imobiliaria->nif }}"></div></div>
                        <div class="col-md-6"><div class="form-group"><label>Email *</label><input type="email" name="email" value="{{ $imobiliaria->email }}" required></div></div>
                        <div class="col-md-6"><div class="form-group"><label>Telefone *</label><input type="text" name="telefone" value="{{ $imobiliaria->telefone }}" required></div></div>
                        <div class="col-md-6"><div class="form-group"><label>Província</label><select name="provincia"><option value="">Selecione</option>@foreach(['Luanda','Benguela','Huambo','Huíla','Cabinda','Malanje','Namibe','Uíge'] as $prov)<option value="{{ $prov }}" {{ $imobiliaria->provincia == $prov ? 'selected' : '' }}>{{ $prov }}</option>@endforeach</select></div></div>
                        <div class="col-md-6"><div class="form-group"><label>Município</label><input type="text" name="municipio" value="{{ $imobiliaria->municipio }}"></div></div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Foto de Perfil</label>
                                <div class="ul-painel-foto-upload">
                                    @if($imobiliaria->foto)
                                        <img src="{{ str_starts_with($imobiliaria->foto, 'assets/') ? asset($imobiliaria->foto) : asset('storage/' . $imobiliaria->foto) }}" alt="{{ $imobiliaria->nome }}" class="ul-painel-foto-preview" id="fotoPreview">
                                    @else
                                        <div class="ul-painel-foto-placeholder" id="fotoPreview">
                                            <i class="bi bi-camera"></i>
                                        </div>
                                    @endif
                                    <div class="ul-painel-foto-actions">
                                        <input type="file" name="foto" id="fotoInput" accept="image/*" style="display:none">
                                        <button type="button" class="ul-btn ul-btn--outline" onclick="document.getElementById('fotoInput').click()">Escolher Foto</button>
                                        <small class="ul-painel-foto-info">JPEG, PNG ou WebP. Máx. 2MB.</small>
                                    </div>
                                </div>
                                @error('foto')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="ul-btn">Salvar Alterações</button>
                </div>
            </form>
        </div>
    </div>

    <div class="col-lg-4">
        <!-- Estado da Conta -->
        <div class="ul-painel-card">
            <h3 class="ul-painel-card-titulo">Estado da Conta</h3>
            <div class="ul-painel-grid-dados">
                <div class="ul-painel-dado">
                    <span class="ul-painel-dado-rotulo">Estado</span>
                    <span class="ul-painel-dado-valor"><span class="ul-badge ul-badge--{{ $imobiliaria->estado }}">{{ ucfirst($imobiliaria->estado) }}</span></span>
                </div>
            </div>
            @if($imobiliaria->estado === 'pendente')
            <div class="ul-painel-aviso ul-painel-aviso--cinza" style="margin-top:15px;">
                <div class="ul-painel-aviso-icone"><i class="bi bi-calendar"></i></div>
                <div class="ul-painel-aviso-texto"><p>A sua conta aguarda aprovação da equipa QNB.</p></div>
            </div>
            @elseif($imobiliaria->estado === 'aprovada' && !$plano)
            <div class="ul-painel-aviso" style="margin-top:15px;">
                <div class="ul-painel-aviso-icone"><i class="bi bi-star"></i></div>
                <div class="ul-painel-aviso-texto"><p><a href="{{ route('painel.ativar-plano') }}">Ative o seu plano</a> para começar a publicar imóveis.</p></div>
            </div>
            @endif
        </div>

        <!-- Plano -->
        @if($plano)
        <div class="ul-painel-card" style="margin-top:15px;">
            <h3 class="ul-painel-card-titulo">Plano Ativo</h3>
            <div class="ul-painel-grid-dados">
                <div class="ul-painel-dado"><span class="ul-painel-dado-rotulo">Tipo</span><span class="ul-painel-dado-valor">{{ $plano->plano->nome }}</span></div>
                <div class="ul-painel-dado"><span class="ul-painel-dado-rotulo">Posts</span><span class="ul-painel-dado-valor">{{ $plano->posts_usados }} / {{ $plano->plano->posts_limite }}</span></div>
                <div class="ul-painel-dado"><span class="ul-painel-dado-rotulo">Validade</span><span class="ul-painel-dado-valor">{{ $plano->data_expiracao ? $plano->data_expiracao->format('d/m/Y') : 'Indefinida' }}</span></div>
            </div>
        </div>
        @endif

        <!-- Atalhos -->
        <div class="ul-painel-card" style="margin-top:15px;">
            <h3 class="ul-painel-card-titulo">Configurações</h3>
            <div class="ul-painel-contactos">
                <a href="{{ route('painel.perfil.canais') }}" class="ul-painel-contacto">
                    <div class="ul-painel-contacto-icone"><i class="bi bi-diagram-3"></i></div>
                    <span>Canais de Contacto</span>
                </a>
                <a href="{{ route('painel.perfil.password') }}" class="ul-painel-contacto">
                    <div class="ul-painel-contacto-icone"><i class="bi bi-key"></i></div>
                    <span>Alterar Password</span>
                </a>
            </div>
        </div>
    </div>
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
                img.className = 'ul-painel-foto-preview';
                img.id = 'fotoPreview';
                preview.replaceWith(img);
            }
        };
        reader.readAsDataURL(file);
    }
});
</script>
@endpush
