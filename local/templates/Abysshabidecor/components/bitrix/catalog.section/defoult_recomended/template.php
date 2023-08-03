<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);
?>




<? if (!empty($arResult['ITEMS'] && $arResult['ITEMS'] != '')) : ?>
	<div class="catalog-element__slider <? if ($arParams['WHITE_BG']) {
											echo " catalog-element__slider_white ";
										} ?> catalog-element__slider-default catalog-element__slider-mobile-white">
		<div class="container catalog-section__element-wrapper">
			<div class="element-slider-collection">
				<div class="element-slider__header align-items-center d-flex justify-content-between">
					<h3 class="element-slider__h3"><?= $arParams['TITLE'] ?></h3>
					<? if (count($arResult["ITEMS"]) > 4) : ?>
						<div class="arrows d-flex ">
							<div class="button button-prev">
								<div class="arrow-left"></div>
							</div>
							<div class="button button-next">
								<div class="arrow-right"></div>
							</div>
						</div>
					<? endif; ?>
				</div>
				<div class="swiper-wrapper">
					<? foreach ($arResult["ITEMS"] as $cell => $arElement) : ?>
						<?
						$this->AddEditAction($arElement['ID'], $arElement['EDIT_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT"));
						$this->AddDeleteAction($arElement['ID'], $arElement['DELETE_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BCS_ELEMENT_DELETE_CONFIRM')));
						?>
						<div class="catalog-section__element swiper-slide" id="<?= $this->GetEditAreaId($arElement['ID']); ?>">
							<div class="section-element__border">
								<a class="section-element__link" href="<?= $arElement["DETAIL_PAGE_URL"] ?>" title="<?= $arElement["NAME"] ?>">
									<?
									if (isset($arElement["PREVIEW_PICTURE"]["ID"]) && $arElement["PREVIEW_PICTURE"]["ID"] != "") {
										$preview_picture = CFile::ResizeImageGet($arElement["PREVIEW_PICTURE"]["ID"], array('width' => 330, 'height' => 330), BX_RESIZE_IMAGE_EXACT, true);
									} else {
										$preview_picture['src'] = '/local/templates/Abysshabidecor/assets/img/no_photo.webp';
									}

									?>
									<img class="section-element__img" src="<?= $preview_picture['src'] ?>" alt="<?= $arElement["NAME"] ?>" />
									<span class="section-element__name"><?= $arElement["NAME"] ?></span>
								</a>


								<? if (is_array($arElement["OFFERS"]) && !empty($arElement["OFFERS"])) : ?>
									<? foreach ($arElement["OFFERS"] as $arOffer) : ?>
										<?
										if ($arOffer['CAN_BUY'] == "") {
											$arOffer['CAN_BUY'] = 1;
										}
										?>
										<? $offers_can_buy[] = $arOffer['CAN_BUY'] ?>
										<? if ($arOffer['CAN_BUY']) : ?>
											<? foreach ($arOffer["PRICES"] as $code => $arPrice) : ?>
												<? if ($arPrice["CAN_ACCESS"]) : ?>
													<?
													$price['min'] = $arPrice["PRINT_VALUE"];
													$price['max'] = $arPrice["PRINT_DISCOUNT_VALUE"];
													$prices[] = $price;
													unset($price);
													?>
												<? endif ?>
											<? endforeach; ?>
										<? endif; ?>
									<? endforeach;
									if (is_array($offers_can_buy) && $offers_can_buy != "" && in_array(1, $offers_can_buy)) :

										foreach ($prices as $key => $arMinPrice) {
											$min_prices = $arMinPrice;
										}
									?>
										<? if (is_countable($offers_can_buy) && count($offers_can_buy) == 1) : ?>
											<? if ($arOffer['PRODUCT']['QUANTITY'] > 0) : ?>
												<? if ($min_prices['min'] != $min_prices['max']) : ?>
													<p class='section-element__price'><span class="catalog-section__discount-price"><?= $min_prices['min'] ?></span><?= $min_prices['max'] ?></p>
												<? else : ?>
													<p class='section-element__price'><?= $min_prices['min'] ?></p>
												<? endif; ?>
											<? else : ?>
												<p class='section-element__price'><?= $min_prices['min'] ?></p>
												<p class='section-element__price'>Под заказ</p>
											<? endif; ?>
										<? else : ?>
											<p class='section-element__price'>от <?= $min_prices['max'] ?></p>
										<? endif; ?>

										<?
										unset($prices);
										unset($min_price);
										unset($offers_can_buy);
										?>
									<? else : ?>
										<p class='section-element__price'>Нет в наличии</p>
									<? endif; ?>
									<?
									unset($offers_can_buy);
									?>
								<? else : ?>
									<? foreach ($arElement["PRICES"] as $code => $arPrice) : ?>
										<? if ($arElement['CAN_BUY']) : ?>
											<? if ($arPrice["CAN_ACCESS"]) : ?>
												<? if ($arPrice["DISCOUNT_VALUE"] < $arPrice["VALUE"]) : ?>
													<p class='section-element__price'><s class='section-element__old-price'><?= $arPrice["PRINT_VALUE"] ?></s>
														<?= $arPrice["PRINT_DISCOUNT_VALUE"] ?></p>
												<? else : ?>
													<p class='section-element__price'><?= $arPrice["PRINT_VALUE"] ?></p>
												<? endif; ?>
											<? endif; ?>
										<? else : ?>
											<p class='section-element__price'>Нет в наличии</p>
										<? endif ?>
									<? endforeach; ?>
								<? endif ?>
								<div class="catalog-section__button-favorite" id-el="<?= $arElement['ID'] ?>"></div>
							</div>
						</div>

					<? endforeach; ?>
				</div>
			</div>
		</div>
	</div>
<? endif; ?>