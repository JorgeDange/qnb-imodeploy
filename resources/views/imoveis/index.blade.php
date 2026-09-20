@extends('layouts.site')

@section('title', 'QNB-Imobiliária - Imóveis')
@section('pagina', 'projects')
@section('header-class', 'ul-header')

@section('content')
<!-- BREADCRUMB SECTION START -->
<div class="ul-breadcrumb">
    <div class="wow animate__fadeInUp">
        <h2 class="ul-breadcrumb-title">Imóveis</h2>
        <div class="ul-breadcrumb-nav">
            <a href="{{ route('home') }}">Início</a>
            <span class="separator"><i class="flaticon-aro-left"></i></span>
            <span class="current-page">Imóveis</span>
        </div>
    </div>
</div>
<!-- BREADCRUMB SECTION END -->

<div class="ul-inner-page-content-wrapper ul-projects-page-content-wrapper">
    <div class="ul-inner-page-container">
        <!-- search filters -->
        <form action="{{ route('imoveis.index') }}" method="GET" class="ul-projects-search-filters">
            <div class="row row-cols-lg-4 row-cols-sm-3 row-cols-2 row-cols-xxs-1 justify-content-center wow animate__fadeInUp">
                <div class="col">
                    <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="Digite uma palavra-chave">
                </div>
                <div class="col">
                    <select name="tipologia" id="property-type">
                        <option data-placeholder="true" {{ !request('tipologia') ? 'selected' : '' }}>Tipo de Imóvel</option>
                        <option value="apartamento" {{ request('tipologia') == 'apartamento' ? 'selected' : '' }}>Apartamento</option>
                        <option value="vivenda" {{ request('tipologia') == 'vivenda' ? 'selected' : '' }}>Moradia</option>
                        <option value="terreno" {{ request('tipologia') == 'terreno' ? 'selected' : '' }}>Terreno</option>
                        <option value="loja" {{ request('tipologia') == 'loja' ? 'selected' : '' }}>Loja</option>
                        <option value="escritorio" {{ request('tipologia') == 'escritorio' ? 'selected' : '' }}>Escritório</option>
                        <option value="armazem" {{ request('tipologia') == 'armazem' ? 'selected' : '' }}>Armazém</option>
                        <option value="quintal" {{ request('tipologia') == 'quintal' ? 'selected' : '' }}>Quintal</option>
                    </select>
                </div>
                <div class="col">
                    <select name="provincia" id="location">
                        <option data-placeholder="true" {{ !request('provincia') ? 'selected' : '' }}>Selecione a Localização</option>
                        <option value="Luanda" {{ request('provincia') == 'Luanda' ? 'selected' : '' }}>Luanda</option>
                        <option value="Benguela" {{ request('provincia') == 'Benguela' ? 'selected' : '' }}>Benguela</option>
                        <option value="Huambo" {{ request('provincia') == 'Huambo' ? 'selected' : '' }}>Huambo</option>
                        <option value="Huíla" {{ request('provincia') == 'Huíla' ? 'selected' : '' }}>Huíla</option>
                        <option value="Cabinda" {{ request('provincia') == 'Cabinda' ? 'selected' : '' }}>Cabinda</option>
                        <option value="Malanje" {{ request('provincia') == 'Malanje' ? 'selected' : '' }}>Malanje</option>
                        <option value="Namibe" {{ request('provincia') == 'Namibe' ? 'selected' : '' }}>Namibe</option>
                        <option value="Uíge" {{ request('provincia') == 'Uíge' ? 'selected' : '' }}>Uíge</option>
                    </select>
                </div>
                <div class="col">
                    <div class="ul-projects-search-filters-btns">
                        <button type="button" class="ul-projects-search-filters-expand-btn"><i class="flaticon-filter"></i></button>
                        <button type="submit" class="ul-projects-search-filters-btn ul-btn">Pesquisar Imóveis</button>
                    </div>
                </div>
            </div>

            <div class="ul-projects-search-filters-row-2 row row-cols-lg-4 row-cols-sm-3 row-cols-2 row-cols-xxs-1 justify-content-center wow animate__fadeInUp">
                <div class="col">
                    <select name="preco_max" id="max-price">
                        <option data-placeholder="true" {{ !request('preco_max') ? 'selected' : '' }}>Preço Máximo</option>
                        <option value="250000" {{ request('preco_max') == '250000' ? 'selected' : '' }}>Até 250 000</option>
                        <option value="500000" {{ request('preco_max') == '500000' ? 'selected' : '' }}>Até 500 000</option>
                        <option value="1000000" {{ request('preco_max') == '1000000' ? 'selected' : '' }}>Até 1 000 000</option>
                        <option value="2500000" {{ request('preco_max') == '2500000' ? 'selected' : '' }}>Até 2 500 000</option>
                        <option value="5000000" {{ request('preco_max') == '5000000' ? 'selected' : '' }}>Até 5 000 000</option>
                    </select>
                </div>
                <div class="col">
                    <select name="dormitorios" id="beds">
                        <option data-placeholder="true" {{ !request('dormitorios') ? 'selected' : '' }}>Quartos</option>
                        <option value="1" {{ request('dormitorios') == '1' ? 'selected' : '' }}>1</option>
                        <option value="2" {{ request('dormitorios') == '2' ? 'selected' : '' }}>2</option>
                        <option value="3" {{ request('dormitorios') == '3' ? 'selected' : '' }}>3</option>
                        <option value="4" {{ request('dormitorios') == '4' ? 'selected' : '' }}>4</option>
                        <option value="5" {{ request('dormitorios') == '5' ? 'selected' : '' }}>5</option>
                        <option value="6" {{ request('dormitorios') == '6' ? 'selected' : '' }}>6</option>
                    </select>
                </div>
                <div class="col">
                    <select name="andares" id="floors">
                        <option data-placeholder="true" {{ !request('andares') ? 'selected' : '' }}>Andares</option>
                        <option value="1" {{ request('andares') == '1' ? 'selected' : '' }}>1</option>
                        <option value="2" {{ request('andares') == '2' ? 'selected' : '' }}>2</option>
                        <option value="3" {{ request('andares') == '3' ? 'selected' : '' }}>3</option>
                        <option value="4" {{ request('andares') == '4' ? 'selected' : '' }}>4+</option>
                    </select>
                </div>
                <div class="col">
                    <select name="garagem" id="garages">
                        <option data-placeholder="true" {{ !request('garagem') ? 'selected' : '' }}>Garagens</option>
                        <option value="0" {{ request('garagem') == '0' ? 'selected' : '' }}>0</option>
                        <option value="1" {{ request('garagem') == '1' ? 'selected' : '' }}>1</option>
                        <option value="2" {{ request('garagem') == '2' ? 'selected' : '' }}>2</option>
                    </select>
                </div>
            </div>
        </form>

        <!-- project cards grid -->
        <div class="row row-cols-md-3 row-cols-2 row-cols-xxs-1 ul-bs-row">
            @forelse($imoveis as $imovel)
            <!-- single project -->
            <div class="col wow animate__fadeInUp">
                <div class="ul-project">
                    <div class="ul-project-img">
                        @if($imovel->capaFoto())
                        <img src="{{ asset('storage/' . $imovel->capaFoto()->caminho) }}" alt="{{ $imovel->titulo }}">
                        @else
                        <img src="{{ asset('assets/img/project-' . (($loop->iteration % 6) + 1) . '.jpg') }}" alt="{{ $imovel->titulo }}">
                        @endif
                    </div>
                    <div class="ul-project-txt">
                        <span class="ul-project-tag">Destaque</span>
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
                        <div class="ul-project-infos">
                            <!-- single info -->
                            <div class="ul-project-info">
                                <span class="icon"><i class="flaticon-bed-color"></i></span>
                                <span class="text">{{ $imovel->dormitorios }} Quartos</span>
                            </div>
                            <!-- single info -->
                            <div class="ul-project-info">
                                <span class="icon"><i class="flaticon-bath"></i></span>
                                <span class="text">{{ $imovel->banheiros }} Casas de Banho</span>
                            </div>
                            @if($imovel->area_construida)
                            <!-- single info -->
                            <div class="ul-project-info">
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
            @empty
            <div class="col-12 text-center py-5">
                <h4>Nenhum imóvel encontrado</h4>
                <p>Tente alterar os filtros de pesquisa.</p>
            </div>
            @endforelse
        </div>

        <!-- pagination -->
        @if($imoveis->hasPages())
        <div class="ul-pagination">
            {{ $imoveis->withQueryString()->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
