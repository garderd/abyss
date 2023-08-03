<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
$i = 0
?>


<div class="catalog-list-catalog-page">
	<div class="container">
		<div class="row catalog-link-wrapper">
		<?
		foreach($arResult["SECTIONS"] as $arSection):
			$this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], CIBlock::GetArrayByID($arSection["IBLOCK_ID"], "SECTION_EDIT"));
			$this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], CIBlock::GetArrayByID($arSection["IBLOCK_ID"], "SECTION_DELETE"), array("CONFIRM" => GetMessage('CT_BCSL_ELEMENT_DELETE_CONFIRM')));
			if($arSection["DEPTH_LEVEL"] == 1):?>
			<div <?if($i == 0 || $i == 1){echo 'class="col-12 col-lg-6"';}else{echo 'class="col-12 col-lg-6"';};?> id="<?=$this->GetEditAreaId($arSection['ID']);?>">
				<a class="catalog-page__link" href="<?=$arSection["SECTION_PAGE_URL"]?>">
					<div class="img-wrapper">
						<img class="catalog-page__img" src="<?=CFile::GetPath($arSection['PICTURE']['ID'])?>" alt="<?=$arSection["NAME"]?>">
					</div>
					<span><?=$arSection["NAME"]?></span>
				</a>
			</div>
			<?
				endif;
				$i++;
			?>
			
		<?endforeach?>
		</div>
	</div>
</div>
