<?
define("NO_KEEP_STATISTIC", true);
define("NOT_CHECK_PERMISSIONS", true);
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
?>
<?if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
                
    $email = $_POST['REGISTER_EMAIL'];
    $login = $_POST['REGISTER_EMAIL'];
    $password = $_POST['REGISTER_PASSWORD'];
    $password_confirm = $_POST['__CONFIRM_PASSWORD'];

    $arr[] = array($email, $login,  $password, $password_confirm);

    $arResult = $USER->Register( $login , "", "", $password, $password_confirm, $email);
    
    $USER_ID = $USER->GetID(); // ID нового пользователя
    if (intval($USER_ID) > 0){
        $USER->Authorize($USER_ID); 
        $result['status'] = 'success';
    }
    else{
        $result['status'] = 'error';
    }
    $result['message'] = str_replace('Логин должен быть не менее 3 символов.<br>', '', $arResult);
    echo json_encode($result);

}
