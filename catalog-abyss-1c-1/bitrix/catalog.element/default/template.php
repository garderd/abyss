<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);
$GLOBALS['detail_id_tovar'] = $arResult['ID'];

?>
<? $tovar_count = $arResult['OFFERS'][0]['PRODUCT']['QUANTITY'];
?>
<?
if (isset($arResult["DETAIL_PICTURE"]["ID"]) && $arResult["DETAIL_PICTURE"]["ID"] != "") {
	$detail_picture = CFile::ResizeImageGet($arResult["DETAIL_PICTURE"]["ID"], array('width' => 2000, 'height' => 2000), BX_RESIZE_IMAGE_EXACT, true);
} else {
	$detail_picture['src'] = '/local/templates/Abysshabidecor/assets/img/no_photo.webp';
}

$arImporters = [
	'Импортер: ООО &quot;Офис-Дизайн&quot;, Москва, Б.Полянка 7/10',
	'Импортер: ООО Вега Компания, Москва, Дм.Ульянова 4-2-193',
	'Импортер: ООО &quot;Вега Компания&quot;, Москва, Дм.Ульянова 4-2-193',
];
$detailText = $arResult['DETAIL_TEXT'];
foreach ($arImporters as $arImporter) {
	if (str_contains($arResult['DETAIL_TEXT'], $arImporter)) {
		$detailText = str_replace($arImporter, "", $arResult['DETAIL_TEXT']);
		break;
	}
}

?>
<div class="detail-PopUp">
	<div class="detail-PopUp-back"></div>
	<div class="detail-PopUp-content">
		<div class="detail-PopUp-close">
		</div>
		<div class="detail-PopUp-title">Товар добавлен в корзину</div>
		<div class="detail-PopUp-item">
			<img src="<?= $detail_picture['src'] ?>" alt="<?= $arResult['NAME'] ?>" title="<?= $arResult['NAME'] ?>">
			<div class="detail-PopUp-item-name"><?= $arResult['NAME'] ?></div>
			<div class="detail-PopUp-item-price">
				<? if ($arResult["ITEM_PRICES"]["DISCOUNT_VALUE"] < $arResult["ITEM_PRICES"]["VALUE"] and $arResult["ITEM_PRICES"]["DISCOUNT_VALUE"]) : ?>
					<span class="element__price-old"><?= $arResult["ITEM_PRICES"]["VALUE"] ?></span>
					<span class="element__price"><?= $arResult["ITEM_PRICES"]["DISCOUNT_VALUE"] ?></span>
				<? else : ?>
					<span class="element__price"><?= $arResult["ITEM_PRICES"]["VALUE"] ?></span>
				<? endif ?>
			</div>
		</div>
		<div class="fake-cart-btn">
			<div class="element__bag"></div>
			В корзинe
			<button onclick="changeValItem('-')"><svg width="20" height="19" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M0 8.5h20v2H0v-2Z" fill="#FFFFFF"></path>
				</svg></button>
			<div class="productItemQuantWrap">
				<div class="productItemCounter"><span class="productItemQuantS">
						<? if ($arResult["IN_CART_QUANTITY"] < 1) {
							echo "1";
						} else {
							echo $arResult["IN_CART_QUANTITY"];
						}
						?>

					</span> шт</div>
			</div>
			<button onclick="changeValItem('+')"><svg width="20" height="19" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M0 8.5h20v2H0v-2Z" fill="#FFFFFF"></path>
					<path d="M9 20.5V.5h2v20H9Z" fill="#FFFFFF"></path>
				</svg></button>
		</div>
		<a class="gray-btn gray-btn-100" href="/cart/">Перейти в корзину</a>
		<a class="transperent-btn" href="javascript:void(0)">Продолжить покупки</a>
	</div>
</div>




<script type="text/javascript">
	function changeValItem(action) {
		let currentCount = parseInt($('.productItemQuantS').html());
		let productId = <?= $arResult['ITEM']['ID'] ?>;
		if (currentCount >= 1) {
			if (action == '+') {

				currentCount += 1;
			} else if (action == '-' && currentCount > 0) {
				currentCount -= 1;
			}
			console.log('currentCount = ' + currentCount);
			$.ajax({
					url: '/local/templates/Abysshabidecor/ajax/updateBasket.php',
					type: 'POST',
					dataType: 'json',
					data: {
						id: productId,
						count: currentCount
					},
				})
				.done(function(res) {
					if (res['currentCount'] == 0) {
						window.location.reload();
					}
					$('.productItemQuantS').html(res['res']);
					BX.onCustomEvent('OnBasketChange');
					if (res['currentCount'] != res['res'] && res['currentCount'] != 0) {
						$('.incorrect-quantity').html('В наличии только ' + res['res'] + ' шт');
						$('.incorrect-quantity').addClass('active');
					}
					console.log(res);

				});
		}
	}
</script>
<div id="productJSData" data-json='{ "id": "<?= $arResult['ID'] ?>", "siteId": "<?= SITE_ID ?>" }'></div>

<div class="catalog-element-container">
	<div class="container catalog-element__content">
		<div class="catalog-element__gallery">
			<div class="element-gallery__wrapper">
				<div class="gallery-container">
					<div class="gallery-main">
						<? if (isset($arResult["PROPERTIES"]["MORE_PHOTO"]["VALUE"]) && !empty($arResult["PROPERTIES"]["MORE_PHOTO"]["VALUE"])) : ?>
							<?
								$arImage = CFile::GetFileArray($arResult["PROPERTIES"]["MORE_PHOTO"]["VALUE"][0]);
								$arImageResize600 = CFile::ResizeImageGet($arImage, array('width'=>600, 'height'=>600), BX_RESIZE_IMAGE_PROPORTIONAL);
								$arImageResize1500 = CFile::ResizeImageGet($arImage, array('width'=>1500, 'height'=>1500), BX_RESIZE_IMAGE_PROPORTIONAL);
							?>
							<a href="<?= $arImageResize1500['src'] ?>" data-fancybox='detail-tovar' data-number="1">
								<img src="<?= $arImageResize600['src'] ?>" alt="<?= $arResult["NAME"] ?>" title="<?= $arResult["NAME"] ?>" />
							</a>
						<? elseif (isset($arResult["DETAIL_PICTURE"]["ID"]) && !empty($arResult["DETAIL_PICTURE"]["ID"])) : ?>
							<?
								$arImage = CFile::GetFileArray($arResult["DETAIL_PICTURE"]["ID"]);
								$arImageResize600 = CFile::ResizeImageGet($arImage, array('width'=>600, 'height'=>600), BX_RESIZE_IMAGE_PROPORTIONAL);
								$arImageResize1500 = CFile::ResizeImageGet($arImage, array('width'=>1500, 'height'=>1500), BX_RESIZE_IMAGE_PROPORTIONAL);
							?>
							<a href="<?= $arImageResize1500['src'] ?>" data-fancybox='detail-tovar' data-number="1">
								<img src="<?= $arImageResize600['src'] ?>" alt="<?= $arResult["NAME"] ?>" title="<?= $arResult["NAME"] ?>" />
							</a>
						<? else : ?>
							<img src="<?= SITE_TEMPLATE_PATH ?>/assets/img/no_photo.webp" alt="<?= $arResult["NAME"] ?>" title="<?= $arResult["NAME"] ?>" />
						<? endif; ?>
						<div class="catalog-section__button-favorite element__button-favorite" id-el="<?= $arResult['ID'] ?>"></div>
					</div>
					<? if (isset($arResult["PROPERTIES"]["MORE_PHOTO"]["VALUE"]) && !empty($arResult["PROPERTIES"]["MORE_PHOTO"]["VALUE"])) : ?>
						<div class="swiper-container gallery-thumbs">
							<div class="swiper-wrapper">
								<? $i = 2 ?>
								<? foreach ($arResult["PROPERTIES"]["MORE_PHOTO"]["VALUE"] as $arImage) : ?>
									<div class="swiper-slide">
										<?
											$arImage = CFile::GetFileArray($arImage);
											$arImageResize600 = CFile::ResizeImageGet($arImage, array('width'=>600, 'height'=>600), BX_RESIZE_IMAGE_PROPORTIONAL);
											$arImageResize1500 = CFile::ResizeImageGet($arImage, array('width'=>1500, 'height'=>1500), BX_RESIZE_IMAGE_PROPORTIONAL);
										?>
										<a href="<?= $arImageResize1500['src'] ?>" data-fancybox='detail-tovar' data-number="<?= $i ?>">
											<img src="<?= $arImageResize600['src'] ?>" alt="<?= $arResult["NAME"] ?>" title="<?= $arResult["NAME"] ?>" />
										</a>
									</div>
									<? $i++ ?>
								<? endforeach; ?>
							</div>
						</div>
					<? elseif (isset($arResult["DETAIL_PICTURE"]["ID"]) && !empty($arResult["DETAIL_PICTURE"]["ID"])) : ?>
						<?
						$arImage = CFile::GetFileArray($arResult["DETAIL_PICTURE"]["ID"]);
						$arImageResize600 = CFile::ResizeImageGet($arImage, array('width'=>600, 'height'=>600), BX_RESIZE_IMAGE_PROPORTIONAL);
						$arImageResize1500 = CFile::ResizeImageGet($arImage, array('width'=>1500, 'height'=>1500), BX_RESIZE_IMAGE_PROPORTIONAL);
						?>
						<div class="swiper-container gallery-thumbs">
							<div class="swiper-wrapper">
								<div class="swiper-slide">
									<a href="<?= $arImageResize1500['src'] ?>" data-fancybox>
										<img src="<?= $arImageResize600['src'] ?>" alt="<?= $arResult["NAME"] ?>" title="<?= $arResult["NAME"] ?>" />
									</a>
								</div>
							</div>
						</div>

					<? else : ?>
						<div class="catalog-element__noimage_mobile">
							<img src="<?= SITE_TEMPLATE_PATH ?>/assets/img/no_photo.webp" alt="<?= $arResult["NAME"] ?>" title="<?= $arResult["NAME"] ?>" />
						</div>
					<? endif; ?>
				</div>
			</div>
		</div>
		<div class="element-gallery-pagination">
			
		</div>
		<div class="element__content">
			<h1 class="element__header"><?= $arResult['NAME'] ?></h1>
			<div class="element__line"></div>

			<? //Цены
			?>
			<div class="element__price-wrapper">
				<? if ($arResult["ITEM_PRICES"]["DISCOUNT_VALUE"] < $arResult["ITEM_PRICES"]["VALUE"] and $arResult["ITEM_PRICES"]["DISCOUNT_VALUE"]) : ?>
					<span class="element__price-old"><?= $arResult["ITEM_PRICES"]["VALUE"] ?></span>
					<span class="element__price"><?= $arResult["ITEM_PRICES"]["DISCOUNT_VALUE"] ?></span>
				<? else : ?>
					<span class="element__price"><?= $arResult["ITEM_PRICES"]["VALUE"] ?></span>
				<? endif ?>
			</div>

			<? //Цвета
			?>
			
			<? if ($arResult['COLOR_CIRCLE_LINK']) : ?>
				<div class="element__circle-color-link_wrapper">
					<? foreach ($arResult['COLOR_CIRCLE_LINK'] as $circle) : ?>
						<?
							if(isset($circle["COLOR_IMAGE"])){
								$imageArray = CFile::GetFileArray($circle["COLOR_IMAGE"]);
								$arResizeColorCircle = CFile::ResizeImageGet($imageArray, array('width'=>50, 'height'=>50), BX_RESIZE_IMAGE_PROPORTIONAL);
							}
							else{
								$arResizeColorCircle = false;
							}
						?>
						<a 
						href="<? if ($circle['ACTIVE'] == "Y") {
										echo "javascript:void(0)";
									} else {
										echo $circle['LINK'];
									} ?>" 
						title="<?= $circle['NAME'] ?>" 
						class="element__circle-color-link <? if ($circle['ACTIVE'] == "Y") echo 'active' ?>" 
						style="<?if($arResizeColorCircle){
								echo "background-image: url(".$arResizeColorCircle['src'].")";
							}
							elseif($circle['HEX_CODE']){
								echo "background-color: ".$circle['HEX_CODE'];
							}?>">
						</a>
					<? endforeach; ?>
				</div>
			<? endif ?>

			<? if (!$tovar_count > 0) : ?>
				<div class="element__size-block_wrapper">
					<div class="element__text">
						Товар доступен по предзаказу, наш менеджер свяжется с вами и уточнит сроки поставки!
					</div>
				</div>

			<? endif; ?>

			<? //Размеры
			?>
			<div class="element__size">

				<? if ($arResult["PROPERTIES"]["RAZMER"]['VALUE']) : ?>
					<span class="element__text">Размер: <?= $arResult["PROPERTIES"]["RAZMER"]['VALUE'] ?></span>
				<? endif; ?>
				<? if ($arResult["ITEM_PRICES"]["CAN_BUY"] == "Y" and ($arResult['ITEM']["CAN_BUY"] == 1 || $arResult['ITEM']["CAN_BUY"] == "Y") && $tovar_count > 0) : ?>
					<span class="element__text element__text_can-buy"> в наличии</span>
				<? else : ?>
					<span class="element__text element__text_not-can-buy">под заказ</span>
				<? endif; ?>
			</div>
			<? if ($arResult["PROPERTIES"]["COLOR_NAME"]) : ?>
				<div class="element__color">
					<span class="element__text">Цвет: <?= $arResult["PROPERTIES"]["COLOR_NAME"] ?></span>
				</div>
			<? endif; ?>
			<? if (isset($arResult['SIZE_LINK'])) : ?>
				<div class="element__size-block_wrapper">
					<? foreach ($arResult['SIZE_LINK'] as $key => $arSize) : ?>
						<? if ($arSize["NAME"] != $arResult["PROPERTIES"]["RAZMER"]['VALUE']) : ?>
							<a href="<?= $arSize["LINK"] ?>" class="element__size-block"><?= $arSize["NAME"] ?></a>
						<? else : ?>
							<a href="javascript:void(0)" class="element__size-block active"><?= $arSize["NAME"] ?></a>
						<? endif; ?>
					<? endforeach ?>
				</div>
			<? endif; ?>
			<? if ($arResult["ITEM_PRICES"]["CAN_BUY"] == "Y" && $arResult['ITEM']["CATALOG_CAN_BUY_ZERO"] == "Y") : ?>

				<div class="<? if ($arResult["IN_CART"]) : ?>incart<? endif; ?> cart-detail">
					<div class="fake-cart-btn">
						<div class="element__bag"></div>
						В корзинe
						<button onclick="changeValItem('-')"><svg width="20" height="19" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M0 8.5h20v2H0v-2Z" fill="#FFFFFF"></path>
							</svg></button>
						<div class="productItemQuantWrap">
							<div class="productItemCounter"><span class="productItemQuantS">
									<? if ($arResult["IN_CART_QUANTITY"] < 1) {
										echo "1";
									} else {
										echo $arResult["IN_CART_QUANTITY"];
									}
									?>

								</span> шт</div>
						</div>
						<button onclick="changeValItem('+')"><svg width="20" height="19" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M0 8.5h20v2H0v-2Z" fill="#FFFFFF"></path>
								<path d="M9 20.5V.5h2v20H9Z" fill="#FFFFFF"></path>
							</svg></button>
					</div>
					<div class="incorrect-quantity"></div>
					<form action="<?= POST_FORM_ACTION_URI ?>" method="post" enctype="multipart/form-data" сlass="add_form">
						<input type="hidden" name="<?= $arParams["ACTION_VARIABLE"] ?>" value="BUY">
						<input type="hidden" name="<?= $arParams["PRODUCT_ID_VARIABLE"] ?>" value="<?= $arResult['ITEM']['ID'] ?>">
						<div class="element__buy-button">
							<? if (!empty($arResult['OFFERS'][0]['PRICES'])) : ?>
								<input class="element__buy-input" type="submit" name="<?= $arParams["ACTION_VARIABLE"] . "ADD2BASKET" ?>" value="В корзину">
								<div class="element__bag"></div>
							<? else : ?>
								<input class="element__buy-input disabled" type="submit" name="<?= $arParams["ACTION_VARIABLE"] . "ADD2BASKET" ?>" disabled value="В корзину">
								<div class="element__bag"></div>
								<div class="error">
									<div class="imformer imformer_no-price">У товара не указана цена, поэтому добавление в корзину невозможно. Пожалуйста, <a class="imformer__a_no-price" href="/contacts/" target="_blank">свяжитесь с нами</a>.</div>
								</div>
							<? endif; ?>
						</div>
						<div class="catalog-section__button-favorite element__button-favorite element__button-favorite_detail" id-el="365"></div>
					</form>
				</div>
			<? endif ?>


			<div class="element__bottom-content element__bottom-content_desktop">

				<div class="element__dropdown-block_wrapper">

					<? if (isset($arResult['PROPERTIES']["CML2_ATTRIBUTES"]["VALUE"]) && $arResult['PROPERTIES']["CML2_ATTRIBUTES"]["VALUE"] != "") : ?>
						<div class="dropdown-block__header">
							<span class="dropdown-block__span">Характеристики</span>
							<div class="dropdown-block__arrow"></div>
						</div>
						<div class="dropdown-block__content">
							<? foreach ($arResult['PROPERTIES']["CML2_ATTRIBUTES"]["VALUE"] as $key => $arAttr) : ?>
								<div class="dropdown-block__property">
									<div class="property__name">
										<?= $arResult['PROPERTIES']["CML2_ATTRIBUTES"]["VALUE"][$key] ?>
									</div>
									<div class="dropdown__bottom-line"></div>
									<div class="property__value">
										<?= $arResult['PROPERTIES']["CML2_ATTRIBUTES"]["DESCRIPTION"][$key] ?>
									</div>
								</div>
							<? endforeach; ?>
						</div>
					<? endif; ?>


					<? if ($detailText) : ?>
						<h5 class="dropdown-block__span">Описание</h5>
						<div class="dropdown-block__content-description">
							<p><?= $detailText ?></p>
						</div>
					<? endif; ?>
				</div>
				<div class="element__text">Стоимость и сроки доставки, рассчитываются по тарифу курьерской службы</div>
				<? $APPLICATION->IncludeComponent(
					"bitrix:main.include",
					".default",
					array(
						"AREA_FILE_SHOW" => "file",
						"COMPONENT_TEMPLATE" => ".default",
						"PATH" => "/local/templates/Abysshabidecor/includes/detail_delivery.php"
					)
				); ?>
			</div>
		</div>
	</div>
</div>
<div class="container element__bottom-content element__bottom-content_mobile">
	<div class="element__dropdown-block_wrapper">
		<div class="element__dropdown-block__content">
			<? if (isset($arResult['PROPERTIES']["CML2_ATTRIBUTES"]["VALUE"]) && $arResult['PROPERTIES']["CML2_ATTRIBUTES"]["VALUE"] != "") : ?>
				<div class="dropdown-block__header">
					<span class="dropdown-block__span">Характеристики</span>
					<div class="dropdown-block__arrow"></div>
				</div>
				<div class="dropdown-block__content">
					<? foreach ($arResult['PROPERTIES']["CML2_ATTRIBUTES"]["VALUE"] as $key => $arAttr) : ?>
						<div class="dropdown-block__property">
							<div class="property__name">
								<?= $arResult['PROPERTIES']["CML2_ATTRIBUTES"]["VALUE"][$key] ?>
							</div>
							<div class="dropdown__bottom-line"></div>
							<div class="property__value">
								<?= $arResult['PROPERTIES']["CML2_ATTRIBUTES"]["DESCRIPTION"][$key] ?>
							</div>
						</div>
					<? endforeach; ?>
				</div>
			<? endif; ?>
			<? if ($arResult['PROPERTIES']['COMPOUND']['~VALUE']['TEXT']) : ?>
				<hr class="dropdown-block__line">
				<div class="dropdown-block__header">
					<span class="dropdown-block__span"><?= $arResult['PROPERTIES']['COMPOUND']['NAME'] ?></span>
					<div class="dropdown-block__arrow"></div>
				</div>
				<div class="dropdown-block__content dropdown-block__content-compound">
					<?= $arResult['PROPERTIES']['COMPOUND']['~VALUE']['TEXT'] ?>
				</div>
			<? endif; ?>

			<? if ($detailText) : ?>
				<hr class="dropdown-block__line">
				<h5 class="dropdown-block__span">Описание</h5>
				<div class="dropdown-block__content-description">
					<p><?= $detailText ?></p>
				</div>
				<?/*
				<div class="dropdown-block__header">
					<span class="dropdown-block__span">Описание</span>
					<div class="dropdown-block__arrow"></div>
				</div>
				<div class="dropdown-block__content dropdown-block__content-description">
					<p><?= $detailText ?></p>
				</div>
				*/?>

			<? endif; ?>
			<div class="element__text">Стоимость и сроки доставки, рассчитываются<br> по тарифу курьерской службы</div>
		</div>
		<div class="footer__contacts-wrapper">
			<? $APPLICATION->IncludeComponent(
				"bitrix:main.include",
				".default",
				array(
					"AREA_FILE_SHOW" => "file",
					"COMPONENT_TEMPLATE" => ".default",
					"PATH" => "/local/templates/Abysshabidecor/includes/detail_delivery.php"
				)
			); ?>
		</div>

	</div>
</div>
</div>