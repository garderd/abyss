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
<div class="o-nas-new">

<?foreach($arResult["ITEMS"] as $arItem):?>
<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>

	<div class="o-nas-item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
	<h2 class="o-nas-item__header-mobile"><?=$arItem['NAME']?></h2>
		<div class="container o-nas-item__content">
			<div>
				<h2 class="o-nas-item__header-desktop"><?=$arItem['NAME']?></h2>
				<div>
					<?=$arItem['~PREVIEW_TEXT']?>
				</div>
			</div>
			<img src="<?=CFile::GetPath($arItem['PROPERTIES']['IMAGE']['VALUE']);?>">			
		</div>
	</div>

<?endforeach;?>

</div>


