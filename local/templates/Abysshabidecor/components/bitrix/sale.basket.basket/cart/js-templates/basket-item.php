<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

/**
 * @var array $mobileColumns
 * @var array $arParams
 * @var string $templateFolder
 */

$usePriceInAdditionalColumn = in_array('PRICE', $arParams['COLUMNS_LIST']) && $arParams['PRICE_DISPLAY_MODE'] === 'Y';
$useSumColumn = in_array('SUM', $arParams['COLUMNS_LIST']);
$useActionColumn = in_array('DELETE', $arParams['COLUMNS_LIST']);

$restoreColSpan = 2 + $usePriceInAdditionalColumn + $useSumColumn + $useActionColumn;

$positionClassMap = array(
	'left' => 'basket-item-label-left',
	'center' => 'basket-item-label-center',
	'right' => 'basket-item-label-right',
	'bottom' => 'basket-item-label-bottom',
	'middle' => 'basket-item-label-middle',
	'top' => 'basket-item-label-top'
);

$discountPositionClass = '';
if ($arParams['SHOW_DISCOUNT_PERCENT'] === 'Y' && !empty($arParams['DISCOUNT_PERCENT_POSITION']))
{
	foreach (explode('-', $arParams['DISCOUNT_PERCENT_POSITION']) as $pos)
	{
		$discountPositionClass .= isset($positionClassMap[$pos]) ? ' '.$positionClassMap[$pos] : '';
	}
}

$labelPositionClass = '';
if (!empty($arParams['LABEL_PROP_POSITION']))
{
	foreach (explode('-', $arParams['LABEL_PROP_POSITION']) as $pos)
	{
		$labelPositionClass .= isset($positionClassMap[$pos]) ? ' '.$positionClassMap[$pos] : '';
	}
}
?>


<script id="basket-item-template" type="text/html">

	<div
		class="bakset-var1__items__item"
		id="basket-item-{{ID}}"
		data-entity="basket-item"
		data-id="{{ID}}"
	>
		{{#SHOW_RESTORE}}
			<div
				class="basket-items-list-item-notification-removed"
				id="basket-item-height-aligner-{{ID}}"
			>
				<div class="basket-items-list-item-removed-container">

					<? echo Loc::getMessage('SBB_GOOD_CAP'); ?>
					{{NAME}}
					<? echo Loc::getMessage('SBB_BASKET_ITEM_DELETED'); ?>.


					<div class="basket-items-list-item-removed-block">

						<span
							class="basket-items-list-item-removed-block__restore  link-var4"
							data-entity="basket-item-restore-button"
						>
							<? echo Loc::getMessage('SBB_BASKET_ITEM_RESTORE')?>
						</span>


						<span
							class="basket-items-list-item-removed-block__close  link-var4"
							data-entity="basket-item-close-restore-button"
						>
							Закрыть сообщение
						</span>
					</div>
				</div>

				{{#SHOW_LOADING}}
					<div class="basket-items-list-item-overlay"></div>
				{{/SHOW_LOADING}}
			</div>
		{{/SHOW_RESTORE}}



		{{^SHOW_RESTORE}}
			<div
				class="
					bakset-var1__items__item__td
					bakset-var1__items__block-picture
				"
			>

				<a
					href="{{DETAIL_PAGE_URL}}"
					class="bakset-var1__items__item__label"
					style="background-image: url({{{IMAGE_URL}}}{{^IMAGE_URL}}<? echo $templateFolder?>/images/no_photo.png{{/IMAGE_URL}});"
				>
				</a>
			</div>



			<div class="bakset-var1__items__item__td bakset-var1__items__block-description">


				<a href="{{DETAIL_PAGE_URL}}" class="bakset-var1__items__items__name" data-entity="basket-item-name">
					{{#DETAIL_PAGE_URL}}
						{{NAME}}
					{{/DETAIL_PAGE_URL}}
				</a>
				<?/*
				<div class="w-100">
					<div class="bakset-var1__items__items__remove-item" data-entity="basket-item-delete">
						
						<img src="/upload/close.svg" width="15" height="15" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">	
						Удалить
					</div>
				</div>*/?>


				{{#NOT_AVAILABLE}}
					<div class="basket-items-list-item-warning-container">
						<div class="alert alert-warning text-center">
							<? echo Loc::getMessage('SBB_BASKET_ITEM_NOT_AVAILABLE')?>.
						</div>
					</div>
				{{/NOT_AVAILABLE}}
				{{#DELAYED}}
					<div class="basket-items-list-item-warning-container">
						<div class="alert alert-warning text-center">
							<? echo Loc::getMessage('SBB_BASKET_ITEM_DELAYED')?>.
							<a href="javascript:void(0)" data-entity="basket-item-remove-delayed">
								<? echo Loc::getMessage('SBB_BASKET_ITEM_REMOVE_DELAYED')?>
							</a>
						</div>
					</div>
				{{/DELAYED}}



				{{#SHOW_LOADING}}
					<div class="basket-items-list-item-overlay">
					</div>
				{{/SHOW_LOADING}}
			</div>

				<div class="basket-item-block-properties basket-item__null-tovar bakset-var1__items__item__td">
					{{#NULL_QUANTITY}}
						<div class="basket-item__null-tovar-circle">!</div>
						<div class="basket-item__text">
							Товар доступен по предзаказу, наш менеджер свяжется с вами и уточнит сроки поставки!
						</div>
					{{/NULL_QUANTITY}}
				</div>


			<div
				class="
					bakset-var1__items__item__td
					bakset-var1__items__block-price
				"
			>
				<div class="basket-item-block-price">


					<div
						class="
							basket-item-price-current
						"
						id="basket-item-price-{{ID}}"
						{{#SHOW_DISCOUNT_PRICE}}
						style="color: #9f0020;"
						{{/SHOW_DISCOUNT_PRICE}}
					>
						<b>{{{PRICE_FORMATED}}}</b>
					</div>


					{{#SHOW_DISCOUNT_PRICE}}
						<div class="basket-item-price-old">
							{{{FULL_PRICE_FORMATED}}}
						</div>
					{{/SHOW_DISCOUNT_PRICE}}


					{{#SHOW_LOADING}}
						<div class="basket-items-list-item-overlay"></div>
					{{/SHOW_LOADING}}
				</div>

			</div>

			

			<div
				class="
					bakset-var1__items__item__td
					bakset-var1__items__block-amount
				"
			>
				<div class="basket-item-block-amount{{#NOT_AVAILABLE}} disabled{{/NOT_AVAILABLE}}"
					data-entity="basket-item-quantity-block">
					<span class="basket-item-amount-btn-minus" data-entity="basket-item-quantity-minus"></span>
					<div class="basket-item-amount-filed-block">
						<input type="text" class="basket-item-amount-filed" value="{{QUANTITY}}"
							{{#NOT_AVAILABLE}} disabled="disabled"{{/NOT_AVAILABLE}}
							data-value="{{QUANTITY}}" data-entity="basket-item-quantity-field"
							id="basket-item-quantity-{{ID}}">
					</div>
					<span class="basket-item-amount-btn-plus" data-entity="basket-item-quantity-plus"></span>
					{{#SHOW_LOADING}}
						<div class="basket-items-list-item-overlay"></div>
					{{/SHOW_LOADING}}
				</div>
				{{#WARNINGS.length}}
					<div class="basket-items-list-item-warning-container">
						<div class="alert alert-warning alert-dismissable" data-entity="basket-item-warning-node">
							<!-- <span class="close" data-entity="basket-item-warning-close">&times;</span> -->
								{{#WARNINGS}}
									<div data-entity="basket-item-warning-text">В наличии только {{AVAILABLE_QUANTITY}} шт</div>
								{{/WARNINGS}}
						</div>
					</div>
			{{/WARNINGS.length}}
			</div>
			<div class="bakset-var1__items__items__remove-item" data-entity="basket-item-delete">	
				<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M7.54688 2.39062H7.3125C7.44141 2.39062 7.54688 2.28516 7.54688 2.15625V2.39062H16.4531V2.15625C16.4531 2.28516 16.5586 2.39062 16.6875 2.39062H16.4531V4.5H18.5625V2.15625C18.5625 1.12207 17.7217 0.28125 16.6875 0.28125H7.3125C6.27832 0.28125 5.4375 1.12207 5.4375 2.15625V4.5H7.54688V2.39062ZM22.3125 4.5H1.6875C1.16895 4.5 0.75 4.91895 0.75 5.4375V6.375C0.75 6.50391 0.855469 6.60938 0.984375 6.60938H2.75391L3.47754 21.9316C3.52441 22.9307 4.35059 23.7188 5.34961 23.7188H18.6504C19.6523 23.7188 20.4756 22.9336 20.5225 21.9316L21.2461 6.60938H23.0156C23.1445 6.60938 23.25 6.50391 23.25 6.375V5.4375C23.25 4.91895 22.8311 4.5 22.3125 4.5ZM18.4248 21.6094H5.5752L4.86621 6.60938H19.1338L18.4248 21.6094Z" fill="#969696"/>
				</svg>
			</div>


		{{/SHOW_RESTORE}}
	</div>
</script>