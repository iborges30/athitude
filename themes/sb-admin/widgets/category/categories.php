<?php $v->layout("_admin"); ?>

<div class="container-fluid">

    <?php
    if (!$category): ?>
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">
            <i class="far fa-folder"></i>
                Nova categoria
            </h1>
        </div>

        <form action="<?= url("/admin/category/categories"); ?>" method="post">
            <!--ACTION SPOOFING-->
            <p><a href="<?= url("/admin/category/home"); ?>">Categorias</a></p>
            <input type="hidden" name="action" value="create"/>

            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="first_name">Categoria</label>
                    <input type="text" name="category" id="first_name" placeholder="Categoria"
                           class="form-control" required>
                </div>
            </div>


            <div class="form-group text-right">
                <button class="btn btn-success btn-icon-split">
                    <span class="icon text-white-50">
                        <i class="fas fa-check"></i>
                    </span>
                    <span class="text">Cadastrar</span>
                </button>
            </div>
        </form>
    <?php else: ?>
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">
            <i class="far fa-folder"></i>
                Atualizar categoria
            </h1>
            <div class="form-group text-right">
                <a href="<?= url("/admin/category/categories"); ?>" class="btn btn-primary btn-icon-split">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
                    <span class="text">Nova categoria</span>
                </a>
            </div>
        </div>

        <form action="<?= url("/admin/category/categories/{$category->id}"); ?>" method="post">
            <!--ACTION SPOOFING-->
            <p><a href="<?= url("/admin/category/home"); ?>">Categorias</a></p>

            <input type="hidden" name="action" value="update"/>
            <div class="form-row">

                <div class="form-group col-md-12">
                    <label for="first_name">Categoria</label>
                    <input type="text" name="category"
                           value="<?= $category->category; ?>"
                           placeholder="Categoria"
                           class="form-control" required>
                </div>
            </div>

            <div class="form-group text-right">
                <button class="btn btn-success btn-icon-split">
                    <span class="icon text-white-50">
                        <i class="fas fa-check"></i>
                    </span>
                    <span class="text">Atualizar</span>
                </button>

                <a href="<?= url("/admin/category/home"); ?>" class="btn btn-info btn-icon-split">
                    <span class="icon text-white-50">
                        <i class="fas fa-check"></i>
                    </span>
                    <span class="text">Voltar</span>
                </a>
            </div>
        </form>
    <?php endif; ?>
</div>
