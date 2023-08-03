
$(document).ready(function () {



    /******************** Форма поиска ********************/

    $('.form-button').click(function (e) {
        $('.search-form').css("display", "flex");
        $(this).css("opacity", "0");
        $('.search-form__text').focus();
    });
    $('.search-form__text').focusout(function () {
        if ($('.search-form__text').val() == '') {
            $('.form-button').css("opacity", "1");
            $('.search-form').css("display", "none");
        }
    });


    /******************* /Форма поиска ********************/

    $('.basket-item-block-properties.bakset-var1__items__item__td').each(function (i) {
        if ($(this).html().trim() === '') {
            $(this).css('display', 'none');
        }
    });


    /******************* Слайдер на главной ********************/
    const swiper = new Swiper('.main-slider', {
        // Optional parameters
        direction: 'horizontal',
        loop: true,

        // If we need pagination
        pagination: {
            el: '.pagination',
            type: 'fraction',
            clickable: true,
        },
    });
    for (var i = 1; i < swiper.slides.length - 1; i++) {
        if (i === 1) {
            // add active class if it is the first bullet
            $('#bullets').append('<span slide-number="' + i + '" class="swiper-pagination-bullet' + ' ' + 'swiper-pagination-bullet-active' + ' ' + 'slide' + i + '"></span>');
        } else {
            $('#bullets').append('<span slide-number="' + i + '" class="swiper-pagination-bullet' + ' ' + 'slide' + i + '"></span>');
        }
    }

    // get all bullet elements
    var bullets = $('.swiper-pagination-bullet');

    swiper.on('slideChange', function () {
        // Get current slide from fraction pagination number
        var slide = "slide" + ($('.swiper-pagination-current').html());
        // Remove active class from all bullets
        bullets.removeClass("swiper-pagination-bullet-active");
        // Check each bullet element if it has slideNumber class
        $.each(bullets, function (index, value) {
            if ($(this).hasClass(slide)) {
                $(this).addClass("swiper-pagination-bullet-active");
                return false;
            }
        });
    });

    $(".swiper-pagination-bullet").on("click", function () {
        swiper.slideTo($(this).attr('slide-number'));
    })


    /******************* /Слайдер на главной ********************/

    /******************* Видео в "О нас" ********************/
    $('.video__item.circle').click(function () {
        $('video').trigger('play').attr("controls", "controls").css("opacity", "1");
        $('.video__content').hide(800);

    });

    /******************* /Видео в "О нас" ********************/


    /******************* Слайдер с коллекциями ********************/
    const swiper1 = new Swiper('.catalog-collection-slider', {
        // Optional parameters
        direction: 'horizontal',
        loop: false,
        pagination: {
            el: ".catalog-collection-slider-pagination",
        },
        breakpoints: {
            320: {
                slidesPerView: 1.75,
                spaceBetween: 30,
            },
            768: {
                slidesPerView: 2.6,
                spaceBetween: 20,

            },
            992: {
                slidesPerView: 4,
                spaceBetween: 0,
            },
        },
    });


    $(".catalog-collection-slider .button-prev").on("click", function () {
        swiper1.slidePrev();
    });
    $(".catalog-collection-slider .button-next").on("click", function () {
        swiper1.slideNext();
    })
    /******************* /Слайдер с коллекциями ********************/

    /******************* табы в оплате ********************/

    let tab_array = [];
    let hash0 = window.location.hash;
    let new_hash0 = hash0.substring(1, hash0.length);
    $('.payment-tabs__header-item').each(function (i) {
        tab_array.push($(this).attr('data-tab'));
    });
    if (window.location.hash == '') {
        $('.payment-tabs__tab').hide();
        $('.payment-tabs__tab').first().show();
        $('.payment-tabs__header-item').first().addClass('active');
        $('.fake-tab__sub-link').first().addClass('active');
    }
    else {
        if ($.inArray(new_hash0, tab_array) !== -1) {
            $('.payment-tabs__tab').hide();
            $('.fake-tab__sub-link[data-tab="' + new_hash0 + '"]').addClass('active');
            $('.payment-tabs__header-item[data-tab="' + new_hash0 + '"]').addClass('active');
            $('.payment-tabs__tab[data-tab="' + new_hash0 + '"]').fadeIn(300);
        }
        else {
            $('.payment-tabs__tab').hide();
            $('.payment-tabs__tab').first().fadeIn(300);
            $('.payment-tabs__header-item').first().addClass('active');
            $('.fake-tab__sub-link').first().addClass('active');
        }
    }

    $('.tab-change').click(function () {
        let hash = window.location.hash;
        let new_hash = hash.substring(1, hash.length);
        let tab = $(this).attr('data-tab');

        if (!$(this).hasClass('active')) {
            $(this).addClass('active');
            $('.payment-tabs__tab').hide();
            $('.payment-tabs__tab[data-tab="' + tab + '"]').fadeIn(300);
            $('.tab-change').removeClass('active');
            $('.tab-change[data-tab="' + tab + '"]').addClass('active');
        }
    });



    /******************* /табы в оплате ********************/


    const sectionSlider = new Swiper('.catalog-list-slider', {
        // Optional parameters
        slidesPerView: 5,
        direction: 'horizontal',
        watchOverflow: true,
        loop: false,
        pagination: {
            type: "bullets",
            el: ".catalog-list-slider-pagination",
        },
        breakpoints: {
            320: {
                slidesPerView: 1.75,
                spaceBetween: 30,
            },
            768: {
                slidesPerView: 2.6,
                spaceBetween: 20,

            },
            992: {
                slidesPerView: 5,
                spaceBetween: 30,
            },
        },
    });




    /******************* Слайдер из разделов ********************/
    const swiper2 = new Swiper('.section-slider', {
        // Optional parameters
        slidesPerView: 1,
        spaceBetween: 40,
        direction: 'horizontal',
        loop: true,
    });

    $(".section-slider .button-prev").on("click", function () {
        swiper2.slidePrev();
    });
    $(".section-slider .button-next").on("click", function () {
        swiper2.slideNext();
    })

    /******************* /Слайдер из разделов ********************/

    $('.catalog-section__mobile-filter-button').click(function () {
        $('.catalog-section__filter.hide-mobile').toggleClass('active');
        $('.catalog-section__filter-button-wrapper').toggleClass('active');
    });


    /******************* Фильтр********************/
    $('.catalog-section__params').hide();
    $('.catalog-section__filter-button').click(function () {

        if (!$(this).hasClass('active')) {
            $('.catalog-section__params').hide();
            $('.catalog-section__filter-button').removeClass('active');
            $(this).addClass('active').next().addClass('active').slideDown(300);

        }
        else {
            $(this).removeClass('active');
            $('.catalog-section__params').slideUp(100);
        }
    });



    if ($('.radio-custom:checked').length)
        $('.section-filter__p_change-name.section-filter__p-popular').text($('.radio-custom:checked').next().text());

    $('.radio-custom').click(function () {

    });

    if ($('.radio-custom-available:checked').length)
        $('.section-filter__p_change-name.section-filter__p-available').text($('.radio-custom-available:checked').next().text());

    $('.radio-custom-available').click(function () {
        $('.section-filter__p_change-name.section-filter__p-available').text($(this).next().text());
    });

    $('.catalog-section__params .radio').click(function () {
        $(this).find('input[name="available"]').prop('checked', true);
        $('.section-filter__p_change-name.section-filter__p-available').text($('.radio-custom-available:checked').next().text());
    });

    $('.catalog-section__params .radio').click(function () {
        $(this).find('input[name="sort_field"]').prop('checked', true);
        $('.section-filter__p_change-name.section-filter__p-popular').text($('.radio-custom:checked').next().text());
    });

    /******************* /Фильтр ********************/


    $('.modal-window-wrapper').hide();


    $('.icons__person').click(function () {
        $('.modal-window-wrapper_login').fadeIn(1000).css("display", "flex");
        $('.modal-window-wrapper_login :first-child').animate({ "top": "0" }, 800);
        $('body').css('overflow', 'hidden');
    });
    $('.modal-window__close').click(function () {
        $('.modal-window-wrapper').hide();
        $('.modal-window-wrapper > :first-child').css({ "top": "-700px" });
        $('body').css('overflow', 'auto');
    });

    $('.form__link_registation').click(function () {
        $('.modal-window-wrapper_login').hide();
        $('.modal-window-wrapper_register').fadeIn(1000).css("display", "flex");
        $('.modal-window-wrapper_register > :first-child').animate({ "top": "0" }, 800);

    });

    $('.form__link_forget').click(function () {
        $('.modal-window-wrapper_login').hide();
        $('.modal-window-wrapper_forgot').fadeIn(1000).css("display", "flex");
        $('.modal-window-wrapper_forgot > :first-child').animate({ "top": "0" }, 800);
    });






    /******************* Записываем в логин значение mail ********************/

    $('#email-reg').focusout(function () {
        $val = $(this).val();
        $('#login-reg').val($val);
    });

    /******************* /Записываем в логин значение mail ********************/

    /******************* переключение type="password" на text ********************/

    $('.input-password__eye').click(function () {
        console.log($(this).prev().attr('type'));
        if ($(this).prev().attr('type') == 'password') {
            $(this).prev().attr('type', 'text');
            $(this).addClass('input-password__eye_open');
        }
        else {
            $(this).prev().attr('type', 'password');
            $(this).removeClass('input-password__eye_open');
        }
    });
    /******************* /переключение type="password" на text ********************/


    /******************** ajax избранное ********************/

    $(".catalog-section__button-favorite").click(function () {
        id = $(this).attr('id-el');
        var param = 'id=' + $(this).attr('id-el');
        $.ajax({
            type: "get",
            url: "/local/templates/Abysshabidecor/ajax/favorites.php",
            dataType: "html",
            data: param,
            success: function (response) {

                console.log(response);
                var result = $.parseJSON(response);
                if (result == 1) { // Если всё чётко, то выполняем действия, которые показывают, что данные отправлены
                    $('.catalog-section__button-favorite[id-el="' + id + '"]').addClass('catalog-section__button-favorite_active');
                }
                if (result == 2) {
                    $('.catalog-section__button-favorite[id-el="' + id + '"]').removeClass('catalog-section__button-favorite_active');
                }
            },
            error: function (jqXHR, textStatus, errorThrown) { // Ошибка
                console.log('Error: ' + errorThrown);

            }

        });
    });

    /******************** /ajax избранное ********************/



    /******************** Галерея в деталке ********************/
    var galleryThumbs = new Swiper(".gallery-thumbs", {
        breakpoints: {
            320: {
                pagination: {
                    el: ".element-gallery-pagination",
                    type: 'bullets',
                },
                direction: 'horizontal',
                slidesPerView: 1.2,
            },
            576: {
                slidesPerView: 5,
                direction: 'vertical',
            }
        }
    });
    $('.gallery-thumbs .swiper-slide').first().addClass('active');


    count_slides = $('.element-gallery-pagination .swiper-pagination-bullet').length;
    $('.element-gallery-pagination .swiper-pagination-bullet').css("width", "calc(100% / " + (count_slides + 2) + ")")

    $('.gallery-thumbs .swiper-slide').click(function (e) {
        if (!$(this).hasClass('active')) {
            e.preventDefault;
            let number_slide = $(this).children('a').attr('data-number');
            $('.gallery-container .gallery-main a').stop(true, false);
            let img_scr = $(this).children('a').attr('href');
            $('.gallery-thumbs .swiper-slide').removeClass('active');
            $(this).addClass('active');

            $('.gallery-container .gallery-main a').animate({ 'opacity': 0 }, 300);

            setTimeout(() => {
                $('.gallery-container .gallery-main a img').removeAttr('src');
                $('.gallery-container .gallery-main a').attr('href', img_scr);
                $('.gallery-container .gallery-main a').attr('data-number', number_slide);
                $('.gallery-container .gallery-main a img').attr('src', img_scr);
                $('.gallery-container .gallery-main a').animate({ 'opacity': 1 }, 600);
            }, 300);

        }
        return false;
    });

    $('a[data-fancybox=detail-tovar]').click(function () {
        let number = $(this).attr('data-number');
        let this_element = $(this);
        $('a[data-fancybox=detail-tovar]').each(function () {
            if ($(this).not($(this_element)).attr('data-number') == number) {
                $(this).attr('data-fancybox', '');
            }
        });
    });

    Fancybox.bind("[data-fancybox]", {
        on: {
            closing: (fancybox, slide) => {
                $('[data-fancybox]').attr("data-fancybox", "detail-tovar");
            }
        }
    });

    /******************** /Галерея в деталке ********************/


    $('.dropdown-block__header').click(function () {
        if ($(this).next('.dropdown-block__content').css('display') == 'none') {
            $(this).next('.dropdown-block__content').slideDown();
            $(this).children('.dropdown-block__arrow').hide(300);
        }
        else {
            $(this).children('.dropdown-block__arrow').show(300);
            $(this).next('.dropdown-block__content').slideUp();

        }
    });

    /******************* Слайдер с товарами из такой же коллекции ********************/
    const swiper3 = new Swiper('.element-slider-collection', {
        // Optional parameters
        slidesPerView: 4,
        spaceBetween: 10,
        direction: 'horizontal',
        loop: true,
        breakpoints: {
            320: {
                slidesPerView: 2.3,
                spaceBetween: 30,
            },
            768: {
                slidesPerView: 3,
                spaceBetween: 30,

            },
            992: {
                slidesPerView: 4,
                spaceBetween: 30,
            },
        },
    });



    $(".element-slider-collection .button-prev").on("click", function () {
        swiper3.slidePrev();
    });
    $(".element-slider-collection .button-next").on("click", function () {
        swiper3.slideNext();
    })

    /******************* /Слайдер с товарами из такой же коллекции ********************/


    const payment_header_slider = new Swiper('.payment__slider-menu', {
        // Optional parameters
        slidesPerView: 1.2,
        spaceBetween: 20,
        direction: 'horizontal',
        loop: false,

    });
    const tabs_header_slider = new Swiper('.tabs__header-slider', {
        slidesPerView: "auto",
        spaceBetween: 20,
        direction: 'horizontal',
        loop: false,
    });

    /******************* Слайдер с просмотренными ********************/
    const swiper4 = new Swiper('.element-slider-view-tovars', {
        // Optional parameters
        slidesPerView: 4,
        spaceBetween: 10,
        direction: 'horizontal',
        loop: true,
        breakpoints: {
            320: {
                slidesPerView: 2.3,
                spaceBetween: 30,
            },
            768: {
                slidesPerView: 3,
                spaceBetween: 30,

            },
            992: {
                slidesPerView: 4,
                spaceBetween: 30,
            },
        },
    });

    $(".element-slider-view-tovars .button-prev").on("click", function () {
        swiper4.slidePrev();
    });
    $(".element-slider-view-tovars .button-next").on("click", function () {
        swiper4.slideNext();
    })

    /******************* /Слайдер с просмотренными ********************/


    /******************* Табы ********************/


    let tab_array_lk = [];
    let hash0_lk = window.location.hash;
    let new_hash0_lk = hash0_lk.substring(1, hash0_lk.length);
    $('.tab__header').each(function (i) {
        tab_array_lk.push($(this).attr('tab-id'));
    });
    if (window.location.hash == '') {
        $('.tab__content').hide();
        $('.tab__content').first().show();
        let tab = $('.tab__header').first().attr('tab-id');
        $('.tab__header[tab-id="' + tab + '"]').addClass('active');
    }
    else {
        if ($.inArray(new_hash0_lk, tab_array_lk) !== -1) {
            $('.tab__content').hide();
            $('.tab__content[tab-id="' + new_hash0_lk + '"]').addClass('active').show();
            $('.tab__header[tab-id="' + new_hash0_lk + '"]').addClass('active');
        }
        else {
            $('.tab__content').hide();
            $('.tab__content').first().show();
            let tab = $('.tab__header').first().attr('tab-id');
            $('.tab__header[tab-id="' + tab + '"]').addClass('active');
        }
    }




    $('.tab__header').click(function () {
        let tabId = $(this).attr('tab-id');
        if (tabId != undefined) {
            $('.tab__header').removeClass('active');
            $(this).addClass('active');
            $('.tab__content').hide();
            $('.tab__content').each(function (index) {
                if ($(this).attr('tab-id') == tabId) {
                    $(this).fadeIn(250);

                    $('.tab__header[tab-id="' + $(this).attr('tab-id') + '"]').addClass('active');
                }
            });
        }
    });




    /******************* /Табы ********************/

    $('input[name="PERSONAL_PHONE"]').mask("8 (999) 999-99-99");
    $('input[name="PERSONAL_PHONE"]').click(function () {
        if ($(this).val() === '8 (___) ___-__-__') {
            $(this).get(0).setSelectionRange(3, 3);
        }
    });



    $('#soa-property-3').mask("8 (999) 999-99-99");
    $('#soa-property-3').click(function () {
        if ($(this).val() === '8 (___) ___-__-__') {
            $(this).get(0).setSelectionRange(3, 3);
        }
    });


    /******************* Мобильное меню ********************/



    $('.menu-item').click(function () {
        $('.menu-item').next().css('display', 'none');
        $('.menu-item-arrow').removeClass('active');
        if (!$(this).next().hasClass('active')) {
            $(this).next().stop().slideDown(300).css({ 'display': 'flex' }).addClass('active');
            $(this).children('.menu-item-arrow-wrapper').children('.menu-item-arrow').addClass('active');
        }
        else {
            $(this).next().slideUp(100).removeClass('active');
            $(this).children('.menu-item-arrow-wrapper').children('.menu-item-arrow').removeClass('active');
        }
    });
    $(".header__top-burger").on("click", function () {
        $(".header__bottom").toggleClass("active");
        $("body").css('overflow', 'hidden');
    })
    $(".menu-close-button").click(function () {
        $(".header__bottom").toggleClass("active");
        $("body").css('overflow', 'auto');
    });

    /******************* /Мобильное меню ********************/

    /*для детальной всякое(еще попап для персонального)*/
    $('input[name*="actionADD2BASKET"]').click(function () {
        event.preventDefault()
        id_val = $('input[name*=id]').attr('value'); // id - имя input-а c id товара
        $('.detail-PopUp').addClass('active');
        $('body').css('overflow', 'hidden');
        $('.cart-detail').addClass('incart');

        $.ajax({
            type: "post",
            url: $('.add_form').attr('action'),
            data: { id: id_val, actionADD2BASKET: 'В корзину', action: "BUY" },
            dataType: "html",
            success: function (out) {

            }
        });
        return false;
    });
    $('.detail-PopUp-back').click(function () {
        $('.detail-PopUp').removeClass('active');
        $('body').css('overflow', 'auto');
    });
    $('.detail-PopUp-close').click(function () {

        $('.detail-PopUp-content-success').css('display', 'none');
        $('.detail-PopUp-content:not(.detail-PopUp-content-success)').show().css('display', 'flex');

        $('.detail-PopUp').removeClass('active');
        $('body').css('overflow', 'auto');
        $('.detail-PopUp-key').css('left', "-56px");
    });
    $('.transperent-btn').click(function () {
        $('.detail-PopUp').removeClass('active');
        $('body').css('overflow', 'auto');
    });


    $('#change-pass').click(function () {
        $('.detail-PopUp').addClass('active');
        $('body').css('overflow', 'hidden');
    });

    $(".link-arrow.show-more").click(function () {
        $('.banny-ritual-text-mobile').toggleClass("active");
        $('.banny-ritual__mobile-table').toggleClass("active");

        if ($('.banny-ritual-text-mobile').hasClass("active")) {
            $('.banny-ritual-text-mobile').fadeIn(500);
            $(this).html("<span>Показать меньше</span>");
        }
        else {
            $('.banny-ritual-text-mobile').fadeOut(500);
            $(this).html("<span>Показать больше</span>");
        };
    });

    $('.bx-filter-input-container .price').on("input", function (event) {
        let dataValue = event.target.value;
        //разрешаеt только цифры
        let re = /[^\d]/gi;
        event.target.value = dataValue.replace(re, "");
    });

    $('.basket-item-block-properties.bakset-var1__items__item__td').css('display', 'flex');


    $('#basket-root').on('focus', '.form-control', function () {
        console.log('в эвенте');
        if ($('.close-link').length > 0) {
            console.log('в условии');
            $('.close-link').trigger('click');
        }
    });

    $('#basket-items-list-container').on('click', '.basket-item-scu-item.selected', function () {

        $('.basket-item-scu-item.selected').not($(this)).parent().parent().children('.basket-item-scu-list-non-selected').removeClass('active');
        $('.basket-item-scu-item.selected').not($(this)).removeClass('active');

        $(this).parent().parent().children('.basket-item-scu-list-non-selected').toggleClass('active');
        $(this).toggleClass('active');
    });

    //ajax авторизация
    $("#auth_form").submit(function (e) {
        $.ajax({
            url: '/local/templates/Abysshabidecor/ajax/auth.php',
            method: 'post',
            dataType: 'json',
            data: $(this).serialize(),
            success: function (result) {
                console.log(result.status);
                if (result.status)
                    location.href = 'https://abysshabidecor.ru/personal/';
                else {
                    $('#login_error').html(result.message);
                }
            }
        });
        e.preventDefault;
        return false;
    });
    $("#reg_form").submit(function (e) {
        $.ajax({
            url: '/local/templates/Abysshabidecor/ajax/registration.php',
            method: 'post',
            dataType: 'json',
            data: $(this).serialize(),
            success: function (result) {
                if (result.status) {
                    if (result.status == 'success') {
                        location.href = 'https://abysshabidecor.ru/personal/#personal-data';
                    }
                    else {
                        let message = result.message;
                        console.log(result);
                        $('#reg_error').html(message['MESSAGE']);
                    }
                }
            }
        });
        e.preventDefault;
        return false;
    });


    $("#change_password").submit(function (e) {
        $.ajax({
            url: '/local/templates/Abysshabidecor/ajax/change_password.php',
            method: 'post',
            dataType: 'json',
            data: $(this).serialize(),
            success: function (result) {
                if (result["status"] == "success") {
                    $('.detail-PopUp-content').hide()
                    $('.detail-PopUp-content-success').show().css('display', 'flex');
                    let center_left = $('.detail-PopUp-circle').height() / 2 - 32;
                    setTimeout(() => {
                        $('.detail-PopUp-key').animate({ left: "50px" }, 400, "swing", function () {
                            $(this).animate({ left: center_left }, 100, "swing");
                        });
                    }, 300);

                }
                else {
                    $('#change_password .content__input').last().addClass('error');
                    $('#change_password .content__input .imformer').html(result["message"]);
                }
            }
        });
        e.preventDefault;
        return false;
    });

    $("#forgot_form").submit(function (e) {
        $.ajax({
            url: '/local/templates/Abysshabidecor/ajax/forgot.php',
            method: 'post',
            dataType: 'json',
            data: $(this).serialize(),
            success: function (result) {
                console.log(result);
                $('.forgot-input').removeClass('good').removeClass('error');
                if (result['status'] == "success") {
                    $('.forgot-input').addClass('good');
                    $('.forgot-input .imformer').html(result['message']);
                }
                else {
                    $('.forgot-input').addClass('error');
                    $('.forgot-input .imformer').html(result['message']);
                }
            }
        });
        e.preventDefault;
        return false;
    });

    $('.header__submenu').hide();
    $('.header__menu li').hover(
        function () {
            if ($(window).width() > 991) {
                $(this).find('.header__submenu').stop().slideDown(300).css({'display': 'flex'});
            }
        },
        function () {
            if ($(window).width() > 991) {
                $(this).find('.header__submenu').stop().slideUp(100).removeClass('active');
            }
        }
    );
    



});




//изменение полей юзера
$(document).ready(function () {

    $('.user_form .input').on('focusout', function (event) {
        $(this).removeClass("good");
        var parent = $(this).parent();
        $(parent).removeClass("good");
        $(parent).removeClass("error");
        $(".imformer", parent).html("");
        if ($(this).val()) {

            var param = $(this).attr('name') + '=' + $(this).val();

            $.ajax({
                url: '/local/templates/Abysshabidecor/ajax/update_user.php',
                type: 'POST',
                dataType: 'json',
                processData: false,
                ontentType: false,
                data: param,
                error: function (jqXHR, exception) {
                    if (jqXHR.status === 0) {
                        alert('НЕ подключен к интернету!');
                    } else if (jqXHR.status == 404) {
                        alert('НЕ найдена страница запроса [404])');
                    } else if (jqXHR.status == 500) {
                        alert('НЕ найден домен в запросе [500].');
                    } else if (exception === 'parsererror') {
                        alert("Ошибка в коде: \n" + jqXHR.responseText);
                    } else if (exception === 'timeout') {
                        alert('Не ответил на запрос.');
                    } else if (exception === 'abort') {
                        alert('Прерван запрос Ajax.');
                    } else {
                        alert('Неизвестная ошибка:\n' + jqXHR.responseText);
                    }
                }
            }).done(function (res) {
                console.log("Форма отправлена");
                if (res == "good") {
                    $(parent).addClass("good");
                    $(".imformer", parent).html("Данные успешно изменены");
                } else {
                    $(parent).addClass("error");
                    $(".imformer", parent).html(res);
                }

            })
                .fail(function (res) {
                    console.log("error");
                    $(this).addClass("error");
                })
                .always(function (res) {
                    console.log(res);
                });
        }
    });

});

$(document).ready(function () {

    $('.form_abis').on('submit', function (event) {
        event.preventDefault();
        var test = true;

        $(':input[test]:visible').each(function (i, requiredField) {

            var parent = $(requiredField).parent();
            $(parent).removeClass("good");
            $(parent).removeClass("error");

            if ($(requiredField).val()) {
                $(parent).addClass("good");
                console.log("good")
            } else {
                $(parent).addClass("error");
                console.log("err")
                $(".imformer", parent).html("Заполните обязательное поле");
                test = false;
            }
        });

        if (test == true) {

            let error = false;
            $('.form_abis button').prop('disabled', true);
            $.ajax({
                url: '/ajax/form.php',
                type: 'POST',
                dataType: 'json',
                processData: false,
                contentType: false,
                data: new FormData(this),
                error: function (jqXHR, exception) {
                    if (jqXHR.status === 0) {
                        alert('НЕ подключен к интернету!');
                    } else if (jqXHR.status == 404) {
                        alert('НЕ найдена страница запроса [404])');
                    } else if (jqXHR.status == 500) {
                        alert('НЕ найден домен в запросе [500].');
                    } else if (exception === 'parsererror') {
                        alert("Ошибка в коде: \n" + jqXHR.responseText);
                    } else if (exception === 'timeout') {
                        alert('Не ответил на запрос.');
                    } else if (exception === 'abort') {
                        alert('Прерван запрос Ajax.');
                    } else {
                        alert('Неизвестная ошибка:\n' + jqXHR.responseText);
                    }
                }
            }).done(function (res) {
                console.log(res);
                $('.form_abis button').html('Сообщение отправлено');
            })
                .fail(function () {
                    console.log("error");
                })
                .always(function () {

                });
        }
    });

    $('.basket-item__null-tovar').hover(
    function(){
        $(this).children('.basket-item__text').stop().fadeIn(300);
    },
    function(){
        $(this).children('.basket-item__text').stop().fadeOut(300);
    });

});  
