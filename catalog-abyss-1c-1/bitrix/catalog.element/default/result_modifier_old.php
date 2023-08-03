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





//подключаем модуль highloadblock
CModule::IncludeModule('highloadblock');
//Напишем функцию получения экземпляра класса:
if (!$arResult["DETAIL_PICTURE"]["SRC"]) {
    $arResult["DETAIL_PICTURE"]["SRC"] = $arResult["PREVIEW_PICTURE"]["SRC"];
}



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
$entity_data_class = GetEntityDataClass($arParams['ID_HIGHLOAD']);
$rsData = $entity_data_class::getList(array(
    'select' => array('*'),
    "order" => array("UF_NAME" => "ASC")
));
while ($el = $rsData->fetch()) {
    $colors[] = $el;
}


unset($entity_data_class);
unset($rsData);

$entity_data_class = GetEntityDataClass(2);
$rsData = $entity_data_class::getList(array(
    'select' => array('*'),
    "order" => array("UF_SORT" => "ASC")
));

while ($el = $rsData->fetch()) {
    $colors_info[] = $el;
    if ($arResult["PROPERTIES"]["TSVET"]["VALUE"] == $el['UF_XML_ID']) {
        $arResult["PROPERTIES"]["TSVET"]['INFO'] = $el;
    }
}

foreach ($colors_info as $color_info) {
    foreach ($colors as $key => $color) {
        if (in_array($color['UF_NAME'], $color_info['UF_CODE_LIST'])) {
            $colors[$key]["COLOR_NAME"] = $color_info["UF_NAME"];
            $colors[$key]["HEX_CODE"] = $color_info["UF_COLOR"];
        }
    }
}




//достаём товары у которых отличается только цвет для того чтобы вывести ссылки на них
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
    foreach ($colors as $color) {
        if ($arFields['PROPERTY_TSVET_IZDELIYA_VALUE'] == $color['UF_NAME']) {
            $rsColorCircleLink['COLOR_NAME'] = $color['COLOR_NAME'];
            $rsColorCircleLink['HEX_CODE'] = $color['HEX_CODE'];
            break;
        }
    }

    $arResult['COLOR_CIRCLE_LINK'][] = $rsColorCircleLink;
}


//достаём товары у которых отличается только размер для того чтобы вывести ссылки на них 
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


foreach ($colors as $color) {
    if ($arResult['PROPERTIES']['COLOR']['VALUE'] == $color['UF_XML_ID']) {
        $arResult['PROPERTIES']['COLOR']['HEX'] = $color['UF_COLOR'];
        $arResult['PROPERTIES']['COLOR']['COLOR_NAME'] = $color['UF_NAME'];
        $arResult['PROPERTIES']['COLOR']['COLOR_CODE'] = $color['ID'];
        break;
    }
} //добавлям hex из highload блока


foreach ($arResult["COLOR_CIRCLE_LINK"] as $key => $arColorCircle) {
    if ($arColorCircle['ID'] == $arResult['ID']) {
        $arResult["COLOR_CIRCLE_LINK"][$key]['ACTIVE'] = 'Y';
    }
}




foreach ($arResult['SIZE_LINK'] as $key => $arSize) {
    $separator = preg_replace('/[0-9]+/', '', $arSize["NAME"]);
    if(!empty($separator)){
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
