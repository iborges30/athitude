<div class="container">
    <div class="modal">
        <div class="page-item">
            <div class="go-back">
                <a href="#" class="jsc-back poppins" data-product-id="161">
                    X
                </a>
            </div>

            <div class="page-item-title">
                <h1 class="poppins text-dark">Coleção blusas de algodão</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-1">
                <div class="page-item-image">
                    <img name="Blusa de malha" alt="Blusa de malha"
                         src="<?= theme("/assets/images/produto.jpg", CONF_VIEW_THEME); ?>">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-70">
                <div class="product-descripition-items">
                    <p class="roboto text-dark">Código: #RF456 </p>
                </div>
                <div class="product-descripition-items">
                    <p class="roboto text-dark">Categoria: Blusas </p>
                </div>

                <div class="product-descripition-items">
                    <p class="roboto text-dark">Fabricante: Atitude Fitness</p>
                </div>
            </div>

            <div class="col-30">
                <div class="product-price">

                    <p class="poppins text-dark">
                        R$ 49,90
                    </p>

                    <small class="text-default poppins">
                        ou em 3x de 20,00
                    </small>
                </div>

            </div>
        </div>
        <div class="row">
            <div class="descritpion-product roboto text-dark">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam rutrum odio id eros congue
                vulputate. Proin sem ligula, commodo eu malesuada eu, porttitor in nulla. Quisque accumsan imperdiet
                felis, vel venenatis erat laoreet porta. Class aptent taciti sociosqu ad litora
            </div>
        </div>
        <div class="row">
            <div class="col-60">
                <div class="product-size product-details">
                    <h2 class="poppins text-dark">
                        Tamanho
                    </h2>
                    <ul class="ds-flex roboto">
                        <li>G</li>
                        <li>P</li>
                        <li>GG</li>
                    </ul>
                </div>
            </div>
            <div class="col-40">
                <div class="product-color product-details">
                    <h2 class="poppins text-dark">
                        Cores
                    </h2>

                    <ul class="ds-flex details-colors">
                        <?php
                        for ($i = 0; $i < 2; $i++):
                            ?>
                            <li style="background: #FE6E53"></li>
                            <li style="background: #0c0c0c"></li>
                            <li style="background: #02C588"></li>
                        <?php
                        endfor;
                        ?>
                    </ul>

                </div>
            </div>
        </div>

        <div class="page-item-buy">
            <div class="row">
                <div class="col-2">
                    <form action="">
                        <span class="item-buy-plus">+</span>
                        <input type="tel" name="amount" value="1" readonly="">
                        <span class="item-buy-minus">-</span>
                    </form>
                </div>

                <div class="col-2">
                    <a href="#" class="bt-add-buy poppins jsc-add-bag">
                        <i class="fas fa-shopping-bag"></i>Adicionar
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>