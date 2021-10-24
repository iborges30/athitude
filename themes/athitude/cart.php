<?php $v->layout("_theme");

;?>

<div class="container">
    <div class="row">
        <div class="col-1">
            <div class="my-bag center">
                <h1 class="poppins text-dark"><i class="fas fa-shopping-bag"></i>Minha sacola</h1>
            </div>
        </div>
    </div>

    <div class="cart">
        <ul>
            <?php
            $subTotal = 0;
            if ($_SESSION["cart"]):
                foreach ($_SESSION["cart"] as $p):
                    $subTotal += $p["price"]*$p["amount"];
                    ?>
                    <li class="jsc-item-cart" id="<?= $p["productId"];?>">
                        <div class="cart-item roboto">
                            <div class="row">
                                <div class="col-90">
                                    <p><b><?= $p["productName"];?></b></p>
                                    <span class="price-item-cart">R$ <?= str_price($p["price"]);?></span>
                                    <span class="code-item-cart">Código: <?= $p["code"];?></span>

                                    <div class="attributes-cart-item">
                                        <span>Tamanho: <?= ($p["size"]);?></span>
                                        <span>Cor: <span class="bg-color-item" style="background: <?= $p["color"];?>"></span></span>
                                        <span>Quantidade: <span class="jsc-item-amount-cart"><?= ($p["amount"]);?></span></span>
                                    </div>
                                </div>
                                <div class="col-10 ds-flex col-cart">
                                    <div class="remove-cart-item">
                                        <a href="#" class="jsc-remove-item-cart"
                                           data-remove-item="<?= $p["productId"];?>">X</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                <?php
                endforeach;
            endif;
            ?>
        </ul>
    </div>
</div>

<div class="shipping container">
    <div class="frete roboto">Forma de entrega</div>
    <div class="zipcode">
        <label for="">
            <input type="text" name="zipcode" class="mask-zipcode" maxlength="9">
        </label>
        <div class="btn-shipping">
            <input type="submit" class="js-zip-code" name="sendPost" value="Calcular">
        </div>
    </div>

    <div class="load ds-none">
        <img src="<?=theme("/assets/images/load.gif");?>" alt="Load">
    </div>
</div>

<section class="container change-frete roboto ds-none">
    <div class="change mb-30">

    </div>
</section>


<div class="subtotal mtb-30 roboto">
    <h2 class="center">Subtotal</h2>
    <p class="center">R$
        <span data-subtotal-cart="<?=$subTotal;?>"
              class="jsc-subtotal"><?=$subTotal;?></span>
    </p>
</div>


<div class="container change-frete ds-none">
    <div class="row finished-order-cart roboto ">
        <div class="col-1">
            <div class="orders-cart">
                <div class="continue-order-buttom"><a href="<?= url();?>">Continuar comprando</a></div>
                <div class="order-cart-buttom">
                    <a href="#" class="jsc-close-orders">Fechar compra</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!--FOOTER --->
