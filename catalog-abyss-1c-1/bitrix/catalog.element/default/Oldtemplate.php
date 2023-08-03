<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
$GLOBALS['detail_id_tovar'] = $arResult['ID'];
$flag_active = 0;
?>

<?/*кнопочки +\-*/?>


<button onclick="changeValItem('-')"><svg width="20" height="3" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0 .5h20v2H0v-2Z" fill="#C3453C"></path></svg></button>
<div class="productItemQuantWrap">
<div class="productItemCounter"><span class="productItemQuantS"><?=$arResult["IN_CART_QUANTITY"]?></span> шт</div>
</div>
<button onclick="changeValItem('+')"><svg width="20" height="21" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0 9.5h20v2H0v-2Z" fill="#C3453C"></path><path d="M9 20.5V.5h2v20H9Z" fill="#C3453C"></path></svg></button>

<script type="text/javascript">
function changeValItem(action) {
	let currentCount = parseInt($('.productItemQuantS').html());
	let productId = <?=$arResult['ID']?>;
	if (currentCount >=1 ) {
		if (action == '+') {
			currentCount += 1;
		} else if (action == '-' && currentCount > 0 ){
			currentCount -= 1;
		}
		$.ajax({
			url: '/local/templates/Abysshabidecor/ajax/updateBasket.php',
			type: 'POST',
			dataType: 'json',
			data: {id: productId, count: currentCount},
		})
		.done(function(res) {
			$('.productItemQuantS').html(currentCount);
			if (currentCount==0) {
				window.location.reload();
			}
			BX.onCustomEvent('OnBasketChange');
		});
	}
}
</script>
	<div id="productJSData" data-json='{ "id": "<?=$arResult['ID']?>", "siteId": "<?=SITE_ID?>" }'></div>
	<div class="container catalog-element-container d-flex">
		<div class="catalog-element__gallery">
			<div class="element-gallery__wrapper">
				<div class="gallery-container">
						<div class="gallery-main">
							<img src="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>" alt="<?=$arResult["NAME"]?>" title="<?=$arResult["NAME"]?>" />
							<div class="catalog-section__button-favorite element__button-favorite" id-el="<?=$arResult['ID']?>"></div>
						</div>
					<div class="swiper-container gallery-thumbs">
						<div class="swiper-wrapper">
								<div class="swiper-slide">
									<img src="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>" alt="<?=$arResult["NAME"]?>" title="<?=$arResult["NAME"]?>" />
								</div>
							<?foreach($arResult["PROPERTIES"]["GALLERY"]["VALUE"] as $arImage):?>
								<div class="swiper-slide">
									<img src="<?=CFile::GetPath($arImage)?>" alt="<?=$arResult["NAME"]?>" title="<?=$arResult["NAME"]?>" />
								</div>
							<?endforeach;?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="element__content">
			<h1 class="element__header"><?=$arResult['NAME']?></h1>
			<div class="element__line"></div>


							<div class="element__price-wrapper">
							<?if($arOffer["PRICES"]["BASE"]["CAN_ACCESS"]):?>
									<?if($arOffer["PRICES"]["BASE"]["DISCOUNT_VALUE"] < $arOffer["PRICES"]["BASE"]["VALUE"]):?>
										<span class="element__price-old"><?=$arOffer["PRICES"]["BASE"]["PRINT_VALUE"]?></span><span class="element__price"><?=$arOffer["PRICES"]["BASE"]["PRINT_DISCOUNT_VALUE"]?></span>
									<?else:?>
										<span class="element__price"><?=$arOffer["PRICES"]["BASE"]["PRINT_VALUE"]?></span>
									<?endif?>
									</p>
							<?endif;?>
							</div>



							<div class="element__color">
								<span class="element__text">Цвет: <?=$arResult['PROPERTIES']['COLOR']['COLOR_NAME']?></span>
							</div>
							<div class="element__circle-color-link_wrapper">
								<?foreach($arResult['COLOR_CIRCLE_LINK'] as $circle):?>
									
									<a href="<?if($circle['ACTIVE'] == "Y"){echo "javascript:void(0)";}else{echo $circle['LINK'];}?>" title="<?=$circle['NAME']?>" class="element__circle-color-link <?if($circle['ACTIVE'] == "Y") echo 'active'?>" style="background-color: <?=$circle['HEX']?>;"></a>
								<?endforeach;?>
							</div>


							<div class="element__size">
								<span class="element__text">Размер: <?=$arOffer["PROPERTIES"]["SIZE"]['VALUE']?></span>
								<?if(isset($arOffer['CAN_BUY']) && $arOffer['CAN_BUY'] == 1):?>
									<span class="element__text element__text_can-buy"> в наличии</span>
								<?else:?>
									<span class="element__text element__text_not-can-buy">нет в наличии</span>
								<?endif;?>
							</div>
							<div class="element__size-block_wrapper">
								<?foreach($arResult['OFFERS'] as $key => $arOffers):?>
									<?if($arOffer["PROPERTIES"]["SIZE"]['VALUE'] != $arOffers["PROPERTIES"]["SIZE"]['VALUE']):?>
										<a href="?razmer=<?=$arOffers["PROPERTIES"]["SIZE"]['VALUE']?>" class="element__size-block"><?=$arOffers["PROPERTIES"]["SIZE"]['VALUE']?></a>
									<?else:?>
										<a href="javascript:void(0)" class="element__size-block active"><?=$arOffers["PROPERTIES"]["SIZE"]['VALUE']?></a>
									<?endif;?>
								<?endforeach?>
							</div>

							<?if($arOffer["CAN_BUY"]):?>
								<form action="<?=POST_FORM_ACTION_URI?>" method="post" enctype="multipart/form-data" сlass="add_form">
									<input type="hidden" name="<?echo $arParams["ACTION_VARIABLE"]?>" value="BUY">
									<input type="hidden" name="<?echo $arParams["PRODUCT_ID_VARIABLE"]?>" value="<?echo $arOffer["ID"]?>">
									<div class="element__buy-button">
										<input class="element__buy-input" type="submit" name="<?echo $arParams["ACTION_VARIABLE"]."ADD2BASKET"?>" value="<?echo GetMessage("CT_BCE_CATALOG_ADD")?>">
										<div class="element__bag"></div>
									</div>
								</form>
							<?elseif(count($arResult["CAT_PRICES"]) > 0):?>
								<?=GetMessage("CATALOG_NOT_AVAILABLE")?>
							<?endif?>


			<?if(is_array($arResult["OFFERS"]) && !empty($arResult["OFFERS"])):?>
				<?if(!isset($_GET['razmer'])):?>  
					<?foreach($arResult["OFFERS"] as $arOffer):?>
						<?if(isset($arOffer['CAN_BUY']) && $arOffer['CAN_BUY'] == 1):?> <?/*Для первого перехода на деталку товара будет выбран первый доступный элемент*/?>
							<?$flag_active = 1;?>
							<div class="element__price-wrapper">
							<?if($arOffer["PRICES"]["BASE"]["CAN_ACCESS"]):?>
									<?if($arOffer["PRICES"]["BASE"]["DISCOUNT_VALUE"] < $arOffer["PRICES"]["BASE"]["VALUE"]):?>
										<span class="element__price-old"><?=$arOffer["PRICES"]["BASE"]["PRINT_VALUE"]?></span><span class="element__price"><?=$arOffer["PRICES"]["BASE"]["PRINT_DISCOUNT_VALUE"]?></span>
									<?else:?>
										<span class="element__price"><?=$arOffer["PRICES"]["BASE"]["PRINT_VALUE"]?></span>
									<?endif?>
									</p>
							<?endif;?>
							</div>
							<div class="element__color">
								<span class="element__text">Цвет: <?=$arResult['PROPERTIES']['COLOR']['COLOR_NAME']?></span>
							</div>
							<div class="element__circle-color-link_wrapper">
								<?foreach($arResult['COLOR_CIRCLE_LINK'] as $circle):?>
									
									<a href="<?if($circle['ACTIVE'] == "Y"){echo "javascript:void(0)";}else{echo $circle['LINK'];}?>" title="<?=$circle['NAME']?>" class="element__circle-color-link <?if($circle['ACTIVE'] == "Y") echo 'active'?>" style="background-color: <?=$circle['HEX']?>;"></a>
								<?endforeach;?>
							</div>
							<div class="element__size">
								<span class="element__text">Размер: <?=$arOffer["PROPERTIES"]["SIZE"]['VALUE']?></span>
								<?if(isset($arOffer['CAN_BUY']) && $arOffer['CAN_BUY'] == 1):?>
									<span class="element__text element__text_can-buy"> в наличии</span>
								<?else:?>
									<span class="element__text element__text_not-can-buy">нет в наличии</span>
								<?endif;?>
							</div>
							<div class="element__size-block_wrapper">
								<?foreach($arResult['OFFERS'] as $key => $arOffers):?>
									<?if($arOffer["PROPERTIES"]["SIZE"]['VALUE'] != $arOffers["PROPERTIES"]["SIZE"]['VALUE']):?>
										<a href="?razmer=<?=$arOffers["PROPERTIES"]["SIZE"]['VALUE']?>" class="element__size-block"><?=$arOffers["PROPERTIES"]["SIZE"]['VALUE']?></a>
									<?else:?>
										<a href="javascript:void(0)" class="element__size-block active"><?=$arOffers["PROPERTIES"]["SIZE"]['VALUE']?></a>
									<?endif;?>

								<?endforeach?>
							</div>
							<!-- Покупка -->
							<?if($arOffer["CAN_BUY"]):?>
								<form action="<?=POST_FORM_ACTION_URI?>" method="post" enctype="multipart/form-data" сlass="add_form">
									<input type="hidden" name="<?echo $arParams["ACTION_VARIABLE"]?>" value="BUY">
									<input type="hidden" name="<?echo $arParams["PRODUCT_ID_VARIABLE"]?>" value="<?echo $arOffer["ID"]?>">
									<div class="element__buy-button">
										<input class="element__buy-input" type="submit" name="<?echo $arParams["ACTION_VARIABLE"]."ADD2BASKET"?>" value="<?echo GetMessage("CT_BCE_CATALOG_ADD")?>">
										<div class="element__bag"></div>
									</div>
								</form>
							<?elseif(count($arResult["CAT_PRICES"]) > 0):?>
								<?=GetMessage("CATALOG_NOT_AVAILABLE")?>
							<?endif?>
							<?break;?>
						<?endif?>
					<?endforeach;?>
					<?if($flag_active == 0):?><?//если при первом заходе не нашлось активного торгового предложения?>
							<div class="element__price-wrapper">
							<?if($arResult["OFFERS"]["PRICES"]["BASE"]["CAN_ACCESS"]):?>
									<?if($arResult["OFFERS"]["PRICES"]["BASE"]["DISCOUNT_VALUE"] < $arResult["OFFERS"]["PRICES"]["BASE"]["VALUE"]):?>
										<span class="element__price-old"><?=$arResult["OFFERS"]["PRICES"]["BASE"]["PRINT_VALUE"]?></span><span class="element__price"><?=$arResult["OFFERS"]["PRICES"]["BASE"]["PRINT_DISCOUNT_VALUE"]?></span>
										<s></s> 
									<?else:?>
										<span class="element__price"><?=$arResult["OFFERS"]["PRICES"]["BASE"]["PRINT_VALUE"]?></span>
									<?endif?>
									</p>
							<?endif;?>
							</div>
							<div class="element__color">
								<span class="element__text">Цвет: <?=$arResult['PROPERTIES']['COLOR']['COLOR_NAME']?></span>
							</div>
							<div class="element__circle-color-link_wrapper">
								<?foreach($arResult['COLOR_CIRCLE_LINK'] as $circle):?>
									<a href="<?if($circle['ACTIVE'] == "Y"){echo "javascript:void(0)";}else{$circle['LINK'];}?>" title="<?=$circle['NAME']?>" class="element__circle-color-link <?if($circle['ACTIVE'] == "Y") echo 'active'?>" style="background-color: <?=$circle['HEX']?>;"></a>
								<?endforeach;?>
							</div>
							<div class="element__size">
								<span class="element__text">Размер: <?=$arResult["OFFERS"][0]["PROPERTIES"]["SIZE"]['VALUE']?></span>
								<?if(isset($arResult["OFFERS"]['CAN_BUY']) && $arResult["OFFERS"]['CAN_BUY'] == 1):?>
									<span class="element__text element__text_can-buy"> в наличии</span>
								<?else:?>
									<span class="element__text element__text_not-can-buy">нет в наличии</span>
								<?endif;?>
							</div>
							<div class="element__size-block_wrapper">
								<?foreach($arResult['OFFERS'] as $key => $arOffer):?>
										<?if($arOffer["PROPERTIES"]["SIZE"]['VALUE'] == $arResult["OFFERS"][0]["PROPERTIES"]["SIZE"]['VALUE']):?>
											<a href="?razmer=<?=$arOffer["PROPERTIES"]["SIZE"]['VALUE']?>" class="element__size-block active"><?=$arOffer["PROPERTIES"]["SIZE"]['VALUE']?></a>
										<?else:?>
											<a href="?razmer=<?=$arOffer["PROPERTIES"]["SIZE"]['VALUE']?>" class="element__size-block"><?=$arOffer["PROPERTIES"]["SIZE"]['VALUE']?></a>
										<?endif;?>
								<?endforeach?>
							</div>
					<?endif;?>
				<?else:?>
					<?foreach($arResult["OFFERS"] as $key => $arOffer):?>
						<?if($_GET['razmer']):?>
							<?$separator = preg_replace('/[0-9]+/', '', $arOffer["PROPERTIES"]['SIZE']['VALUE']);?>
							<?$get_sum = array_sum(explode($separator, $_GET['razmer']));?>
							<?foreach($arResult["OFFERS"] as $arOffer):?>
									<?if($arOffer["SUM_SIZE_VALUE"] == $get_sum):?>
										<div class="element__price-wrapper">
											<?if($arOffer["PRICES"]["BASE"]["CAN_ACCESS"]):?>
													<?if($arOffer["PRICES"]["BASE"]["DISCOUNT_VALUE"] < $arOffer["PRICES"]["BASE"]["VALUE"]):?>
														<span class="element__price-old"><?=$arOffer["PRICES"]["BASE"]["PRINT_VALUE"]?></span><span class="element__price"><?=$arOffer["PRICES"]["BASE"]["PRINT_DISCOUNT_VALUE"]?></span>
													<?else:?>
														<span class="element__price"><?=$arOffer["PRICES"]["BASE"]["PRINT_VALUE"]?></span>
													<?endif?>
													
											<?endif;?>
										</div>
										<div class="element__color">
											<span class="element__text">Цвет: <?=$arResult['PROPERTIES']['COLOR']['COLOR_NAME']?></span>
										</div>
										<div class="element__circle-color-link_wrapper">
											<?foreach($arResult['COLOR_CIRCLE_LINK'] as $circle):?>
												
												<a href="<?if($circle['ACTIVE'] == "Y"){echo "javascript:void(0)";}else{echo $circle['LINK'];}?>" title="<?=$circle['NAME']?>" class="element__circle-color-link <?if($circle['ACTIVE'] == "Y") echo 'active'?>" style="background-color: <?=$circle['HEX']?>;"></a>
											<?endforeach;?>
										</div>
										<div class="element__size">
											<span class="element__text">Размер: <?=$arOffer["PROPERTIES"]["SIZE"]['VALUE']?></span>
											<?if(isset($arOffer['CAN_BUY']) && $arOffer['CAN_BUY'] == 1):?>
												<span class="element__text element__text_can-buy"> в наличии</span>
											<?else:?>
												<span class="element__text element__text_not-can-buy">нет в наличии</span>
											<?endif;?>
										</div>
										<div class="element__size-block_wrapper">
											<?foreach($arResult['OFFERS'] as $key => $arOffers):?>
												<?if($arOffer["PROPERTIES"]["SIZE"]['VALUE'] != $arOffers["PROPERTIES"]["SIZE"]['VALUE']):?>
													<a href="?razmer=<?=$arOffers["PROPERTIES"]["SIZE"]['VALUE']?>" class="element__size-block"><?=$arOffers["PROPERTIES"]["SIZE"]['VALUE']?></a>
												<?else:?>
													<a href="javascript:void(0)" class="element__size-block active"><?=$arOffers["PROPERTIES"]["SIZE"]['VALUE']?></a>
												<?endif;?>

											<?endforeach?>
										</div>
										<?if($arOffer["CAN_BUY"]):?>
											<form action="<?=POST_FORM_ACTION_URI?>" method="post" enctype="multipart/form-data" сlass="add_form">
												<input type="hidden" name="<?echo $arParams["ACTION_VARIABLE"]?>" value="BUY">
												<input type="hidden" name="<?echo $arParams["PRODUCT_ID_VARIABLE"]?>" value="<?echo $arOffer["ID"]?>">
												<div class="element__buy-button">
													<?if($arResult["IN_CART"]):?>
														<input class="element__buy-input" type="submit" name="<?echo $arParams["ACTION_VARIABLE"]."ADD2BASKET"?>" value="В корзине">
													<?else:?>
														<input class="element__buy-input" type="submit" name="<?echo $arParams["ACTION_VARIABLE"]."ADD2BASKET"?>" value="В корзину">
													<?endif;?>
													<div class="element__bag"></div>
												</div>
											</form>
										<?endif;?>
										<?break(2);?>
									<?endif;?>
							<?endforeach;?>
						<?endif;?>
					<?endforeach;?>
				<?endif;?>









			<?else:?>
			<!-- Если нет преддожений --> 
				<!-- Цены -->
				<div class="element__price-wrapper">
				<?foreach($arResult["PRICES"] as $code=>$arPrice):?>
					<?if($arPrice["CAN_ACCESS"]):?>
						<?if($arPrice["DISCOUNT_VALUE"] < $arPrice["VALUE"]):?>
						<span class="element__price-old"><?=$arPrice["PRINT_VALUE"]?></span><span class="element__price"><?=$arPrice["PRINT_DISCOUNT_VALUE"]?></span>
						<?else:?>
						<span class="element__price"><?=$arPrice["PRINT_VALUE"]?></span>
							
						<?endif?>
						</p>
					<?endif;?>
				<?endforeach;?>
				</div>

				
				<div class="element__color">
					<span class="element__text">Цвет: <?=$arResult['PROPERTIES']['COLOR']['COLOR_NAME']?></span>
				</div>
				<div class="element__circle-color-link_wrapper">
					<?foreach($arResult['COLOR_CIRCLE_LINK'] as $circle):?>
						<a href="<?if($circle['ACTIVE'] == "Y"){echo "javascript:void(0)";}else{echo $circle['LINK'];}?>" title="<?=$circle['NAME']?>" class="element__circle-color-link <?if($circle['ACTIVE'] == "Y") echo 'active'?>" style="background-color: <?=$circle['HEX']?>;"></a>
					<?endforeach;?>
				</div>
				<div class="element__size">
					<span class="element__text">Размер: <?=$arResult["PROPERTIES"]["SIZE"]['VALUE']?></span>
					<?if(isset($arResult['CAN_BUY']) && $arResult['CAN_BUY'] == 1):?>
						<span class="element__text element__text_can-buy"> в наличии</span>
					<?else:?>
						<span class="element__text element__text_not-can-buy">нет в наличии</span>
					<?endif;?>
				</div>

				<!-- Покупка -->
				<?if($arResult["CAN_BUY"]):?>
					<?if($arResult["IN_CART"]):?>
					<form action="<?=POST_FORM_ACTION_URI?>" method="post" enctype="multipart/form-data" сlass="add_form">
						<input type="hidden" name="<?echo $arParams["ACTION_VARIABLE"]?>" value="BUY">
						<input type="hidden" name="<?echo $arParams["PRODUCT_ID_VARIABLE"]?>" value="<?echo $arResult["ID"]?>">
						<div class="element__buy-button">
							<input class="element__buy-input" type="submit" name="<?echo $arParams["ACTION_VARIABLE"]."ADD2BASKET"?>" value="В корзине">
							<div class="element__bag"></div>
						</div>
					</form>
					<?else:?>
					<form action="<?=POST_FORM_ACTION_URI?>" method="post" enctype="multipart/form-data" сlass="add_form">
						<input type="hidden" name="<?echo $arParams["ACTION_VARIABLE"]?>" value="BUY">
						<input type="hidden" name="<?echo $arParams["PRODUCT_ID_VARIABLE"]?>" value="<?echo $arResult["ID"]?>">
						<div class="element__buy-button">
							<input class="element__buy-input" type="submit" name="<?echo $arParams["ACTION_VARIABLE"]."ADD2BASKET"?>" value="В корзину">
							<div class="element__bag"></div>
						</div>
					</form>
					<?endif;?>
				<?elseif((count($arResult["PRICES"]) > 0) || is_array($arResult["PRICE_MATRIX"])):?>
					<?=GetMessage("CATALOG_NOT_AVAILABLE")?>
				<?endif?>
			<?endif?>















			
			<div class="element__dropdown-block_wrapper">
				<div class="dropdown-block__header">
					<span class="dropdown-block__span">Характеристики</span> 
					<div class="dropdown-block__arrow"></div>
				</div>
				<div class="dropdown-block__content">
					<div class="dropdown-block__property">
						<div class="property__name"><?=$arResult['PROPERTIES']['VENDOR_CODE']['NAME']?></div>
						<div class="dropdown__bottom-line"></div>
						<div class="property__value"><?=$arResult['PROPERTIES']['VENDOR_CODE']['VALUE']?></div>
					</div>
					<div class="dropdown-block__property">
						<div class="property__name"><?=$arResult['PROPERTIES']['DENSITY']['NAME']?></div>
						<div class="dropdown__bottom-line"></div>
						<div class="property__value"><?=$arResult['PROPERTIES']['DENSITY']['VALUE']?></div>
					</div>
					<div class="dropdown-block__property">
						<div class="property__name"><?=$arResult['PROPERTIES']['COLOR_PANTONE']['NAME']?></div>
						<div class="dropdown__bottom-line"></div>
						<div class="property__value"><?=$arResult['PROPERTIES']['COLOR_PANTONE']['VALUE']?></div>
					</div>
					<div class="dropdown-block__property">
						<div class="property__name"><?=$arResult['PROPERTIES']['PECULIARITIES']['NAME']?></div>
						<div class="dropdown__bottom-line"></div>
						<div class="property__value"><?=$arResult['PROPERTIES']['PECULIARITIES']['VALUE']?></div>
					</div>
				</div>
				<hr class="dropdown-block__line">
				<div class="dropdown-block__header">
					<span class="dropdown-block__span"><?=$arResult['PROPERTIES']['COMPOUND']['NAME']?></span> 
					<div class="dropdown-block__arrow"></div>
				</div>
				<div class="dropdown-block__content dropdown-block__content-compound">
					<?=$arResult['PROPERTIES']['COMPOUND']['~VALUE']['TEXT']?>
				</div>
				<hr class="dropdown-block__line">
				<div class="dropdown-block__header">
					<span class="dropdown-block__span">Описание</span> 
					<div class="dropdown-block__arrow"></div>
				</div>
				<div class="dropdown-block__content dropdown-block__content-description">
					<p><?=$arResult['DETAIL_TEXT']?></p>
				</div>
			</div> 
			<div class="element__delivery">
				
			</div>
		</div>
	</div>
