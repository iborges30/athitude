<?php require("inc/header.php"); ?>

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
                <?php for ($i = 0;
                           $i < 5;
                           $i++): ?>
                    <li>
                        <div class="cart-item roboto">
                            <div class="row">
                                <div class="col-90">
                                    <p><b>Blusa de algodão</b></p>
                                    <span class="price-item-cart">R$ 50,00</span>
                                    <span class="code-item-cart">Código: #4056</span>

                                    <div class="attributes-cart-item">
                                        <span>Tamanho: G</span>
                                        <span>Cor: <span class="bg-color-item">teste</span></span>
                                    </div>
                                </div>
                                <div class="col-10 ds-flex col-cart">
                                    <div class="remove-cart-item">
                                        <a href="#">X</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                <?php
                endfor;
                ?>
            </ul>
        </div>
    </div>

    <div class="shipping">
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
            <img src="assets/images/load.gif" alt="Load">
        </div>
    </div>

    <section class="container change-frete roboto " style="display: flex;">
        <div class="change mb-30">

            <label for="">ENTREGA EM CAMPO NOVO DO PARECIS - R$ 5,00
                <input type="radio" name="freteEscolhido" value="0" class="ajax-type-send">
            </label>

            <label for="">ENTREGA EM TANGARÁ DA SERRA - R$ 5,00
                <input type="radio" name="freteEscolhido" value="0" class="ajax-type-send">
            </label>

            <label>Sedex<span class="ajax-valor">: R$ 27.7 - 4 dias </span>
                <input class="ajax-type-send"
                       type="radio"
                       value="27.7"
                       name="freteEscolhido">
            </label>

            <label>PAC<span class="ajax-valor">: R$ 24.3 - 8 dias </span>
                <input class="ajax-type-send" type="radio" value="24.3"
                       name="freteEscolhido">
            </label>

            <label for="">RETIRAR NA LOJA - R$ 0,00
                <input type="radio" name="freteEscolhido" value="0" class="ajax-type-send">
            </label>
        </div>
    </section>


    <div class="subtotal mtb-30 roboto">
        <h2 class="center">Subtotal</h2>
        <p class="center">R$ <span data-subtotal="137.8">137,80</span></p>
    </div>


    <div class="container">
        <div class="row finished-order-cart roboto" style="display: block;">
            <div class="col-1">
                <div class="orders-cart">
                    <div class="continue-order-buttom"><a href="https://bellachick.net.br/loja">Continuar comprando</a></div>
                    <div class="order-cart-buttom"><a href="#" class="jsc-close-orders">Fechar compra</a></div>
                </div>
            </div>
        </div>
    </div>

<!--FOOTER --->
<?php require("inc/footer.php"); ?>