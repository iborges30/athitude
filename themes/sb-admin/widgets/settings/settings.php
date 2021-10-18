<?php $v->layout("_admin"); ?>

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-fw fa-address-book"></i>
            Minha empresa
        </h1>
    </div>

    <div class="row">
        <div class="col-xl-12 col-lg-7">
            <!-- Area Chart -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <div class="col-sm-12 ">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab"
                                   aria-controls="home" aria-selected="true">Minha empresa</a>
                            </li>
                            <?php
                            if ($enterprise):
                                ?>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link together" id="contact-tab" data-toggle="tab"
                                       href="#enturmaneto"
                                       role="tab"
                                       aria-controls="contact" data-student="<?= $enterprise->id; ?>"
                                       aria-selected="false">Sobre</a>
                                </li>

                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile"
                                       role="tab"
                                       aria-controls="profile" aria-selected="false">Configurações de Entrega</a>
                                </li>
                            <?php
                            endif;
                            ?>
                        </ul>
                    </div>

                    <div class="card-body bg-white radius shadow-sm">
                        <div class="tab-content " id="myTabContent">
                            <div class="tab-pane fade show active ajax-form-student" id="home" role="tabpanel"
                                 aria-labelledby="home-tab">
                                <?php
                                if (!$enterprise):
                                    ?>
                                    <form action="<?= url("/admin/settings/settings"); ?>" method="post"
                                          name="formenrllments">
                                        <input type="hidden" value="create" name="action">
                                        <div class="form-row">
                                            <div class="form-group col-md-12">
                                                <label for="inputEmail4">Nome da empresa</label>
                                                <input type="text" name="enterprise" class="form-control"
                                                       required
                                                       placeholder="Informe o nome da sua empresa">
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label for="inputPassword4">CNPJ</label>
                                                <input type="text" name="document" class="form-control mask-enterprise"
                                                       required
                                                       placeholder="Informe o CNPJ">
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label for="inputAddress">WhatsApp</label>
                                                <input type="text" name="whatsapp" class="form-control mask-phone"
                                                       required
                                                       placeholder="Informe o WhatsApp da loja">
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label for="inputZip">CEP</label>
                                                <input type="text" name="zip_code"
                                                       class="form-control mask-zip-code getCep">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="inputCity">Endereço</label>
                                                <input type="text" name="address" class="form-control wc_logradouro"
                                                       placeholder="Endereço da loja">
                                            </div>

                                            <div class="form-group col-md-2">
                                                <label for="inputZip">Número</label>
                                                <input type="text" name="number" class="form-control">
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label for="inputZip">Bairro</label>
                                                <input type="text" name="district" class="form-control wc_bairro">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="inputZip">Complemento</label>
                                                <input type="text" name="complement" class="form-control">
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label for="inputZip">Cidade</label>
                                                <input type="text" name="city" class="form-control wc_localidade">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="inputZip">Estado</label>
                                                <input type="text" name="state" maxlength="2"
                                                       class="form-control wc_uf">
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary ">Salvar</button>

                                    </form>
                                <?php
                                else:
                                    ?>
                                    <form action="<?= url("/admin/settings/settings/{$enterprise->id}"); ?>"
                                          method="post"
                                          name="formEnterprise">
                                        <input type="hidden" value="update" name="action">
                                        <div class="form-row">
                                            <div class="form-group col-md-12">
                                                <label for="inputEmail4">Nome da empresa</label>
                                                <input type="text" name="enterprise" class="form-control"
                                                       required value="<?= $enterprise->enterprise; ?>"
                                                       placeholder="Informe o nome da sua empresa">
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label for="inputPassword4">CNPJ</label>
                                                <input type="text" name="document" class="form-control mask-enterprise"
                                                       required value="<?= $enterprise->document; ?>"
                                                       placeholder="Informe o CNPJ">
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label for="inputAddress">WhatsApp</label>
                                                <input type="text" name="whatsapp" class="form-control mask-phone"
                                                       required value="<?= $enterprise->whatsapp; ?>"
                                                       placeholder="Informe o WhatsApp da loja">
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label for="inputZip">CEP</label>
                                                <input type="text" name="zip_code" value="<?= $enterprise->zip_code; ?>"
                                                       class="form-control mask-zip-code getCep">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="inputCity">Endereço</label>
                                                <input type="text" name="address" value="<?= $enterprise->address; ?>"
                                                       class="form-control wc_logradouro"
                                                       placeholder="Endereço da loja">
                                            </div>

                                            <div class="form-group col-md-2">
                                                <label for="inputZip">Número</label>
                                                <input type="text" name="number" value="<?= $enterprise->number; ?>"
                                                       class="form-control">
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label for="inputZip">Bairro</label>
                                                <input type="text" name="district" value="<?= $enterprise->district; ?>"
                                                       class="form-control wc_bairro">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="inputZip">Complemento</label>
                                                <input type="text" name="complement"
                                                       value="<?= $enterprise->complement; ?>" class="form-control">
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label for="inputZip">Cidade</label>
                                                <input type="text" name="city" value="<?= $enterprise->city; ?>"
                                                       class="form-control wc_localidade">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="inputZip">Estado</label>
                                                <input type="text" name="state" maxlength="2"
                                                       class="form-control wc_uf" value="<?= $enterprise->state; ?>">
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-success ">Atualizar</button>

                                    </form>
                                <?php
                                endif;
                                ?>
                            </div>

                            <div class="tab-pane fade ajax-together" id="enturmaneto" role="tabpanel"
                                 aria-labelledby="contact-tab">
                                <form action="<?= url("/admin/about/settings/{$enterprise->id}"); ?>"
                                      method="post"
                                      name="formAbout">
                                    <input type="hidden" value="updateAbout" name="action">
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="inputEmail4">Categoria</label>
                                            <input type="text" name="category" class="form-control"
                                                   required value="<?= $enterprise->category; ?>"
                                                   placeholder="Ex: Roupas e sapatos">
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="inputPassword4">Informação</label>
                                            <input type="text" name="information" class="form-control"
                                                   required value="<?= $enterprise->information; ?>"
                                                   placeholder="Ex: Condições Especiais para sua compra em nossa loja e site.">
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="inputZip">Capa</label>
                                            <input type="file" name="image"
                                                   class="form-control-file">
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary ">Atualizar</button>
                                </form>
                            </div>


                            <div class="tab-pane fade ajax-together" id="profile" role="tabpanel"
                                 aria-labelledby="contact-tab">
                                <form name="formRate" action="<?= url("/admin/rate/settings/{$enterprise->id}"); ?>"
                                      method="post"
                                      name="formRate">
                                    <input type="hidden" value="updateRate" name="action">
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="inputEmail4">Taxa de entrega</label>
                                            <input type="text" class="form-control" name="delivery_rate"
                                                   value="<?= str_price($enterprise->delivery_rate); ?>"
                                                   placeholder="Taxa de entrega">
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="inputPassword4">Pedido mínimo</label>
                                            <input type="text" class="form-control" name="minimum_order"
                                                   placeholder="Valor mínimo para realizar um pedido"
                                                   value="<?= str_price($enterprise->minimum_order); ?>">
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="inputPassword4">Quantidade de parcelas</label>
                                            <input type="number" class="form-control" name="installment"
                                                   placeholder="Valor mínimo para realizar um pedido"
                                                   value="<?= $enterprise->installment; ?>">
                                        </div>


                                    </div>
                                    <button type="submit" class="btn btn-primary ">Salvar</button>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Bar Chart -->
    </div>
</div>


