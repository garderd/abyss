<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
?>
<?/*
	if (CModule::IncludeModule("iblock")) {
		$arFilter = array(
			"ACTIVE" => "Y",
			"GLOBAL_ACTIVE" => "Y",
			"IBLOCK_ID" => $arParams["IBLOCK_ID"],
		);
		if (strlen($arResult["VARIABLES"]["SECTION_CODE"]) > 0) {
			$arFilter["=CODE"] = $arResult["VARIABLES"]["SECTION_CODE"];
		} elseif ($arResult["VARIABLES"]["SECTION_ID"] > 0) {
			$arFilter["ID"] = $arResult["VARIABLES"]["SECTION_ID"];
		}
		$obCache = new CPHPCache;
		if ($obCache->InitCache(36000, serialize($arFilter), "/iblock/catalog")) {
			$arCurSection = $obCache->GetVars();
		} else {
			$arCurSection = array();
			$dbRes = CIBlockSection::GetList(array(), $arFilter, false, array("ID"));
			$dbRes = new CIBlockResult($dbRes);
			if (defined("BX_COMP_MANAGED_CACHE")) {
				global $CACHE_MANAGER;
				$CACHE_MANAGER->StartTagCache("/iblock/catalog");

				if ($arCurSection = $dbRes->GetNext()) {
					$CACHE_MANAGER->RegisterTag("iblock_id_" . $arParams["IBLOCK_ID"]);
				}
				$CACHE_MANAGER->EndTagCache();
			} else {
				if (!$arCurSection = $dbRes->GetNext())
					$arCurSection = array();
			}
			$obCache->EndDataCache($arCurSection);
		}
	} 
	$path = $arResult['URL_TEMPLATES']['sections'].$arResult['VARIABLES']['SECTION_CODE_PATH'].'/';

	*/?>
<?$path = $APPLICATION->GetCurPage(false);?>

<div class="catalog-section__header-content">
    <div class="container catalog-section__breadcrumb-wrapper">
        <div class="catalog-section__breadcrumb">
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
    </div>
    <?$APPLICATION->IncludeComponent(
		"bitrix:news.list",
		"section_header",
			Array(
				"IBLOCK_ID" => $arParams['IBLOCK_ID'],
				"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
				"PATH" => $path,
				"SECTION_ID" => $arResult['VARIABLES']['SECTION_ID'],
				"SECTION_CODE" =>$arResult['VARIABLES']['SECTION_CODE'],
				"ACTIVE_DATE_FORMAT" => "d.m.Y",
				"ADD_SECTIONS_CHAIN" => $arParams["ADD_SECTIONS_CHAIN"],
				"AJAX_MODE" => "N",
				"AJAX_OPTION_ADDITIONAL" => "",
				"AJAX_OPTION_HISTORY" => "N",
				"AJAX_OPTION_JUMP" => "N",
				"AJAX_OPTION_STYLE" => "Y",
				"CACHE_FILTER" => $arParams["CACHE_FILTER"],
				"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
				"CACHE_TIME" => $arParams["CACHE_TIME"],
				"CACHE_TYPE" => $arParams["CACHE_TYPE"],
				"CHECK_DATES" => "Y",
				"DETAIL_URL" => "",
				"DISPLAY_BOTTOM_PAGER" => "N",
				"DISPLAY_DATE" => "Y",
				"DISPLAY_NAME" => "Y",
				"DISPLAY_PICTURE" => "Y",
				"DISPLAY_PREVIEW_TEXT" => "Y",
				"DISPLAY_TOP_PAGER" => "N",
				"FIELD_CODE" => array("",""),
				"FILTER_NAME" => "",
				"HIDE_LINK_WHEN_NO_DETAIL" => "N",
				"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
				"INCLUDE_SUBSECTIONS" => "Y",
				"MESSAGE_404" => "",
				"NEWS_COUNT" => "20",
				"PAGER_BASE_LINK_ENABLE" => "N",
				"PAGER_DESC_NUMBERING" => "N",
				"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
				"PAGER_SHOW_ALL" => "N",
				"PAGER_SHOW_ALWAYS" => "N",
				"PAGER_TEMPLATE" => ".default",
				"PAGER_TITLE" => "Новости",
				"PARENT_SECTION" => "",
				"PARENT_SECTION_CODE" => "",
				"PREVIEW_TRUNCATE_LEN" => "",
				"PROPERTY_CODE" => array("",""),
				"SET_BROWSER_TITLE" => "N",
				"SET_LAST_MODIFIED" => "N",
				"SET_META_DESCRIPTION" => "N",
				"SET_META_KEYWORDS" => "N",
				"SET_STATUS_404" => "N",
				"SET_TITLE" => "N",
				"SHOW_404" => "N",
				"SORT_BY1" => "ACTIVE_FROM",
				"SORT_BY2" => "SORT",
				"SORT_ORDER1" => "DESC",
				"SORT_ORDER2" => "ASC",
				"STRICT_SECTION_CHECK" => "N"
			)
	);?>

	
	</div>
	<div class="d-flex flex-column">
		<div class="container">
		<?$APPLICATION->IncludeComponent(
				"bitrix:catalog.smart.filter", 
				"smart_filter", 
				array(
					"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
					"CACHE_TIME" => $arParams["CACHE_TIME"],
					"CACHE_TYPE" => $arParams["CACHE_TYPE"],
					"CONVERT_CURRENCY" => $arParams["CONVERT_CURRENCY"],
					"DISPLAY_ELEMENT_COUNT" => "Y",
					"FILTER_NAME" => $arParams["FILTER_NAME"],
					"HIDE_NOT_AVAILABLE" => $arParams["HIDE_NOT_AVAILABLE"],
					"IBLOCK_ID" => $arParams["IBLOCK_ID"],
					"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
					"ID_HIGHLOAD" => $arParams['ID_HIGHLOAD'],
					"PAGER_PARAMS_NAME" => "arrPager",
					"PREFILTER_NAME" => "smartPreFilter",
					"PRICE_CODE" => $arParams["PRICE_CODE"],
					"SAVE_IN_SESSION" => "N",
					"INSTANT_RELOAD" => $arParams['INSTANT_RELOAD'],
					"SECTION_CODE" => "",
					"SECTION_DESCRIPTION" => "-",
					"SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
					"SECTION_TITLE" => "-",
					"SEF_MODE" => $arParams["SEF_MODE"],
					"SEF_FOLDER" => $arParams["SEF_FOLDER"],
					"SEF_URL_TEMPLATES" =>  $arParams["SEF_URL_TEMPLATES"],
					"XML_EXPORT" => "N",
					"COMPONENT_TEMPLATE" => "smart_filter",
					"SECTION_CODE_PATH" => $arParams['SEF_URL_TEMPLATES']['smart_filter'],
					"SMART_FILTER_PATH" => $_REQUEST["SMART_FILTER_PATH"]
				),
				$component
			);?>
		</div>
	<?
		$sort_result = array();
		if(!empty($_GET['sort_field'])){
			$sort_result = explode(' ',$_GET['sort_field']);
			$arParams["ELEMENT_SORT_FIELD"] =  $sort_result[0];
			$arParams["ELEMENT_SORT_ORDER"] = $sort_result[1];
		}
		if($_GET['available'] == 'all'){
			$arParams["HIDE_NOT_AVAILABLE"] = 'N';
		}
		else{
			$arParams["HIDE_NOT_AVAILABLE"] = 'Y';
		}
	?>

	
		<div class="catalog-section__wrapper">
			<?$APPLICATION->IncludeComponent(
				"bitrix:catalog.section",
				"",
				Array(
					"HIDE_NOT_AVAILABLE" => $arParams["HIDE_NOT_AVAILABLE"],
					"HIDE_NOT_AVAILABLE_OFFERS" => $arParams["HIDE_NOT_AVAILABLE_OFFERS"],
					"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
					"IBLOCK_ID" => $arParams["IBLOCK_ID"],
					"ELEMENT_SORT_FIELD" => $arParams["ELEMENT_SORT_FIELD"],
					"ELEMENT_SORT_ORDER" => $arParams["ELEMENT_SORT_ORDER"],
					"ELEMENT_SORT_FIELD2" => $arParams["ELEMENT_SORT_FIELD2"],
					"ELEMENT_SORT_ORDER2" => $arParams["ELEMENT_SORT_ORDER2"],
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
			?>
			
		</div>
	</div>
</div>

