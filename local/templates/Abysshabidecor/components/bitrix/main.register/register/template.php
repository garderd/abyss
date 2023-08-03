<?
/**
 * Bitrix Framework
 * @package bitrix
 * @subpackage main
 * @copyright 2001-2014 Bitrix
 */

/**
 * Bitrix vars
 * @global CMain $APPLICATION
 * @global CUser $USER
 * @param array $arParams
 * @param array $arResult
 * @param CBitrixComponentTemplate $this
 */

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die();

if($arResult["SHOW_SMS_FIELD"] == true)
{
	CJSCore::Init('phone_auth');
}
?>

<div class="bx-auth-reg">

    <?if($USER->IsAuthorized()):?>

    <p>
        <?echo GetMessage("MAIN_REGISTER_AUTH")?>
    </p>

    <?else:?>
    <?
if (count($arResult["ERRORS"]) > 0):
elseif($arResult["USE_EMAIL_CONFIRMATION"] === "Y"):
?>

    <p>
        <?echo GetMessage("REGISTER_EMAIL_WILL_BE_SENT")?>
    </p>
    <?endif?>

    <?if($arResult["SHOW_SMS_FIELD"] == true):?>

    <form method="post"  action="<?=POST_FORM_ACTION_URI?>" name="regform">
        <?
if($arResult["BACKURL"] <> ''):
?>
        <input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
        <?
endif;
?>
        <input type="hidden" name="SIGNED_DATA" value="<?=htmlspecialcharsbx($arResult["SIGNED_DATA"])?>" />
        <table>
            <tbody>
                <tr>
                    <td>
                        <?echo GetMessage("main_register_sms")?><span class="starrequired">*</span>
                    </td>
                    <td><input size="30" type="text" name="SMS_CODE"
                            value="<?=htmlspecialcharsbx($arResult["SMS_CODE"])?>" autocomplete="off" /></td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td></td>
                    <td><input type="submit" name="code_submit_button" value="<?echo GetMessage("
                            main_register_sms_send")?>" /></td>
                </tr>
            </tfoot>
        </table>
    </form>

   

    <div id="bx_register_resend"></div>

    <?else:?>

    <form method="post" id="reg_form" action="<?=POST_FORM_ACTION_URI?>" name="regform" enctype="multipart/form-data">
<?
		if($arResult["BACKURL"] <> ''):
		?>
				<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
				<?
		endif;
		?>
            <h4 class="form__header">Регистрация</h4>
                <?foreach ($arResult["SHOW_FIELDS"] as $FIELD):?>
            
                <div class="form__input-wrapper">
				<?if($FIELD != 'LOGIN'):?>
                    <div class="form__label"><?=GetMessage("REGISTER_FIELD_".$FIELD)?>
                        <?if ($arResult["REQUIRED_FIELDS_FLAGS"][$FIELD] == "Y"):?>
                        <?endif?>
					</div>
					<?endif;?>
                        <?
					switch ($FIELD)
					{
						case "PASSWORD":
							?><input class="form__input form__input_password" size="30" type="password" name="REGISTER_<?=$FIELD?>" value="<?=$arResult["VALUES"][$FIELD]?>"
											autocomplete="off" class="bx-auth-input" />
										<div class="input-password__eye"></div>
										<?if($arResult["SECURE_AUTH"]):?>
										<span class="bx-auth-secure" id="bx_auth_secure" title="<?echo GetMessage("
											AUTH_SECURE_NOTE")?>" style="display:none">
											<div class="bx-auth-secure-icon"></div>
										</span>
										<noscript>
											<span class="bx-auth-secure" title="<?echo GetMessage(" AUTH_NONSECURE_NOTE")?>">
												<div class="bx-auth-secure-icon bx-auth-secure-unlock"></div>
											</span>
										</noscript>
										<script type="text/javascript">
										document.getElementById('bx_auth_secure').style.display = 'inline-block';
										</script>
										<?endif?>
										<?
							break;
						case "CONFIRM_PASSWORD":
							?><input class="form__input form__input_password" size="30" type="password" name="__<?=$FIELD?>" value="<?=$arResult["VALUES"][$FIELD]?>"
											autocomplete="off" />
											<div class="input-password__eye"></div>
										<?
							break;

							?><textarea cols="30" rows="5" name="REGISTER_<?=$FIELD?>"><?=$arResult["VALUES"][$FIELD]?></textarea>
										<?
							break;
						default:
							if ($FIELD == "PERSONAL_BIRTHDAY"):?><small><?=$arResult["DATE_FORMAT"]?></small><br /><?endif;?>
							<?if($FIELD == 'LOGIN'):?>
								<input class="form__input" id="login-reg" size="30" type="hidden" name="REGISTER_<?=$FIELD?>"/>
							<?elseif($FIELD == 'EMAIL'):?>
								<input class="form__input" id="email-reg" size="30" type="text" name="REGISTER_<?=$FIELD?>" value="<?=$arResult["VALUES"][$FIELD]?>" />
							<?else:?>
								<input class="form__input" size="30" type="text" name="REGISTER_<?=$FIELD?>" value="<?=$arResult["VALUES"][$FIELD]?>" />
							<?endif;?>
										<?
								if ($FIELD == "PERSONAL_BIRTHDAY")
									$APPLICATION->IncludeComponent(
										'bitrix:main.calendar',
										'',
										array(
											'SHOW_INPUT' => 'N',
											'FORM_NAME' => 'regform',
											'INPUT_NAME' => 'REGISTER[PERSONAL_BIRTHDAY]',
											'SHOW_TIME' => 'N'
										),
										null,
										array("HIDE_ICONS"=>"Y")
									);
								?>
										<?
					}
					?>
				</div>
                <?endforeach?>
                <?// ********************* User properties ***************************************************?>
                <?if($arResult["USER_PROPERTIES"]["SHOW"] == "Y"):?>
                <tr>
                    <td colspan="2">
                        <?=trim($arParams["USER_PROPERTY_NAME"]) <> '' ? $arParams["USER_PROPERTY_NAME"] : GetMessage("USER_TYPE_EDIT_TAB")?>
                    </td>
                </tr>
                <?foreach ($arResult["USER_PROPERTIES"]["DATA"] as $FIELD_NAME => $arUserField):?>
                <tr>
                    <td><?=$arUserField["EDIT_FORM_LABEL"]?>:
                        <?if ($arUserField["MANDATORY"]=="Y"):?><span class="starrequired">*</span>
                        <?endif;?>
                    </td>
                    <td>
                        <?$APPLICATION->IncludeComponent(
				"bitrix:system.field.edit",
				$arUserField["USER_TYPE"]["USER_TYPE_ID"],
				array("bVarsFromForm" => $arResult["bVarsFromForm"], "arUserField" => $arUserField, "form_name" => "regform"), null, array("HIDE_ICONS"=>"Y"));?>
                    </td>
                </tr>
                <?endforeach;?>
                <?endif;?>
                <?// ******************** /User properties ***************************************************?>
                <?
/* CAPTCHA */
if ($arResult["USE_CAPTCHA"] == "Y")
{
	?>
                <tr>
                    <td colspan="2"><b><?=GetMessage("REGISTER_CAPTCHA_TITLE")?></b></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type="hidden" name="captcha_sid" value="<?=$arResult["CAPTCHA_CODE"]?>" />
                        <img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["CAPTCHA_CODE"]?>" width="180"
                            height="40" alt="CAPTCHA" />
                    </td>
                </tr>
                <tr>
                    <td><?=GetMessage("REGISTER_CAPTCHA_PROMT")?>:<span class="starrequired">*</span></td>
                    <td><input type="text" name="captcha_word" maxlength="50" value="" autocomplete="off" /></td>
                </tr>
                <?
}
/* !CAPTCHA */
?>
	<input class="form__submit" type="submit" name="register_submit_button" value="<?=GetMessage("AUTH_REGISTER")?>" />
    <span id="reg_error" class="form__error"></span>
    </form>

  
    <?endif //$arResult["SHOW_SMS_FIELD"] == true ?>

    <?endif?>
</div>
