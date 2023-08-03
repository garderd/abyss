<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
$arResult["ORDER_BY_STATUS"] = Array();
foreach($arResult["ORDERS"] as $val)
{
	$arResult["ORDER_BY_STATUS"][$val["ORDER"]["STATUS_ID"]][] = $val;
}


foreach($arResult["ORDERS"] as $key => $order){
	$dbRes = \Bitrix\Sale\PropertyValueCollection::getList([
		'select' => ['*'],
		'filter' => ['=ORDER_ID' => $order["ORDER"]['ID'],"=CODE" => "PUNKT_SDEK" ]
	]);
	if($item = $dbRes->fetch()){
		$arResult['ORDERS'][$key]["ORDER"]["PUNKT_SDEK"] = $item;
	}
}



?><pre>
<?//print_r($arResult['ORDERS']);?>
</pre>