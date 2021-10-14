<!--- MODAL  --->
<?php if (empty($item)): ?>
    <div class="modal fade " tabindex="-1" role="dialog" id="new-inventory">
        <div class="modal-dialog modal-xl">
            <div class="modal-content" style="border: none">
                <div class="modal-header bg-info">
                    <h5 class="modal-title" style="color: #fff;"><i class="fas fa-keyboard"></i> Cadastrar Estoque
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="<?= url("/admin/inventory/create"); ?>"
                          name="formInventory"
                          class="ajax_off" method="post">
                        <div class="row">
                            <div class="col-md-12 ajax_response_modal bg-warning p-3 rounded text-white ds-none"></div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <input type="hidden" name="action" value="createInventory">
                                <input type="hidden" name="product_id" value="<?= $product->id; ?>">
                            </div>

                            <div class="form-group col-md-4">
                                <label for="inputEmail4">Tamanho</label>
                                <input type="text" name="size" required class="form-control">
                            </div>

                            <div class="form-group col-md-4">
                                <label for="inputEmail4">Cor</label>
                                <input type="color" name="color" required class="form-control">
                            </div>

                            <div class="form-group col-md-4">
                                <label for="inputEmail4">Quantidade</label>
                                <input type="number" name="amount" required class="form-control">
                            </div>

                        </div>
                        <button type="submit" class="jsc-creat-inventory btn btn-primary"><i
                                    class="fas fa-keyboard"></i>
                            Cadastrar
                        </button>
                        <img class="csw-load ml-4 ds-none"
                             src="<?= theme("/assets/images/load.gif", CONF_VIEW_ADMIN); ?>"
                             alt="load">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--- MODAL -->
<?php endif; ?>

<?php if (!empty($item)): ?>
    <div class="modal fade " tabindex="-1" role="dialog" id="update-inventory">
        <div class="modal-dialog modal-xl">
            <div class="modal-content" style="border: none">
                <div class="modal-header bg-info">
                    <h5 class="modal-title" style="color: #fff;">
                        <i class="fas fa-keyboard"></i> Editar Estoque
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="<?= url("/admin/inventory/update"); ?>"
                          name="formUpdateInvetory"
                          class="ajax_off" method="post">
                        <div class="row">
                            <div class="col-md-12 ajax_response_modal bg-warning p-3 rounded text-white ds-none"></div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <input type="hidden" name="action" value="updateInventory">
                                <input type="hidden" name="product_id" value="<?= $item->product_id; ?>">
                                <input type="hidden" name="id" value="<?= $item->id; ?>">
                            </div>

                            <div class="form-group col-md-4">
                                <label for="inputEmail4">Tamanho</label>
                                <input type="text" name="size" required class="form-control"
                                       value="<?= $item->size; ?>">
                            </div>

                            <div class="form-group col-md-4">
                                <label for="inputEmail4">Cor</label>
                                <input type="color" name="color" required class="form-control"
                                       value="<?= $item->color; ?>">
                            </div>

                            <div class="form-group col-md-4">
                                <label for="inputEmail4">Quantidade</label>
                                <input type="number" name="amount" required class="form-control"
                                       value="<?= $item->amount; ?>">
                            </div>

                        </div>
                        <button type="submit" class="jsc-creat-inventory btn btn-success">
                            <i class="fas fa-keyboard"></i>
                            Atualizar
                        </button>
                        <img class="csw-load ml-4 ds-none"
                             src="<?= theme("/assets/images/load.gif", CONF_VIEW_ADMIN); ?>" alt="load">
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>