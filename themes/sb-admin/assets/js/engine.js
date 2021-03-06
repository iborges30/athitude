// JQUERY INIT

$(function () {

    var ajaxResponseBaseTime = 3;
    var ajaxResponseRequestError = "<div class='message error icon-warning'>Desculpe mas não foi possível processar sua requisição...</div>";

    // MOBILE MENU

    $(".mobile_menu").click(function (e) {
        e.preventDefault();

        var menu = $(".dash_sidebar");
        menu.animate({right: 0}, 200, function (e) {
            $("body").css("overflow", "hidden");
        });

        menu.one("mouseleave", function () {
            $(this).animate({right: '-260'}, 200, function (e) {
                $("body").css("overflow", "auto");
            });
        });
    });

    //NOTIFICATION CENTER

    function notificationsCount() {
        var center = $(".notification_center_notify");
        $.post(center.data("count"), function (response) {
            if (response.count) {
                center.html(response.count);
            } else {
                center.html("0");
            }
        }, "json");
    }

    function notificationHtml(link, image, notify, date) {
        return '<span data-notificationlink="' + link + '" class="dropdown-item d-flex align-items-center" style="cursor: pointer">\n' +
            '       <div class="mr-3">\n' +
            '           <img class="img-profile rounded-circle" src="' + image + '" style="width: 60px">\n' +
            '       </div>\n' +
            '       <div>\n' +
            '           <div class="small text-gray-500">' + date + '</div>\n' +
            '           <span class="font-weight-bold">' + notify + '</span>\n' +
            '       </div>\n' +
            '   </span>'
    }

    notificationsCount();

    setInterval(function () {
        notificationsCount();
    }, 1000 * 50);

    $(".notification_center").click(function (e) {
        e.preventDefault();

        var notify = $(this).data("notify");
        var center = $(".notification_center_open");
        var centerList = $(".notification_center_list");

        $.post(notify, function (response) {
            if (response.message) {
                ajaxMessage(response.message, ajaxResponseBaseTime);
            }

            var centerHtml = "";
            if (response.notifications) {
                $.each(response.notifications, function (e, notify) {
                    centerHtml += notificationHtml(notify.link, notify.image, notify.title, notify.created_at);
                });

                center.html(centerHtml);
                centerList.css("display", "block");
                center.dropdown("show");
            }
        }, "json");

        center.one("mouseleave", function () {
            centerList.css("display", "none");
        });

        notificationsCount();
    });

    $(".notification_center_open").on("click", "[data-notificationlink]", function () {
        window.location.href = $(this).data("notificationlink");
    });

    //DATA SET

    $("[data-post]").click(function (e) {
        e.preventDefault();

        var clicked = $(this);
        var data = clicked.data();
        var load = $(".ajax_load");

        if (data.confirm) {
            var deleteConfirm = confirm(data.confirm);
            if (!deleteConfirm) {
                return;
            }
        }

        $.ajax({
            url: data.post,
            type: "POST",
            data: data,
            dataType: "json",
            beforeSend: function () {
                load.fadeIn(200).css("display", "flex");
            },
            success: function (response) {
                //redirect
                if (response.redirect) {
                    window.location.href = response.redirect;
                } else {
                    load.fadeOut(200);
                }

                //reload
                if (response.reload) {
                    window.location.reload();
                } else {
                    load.fadeOut(200);
                }

                //message
                if (response.message) {
                    ajaxMessage(response.message, ajaxResponseBaseTime);
                }
            },
            error: function () {
                ajaxMessage(ajaxResponseRequestError, 5);
                load.fadeOut();
            }
        });
    });

    //FORMS

    $("form:not('.ajax_off')").submit(function (e) {
        e.preventDefault();

        var form = $(this);
        var load = $(".ajax_load");

        if (typeof tinyMCE !== 'undefined') {
            tinyMCE.triggerSave();
        }

        form.ajaxSubmit({
            url: form.attr("action"),
            type: "POST",
            dataType: "json",
            beforeSend: function () {
                load.fadeIn(200).css("display", "flex");
            },
            uploadProgress: function (event, position, total, completed) {
                var loaded = completed;
                var load_title = $(".ajax_load_box_title");
                load_title.text("Enviando (" + loaded + "%)");

                if (completed >= 100) {
                    load_title.text("Aguarde, carregando...");
                }
            },
            success: function (response) {
                //redirect
                if (response.redirect) {
                    window.location.href = response.redirect;
                } else {
                    form.find("input[type='file']").val(null);
                    load.fadeOut(200);
                }

                //reload
                if (response.reload) {
                    window.location.reload();
                } else {
                    load.fadeOut(200);
                }

                //message
                if (response.message) {
                    ajaxMessage(response.message, ajaxResponseBaseTime);
                }

                //image by fsphp mce upload
                if (response.mce_image) {
                    $('.mce_upload').fadeOut(200);
                    tinyMCE.activeEditor.insertContent(response.mce_image);
                }
            },
            complete: function () {
                if (form.data("reset") === true) {
                    form.trigger("reset");
                }
            },
            error: function () {
                ajaxMessage(ajaxResponseRequestError, 5);
                load.fadeOut();
            }
        });
    });

    // AJAX RESPONSE

    function ajaxMessage(message, time) {
        var ajaxMessage = $(message);

        ajaxMessage.append("<div class='message_time'></div>");
        ajaxMessage.find(".message_time").animate({"width": "100%"}, time * 1000, function () {
            $(this).parents(".message").fadeOut(200);
        });

        $(".ajax_response").append(ajaxMessage);
        ajaxMessage.effect("bounce");
    }

    // AJAX RESPONSE MONITOR

    $(".ajax_response .message").each(function (e, m) {
        ajaxMessage(m, ajaxResponseBaseTime += 1);
    });

    // AJAX MESSAGE CLOSE ON CLICK

    $(".ajax_response").on("click", ".message", function (e) {
        $(this).effect("bounce").fadeOut(1);
    });


    //############# POSTS

    //CAPA VIEW
    $('.wc_loadimage').change(function () {
        var input = $(this);
        var target = $('.' + input.attr('name'));
        var fileDefault = target.attr('default');

        if (!input.val()) {
            target.fadeOut('fast', function () {
                $(this).attr('src', fileDefault).fadeIn('slow');
            });
            return false;
        }

        if (this.files && (this.files[0].type.match("image/jpeg") || this.files[0].type.match("image/png"))) {
            var reader = new FileReader();
            reader.onload = function (e) {
                target.fadeOut('fast', function () {
                    $(this).attr('src', e.target.result).width('100%').fadeIn('fast');
                });
            };
            reader.readAsDataURL(this.files[0]);
        } else {
            Trigger('<div class="trigger trigger_alert trigger_ajax"><b class="icon-warning">ERRO AO SELECIONAR:</b> O arquivo <b>' + this.files[0].name + '</b> não é válido! <b>Selecione uma imagem JPG ou PNG!</b></div>');
            target.fadeOut('fast', function () {
                $(this).attr('src', fileDefault).fadeIn('slow');
            });
            input.val('');
            return false;
        }
    });

    //ABRE A MODAL PARA GERAR NOVO FABRICANTE
    $(".jsc-brand").change(function () {
        var brand = $(this).val();
        if (brand === 'new') {
            $('#new-brand').modal("show");
        }
    });


    $("form[name='formBrandproducts']").submit(function () {
        var dados = $(this).serialize();
        var url = $(this).attr("action");

        $.ajax({
            url: url,
            method: 'post',
            dataType: 'json',
            data: dados,
            beforeSend: function () {
                $(".csw-load").fadeIn("fast");
            },
            success: function (response) {
                if (response.message == 'error') {
                    alert("Verifique o nome do fabricante. É possívelmente ela já existe no sistema.");
                } else {
                    $("#new-brand").modal("hide");
                    $(".jsc-brand").append("<option selected value='" + response.value + "'>" + response.name + "</option>");
                }
            },
            complete: function () {
                $(".csw-load").fadeOut("fast");
            }
        });
        return false;
    });


    //ABRE A MODAL PARA GERAR NOVA CATEGORIA
    $(".jsc-category").change(function () {
        var category = $(this).val();
        if (category === 'category') {
            $('#new-category').modal("show");
        }
    });


    //GERA A NOVA CATEGORIA
    $("form[name='formCategoryProducts']").submit(function () {
        var dados = $(this).serialize();
        var url = $(this).attr("action");

        $.ajax({
            url: url,
            method: 'post',
            dataType: 'json',
            data: dados,
            beforeSend: function () {
                $(".csw-load").fadeIn("fast");
            },
            success: function (response) {
                if (response.message == 'error') {
                    alert("Verifique o nome da categoria informada, possívelmente ela já existe no sistema.");
                } else {
                    $("#new-category").modal("hide");
                    $(".jsc-category").append("<option selected value='" + response.value + "'>" + response.name + "</option>");
                }
            },
            complete: function () {
                $(".csw-load").fadeOut("fast");
            }
        });

        return false;
    });

    //ABRE A MODAL DO ESTOQUE
    $(".jsc-inventory-open-modal").click(function () {
        $("#new-inventory").modal("show");
        return false;
    });

    //CADASTRA O ESTOQUE
    $("form[name='formInventory']").submit(function () {
        var dados = $(this).serialize();
        var url = $(this).attr("action");
        $.ajax({
            url: url,
            method: 'post',
            dataType: 'json',
            data: dados,
            beforeSend: function () {
                $(".csw-load").fadeIn("fast");
            },
            success: function (response) {
                if (response.message) {
                    $(".ajax_response_modal").text("").fadeIn("fast").text(response.message);
                }

                $(".jsc-table").append('<tr id="' + response.id + '"> <th scope="row">' + response.id + '</th> ' +
                    '    <td>' + response.size + '</td>' +
                    '    <td class="text-white">' +
                    '        <span class="btn btn-circle shadow" style="background:' + response.color + '"></span>' +
                    '    </td>' +
                    '    <td>' + response.size + '</td>' +
                    '    <td>' +
                    '        <a href="' + response.url.replace("delete", "edit") + '" data-inventory-edit="' + response.id + '" class="btn btn-primary jsc-inventory-edit btn-circle btn-sm">' +
                    '            <i class="fas fa-edit"></i>' +
                    '        </a>' +
                    '        <a data-delete-id="' + response.id + '" href="' + response.url + '" class="jsc-delete-inventory btn btn-danger btn-circle btn-sm">' +
                    '            <i class="fas fa-trash"></i>' +
                    '        </a>' +
                    '    </td>' +
                    '</tr>');
                $("form[name='formInventory']").resetForm();
            }, complete: function () {
                $(".csw-load").fadeOut("fast");
            }

        });
        return false;
    });


    //DELETA INVENTÁRIO
    $("body").on("click", ".jsc-delete-inventory", function () {
        var deleteId = $(this).data("delete-id");
        var url = $(this).attr("href");
        $.ajax({
            url: url,
            method: 'post',
            data: {deleteId: deleteId},
            dataType: 'json',
            success: function (response) {
                if (response.detele) {
                    $("tr#" + response.id).fadeOut("fast");
                }
            }
        });
        return false;
    });

    //ABRE A MODAL DE EDIÇÃO
    $("body").on("click", ".jsc-inventory-edit", function () {
        var inventoryId = $(this).data("inventory-edit");
        var url = $(this).attr("href");
        $.ajax({
            url: url,
            method: 'post',
            data: {inventoryId: inventoryId},
            dataType: 'html',
            success: function (response) {
                $(".ajax-modal-edit-inventory").html(response);
                $("#update-inventory").modal("show");
            }
        });
        return false;
    });

    //ATUALIZA O INVENTÁRIO
    $(".container-fluid").on("submit", 'form[name="formUpdateInvetory"]', function () {
        var dados = $(this).serialize();
        var url = $(this).attr("action");
        $.ajax({
            url: url,
            dataType: 'json',
            data: dados,
            method: 'post',
            beforeSend: function () {
                $(".csw-load").fadeIn("fast");
            }, success: function (response) {
                $("#update-inventory").modal("hide");
                location.reload();
            }, complete: function () {
                $(".csw-load").fadeOut("fast");
            }
        });
        return false;
    });


    // PARTE DA GALERIA
    $('html').on('change', 'form[name="formGallery"]', function (e) {
        e.preventDefault();
        e.stopPropagation();
        var form = $(this);
        var BASE = 'https://localhost/athitude';
        var url = $(this).attr("action");

        console.log(url);

        form.ajaxSubmit({
            url: url,
            dataType: 'json',
            success: function (response) {
                $.each(response.gallery, function (key, values) {

                    $(".ajax-gallery").append('  ' +
                        ' <div class="mt-5 mb-5 m-lg-5" id="g-' + values.id + '">' +
                        '  <a href="../gallery/delete/' + values.id + '" data-id=" ' + values.id + ' " data-image="' + values.uri + '" class="jsc-delete-image-gallery">' +
                        '  <figure class="figure">' +
                        '<img width="120" height="120" src="' + BASE + '/storage/' + values.uri + '">' +
                        '    </figure>' +
                        '    </a>' +
                        '   </div>');

                });
            }

        })
    });

    //DELETE DA GALERIA
    $("body").on("click", ".jsc-delete-image-gallery", function () {
        var id = $(this).data("id");
        var uri = $(this).attr("href");
        var image = $(this).data("image");
        var r = confirm("Você realmente deseja deletar essa imagem?");
        if (r == true) {
            $.ajax({
                url: uri,
                method: "Post",
                dataType: 'json',
                data: {id: id, image: image},
                success: function (response) {
                    $("#g-" + response.image).slideUp("fast");

                }
            });
        }
        return false;
    });

    // MAKS
    $(".mask-date").mask('00/00/0000');
    $(".mask-datetime").mask('00/00/0000 00:00');
    $(".mask-month").mask('00/0000', {reverse: true});
    $(".mask-doc").mask('000.000.000-00', {reverse: true});
    $(".mask-card").mask('0000  0000  0000  0000', {reverse: true});
    $(".mask-money").mask('000.000.000.000.000,00', {reverse: true, placeholder: "0,00"});
});

// TINYMCE INIT

tinyMCE.init({
    selector: "textarea.mce",
    language: 'pt_BR',
    menubar: false,
    theme: "modern",
    height: 132,
    skin: 'light',
    entity_encoding: "raw",
    theme_advanced_resizing: true,
    plugins: [
        "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
        "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
        "save table contextmenu directionality emoticons template paste textcolor media"
    ],
    toolbar: "styleselect | pastetext | removeformat |  bold | italic | underline | strikethrough | bullist | numlist | alignleft | aligncenter | alignright |  link | unlink | fsphpimage | code | fullscreen",
    style_formats: [
        {title: 'Normal', block: 'p'},
        {title: 'Titulo 3', block: 'h3'},
        {title: 'Titulo 4', block: 'h4'},
        {title: 'Titulo 5', block: 'h5'},
        {title: 'Código', block: 'pre', classes: 'brush: php;'}
    ],
    link_class_list: [
        {title: 'None', value: ''},
        {title: 'Blue CTA', value: 'btn btn_cta_blue'},
        {title: 'Green CTA', value: 'btn btn_cta_green'},
        {title: 'Yellow CTA', value: 'btn btn_cta_yellow'},
        {title: 'Red CTA', value: 'btn btn_cta_red'}
    ],
    setup: function (editor) {
        editor.addButton('fsphpimage', {
            title: 'Enviar Imagem',
            icon: 'image',
            onclick: function () {
                $('.mce_upload').fadeIn(200, function (e) {
                    $("body").click(function (e) {
                        if ($(e.target).attr("class") === "mce_upload") {
                            $('.mce_upload').fadeOut(200);
                        }
                    });
                }).css("display", "flex");
            }
        });
    },
    link_title: false,
    target_list: false,
    theme_advanced_blockformats: "h1,h2,h3,h4,h5,p,pre",
    media_dimensions: false,
    media_poster: false,
    media_alt_source: false,
    media_embed: false,
    extended_valid_elements: "a[href|target=_blank|rel|class]",
    imagemanager_insert_template: '<img src="{$url}" title="{$title}" alt="{$title}" />',
    image_dimensions: false,
    relative_urls: false,
    remove_script_host: false,
    paste_as_text: true
});