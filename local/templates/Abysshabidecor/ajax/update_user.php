<?require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");?>

<?
$user = new CUser;
if ($_POST["PERSONAL_PHONE"]) {
	preg_match('/^8 \((\d{3})\) (\d{3})-(\d{2})-(\d{2})$/U', $_POST["PERSONAL_PHONE"], $matches);
	if(isset($matches) && $matches != "") {

	}else{
		echo json_encode("Некорректный номер телефона");
		die;
	}
}

$fields = $_POST;
if($user->Update($USER->GetID(), $fields)){
	echo json_encode("good");
}else{
	$strError .= $user->LAST_ERROR;
	echo json_encode($strError);
}

?>
