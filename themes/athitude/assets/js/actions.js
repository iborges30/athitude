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

    /***********************************
     * ***** MENU MOBILE ***************
     ***********************************/

    $('.open-menu label').click(function () {
        $('.jsc-nav').fadeToggle('fast');
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
            data: {productId: productId, selectedSize: selectedSize},
            dataType: "html",
            beforeSend: function () {
                $(".dialog-home-products").slideDown("fast");
            },
            success: function (response) {
                $(".ajax-colors").html(response);

            },
            complete: function () {
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
        amount = parseInt(amount) + 1;
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
            data: {amount: amount, productId: productId, size: size, color: color},
            success: function (response) {
                if (response.nostock) {
                    message("Ops.", "Quantidade máxima desse produto atingida");
                    return;
                }
                if (response.amount > 1) {
                    $(".page-item-buy input[name='amount']").val(response.amount);
                }

            }
        });
    });


    //ADICOINA PRODUTO A BAG
    $(".ajax-product-modal").on("click", ".jsc-add-bag", function () {
        var amount = $("input[name='amount']").val();
        var productId = $(this).data("product-id");
        var productName = $(".jsc-product-name").text();
        var code = $(".jsc-code-item").text();
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
            data: {
                productName: productName,
                code: code,
                amount: amount,
                productId: productId,
                size: size,
                color: color,
                price: price
            },
            success: function (response) {
                if (response.success) {
                    $(".product-name-modal").text(productName);
                    $(".dialog-bag").show("slow");
                }
            }

        });
        return false;
    });

    //REMOVE ITEM DO CARRINHO
    $(".jsc-remove-item-cart").click(function () {
        var productId = $(this).data("remove-item");
        var uri = BASE + '/remove/item/cart';
        var amount = $(".jsc-item-amount-cart").text();

        $.ajax({
            url: uri,
            method: "post",
            dataType: "json",
            data: {
                productId: productId,
                amount: amount
            },
            success: function (response) {
                if (response.clear) {
                    $(".jsc-subtotal").text(response.calculation);
                    $(".jsc-subtotal").attr("data-subtotal-cart", response.calculation);
                    $("#" + response.id).slideUp("fast");
                }
            }
        });

        return false;
    });


    //CALCULA O FRETE
    $(".js-zip-code").click(function () {
        var zipcode = $("input[name='zipcode']").val();
        if (!zipcode || zipcode === '') {
            message("Opsss", "Você precisa informar um CEP de destino.", "red.")
        } else {

            $.ajax({
                url: BASE + '/zipcode',
                method: 'post',
                data: {zipcode: zipcode},
                dataType: 'json',
                beforeSend: function () {
                    $(".load").show("fast");
                },
                success: function (response) {
                    if (response.calcule) {
                        $(".change").empty();
                        $.each(response.calcule, function (key, value) {
                            $(".change").append('<label>' + value.name + '<span class="ajax-valor">: R$ ' + value.price + ' - ' + value.deadline + ' dias </span>' + '<input class="ajax-type-send" type="radio" value="' + value.price + '" name="freteEscolhido">' + '</label>');
                        });
                        $(".change").append('<label for="">RETIRAR NA LOJA - R$ 0,00 ' + '<input type="radio" name="freteEscolhido" value="0" class="ajax-type-send"> </label>');
                        $(".change-frete").css("display", "flex").show("fast");
                    }

                },
                complete: function () {
                    $(".load").hide("fast");
                }
            });

        }
        return false;
    });

    //INSERE O VALOR NO TOTAL
    $("body").on("click", ".ajax-type-send", function () {
        var send = $(this).val();
        var subTotal = $(".jsc-subtotal").attr("data-subtotal-cart");
        subTotal = parseFloat(subTotal);
        send = parseFloat(send)
        var calculeTotal = send + subTotal;
        console.log(send, subTotal, calculeTotal);
        if (send === 0) {
            $(".subtotal span").text(subTotal);
        }
        $(".subtotal span").text(calculeTotal.toFixed(2));
        $(".finished-order-cart").fadeIn("fast", function () {
            var go = localStorage.setItem('send', 'yes');
        });

    });

    //COLOCA O LINK NO BOTÃO para poder continuar
    $(".jsc-close-orders").click(function () {
        var next = localStorage.getItem('send');
        if (next === 'yes') {
            window.location.href = BASE + '/cliente/checkout';
        }
        return false;
    });


    //############## GET CEP
    $('.wc_getCep').change(function () {
        var cep = $(this).val().replace('-', '').replace('.', '');
        if (cep.length === 8) {
            $.get("https://viacep.com.br/ws/" + cep + "/json", function (data) {
                if (!data.erro) {
                    $('.wc_bairro').val(data.bairro);
                    $('.wc_complemento').val(data.complemento);
                    $('.wc_localidade').val(data.localidade);
                    $('.wc_logradouro').val(data.logradouro);
                    $('.wc_uf').val(data.uf);
                }
            }, 'json');
        }
    });


    $("select[name='sendOrders']").change(function () {
        var typeSend = $(this).val();
        var uri = BASE + '/priceFrete';
        $.ajax({
            url: uri,
            data: {type: typeSend},
            dataType: 'json',
            method: 'post',
            success: function (response) {
                if (response) {
                    var totalProduct = $(".total-product").text();//.replace("R$", "").replace(".", "").replace(",", ".");
                    var rate = response.price;
                    var calculate = parseFloat(totalProduct) + parseFloat(rate);

                    $(".order-total-payment span").text(calculate.toFixed(2));
                    $("input[name='total_orders']").val(calculate.toFixed(2));

                    $(".required").attr("required");
                    $(".get-send-product").html(' <p><b>FORMA DE ENTREGA</b></p><p> <span>R$ ' + rate + ' - ' + response.type + ': ' + response.days + ' dias</span></p>');
                    $("input[name='delivery_rate']").val(rate);
                    $("input[name='deadline']").val(response.days);
                }
            }
        });

    });


    //BUSCA DADOS DO USUÁRIO CASO ELE EXISTA JÁ NO SISTEMA
    $(".jsc-document").change(function () {
        var dados = $(this).val().replaceAll(".", "").replace("-", "");
        var url = BASE + '/document';
        $.ajax({
            url: url,
            dataType: 'json',
            data: {document: dados},
            type: 'post',
            success: function (response) {
                if (response.client) {
                    $.each(response.client, function (key, value) {
                        $(".ajax-address").val(value.address);
                        $(".ajax-phone").val(value.phone);
                        $(".ajax-email").val(value.email);
                        $(".ajax-zipcode").val(value.zipcode);
                        $(".ajax-city").val(value.city);
                        $(".ajax-state").val(value.state);
                        $(".ajax-square").val(value.square);
                        $(".ajax-number").val(value.number);
                        $(".ajax-complement").val(value.complement);
                        $(".ajax-reference").val(value.reference);
                        $(".ajax-name-client").val(value.client);
                    });
                }
            }
        })
    });


    /*
    ********************************
    *******  PARTE DA ENTREGA  *****
    ********************************
    *
     */
    $("select[name='payment_method']").change(function () {
        var method = $(this).val();
        if (method === 'credit' || method === 'debit') {
            $(".payment-credit-card").show("fast");
            $("select[name='installments']").attr("required", "true");

        } else {
            $("select[name='installments']").removeAttr("required", "true");
            $(".payment-credit-card").slideUp("fast");
        }
    });


    //CADASTRA O PEDIDO
    $("form[name='formCompletedOrder']").submit(function () {
        var dados = $(this).serialize();
        var uri = BASE + '/orders';
        $.ajax({
            url: uri,
            dataType: 'json',
            data: dados,
            type: 'post',
            beforeSend: function () {
                $(".dialog-complete").css("display", "flex");
                $(".modal-load").fadeIn();
            },
            success: function (response) {
                if (response.message) {
                    $(".ajax_response").html(response.message);
                    $('html, body').animate({scrollTop: $('.jsc-menssage-response').offset().top}, 'slow');
                }
                if (response.completed) {
                    message("Tudo certo.", "Seu pedido foi cadastrado com sucesso. Você será redirecionado para o WhatsApp da Loja para finalizar o pagamento.", "green");

                    window.setTimeout(function () {
                        location.href = "https://api.whatsapp.com/send?phone=55" + response.phone + "&text=" + messageWhatsApp(response.name, response.document, response.numberOrder, response.method);
                    }, 3000);

                }

            }, complete: function () {
                $(".dialog-complete").fadeOut(function () {
                    $(".modal-load").fadeOut();
                });
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


        /*******************************
        *******  PARTE DA ENTREGA  *****
        ********************************/

    function messageWhatsApp(name, document, numberOrder, method) {
        var message = "Olá, " + name + "  ," +
            " CPF: " + document + "," +
            " Pedido Nº:" + numberOrder +
            " Meio de pagamento escolhido: " + method +
            "Forma de Entrega: Retirar na loja" +
            " Seu pedido foi cadastrado com sucesso em nosso sistema." +
            " Use o link abaixo para acessar os detalhes da sua compra. " +
            "A Athitude Moda Fitness agradece pela preferência. " +
            "Você pode acessar os detalhes do seu pedido clicando aqui: " + BASE + '/my-historic/' + numberOrder;

        return message;
    }

    /*******************************
     ********************************
     ******* MASCÁRAS  **************
     ********************************
     ********************************/

    $(".mask-zipcode").mask("99999-999");
    $(".mask-document").mask("999.999.999-99");
    $(".mask-phone").mask("(99) 9 9999-9999");
});

