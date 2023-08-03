<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
CModule::IncludeModule("iblock");
use Bitrix\Sale;?>
<?

		global $USER;
		if ($USER->IsAuthorized()):?>
		<?if (count($arResult["ORDER_BY_STATUS"]) > 0):?>
			<div class="personal-order-list">
			<?$bNoOrder = true;
			foreach($arResult["ORDER_BY_STATUS"] as $key => $val):			
				$bShowStatus = true;
				foreach($val as $key1 => $vval):
					$bNoOrder = false;?>

					

						<div class="personal-order-list-item">
							<div class="personal-order-list-item-normal">

								<div>
									Заказ <?=$vval["ORDER"]["ACCOUNT_NUMBER"]?>
								</div>
								<div>
									<?=$vval["ORDER"]["DATE_INSERT"]?>
								</div>
								<div>

									<?=$vval["ORDER"]["FORMATED_PRICE"]?>
								</div>
								<div>
								
								</div>
							</div>
							<div class="personal-order-list-item-fool">		
								<div class="personal-order-list-item-fool-inner">
									<div class="personal-order-list-item-fool-arrow"></div>
									<?
										$user=array();
										$dbRes = \Bitrix\Sale\PropertyValueCollection::getList([
									            'select' => ['*'],
									            'filter' => [
									                '=ORDER_ID' => $vval["ORDER"]["ACCOUNT_NUMBER"], 
									            ]
									        ]);
									        
									        while ($item = $dbRes->fetch())
									        {
									            $user[$item['CODE']] = $item["VALUE"];
									        }
										?>
									<div class="personal-order-list-item-fool-row">
										<div>
											Заказ
										</div>
										<div class="list-item__content">
											<?=$vval["ORDER"]["ACCOUNT_NUMBER"]?>
										</div>
									</div>

									<div class="personal-order-list-item-fool-row">
										<div>
											Дата
										</div>
										<div class="list-item__content">
											<?=$vval["ORDER"]["DATE_INSERT"]?>
										</div>
									</div>

									<div class="personal-order-list-item-fool-row">
										<div>
											Товары:
										</div>
										<div class="list-item__content">
											<?=$vval["ORDER"]["FORMATED_PRICE"]?>
										</div>
									</div>
									<div class="personal-order-list-item-fool-imgs">
										<?foreach ($vval["BASKET_ITEMS"] as $vvval):?>
										<?
										$img='';
										$link='';										
										$rsElem = CIBlockElement::GetById($vvval['PRODUCT_ID']);
										if($arElem = $rsElem->GetNextElement())
											{$ar_res = $arElem->GetFields();$arProps = $arElem->GetProperties();}
										else{continue;}
											if($arProps["CML2_LINK"]["VALUE"]!=""){
												$rsElem = CIBlockElement::GetById($arProps["CML2_LINK"]["VALUE"]);
												if($arElem = $rsElem->GetNextElement())
													{$ar_res = $arElem->GetFields();$arProps = $arElem->GetProperties();}
												else{continue;}
											}
																			
										$img=CFile::GetPath($ar_res["PREVIEW_PICTURE"]);
										if (empty($img)) {
											//если пустая превьюшка
										    $img="/local/templates/newKiwi/img/no_photo.jpg";
										}
										$link=$ar_res['DETAIL_PAGE_URL'];
										?> 
											<a class="fool-imgs-item" hr class="hr__personal"ef="<?=$link?>">
												<img src="<?=$img?>">
											
													<div class="fool-imgs-item-text">
														<?=$vvval['NAME']?>	<br>
														x<?=$vvval['QUANTITY']?>	
													</div>
													<div class="fool-imgs-item-price">
														<?=intval($vvval['PRICE'])?>₽
													</div>
											</a>											 		
										<?endforeach;?>
									</div>
									<hr class="hr__personal">
									<div class="personal-order-list-item-fool-row">
										<div>
											Получатель:
										</div>
										<div class="list-item__content">
											<?=$user['FIO']?>
										</div>
									</div>
									<div class="personal-order-list-item-fool-row">
										<div>
											Телефон:
										</div>
										<div class="list-item__content">
											<?=$user['PHONE']?>
										</div>
									</div>
									<hr class="hr__personal">
									<div class="personal-order-list-item-fool-row">
										<div>
											Способ получения:
										</div>
										<div class="list-item__content">
											<?=$arResult["INFO"]["DELIVERY"][$vval["ORDER"]["DELIVERY_ID"]]["NAME"]?>
										</div>
									</div>
									<?
									unset($address);
									unset($punkt);
									unset($ulitsa);
									unset($dom);
									unset($kw);
									$punkt = $arResult['ORDERS'][$key1]["ORDER"]["PUNKT_SDEK"]['VALUE'];
 									$order_props = CSaleOrderPropsValue::GetOrderProps($vval["ORDER"]["ACCOUNT_NUMBER"]);
												while ($arProps = $order_props->Fetch()){
													if ($arProps['ORDER_PROPS_ID']==8){ $ulitsa=$arProps['VALUE'];}
											          //Дом
											        if ($arProps['ORDER_PROPS_ID']==9){ $dom=$arProps['VALUE'];}
											        //кв
											        if ($arProps['ORDER_PROPS_ID']==10){ $kw=$arProps['VALUE'];}
												}
												if ($ulitsa and $dom and $kw) {
													$address=$ulitsa." ".$dom." ".$kw;
												}
												elseif($punkt){
													$address = preg_replace("/^(.+?)#.+$/", '\\1', $punkt);
												}
											?>
									<?if ($address):?>	
									<div class="personal-order-list-item-fool-row">
										<div>
											Адрес:
										</div>
										<div class="list-item__content">
											
											<?echo $address;?>
										</div>
									</div>
									<?endif;?>
									<hr class="hr__personal">
									<div class="personal-order-list-item-fool-row">
										<div>
											Способ оплаты:
										</div>
										<div class="list-item__content">
											<?=$vval['PAYMENT'][0]['PAY_SYSTEM_NAME']?>
										</div>
									</div>
									<hr class="hr__personal">
									<div class="personal-order-list-item-fool-row">
										<div>
											Статус:
										</div>
										<div class="list-item__content">
											<?=$arResult["INFO"]["STATUS"][$vval["ORDER"]["STATUS_ID"]]["NAME"]?>
										</div>
									</div>

								</div>
							</div>
						</div>

					
				<?endforeach;
			endforeach?>
			</div>

		<?else:?>
			<div class="container">
				<div class="favorites">	
					<h1 class="contacts__h1">Заказов пока нет</h1>
					<a href="/katalog/" class="hr__personal gray-btn gray-btn__bug  d-flex align-items-center" >
						<div class="element__bag" style="position: static;"></div> 
						Начать покупки
					</a>
				</div>
			</div>	
		<?endif;?>
		

		<?endif;?>