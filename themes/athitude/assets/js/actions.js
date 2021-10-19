$(function () {

    //############## GET PROJECT
    BASE = $("link[rel='base']").attr("href");


    $(".jsc-product-item").click(function () {
        var url = BASE + '/single/modal';
        var productId = $(this).attr("data-product-id");


        $.ajax({
            url: url,
            dataType: 'html',
            method: 'post',
            data: {productId: productId},
            beforeSend: function () {
                $(".dialog-home-products").fadeIn("fast").addClass("ds-flex");
            },
            success: function (response) {
                $(".ajax-product-modal").empty().html(response);
                $(".dialog").animate({bottom: "0", height: ["easeOutBounce"], opacity: 1}, "slow", function () {
                    $(this).css({
                        'display': 'flex',
                        'overflow': 'scroll'

                    });
                });

            },
            complete: function () {
                $(".dialog-home-products").fadeOut("slow", function () {
                    $(this).removeClass("ds-flex");
                });
            }
        });

        return false;
    });

    //FECHA A MODAL DE PRODUTO
    $(".dialog").on("click", ".jsc-back", function () {
        var url = BASE + '/remove-session';
        var id = $(this).attr("data-product-id");

        $.ajax({
            url: url,
            method: 'post',
            dataType: 'json',
            data: {id: id}
        });

        $(".dialog").animate({bottom: "-999px", opacity: 0}, "slow", function () {
            $(".ajax-modal").empty();
        });

        return false;
    });


    //REMOVE PRODUTO
    $(".ajax-product-modal").on("click", ".item-buy-minus", function () {
        var newValue = $(".page-item-buy input[name='amount']");
        var amount = $(".page-item-buy input[name='amount']").val();
        var minus = parseInt(amount) - 1;
        if (minus == 0) {
            newValue = newValue.val(1);
        } else {
            newValue = newValue.val(minus);
        }
    });

    var size = null; //ESTA AQUI PARA SER USADO FORA ESTOU PEGANDO SÓ O ID
    //MARCA O TAMANHO ESCOLHIDO
    $(".ajax-product-modal").on("click", ".jsc-size-selected", function () {
        size = $(this).data("size-id");
        $(".active-size").css("display", "none");
        $("#size-" + size).css("display", "block");


    });

    //PRECISO REVER A COR POIS ELA DEVE SER RETORNADA VIA AJAX QUANDO FOR ESCOLHIDO O TAMANHO
    var color = null;
    $(".ajax-product-modal").on("click", ".jsc-color-selected", function () {
        color = $(this).data("color-id");
        $(".active-color").css("display", "none");
        $("#color-" + color).css("display", "block");
    });


    //ADICIONA PRODUTO -- CONTINUAR AQUI
    $(".ajax-product-modal").on("click", ".item-buy-plus", function () {
        var productId = $(".bt-add-buy").attr("data-product-id");
        var amount = $(".page-item-buy input[name='amount']").val();
        amount = parseInt(amount) + 1;
        var uri = BASE + '/single/plus';

        if (!size) {
            message("Ops", "Você deve escolher uma tamanho para para continuar.", "red");
            return;
        }

        if (!color) {
            message("Ops", "Você deve escolher uma cor para para continuar.", "red");
            return;
        }

        $.ajax({
            url: uri,
            method: "post",
            dataType: "json",
            data: {amount: amount, productId: productId, attributesId: size},
            success: function (response) {
                if (response.nostock) {
                    message("Ops.", "Quantidade máxima desse produto atingida");
                }

            }
        });
    });


    //ADICOINA PRODUTO A BAG
    $(".ajax-product-modal").on("click", ".jsc-add-bag", function () {
        var amount = $("input[name='amount']").val();
        var productId = $(this).data("product-id");
        var attributesId = size;
        var price = $(this).data("price");
        var uri = BASE + '/insert/product/session';

        if (!size) {
            message("Ops", " Você deve escolher uma tamanho para para continuar.", "red");
            return;
        }

        if (!color) {
            message("Ops", "Você deve escolher uma cor para para continuar.", "red");
            return;
        }

        $.ajax({
            url: uri,
            method: 'post',
            dataType: 'json',
            data: {amount: amount, productId: productId, attributesId: attributesId, price: price},
            success: function (response) {
                console.log(response);
            }

        });

        return false;
    });


    function message(title, message, type) {
        $.alert({
            title: title,
            content: message,
            titleClass: 'roboto',
            icon: 'icon-warning',
            animation: 'zoom',
            type: type,
            theme: 'modern',
        });
    }
});

