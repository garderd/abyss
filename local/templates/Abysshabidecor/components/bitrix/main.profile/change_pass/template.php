<?
/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 */
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();
?>

<div class="bx-auth-profile">

<?ShowError($arResult["strProfileError"]);?>


<form method="post" id="change_password" name="form1" action="<?=$arResult["FORM_TARGET"]?>" enctype="multipart/form-data">
<?=$arResult["BX_SESSION_CHECK"]?>
<input type="hidden" name="lang" value="<?=LANG?>" />
<input type="hidden" name="ID" value=<?=$arResult["ID"]?> />



<?if($arResult['CAN_EDIT_PASSWORD']):?>

		<div class="content__input"  style="position: relative;">
			<span class="input__header"><?=GetMessage('NEW_PASSWORD_REQ')?></span>
			<input  type="password" name="NEW_PASSWORD" maxlength="50" value="" autocomplete="off" class="bx-auth-input input" />
			<div class="input-password__eye"></div>
		</div>

<?if($arResult["SECURE_AUTH"]):?>
				<span class="bx-auth-secure" id="bx_auth_secure" title="<?echo GetMessage("AUTH_SECURE_NOTE")?>" style="display:none">
					<div class="bx-auth-secure-icon"></div>
				</span>
				<noscript>
				<span class="bx-auth-secure" title="<?echo GetMessage("AUTH_NONSECURE_NOTE")?>">
					<div class="bx-auth-secure-icon bx-auth-secure-unlock"></div>
				</span>
				</noscript>
<script type="text/javascript">
document.getElementById('bx_auth_secure').style.display = 'inline-block';
</script>

<?endif?>
		<div class="content__input" style="position: relative;">
			<span class="input__header"><?=GetMessage('NEW_PASSWORD_CONFIRM')?></span>
			<input type="password" name="NEW_PASSWORD_CONFIRM" maxlength="50" value="" autocomplete="off" class="input" />
			<div class="input-password__eye"></div>
			<div class="imformer"></div>
		</div>
<?endif?>
<?/*<a class="siple_link">Забыли пароль?</a>*/?>
<input class="gray-btn gray-btn-100" type="submit" name="save" value="Изменить пароль">
	
</form>

</div>