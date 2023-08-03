<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

/**
 * @var array $arParams
 */
?>
<script id="basket-total-template" type="text/html">
	<div class="cart-check" data-entity="basket-checkout-aligner">

		<?if ($arParams['HIDE_COUPON'] !== 'Y'):?>

			<div class="basket-coupon-section">
				<div class="basket-coupon-block-field">
					<div class="basket-coupon-block-field-description">
						Промокод
					</div>
					<div class="form">
						<div class="form-group" style="position: relative;">
							<input type="text" class="form-control" id="" placeholder="" data-entity="basket-coupon-input">
							<span class="basket-coupon-block-coupon-btn"></span>
						</div>
					</div>
				</div>
				<?
					if ($arParams['HIDE_COUPON'] !== 'Y')
					{
					?>
						<div class="basket-coupon-alert-section">
							<div class="basket-coupon-alert-inner">
								{{#COUPON_LIST}}
								<div class="basket-coupon-alert text-{{CLASS}}">
									<span class="basket-coupon-text">
										<strong>{{COUPON}}</strong> - <?=Loc::getMessage('SBB_COUPON')?> {{JS_CHECK_CODE}}
										{{#DISCOUNT_NAME}}({{DISCOUNT_NAME}}){{/DISCOUNT_NAME}}
									</span>
									<span class="close-link" data-entity="basket-coupon-delete" data-coupon="{{COUPON}}">
										<?=Loc::getMessage('SBB_DELETE')?>
									</span>
								</div>
								{{/COUPON_LIST}}
							</div>
						</div>
						<?
					}
				?>
						</div>

					<?endif;?>

			<div class="cart-total-prop">
				<div class="cart-row">
					<div class="cart-row-left">Товары: x{{{COUNT_ITEMS}}} 
						{{#WEIGHT_FORMATED}}{{{WEIGHT_FORMATED}}}{{/WEIGHT_FORMATED}}
					</div>
					<div class="cart-row-right">{{{PRICE_WITHOUT_DISCOUNT_FORMATED}}}</div>
				</div>

				{{#DISCOUNT_PRICE_FORMATED}}
				<div class="cart-row discount">
					<div class="cart-row-left">Скидка</div>
					<div class="cart-row-right">{{{DISCOUNT_PRICE_FORMATED}}}</div>
				</div>
				{{/DISCOUNT_PRICE_FORMATED}}
				<hr>
				<div class="cart-row">
					<div class="cart-row-left">Стоимость без учета доставки:</div>
					<div class="cart-row-right">{{{PRICE_FORMATED}}}</div>
				</div>
				<div class="cart-imfo">
					Стоимость доставки и сроки доставки, заказанного товара рассчитывается в соответствии с тарифами курьерских служб или транспортных компаний
				</div>
				<button class="gray-btn gray-btn-100 {{#DISABLE_CHECKOUT}} disabled{{/DISABLE_CHECKOUT}}"
						data-entity="basket-checkout-button">
						<?=Loc::getMessage('SBB_ORDER')?>
				</button>
				
			</div>
	</div>
</script>