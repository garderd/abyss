<?
require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
global $USER;
$arResult = $USER->SendPassword("", $_POST['USER_EMAIL']);
if($arResult["TYPE"] == "OK"){
    $result["status"] = "success";
    $result["message"] = "Контрольная строка для смены пароля выслана";
}
else
{   
    $result["status"] = "error";
    $result["message"] = "Введенный email не найден";
}

echo json_encode($result);