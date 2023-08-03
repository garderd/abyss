<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

/**
 * @var array $arParams
 * @var array $arResult
 * @var $APPLICATION CMain
 */
	$APPLICATION->SetPageProperty('title', "Заказ оформлен");
?>

<? if (!empty($arResult["ORDER"])): ?>
	<h1 class="h1"><?$APPLICATION->ShowTitle()?></h1>
	<div class="order-confirm">
		<div class="busket-row"> 
			<div class="busket-row-left">Номер заказа</div>
			<div class="busket-row-right"><?=$arResult["ORDER"]["ACCOUNT_NUMBER"] ?></div>
		</div>
		<div class="busket-row"> 
			<div class="busket-row-left">Дата заказа</div>
			<div class="busket-row-right"><?=$arResult["ORDER"]["DATE_INSERT"]->toUserTime()->format('d.m.Y H:i') ?></div>
		</div>
		<div class="busket-row"> 
			<div class="busket-row-left">Товары: <?=$arResult['ORDER']['ORDER_PROPERTY']['TOVARS']['QUANTITY']?> шт. <?if(isset($arResult['ORDER']['ORDER_PROPERTY']['TOVARS']['WEIGHT']) && $arResult['ORDER']['ORDER_PROPERTY']['TOVARS']['WEIGHT'] != 0){echo ", ".$arResult['ORDER']['ORDER_PROPERTY']['TOVARS']['WEIGHT'];}?></div>
			<div class="busket-row-right"><?=number_format($arResult["ORDER"]["PRICE"], 0, '', ' ');?> ₽</div>
		</div>
		<hr style="margin:0;">
		<div class="busket-row"> 
			<div class="busket-row-left">Получатель</div>
			<div class="busket-row-right"><?=$arResult['ORDER']['ORDER_PROPERTY']["FIO"]['VALUE']?></div>
		</div>
		<div class="busket-row"> 
			<div class="busket-row-left">Телефон</div>
			<div class="busket-row-right"><?=$arResult['ORDER']['ORDER_PROPERTY']["PHONE"]['VALUE']?></div>
		</div>
		<hr style="margin:0;">
		<?


	

		$arDeliv = CSaleDelivery::GetByID(intval($arResult["ORDER"]["DELIVERY_ID"]));
		if (!$arDeliv){
			if($arResult["ORDER"]["DELIVERY_ID"] == 36){
				$arDeliv["NAME"] = "СДЭК";
			}
			if($arResult["ORDER"]["DELIVERY_ID"] == 37){
				$arDeliv["NAME"] = "Доставка курьером";
			}
			if($arResult["ORDER"]["DELIVERY_ID"] == 39){
				$arDeliv["NAME"] = "Постамат";
			}
			if($arResult["ORDER"]["DELIVERY_ID"] == 38){
				$arDeliv["NAME"] = "Самовывоз";
			}
		}
		if ($arDeliv):?>
		<div class="busket-row"> 
			<div class="busket-row-left">Способ получения</div>
			<div class="busket-row-right"><?=$arDeliv["NAME"]?></div>
		</div>	 
		<?endif?>

		
		<?if(isset($arResult['ORDER']['ORDER_PROPERTY']['STREET']['VALUE']) && $arResult['ORDER']['ORDER_PROPERTY']['STREET']['VALUE'] != '' && isset($arResult['ORDER']['ORDER_PROPERTY']['HOUSE']['VALUE']) && $arResult['ORDER']['ORDER_PROPERTY']['HOUSE']['VALUE'] != '' && isset($arResult['ORDER']['ORDER_PROPERTY']['FLAT']['VALUE']) && $arResult['ORDER']['ORDER_PROPERTY']['FLAT']['VALUE'] != "" ):?>
		<div class="busket-row"> 
			<div class="busket-row-left">Адрес</div>
			<div class="busket-row-right">г. <?=$arResult['ORDER']['ORDER_PROPERTY']['LOCATION']['CITY_NAME_ORIG']?>, ул. <?=$arResult['ORDER']['ORDER_PROPERTY']['STREET']['VALUE']?>, д. <?=$arResult['ORDER']['ORDER_PROPERTY']['HOUSE']['VALUE']?>, кв. <?=$arResult['ORDER']['ORDER_PROPERTY']['FLAT']['VALUE']?></div>
		</div>	 
		<hr style="margin:0;">
		<?endif;?>
	<?
		if ($arResult["ORDER"]["IS_ALLOW_PAY"] === 'Y')
		{
			if (!empty($arResult["PAYMENT"]))
			{
				foreach ($arResult["PAYMENT"] as $payment)
				{
					if ($payment["PAID"] != 'Y')
					{
						if (!empty($arResult['PAY_SYSTEM_LIST'])
							&& array_key_exists($payment["PAY_SYSTEM_ID"], $arResult['PAY_SYSTEM_LIST'])
						)
						{
							$arPaySystem = $arResult['PAY_SYSTEM_LIST_BY_PAYMENT_ID'][$payment["ID"]];

							if (empty($arPaySystem["ERROR"]))
							{
								$APPLICATION->SetTitle("Оплата заказа");?>
										<div class="busket-row"> 
											<div class="busket-row-left"><?=Loc::getMessage("SOA_PAY")?></div>
											
											<div class="busket-row-right"><?=$arPaySystem["NAME"] ?></div>
										</div>
											
											
									
											<? if ($arPaySystem["ACTION_FILE"] <> '' && $arPaySystem["NEW_WINDOW"] == "Y" && $arPaySystem["IS_CASH"] != "Y"): ?>
												<?
												$orderAccountNumber = urlencode(urlencode($arResult["ORDER"]["ACCOUNT_NUMBER"]));
												$paymentAccountNumber = $payment["ACCOUNT_NUMBER"];
												?>
												<script>
													window.open('<?=$arParams["PATH_TO_PAYMENT"]?>?ORDER_ID=<?=$orderAccountNumber?>&PAYMENT_ID=<?=$paymentAccountNumber?>');
												</script>
											<?=Loc::getMessage("SOA_PAY_LINK", array("#LINK#" => $arParams["PATH_TO_PAYMENT"]."?ORDER_ID=".$orderAccountNumber."&PAYMENT_ID=".$paymentAccountNumber))?>
											<? if (CSalePdf::isPdfAvailable() && $arPaySystem['IS_AFFORD_PDF']): ?>
											<br/>
												<?=Loc::getMessage("SOA_PAY_PDF", array("#LINK#" => $arParams["PATH_TO_PAYMENT"]."?ORDER_ID=".$orderAccountNumber."&pdf=1&DOWNLOAD=Y"))?>
											<? endif ?>
											<? else: ?>
												<?=$arPaySystem["BUFFERED_OUTPUT"]?>
											<? endif ?>


								<?
							}
							else
							{
								?>
								<span style="color:red;"><?=Loc::getMessage("SOA_ORDER_PS_ERROR")?></span>
								<?
							}
						}
						else
						{
							?>
							<span style="color:red;"><?=Loc::getMessage("SOA_ORDER_PS_ERROR")?></span>
							<?
						}
					}
				}
			}
		}
		else
		{
			?>
			<br /><strong><?=$arParams['MESS_PAY_SYSTEM_PAYABLE_ERROR']?></strong>
			<?
		}
	?>	

	<hr style="margin:0;">
	<div class="busket-row"> 
		<a href="/personal/" class="back-catalog">Детали заказа <span class="desktop-text"> в личном кабинете</span></a>
	</div>	
	</div>
<? else: ?>
	<?$APPLICATION->SetTitle(Loc::getMessage("SOA_ERROR_ORDER"));?>
	<h1 class="h1"><?$APPLICATION->ShowTitle(false)?></h1>
	<br/><br/>

	<table class="sale_order_full_table">
		<tr>
			<td>
				<?=Loc::getMessage("SOA_ERROR_ORDER_LOST", ["#ORDER_ID#" => htmlspecialcharsbx($arResult["ACCOUNT_NUMBER"])])?>
				<?=Loc::getMessage("SOA_ERROR_ORDER_LOST1")?>
			</td>
		</tr>
	</table>

<? endif ?>
