<!--- MODAL  --->
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
                <form action="<?= url("/admin/category/products"); ?>" name="formCategoryProducts"
                      class="ajax_off" method="post">
                    <div class="row">
                        <div class="col-md-12 ajax_response_modal"></div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <input type="hidden" name="action" value="createCategory">
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
                    <button type="submit" class="jsc-send-income btn btn-primary"><i class="fas fa-keyboard"></i>
                       Cadastrar
                    </button>
                    <img class="csw-load ml-4 ds-none" src="<?= theme("/assets/images/load.gif", CONF_VIEW_ADMIN); ?>" alt="load">
                </form>
            </div>
        </div>
    </div>
</div>
<!--- MODAL -->