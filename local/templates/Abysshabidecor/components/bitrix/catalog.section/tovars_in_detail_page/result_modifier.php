<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
use Bitrix\Main\Application;


if(!$USER->IsAuthorized()) // Для неавторизованного
{
    global $APPLICATION;
    $favorites = unserialize(Application::getInstance()->getContext()->getRequest()->getCookie("favorites"));
}
else {
     $idUser = $USER->GetID();
     $rsUser = CUser::GetByID($idUser);
     $arUser = $rsUser->Fetch();
     $favorites = $arUser['UF_FAVORITES'];
}
$arResult['FAVORITES'] = $favorites;



$arSelect = Array("ID", "NAME", "IBLOCK_SECTION_ID");
$arFilter = Array("IBLOCK_ID"=>$arParams['IBLOCK_ID'], "ACTIVE"=>"Y");
$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
while($ob = $res->GetNextElement())
{
    $arElement = $ob->GetFields();
    $arElements[] = $arElement;
}

foreach($arElements as $key2 => $arElement){
    $res = CIBlockSection::GetByID($arElement['IBLOCK_SECTION_ID']);
    if($ar_res = $res->GetNext())
    {
        $arCollections[] = $ar_res['CODE'];
        if($arResult['ORIGINAL_PARAMETERS']['SECTION_CODE'] == $ar_res['CODE'] )
        {
            $arResult["THIS_COLLECTION"] = $ar_res;
        }
    }
}
foreach($arResult['ITEMS'] as $key1 => $arItem){
    foreach($arElements as $key2 => $arElement){
        $res = CIBlockSection::GetByID($arElement['IBLOCK_SECTION_ID']);
        if($ar_res = $res->GetNext())
        {
            if(!in_array($arResult['ORIGINAL_PARAMETERS']['SECTION_CODE'],array_unique($arCollections))){
                if($arItem["ID"] == $arElement["ID"]){
                    $arResult['ITEMS'][$key1]['COLLECTION'] = $ar_res['CODE'];
                    $arResult['ITEMS'][$key1]['DETAIL_PAGE_URL_RIGHT'] = $arResult['SECTION_PAGE_URL']. $ar_res['CODE'] . '/' . $arResult['ITEMS'][$key1]['CODE'] . '/';
                    break(1);
                }
            }
            else{
                $arResult['ITEMS'][$key1]['DETAIL_PAGE_URL_RIGHT'] = $arResult['ITEMS'][$key1]['DETAIL_PAGE_URL'];
            }
        }
    }
}




?>