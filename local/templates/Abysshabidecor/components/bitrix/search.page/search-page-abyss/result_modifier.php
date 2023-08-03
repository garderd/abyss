<?php
// debug($arResult["SEARCH"]);
foreach ($arResult["SEARCH"] as &$arItem) {
    $arSelect = array("ID", "IBLOCK_ID", "NAME", "DATE_ACTIVE_FROM", "PREVIEW_PICTURE");
    $arFilter = array("ID" => $arItem['ITEM_ID'], "ACTIVE_DATE" => "Y", "ACTIVE" => "Y");
    $res = CIBlockElement::GetList(array(), $arFilter, false, array(), $arSelect);
    while ($ob = $res->GetNextElement()) {
        $arFields = $ob->GetFields();
        if (isset($arFields['PREVIEW_PICTURE']) && $arFields['PREVIEW_PICTURE'] != '') {;
            $file = CFile::ResizeImageGet($arFields['PREVIEW_PICTURE'], array('width'=>500, 'height'=>500), BX_RESIZE_IMAGE_PROPORTIONAL, false);	
            $arItem["PREVIEW_PICTURE"] = $file['src'];
        }

        $rsOffer = CCatalogSKU::getOffersList(array($arItem['ITEM_ID']), 0, array(), array(), array());
        
        foreach($rsOffer[$arItem['ITEM_ID']] as $arOffer){
            $arPrice = CPrice::GetBasePrice($arOffer["ID"]);
            $arItem["QUANTITY"] = $arPrice["PRODUCT_QUANTITY"];
            if(isset($arPrice["PRICE"])){
                $arItem["PRICE"] = CurrencyFormat($arPrice["PRICE"], $arPrice["CURRENCY"]);
            }
           
        }
       
    }
}
