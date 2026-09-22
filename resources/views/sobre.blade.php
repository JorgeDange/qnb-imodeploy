@extends('layouts.site')

@section('title', 'QNB-Imobiliária - Sobre a QNB')
@section('pagina', 'about')

@section('content')
<!-- BREADCRUMB SECTION START -->
<div class="ul-breadcrumb">
    <div class="wow animate__fadeInUp">
        <h2 class="ul-breadcrumb-title">Sobre a QNB</h2>
        <div class="ul-breadcrumb-nav">
            <a href="{{ route('home') }}">Início</a>
            <span class="separator"><i class="flaticon-aro-left"></i></span>
            <span class="current-page">Sobre a QNB</span>
        </div>
    </div>
</div>
<!-- BREADCRUMB SECTION END -->

<div class="ul-inner-page-content-wrapper">
    <!-- WHY CHOOSE US SECTION START -->
    <section class="ul-why-choose-us wow animate__fadeInUp">
        <div class="ul-inner-page-container">
            <div class="row row-cols-lg-2 row-cols-1 align-items-center">
                <div class="col">
                    <div class="ul-why-choose-us-imgs">
                        <div class="img"><img src="{{ asset('assets/img/why-choose-img-1.jpg') }}" alt="image"></div>
                        <div class="img">
                            <img src="{{ asset('assets/img/why-choose-img-2.jpg') }}" alt="image">
                            <!-- icon -->
                            <div class="icon"><i class="flaticon-home-agreement"></i></div>
                        </div>
                    </div>
                </div>

                <!-- txt -->
                <div class="col">
                    <div class="ul-why-choose-us-txt">
                        <span class="ul-section-sub-title">Porquê escolher a QNB</span>
                        <h2 class="ul-section-title">A QNB torna o seu sonho de habitação realidade</h2>
                        <p class="ul-why-choose-us-heading-descr">Anúncios imobiliários de confiança em todo o país</p>

                        <div class="ul-why-choose-us-list">
                            <div class="ul-why-choose-us-list-item">
                                <div class="icon"><i class="flaticon-property"></i></div>
                                <div class="txt">
                                    <h3 class="ul-why-choose-us-list-item-title">Variedade de Imóveis</h3>
                                    <p class="ul-why-choose-us-list-item-descr">Casas, apartamentos, terrenos e escritórios anunciados por imobiliárias e construtoras, com preços em Kz ou USD.</p>
                                </div>
                            </div>

                            <div class="ul-why-choose-us-list-item">
                                <div class="icon"><i class="flaticon-list-1"></i></div>
                                <div class="txt">
                                    <h3 class="ul-why-choose-us-list-item-title">Contacto Direto</h3>
                                    <p class="ul-why-choose-us-list-item-descr">Fale diretamente com a empresa anunciante de cada imóvel, sem intermediários nem taxas escondidas.</p>
                                </div>
                            </div>

                            <div class="ul-why-choose-us-list-item">
                                <div class="icon"><i class="flaticon-change"></i></div>
                                <div class="txt">
                                    <h3 class="ul-why-choose-us-list-item-title">Anúncios Verificados</h3>
                                    <p class="ul-why-choose-us-list-item-descr">Todos os anúncios são aprovados pela equipa QNB antes de ficarem visíveis, garantindo qualidade e fiabilidade.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- WHY CHOOSE US SECTION END -->


    <!-- PARTNERS SECTION START -->
    <div class="ul-inner-page-container ul-section-spacing">
        <div class="wow animate__fadeInUp">
            <div class="ul-partners-slider swiper">
                <div class="swiper-wrapper align-items-center">
                    <div class="swiper-slide"><img src="{{ asset('assets/img/logo-c.svg') }}" alt="Parter Logo"></div>
                    <div class="swiper-slide"><img src="{{ asset('assets/img/logo-c.svg') }}" alt="Parter Logo"></div>
                    <div class="swiper-slide"><img src="{{ asset('assets/img/logo-c.svg') }}" alt="Parter Logo"></div>
                    <div class="swiper-slide"><img src="{{ asset('assets/img/logo-c.svg') }}" alt="Parter Logo"></div>
                    <div class="swiper-slide"><img src="{{ asset('assets/img/logo-c.svg') }}" alt="Parter Logo"></div>
                    <div class="swiper-slide"><img src="{{ asset('assets/img/logo-c.svg') }}" alt="Parter Logo"></div>
                    <div class="swiper-slide"><img src="{{ asset('assets/img/logo-c.svg') }}" alt="Parter Logo"></div>
                    <div class="swiper-slide"><img src="{{ asset('assets/img/logo-c.svg') }}" alt="Parter Logo"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- PARTNERS SECTION END -->


    <!-- ABOUT SECTION START -->
    <section class="ul-about ul-inner-about ul-section-spacing">
        <div class="ul-inner-page-container my-0 wow animate__fadeInUp">
            <div class="row row-cols-lg-2 row-cols-1 align-items-center ul-bs-row">
                <!-- txt -->
                <div class="col">
                    <div class="ul-about-txt ul-inner-about-txt">
                        <h2 class="ul-section-title">Bem-vindo à QNB-Imobiliária</h2>
                        <div>
                            <p>A QNB-Imobiliária é a plataforma digital de referência onde empresas e imobiliárias anunciam os seus imóveis para fins comerciais, de Luanda a Cabinda. A QNB liga diretamente os anunciantes aos clientes interessados, sem intermediários escondidos.
                            </p>
                            <p>
                                Todos os anúncios são aprovados pela equipa QNB antes de serem publicados, garantindo qualidade e fiabilidade. O contacto com o responsável por cada imóvel é sempre direto e transparente.
                            </p>
                        </div>

                        <div class="ul-about-txt-bottom ul-inner-about-txt-bottom">
                            <ul class="ul-inner-about-list">
                                <li><i class="flaticon-read-more-icon"></i> Imóveis verificados em várias províncias</li>
                                <li><i class="flaticon-read-more-icon"></i> Aprovação que garante qualidade dos anúncios</li>
                                <li><i class="flaticon-read-more-icon"></i> Contacto direto com a imobiliária responsável</li>
                            </ul>

                            <div class="ul-about-stats ul-inner-about-stats">
                                <div class="ul-about-stat ul-inner-about-stat">
                                    <span class="number">{{ $estatisticas['imobiliarias'] ?? 50 }}+</span>
                                    <span class="txt">Clientes Satisfeitos</span>
                                </div>
                                <div class="ul-about-stat ul-inner-about-stat">
                                    <span class="number">{{ $estatisticas['imoveis'] ?? 100 }}+</span>
                                    <span class="txt">Imóveis Publicados</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- img -->
                <div class="col">
                    <div class="ul-about-img ul-inner-about-img"><img src="{{ asset('assets/img/about-img.jpg') }}" alt="About Image"></div>
                </div>
            </div>
        </div>
    </section>
    <!-- ABOUT SECTION END -->


    <!-- TESTIMONIAL SECTION START -->
    <section class="ul-inner-testimonial overflow-hidden ul-section-spacing">
        <div class="ul-inner-page-container wow animate__fadeInUp">
            <div class="ul-section-heading text-center justify-content-center">
                <div>
                    <span class="ul-section-sub-title">Depoimentos</span>
                    <h2 class="ul-section-title">O Que Dizem os Clientes da QNB</h2>
                </div>
            </div>

            <!-- slider -->
            <div class="ul-inner-testimonial-slider swiper">
                <div class="swiper-wrapper">
                    @if($depoimentos->count())
                    @foreach($depoimentos as $depoimento)
                    <!-- single review -->
                    <div class="swiper-slide">
                        <div class="ul-inner-testimony">
                            <div class="ul-inner-testimony-rating">
                                @for($i = 1; $i <= 5; $i++)
                                <i class="flaticon-star" {{ $i <= $depoimento->estrelas ? '' : 'style="opacity:0.25;"' }}></i>
                                @endfor
                            </div>
                            <p class="ul-inner-testimony-descr">{{ $depoimento->texto }}</p>
                            <div class="ul-inner-testimony-bottom">
                                <div class="ul-inner-testimony-reviewer">
                                    <div class="reviewer-image"><img src="{{ $depoimento->avatar ? asset('storage/' . $depoimento->avatar) : asset('assets/img/logo-w.svg') }}" alt="reviewer image"></div>
                                    <div>
                                        <h3 class="reviewer-name">{{ $depoimento->nome }}</h3>
                                        <span class="reviewer-role">{{ $depoimento->cargo }}</span>
                                    </div>
                                </div>

                                <!-- icon -->
                                <div class="ul-inner-testimony-icon"><i class="flaticon-quote"></i></div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @else
                    <!-- fallback -->
                    <div class="swiper-slide">
                        <div class="ul-inner-testimony">
                            <div class="ul-inner-testimony-rating">
                                <i class="flaticon-star"></i><i class="flaticon-star"></i><i class="flaticon-star"></i><i class="flaticon-star"></i><i class="flaticon-star"></i>
                            </div>
                            <p class="ul-inner-testimony-descr">Encontrei o apartamento ideal na QNB-Imobiliária. O processo foi simples e o contacto com a imobiliária responsável foi direto, sem complicações.</p>
                            <div class="ul-inner-testimony-bottom">
                                <div class="ul-inner-testimony-reviewer">
                                    <div class="reviewer-image"><img src="{{ asset('assets/img/logo-w.svg') }}" alt="reviewer image"></div>
                                    <div>
                                        <h3 class="reviewer-name">Joana Mendes</h3>
                                        <span class="reviewer-role">Cliente</span>
                                    </div>
                                </div>
                                <div class="ul-inner-testimony-icon"><i class="flaticon-quote"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="ul-inner-testimony">
                            <div class="ul-inner-testimony-rating">
                                <i class="flaticon-star"></i><i class="flaticon-star"></i><i class="flaticon-star"></i><i class="flaticon-star"></i><i class="flaticon-star"></i>
                            </div>
                            <p class="ul-inner-testimony-descr">Encontrei o apartamento ideal na QNB-Imobiliária. O processo foi simples e o contacto com a imobiliária responsável foi direto, sem complicações.</p>
                            <div class="ul-inner-testimony-bottom">
                                <div class="ul-inner-testimony-reviewer">
                                    <div class="reviewer-image"><img src="{{ asset('assets/img/logo-w.svg') }}" alt="reviewer image"></div>
                                    <div>
                                        <h3 class="reviewer-name">Joana Mendes</h3>
                                        <span class="reviewer-role">Cliente</span>
                                    </div>
                                </div>
                                <div class="ul-inner-testimony-icon"><i class="flaticon-quote"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="ul-inner-testimony">
                            <div class="ul-inner-testimony-rating">
                                <i class="flaticon-star"></i><i class="flaticon-star"></i><i class="flaticon-star"></i><i class="flaticon-star"></i><i class="flaticon-star"></i>
                            </div>
                            <p class="ul-inner-testimony-descr">Encontrei o apartamento ideal na QNB-Imobiliária. O processo foi simples e o contacto com a imobiliária responsável foi direto, sem complicações.</p>
                            <div class="ul-inner-testimony-bottom">
                                <div class="ul-inner-testimony-reviewer">
                                    <div class="reviewer-image"><img src="{{ asset('assets/img/logo-w.svg') }}" alt="reviewer image"></div>
                                    <div>
                                        <h3 class="reviewer-name">Joana Mendes</h3>
                                        <span class="reviewer-role">Cliente</span>
                                    </div>
                                </div>
                                <div class="ul-inner-testimony-icon"><i class="flaticon-quote"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="ul-inner-testimony">
                            <div class="ul-inner-testimony-rating">
                                <i class="flaticon-star"></i><i class="flaticon-star"></i><i class="flaticon-star"></i><i class="flaticon-star"></i><i class="flaticon-star"></i>
                            </div>
                            <p class="ul-inner-testimony-descr">Encontrei o apartamento ideal na QNB-Imobiliária. O processo foi simples e o contacto com a imobiliária responsável foi direto, sem complicações.</p>
                            <div class="ul-inner-testimony-bottom">
                                <div class="ul-inner-testimony-reviewer">
                                    <div class="reviewer-image"><img src="{{ asset('assets/img/logo-w.svg') }}" alt="reviewer image"></div>
                                    <div>
                                        <h3 class="reviewer-name">Joana Mendes</h3>
                                        <span class="reviewer-role">Cliente</span>
                                    </div>
                                </div>
                                <div class="ul-inner-testimony-icon"><i class="flaticon-quote"></i></div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- pagination -->
            <div class="ul-slider-action-wrapper ul-inner-testimonial-slider-action-wrapper">
                <button class="ul-inner-testimonial-slider-prev">Anterior</button>
                <div class="ul-slider-pagination-progress ul-inner-testimonial-slider-pagination flex-shrink-0"></div>
                <button class="ul-inner-testimonial-slider-next">Seguinte</button>
            </div>
        </div>
    </section>
    <!-- TESTIMONIAL SECTION END -->


    <!-- FEATURES SECTION START -->
    <section class="ul-features ul-section-spacing">
        <div class="ul-inner-page-container">
            <div class="ul-features-content wow animate__fadeInUp">
                <div class="row ul-bs-row">
                    <!-- section heading -->
                    <div class="col-lg-3">
                        <div class="ul-section-heading ul-features-heading">
                            <div>
                                <span class="ul-section-sub-title">Facilidades</span>
                                <h2 class="ul-section-title">Principais Características</h2>
                                <a href="{{ route('imoveis.index') }}" class="ul-features-heading-btn ul-btn">Adicionar Imóveis</a>
                            </div>

                            <!-- vector -->
                            <img src="{{ asset('assets/img/features-vector.svg') }}" alt="vector" class="vector wow animate__fadeInLeft">
                        </div>
                    </div>

                    <!-- features -->
                    <div class="col-lg-9">
                        <div class="ul-features-slider swiper">
                            <div class="swiper-wrapper">
                                <!-- single feature -->
                                <div class="swiper-slide">
                                    <div class="ul-feature">
                                        <div class="ul-feature-icon"><i class="flaticon-buildings"></i></div>
                                        <div class="ul-feature-txt">
                                            <h3 class="ul-feature-title"><a href="{{ route('imoveis.index') }}">Armazéns</a></h3>
                                            <span class="ul-feature-sub-title">4 Imóveis</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- single feature -->
                                <div class="swiper-slide">
                                    <div class="ul-feature">
                                        <div class="ul-feature-icon"><i class="flaticon-building"></i></div>
                                        <div class="ul-feature-txt">
                                            <h3 class="ul-feature-title"><a href="{{ route('imoveis.index') }}">Condomínios</a></h3>
                                            <span class="ul-feature-sub-title">5 Imóveis</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- single feature -->
                                <div class="swiper-slide">
                                    <div class="ul-feature">
                                        <div class="ul-feature-icon"><i class="flaticon-house-1"></i></div>
                                        <div class="ul-feature-txt">
                                            <h3 class="ul-feature-title"><a href="{{ route('imoveis.index') }}">Moradias</a></h3>
                                            <span class="ul-feature-sub-title">8 Imóveis</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- single feature -->
                                <div class="swiper-slide">
                                    <div class="ul-feature">
                                        <div class="ul-feature-icon"><i class="flaticon-building"></i></div>
                                        <div class="ul-feature-txt">
                                            <h3 class="ul-feature-title"><a href="{{ route('imoveis.index') }}">Armazéns</a></h3>
                                            <span class="ul-feature-sub-title">4 Imóveis</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="ul-slider-action-wrapper ul-features-slider-action-wrapper">
                            <button class="ul-features-slider-prev">Anterior</button>
                            <div class="ul-slider-pagination-progress ul-features-slider-pagination flex-shrink-0"></div>
                            <button class="ul-features-slider-next">Seguinte</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- FEATURES SECTION END -->
</div>
@endsection
