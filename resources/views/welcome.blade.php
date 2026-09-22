@extends('layouts.site')

@section('title', 'QNB-Imobiliária - Encontre o seu imóvel')
@section('pagina', 'index')

@section('content')
<!-- BANNER SECTION START -->
<section class="ul-banner">
    <!-- top -->
    <div class="top">
        <div class="ul-banner-slider swiper">
            <div class="swiper-wrapper">
                <!-- single slide -->
                <div class="swiper-slide">
                    <div class="ul-banner-slide">
                        <div class="ul-banner-container">
                            <div class="row align-items-center flex-sm-row flex-column-reverse">
                                <!-- banner text -->
                                <div class="col-md-9 col-sm-8">
                                    <span class="ul-banner-slide-shadow-title">QNB</span>
                                    <div class="ul-banner-slide-txt wow animate__fadeInUp">
                                        <span class="ul-banner-slide-sub-title">A sua residência de luxo</span>
                                        <h1 class="ul-banner-slide-title">O melhor espaço para viver</h1>
                                        <p class="ul-banner-slide-descr">Milhares de imóveis em todo o país - casas, apartamentos, terrenos e escritórios anunciados por imobiliárias e proprietários de confiança.</p>
                                        <div class="ul-banner-slide-btns">
                                            <a href="{{ route('imoveis.index') }}" class="ul-btn">Explorar Imóveis</a>
                                        </div>
                                    </div>
                                </div>

                                <!-- banner image -->
                                <div class="col-md-3 col-sm-4">
                                    <div class="ul-banner-slide-img wow animate__fadeInUp">
                                        <img src="{{ asset('assets/img/banner-img-1.png') }}" alt="Banner Image">
                                        <a href="https://youtu.be/4jnzf1yj48M?si=owDQ6MQLmVy0r56E" data-fslightbox="video" class="ul-banner-slide-video-btn"><i class="flaticon-play"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- single slide -->
                <div class="swiper-slide">
                    <div class="ul-banner-slide">
                        <div class="ul-banner-container">
                            <div class="row align-items-center flex-sm-row flex-column-reverse">
                                <!-- banner text -->
                                <div class="col-md-9 col-sm-8">
                                    <span class="ul-banner-slide-shadow-title">QNB</span>
                                    <div class="ul-banner-slide-txt wow animate__fadeInUp">
                                        <span class="ul-banner-slide-sub-title">A sua residência de luxo</span>
                                        <h1 class="ul-banner-slide-title">O melhor espaço para viver</h1>
                                        <p class="ul-banner-slide-descr">Milhares de imóveis em todo o país - casas, apartamentos, terrenos e escritórios anunciados por imobiliárias e proprietários de confiança.</p>
                                        <div class="ul-banner-slide-btns">
                                            <a href="{{ route('imoveis.index') }}" class="ul-btn">Explorar Imóveis</a>
                                        </div>
                                    </div>
                                </div>

                                <!-- banner image -->
                                <div class="col-md-3 col-sm-4">
                                    <div class="ul-banner-slide-img wow animate__fadeInUp">
                                        <img src="{{ asset('assets/img/banner-img-1.png') }}" alt="Banner Image">
                                        <a href="https://youtu.be/4jnzf1yj48M?si=owDQ6MQLmVy0r56E" data-fslightbox="video" class="ul-banner-slide-video-btn"><i class="flaticon-play"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- single slide -->
                <div class="swiper-slide">
                    <div class="ul-banner-slide">
                        <div class="ul-banner-container">
                            <div class="row align-items-center flex-sm-row flex-column-reverse">
                                <!-- banner text -->
                                <div class="col-md-9 col-sm-8">
                                    <span class="ul-banner-slide-shadow-title">QNB</span>
                                    <div class="ul-banner-slide-txt wow animate__fadeInUp">
                                        <span class="ul-banner-slide-sub-title">A sua residência de luxo</span>
                                        <h1 class="ul-banner-slide-title">O melhor espaço para viver</h1>
                                        <p class="ul-banner-slide-descr">Milhares de imóveis em todo o país - casas, apartamentos, terrenos e escritórios anunciados por imobiliárias e proprietários de confiança.</p>
                                        <div class="ul-banner-slide-btns">
                                            <a href="{{ route('imoveis.index') }}" class="ul-btn">Explorar Imóveis</a>
                                        </div>
                                    </div>
                                </div>

                                <!-- banner image -->
                                <div class="col-md-3 col-sm-4">
                                    <div class="ul-banner-slide-img wow animate__fadeInUp">
                                        <img src="{{ asset('assets/img/banner-img-1.png') }}" alt="Banner Image">
                                        <a href="https://youtu.be/4jnzf1yj48M?si=owDQ6MQLmVy0r56E" data-fslightbox="video" class="ul-banner-slide-video-btn"><i class="flaticon-play"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- bottom -->
    <div class="bottom">
        <div class="left wow animate__fadeInUp">
            <div class="ul-banner-address-slider swiper">
                <div class="swiper-wrapper">
                    <!-- single slide -->
                    <div class="swiper-slide">
                        <span class="address-1">Luanda</span>
                        <span class="address-2">Condomínio Miramar</span>
                    </div>

                    <!-- single slide -->
                    <div class="swiper-slide">
                        <span class="address-1">Luanda, Morro Bento</span>
                        <span class="address-2">Condomínio Miramar</span>
                    </div>

                    <!-- single slide -->
                    <div class="swiper-slide">
                        <span class="address-1">Benguela</span>
                        <span class="address-2">Condomínio Miramar</span>
                    </div>
                </div>

            </div>
        </div>

        <div class="right wow animate__fadeInUp">
            <div class="ul-banner-slider-pagination"></div>
            <div class="ul-banner-slider-nav ul-slider-nav">
                <button class="prev"><i class="flaticon-left"></i></button>
                <button class="next"><i class="flaticon-right"></i></button>
            </div>
        </div>
    </div>
</section>
<!-- BANNER SECTION END -->


<!-- CITIES SECTION START -->
<section class="ul-cities ul-section-spacing">
    <div class="ul-container wow animate__fadeInUp">
        <!-- section heading -->
        <div class="ul-section-heading">
            <div class="left">
                <h2 class="ul-section-title">Encontre Imóveis Nestas Localizações</h2>
                <p class="ul-section-descr">Imóveis verificados nas principais províncias</p>
            </div>
            <div class="right">
                <a href="{{ route('imoveis.index') }}" class="ul-btn">Ver Todos os Imóveis</a>
            </div>
        </div>

        <!-- cities -->
        <div class="row row-cols-xl-4 row-cols-md-3 row-cols-2 row-cols-xxs-1 g-4 mx-auto">
            @foreach($cidades as $cidade)
            <!-- single city -->
            <div class="col">
                <div class="ul-city">
                    <div class="img"><a href="{{ route('imoveis.index', ['provincia' => $cidade->provincia]) }}"><img src="{{ asset('assets/img/city-' . $loop->iteration . '.jpg') }}" alt="City Image"></a></div>
                    <div class="txt">
                        <h3 class="ul-city-title"><a href="{{ route('imoveis.index', ['provincia' => $cidade->provincia]) }}">{{ $cidade->provincia }}</a></h3>
                        <span class="ul-city-count">{{ $cidade->total }} Imóveis</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- vector -->
    <div class="ul-cities-vectors">
        <img src="{{ asset('assets/img/cities-vector-1.svg') }}" alt="vector" class="vector-1 wow animate__fadeInLeft">
        <img src="{{ asset('assets/img/cities-vector-1.svg') }}" alt="vector" class="vector-2 wow animate__fadeInUp">
    </div>
</section>
<!-- CITIES SECTION END -->


<!-- WHY CHOOSE US SECTION START -->
<section class="ul-why-choose-us ul-section-spacing wow animate__fadeInUp">
    <div class="ul-container">
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
                    <h2 class="ul-section-title">A QNB liga-o ao imóvel dos seus sonhos</h2>
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
        </div>
    </div>
</section>
<!-- WHY CHOOSE US SECTION END -->


<!-- PROPERTY FILTER SEARCH SECTION START -->
<section class="ul-property-filter-search ul-section-spacing pt-0">
    <div class="ul-property-filter-search-container">
        <h3 class="ul-property-filter-search-title text-center wow animate__fadeInUp">Pesquise o Seu Imóvel</h3>
        <form action="{{ route('imoveis.index') }}" method="GET" class="ul-property-filter-search-form wow animate__fadeInUp">
            <div class="form-group">
                <label for="filter-location">Localização</label>
                <select name="provincia" id="filter-location">
                    <option value="">Todas as províncias</option>
                    <option value="Luanda">Luanda</option>
                    <option value="Benguela">Benguela</option>
                    <option value="Huambo">Huambo</option>
                    <option value="Huíla">Huíla</option>
                    <option value="Cabinda">Cabinda</option>
                    <option value="Malanje">Malanje</option>
                    <option value="Namibe">Namibe</option>
                    <option value="Uíge">Uíge</option>
                </select>
            </div>
            <div class="form-group">
                <label for="filter-property-type">Tipo de Imóvel</label>
                <select name="tipologia" id="filter-property-type">
                    <option value="">Todos os tipos</option>
                    <option value="residencial">Residencial</option>
                    <option value="comercial">Comercial</option>
                    <option value="terreno">Terreno</option>
                </select>
            </div>
            <div class="form-group">
                <label for="filter-price">Preço</label>
                <select name="preco_max" id="filter-price">
                    <option value="">Qualquer preço</option>
                    <option value="250000">Até 250 000</option>
                    <option value="500000">Até 500 000</option>
                    <option value="1000000">Até 1 000 000</option>
                    <option value="2500000">Até 2 500 000</option>
                    <option value="5000000">Até 5 000 000</option>
                </select>
            </div>

            <button type="submit"><span class="icon"><i class="flaticon-search"></i></span> Pesquisar</button>
        </form>
    </div>
</section>
<!-- PROPERTY FILTER SEARCH SECTION END -->


<!-- FEATURED PROPERTIES SECTION START -->
<section class="ul-featured-properties ul-section-spacing">
    <!-- section title slider -->
    <div class="ul-featured-properties-title-slider splide">
        <div class="splide__track">
            <ul class="splide__list">
                <li class="splide__slide">
                    <h2 class="ul-featured-properties-title-txt"><i class="flaticon-star"></i> Imóveis em Destaque</h2>
                </li>
                <li class="splide__slide">
                    <h2 class="ul-featured-properties-title-txt"><i class="flaticon-star"></i> Imóveis em Destaque</h2>
                </li>
            </ul>
        </div>
    </div>

    <!-- properties slider -->
    <div class="ul-featured-properties-slider-wrapper wow animate__fadeInUp">
        <div class="ul-featured-properties-slider swiper">
            <div class="swiper-wrapper">
                @foreach($imoveisDestaque as $imovel)
                <!-- single property slider item -->
                <div class="swiper-slide">
                    <div class="ul-featured-property ul-project">
                        <div>
                            <div class="header">
                                <div class="left"><span class="index">{{ $loop->iteration < 10 ? '0' . $loop->iteration : $loop->iteration }}</span></div>
                                <div class="right">
                                    <button class="ul-project-add-to-favorites-btn"><i class="flaticon-heart"></i></button>
                                </div>
                            </div>
                            <a href="{{ route('imoveis.show', $imovel->referencia) }}" class="ul-project-title">{{ $imovel->titulo }}</a>
                            <p class="ul-project-location">{{ $imovel->municipio }}, {{ $imovel->provincia }}</p>
                        </div>
                        <div class="ul-project-img">
                            @if($imovel->capaFoto())
                            <img src="{{ asset('storage/' . $imovel->capaFoto()->caminho) }}" alt="{{ $imovel->titulo }}">
                            @else
                            <img src="{{ asset('assets/img/project-' . (($loop->iteration % 6) + 1) . '.jpg') }}" alt="{{ $imovel->titulo }}">
                            @endif
                            <span class="ul-project-tag">Destaque</span>
                        </div>
                        <div class="ul-project-txt">
                            <!-- price -->
                            <span class="ul-project-price"><span class="number">{{ number_format($imovel->preco, 0, ',', '.') }}</span> {{ $imovel->moeda }}</span>
                            <!-- infos -->
                            <div class="ul-project-infos ul-featured-property-infos">
                                <!-- single info -->
                                <div class="ul-project-info ul-featured-property-info">
                                    <span class="icon"><i class="flaticon-bed-color"></i></span>
                                    <span class="text">{{ $imovel->dormitorios }} Quartos</span>
                                </div>
                                <!-- single info -->
                                <div class="ul-project-info ul-featured-property-info">
                                    <span class="icon"><i class="flaticon-bath"></i></span>
                                    <span class="text">{{ $imovel->banheiros }} Casas de Banho</span>
                                </div>
                                @if($imovel->area_construida)
                                <!-- single info -->
                                <div class="ul-project-info ul-featured-property-info">
                                    <span class="icon"><i class="flaticon-scale"></i></span>
                                    <span class="text">{{ number_format($imovel->area_construida, 0) }} m²</span>
                                </div>
                                @endif
                            </div>
                            <!-- imobiliária -->
                            <div class="ul-project-agent">
                                <div class="ul-project-agent-avatar">
                                    @if($imovel->imobiliaria && $imovel->imobiliaria->foto)
                                        <img src="{{ str_starts_with($imovel->imobiliaria->foto, 'assets/') ? asset($imovel->imobiliaria->foto) : asset('storage/' . $imovel->imobiliaria->foto) }}" alt="{{ $imovel->imobiliaria->nome }}">
                                    @else
                                        <img src="{{ asset('assets/img/logo-c.svg') }}" alt="{{ $imovel->imobiliaria->nome ?? 'QNB' }}">
                                    @endif
                                </div>
                                <span class="ul-project-agent-name">{{ $imovel->imobiliaria->nome ?? 'QNB-Imobiliária' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- slider navigation -->
        <div class="ul-featured-properties-slider-nav ul-slider-nav">
            <button class="prev"><i class="flaticon-arrow"></i></button>
            <button class="next"><i class="flaticon-right-arrow"></i></button>
        </div>
    </div>
</section>
<!-- FEATURED PROPERTIES SECTION END -->


<!-- FACILITY SECTION START -->
<section class="ul-facilities ul-section-spacing">
    <div class="ul-container">
        <div class="row ul-bs-row row-cols-lg-2 row-cols-1 wow animate__fadeInUp">
            <!-- text -->
            <div class="col">
                <div class="ul-facilities-txt">
                    <h6 class="ul-section-sub-title">Vantagens da Plataforma</h6>
                    <h2 class="ul-section-title">Imóveis verificados de empresas de confiança</h2>
                    <p class="ul-facilities-descr">A QNB-Imobiliária reúne os anúncios de imobiliárias, construtoras e proprietários num só lugar, com contacto direto entre o anunciante e o cliente.</p>

                    <div class="ul-facilities-stats">
                        <!-- single stat -->
                        <div class="ul-facilities-stat">
                            <span class="number">100%</span>
                            <span class="txt">Anúncios Verificados</span>
                        </div>
                        <!-- single stat -->
                        <div class="ul-facilities-stat">
                            <span class="number">99%</span>
                            <span class="txt">Clientes Satisfeitos</span>
                        </div>
                        <!-- single stat -->
                        <div class="ul-facilities-stat">
                            <span class="number">8</span>
                            <span class="txt">Províncias Cobertas</span>
                        </div>
                    </div>

                    <div class="ul-facilities-list">
                        <ul>
                            <li>Anúncios com fotos, preço e localização detalhada</li>
                            <li>Contacto direto com a empresa anunciante</li>
                            <li>Aprovação da equipa QNB antes da publicação</li>
                            <li>Preço em Kz ou USD, à escolha do anunciante</li>
                        </ul>
                    </div>

                    <div class="ul-facilities-img-slider-wrapper">
                        <div class="ul-facilities-img-slider-nav ul-slider-nav">
                            <button class="prev"><i class="flaticon-arrow"></i></button>
                            <button class="next"><i class="flaticon-right-arrow"></i></button>
                        </div>
                        <div class="ul-facilities-img-slider swiper">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide"><img src="{{ asset('assets/img/project-1.jpg') }}" alt="Facility Image"></div>
                                <div class="swiper-slide"><img src="{{ asset('assets/img/project-2.jpg') }}" alt="Facility Image"></div>
                                <div class="swiper-slide"><img src="{{ asset('assets/img/project-3.jpg') }}" alt="Facility Image"></div>
                                <div class="swiper-slide"><img src="{{ asset('assets/img/project-4.jpg') }}" alt="Facility Image"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- img -->
            <div class="col">
                <div class="ul-facilities-img"><img src="{{ asset('assets/img/facility-img.jpg') }}" alt="Facility Image"></div>
            </div>
        </div>
    </div>
</section>
<!-- FACILITY SECTION END -->


<!-- PROPERTIES SECTION START -->
<section class="ul-properties ul-section-spacing">
    <div class="ul-container">
        <!-- section heading -->
        <div class="ul-section-heading text-center justify-content-center wow animate__fadeInUp">
            <div>
                <span class="ul-section-sub-title">Imóveis Anunciados</span>
                <h2 class="ul-section-title">Imóveis de Sonho, ao Seu Alcance</h2>
            </div>
        </div>

        <div class="ul-properties-tab-navs wow animate__fadeInUp">
             <button class="tab-nav" data-tab="tab-sell"><i class="flaticon-house-2"></i> Todos</button>
            <button class="tab-nav active" data-tab="tab-rent"><i class="flaticon-key"></i> Arrendar</button>
            <button class="tab-nav" data-tab="tab-buy"><i class="flaticon-buy"></i> Comprar</button>
        </div>

        <div class="tabs-wrapper wow animate__fadeInUp">
            <!-- 1st tab / rent -->
            <div class="ul-tab active" id="tab-rent">
                <div class="row row-cols-md-3 row-cols-2 row-cols-xxs-1 ul-bs-row">
                    @foreach($imoveisDestaque as $imovel)
                    <!-- single project -->
                    <div class="col">
                        <div class="ul-project">
                            <div class="ul-project-img">
                                @if($imovel->capaFoto())
                                <img src="{{ asset('storage/' . $imovel->capaFoto()->caminho) }}" alt="{{ $imovel->titulo }}">
                                @else
                                <img src="{{ asset('assets/img/project-' . (($loop->iteration % 6) + 1) . '.jpg') }}" alt="{{ $imovel->titulo }}">
                                @endif
                            </div>
                            <div class="ul-project-txt">
                                <span class="ul-project-tag">Popular</span>
                                <div class="top">
                                    <div class="left">
                                        <span class="ul-project-price"><span class="number">{{ number_format($imovel->preco, 0, ',', '.') }}</span> {{ $imovel->moeda }}</span>
                                        <a href="{{ route('imoveis.show', $imovel->referencia) }}" class="ul-project-title">{{ $imovel->titulo }}</a>
                                        <p class="ul-project-location">{{ $imovel->municipio }}, {{ $imovel->provincia }}</p>
                                    </div>
                                    <div class="right">
                                        <button class="ul-project-add-to-favorites-btn"><i class="flaticon-heart"></i></button>
                                    </div>
                                </div>

                                <!-- bottom -->
                                <div class="ul-project-infos ul-featured-property-infos">
                                    <!-- single info -->
                                    <div class="ul-project-info ul-featured-property-info">
                                        <span class="icon"><i class="flaticon-bed-color"></i></span>
                                        <span class="text">{{ $imovel->dormitorios }} Quartos</span>
                                    </div>
                                    <!-- single info -->
                                    <div class="ul-project-info ul-featured-property-info">
                                        <span class="icon"><i class="flaticon-bath"></i></span>
                                        <span class="text">{{ $imovel->banheiros }} Casas de Banho</span>
                                    </div>
                                    @if($imovel->area_construida)
                                    <!-- single info -->
                                    <div class="ul-project-info ul-featured-property-info">
                                        <span class="icon"><i class="flaticon-scale"></i></span>
                                        <span class="text">{{ number_format($imovel->area_construida, 0) }} m²</span>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- 2nd tab / buy -->
            <div class="ul-tab" id="tab-buy">
                <div class="row row-cols-md-3 row-cols-2 row-cols-xxs-1 ul-bs-row">
                    @foreach($imoveisDestaque->reverse() as $imovel)
                    <div class="col">
                        <div class="ul-project">
                            <div class="ul-project-img">
                                @if($imovel->capaFoto())
                                <img src="{{ asset('storage/' . $imovel->capaFoto()->caminho) }}" alt="{{ $imovel->titulo }}">
                                @else
                                <img src="{{ asset('assets/img/project-' . (($loop->iteration % 6) + 1) . '.jpg') }}" alt="{{ $imovel->titulo }}">
                                @endif
                            </div>
                            <div class="ul-project-txt">
                                <span class="ul-project-tag">Popular</span>
                                <div class="top">
                                    <div class="left">
                                        <span class="ul-project-price"><span class="number">{{ number_format($imovel->preco, 0, ',', '.') }}</span> {{ $imovel->moeda }}</span>
                                        <a href="{{ route('imoveis.show', $imovel->referencia) }}" class="ul-project-title">{{ $imovel->titulo }}</a>
                                        <p class="ul-project-location">{{ $imovel->municipio }}, {{ $imovel->provincia }}</p>
                                    </div>
                                    <div class="right">
                                        <button class="ul-project-add-to-favorites-btn"><i class="flaticon-heart"></i></button>
                                    </div>
                                </div>
                                <div class="ul-project-infos ul-featured-property-infos">
                                    <div class="ul-project-info ul-featured-property-info">
                                        <span class="icon"><i class="flaticon-bed-color"></i></span>
                                        <span class="text">{{ $imovel->dormitorios }} Quartos</span>
                                    </div>
                                    <div class="ul-project-info ul-featured-property-info">
                                        <span class="icon"><i class="flaticon-bath"></i></span>
                                        <span class="text">{{ $imovel->banheiros }} Casas de Banho</span>
                                    </div>
                                    @if($imovel->area_construida)
                                    <div class="ul-project-info ul-featured-property-info">
                                        <span class="icon"><i class="flaticon-scale"></i></span>
                                        <span class="text">{{ number_format($imovel->area_construida, 0) }} m²</span>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- 3rd tab / sell -->
            <div class="ul-tab" id="tab-sell">
                <div class="row row-cols-md-3 row-cols-2 row-cols-xxs-1 ul-bs-row">
                    @foreach($imoveisDestaque as $imovel)
                    <div class="col">
                        <div class="ul-project">
                            <div class="ul-project-img">
                                @if($imovel->capaFoto())
                                <img src="{{ asset('storage/' . $imovel->capaFoto()->caminho) }}" alt="{{ $imovel->titulo }}">
                                @else
                                <img src="{{ asset('assets/img/project-' . (($loop->iteration % 6) + 1) . '.jpg') }}" alt="{{ $imovel->titulo }}">
                                @endif
                            </div>
                            <div class="ul-project-txt">
                                <span class="ul-project-tag">Popular</span>
                                <div class="top">
                                    <div class="left">
                                        <span class="ul-project-price"><span class="number">{{ number_format($imovel->preco, 0, ',', '.') }}</span> {{ $imovel->moeda }}</span>
                                        <a href="{{ route('imoveis.show', $imovel->referencia) }}" class="ul-project-title">{{ $imovel->titulo }}</a>
                                        <p class="ul-project-location">{{ $imovel->municipio }}, {{ $imovel->provincia }}</p>
                                    </div>
                                    <div class="right">
                                        <button class="ul-project-add-to-favorites-btn"><i class="flaticon-heart"></i></button>
                                    </div>
                                </div>
                                <div class="ul-project-infos ul-featured-property-infos">
                                    <div class="ul-project-info ul-featured-property-info">
                                        <span class="icon"><i class="flaticon-bed-color"></i></span>
                                        <span class="text">{{ $imovel->dormitorios }} Quartos</span>
                                    </div>
                                    <div class="ul-project-info ul-featured-property-info">
                                        <span class="icon"><i class="flaticon-bath"></i></span>
                                        <span class="text">{{ $imovel->banheiros }} Casas de Banho</span>
                                    </div>
                                    @if($imovel->area_construida)
                                    <div class="ul-project-info ul-featured-property-info">
                                        <span class="icon"><i class="flaticon-scale"></i></span>
                                        <span class="text">{{ number_format($imovel->area_construida, 0) }} m²</span>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="text-center wow animate__fadeInUp">
            <a href="{{ route('imoveis.index') }}" class="ul-btn ul-properties-btn">Ver Mais Imóveis</a>
        </div>
    </div>
</section>
<!-- PROPERTIES SECTION END -->


<!-- STATS SECTION START -->
<div class="ul-stats ul-section-spacing">
    <div class="ul-stats-wrapper wow animate__fadeInUp">
        <div class="ul-stats-item">
            <i class="flaticon-home-tik-mark"></i>
            <span class="number">{{ $estatisticas['imoveis'] ?? 0 }}+</span>
            <span class="txt">Imóveis Anunciados</span>
        </div>
        <div class="ul-stats-item">
            <i class="flaticon-buildings"></i>
            <span class="number">{{ $estatisticas['imobiliarias'] ?? 0 }}+</span>
            <span class="txt">Empresas Anunciantes</span>
        </div>
        <div class="ul-stats-item">
            <i class="flaticon-home-tik-mark"></i>
            <span class="number">{{ $estatisticas['interacoes'] ?? 0 }}+</span>
            <span class="txt">Anúncios Verificados</span>
        </div>
        <div class="ul-stats-item">
            <i class="flaticon-map"></i>
            <span class="number">{{ $estatisticas['provincias'] ?? 8 }}+</span>
            <span class="txt">Províncias Cobertas</span>
        </div>
    </div>
</div>
<!-- STATS SECTION END -->


<!-- TESTIMONIAL SECTION START -->
<section class="ul-testimonial ul-section-spacing">
    <div class="ul-testimonial-container">
        <div class="row row-cols-lg-2 row-cols-1 gx-0 align-items-center flex-lg-row flex-column-reverse gy-5">
            <!-- img -->
            <div class="col">
                <div class="ul-testimonial-img wow animate__fadeInUp">
                    <img src="{{ asset('assets/img/testimonial-img.jpg') }}" alt="Testimonial Image">
                </div>
            </div>

            <!-- testimonial slider -->
            <div class="col">
                <div class="ul-testimonial-txt wow animate__fadeInUp">
                    <div class="ul-section-heading">
                        <div>
                            <span class="ul-section-sub-title">Depoimentos</span>
                            <h2 class="ul-section-title">O Que Dizem os Clientes da QNB</h2>
                        </div>
                    </div>
                    <div class="ul-testimonial-slider swiper">
                        <div class="swiper-wrapper">
                            @if($depoimentos->count())
                            @foreach($depoimentos as $depoimento)
                            <!-- single slide -->
                            <div class="swiper-slide">
                                <div class="ul-testimony">
                                    <div class="top">
                                        <div class="ul-testimony-reviewer-img">
                                            <img src="{{ $depoimento->avatar ? asset('storage/' . $depoimento->avatar) : asset('assets/img/partner-1.png') }}" alt="Reviewer Image">
                                        </div>

                                        <div class="ul-testimony-reviewer-info">
                                            <h3 class="ul-testimony-reviewer-name">{{ $depoimento->nome }}</h3>
                                            <h4 class="ul-testimony-reviewer-role">{{ $depoimento->cargo }}</h4>
                                            <div class="ul-testimony-rating">
                                                @for($i = 1; $i <= 5; $i++)
                                                <i class="flaticon-star" {{ $i <= $depoimento->estrelas ? '' : 'style="opacity:0.25;"' }}></i>
                                                @endfor
                                            </div>
                                        </div>
                                    </div>
                                    <p class="ul-testimony-txt">{{ $depoimento->texto }}</p>
                                </div>
                            </div>
                            @endforeach
                            @else
                            <!-- fallback static slides -->
                            <div class="swiper-slide">
                                <div class="ul-testimony">
                                    <div class="top">
                                        <div class="ul-testimony-reviewer-img">
                                            <img src="{{ asset('assets/img/partner-1.png') }}" alt="Reviewer Image">
                                        </div>
                                        <div class="ul-testimony-reviewer-info">
                                            <h3 class="ul-testimony-reviewer-name">Ana Domingos</h3>
                                            <h4 class="ul-testimony-reviewer-role">Proprietária</h4>
                                            <div class="ul-testimony-rating">
                                                <i class="flaticon-star"></i><i class="flaticon-star"></i><i class="flaticon-star"></i><i class="flaticon-star"></i><i class="flaticon-star"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="ul-testimony-txt">Encontrei rapidamente um comprador para o meu terreno através da QNB-Imobiliária. O processo de anúncio foi simples e o contacto com os interessados direto.</p>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="ul-testimony">
                                    <div class="top">
                                        <div class="ul-testimony-reviewer-img">
                                            <img src="{{ asset('assets/img/partner-1.png') }}" alt="Reviewer Image">
                                        </div>
                                        <div class="ul-testimony-reviewer-info">
                                            <h3 class="ul-testimony-reviewer-name">Ana Domingos</h3>
                                            <h4 class="ul-testimony-reviewer-role">Proprietária</h4>
                                            <div class="ul-testimony-rating">
                                                <i class="flaticon-star"></i><i class="flaticon-star"></i><i class="flaticon-star"></i><i class="flaticon-star"></i><i class="flaticon-star"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="ul-testimony-txt">Encontrei rapidamente um comprador para o meu terreno através da QNB-Imobiliária. O processo de anúncio foi simples e o contacto com os interessados direto.</p>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="ul-testimony">
                                    <div class="top">
                                        <div class="ul-testimony-reviewer-img">
                                            <img src="{{ asset('assets/img/partner-1.png') }}" alt="Reviewer Image">
                                        </div>
                                        <div class="ul-testimony-reviewer-info">
                                            <h3 class="ul-testimony-reviewer-name">Ana Domingos</h3>
                                            <h4 class="ul-testimony-reviewer-role">Proprietária</h4>
                                            <div class="ul-testimony-rating">
                                                <i class="flaticon-star"></i><i class="flaticon-star"></i><i class="flaticon-star"></i><i class="flaticon-star"></i><i class="flaticon-star"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="ul-testimony-txt">Encontrei rapidamente um comprador para o meu terreno através da QNB-Imobiliária. O processo de anúncio foi simples e o contacto com os interessados direto.</p>
                                </div>
                            </div>
                            @endif
                        </div>

                        <!-- slider pagination -->
                        <div class="ul-testimonial-slider-pagination"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- TESTIMONIAL SECTION END -->


<!-- PARTNERS AREA START -->
<div class="ul-partners-area">
    <div class="ul-container wow animate__fadeInUp">
        <span class="ul-partners-area-title">Parceiros da QNB</span>

        <div class="ul-partners-slider swiper">
            <div class="swiper-wrapper align-items-center">
                @if($parceiros->count())
                @foreach($parceiros as $parceiro)
                <!-- single slide -->
                <div class="swiper-slide">
                    <img src="{{ asset('storage/' . $parceiro->logo) }}" alt="{{ $parceiro->nome }}">
                </div>
                @endforeach
                @else
                <!-- fallback -->
                <div class="swiper-slide"><img src="{{ asset('assets/img/logo-c.svg') }}" alt="Parter Logo"></div>
                <div class="swiper-slide"><img src="{{ asset('assets/img/logo-c.svg') }}" alt="Parter Logo"></div>
                <div class="swiper-slide"><img src="{{ asset('assets/img/logo-c.svg') }}" alt="Parter Logo"></div>
                <div class="swiper-slide"><img src="{{ asset('assets/img/logo-c.svg') }}" alt="Parter Logo"></div>
                <div class="swiper-slide"><img src="{{ asset('assets/img/logo-c.svg') }}" alt="Parter Logo"></div>
                <div class="swiper-slide"><img src="{{ asset('assets/img/logo-c.svg') }}" alt="Parter Logo"></div>
                <div class="swiper-slide"><img src="{{ asset('assets/img/logo-c.svg') }}" alt="Parter Logo"></div>
                <div class="swiper-slide"><img src="{{ asset('assets/img/logo-c.svg') }}" alt="Parter Logo"></div>
                @endif
            </div>
        </div>
    </div>
</div>
<!-- PARTNERS AREA END -->
@endsection
