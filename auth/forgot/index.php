<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Восстановление пароля");?>
<div style="min-height: 50vh;" class="container forgot-password">
	<h2><?$APPLICATION->ShowTitle(false)?></h2>
	<?$APPLICATION->IncludeComponent("bitrix:main.auth.changepasswd", "change_password", Array(
	"AUTH_AUTH_URL" => "",	// Страница для авторизации
		"AUTH_REGISTER_URL" => "",	// Страница для регистрации
	),
	false
);?>
</div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>