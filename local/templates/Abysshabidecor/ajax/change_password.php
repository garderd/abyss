<? define("NO_KEEP_STATISTIC", true);?>
<? define("NOT_CHECK_PERMISSIONS", true); ?>
<? define("NEED_AUTH", true); ?>
<? require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php"); ?>
<?
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){

    if($USER->IsAuthorized()){	
        $checkword = randString(20);
        $password = $_POST['NEW_PASSWORD'];
        $password_confirm = $_POST['NEW_PASSWORD_CONFIRM'];
        $fields = array(
            "PASSWORD" => $password, 
            "CONFIRM_PASSWORD" => $password_confirm,
            "CHECKWORD" => $checkword         // а иначе в $USER->Update() при изменении поля  PASSWORD сгенерируется свой новый CHECKWORD
         );
     
        if($USER->Update($USER->GetID(), $fields)){
            $result['status'] = 'success';
        }
        else{
            $result['status'] = 'error';
            $result['message'] = $USER->LAST_ERROR;
        }
    }
    
    exit(json_encode($result));
}
