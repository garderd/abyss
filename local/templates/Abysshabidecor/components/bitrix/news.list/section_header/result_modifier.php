<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
	$arFilter = array('IBLOCK_ID' => $arParams['IBLOCK_ID'], 'ACTIVE' => 'Y','CODE' => $arParams['SECTION_CODE']);
	$arSelect = array();
	$rsSect = CIBlockSection::GetList(array('sort'=>'asc'),$arFilter,false);
   	while ($arSect = $rsSect->GetNext())
   	{
		$arResult['SECTIONS'][] = $arSect;
	}
	unset($arFilter);
	unset($arSelect);
	unset($rsSect);


	$rsParentSection = CIBlockSection::GetByID($arParams['SECTION_ID']);
	if ($arParentSection = $rsParentSection->GetNext())
	{
		$arFilter = array('IBLOCK_ID' => $arParentSection['IBLOCK_ID'],'>LEFT_MARGIN' => $arParentSection['LEFT_MARGIN'],'<RIGHT_MARGIN' => $arParentSection['RIGHT_MARGIN'],'>DEPTH_LEVEL' => $arParentSection['DEPTH_LEVEL']); // выберет потомков без учета активности
		$rsSect = CIBlockSection::GetList(array('left_margin' => 'asc'),$arFilter);
		while ($arSect = $rsSect->GetNext())
		{
				$arResult['SECTIONS']['SECTIONS_CHILD'][] = $arSect;
		}
	}

	$arResult['COUNT_SLASH'] = substr_count($arParams['PATH'],'/');
?>
