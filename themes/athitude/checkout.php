<?php $v->layout("_theme"); ?>

<?php
var_dump($_SESSION["cart"]);
if (!empty($_SESSION["cart"])):
    ?>
    <div class="dialog-complete">
        <div class="modal-load">
            <img src="<?= theme("/assets/images/load.gif", CONF_VIEW_THEME); ?>">
        </div>
    </div>

    <div class="orders">
        <div class="row">
            <div class="col-1">
                <header>
                    <h1 class=" color-dark  jsc-menssage-response center roboto">DADOS DO CLIENTE</h1>
                </header>
            </div>
            <div class="col-1">
                <div class="orders-client poppins">
                    <form action="<?= url("/orders"); ?>" method="post" name="formCompletedOrder">
                        <input type="hidden" name="delivery_rate">
                        <input type="hidden" name="deadline">
                        <?= csrf_input(); ?>
                        <div class="ajax_response"></div>

                        <div class="form-group">
                            <label>
                                <span class="color-dark ">CPF</span>
                            </label>
                            <input type="tel" name="document" class="mask-document jsc-document"
                                   placeholder="Informe seu cpf" required="" maxlength="14">
                        </div>

                        <div class="form-group">
                            <label>
                                <span class="color-dark ">NOME DO CLIENTE</span>
                            </label>
                            <input type="text" class="ajax-name-client"
                                   name="name" required="" placeholder="Informe seu nome completo">
                        </div>


                        <div class="form-group">
                            <label>
                                <span class="color-dark ">WHATSAPP/Telefone</span>
                            </label>
                            <input type="text" name="phone" class="mask-phone ajax-phone"
                                   placeholder="Informe seu telefone" required="" maxlength="15">
                        </div>


                        <div class="form-group">
                            <label>
                                <span class="color-dark ">E-mail</span>
                            </label>
                            <input type="email" name="email" class="ajax-email" placeholder="Informe seu E-mail"
                                   required="">
                        </div>


                        <h2 class=" color-dark center roboto">ENDEREÇO DE ENTREGA</h2>

                        <div class="form-group address">
                            <div class="row">
                                <div class="col-1">
                                    <label>
                                        <span class="color-dark ">Endereço</span>
                                    </label>
                                    <input type="text" class="ajax-address" name="address"
                                           placeholder="Informe o nome da rua">
                                </div>

                                <div class="col-1">
                                    <label>
                                        <span class="color-dark ">CEP</span>
                                    </label>
                                    <input type="tel"
                                           class="mask-zipcode wc_getCep ajax-zipcode"
                                           name="zipcode"
                                           placeholder="Informe o CEP" maxlength="9">
                                </div>

                                <div class="col-2">
                                    <label>
                                        <span class="color-dark ">Número</span>
                                    </label>
                                    <input type="text" name="number" class="ajax-number"
                                           placeholder="Informe o número da sua residência">
                                </div>

                                <div class="col-2">
                                    <label>
                                        <span class="color-dark ">Bairro</span>
                                    </label>
                                    <input type="text" name="square" class="ajax-square"
                                           placeholder="Informe o seu bairro">
                                </div>

                                <div class="col-2">
                                    <label>
                                        <span class="color-dark ">Complemento</span>
                                    </label>
                                    <input type="text" name="complement" class="ajax-complement"
                                           placeholder="Informe o seu complemento">
                                </div>

                                <div class="col-2">
                                    <label>
                                        <span class="color-dark ">Ponto de referência</span>
                                    </label>
                                    <input type="text" name="reference" class="ajax-reference"
                                           placeholder="Informe um ponto de referência">
                                </div>

                                <div class="col-2">
                                    <label>
                                        <span class="color-dark ">Cidade</span>
                                    </label>
                                    <input type="text" name="city" class="wc_localidade ajax-city"
                                           placeholder="Informe a cidade">
                                </div>

                                <div class="col-2">
                                    <label>
                                        <span class="color-dark ">Estado</span>
                                    </label>
                                    <input type="text" name="state" class="wc_uf ajax-state"
                                           placeholder="Informe o Estado">
                                </div>

                            </div>
                        </div>

                        <h2 class=" color-dark center">FORMA DE ENTREGA</h2>
                        <div class="form-group">
                            <label>
                                <span class="color-dark ">FORMA DE ENTREGA</span>
                            </label>
                            <select name="sendOrders" required="required">
                                <
                                <option disabled="" selected>Selecionem uma forma de entrega</option>
                                <?php foreach ($_SESSION["zipcode"] as $p) : ?>
                                    <option value="<?= $p['name']; ?>"><?= $p['name']; ?> -
                                        R$ <?= str_price($p['price']); ?> - <?= $p['deadline']; ?> dias
                                    </option>
                                <?php endforeach; ?>
                                <option value="store">Retirar na Loja - R$ 0</option>

                            </select>
                        </div>

                        <h2 class="poppins text-dark roboto center">FORMA DE PAGAMENTO</h2>
                        <div class="form-group">
                            <label>
                                <span class="text-dark roboto">FORMA DE PAGAMENTO</span>
                            </label>
                            <select name="payment_method" required="" class="paymen-method">
                                <option disabled="" selected="">Selecione um método de pagamento</option>
                                <?php foreach (paymentMethod() as $key => $value): ?>
                                    <option value="<?= $key; ?>"><?= $value; ?></option>
                                <?php endforeach; ?>

                            </select>


                            <div class="payment-credit-card ds-none">
                                <label>
                                    <span class="text-dark roboto">Parcelamento</span>
                                </label>

                                <select name="installments">

                                    //REGRA PARA A QUANTIDADE DE PARCELAS
                                    <?php $limit = $enterprise->installment;
                                    foreach ($installments as $installment) :
                                    if ($limit >= $installment['installment']) :
                                    ?>
                                    <option value="<?= $installment['installment'] ?>">
                                        <?= $installment['installment'] . ' x R$ ' . str_price($installment['value']) ?>
                                    </option>
                                    <?php
                                            endif;
                                        endforeach;
                                        ?>
                                    <option disabled="">Selecione a quantidade de parcelas</option>
                                </select>
                            </div>
                        </div>
                </div>
            </div>
            <!----- CARTÃO --->
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-1">
                <div class="orders-details">
                    <h2 class=" color-dark mb-30">RESUMO DO PEDIDO</h2>
                    <div class="order">
                        <ul>
                            <?php
                            //REGRA PARA O VALOR MÍNIMO
                            //FOREACH PARA SABER O TOTAL
                            $total = null;
                            if (!empty($_SESSION["cart"])) :
                                foreach ($_SESSION["cart"] as $p) :
                                    $total += ($p["amount"] * $p["price"]);
                                    ?>
                                    <li>
                                        <div class="order-itens">
                                            <span><?= $p["amount"]; ?>x</span>
                                            <span><?= $p["productName"]; ?> - <b>Tamanho</b> <?= $p["size"]; ?></span>
                                            <span><b>Código</b> <?= $p["code"]; ?></span>
                                        </div>
                                    </li>
                                <?php
                                endforeach;
                            endif;
                            ?>

                        </ul>
                        <div class="order-total mt-30">
                            <p><b>TOTAL ITENS</b>: R$ <span class="total-product"><?= $subTotal;?></span></p>

                            <div class="send get-send-product">
                                <p><b>FORMA DE ENTREGA</b></p>
                            </div>
                        </div>

                        <div class="order-total-payment ">
                            <p><b>TOTAL À PAGAR</b>: R$ <span><?= $subTotal?></span></p>
                            <div class="send mt-30">
                                <p>O seu pedido será registrado em nosso sistema e enviado para o WhatsApp da nossa
                                    loja.
                                    A Athtitude Fitness agradece pela preferência.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-1">
            <div class="orders-action-send">
                <input type="hidden" name="total_orders">
                <input type="submit" name="finishedOrders" value="Finalizar compra" class="btn-finished">
            </div>
            </form>
        </div>
    </div>
<?php
endif;
?>
<!--FOOTER --->
