@extends('layouts.site')

@section('title', 'QNB-Imobiliária - Contacto')
@section('pagina', 'contacto')

@section('content')
<!-- BREADCRUMB SECTION START -->
<div class="ul-breadcrumb">
    <div class="wow animate__fadeInUp">
        <h2 class="ul-breadcrumb-title">Contacto</h2>
        <div class="ul-breadcrumb-nav">
            <a href="{{ route('home') }}">Início</a>
            <span class="separator"><i class="flaticon-aro-left"></i></span>
            <span class="current-page">Contacto</span>
        </div>
    </div>
</div>
<!-- BREADCRUMB SECTION END -->


<!-- CONTACT SECTION START -->
<div class="ul-inner-page-content-wrapper">
    <div class="ul-inner-page-container">
        <div class="ul-contact">
            <div class="row g-0">
                <!-- contact infos -->
                <div class="col-md-5">
                    <div class="ul-contact-infos-wrapper">
                        <div class="heading">
                            <h3 class="ul-contact-infos-title">Informações de Contacto</h3>
                            <span class="ul-contact-infos-sub-title">Fale com a equipa QNB - resposta rápida!</span>
                        </div>

                        <!-- infos -->
                        <div class="ul-contact-infos">
                            <a href="tel:+244921852727" class="ul-contact-info"><i class="flaticon-telephone"></i> +244 921 852 727</a>
                            <a href="mailto:comercial@qnbangola.com" class="ul-contact-info"><i class="flaticon-mail"></i> comercial@qnbangola.com</a>
                            <a href="https://maps.app.goo.gl/ZXfSYE7ThcibKAXJ6" target="_blank" rel="noopener" class="ul-contact-info">
                                <i class="flaticon-location-pin"></i>
                                <span class="txt">Morro Bento, Rua da Anghotel, Luanda</span>
                            </a>
                        </div>

                        <!-- socials -->
                        <div class="ul-contact-socials">
                            <a href="#"><i class="flaticon-twitter-1"></i></a>
                            <a href="https://www.instagram.com/qnbangola" target="_blank" rel="noopener"><i class="flaticon-instagram"></i></a>
                            <a href="https://www.linkedin.com/in/qnbangola" target="_blank" rel="noopener"><i class="flaticon-linkedin"></i></a>
                        </div>
                    </div>
                </div>

                <!-- form -->
                <div class="col-md-7">
                    <div class="ul-contact-form-wrapper">

                        @if(session('success'))
                        <div style="padding: 12px; background: #d4edda; color: #155724; border-radius: 6px; margin-bottom: 16px;">
                            {{ session('success') }}
                        </div>
                        @endif

                        @if($errors->any())
                        <div style="padding: 12px; background: #f8d7da; color: #721c24; border-radius: 6px; margin-bottom: 16px;">
                            @foreach($errors->all() as $error)
                            <p style="margin: 0;">{{ $error }}</p>
                            @endforeach
                        </div>
                        @endif

                        <form action="{{ route('contacto.enviar') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="contact-first-name">Primeiro Nome</label>
                                <input type="text" name="nome" id="contact-first-name" placeholder="João" required>
                            </div>

                            <div class="form-group">
                                <label for="contact-last-name">Apelido</label>
                                <input type="text" name="apelido" id="contact-last-name" placeholder="Silva" required>
                            </div>

                            <div class="form-group">
                                <label for="contact-email">Email</label>
                                <input type="email" name="email" id="contact-email" placeholder="exemplo@qnbimobiliaria.ao" required>
                            </div>

                            <div class="form-group">
                                <label for="contact-phone">Número de Telefone</label>
                                <input type="tel" name="telefone" id="contact-phone" placeholder="+244 900 000 000" required>
                            </div>

                            <div class="form-group">
                                <span class="contact-inner-title">Selecione o Assunto</span>
                                <div class="ul-contact-form-subjects">
                                    <!-- subject 1 -->
                                    <div class="ul-radio">
                                        <label for="contact-subject-1">
                                            <input type="radio" name="assunto" id="contact-subject-1" value="Informação Geral" checked>
                                            <span class="checkmark"><i class="flaticon-check-2"></i></span>
                                            <span class="txt">Informação Geral</span>
                                        </label>
                                    </div>
                                    <!-- subject 2 -->
                                    <div class="ul-radio">
                                        <label for="contact-subject-2">
                                            <input type="radio" name="assunto" id="contact-subject-2" value="Consulta de Imóvel">
                                            <span class="checkmark"><i class="flaticon-check-2"></i></span>
                                            <span class="txt">Consulta de Imóvel</span>
                                        </label>
                                    </div>
                                    <!-- subject 3 -->
                                    <div class="ul-radio">
                                        <label for="contact-subject-3">
                                            <input type="radio" name="assunto" id="contact-subject-3" value="Parceria">
                                            <span class="checkmark"><i class="flaticon-check-2"></i></span>
                                            <span class="txt">Parceria</span>
                                        </label>
                                    </div>
                                    <!-- subject 4 -->
                                    <div class="ul-radio">
                                        <label for="contact-subject-4">
                                            <input type="radio" name="assunto" id="contact-subject-4" value="Outro">
                                            <span class="checkmark"><i class="flaticon-check-2"></i></span>
                                            <span class="txt">Outro</span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="contact-message">Mensagem</label>
                                <textarea name="mensagem" id="contact-message" placeholder="Escreva a sua mensagem" required></textarea>
                            </div>

                            <button class="ul-btn">Enviar Mensagem</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<iframe src="https://www.google.com/maps?q=Morro%20Bento%2C%20Luanda&output=embed" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" class="ul-contact-map"></iframe>
<!-- CONTACT SECTION END -->
@endsection
