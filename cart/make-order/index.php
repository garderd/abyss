<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Оформление заказа");
?><div class="container">
	 <?$APPLICATION->IncludeComponent(
		"bitrix:breadcrumb",
		"breadcrumb",
		Array(
			"PATH" => "",
			"SITE_ID" => "s1",
			"START_FROM" => "0"
		)
	);?> 


	 <?$APPLICATION->IncludeComponent(
	"bitrix:sale.order.ajax",
	"main",
	Array(
		"ACTION_VARIABLE" => "soa-action",
		"ADDITIONAL_PICT_PROP_5" => "-",
		"ADDITIONAL_PICT_PROP_7" => "-",
		"ALLOW_APPEND_ORDER" => "Y",
		"ALLOW_AUTO_REGISTER" => "Y",
		"ALLOW_NEW_PROFILE" => "N",
		"ALLOW_USER_PROFILES" => "N",
		"BASKET_IMAGES_SCALING" => "adaptive",
		"BASKET_POSITION" => "before",
		"COMPATIBLE_MODE" => "Y",
		"DELIVERIES_PER_PAGE" => "9",
		"DELIVERY_FADE_EXTRA_SERVICES" => "N",
		"DELIVERY_NO_AJAX" => "H",
		"DELIVERY_NO_SESSION" => "Y",
		"DELIVERY_TO_PAYSYSTEM" => "p2d",
		"DISABLE_BASKET_REDIRECT" => "N",
		"EMPTY_BASKET_HINT_PATH" => "/",
		"HIDE_ORDER_DESCRIPTION" => "N",
		"ONLY_FULL_PAY_FROM_ACCOUNT" => "N",
		"PATH_TO_AUTH" => "/auth/",
		"PATH_TO_BASKET" => "/cart/",
		"PATH_TO_PAYMENT" => "payment.php",
		"PATH_TO_PERSONAL" => "index.php",
		"PAY_FROM_ACCOUNT" => "N",
		"PAY_SYSTEMS_PER_PAGE" => "9",
		"PICKUPS_PER_PAGE" => "5",
		"PICKUP_MAP_TYPE" => "yandex",
		"PRODUCT_COLUMNS_HIDDEN" => array(),
		"PRODUCT_COLUMNS_VISIBLE" => array("PREVIEW_PICTURE","PROPS"),
		"PROPS_FADE_LIST_1" => array("1","2","3"),
		"SEND_NEW_USER_NOTIFY" => "Y",
		"SERVICES_IMAGES_SCALING" => "adaptive",
		"SET_TITLE" => "Y",
		"SHOW_BASKET_HEADERS" => "N",
		"SHOW_COUPONS" => "N",
		"SHOW_COUPONS_BASKET" => "Y",
		"SHOW_COUPONS_DELIVERY" => "Y",
		"SHOW_COUPONS_PAY_SYSTEM" => "Y",
		"SHOW_DELIVERY_INFO_NAME" => "Y",
		"SHOW_DELIVERY_LIST_NAMES" => "Y",
		"SHOW_DELIVERY_PARENT_NAMES" => "N",
		"SHOW_MAP_IN_PROPS" => "N",
		"SHOW_NEAREST_PICKUP" => "N",
		"SHOW_NOT_CALCULATED_DELIVERIES" => "L",
		"SHOW_ORDER_BUTTON" => "final_step",
		"SHOW_PAY_SYSTEM_INFO_NAME" => "Y",
		"SHOW_PAY_SYSTEM_LIST_NAMES" => "Y",
		"SHOW_PICKUP_MAP" => "Y",
		"SHOW_STORES_IMAGES" => "N",
		"SHOW_TOTAL_ORDER_BUTTON" => "N",
		"SHOW_VAT_PRICE" => "N",
		"SKIP_USELESS_BLOCK" => "Y",
		"SPOT_LOCATION_BY_GEOIP" => "Y",
		"TEMPLATE_LOCATION" => "popup",
		"TEMPLATE_THEME" => "blue",
		"USER_CONSENT" => "N",
		"USER_CONSENT_ID" => "0",
		"USER_CONSENT_IS_CHECKED" => "Y",
		"USER_CONSENT_IS_LOADED" => "N",
		"USE_CUSTOM_ADDITIONAL_MESSAGES" => "N",
		"USE_CUSTOM_ERROR_MESSAGES" => "N",
		"USE_CUSTOM_MAIN_MESSAGES" => "N",
		"USE_ENHANCED_ECOMMERCE" => "N",
		"USE_PHONE_NORMALIZATION" => "N",
		"USE_PRELOAD" => "Y",
		"USE_PREPAYMENT" => "N",
		"USE_YM_GOALS" => "N"
	)
);?>
</div>

<?$APPLICATION->IncludeComponent(
	"bitrix:catalog.section", 
	"defoult", 
	array(
		"TITLE" => "Рекомендуем",
		"WHITE_BG" => "Y",
		"SECTION_ID" => "",
		"IBLOCK_TYPE" => "1c_catalog",
		"IBLOCK_ID" => "33",
		"HIDE_NOT_AVAILABLE" => "Y",
		"ELEMENT_SORT_FIELD" => "shows",
		"ELEMENT_SORT_ORDER" => "desc",
		"BASKET_URL" => "/cart/",
		"ACTION_VARIABLE" => "action",
		"PRODUCT_ID_VARIABLE" => "id",
		"SECTION_ID_VARIABLE" => "SECTION_ID",
		"FILTER_NAME" => "arrFilter",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"SET_TITLE" => "N",
		"SET_STATUS_404" => "N",
		"PAGE_ELEMENT_COUNT" => "10",
		"PRICE_CODE" => array(
			0 => "BASE",
		),
		"OFFERS_SORT_FIELD" => "shows",
		"OFFERS_SORT_ORDER" => "asc",
		"SECTION_URL" => "/katalog/#SECTION_CODE_PATH#/",
		"DETAIL_URL" => "/katalog/#SECTION_CODE_PATH#/#ELEMENT_CODE#/",
		"COMPONENT_TEMPLATE" => "defoult",
		"SECTION_CODE" => "",
		"SECTION_USER_FIELDS" => array(
			0 => "",
			1 => "",
		),
		"INCLUDE_SUBSECTIONS" => "Y",
		"SHOW_ALL_WO_SECTION" => "N",
		"CUSTOM_FILTER" => "{\"CLASS_ID\":\"CondGroup\",\"DATA\":{\"All\":\"AND\",\"True\":\"True\"},\"CHILDREN\":[]}",
		"HIDE_NOT_AVAILABLE_OFFERS" => "N",
		"ELEMENT_SORT_FIELD2" => "id",
		"ELEMENT_SORT_ORDER2" => "desc",
		"OFFERS_SORT_FIELD2" => "id",
		"OFFERS_SORT_ORDER2" => "desc",
		"LINE_ELEMENT_COUNT" => "3",
		"OFFERS_FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"OFFERS_LIMIT" => "5",
		"BACKGROUND_IMAGE" => "-",
		"SEF_MODE" => "N",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"SET_BROWSER_TITLE" => "Y",
		"BROWSER_TITLE" => "-",
		"SET_META_KEYWORDS" => "Y",
		"META_KEYWORDS" => "-",
		"SET_META_DESCRIPTION" => "Y",
		"META_DESCRIPTION" => "-",
		"SET_LAST_MODIFIED" => "N",
		"USE_MAIN_ELEMENT_SECTION" => "N",
		"ADD_SECTIONS_CHAIN" => "N",
		"USE_PRICE_COUNT" => "N",
		"SHOW_PRICE_COUNT" => "1",
		"PRICE_VAT_INCLUDE" => "Y",
		"CONVERT_CURRENCY" => "N",
		"USE_PRODUCT_QUANTITY" => "N",
		"PRODUCT_QUANTITY_VARIABLE" => "quantity",
		"ADD_PROPERTIES_TO_BASKET" => "Y",
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"PARTIAL_PRODUCT_PROPERTIES" => "N",
		"DISPLAY_COMPARE" => "N",
		"PAGER_TEMPLATE" => ".default",
		"DISPLAY_TOP_PAGER" => "N",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"PAGER_TITLE" => "Товары",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"SHOW_404" => "N",
		"MESSAGE_404" => "",
		"COMPATIBLE_MODE" => "Y",
		"DISABLE_INIT_JS_IN_COMPONENT" => "N"
	),
	false
);?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>