<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if (!empty($arResult)):?>
	<menu class="footer__menu_first">
		<span class="footer__menu-header">Каталог</span>
		<ul>
		<?foreach ($arResult as $arItem):?>
			<?if($arItem['DEPTH_LEVEL'] == 1):?>
			<li>
				<a href="<?=$arItem['LINK']?>"><?=$arItem['TEXT']?></a>
			</li>
			<?endif;?>
		<?endforeach;?>
		</ul>
	</menu>
	
<?endif?>