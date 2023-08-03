<?

	$arFilter = array('IBLOCK_ID' => $arParams['IBLOCK_ID'], 'ACTIVE' => 'Y');
   	$rsSect = CIBlockSection::GetList(array('sort'=>'asc'), $arFilter, false, array("DEPTH_LEVEL","NAME","SECTION_PAGE_URL","PICTURE","ID","CODE"), array("nPageSize" => $arParams["SECTION_COUNT"]));
   	while ($arSect = $rsSect->GetNext())
   	{
		$arResult['SECTIONS'][] = $arSect;
	}
	
?>
