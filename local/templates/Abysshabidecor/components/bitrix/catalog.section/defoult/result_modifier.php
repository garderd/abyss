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
?>