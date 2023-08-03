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

    <?foreach($arResult["ITEMS"] as $arItem):?>
    <?
		$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
		?>
    <div class="video__item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
        <video poster="<?=$arItem['PREVIEW_PICTURE']['SRC'] ?>">
            <source src="<?=$arItem['PROPERTIES']['VIDEO']['VALUE']['path']?>">
        </video>
		<div class="video__content">
			<h3 class="video__header">
				<?=$arItem['PROPERTIES']['VIDEO']['VALUE']['title']?>
			</h3>
			<span class="video__description">
				<?=$arItem['PROPERTIES']['VIDEO']['VALUE']['desc']?>
			</span>
			<div class="video__item circle">
				<img src="<?=SITE_TEMPLATE_PATH?>/assets/img/icons/triangle.svg" alt="play">
			</div>
		</div>
    </div>
    <?endforeach;?>