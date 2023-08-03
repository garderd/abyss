<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
$this_tovar_id = $GLOBALS['detail_id_tovar'];
?>



	<?if(!empty($arResult['ITEMS'] && $arResult['ITEMS'] != '')):?>
	<div class="catalog-element__slider">
		<div class="container catalog-section__element-wrapper">
			<div class="element-slider-view-tovars">
				<div class="element-slider__header align-items-center d-flex justify-content-between">
					<h3 class="element-slider__h3">Еще Товары из коллекции <?=$arResult['THIS_COLLECTION']["NAME"]?></h3>
					<div class="arrows d-flex ">
						<div class="button button-prev">
							<div class="arrow-left"></div>
						</div>
						<div class="button button-next">
							<div class="arrow-right"></div>
						</div>
					</div>
				</div>
				<div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 swiper-wrapper">
					<?foreach($arResult["ITEMS"] as $cell=>$arElement):?>
						<?if($arElement['COLLECTION'] == $arResult['THIS_SECTION']['CODE'] && $this_tovar_id != $arElement["ID"]):?>
							<?
								$this->AddEditAction($arElement['ID'], $arElement['EDIT_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT"));
								$this->AddDeleteAction($arElement['ID'], $arElement['DELETE_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BCS_ELEMENT_DELETE_CONFIRM')));
							?>
							<div class="catalog-section__element swiper-slide" id="<?=$this->GetEditAreaId($arElement['ID']);?>">
									<div class="section-element__border">
										<a class="section-element__link"  href="<?=$arElement["DETAIL_PAGE_URL_RIGHT"]?>"
											title="<?=$arElement["NAME"]?>">
											<img class="section-element__img" src="<?=$arElement["PREVIEW_PICTURE"]["SRC"]?>"
												alt="<?=$arElement["NAME"]?>" />
											<div class="fake-cart-btn">
				                            	<div class="element__bag"></div>
				                            	В корзину
				                        	</div>												
											<span class="section-element__name"><?=$arElement["NAME"]?></span>
										</a>

							
											<?if(is_array($arElement["OFFERS"]) && !empty($arElement["OFFERS"])):?>
												<?foreach($arElement["OFFERS"] as $arOffer):?>
													<?$offers_can_buy[] = $arOffer['CAN_BUY']?>
														<?if($arOffer['CAN_BUY']):?>
															<?foreach($arOffer["PRICES"] as $code=>$arPrice):?>
															<?if($arPrice["CAN_ACCESS"]):?>
																<?
																	$price['min'] = $arPrice["PRINT_VALUE"];			
																	$price['max'] = $arPrice["PRINT_DISCOUNT_VALUE"];
																	$prices[] = $price;
																	unset($price);
																?>
															<?endif?>
															<?endforeach;?>
														<?endif;?>
												<?endforeach;
												if(in_array(1,$offers_can_buy)):

													foreach($prices as $key => $arMinPrice) {
														$min_prices = $arMinPrice;
													}
													?>
														<?if(count_not_zero($offers_can_buy) == 1):?>
															<?if($min_prices['min'] != $min_prices['max']):?>
															<p class='section-element__price'><span class="catalog-section__discount-price"><?=$min_prices['min']?></span><?=$min_prices['max']?></p>
															<?else:?>
																<p class='section-element__price'><?=$min_prices['min']?></p>

															<?endif;?>
														<?else:?>
															<p class='section-element__price'>от <?=$min_prices['max']?></p>
														<?endif;
														?>

														<?
															unset($prices);
															unset($min_price);
															unset($offers_can_buy);
														?>
												<?else:?>
													<p class='section-element__price'>Нет в наличии</p>
												<?endif;?>
											<?else:?>
												<?foreach($arElement["PRICES"] as $code=>$arPrice):?>
												<?if($arElement['CAN_BUY']):?>
													<?if($arPrice["CAN_ACCESS"]):?>
														<?if($arPrice["DISCOUNT_VALUE"] < $arPrice["VALUE"]):?>
															<p class='section-element__price'><s class='section-element__old-price'><?=$arPrice["PRINT_VALUE"]?></s>
																<?=$arPrice["PRINT_DISCOUNT_VALUE"]?></p>
														<?else:?>
														<p class='section-element__price'><?=$arPrice["PRINT_VALUE"]?></p>
														<?endif;?>
													<?endif;?>
												<?else:?>
													<p class='section-element__price'>Нет в наличии</p>
												<?endif?>
												<?endforeach;?>
											<?endif?>
										<div class="catalog-section__button-favorite" id-el="<?=$arElement['ID']?>"></div>
									</div>
							</div>
						<?endif;?>						
					<?endforeach;?>
				</div>
			</div>
		</div>
	</div>
	<?endif;?>
