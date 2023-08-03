<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;
?>
<?$APPLICATION->SetTitle("Заказов пока нет");?>
<div class="container">
	<div class="favorites">	
		<h1 class="contacts__h1"><?$APPLICATION->showTitle(false)?></h1>
		<a href="/katalog/" class="hr__personal gray-btn gray-btn__bug  d-flex align-items-center" >
			<div class="element__bag" style="position: static;"></div> 
			За покупками
		</a>
	</div>
</div>	