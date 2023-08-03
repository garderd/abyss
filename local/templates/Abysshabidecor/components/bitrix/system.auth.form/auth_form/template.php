<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

CJSCore::Init();
?>

<div class="bx-system-auth-form">

    <?
if ($arResult['SHOW_ERRORS'] == 'Y' && $arResult['ERROR'])
	ShowMessage($arResult['ERROR_MESSAGE']);
?>

    <?if($arResult["FORM_TYPE"] == "login"):?>

    <form id="auth_form" name="system_auth_form<?=$arResult["RND"]?>" method="post" target="_top" action="<?=$arResult["AUTH_URL"]?>">
		<h4 class="form__header">Логин</h4>
        <?if($arResult["BACKURL"] <> ''):?>
       		<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
        <?endif?>
        <?foreach ($arResult["POST"] as $key => $value):?>
        <input type="hidden" name="<?=$key?>" value="<?=$value?>" />
        <?endforeach?>
			<input type="hidden" name="AUTH_FORM" value="Y" />
			<input type="hidden" name="TYPE" value="AUTH" />
		<div class="d-flex flex-column justify-content-between">
			<div class="d-flex flex-column form__input-wrapper">
				<label class="form__label" for="USER_LOGIN">E-mail</label> 
				<input class="form__input" type="text" name="USER_LOGIN" maxlength="50" value="" size="17" />
			</div>
			<div class="d-flex flex-column form__input-wrapper">
				<label class="form__label" for="USER_PASSWORD">Пароль</label> 
				<input class="form__input form__input_password" type="password" name="USER_PASSWORD" maxlength="255" size="17" autocomplete="off" />
				<div class="input-password__eye"></div>
			</div>


			<input class="form__submit" type="submit" name="Login" value="<?=GetMessage("AUTH_LOGIN_BUTTON")?>" />


			<a class="form__link form__link_forget" href="javascript:void(0);" rel="nofollow">Забыли пароль?</a>
			<a class="form__link form__link_registation" href="javascript:void(0);" rel="nofollow"><span>Регистрация</span></a>
			<span id="login_error" class="form__error"></span>
		</div>
		<script>
			BX.ready(function() {
				var loginCookie = BX.getCookie("<?=CUtil::JSEscape($arResult["~LOGIN_COOKIE_NAME"])?>");
				if (loginCookie) {
					var form = document.forms["system_auth_form<?=$arResult["RND"]?>"];
					var loginInput = form.elements["USER_LOGIN"];
					loginInput.value = loginCookie;
				}
			});
        </script>
    </form>

    <?if($arResult["AUTH_SERVICES"]):?>
    <?
	$APPLICATION->IncludeComponent("bitrix:socserv.auth.form", "", 
		array(
			"AUTH_SERVICES"=>$arResult["AUTH_SERVICES"],
			"AUTH_URL"=>$arResult["AUTH_URL"],
			"POST"=>$arResult["POST"],
			"POPUP"=>"Y",
			"SUFFIX"=>"form",
		), 
		$component, 
		array("HIDE_ICONS"=>"Y")
	);
	?>
    <?endif?>


    <?endif?>
</div>
