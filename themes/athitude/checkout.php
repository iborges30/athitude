<?php require("inc/header.php"); ?>

    <div class="orders">
        <div class="row">
            <div class="col-1">
                <header>
                    <h1 class=" color-dark  jsc-menssage-response center roboto">DADOS DO CLIENTE</h1>
                </header>
            </div>
            <div class="col-1">
                <div class="orders-client poppins">
                    <form action="#" method="post" name="formCompletedOrder">
                        <input type="hidden" name="delivery_rate">
                        <input type="hidden" name="deadline">
                        <input type="hidden" name="csrf" value="39cc6326ca75eba3cd601b3a489f7ec8">
                        <div class="ajax_response"></div>
                        <div class="form-group">
                            <label>
                                <span class="color-dark ">NOME DO CLIENTE</span>
                            </label>
                            <input type="text" name="name" required="" placeholder="Informe seu nome completo">
                        </div>

                        <div class="form-group">
                            <label>
                                <span class="color-dark ">CPF</span>
                            </label>
                            <input type="tel" name="document" class="mask-document jsc-document"
                                   placeholder="Informe seu cpf" required="" maxlength="14">
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
                                    <input type="tel" class="mask-zipcode wc_getCep ajax-zipcode" name="zipcode"
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
                                <option disabled="" selected="">Selecionem uma forma de entrega</option>
                                <option value="Sedex">Sedex - R$ 27,70 - 4 dias</option>
                                <option value="PAC">PAC - R$ 24,30 - 8 dias</option>
                                <option value="store">Retirar na Loja - R$ 0</option>
                            </select>
                        </div>

                    </form>
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
                            <li class="mt-10">
                                <div class="order-itens">
                                    <span>1x</span>
                                    <span>Anel Feminino Estilo Formatura Verde Esmeralda - <b>Tamanho</b> 15</span>
                                    <span><b>Código</b> AE 0921</span>
                                </div>
                            </li>

                            <li class="mt-10">
                                <div class="order-itens">
                                    <span>1x</span>
                                    <span>Anel Feminino Estilo Formatura Verde Esmeralda - <b>Tamanho</b> 15</span>
                                    <span><b>Código</b> AE 0921</span>
                                </div>
                            </li>

                        </ul>
                        <div class="order-total mt-30">
                            <p><b>TOTAL ITENS</b>: R$ <span class="total-product">137,80</span></p>

                            <div class="send get-send-product">
                                <p><b>FORMA DE ENTREGA</b></p>
                            </div>
                        </div>

                        <div class="order-total-payment ">
                            <p><b>TOTAL À PAGAR</b>: R$ <span>137,80</span></p>
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
        </div>
    </div>
    <!--FOOTER --->
<?php require("inc/footer.php"); ?>