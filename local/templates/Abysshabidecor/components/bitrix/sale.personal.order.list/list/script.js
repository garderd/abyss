$(document).ready(function () {
    $(".personal-order-list-item").click(function (e) {
        if (!$(this).hasClass("active")) {
            $(this).find('.personal-order-list-item-fool').slideDown(300).css('display', 'flex');
            $(this).addClass('active');
        }
    });

    $('.personal-order-list-item-fool-arrow').click(function () {
        $(this).closest('.personal-order-list-item-fool').slideUp(300);
        setTimeout(() => { 
            $(this).closest('.personal-order-list-item').removeClass('active'); },
            300
        );

    });
})
