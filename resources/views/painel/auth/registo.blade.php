<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel — Registo | QNB-Imobiliária</title>

    <!-- libraries CSS -->
    <link rel="stylesheet" href="{{ asset('assets/icon/flaticon_real_estate.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/animate-wow/animate.min.css') }}">

    <!-- custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('painel-assets/css/painel.css') }}">
    <link rel="icon" type="image/svg+xml" href="{{ asset('assets/img/logo-c.svg') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
</head>

<body>
    <div class="preloader" id="preloader">
        <div class="loader"></div>
    </div>

    <div class="ul-painel">

        <!-- TOPBAR -->
        <div class="ul-painel-topbar">
            <div class="ul-painel-topbar-left">
                <a href="{{ route('home') }}"><img src="{{ asset('assets/img/logo.svg') }}" alt="QNB-Imobiliária" class="logo"></a>
            </div>
            <div class="ul-painel-topbar-right">
                <a href="{{ route('home') }}" class="ul-painel-ver-site">Ver site público</a>
            </div>
        </div>

        <!-- AUTH -->
        <div class="ul-auth">
            <div class="ul-auth-card">
                <a href="{{ route('painel.login') }}" class="ul-auth-voltar"><i class="bi bi-arrow-left"></i> Voltar ao login</a>
                <div class="ul-auth-logo">
                    <img src="{{ asset('assets/img/logo-c.svg') }}" alt="QNB-Imobiliária">
                </div>
                <h2 class="ul-auth-titulo">Registe a sua conta</h2>
                <p class="ul-auth-subtitulo">Crie a sua conta para aceder ao painel.</p>

                @if($errors->any())
                <div class="ul-auth-erro" style="display:block;">
                    @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                    @endforeach
                </div>
                @endif

                <form class="ul-painel-form" id="ul-form-registo" method="POST" action="{{ route('painel.registo.post') }}">
                    @csrf
                    <div class="ul-auth-campos imobiliaria">
                        <div class="form-group">
                            <label for="nome">Nome da Imobiliária*</label>
                            <input type="text" id="nome" name="nome" placeholder="Nome da empresa" value="{{ old('nome') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="nif">NIF</label>
                            <input type="text" id="nif" name="nif" placeholder="Número de identificação fiscal" value="{{ old('nif') }}">
                        </div>
                        <div class="form-group">
                            <label for="email">Email*</label>
                            <input type="email" id="email" name="email" placeholder="Email de contacto" value="{{ old('email') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="telefone">Telefone*</label>
                            <input type="tel" id="telefone" name="telefone" placeholder="Número de telefone" value="{{ old('telefone') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="provincia">Província</label>
                            <select id="provincia" name="provincia">
                                <option value="">Selecione</option>
                                <option value="Luanda" {{ old('provincia') == 'Luanda' ? 'selected' : '' }}>Luanda</option>
                                <option value="Benguela" {{ old('provincia') == 'Benguela' ? 'selected' : '' }}>Benguela</option>
                                <option value="Huambo" {{ old('provincia') == 'Huambo' ? 'selected' : '' }}>Huambo</option>
                                <option value="Huíla" {{ old('provincia') == 'Huíla' ? 'selected' : '' }}>Huíla</option>
                                <option value="Cabinda" {{ old('provincia') == 'Cabinda' ? 'selected' : '' }}>Cabinda</option>
                                <option value="Malanje" {{ old('provincia') == 'Malanje' ? 'selected' : '' }}>Malanje</option>
                                <option value="Namibe" {{ old('provincia') == 'Namibe' ? 'selected' : '' }}>Namibe</option>
                                <option value="Uíge" {{ old('provincia') == 'Uíge' ? 'selected' : '' }}>Uíge</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="municipio">Município</label>
                            <input type="text" id="municipio" name="municipio" placeholder="Município" value="{{ old('municipio') }}">
                        </div>
                        <div class="form-group">
                            <label for="password">Palavra-passe*</label>
                            <input type="password" id="password" name="password" placeholder="Crie uma palavra-passe" required>
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">Confirmar Palavra-passe*</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Repita a palavra-passe" required>
                        </div>
                        <p class="ul-auth-subtitulo" style="text-align:left;font-size:12.5px;">Depois do registo, a sua conta fica <strong>pendente</strong> até aprovação da equipa QNB. Só poderá publicar imóveis depois de ativar um plano.</p>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="ul-btn w-100"><i class="bi bi-house-check"></i> Criar Conta</button>
                    </div>
                </form>

                <p class="ul-auth-alternativa">Já tem conta? <a href="{{ route('painel.login') }}">Entrar</a></p>
            </div>
        </div>

        <!-- RODAPÉ SIMPLIFICADO -->
        <footer class="ul-painel-rodape">
            <span>© 2026 QNB-Imobiliária. Todos os direitos reservados.</span>
            <span><a href="{{ route('home') }}">Voltar ao site</a></span>
        </footer>
    </div>

    <!-- scripts -->
    <script src="{{ asset('assets/vendor/bootstrap/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/qnb-api.js') }}"></script>
    <script src="{{ asset('painel-assets/js/painel-auth.js') }}"></script>
    <script src="{{ asset('painel-assets/js/painel-loader.js') }}"></script>
</body>

</html>
