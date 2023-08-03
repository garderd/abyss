<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Оплата и доставка");
?><div class="container">
	 <?$APPLICATION->IncludeComponent(
	"bitrix:breadcrumb",
	"breadcrumb",
	Array(
		"PATH" => "",
		"SITE_ID" => "s1",
		"START_FROM" => "0"
	)
);?>
</div>
<div class="container personal__wrapper payment_and_return">
	<div class="d-flex justify-content-start tabs__wrapper">
		<div class="tabs__header-wrapper">
 <a href="/payment_and_delivery/" class="fake-tab__header active">
			<h3 class="tab__h3">Оплата и доставка</h3>
			<div class="tab__header-arrow">
			</div>
 </a> <a href="#self" data-tab="self" class="fake-tab__sub-link tab-change">Самовывоз по Москве </a> <a href="#courier" data-tab="courier" class="fake-tab__sub-link tab-change">Курьером по Москве </a> <a href="#sdek" data-tab="sdek" class="fake-tab__sub-link tab-change">СДЕК в пункт выдачи </a> <a href="/exchange_and_return/" class="fake-tab__header">
			<h3 class="tab__h3">Обмен и возврат</h3>
			<div class="tab__header-arrow">
			</div>
 </a>
		</div>
		<div class="payment__slider-menu">
			<div class="swiper-wrapper">
 <a href="/payment_and_delivery/" class="fake-tab__header active swiper-slide">
				<h3 class="tab__h3">Оплата и доставка</h3>
				<div class="tab__header-arrow">
				</div>
 </a> <a href="/exchange_and_return/" class="fake-tab__header swiper-slide">
				<h3 class="tab__h3">Обмен и возврат</h3>
				<div class="tab__header-arrow">
				</div>
 </a>
			</div>
		</div>
		<div class="tabs__content-wrapper">
			<div class="tab__content">
				<h2>Оплата</h2>
				<div class="delivery-items-block oplata-block">
					<div class="delivery_item delivery_item-top">
						<div class="delivery_item_header">
							 Онлайн-оплата на сайте
						</div>
 <img src="/local/templates/Abysshabidecor/assets/img/icons/icon _bank card 2_.png"> <b>Бесплатно</b>
						<div>
							 Доступна при любых способах доставки
						</div>
						<div>
							 Операции проходят через сервис онлайн-платежей Альфа Банка
						</div>
						<div class="card-block">
 <img src="/local/templates/Abysshabidecor/assets/img/icons/visalogo.svg"> <img src="/local/templates/Abysshabidecor/assets/img/icons/Mastercardlogo.svg"> <img src="/local/templates/Abysshabidecor/assets/img/icons/mirlogo.svg">
						</div>
					</div>
					<div class="delivery_item delivery_item-top">
						<div class="delivery_item_header">
							 Оплата наличными
						</div>
 <img src="/local/templates/Abysshabidecor/assets/img/icons/wallet.png"> <b>Бесплатно</b>
						<div>
							 Доступна только при самовывозе и доставке курьером по Москве
						</div>
					</div>
				</div>
				<h2 class="top_margin">Доставка</h2>
				<div class="payment-tabs__header">
 <a href="#self" data-tab="self" id="self" class="payment-tabs__header-item tab-change">Самовывоз в Москве
					<div class="tab__header-arrow tab__header-arrow_grey-mobile">
					</div>
 </a> <a href="#courier" data-tab="courier" id="courier" class="payment-tabs__header-item tab-change">Курьером по Москве
					<div class="tab__header-arrow tab__header-arrow_grey-mobile">
					</div>
 </a> <a href="#sdek" data-tab="sdek" id="sdek" class="payment-tabs__header-item tab-change">СДЕК в пункт выдачи
					<div class="tab__header-arrow tab__header-arrow_grey-mobile">
					</div>
 </a>
				</div>
				<div class="payment-tabs-wrapper">
					<div data-tab="self" class="payment-tabs__tab">
						<div class="delivery-items-block_and_text">
							<div class="delivery_item">
								<div class="delivery_item_header">
									 Самовывоз в москве
								</div>
 <img src="/local/templates/Abysshabidecor/assets/img/icons/icon _teacher man_.png"> <b>Бесплатно</b>
								<div>
									 Заберите заказ по адресу: Москва, Варшавское шоссе дом 7 офис 14
								</div>
							</div>
						</div>
						<div class="map">
							 <script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3Aebaece8bf3ab087b309ae47b06ea3b28e0014f8c51e34fac38c76fc4d02482df&amp;width=100%25&amp;height=345&amp;lang=ru_RU&amp;scroll=false"></script>
						</div>
						<div class="img-block">
 <img src="/local/templates/Abysshabidecor/assets/img/Самовывоз в Москве-1.webp"> <img src="/local/templates/Abysshabidecor/assets/img/Самовывоз в Москве-2.webp">
						</div>
					</div>
					<div data-tab="courier" class="payment-tabs__tab">
						<div class="delivery-items-block_and_text">
							<div class="delivery_item">
								<div class="delivery_item_header">
									 Доставка курьером по&nbsp;Москве
								</div>
 <img src="/local/templates/Abysshabidecor/assets/img/icons/icon _box 3d_.png"> <b>В пределах МКАД: 500 ₽, бесплатно при заказе от 20 000 ₽.</b> <b>До 10 км от МКАД: 800 ₽.</b> <b>От 10 км от МКАД: 800 + 80 ₽ за каждый км.</b>
								<div>
									 Курьерская служба свяжется с&nbsp;вами для&nbsp;согласования даты и&nbsp;времени доставки
								</div>
							</div>
						</div>
					</div>
					<div data-tab="sdek" class="payment-tabs__tab">
						<div class="delivery-items-block_and_text">
							<div class="delivery_item">
								<div class="delivery_item_header">
									 СДЕК доставка в пункт выдачи
								</div>
 <img src="/local/templates/Abysshabidecor/assets/img/icons/WwRC73vQdmjyYz-FuqiKlHCMWdW2xv0P 1.png"> <b>от 240 ₽</b>
								<div>
									 Выберите пункт выдачи и дату доставки
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<br><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>