<?
/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 */
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();

if($arResult["SHOW_SMS_FIELD"] == true)
{
	CJSCore::Init('phone_auth');
}
?>

<h1 class="personal__header">Личный кабинет</h1>
    <div class="d-flex justify-content-start tabs__wrapper">
        <div class="tabs__header-wrapper">
			<div class="tab__header" tab-id="orders"><h3 class="tab__h3">Заказы</h3> <div class="tab__header-arrow"></div></div>
			<a href="/favorities/" class="tab__header"><h3 class="tab__h3">Избранное</h3> <div class="tab__header-arrow"></div></a>
			<div class="tab__header" tab-id="personal-data"><h3 class="tab__h3">Персональные данные</h3> <div class="tab__header-arrow"></div></div>
			<div class="tab__header" tab-id="personal-sale"><h3 class="tab__h3">Персональная скидка</h3> <div class="tab__header-arrow"></div></div>
        </div>
        <div class="tabs__content-wrapper">
			<div class="tab__content" tab-id="orders">
				<?global $USER;
					if ($USER->IsAuthorized()):?>
			<?$APPLICATION->IncludeComponent(
				"bitrix:sale.personal.order.list",
				"list",
				Array(
					"ACTIVE_DATE_FORMAT" => "d.m.Y",
					"CACHE_GROUPS" => "Y",
					"CACHE_TIME" => "3600",
					"CACHE_TYPE" => "A",
					"COMPONENT_TEMPLATE" => ".default",
					"DEFAULT_SORT" => "DATE_INSERT",
					"DISALLOW_CANCEL" => "N",
					"HISTORIC_STATUSES" => "",
					"ID" => $ID,
					"NAV_TEMPLATE" => "",
					"ORDERS_PER_PAGE" => "10000",
					"PATH_TO_BASKET" => "/cart/",
					"PATH_TO_CANCEL" => "",
					"PATH_TO_CATALOG" => "/katalog/",
					"PATH_TO_COPY" => "",
					"PATH_TO_DETAIL" => "",
					"PATH_TO_PAYMENT" => "payment.php",
					"REFRESH_PRICES" => "N",
					"RESTRICT_CHANGE_PAYSYSTEM" => array(0=>"0",),
					"SAVE_IN_SESSION" => "Y",
					"SET_TITLE" => "Y",
					"STATUS_COLOR_F" => "gray",
					"STATUS_COLOR_N" => "green",
					"STATUS_COLOR_P" => "yellow",
					"STATUS_COLOR_PSEUDO_CANCELLED" => "red"
				)
			);?>
			<?endif;?>
			</div>
			<div class="tab__content" tab-id="favorities">
			<?$APPLICATION->IncludeComponent(
					"bitrix:catalog.section",
					"favorites",
					Array(
						"ACTION_VARIABLE" => "action",
						"ADD_PICT_PROP" => "-",
						"ADD_PROPERTIES_TO_BASKET" => "Y",
						"ADD_SECTIONS_CHAIN" => "N",
						"ADD_TO_BASKET_ACTION" => "ADD",
						"AJAX_MODE" => "N",
						"AJAX_OPTION_ADDITIONAL" => "",
						"AJAX_OPTION_HISTORY" => "N",
						"AJAX_OPTION_JUMP" => "N",
						"AJAX_OPTION_STYLE" => "Y",
						"BACKGROUND_IMAGE" => "-",
						"BASKET_URL" => "/personal/basket.php",
						"BROWSER_TITLE" => "-",
						"CACHE_FILTER" => "N",
						"CACHE_GROUPS" => "N",
						"CACHE_TIME" => "36000000",
						"CACHE_TYPE" => "N",
						"COMPATIBLE_MODE" => "Y",
						"CONVERT_CURRENCY" => "N",
						"CUSTOM_FILTER" => "{\"CLASS_ID\":\"CondGroup\",\"DATA\":{\"All\":\"AND\",\"True\":\"True\"},\"CHILDREN\":[]}",
						"DETAIL_URL" => "",
						"DISABLE_INIT_JS_IN_COMPONENT" => "N",
						"DISPLAY_BOTTOM_PAGER" => "Y",
						"DISPLAY_COMPARE" => "N",
						"DISPLAY_TOP_PAGER" => "N",
						"ELEMENT_SORT_FIELD" => "sort",
						"ELEMENT_SORT_FIELD2" => "id",
						"ELEMENT_SORT_ORDER" => "asc",
						"ELEMENT_SORT_ORDER2" => "desc",
						"ENLARGE_PRODUCT" => "STRICT",
						"FILTER_NAME" => "arrFilter",
						"FAVORITES" => $arResult['FAVORITES'],
						"HIDE_NOT_AVAILABLE" => "N",
						"HIDE_NOT_AVAILABLE_OFFERS" => "N",
						"IBLOCK_ID" => "5",
						"IBLOCK_TYPE" => "catalog",
						"INCLUDE_SUBSECTIONS" => "Y",
						"LABEL_PROP" => array(),
						"LAZY_LOAD" => "N",
						"LINE_ELEMENT_COUNT" => "3",
						"LOAD_ON_SCROLL" => "N",
						"MESSAGE_404" => "",
						"MESS_BTN_ADD_TO_BASKET" => "В корзину",
						"MESS_BTN_BUY" => "Купить",
						"MESS_BTN_DETAIL" => "Подробнее",
						"MESS_BTN_LAZY_LOAD" => "Показать ещё",
						"MESS_BTN_SUBSCRIBE" => "Подписаться",
						"MESS_NOT_AVAILABLE" => "Нет в наличии",
						"META_DESCRIPTION" => "-",
						"META_KEYWORDS" => "-",
						"OFFERS_FIELD_CODE" => array("", ""),
						"OFFERS_LIMIT" => "5",
						"OFFERS_SORT_FIELD" => "sort",
						"OFFERS_SORT_FIELD2" => "id",
						"OFFERS_SORT_ORDER" => "asc",
						"OFFERS_SORT_ORDER2" => "desc",
						"PAGER_BASE_LINK_ENABLE" => "N",
						"PAGER_DESC_NUMBERING" => "N",
						"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
						"PAGER_SHOW_ALL" => "N",
						"PAGER_SHOW_ALWAYS" => "N",
						"PAGER_TEMPLATE" => ".default",
						"PAGER_TITLE" => "Товары",
						"PAGE_ELEMENT_COUNT" => "100000",
						"PARTIAL_PRODUCT_PROPERTIES" => "N",
						"PRICE_CODE" => array(),
						"PRICE_VAT_INCLUDE" => "Y",
						"PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons",
						"PRODUCT_DISPLAY_MODE" => "N",
						"PRODUCT_ID_VARIABLE" => "id",
						"PRODUCT_PROPS_VARIABLE" => "prop",
						"PRODUCT_QUANTITY_VARIABLE" => "quantity",
						"PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false}]",
						"PRODUCT_SUBSCRIPTION" => "Y",
						"PROPERTY_CODE_MOBILE" => array("SIZE", "VENDOR_CODE", "COLOR"),
						"RCM_PROD_ID" => $_REQUEST["PRODUCT_ID"],
						"RCM_TYPE" => "personal",
						"SECTION_CODE" => "",
						"SECTION_ID" => $_REQUEST["SECTION_ID"],
						"SECTION_ID_VARIABLE" => "SECTION_ID",
						"SECTION_URL" => "",
						"SECTION_USER_FIELDS" => array("", ""),
						"SEF_MODE" => "N",
						"SET_BROWSER_TITLE" => "Y",
						"SET_LAST_MODIFIED" => "N",
						"SET_META_DESCRIPTION" => "Y",
						"SET_META_KEYWORDS" => "Y",
						"SET_STATUS_404" => "N",
						"SET_TITLE" => "Y",
						"SHOW_404" => "N",
						"SHOW_ALL_WO_SECTION" => "N",
						"SHOW_CLOSE_POPUP" => "N",
						"SHOW_DISCOUNT_PERCENT" => "N",
						"SHOW_FROM_SECTION" => "N",
						"SHOW_MAX_QUANTITY" => "N",
						"SHOW_OLD_PRICE" => "N",
						"SHOW_PRICE_COUNT" => "1",
						"SHOW_SLIDER" => "Y",
						"SLIDER_INTERVAL" => "3000",
						"SLIDER_PROGRESS" => "N",
						"TEMPLATE_THEME" => "blue",
						"USE_ENHANCED_ECOMMERCE" => "N",
						"USE_MAIN_ELEMENT_SECTION" => "N",
						"USE_PRICE_COUNT" => "N",
						"USE_PRODUCT_QUANTITY" => "N"
					)
				);?>
			</div>
			<div class="tab__content" tab-id="personal-data">
				<form method="post" class="tab__form" name="form1" action="<?=$arResult["FORM_TARGET"]?>" enctype="multipart/form-data">
				<?=$arResult["BX_SESSION_CHECK"]?>
					<input type="hidden" name="lang" value="<?=LANG?>" />
					<input type="hidden" name="ID" value=<?=$arResult["ID"]?> />
					<div class="content__input">
						<span class="input__header">Фамилия</span>
						<input class="input" type="text" name="LAST_NAME" value="<?=$arResult["arUser"]["LAST_NAME"]?>" />
					</div>
					<div class="content__input">
						<span class="input__header">Имя</span>
						<input class="input" type="text" name="NAME" value="<?=$arResult["arUser"]["NAME"]?>" />
					</div>
					<div class="content__input">
						<span class="input__header">Отчество</span>
						<input class="input" type="text" name="SECOND_NAME" value="<?=$arResult["arUser"]["SECOND_NAME"]?>" />	
					</div>
					<div class="content__input">
						<span class="input__header">E-mail</span>
						<input class="input" type="text" name="EMAIL" value="<? echo $arResult["arUser"]["EMAIL"]?>" />
					</div>
					<div class="content__input">
						<span class="input__header">Телефон</span>
						<input class="input input__phone" type="text" name="PHONE_NUMBER" value="<? echo $arResult["arUser"]["PHONE_NUMBER"]?>" /> 
					</div>
					
					<input type="submit" name="save" value="<?=(($arResult["ID"]>0) ? GetMessage("MAIN_SAVE") : GetMessage("MAIN_ADD"))?>">
				</form>
			</div>
			<div class="tab__content" tab-id="personal-sale">
				персональная скидка
			</div>
        </div>
    </div>




