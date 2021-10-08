<?php $v->layout("_admin"); ?>

<div class="container-fluid">

    <?php
    if (!$brand): ?>
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-copyright"></i>
                Novo Fabricante
            </h1>
        </div>

        <form action="<?= url("/admin/brand/brands"); ?>" method="post">
            <!--ACTION SPOOFING-->
            <p><a href="<?= url("/admin/brand/home"); ?>">Fabricante</a></p>
            <input type="hidden" name="action" value="create"/>

            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="first_name">Fabricante</label>
                    <input type="text" name="name" id="first_name" placeholder="Fabricante"
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
                <i class="fas fa-copyrights"></i>
                Atualizar Fabricante
            </h1>
            <div class="form-group text-right">
                <a href="<?= url("/admin/brand/brands"); ?>" class="btn btn-primary btn-icon-split">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
                    <span class="text">Novo Fabricante</span>
                </a>
            </div>
        </div>

        <form action="<?= url("/admin/brand/brands/{$brand->id}"); ?>" method="post">
            <!--ACTION SPOOFING-->
            <p><a href="<?= url("/admin/brand/home"); ?>">Fabricante</a></p>

            <input type="hidden" name="action" value="update"/>
            <div class="form-row">

                <div class="form-group col-md-12">
                    <label for="first_name">Fabricante</label>
                    <input type="text" name="name"
                           value="<?= $brand->name; ?>"
                           placeholder="Fabricante"
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


                <a href="<?= url("/admin/brand/home"); ?>" class="btn btn-info btn-icon-split">
                    <span class="icon text-white-50">
                        <i class="fas fa-check"></i>
                    </span>
                    <span class="text">Voltar</span>
                </a>
            </div>
        </form>
    <?php endif; ?>

</div>
