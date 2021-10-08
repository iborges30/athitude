<?php $v->layout("_admin"); ?>

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-copyright"></i>
          Fabricantes
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
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Meus fabricantes</h6>
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
                                    <th>Fabricantes</th>
                                    <th>Gerenciar</th>
                                </tr>
                                </thead>
                                <?php
                                if ($brands):
                                    foreach ($brands as $p):
                                        ?>
                                        <tr role="row">
                                            <td><?= $p->id; ?></td>
                                            <td><?= $p->name; ?></td>
                                            <td>
                                                <a href="<?= url("/admin/brand/brands/{$p->id}"); ?>"
                                                   class="btn btn-info btn-circle" title="Editar">
                                                    <i class="fas fa-check"></i>
                                                </a>

                                                <a href="#" class="btn btn-danger btn-circle"
                                                   data-post="<?= url("/admin/brand/brands/{$p->id}"); ?>"
                                                   data-action="delete"
                                                   data-confirm="ATENÇÃO: Tem certeza que deseja excluir este Fabricante os dados relacionados a ela? Essa ação não pode ser feita!"

                                                <span class="icon text-white-50">
                                                        <i class="fas fa-trash"></i>
                                                    </span>
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
                <!--paginação -->
                <?= $paginator; ?>
            </div>
        </div>
    </div>
</div>