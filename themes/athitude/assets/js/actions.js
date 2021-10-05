$(function () {
    $(".jsc-product-item").click(function () {
        $(".dialog").animate({bottom: "0", height: ["easeOutBounce"], opacity: "toggle"}, "slow", function () {
            $(this).css({
                'display': 'flex',
                'overflow': 'scroll',
                'top':'0'
            });
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

