<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
?>
<div class="search-page">
	<div class="container">
		<? $APPLICATION->IncludeComponent(
			"bitrix:breadcrumb",
			"breadcrumb",
			array(
				"PATH" => "",
				"SITE_ID" => "s1",
				"START_FROM" => "0"
			)
		); ?>
	</div>
	<h1 class="contacts__h1">Поиск</h1>
	<div class="container">
		<form class="search-page-form" action="" method="get">

			<input type="hidden" name="tags" value="<? echo $arResult["REQUEST"]["TAGS"] ?>" />
			<input type="hidden" name="how" value="<? echo $arResult["REQUEST"]["HOW"] == "d" ? "d" : "r" ?>" />
			<? if ($arParams["USE_SUGGEST"] === "Y") :
				if (mb_strlen($arResult["REQUEST"]["~QUERY"]) && is_object($arResult["NAV_RESULT"])) {
					$arResult["FILTER_MD5"] = $arResult["NAV_RESULT"]->GetFilterMD5();
					$obSearchSuggest = new CSearchSuggest($arResult["FILTER_MD5"], $arResult["REQUEST"]["~QUERY"]);
					$obSearchSuggest->SetResultCount($arResult["NAV_RESULT"]->NavRecordCount);
				}
			?>
				<? $APPLICATION->IncludeComponent(
					"bitrix:search.suggest.input",
					"",
					array(
						"NAME" => "q",
						"VALUE" => $arResult["REQUEST"]["~QUERY"],
						"INPUT_SIZE" => 59,
						"DROPDOWN_SIZE" => 50,
						"FILTER_MD5" => $arResult["FILTER_MD5"],
					),
					$component,
					array("HIDE_ICONS" => "Y")
				); ?>
			<? else : ?>
				<input class="search-query" type="text" name="q" value="<?= $arResult["REQUEST"]["QUERY"] ?>" />
			<? endif; ?>

			<input class="gray-btn" type="submit" value="Найти" />
		</form>
	</div>
	<? if (isset($arResult["REQUEST"]["ORIGINAL_QUERY"])) :
	?>
		<div class="search-language-guess">
			<? echo GetMessage("CT_BSP_KEYBOARD_WARNING", array("#query#" => '<a href="' . $arResult["ORIGINAL_QUERY_URL"] . '">' . $arResult["REQUEST"]["ORIGINAL_QUERY"] . '</a>')) ?>
		</div><br /><?
				endif; ?>
	<div class="search-result container">
		<? if ($arResult["REQUEST"]["QUERY"] === false && $arResult["REQUEST"]["TAGS"] === false) : ?>
		<? elseif ($arResult["ERROR_CODE"] != 0) : ?>
			<h2 class="h2">Пустой поисковой запрос</h2>
		<? elseif (count($arResult["SEARCH"]) > 0) : ?>
			<? if ($arParams["DISPLAY_TOP_PAGER"] != "N") echo $arResult["NAV_STRING"] ?>
			<br />
			<div class="container catalog-section__element-wrapper">
				<div class="row row-cols-2 row-cols-md-3 row-cols-lg-4">
					<? foreach ($arResult["SEARCH"] as $arItem) : ?>
						<div class="catalog-section__element">
							<div class="section-element__border">
								<a class="section-element__link" href="<?= $arItem["URL"] ?>" title="<?= $arItem["TITLE"] ?>">
									<? if (isset($arItem["PREVIEW_PICTURE"]) && $arItem["PREVIEW_PICTURE"] != "") : ?>
										<img class="section-element__img" src="<?=  $arItem["PREVIEW_PICTURE"] ?>" alt="<?= $arItem["TITLE"] ?>">
									<? else : ?>
										<img class="section-element__img" src="<?= SITE_TEMPLATE_PATH ?>/assets/img/no_photo.webp" alt="<?= $arItem["TITLE"] ?>">
									<? endif; ?>
									<span class="section-element__name"><?= $arItem["TITLE"] ?></span>
								</a>
								<? if( isset($arItem['QUANTITY']) && $arItem['QUANTITY'] == "0" && $arItem['PRICE']): ?>
									<p class='section-element__price'><?= $arItem['PRICE'] ?></p>
									<p class='section-element__price'>Под заказ</p>
								<? elseif(isset($arItem['PRICE'])): ?>
								<p class="section-element__price"><?=$arItem['PRICE']?></p>
								<? endif; ?>
								<div class="catalog-section__button-favorite" id-el="<?= $arItem['ID'] ?>"></div>
							</div>
						</div>
					<? endforeach; ?>
				</div>
			</div>
			<? if ($arParams["DISPLAY_BOTTOM_PAGER"] != "N") echo $arResult["NAV_STRING"] ?>
			<br />
			<p class="search-sorted">
				<? if ($arResult["REQUEST"]["HOW"] == "d") : ?>
					<a href="<?= $arResult["URL"] ?>&amp;how=r<? echo $arResult["REQUEST"]["FROM"] ? '&amp;from=' . $arResult["REQUEST"]["FROM"] : '' ?><? echo $arResult["REQUEST"]["TO"] ? '&amp;to=' . $arResult["REQUEST"]["TO"] : '' ?>"><?= GetMessage("SEARCH_SORT_BY_RANK") ?></a>&nbsp;|&nbsp;<b><?= GetMessage("SEARCH_SORTED_BY_DATE") ?></b>
				<? else : ?>
					<b><?= GetMessage("SEARCH_SORTED_BY_RANK") ?></b>&nbsp;|&nbsp;<a href="<?= $arResult["URL"] ?>&amp;how=d<? echo $arResult["REQUEST"]["FROM"] ? '&amp;from=' . $arResult["REQUEST"]["FROM"] : '' ?><? echo $arResult["REQUEST"]["TO"] ? '&amp;to=' . $arResult["REQUEST"]["TO"] : '' ?>"><?= GetMessage("SEARCH_SORT_BY_DATE") ?></a>
				<? endif; ?>
			</p>
		<? else : ?>
			<h2 class="h2">К сожалению, на ваш поисковый запрос ничего не найдено.</h2>
		<? endif; ?>
	</div>
</div>
<script type="text/javascript">
	$('.search-page-form .search-query').each(function() {
		$(this).attr('placeholder', "Найти...");
	});
</script>