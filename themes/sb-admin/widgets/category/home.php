<?php $v->layout("_admin"); ?>

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
        <i class="far fa-folder"></i>
            Categoria de produtos
        </h1>
        <div class="form-group text-right">
            <a href="<?= url("/admin/category/categories"); ?>" class="btn btn-primary btn-icon-split">
                <span class="icon text-white-50">
                <i class="far fa-folder"></i>
                </span>
                <span class="text">Nova categoria</span>
            </a>
        </div>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Minhas categorias de produtos</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <div class="dataTables_wrapper dt-bootstrap4">

                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table table-bordered" width="100%" cellspacing="0">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Categoria</th>
                                    <th>Gerenciar</th>
                                </tr>
                                </thead>
                                <?php
                                if ($categories):
                                    foreach ($categories as $p):
                                        ?>
                                        <tr role="row">
                                            <td><?= $p->id; ?></td>
                                            <td><?= $p->category; ?></td>
                                            <td>
                                                <a href="<?= url("/admin/category/categories/{$p->id}"); ?>"
                                                   class="btn btn-info btn-circle" title="Editar">
                                                    <i class="fas fa-check"></i>
                                                </a>

                                                <a href="#" class="btn btn-danger btn-circle"
                                                   data-post="<?= url("/admin/category/categories/{$p->id}"); ?>"
                                                   data-action="delete"
                                                   data-confirm="ATEN????O: Tem certeza que deseja excluir esta categoria os dados relacionados a ela? Essa a????o n??o pode ser feita!"

                                                <span class="icon text-white-50">
                                                        <i class="fas fa-trash"></i>
                                                    </span>

                                                </a>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php
                                    endforeach;
                                endif;
                                ?>
                            </table>
                        </div>
                    </div>
                </div>
                <!--pagina????o -->
                <?= $paginator; ?>
            </div>
        </div>
    </div>
</div>
