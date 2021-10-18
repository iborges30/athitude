<div class="col-2" id="<?= $p->id ?>">
    <div class="product">
        <div class="image-product">

            <div class="container-product-cover">
                <a title="<?= $p->name; ?>" href="<?= url("/produto/{$p->url}"); ?>"
                   data-product-id="<?= $p->id ?>"
                   class="jsc-product-item">
                    <img title="<?= $p->name; ?>" alt="<?= $p->name; ?>" src="<?= image($p->image, 400, 400); ?>"/>
                </a>
            </div>

            <div class="text-production">
                <p class="text-default roboto">
                    <a title="<?= $p->name; ?>"
                       data-product-id="<?= $p->id ?>"
                       href="<?= url("/produto/{$p->url}"); ?>"
                       class="jsc-product-item">
                        <?= $p->name; ?>
                    </a>
                </p>
            </div>
        </div>

        <p class="text-default roboto price">R$ <?= str_price($p->price); ?></p>
        <small class="text-default roboto ">
            ou em <?= $enterprise->installment; ?>x de <?= calculeInstallment($enterprise->installment, $p->price); ?>
        </small>

        <div class="details">
            <a title="<?= $p->name; ?>"
               data-product-id="<?= $p->id ?>"
               href="<?= url("/produto/{$p->url}"); ?>"
               class="text-dark roboto jsc-product-item">
                <i class="fas fa-shopping-bag"></i> VER DETALHES
            </a>
        </div>
    </div>
</div>