<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
?>

<div class="catalog-element">
			<div class="container catalog-element__breadcrumb">
            <?$APPLICATION->IncludeComponent(
                "bitrix:breadcrumb",
                "breadcrumb",
                Array(
                    "PATH" => "",
                    "SITE_ID" => "s1",
                    "START_FROM" => "0"
                )
            );?>
    		</div>
		
	<?$ElementID=$APPLICATION->IncludeComponent(
		"bitrix:catalog.element",
		"",
		Array(
			"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
			"IBLOCK_ID" => $arParams["IBLOCK_ID"],
			"PROPERTY_CODE" => $arParams["DETAIL_PROPERTY_CODE"],
			"META_KEYWORDS" => $arParams["DETAIL_META_KEYWORDS"],
			"META_DESCRIPTION" => $arParams["DETAIL_META_DESCRIPTION"],
			"BROWSER_TITLE" => $arParams["DETAIL_BROWSER_TITLE"],
			"BASKET_URL" => $arParams["BASKET_URL"],
			"ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
			"PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
			"SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
			"DISPLAY_PANEL" => $arParams["DISPLAY_PANEL"],
			"CACHE_TYPE" => "N",
			"CACHE_TIME" => $arParams["CACHE_TIME"],
			"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
			"SET_TITLE" => $arParams["SET_TITLE"],
			"SET_STATUS_404" => $arParams["SET_STATUS_404"],
			"PRICE_CODE" => $arParams["PRICE_CODE"],
			"USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
			"SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],
			"PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
			"PRICE_VAT_SHOW_VALUE" => $arParams["PRICE_VAT_SHOW_VALUE"],
			"LINK_IBLOCK_TYPE" => $arParams["LINK_IBLOCK_TYPE"],
			"LINK_IBLOCK_ID" => $arParams["LINK_IBLOCK_ID"],
			"LINK_PROPERTY_SID" => $arParams["LINK_PROPERTY_SID"],
			"LINK_ELEMENTS_URL" => $arParams["LINK_ELEMENTS_URL"],
			"ID_HIGHLOAD" => $arParams["ID_HIGHLOAD"],
			"OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],
			"OFFERS_FIELD_CODE" => $arParams["DETAIL_OFFERS_FIELD_CODE"],
			"OFFERS_PROPERTY_CODE" => $arParams["DETAIL_OFFERS_PROPERTY_CODE"],
			"OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
			"OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
			"ADD_ELEMENT_CHAIN" => $arParams["ADD_ELEMENT_CHAIN"],
			"ELEMENT_ID" => $arResult["VARIABLES"]["ELEMENT_ID"],
			"ELEMENT_CODE" => $arResult["VARIABLES"]["ELEMENT_CODE"],
			"USE_MAIN_ELEMENT_SECTION" => $arParams['USE_MAIN_ELEMENT_SECTION'],
			"STRICT_SECTION_CHECK" => $arParams['DETAIL_STRICT_SECTION_CHECK'],
			"SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
			"SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
			"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
			"DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["element"],
		),
		$component
	);?>

<?
	$res = CIBlockElement::GetByID($ElementID);
	if($ar_res = $res->GetNext()){
		$section = CIBlockSection::GetByID($ar_res['IBLOCK_SECTION_ID']);
		if($ar_section = $section->GetNext()){}
			$GLOBALS['FilterID']=Array("!ID" => $ElementID);
	}

	$APPLICATION->IncludeComponent(
	"bitrix:catalog.section",
	"defoult",
	Array(
		"TITLE" => "ЕЩЕ ТОВАРЫ ИЗ КОЛЛЕКЦИИ ".$ar_section['NAME'], //заголовок сверху
		"WHITE_BG" => "", //задать если нужен белый фон, вместо серого
		"SECTION_ID" => $ar_res['IBLOCK_SECTION_ID'],//раздел, он же коллекци
		'IBLOCK_TYPE' => "catalog",
	    'IBLOCK_ID' => $arParams["IBLOCK_ID"],
	    'HIDE_NOT_AVAILABLE' => "Y",
	   	'ELEMENT_SORT_FIELD' => "shows",
	    'ELEMENT_SORT_ORDER' => "desc",
	    'BASKET_URL' => "/cart/",
	    'ACTION_VARIABLE' => "action",
	    'PRODUCT_ID_VARIABLE' => "id",
	    'SECTION_ID_VARIABLE' => "SECTION_ID",
	    'FILTER_NAME' => "FilterID",
	    'CACHE_TYPE' => "A",
	    'CACHE_TIME' => "36000000",
	    'CACHE_FILTER' => "N",
	    'CACHE_GROUPS' => "Y",
	    'SET_TITLE' => "N",
	    'SET_STATUS_404' => "N",
	    'PAGE_ELEMENT_COUNT' => "10",
	    'PRICE_CODE' => array(0=>"BASE",),
	    'OFFERS_SORT_FIELD' => 'shows',
	    'OFFERS_SORT_ORDER' => 'asc',
	    'SECTION_URL' => "/katalog/#SECTION_CODE_PATH#/",
	    'DETAIL_URL' => '/katalog/#SECTION_CODE_PATH#/#ELEMENT_CODE#/',
	)
	);?>
	<?/*$APPLICATION->IncludeComponent(
		"bitrix:catalog.section",
		"tovars_in_detail_page",
		Array(
			"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
			"IBLOCK_ID" => $arParams["IBLOCK_ID"],
			"HIDE_NOT_AVAILABLE" => $arParams["HIDE_NOT_AVAILABLE"],
			"ELEMENT_SORT_FIELD" => $arParams["ELEMENT_SORT_FIELD"],
			"ELEMENT_SORT_ORDER" => $arParams["ELEMENT_SORT_ORDER"],
			"PROPERTY_CODE" => $arParams["LIST_PROPERTY_CODE"],
			"META_KEYWORDS" => $arParams["LIST_META_KEYWORDS"],
			"META_DESCRIPTION" => $arParams["LIST_META_DESCRIPTION"],
			"BROWSER_TITLE" => $arParams["LIST_BROWSER_TITLE"],
			"INCLUDE_SUBSECTIONS" => $arParams["INCLUDE_SUBSECTIONS"],
			"BASKET_URL" => $arParams["BASKET_URL"],
			"ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
			"PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
			"SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
			"FILTER_NAME" => $arParams["FILTER_NAME"],
			"DISPLAY_PANEL" => $arParams["DISPLAY_PANEL"],
			"CACHE_TYPE" => $arParams["CACHE_TYPE"],
			"CACHE_TIME" => $arParams["CACHE_TIME"],
			"CACHE_FILTER" => $arParams["CACHE_FILTER"],
			"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
			"SET_TITLE" => $arParams["SET_TITLE"],
			"SET_STATUS_404" => $arParams["SET_STATUS_404"],
			"DISPLAY_COMPARE" => $arParams["USE_COMPARE"],
			"PAGE_ELEMENT_COUNT" => $arParams["PAGE_ELEMENT_COUNT"],
			"LINE_ELEMENT_COUNT" => $arParams["LINE_ELEMENT_COUNT"],
			"PRICE_CODE" => $arParams["PRICE_CODE"],
			"USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
			"SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],

			"PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],

			"DISPLAY_TOP_PAGER" => $arParams["DISPLAY_TOP_PAGER"],
			"DISPLAY_BOTTOM_PAGER" => $arParams["DISPLAY_BOTTOM_PAGER"],
			"PAGER_TITLE" => $arParams["PAGER_TITLE"],
			"PAGER_SHOW_ALWAYS" => $arParams["PAGER_SHOW_ALWAYS"],
			"PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
			"PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
			"PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
			"PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],

			"OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],
			"OFFERS_FIELD_CODE" => $arParams["LIST_OFFERS_FIELD_CODE"],
			"OFFERS_PROPERTY_CODE" => $arParams["LIST_OFFERS_PROPERTY_CODE"],
			"OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
			"OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
			"OFFERS_LIMIT" => $arParams["LIST_OFFERS_LIMIT"],

			"SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
			"SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
			"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
			"DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["element"],

		
		),
		$component
	);
	*/?>
	<?$APPLICATION->IncludeComponent(
	"bitrix:catalog.products.viewed", 
	"view_tovars", 
	array(
		"ACTION_VARIABLE" => "action_cpv",
		"ADDITIONAL_PICT_PROP_5" => "-",
		"ADDITIONAL_PICT_PROP_7" => "-",
		"ADD_PROPERTIES_TO_BASKET" => "Y",
		"ADD_TO_BASKET_ACTION" => "ADD",
		"BASKET_URL" => "/personal/basket.php",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "3600",
		"CACHE_TYPE" => "A",
		"CONVERT_CURRENCY" => "N",
		"DEPTH" => "2",
		"DISPLAY_COMPARE" => "N",
		"ENLARGE_PRODUCT" => "STRICT",
		"HIDE_NOT_AVAILABLE" => "N",
		"HIDE_NOT_AVAILABLE_OFFERS" => "N",
		"IBLOCK_ID" => $arParams["IBLOCK_ID"],
		"IBLOCK_MODE" => "single",
		"IBLOCK_TYPE" => "catalog",
		"LABEL_PROP_5" => array(
		),
		"LABEL_PROP_POSITION" => "top-left",
		"MESS_BTN_ADD_TO_BASKET" => "В корзину",
		"MESS_BTN_BUY" => "Купить",
		"MESS_BTN_DETAIL" => "Подробнее",
		"MESS_BTN_SUBSCRIBE" => "Подписаться",
		"MESS_NOT_AVAILABLE" => "Нет в наличии",
		"PAGE_ELEMENT_COUNT" => "9",
		"PARTIAL_PRODUCT_PROPERTIES" => "N",
		"PRICE_CODE" => array(
			0 => "BASE",
		),
		"PRICE_VAT_INCLUDE" => "Y",
		"PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons",
		"PRODUCT_ID_VARIABLE" => "id",
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"PRODUCT_QUANTITY_VARIABLE" => "quantity",
		"PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false}]",
		"PRODUCT_SUBSCRIPTION" => "Y",
		"SECTION_CODE" => "",
		"SECTION_ELEMENT_CODE" => "",
		"SECTION_ELEMENT_ID" => $GLOBALS["CATALOG_CURRENT_ELEMENT_ID"],
		"SECTION_ID" => $GLOBALS["CATALOG_CURRENT_SECTION_ID"],
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
		"USE_PRICE_COUNT" => "N",
		"USE_PRODUCT_QUANTITY" => "N",
		"COMPONENT_TEMPLATE" => "view_tovars"
	),
	false
);?>

</div>
