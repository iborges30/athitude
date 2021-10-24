<div class="container">
    <div class="modal">
        <div class="page-item">
            <div class="go-back">
                <a href="#" class="jsc-back poppins">
                    X
                </a>
            </div>

            <div class="page-item-title">
                <h1 class="poppins text-dark jsc-product-name"><?= $product->name; ?></h1>
            </div>
        </div>
        <div class="row">
            <div class="col-1">
                <div class="page-item-image">
                    <img title="<?= $product->name; ?>" alt="<?= $product->name; ?>"
                         src="<?= image($product->image, 1080, 1080); ?>"/>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-70">
                <div class="product-descripition-items">
                    <p class="roboto text-dark">Código: <span class="jsc-code-item"><?= $product->code; ?></span> </p>
                </div>
                <div class="product-descripition-items">
                    <p class="roboto text-dark">Categoria: <?= $category->category; ?> </p>
                </div>

                <div class="product-descripition-items">
                    <p class="roboto text-dark">Fabricante: <?= $brand->name; ?></p>
                </div>
            </div>

            <div class="col-30">
                <div class="product-price">
                    <p class="poppins text-dark">
                        R$ <?= str_price($product->price); ?>
                    </p>

                    <small class="text-default poppins">
                        ou em <?= $_SESSION["enterprise"]->installment; ?>x
                        de <?= calculeInstallment($_SESSION["enterprise"]->installment, $product->price); ?>
                    </small>
                </div>

            </div>
        </div>
        <div class="row">
            <div class="descritpion-product roboto text-dark">
                <?= $product->description; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-60">
                <div class="product-size product-details">
                    <h2 class="poppins text-dark">
                        Tamanho
                    </h2>
                    <ul class="ds-flex roboto">
                        <?php foreach ($inventory as $p): ?>
                            <li data-size-id="<?= $p->id; ?>"
                                data-size="<?= $p->size; ?>"
                                class="jsc-size-selected jsc-set-color">
                                <div class="check-active active-size" id="size-<?= $p->id; ?>">
                                    <i class="far fa-check-circle"></i>
                                </div>
                                <div class="size">
                                    <?= $p->size; ?>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <div class="col-40">
                <div class="product-color product-details">
                    <h2 class="poppins text-dark">
                        Cores
                    </h2>
                    <!--RECE AS CORES VIA AJAX -->
                    <ul class="ds-flex details-colors ajax-colors"></ul>
                    <!--RECE AS CORES VIA AJAX -->
                </div>
            </div>
        </div>

        <div class="page-item-buy">
            <div class="row">
                <div class="col-2">
                    <form action="">

                        <span class="item-buy-plus" id="">+</span>
                        <input type="tel" name="amount" value="1" readonly="">
                        <span class="item-buy-minus">-</span>
                    </form>
                </div>

                <div class="col-2">
                    <a href="#" class="bt-add-buy poppins jsc-add-bag"
                       data-price="<?= $product->price; ?>"
                       data-product-id="<?= $product->id; ?>">
                        <i class="fas fa-shopping-bag"></i>Adicionar
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="dialog-bag all" >
    <div class="modal-bag">
        <div class="modal-title-bag">
            <h2 class="poppins text-dark">MINHA SACOLA</h2>
        </div>
        <div class="modal-itens">
            <p class="roboto text-dark"> Você adicionou <b class="product-name-modal"> </b> a
                sua
                sacola de compras. O que
                deseja fazer agora?</p>
        </div>
        <div class="modal-actions">
            <a href="<?= url();?>" class="roboto continue" title="Continuar comprando">CONTINUAR COMPRANDO</a>
            <a href="<?= url("/pedidos/cart");?>" class="roboto close jsc-close">FECHAR COMPRA</a>
        </div>
    </div>
</div>