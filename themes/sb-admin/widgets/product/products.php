<?php $v->layout("_admin"); ?>
<div class="container-fluid">
    <?php $v->insert("widgets/product/modal_category"); ?>
    <?php $v->insert("widgets/product/modal_brand"); ?>

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-fw fa-building"></i>
            Novo Produto
        </h1>
    </div>

    <div class="col-sm-12">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home"
                   aria-selected="true">Novo Produto</a>
            </li>

        </ul>
    </div>

    <div class="card-body bg-white radius shadow">
        <div class="tab-content " id="myTabContent">
            <!-- CADASTRO GERAL -->
            <div class="tab-pane fade show active row" id="home" role="tabpanel"
                 aria-labelledby="home-tab">
                <div class="row">
                    <div class="col-lg-4 order-lg-2">
                        <div class="card shadow mb-4">
                            <div class="card-profile-image mt-4 col-md-12 text-center">
                                <figure class="figure">
                                    <img src="<?= theme("/assets/images/logo.jpg", CONF_VIEW_THEME); ?>"
                                         alt="Atitude" class="js-profile  image">
                                </figure>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-8 order-lg-1">
                        <div class="card shadow mb-4">
                            <div class="card-body">
                                <form action="<?= url("/admin/product/product"); ?>" method="post" name="formProduct">
                                    <input type="hidden" name="action" value="create">
                                    <div class="pl-lg-1">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group focused">
                                                    <label class="form-control-label" for="name">Código
                                                        <span class="small text-danger">*</span></label>
                                                    <input type="text" id="code" class="form-control" name="code"
                                                           placeholder="Informe o nome do código do produto">
                                                </div>
                                            </div>

                                            <div class="col-md-9">
                                                <div class="form-group focused">
                                                    <label class="form-control-label" for="name">Produto
                                                        <span class="small text-danger">*</span></label>
                                                    <input type="text" id="name" class="form-control" name="name"

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
                                                    <input type="text" name="price" class="form-control mask-money"
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
                                                        <input type="file" class="custom-file-input wc_loadimage"
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
                                                    <textarea class="form-control" name="description" cols="30"
                                                              rows="10"></textarea>

                                                </div>
                                            </div>


                                            <div class="col-md-3">
                                                <div class="form-group ">
                                                    <label class="form-control-label" for="name">Largura
                                                        <span class="small text-danger">*</span></label>
                                                    <input type="text" name="width" class="form-control"
                                                           placeholder="Largura do produto">

                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group ">
                                                    <label class="form-control-label" for="name">Profundidade
                                                        <span class="small text-danger">*</span></label>
                                                    <input type="text" name="depth" class="form-control"
                                                           placeholder="Profundidade do produto">

                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group ">
                                                    <label class="form-control-label" for="name">Comprimento
                                                        <span class="small text-danger">*</span></label>
                                                    <input type="text" name="length" class="form-control"
                                                           placeholder="Comprimento do produto">

                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group ">
                                                    <label class="form-control-label" for="name">Peso
                                                        <span class="small text-danger">*</span></label>
                                                    <input type="text" name="weight" class="form-control"
                                                           placeholder="Peso do produto">

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