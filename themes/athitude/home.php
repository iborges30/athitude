<?php $v->layout("_theme"); ?>

<div class="dialog-home-products ds-none">
    <div class="box-load">
        <img src="<?=theme("/assets/images/loadball.gif");?>" alt="load">
    </div>
</div>

<div class="dialog all ajax-product-modal"></div>


<div class="container">
    <div class="row">
        <div class="col-1">
            <div class="description">
                <p class="roboto text-gray center"><?= $enterprise->information;?></p>
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
                    <p class="roboto text-dark">R$ <?= str_price($enterprise->minimum_order);?></p>
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
                    <p class="roboto text-dark">R$ <?= str_price($enterprise->delivery_rate);?></p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- PESQUISA -->
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
                            <img src="<?= theme("/assets/images/produto.jpg", CONF_VIEW_THEME); ?>">
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
<!-- PESQUISA -->

<div class="container products">
    <div class="row">
        <?php
        if ($products):
            foreach ($products as $p) :
                $v->insert("products", ["p" => $p]); ?>
            <?php
            endforeach;
        endif;
        ?>

        <div class="row">
            <div class="col-1">
                <?= $paginator; ?>
            </div>
        </div>
    </div>
</div>

