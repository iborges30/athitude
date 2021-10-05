<?php $v->layout("_theme"); ?>
<div class="dialog all">
    <div class="container">
        <div class="modal">
            <div class="page-item">
                <div class="go-back">
                    <a href="#" class="jsc-back poppins" data-product-id="161">
                       X
                    </a>
                </div>

                <div class="page-item-title">
                    <h1 class="poppins text-dark">Coleção blusas de algodão</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-1">
                    <div class="page-item-image">
                        <img name="Blusa de malha" alt="Blusa de malha"
                             src="<?= theme("/assets/images/produto.jpg", CONF_VIEW_THEME);?>">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-70">
                    <div class="product-descripition-items">
                        <p class="roboto text-dark">Código: #RF456 </p>
                    </div>
                    <div class="product-descripition-items">
                        <p class="roboto text-dark">Categoria: Blusas </p>
                    </div>

                    <div class="product-descripition-items">
                        <p class="roboto text-dark">Fabricante: Atitude Fitness</p>
                    </div>
                </div>

                <div class="col-30">
                    <div class="product-price">

                        <p class="poppins text-dark">
                            R$ 49,90
                        </p>

                        <small class="text-default poppins">
                            ou em 3x de 20,00
                        </small>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="descritpion-product roboto text-dark">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam rutrum odio id eros congue
                    vulputate. Proin sem ligula, commodo eu malesuada eu, porttitor in nulla. Quisque accumsan imperdiet
                    felis, vel venenatis erat laoreet porta. Class aptent taciti sociosqu ad litora
                </div>
            </div>
            <div class="row">
                <div class="col-60">
                    <div class="product-size product-details">
                        <h2 class="poppins text-dark">
                            Tamanho
                        </h2>
                        <ul class="ds-flex roboto">
                            <li>G</li>
                            <li>P</li>
                            <li>GG</li>
                        </ul>
                    </div>
                </div>
                <div class="col-40">
                    <div class="product-color product-details">
                        <h2 class="poppins text-dark">
                            Cores
                        </h2>

                        <ul class="ds-flex details-colors">
                            <?php
                            for($i = 0; $i < 2; $i++):
                            ?>
                            <li style="background: #FE6E53"></li>
                            <li style="background: #0c0c0c"></li>
                            <li style="background: #02C588"></li>
                            <?php
                            endfor;
                            ?>
                        </ul>

                    </div>
                </div>
            </div>

            <div class="page-item-buy">
                <div class="row">
                    <div class="col-2">
                        <form action="">
                            <span class="item-buy-plus">+</span>
                            <input type="tel" name="amount" value="1" readonly="">
                            <span class="item-buy-minus">-</span>
                        </form>
                    </div>

                    <div class="col-2">
                        <a href="#" class="bt-add-buy poppins jsc-add-bag">
                            <i class="fas fa-shopping-bag"></i>Adicionar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>





<div class="container">
    <div class="row">
        <div class="col-1">
            <div class="description">
                <p class="roboto text-gray center">Condições Especiais para sua compra em nossa loja e site.</p>
            </div>

            <div class="time">
                <span class="poppins"><i class="fas fa-signal"></i> Online agora</span>
            </div>
        </div>
    </div>
</div>

<section class="container">
    <div class="row">
        <div class="col-2">
            <div class="dollar">
                <div class="icon-dollar">
                    <i class="fas fa-dollar-sign text-gray"></i>
                </div>
                <div class="value-dollar">
                    <p class="roboto text-dark">PEDIDO MÍNIMO:</p>
                    <p class="roboto text-dark">R$ 35,00</p>
                </div>
            </div>
        </div>
        <div class="col-2">
            <div class="car">
                <div class="icon-car">
                    <i class="fas fa-cart-arrow-down text-gray"></i>
                </div>
                <div class="value-dollar">
                    <p class="roboto text-dark">ENTREGA LOCAL:</p>
                    <p class="roboto text-dark">R$ 7,00</p>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="all bg-search">
    <div class="search">
        <form name="formProductSearch" class="formProductSearch"
              action=""
              method="post">
            <input class="jsc-search" type="text" name="s" placeholder="O que você gostaria de encontrar">
            <button class="btn btn-search"></button>
            <div class="products-ajax jsc-response">

                <ul class="list-numbers">
                    <li>
                        <div class="image-filter">
                            <img src="<?= theme("/assets/images/produto.jpg", CONF_VIEW_THEME);?>">
                        </div>

                        <div class="product-filter">
                            <p class="text-default roboto">
                                <a href="#" class="text-default roboto">Barra
                                    Vintage- Sabonete Vegetal
                                </a>
                            </p>
                            <p><a href=""
                                  class="ext-default roboto">R$ 25.00</a>
                            </p>
                        </div>
                    </li>

                </ul>
            </div>
        </form>
    </div>
</div>


<div class="container products">
    <div class="row">
        <?php for ($i = 0; $i < 4; $i++): ?>
            <div class="col-2" id="16">
                <div class="product">
                    <div class="image-product">

                        <div class="container-product-cover">
                            <a title="# " href="#" class="jsc-product-item">
                                <img title="T#" src="<?= theme("/assets/images/produto.jpg", CONF_VIEW_THEME);?>">
                            </a>
                        </div>

                        <div class="text-production">
                            <p class="text-default roboto">
                                <a title="" class="jsc-product-item" href="#">Blusas de algodão em várias cores</a>
                            </p>
                        </div>
                    </div>

                    <p class="text-default roboto price">R$ 18,62</p>
                    <small class="text-default roboto ds-none">
                        ou em 6x de 3,10
                    </small>

                    <div class="details">
                        <a title="#" href="#" class="text-dark roboto jsc-product-item">
                            <i class="fas fa-shopping-bag"></i> VER DETALHES
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-2" id="16">
                <div class="product">
                    <div class="image-product">

                        <div class="container-product-cover">
                            <a title="# " href="#" class="jsc-product-item">
                                <img title="T#" src="<?= theme("/assets/images/produto-3.jpg", CONF_VIEW_THEME);?>">
                            </a>
                        </div>

                        <div class="text-production">
                            <p class="text-default roboto">
                                <a title="" href="#" class="jsc-product-item">Calça para academia</a>
                            </p>
                        </div>
                    </div>

                    <p class="text-default roboto price">R$ 18,62</p>
                    <small class="text-default roboto ds-none">
                        ou em 6x de 3,10
                    </small>

                    <div class="details">
                        <a title="#" href="#" class="text-dark roboto jsc-product-item">
                            <i class="fas fa-shopping-bag"></i> VER DETALHES
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-2" id="16">
                <div class="product">
                    <div class="image-product">
                        <div class="container-product-cover">
                            <a title="# " href="#" class="jsc-product-item">
                                <img title="T#" src="<?= theme("/assets/images/produto-2.jpg", CONF_VIEW_THEME);?>">
                            </a>
                        </div>
                        <div class="text-production">
                            <p class="text-default roboto">
                                <a title="" href="#" class="jsc-product-item">As novidades não param</a>
                            </p>
                        </div>
                    </div>

                    <p class="text-default roboto price">R$ 18,62</p>
                    <small class="text-default roboto ds-none">
                        ou em 6x de 3,10
                    </small>

                    <div class="details">
                        <a title="#" href="#" class="text-dark roboto jsc-product-item">
                            <i class="fas fa-shopping-bag"></i> VER DETALHES
                        </a>
                    </div>
                </div>
            </div>
        <?php endfor; ?>
    </div>
</div>

