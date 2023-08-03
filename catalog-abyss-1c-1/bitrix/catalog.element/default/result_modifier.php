<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
// подключаем пространство имен класса HighloadBlockTable и даём ему псевдоним HLBT для удобной работы


use Bitrix\Highloadblock\HighloadBlockTable as HLBT;


/*Удобненько выбираем текущее ТП*/

if ($_GET['razmer'] and $arResult["OFFERS"]) {
    //Если есть гет параметр
    foreach ($arResult["OFFERS"] as $key => $arOffer) {
        if ($arOffer["PROPERTIES"]["SIZE"]['VALUE'] == $_GET['razmer']) {
            $arResult['mainOffer']['KEY'] = $key;
            $arResult['mainOffer']['ID'] = $arOffer["ID"];
            $arResult['mainOffer']['RAZMER'] = $arOffer["PROPERTIES"]["SIZE"]['VALUE'];
            $arResult['ITEM'] = $arOffer;
            if ($arOffer["PRICES"]["BASE"]["DISCOUNT_VALUE"] < $arOffer["PRICES"]["BASE"]["VALUE"]) {
                $arResult["ITEM_PRICES"]["VALUE"] = $arOffer["PRICES"]["BASE"]["PRINT_VALUE"];
                $arResult["ITEM_PRICES"]["DISCOUNT_VALUE"] = $arOffer["PRICES"]["BASE"]["PRINT_DISCOUNT_VALUE"];
            } else {
                $arResult["ITEM_PRICES"]["VALUE"] = $arOffer["PRICES"]["BASE"]["PRINT_VALUE"];
            }
            $arResult["ITEM_PRICES"]["CAN_BUY"] = $arOffer["CATALOG_CAN_BUY_ZERO"];
            break;
        }
    }
} else if ($arResult["OFFERS"]) {
    //Если нет гет параметра, но есть оферы
    foreach ($arResult["OFFERS"] as $key => $arOffer) :
        if ($arOffer["CAN_BUY"] == "") {
            $arOffer["CAN_BUY"] = $arOffer["CATALOG_CAN_BUY_ZERO"];
        };
        if ($arOffer["CAN_BUY"] == "Y") {
            $arResult['mainOffer']['ID'] = $arOffer["ID"];
            $arResult['mainOffer']['KEY'] = $key;
            $arResult['mainOffer']['RAZMER'] = $arOffer["PROPERTIES"]["SIZE"]['VALUE'];
            $arResult['ITEM'] = $arOffer;
            //цены в один массивчик
            if ($arOffer["PRICES"]["BASE"]["DISCOUNT_VALUE"] < $arOffer["PRICES"]["BASE"]["VALUE"]) {
                $arResult["ITEM_PRICES"]["VALUE"] = $arOffer["PRICES"]["BASE"]["PRINT_VALUE"];
                $arResult["ITEM_PRICES"]["DISCOUNT_VALUE"] = $arOffer["PRICES"]["BASE"]["PRINT_DISCOUNT_VALUE"];
            } else {
                $arResult["ITEM_PRICES"]["VALUE"] = $arOffer["PRICES"]["BASE"]["PRINT_VALUE"];
            }
            $arResult["ITEM_PRICES"]["CAN_BUY"] = $arOffer["CATALOG_CAN_BUY_ZERO"];
            break;
        }
    endforeach;
} else {
    //Если товар без ТП
    $arResult['ITEM'] = $arResult;
    foreach ($arResult["PRICES"] as $code => $arPrice) :
        if ($arPrice["DISCOUNT_VALUE"] < $arPrice["VALUE"]) {
            $arResult["ITEM_PRICES"]["VALUE"] = $arPrice["PRINT_VALUE"];
            $arResult["ITEM_PRICES"]["DISCOUNT_VALUE"] = $arPrice["PRINT_DISCOUNT_VALUE"];
        } else {
            $arResult["ITEM_PRICES"]["VALUE"] = $arPrice["PRINT_VALUE"];
        }
        $arResult["ITEM_PRICES"]["CAN_BUY"] = $arPrice["CAN_BUY"];
        break;
    endforeach;
}


/*Проверяем, есть ли в корзине */
\Bitrix\Main\Loader::includeModule('sale');

$siteId = 's1';
$fUserId = CSaleBasket::GetBasketUserID();

$productId = $arResult['ITEM']['ID'];


$productByBasketItem = null;
$arResult["IN_CART"] = false;

$basket = \Bitrix\Sale\Basket::loadItemsForFUser($fUserId, $siteId);
$basketItems = $basket->getBasketItems();

$busket = array();

if ($basketItems) {
    foreach ($basketItems as $basketItem) {

        if ($basketItem->getField('PRODUCT_ID') == $productId) {

            $productByBasketItem = $basketItem;
            $arResult["IN_CART_QUANTITY"] = (int) $basketItem->getField('QUANTITY');
            $arResult["IN_CART"] = true;
            break;
        }
    }
}
if (!$arResult["DETAIL_PICTURE"]["SRC"]) {
    $arResult["DETAIL_PICTURE"]["SRC"] = $arResult["PREVIEW_PICTURE"]["SRC"];
}


//подключаем модуль highloadblock
CModule::IncludeModule('highloadblock');
//Напишем функцию получения экземпляра класса:


function GetEntityDataClass($HlBlockId)
{
    if (empty($HlBlockId) || $HlBlockId < 1) {
        return false;
    }
    $hlblock = HLBT::getById($HlBlockId)->fetch();
    $entity = HLBT::compileEntity($hlblock);
    $entity_data_class = $entity->getDataClass();
    return $entity_data_class;
}


$entity_data_class = GetEntityDataClass(2);
$rsData = $entity_data_class::getList(array(
    'select' => array('*'),
    "order" => array("UF_SORT" => "ASC"),
    'filter' => array("UF_CODE_LIST" => $arResult["PROPERTIES"]["TSVET_IZDELIYA"]["VALUE"]),
));

while ($el = $rsData->fetch()) {
    if ($arResult["PROPERTIES"]["TSVET"]["VALUE"] == $el['UF_XML_ID']) {
        $arResult["PROPERTIES"]["TSVET"]['INFO'] = $el;
    }
    $arResult["PROPERTIES"]["COLOR_NAME"] = $el["UF_NAME"];
}


//достаём товары у которых отличается только цвет для того чтобы вывести ссылки на них

if (   isset($arResult["PROPERTIES"]["ARTIKUL_ANGL"]["VALUE"]) && $arResult["PROPERTIES"]["ARTIKUL_ANGL"]["VALUE"] != "" 
    && isset($arResult["PROPERTIES"]["ARTIKUL_ANGL"]["VALUE"]) && $arResult["PROPERTIES"]["ARTIKUL_ANGL"]["VALUE"] != ""
    && isset($arResult["PROPERTIES"]["ARTIKUL_ANGL"]["VALUE"]) && $arResult["PROPERTIES"]["ARTIKUL_ANGL"]["VALUE"] != ""
){
    $arSelect = array("ID", "IBLOCK_ID", "NAME", "DETAIL_PAGE_URL", "PROPERTY_ARTIKUL_ANGL", "PROPERTY_NAIMENOVANIE_ANGL", "PROPERTY_RAZMER", "PROPERTY_TSVET_IZDELIYA");
    $arFilter = array(
        "IBLOCK_ID" => $arParams['IBLOCK_ID'],
        "ACTIVE_DATE" => "Y",
        "ACTIVE" => "Y",
        "PROPERTY_ARTIKUL_ANGL" => $arResult["PROPERTIES"]["ARTIKUL_ANGL"]["VALUE"],
        "PROPERTY_NAIMENOVANIE_ANGL" => $arResult["PROPERTIES"]["NAIMENOVANIE_ANGL"]["VALUE"],
        "PROPERTY_RAZMER" => $arResult["PROPERTIES"]["RAZMER"]["VALUE"],
    );
    $res = CIBlockElement::GetList(array(), $arFilter, false, false, $arSelect);

    while ($ob = $res->GetNextElement()) {
        $arFields = $ob->GetFields();
        $rsColorCircleLink["NAME"] = $arFields["NAME"];
        $rsColorCircleLink["ID"] = $arFields["ID"];
        $rsColorCircleLink['LINK'] = $arFields['DETAIL_PAGE_URL'];
        $rsColorCircleLink['COLOR_CODE'] = $arFields['PROPERTY_TSVET_IZDELIYA_VALUE'];

        $entity_data_class = GetEntityDataClass(2);
        $rsData = $entity_data_class::getList(array(
            'select' => array('*'),
            "order" => array("UF_SORT" => "ASC"),
            'filter' => array("UF_CODE_LIST" => $arFields["PROPERTY_TSVET_IZDELIYA_VALUE"]),
        ));

        while ($el = $rsData->fetch()) {
            $rsColorCircleLink['COLOR_NAME'] = $el['UF_NAME'];
            if (isset($el['UF_COLOR'])) {
                $rsColorCircleLink['HEX_CODE'] = $el['UF_COLOR'];
            }
            if (isset($el['UF_IMAGE'])) {
                $rsColorCircleLink['COLOR_IMAGE'] = $el['UF_IMAGE'];
            }
        }
        $arResult['COLOR_CIRCLE_LINK'][] = $rsColorCircleLink;
    }
}
else{
    $arResult['COLOR_CIRCLE_LINK'] = array();
}




//достаём товары у которых отличается только размер для того чтобы вывести ссылки на них 

if (
    isset($arResult["PROPERTIES"]["ARTIKUL_ANGL"]["VALUE"]) && $arResult["PROPERTIES"]["ARTIKUL_ANGL"]["VALUE"] != ""
    && isset($arResult["PROPERTIES"]["NAIMENOVANIE_ANGL"]["VALUE"]) && $arResult["PROPERTIES"]["NAIMENOVANIE_ANGL"]["VALUE"] != ""
    && isset($arResult["PROPERTIES"]["TSVET_IZDELIYA"]["VALUE"]) && $arResult["PROPERTIES"]["TSVET_IZDELIYA"]["VALUE"] != ""
) {
    $arSelect = array("ID", "IBLOCK_ID", "NAME", "DETAIL_PAGE_URL", "PROPERTY_ARTIKUL_ANGL", "PROPERTY_NAIMENOVANIE_ANGL", "PROPERTY_RAZMER", "PROPERTY_TSVET_IZDELIYA");
    $arFilter = array(
        "IBLOCK_ID" => $arParams['IBLOCK_ID'],
        "ACTIVE_DATE" => "Y",
        "ACTIVE" => "Y",
        "PROPERTY_ARTIKUL_ANGL" => $arResult["PROPERTIES"]["ARTIKUL_ANGL"]["VALUE"],
        "PROPERTY_NAIMENOVANIE_ANGL" => $arResult["PROPERTIES"]["NAIMENOVANIE_ANGL"]["VALUE"],
        "PROPERTY_TSVET_IZDELIYA" => $arResult["PROPERTIES"]["TSVET_IZDELIYA"]["VALUE"],
    );
    $res = CIBlockElement::GetList(array(), $arFilter, false, false, $arSelect);

    while ($ob = $res->GetNextElement()) {
        $arFields = $ob->GetFields();
        $rsSizeLink["NAME"] = $arFields["PROPERTY_RAZMER_VALUE"];
        $rsSizeLink["ID"] = $arFields["ID"];
        $rsSizeLink['LINK'] = $arFields['DETAIL_PAGE_URL'];
        $arResult['SIZE_LINK'][] = $rsSizeLink;
    }
} else {
    $arResult['SIZE_LINK'] = array();
}

foreach ($arResult["COLOR_CIRCLE_LINK"] as $key => $arColorCircle) {
    if ($arColorCircle['ID'] == $arResult['ID']) {
        $arResult["COLOR_CIRCLE_LINK"][$key]['ACTIVE'] = 'Y';
    }
}




foreach ($arResult['SIZE_LINK'] as $key => $arSize) {
    $separator = preg_replace('/[0-9]+/', '', $arSize["NAME"]);
    if (!empty($separator)) {
        $arResult['SIZE_LINK'][$key]['PROIZV_SIZE_VALUE'] = array_product(explode($separator, $arSize["NAME"]));
    }
}
if (isset($arResult['SIZE_LINK']) && $arResult['SIZE_LINK'] != "") {
    usort($arResult['SIZE_LINK'], function ($a, $b) { //сортируем предложения по произведению длины и ширины размера
        return ($a['PROIZV_SIZE_VALUE'] - $b['PROIZV_SIZE_VALUE']);
    });
}
$SectList = CIBlockSection::GetList(array("SORT" => "ASC"), array("IBLOCK_ID" => $arParams["IBLOCK_ID"], "ACTIVE" => "Y"), false, array("ID", "IBLOCK_ID", "IBLOCK_TYPE_ID", "IBLOCK_SECTION_ID", "CODE", "SECTION_ID", "NAME", "SECTION_PAGE_URL"));
while ($SectListGet = $SectList->GetNext()) {
    if ($SectListGet['CODE'] == $arResult['ORIGINAL_PARAMETERS']['SECTION_CODE'])
        $arResult["THIS_SECTION"] = $SectListGet;
}
