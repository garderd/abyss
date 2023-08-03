<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Поиск");?>


<?$APPLICATION->IncludeComponent(
	"bitrix:search.page", 
	"search-page-abyss", 
	array(
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_SHADOW" => "Y",
		"AJAX_OPTION_STYLE" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"CHECK_DATES" => "Y",
		"DEFAULT_SORT" => "rank",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"DISPLAY_TOP_PAGER" => "N",
		"FILTER_NAME" => "",
		"NO_WORD_LOGIC" => "Y",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => "ajaxButtonSearch",
		"PAGER_TITLE" => "Результаты поиска",
		"PAGE_RESULT_COUNT" => "16",
		"PATH_TO_USER_PROFILE" => "",
		"RATING_TYPE" => "",
		"RESTART" => "Y",
		"SHOW_ITEM_DATE_CHANGE" => "Y",
		"SHOW_ITEM_TAGS" => "Y",
		"SHOW_ORDER_BY" => "Y",
		"SHOW_RATING" => "",
		"SHOW_TAGS_CLOUD" => "N",
		"SHOW_WHEN" => "N",
		"SHOW_WHERE" => "N",
		"TAGS_INHERIT" => "Y",
		"USE_LANGUAGE_GUESS" => "Y",
		"USE_SUGGEST" => "N",
		"USE_TITLE_RANK" => "Y",
		"arrFILTER" => array(
			0 => "iblock_1c_catalog",
		),
		"arrFILTER_iblock_catalog" => array(
			0 => "all",
		),
		"arrWHERE" => "",
		"COMPONENT_TEMPLATE" => "search-page-abyss",
		"arrFILTER_iblock_1c_catalog" => array(
			0 => "33",
		),
		"arrFILTER_blog" => array(
			0 => "all",
		)
	),
	false
);?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>