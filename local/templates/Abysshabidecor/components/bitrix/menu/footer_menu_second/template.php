<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if (!empty($arResult)):?>
	<menu class="footer__menu_second">
		<ul>
		<?foreach ($arResult as $arItem):?>
			<li>
				<a href="<?=$arItem['LINK']?>"><?=$arItem['TEXT']?></a>
			</li>
		<?endforeach;?>
		</ul>
	</menu>
	
<?endif?>