<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/**
 * @var array $arParams
 * @var array $arResult
 * @var SaleOrderAjax $component
 */


 
$component = $this->__component;
$component::scaleImages($arResult['JS_DATA'], $arParams['SERVICES_IMAGES_SCALING']);
$ORDER_ID = $arResult['ORDER_ID'];



$dbRes = \Bitrix\Sale\PropertyValueCollection::getList([
    'select' => ['*'],
    'filter' => [
        '=ORDER_ID' => $ORDER_ID, 
    ]
]);

while ($item = $dbRes->fetch())
{
    if($item['CODE'] == "LOCATION"){
        $arResult["ORDER"]["ORDER_PROPERTY"][$item['CODE']] = CSaleLocation::GetByID($item['VALUE']);
    }
    else{
        $arResult["ORDER"]["ORDER_PROPERTY"][$item['CODE']] = $item;
    }
}



$arBasketItems = array();

$dbBasketItems = CSaleBasket::GetList(
        array(
                "NAME" => "ASC",
                "ID" => "ASC"
            ),
        array(
                "FUSER_ID" => CSaleBasket::GetBasketUserID(),
                "LID" => SITE_ID,
                "ORDER_ID" => $ORDER_ID
            ),
        false,
        false,
        array("ID", "CALLBACK_FUNC", "MODULE", 
              "PRODUCT_ID", "QUANTITY", "DELAY", 
              "CAN_BUY", "PRICE", "WEIGHT")
    );
while ($arItems = $dbBasketItems->Fetch())
{
    if (strlen($arItems["CALLBACK_FUNC"]) > 0)
    {
        CSaleBasket::UpdatePrice($arItems["ID"], 
                                 $arItems["CALLBACK_FUNC"], 
                                 $arItems["MODULE"], 
                                 $arItems["PRODUCT_ID"], 
                                 $arItems["QUANTITY"]);
        $arItems = CSaleBasket::GetByID($arItems["ID"]);
    }

    $arBasketItems[] = $arItems;
}

$quantity = 0;
$weight = 0;

foreach($arBasketItems as $BasketItem){
    $quantity += $BasketItem['QUANTITY'];
    $weight += $BasketItem['WEIGHT'];
}

$arResult['ORDER']['ORDER_PROPERTY']['TOVARS']['QUANTITY'] = $quantity;
$arResult['ORDER']['ORDER_PROPERTY']['TOVARS']['WEIGHT'] = round($weight / 1000, 2) . "кг";

$arResult['ORDER']['ORDER_PROPERTY']['TOVAR'] = $arBasketItems;



?>

