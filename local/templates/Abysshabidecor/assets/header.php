<?  if (!defined ('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
    use Bitrix\Main\Page\Asset;

    use Bitrix\Main\Loader;
    Loader::includeModule("sale");
    $BasketItems = CSaleBasket::GetList(
        array(),
        array(
            "FUSER_ID" => CSaleBasket::GetBasketUserID(),
            "LID" => SITE_ID,
            "ORDER_ID" => "NULL"

        ),
        array(),
    );
    $GLOBALS['basketItems'] = $BasketItems;
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?$APPLICATION->ShowTitle();?>
    </title>
    <?
        Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/assets/vendor/jquery/jquery-3.6.1.min.js");
        Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/assets/vendor/jquery/jquery.maskedinput.js");
        Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/assets/vendor/bootstrap-5/js/bootstrap.js");
        Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/assets/vendor/swiper/swiper-bundle.min.js");
        Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/assets/vendor/fancybox/fancybox.umd.js");
        Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "https://cdn.jsdelivr.net/npm/jquery.maskedinput@1.4.1/src/jquery.maskedinput.min.js");
        Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js");
        Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/assets/js/script.js");
        
        Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/assets/vendor/bootstrap-5/css/bootstrap.css");
        Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/assets/vendor/swiper/swiper-bundle.min.css");
        Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/assets/vendor/fancybox/fancybox.css");
        Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/assets/css/main.css");
		$APPLICATION->ShowHead();
    ?>
<meta name="mailru-domain" content="lRcqzXBiLZoNexB8" />
</head>

<body>
    <div id="panel">
        <? $APPLICATION->showPanel(); ?>
    </div>

    
    <header>
        <div class="container header-container d-flex flex-column">
            <div class="header__top d-flex flex-row justify-content-between align-items-center">
                    <?$APPLICATION->IncludeComponent(
						"bitrix:main.include",
						".default",
						array(
						"AREA_FILE_SHOW" => "file",
						"COMPONENT_TEMPLATE" => ".default",
						"PATH" => "/local/templates/Abysshabidecor/includes/header_links.php"
						)
					);?>
                <div class="header__top-logo">
                    <a href="/">
                        <img class="header-logo__img" src="<?=SITE_TEMPLATE_PATH?>/assets/img/logo/logo1.svg" alt="">
                    </a>
                </div>
                <div class="header__top-icons d-flex justify-content-end">
                    <a href="javascript:void(0)">
                        <img class="form-button" src="<?=SITE_TEMPLATE_PATH?>/assets/img/icons/search.svg" alt="">
                        <?$APPLICATION->IncludeComponent("bitrix:search.form", "search_form", Array(
							"PAGE" => "#SITE_DIR#search/index.php",	// Страница выдачи результатов поиска (доступен макрос #SITE_DIR#)
								"USE_SUGGEST" => "N",	// Показывать подсказку с поисковыми фразами
							),
							false
						);?>
                    </a>
                    <a <?if(!$USER->IsAuthorized()) echo 'class="icons__person"'; else echo 'href="/personal/"' ?>>
                        <img src="<?=SITE_TEMPLATE_PATH?>/assets/img/icons/person.svg" alt="">
                    </a>
                    <a <?if($USER->IsAuthorized()){echo 'href="/personal/#favorities"';}else{echo 'href="/favorities/"';};?>>
                        <img src="<?=SITE_TEMPLATE_PATH?>/assets/img/icons/heart.svg" alt="">
                    </a>
                    <a href="/cart/" class="header__basket">
                        <img src="<?=SITE_TEMPLATE_PATH?>/assets/img/icons/bag.svg" alt="">
                        <?if($BasketItems > 0):?>
                        <div class="header-basket__circle"><?=$BasketItems;?></div>
                        <?endif;?>
                    </a>
                </div>
                <div class="header-mobile-right">
                    <a href="/cart/" class="mobile_basket header__basket">
                        <img src="<?=SITE_TEMPLATE_PATH?>/assets/img/icons/bag.svg" alt="">
                        <?if($BasketItems > 0):?>
                        <div class="header-basket__circle"><?=$BasketItems;?></div>
                        <?endif;?>
                    </a>
                    <div class="header__top-burger"></div>
                </div>
            </div>
            <div class="header__bottom">
                <div class="menu-close-button"></div>
                <?$APPLICATION->IncludeComponent(
                    "bitrix:menu", 
                    "header_menu", 
                    array(
                        "ALLOW_MULTI_SELECT" => "N",
                        "CHILD_MENU_TYPE" => "left",
                        "DELAY" => "N",
                        "MAX_LEVEL" => "2",
                        "MENU_CACHE_GET_VARS" => array(
                        ),
                        "MENU_CACHE_TIME" => "3600",
                        "MENU_CACHE_TYPE" => "N",
                        "MENU_CACHE_USE_GROUPS" => "Y",
                        "MENU_THEME" => "site",
                        "ROOT_MENU_TYPE" => "top",
                        "USE_EXT" => "Y",
                        "COMPONENT_TEMPLATE" => "header_menu"
                    ),
                    false
                );?>
            </div>
        </div>
        
    </header>
    <main>
