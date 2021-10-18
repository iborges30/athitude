$(function () {

    //############## GET PROJECT
    BASE = $("link[rel='base']").attr("href");



    $(".jsc-product-item").click(function () {
        var url = BASE+'/single/modal';
        var productId = $(this).attr("data-product-id");


       $.ajax({
            url: url,
            dataType: 'html',
            method: 'post',
           data:{productId:productId},
            beforeSend: function () {
                $(".dialog-home-products").fadeIn("fast").addClass("ds-flex");
            },
            success: function (response) {

               $(".ajax-product-modal").empty().html(response);
                $(".dialog").animate({bottom: "0", height: ["easeOutBounce"], opacity: 1}, "slow", function () {
                    $(this).css({
                        'display': 'flex',
                        'overflow': 'scroll',
                        'top':'0'
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

    $(".jsc-add-bag").click(function (){
        $(".dialog").slideUp("slow");
        return false;
    })


    $(".jsc-back").click(function () {
        $(".dialog").fadeOut("slow");
        return false;
    });
});

