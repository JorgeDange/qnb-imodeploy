<?php $__env->startSection('title', 'QNB-Imobiliária - Imóveis'); ?>
<?php $__env->startSection('pagina', 'projects'); ?>
<?php $__env->startSection('header-class', 'ul-header'); ?>

<?php $__env->startSection('content'); ?>
<!-- BREADCRUMB SECTION START -->
<div class="ul-breadcrumb">
    <div class="wow animate__fadeInUp">
        <h2 class="ul-breadcrumb-title">Imóveis</h2>
        <div class="ul-breadcrumb-nav">
            <a href="<?php echo e(route('home')); ?>">Início</a>
            <span class="separator"><i class="flaticon-aro-left"></i></span>
            <span class="current-page">Imóveis</span>
        </div>
    </div>
</div>
<!-- BREADCRUMB SECTION END -->

<div class="ul-inner-page-content-wrapper ul-projects-page-content-wrapper">
    <div class="ul-inner-page-container">
        <!-- search filters -->
        <form action="<?php echo e(route('imoveis.index')); ?>" method="GET" class="ul-projects-search-filters">
            <div class="row row-cols-lg-4 row-cols-sm-3 row-cols-2 row-cols-xxs-1 justify-content-center wow animate__fadeInUp">
                <div class="col">
                    <input type="text" name="keyword" value="<?php echo e(request('keyword')); ?>" placeholder="Digite uma palavra-chave">
                </div>
                <div class="col">
                    <select name="tipologia" id="property-type">
                        <option data-placeholder="true" <?php echo e(!request('tipologia') ? 'selected' : ''); ?>>Tipo de Imóvel</option>
                        <option value="apartamento" <?php echo e(request('tipologia') == 'apartamento' ? 'selected' : ''); ?>>Apartamento</option>
                        <option value="vivenda" <?php echo e(request('tipologia') == 'vivenda' ? 'selected' : ''); ?>>Moradia</option>
                        <option value="terreno" <?php echo e(request('tipologia') == 'terreno' ? 'selected' : ''); ?>>Terreno</option>
                        <option value="loja" <?php echo e(request('tipologia') == 'loja' ? 'selected' : ''); ?>>Loja</option>
                        <option value="escritorio" <?php echo e(request('tipologia') == 'escritorio' ? 'selected' : ''); ?>>Escritório</option>
                        <option value="armazem" <?php echo e(request('tipologia') == 'armazem' ? 'selected' : ''); ?>>Armazém</option>
                        <option value="quintal" <?php echo e(request('tipologia') == 'quintal' ? 'selected' : ''); ?>>Quintal</option>
                    </select>
                </div>
                <div class="col">
                    <select name="provincia" id="location">
                        <option data-placeholder="true" <?php echo e(!request('provincia') ? 'selected' : ''); ?>>Selecione a Localização</option>
                        <option value="Luanda" <?php echo e(request('provincia') == 'Luanda' ? 'selected' : ''); ?>>Luanda</option>
                        <option value="Benguela" <?php echo e(request('provincia') == 'Benguela' ? 'selected' : ''); ?>>Benguela</option>
                        <option value="Huambo" <?php echo e(request('provincia') == 'Huambo' ? 'selected' : ''); ?>>Huambo</option>
                        <option value="Huíla" <?php echo e(request('provincia') == 'Huíla' ? 'selected' : ''); ?>>Huíla</option>
                        <option value="Cabinda" <?php echo e(request('provincia') == 'Cabinda' ? 'selected' : ''); ?>>Cabinda</option>
                        <option value="Malanje" <?php echo e(request('provincia') == 'Malanje' ? 'selected' : ''); ?>>Malanje</option>
                        <option value="Namibe" <?php echo e(request('provincia') == 'Namibe' ? 'selected' : ''); ?>>Namibe</option>
                        <option value="Uíge" <?php echo e(request('provincia') == 'Uíge' ? 'selected' : ''); ?>>Uíge</option>
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
                        <option data-placeholder="true" <?php echo e(!request('preco_max') ? 'selected' : ''); ?>>Preço Máximo</option>
                        <option value="250000" <?php echo e(request('preco_max') == '250000' ? 'selected' : ''); ?>>Até 250 000</option>
                        <option value="500000" <?php echo e(request('preco_max') == '500000' ? 'selected' : ''); ?>>Até 500 000</option>
                        <option value="1000000" <?php echo e(request('preco_max') == '1000000' ? 'selected' : ''); ?>>Até 1 000 000</option>
                        <option value="2500000" <?php echo e(request('preco_max') == '2500000' ? 'selected' : ''); ?>>Até 2 500 000</option>
                        <option value="5000000" <?php echo e(request('preco_max') == '5000000' ? 'selected' : ''); ?>>Até 5 000 000</option>
                    </select>
                </div>
                <div class="col">
                    <select name="dormitorios" id="beds">
                        <option data-placeholder="true" <?php echo e(!request('dormitorios') ? 'selected' : ''); ?>>Quartos</option>
                        <option value="1" <?php echo e(request('dormitorios') == '1' ? 'selected' : ''); ?>>1</option>
                        <option value="2" <?php echo e(request('dormitorios') == '2' ? 'selected' : ''); ?>>2</option>
                        <option value="3" <?php echo e(request('dormitorios') == '3' ? 'selected' : ''); ?>>3</option>
                        <option value="4" <?php echo e(request('dormitorios') == '4' ? 'selected' : ''); ?>>4</option>
                        <option value="5" <?php echo e(request('dormitorios') == '5' ? 'selected' : ''); ?>>5</option>
                        <option value="6" <?php echo e(request('dormitorios') == '6' ? 'selected' : ''); ?>>6</option>
                    </select>
                </div>
                <div class="col">
                    <select name="andares" id="floors">
                        <option data-placeholder="true" <?php echo e(!request('andares') ? 'selected' : ''); ?>>Andares</option>
                        <option value="1" <?php echo e(request('andares') == '1' ? 'selected' : ''); ?>>1</option>
                        <option value="2" <?php echo e(request('andares') == '2' ? 'selected' : ''); ?>>2</option>
                        <option value="3" <?php echo e(request('andares') == '3' ? 'selected' : ''); ?>>3</option>
                        <option value="4" <?php echo e(request('andares') == '4' ? 'selected' : ''); ?>>4+</option>
                    </select>
                </div>
                <div class="col">
                    <select name="garagem" id="garages">
                        <option data-placeholder="true" <?php echo e(!request('garagem') ? 'selected' : ''); ?>>Garagens</option>
                        <option value="0" <?php echo e(request('garagem') == '0' ? 'selected' : ''); ?>>0</option>
                        <option value="1" <?php echo e(request('garagem') == '1' ? 'selected' : ''); ?>>1</option>
                        <option value="2" <?php echo e(request('garagem') == '2' ? 'selected' : ''); ?>>2</option>
                    </select>
                </div>
            </div>
        </form>

        <!-- project cards grid -->
        <div class="row row-cols-md-3 row-cols-2 row-cols-xxs-1 ul-bs-row">
            <?php $__empty_1 = true; $__currentLoopData = $imoveis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $imovel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <!-- single project -->
            <div class="col wow animate__fadeInUp">
                <div class="ul-project">
                    <div class="ul-project-img">
                        <?php if($imovel->capaFoto()): ?>
                        <img src="<?php echo e(asset('storage/' . $imovel->capaFoto()->caminho)); ?>" alt="<?php echo e($imovel->titulo); ?>">
                        <?php else: ?>
                        <img src="<?php echo e(asset('assets/img/project-' . (($loop->iteration % 6) + 1) . '.jpg')); ?>" alt="<?php echo e($imovel->titulo); ?>">
                        <?php endif; ?>
                    </div>
                    <div class="ul-project-txt">
                        <span class="ul-project-tag">Destaque</span>
                        <div class="top">
                            <div class="left">
                                <span class="ul-project-price"><span class="number"><?php echo e(number_format($imovel->preco, 0, ',', '.')); ?></span> <?php echo e($imovel->moeda); ?></span>
                                <a href="<?php echo e(route('imoveis.show', $imovel->referencia)); ?>" class="ul-project-title"><?php echo e($imovel->titulo); ?></a>
                                <p class="ul-project-location"><?php echo e($imovel->municipio); ?>, <?php echo e($imovel->provincia); ?></p>
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
                                <span class="text"><?php echo e($imovel->dormitorios); ?> Quartos</span>
                            </div>
                            <!-- single info -->
                            <div class="ul-project-info">
                                <span class="icon"><i class="flaticon-bath"></i></span>
                                <span class="text"><?php echo e($imovel->banheiros); ?> Casas de Banho</span>
                            </div>
                            <?php if($imovel->area_construida): ?>
                            <!-- single info -->
                            <div class="ul-project-info">
                                <span class="icon"><i class="flaticon-scale"></i></span>
                                <span class="text"><?php echo e(number_format($imovel->area_construida, 0)); ?> m²</span>
                            </div>
                            <?php endif; ?>
                        </div>

                        <!-- imobiliária -->
                        <div class="ul-project-agent">
                            <div class="ul-project-agent-avatar">
                                <?php if($imovel->imobiliaria && $imovel->imobiliaria->foto): ?>
                                    <img src="<?php echo e(str_starts_with($imovel->imobiliaria->foto, 'assets/') ? asset($imovel->imobiliaria->foto) : asset('storage/' . $imovel->imobiliaria->foto)); ?>" alt="<?php echo e($imovel->imobiliaria->nome); ?>">
                                <?php else: ?>
                                    <img src="<?php echo e(asset('assets/img/logo-c.svg')); ?>" alt="<?php echo e($imovel->imobiliaria->nome ?? 'QNB'); ?>">
                                <?php endif; ?>
                            </div>
                            <span class="ul-project-agent-name"><?php echo e($imovel->imobiliaria->nome ?? 'QNB-Imobiliária'); ?></span>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-12 text-center py-5">
                <h4>Nenhum imóvel encontrado</h4>
                <p>Tente alterar os filtros de pesquisa.</p>
            </div>
            <?php endif; ?>
        </div>

        <!-- pagination -->
        <?php if($imoveis->hasPages()): ?>
        <div class="ul-pagination">
            <?php echo e($imoveis->withQueryString()->links()); ?>

        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.site', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\JORGE DANGE\Documents\PROGRAMACAO\WEB\QND\PageWeb\imobiliaria\qnb-imobiliaria\resources\views\imoveis\index.blade.php ENDPATH**/ ?>