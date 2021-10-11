<?php $v->layout("_admin"); ?>
<div class="container-fluid">
    <?php $v->insert("widgets/product/modal_brand"); ?>
    <?php $v->insert("widgets/product/modal_category"); ?>
    <?php $v->insert("widgets/product/modal_inventory"); ?>
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-fw fa-building"></i>
            Editar Produto
        </h1>
    </div>

    <div class="col-sm-12">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home"
                   aria-selected="true">Editar Produto</a>
            </li>

            <li class="nav-item" role="presentation">
                <a class="nav-link" id="capa-tab" data-toggle="tab" href="#capa" role="tab" aria-controls="capa"
                   aria-selected="true">Estoque</a>
            </li>

            <li class="nav-item" role="presentation">
                <a class="nav-link" id="photos-tab" data-toggle="tab" href="#photos" role="tab" aria-controls="capa"
                   aria-selected="true">Galeria de imagens</a>
            </li>

        </ul>
    </div>

    <div class="card-body bg-white radius shadow">
        <div class="tab-content " id="myTabContent">
            <!-- CADASTRO GERAL -->
            <div class="tab-pane fade show  row" id="home" role="tabpanel"
                 aria-labelledby="home-tab">
                <div class="row">
                    <div class="col-lg-4 order-lg-2">
                        <div class="card shadow mb-4">
                            <div class="card-profile-image mt-4 col-md-12 text-center">
                                <figure class="figure">
                                    <?= photo_img($product->image, $product->name, 400, 400, null, "image"); ?>
                                </figure>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-8 order-lg-1">
                        <div class="card shadow mb-4">
                            <div class="card-body">
                                <form action="<?= url("/admin/product/update/{$product->id}"); ?>" method="post"
                                      name="formProduct">
                                    <input type="hidden" name="action" value="update">
                                    <div class="pl-lg-1">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group focused">
                                                    <label class="form-control-label" for="name">Código
                                                        <span class="small text-danger">*</span></label>
                                                    <input type="text" id="code" class="form-control"
                                                           name="code"
                                                           value="<?= $product->code; ?>"
                                                           placeholder="Informe o nome do código do produto">
                                                </div>
                                            </div>

                                            <div class="col-md-9">
                                                <div class="form-group focused">
                                                    <label class="form-control-label" for="name">Produto
                                                        <span class="small text-danger">*</span></label>
                                                    <input type="text" id="name" class="form-control" name="name"
                                                           value="<?= $product->name; ?>"
                                                           placeholder="Informe o nome do produto">
                                                </div>
                                            </div>


                                            <div class="col-md-4">
                                                <div class="form-group focused">
                                                    <label class="form-control-label" for="name">Categoria
                                                        <span class="small text-danger">*</span></label>
                                                    <select name="category_id" id="" class="form-control jsc-category">
                                                        <?php
                                                        if ($categories):
                                                            foreach ($categories as $p):
                                                                ?>
                                                                <option value="<?= $p->id; ?>"><?= $p->category; ?></option>
                                                            <?php
                                                            endforeach;
                                                        endif;
                                                        ?>
                                                        <option value="category">Nova Categoria</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group focused">
                                                    <label class="form-control-label" for="name">Fabricante
                                                        <span class="small text-danger">*</span></label>
                                                    <select name="brand_id" id="" class="form-control jsc-brand">
                                                        <?php
                                                        if ($brands):
                                                            foreach ($brands as $p):
                                                                ?>
                                                                <option value="<?= $p->id; ?>"><?= $p->name; ?></option>
                                                            <?php
                                                            endforeach;
                                                        endif;
                                                        ?>
                                                        <option value="new">Novo Fabricante</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group focused">
                                                    <label class="form-control-label" for="name">Preço
                                                        <span class="small text-danger">*</span></label>
                                                    <input type="text" name="price"
                                                           value="<?= $product->price; ?>"
                                                           class="form-control mask-money"
                                                           placeholder="Informe o valor do produto">
                                                </div>
                                            </div>


                                            <div class="col-md-6">
                                                <div class="form-group focused">
                                                    <label class="form-control-label" for="name">Status
                                                        <span class="small text-danger">*</span></label>
                                                    <select name="status" id="" class="form-control">
                                                        <?php
                                                        foreach (status() as $key => $p):
                                                            ?>
                                                            <option value="<?= $key; ?>"><?= $p; ?></option>
                                                        <?php
                                                        endforeach;
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6" style="margin-top: 30px">
                                                <div class="form-group focused">
                                                    <div class="custom-file">
                                                        <input type="file"
                                                               accept="image/jpeg, image/jpg, image/png"
                                                               class="custom-file-input wc_loadimage"
                                                               name="image" id="inputGroupFile01">
                                                        <label class="custom-file-label"
                                                               for="inputGroupFile01">Imagem</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group ">
                                                    <label class="form-control-label" for="name">Descrição
                                                        <span class="small text-danger">*</span></label>
                                                    <textarea class="form-control"
                                                              name="description" cols="30"
                                                              rows="10"><?= $product->description; ?></textarea>

                                                </div>
                                            </div>


                                            <div class="col-md-3">
                                                <div class="form-group ">
                                                    <label class="form-control-label" for="name">Largura
                                                        <span class="small text-danger">*</span></label>
                                                    <input type="text" name="width" value="<?= $product->width; ?>"
                                                           class="form-control mask-money"
                                                           placeholder="Largura do produto">

                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group ">
                                                    <label class="form-control-label" for="name">Profundidade
                                                        <span class="small text-danger">*</span></label>
                                                    <input type="text"
                                                           value="<?= $product->depth; ?>"
                                                           name="depth" class="form-control mask-money"
                                                           placeholder="Profundidade do produto">

                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group ">
                                                    <label class="form-control-label" for="name">Comprimento
                                                        <span class="small text-danger">*</span></label>
                                                    <input type="text"
                                                           value="<?= $product->length; ?>"
                                                           name="length" class="form-control mask-money"
                                                           placeholder="Comprimento do produto">

                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group ">
                                                    <label class="form-control-label" for="name">Peso
                                                        <span class="small text-danger">*</span></label>
                                                    <input type="text"
                                                           value="<?= $product->weight; ?>"
                                                           name="weight" class="form-control mask-money"
                                                           placeholder="Peso do produto">

                                                </div>
                                            </div>

                                            <div class="col text-right" style="margin-top: 30px">
                                                <div class="form-group ">
                                                    <button type="submit" class="btn btn-success">Atualizar</button>
                                                    <a href="#" class="btn btn-primary ml-4">Voltar</a>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CAPA -->
            <div class="row tab-pane fade show active " id="capa" role="tabpanel" aria-labelledby="capa-tab">
                <div class="row">
                    <div class="col-lg-12 order-lg-1">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Tamanho</th>
                                <th scope="col">Cor</th>
                                <th scope="col">Quantidade</th>
                                <th scope="col">Ação</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>P</td>
                                <td>Amarelo</td>
                                <td>1</td>
                                <td>Deleta/Edita</td>
                            </tr>
                            <tr>
                                <th scope="row">1</th>
                                <td>P</td>
                                <td>Amarelo</td>
                                <td>1</td>
                                <td>Deleta/Edita</td>
                            </tr>
                            <tr>
                                <th scope="row">1</th>
                                <td>P</td>
                                <td>Amarelo</td>
                                <td>1</td>
                                <td>Deleta/Edita</td>
                            </tr>
                            </tbody>
                        </table>
                        <div class="col text-right" style="margin-top: 30px">
                            <div class="form-group ">
                                <a href="#"
                                   data-product-id="<?=$product->id;?>"
                                   class="btn btn-success ml-4 jsc-inventory-open-modal">Cadastrar</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- PHOTOS -->
            <!-- CAPA -->
            <div class="row tab-pane fade show  " id="photos" role="tabpanel" aria-labelledby="photos-tab">
                <div class="row">
                    <div class="col-lg-6 order-lg-2">
                        <div class="card shadow mb-4">
                            <div class="card-profile-image mt-4 col-md-12 text-center">
                                <figure class="figure">
                                    <img src="https://fomix.net.br/plus/storage/images/cache/cover-burguer-delivery-375-0a5e0799.png"
                                         alt="Burguer Delivery" class="js-capa imagecover"></figure>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 order-lg-1">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">
                                    Burguer Delivery </h6>
                            </div>
                            <div class="card-body">

                                <form action="https://fomix.net.br/plus/admin/enterprise/myenterprise/update-cover"
                                      method="post">
                                    <input type="hidden" name="action" value="update">
                                    <div class="pl-lg-1">
                                        <div class="row">


                                            <div class="col-lg-12" style="margin-top: 30px">
                                                <div class="form-group focused">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input wc_loadimage"
                                                               name="imagecover" id="inputGroupFile02">
                                                        <label class="custom-file-label"
                                                               for="inputGroupFile02">Imagem</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col text-right" style="margin-top: 30px">
                                                <div class="form-group ">
                                                    <button type="submit" class="btn btn-success">Atualizar</button>
                                                    <a href="https://fomix.net.br/plus/admin/enterprise/home"
                                                       class="btn btn-primary ml-4">Voltar</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>