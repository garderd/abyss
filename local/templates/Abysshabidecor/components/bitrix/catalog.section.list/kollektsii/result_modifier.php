<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
foreach($arResult['SECTIONS'] as $key => $arSection){
	if($arSection['DEPTH_LEVEL'] == 1){
		$rsParentSection = CIBlockSection::GetByID($arSection['ID']);
		if ($arParentSection = $rsParentSection->GetNext())
		{
			$arFilter = array('IBLOCK_ID' => $arParentSection['IBLOCK_ID'],'>LEFT_MARGIN' => $arParentSection['LEFT_MARGIN'],'<RIGHT_MARGIN' => $arParentSection['RIGHT_MARGIN'],'>DEPTH_LEVEL' => $arParentSection['DEPTH_LEVEL']);
			$rsSect = CIBlockSection::GetList(array('left_margin' => 'asc'),$arFilter);
			while ($arSect = $rsSect->GetNext())
			{		$arSect['CODE'] = $arSection['CODE'];
					$arResult['SECTIONS_CHILD'][] = $arSect;
					$arResult["SECTIONS_CHILD"]["COUNT"] = count($arSect);
			}
		}
	}
}
?>