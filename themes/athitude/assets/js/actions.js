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

      /*  $.ajax({
            url: url,
            method: 'post',
            dataType: 'json',
            data: {id: id}
        });*/

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

    var sizeId = null;
    var size = null;

    //MARCA O TAMANHO ESCOLHIDO
    $(".ajax-product-modal").on("click", ".jsc-size-selected", function () {
        sizeId = $(this).data("size-id");
        size = $(this).data("size");
        $(".active-size").css("display", "none");
        $("#size-" + sizeId).css("display", "block");

    });

    //TRAZ AS CORES
    $(".ajax-product-modal").on("click", ".jsc-set-color", function () {
        var productId = $(".bt-add-buy").attr("data-product-id");
        var selectedSize = size;
        console.log(productId, selectedSize);
        var uri = BASE + '/modal/selected/colors';
        $.ajax({
            url: uri,
            method: "post",
            data: {productId: productId, selectedSize:selectedSize},
            dataType: "html",
            beforeSend:function (){
                $(".dialog-home-products").slideDown("fast");
            },
            success: function (response) {
                $(".ajax-colors").html(response);

            },
            complete:function (){
                $(".dialog-home-products").fadeOut();
            }
        });


    });


    //CORES
    var colorId = null;
    var color = null;

    $(".ajax-product-modal").on("click", ".jsc-color-selected", function () {
        colorId = $(this).data("color-id");
        color = $(this).data("color");
        color = color;

        $(".active-color").css("display", "none");
        $("#color-" + colorId).css("display", "block");
        $(".page-item-buy input[name='amount']").val(1);
    });


    //ADICIONA PRODUTO -- CONTINUAR AQUI
    $(".ajax-product-modal").on("click", ".item-buy-plus", function () {
        var productId = $(".bt-add-buy").attr("data-product-id");
         var amount = $(".page-item-buy input[name='amount']").val();
        amount = parseInt(amount) +1 ;
        console.log(amount);
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
            data: {amount: amount, productId: productId, size: size, color:color},
            success: function (response) {
                if (response.nostock) {
                    message("Ops.", "Quantidade máxima desse produto atingida");
                   return ;
                }
                if(response.amount > 1){
                    $(".page-item-buy input[name='amount']").val(response.amount);
                }

            }
        });
    });


    //ADICOINA PRODUTO A BAG
    $(".ajax-product-modal").on("click", ".jsc-add-bag", function () {
        var amount = $("input[name='amount']").val();
        var productId = $(this).data("product-id");

        var price = $(this).data("price");
        var uri = BASE + '/insert/product/session';

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
            method: 'post',
            dataType: 'json',
            data: {amount: amount, productId: productId, size: size, color:color, price: price},
            success: function (response) {
                $(".dialog-bag").show();
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

