<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Личный кабинет");
global $USER;?><div class="container">
	 <?$APPLICATION->IncludeComponent(
	"bitrix:breadcrumb",
	"breadcrumb",
	Array(
		"PATH" => "",
		"SITE_ID" => "s1",
		"START_FROM" => "0"
	)
);?>
<?if(!$USER->IsAuthorized()) // Для неавторизованного
{
    global $APPLICATION; 
	$favorites = unserialize($_COOKIE["favorites"]);
}
else {
     $idUser = $USER->GetID();
     $rsUser = CUser::GetByID($idUser);
     $arUser = $rsUser->Fetch();
     $favorites = $arUser['UF_FAVORITES'];
    
}

$GLOBALS['arrFilter']=Array("ID" => $favorites);

CModule::IncludeModule("iblock"); 
$arFilter = Array("IBLOCK_ID"=>33, "ACTIVE"=>"Y", "ID" => $favorites);
$res_count = CIBlockElement::GetList(Array(), $arFilter, Array(), false, Array('ID','IBLOCK_ID', "*"));

?>
</div>
<div class="container personal__wrapper">
<h1 class="personal__header">Личный кабинет</h1>
    <div class="tabs__wrapper">
        <div class="tabs__header-wrapper tabs__wrapper-desktop">
			<a class="tab__header" href="#orders" tab-id="orders"><h3 class="tab__h3">Заказы</h3> <div class="tab__header-arrow"></div></a>
			<a class="tab__header" href="#favorities" tab-id="favorities"><h3 class="tab__h3">Избранное</h3> <div class="tab__header-arrow"></div></a>
			<a class="tab__header" href="#personal-data" tab-id="personal-data"><h3 class="tab__h3">Персональные данные</h3> <div class="tab__header-arrow"></div></a>
			<?//<a class="tab__header" href="#personal-sale" tab-id="personal-sale"><h3 class="tab__h3">Персональная скидка</h3> <div class="tab__header-arrow"></div></a>?>
			<?if ($USER->IsAuthorized()):?>
			<a href="<?echo str_replace("personal/","",$APPLICATION->GetCurPageParam("logout=yes&".bitrix_sessid_get(), ["login","logout","register","forgot_password","change_password"]));?>"  class="back-catalog">ВЫХОД</a>
			<?endif;?>
        </div>
		<div class="tabs__header-wrapper tabs__header-slider tabs__header-wrapper-mobile ">
			<div class="swiper-wrapper">
				<div class="tab__header swiper-slide" tab-id="orders"><h3 class="tab__h3">Заказы</h3> <div class="tab__header-arrow"></div></div>

				<div class="tab__header swiper-slide" tab-id="favorities"><h3 class="tab__h3">Избранное</h3> <div class="tab__header-arrow"></div></div>

				<div class="tab__header swiper-slide" tab-id="personal-data"><h3 class="tab__h3">Персональные данные</h3> <div class="tab__header-arrow"></div></div>
				<?//<div class="tab__header swiper-slide" tab-id="personal-sale"><h3 class="tab__h3">Персональная скидка</h3> <div class="tab__header-arrow"></div></div>?>
				<?if ($USER->IsAuthorized()):?>
					<a href="<?echo str_replace("personal/","",$APPLICATION->GetCurPageParam("logout=yes&".bitrix_sessid_get(), ["login","logout","register","forgot_password","change_password"]));?>" class="swiper-slide back-catalog swiper-slide">ВЫХОД</a>
				<?endif;?>
			</div>
        </div>
        <div class="tabs__content-wrapper">
			<div class="tab__content" tab-id="orders">
				<?if ($USER->IsAuthorized()):?>
			<?$APPLICATION->IncludeComponent(
				"bitrix:sale.personal.order.list",
				"list",
				Array(
					"ACTIVE_DATE_FORMAT" => "d.m.Y",
					"CACHE_GROUPS" => "Y",
					"CACHE_TIME" => "3600",
					"CACHE_TYPE" => "A",
					"DEFAULT_SORT" => "DATE_INSERT",
					"DISALLOW_CANCEL" => "N",
					"HISTORIC_STATUSES" => array("TT"),
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
					"RESTRICT_CHANGE_PAYSYSTEM" => array("0"),
					"SAVE_IN_SESSION" => "Y",
					"SET_TITLE" => "N",
					"STATUS_COLOR_F" => "gray",
					"STATUS_COLOR_N" => "green",
					"STATUS_COLOR_P" => "yellow",
					"STATUS_COLOR_PSEUDO_CANCELLED" => "red"
				)
			);?>
			<?else:?>
				<a href="javascript:void(0)" class="gray-btn icons__person" style="margin:auto">Войти в аккаунт</a>
			<?endif;?>
			</div>
			<div class="tab__content" tab-id="favorities">
			<?if ($res_count > 0 and !empty($favorites)): ?> 
			<?$APPLICATION->IncludeComponent(
				"bitrix:catalog.section",
				"favorites3",
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
					"HIDE_NOT_AVAILABLE" => "N",
					"HIDE_NOT_AVAILABLE_OFFERS" => "N",
					"IBLOCK_ID" => "33",
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
					"OFFERS_FIELD_CODE" => array("",""),
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
					"PRICE_CODE" => array("BASE"),
					"PRICE_VAT_INCLUDE" => "Y",
					"PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons",
					"PRODUCT_DISPLAY_MODE" => "N",
					"PRODUCT_ID_VARIABLE" => "id",
					"PRODUCT_PROPS_VARIABLE" => "prop",
					"PRODUCT_QUANTITY_VARIABLE" => "quantity",
					"PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false}]",
					"PRODUCT_SUBSCRIPTION" => "Y",
					"PROPERTY_CODE_MOBILE" => array("SIZE","VENDOR_CODE","COLOR"),
					"RCM_PROD_ID" => $_REQUEST["PRODUCT_ID"],
					"RCM_TYPE" => "personal",
					"SECTION_CODE" => "",
					"SECTION_ID" => $_REQUEST["SECTION_ID"],
					"SECTION_ID_VARIABLE" => "SECTION_ID",
					"SECTION_URL" => "",
					"SECTION_USER_FIELDS" => array("",""),
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
			);?><?else:?> <?$APPLICATION->SetTitle("В избранном пусто");?> <a href="/katalog/" class="gray-btn" style="margin:auto">Начать покупки</a> <?endif;?>
			</div>
			<div class="tab__content" tab-id="personal-data">
				<?/*$APPLICATION->IncludeComponent(
					"bitrix:main.profile",
					"",
					Array(
						"AJAX_MODE" => $arParams["AJAX_MODE_PRIVATE"],
						"CHECK_RIGHTS" => "N",
						"EDITABLE_EXTERNAL_AUTH_ID" => $arParams["EDITABLE_EXTERNAL_AUTH_ID"],
						"SEND_INFO" => "N",
						"SET_TITLE" => "N",
						"USER_PROPERTY" => "",
						"USER_PROPERTY_NAME" => ""
					)
				);*/?>
				<?if($USER->IsAuthorized()):?>
					<form method="post" class="tab__form user_form" name="form1" action="<?=$arResult["FORM_TARGET"]?>" enctype="multipart/form-data">
					<?
					$rsUser = CUser::GetByID($USER->GetID());
					$arUser = $rsUser->Fetch();

					?>
						<input type="hidden" name="ID" value=<?=$arUser["ID"]?> />
						<div class="content__input">
							<span class="input__header">Фамилия</span>
							<input class="input" type="text" name="LAST_NAME" value="<?=$arUser["LAST_NAME"]?>" />
							<div class="imformer"></div>
						</div>
						<div class="content__input">
							<span class="input__header">Имя</span>
							<input class="input" type="text" name="NAME" value="<?=$arUser["NAME"]?>" />
							<div class="imformer"></div>
						</div>
						<div class="content__input">
							<span class="input__header">Отчество</span>
							<input class="input" type="text" name="SECOND_NAME" value="<?=$arUser["SECOND_NAME"]?>" />
							<div class="imformer"></div>	
						</div>
						<div class="content__input">
							<span class="input__header">E-mail</span>
							<input class="input" type="text" name="EMAIL" value="<?=$arUser["EMAIL"]?>" />
							<div class="imformer"></div>
						</div>
						<div class="content__input">
							<span class="input__header">Телефон</span>
							<input class="input" type="tel" name="PERSONAL_PHONE" value="<?=$arUser["PERSONAL_PHONE"]?>" /> 
							<div class="imformer"></div>
						</div>
					</form>
					<a id="change-pass" class="arrow-link">Изменить пароль</a>
				<?else:?>
					<a href="javascript:void(0)" class="gray-btn icons__person" style="margin:auto">Войти в аккаунт</a>
				<?endif;?>
			</div>

			<?/*
				<div class="tab__content" tab-id="personal-sale">
				<?
				if (CModule::IncludeModule("sale")):

				$arFilter = array('PAYED' => 'Y');
				$rsSales = CSaleOrder::GetList(array("DATE_INSERT" => "ASC"), $arFilter, array('SUM' => 'PRICE', 'SUM_PAID'));
				$sum=0;
				while ($arSales = $rsSales->Fetch())
						$sum+=$arSales['SUM_PAID'];
				
				endif;
				$sum=round($sum);
				if ($sum<150000) {
					$sale=5;
				}elseif($sum>=150000 and $sum<300000){
					$sale=10;
				}else{
					$sale=15;
				}
				?>
					<div class="peronal_sale">
						<h2>Ваша персональная скидка</h2>
						<div class="peronal_sale_summ">
							<div class="peronal_sale_percent"><?=$sale?>%</div>
							<div>Общая сумма покупок <?=$sum?> ₽</div>
						</div>
						<hr>
						<div class="peronal_sale_text">
							<span>Размер скидки зависит от общей суммы совершенных покупок</span>
							<div>От 1 до 150 000 ₽ — скидка 5%<br>
							От 150 001 до 300 000 ₽ — скидка 10%<br>
							От 300 001 до 600 000 ₽ — скидка 15%</div>
						</div>
						<a href="/katalog/" class="gray-btn gray-with-bag"><div class="element__bag"></div>За покупками</a>	
					</div>				
			*/?></div>
        </div>
    </div>
</div>

<div class="detail-PopUp">
	<div class="detail-PopUp-back"></div>
	<div class="detail-PopUp-content">
		<div class="detail-PopUp-close"></div>
		<div class="detail-PopUp-title">Изменить пароль</div>
			<?$APPLICATION->IncludeComponent(
				"bitrix:main.profile",
				"change_pass",
				Array(
					"CHECK_RIGHTS" => "N",
					"SEND_INFO" => "Y",
					"SET_TITLE" => "N",
					"USER_PROPERTY" => "",
					"USER_PROPERTY_NAME" => ""
				)
			);?>
	</div>
	<div class="detail-PopUp-content detail-PopUp-content-success">
		<div class="detail-PopUp-close"></div>
		<div class="detail-PopUp-title detail-PopUp-title_success">Пароль изменён</div>
		<div class="detail-PopUp-circle">
			<div class="detail-PopUp-key"></div>
		</div>
	</div>
</div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>