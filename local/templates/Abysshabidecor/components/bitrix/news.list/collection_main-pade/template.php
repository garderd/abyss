<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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
$this->setFrameMode(true);
?>

<?//debug(count($arResult["ITEMS"]));?>
<div class="collection-container">
	<div class="catalog-collection-slider">
		<div class="header align-items-center d-flex justify-content-between">
			<h3>Коллекции</h3>
			<div class="arrows d-flex ">
				<div class="button button-prev">
					<div class="arrow-left"></div>
				</div>
				<div class="button button-next">
					<div class="arrow-right"></div>
				</div>
			</div>
		</div>
		<div class="swiper-wrapper">
			<?foreach($arResult['SECTIONS'] as $arCollection):?>
			<? if($arCollection['DEPTH_LEVEL'] != 1):?>
			<div class="swiper-slide collection" id="<?=$this->GetEditAreaId($arCollection['ID']);?>">
				<a href="<?=$arCollection['SECTION_PAGE_URL']?>">
					<div class="img-wrapper">
						<img src="<?=CFile::GetPath($arCollection['PICTURE'])?>" alt="<?=$arCollection['NAME']?>">
					</div>
					<span><?=$arCollection['NAME']?></span>
				</a>
			</div>
			<?endif;?>
			<?endforeach;?>
		</div>
		<?/*<div class="catalog-collection-slider-pagination"></div>*/?>
	</div>
</div>
