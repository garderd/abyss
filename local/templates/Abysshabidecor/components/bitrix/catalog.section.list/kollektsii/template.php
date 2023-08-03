<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
?>
<?
	$i = 0;
?>
<?foreach($arResult["SECTIONS"] as $arSection):?>
	<?$count_slides = 0;?>
	<?foreach($arResult['SECTIONS_CHILD'] as $arSectionChild):?>
		<?if($arSectionChild['CODE'] == $arSection['CODE']):?>
			<?$count_slides++?>
		<?endif;?>
	<?endforeach;?>
	<?if($arSection['DEPTH_LEVEL'] == 1):?>
		<div class="catalog-section__header"
			style="background-image: url(<?=CFile::GetPath($arSection['PICTURE']['ID'])?>);">
			<div class="container">
				<h1 class="catalog-section__h1"><?=$arSection['NAME']?></h1>
			</div>
		</div>
		<?if($arResult['SECTIONS_CHILD']):?>
			<div class="catalog-section__collection catalog-section__collection-<?=$i?>">
				<div class="container catalog-section-slider-wrapper" style="padding: var(--padding-0-15) !important;">
					<?//if($count_slides < 7):?>
						<div class="button button-prev">
							<div class="arrow-left"></div>
						</div>
					<?//endif?>
					<div class="catalog-section__link-slider collection-slider-<?=$i?> <?if($count_slides <= 7) echo 'noafter nobefore'?>" style="">
						<div class="catalog-section__link-wrapper swiper-wrapper">
						<?foreach($arResult['SECTIONS_CHILD'] as $arSectionChild):?>
						<?if($arSectionChild['CODE'] == $arSection['CODE']):?>

						<a class="catalog-section__link swiper-slide" href="<?=$arSectionChild['SECTION_PAGE_URL']?>">
							<img class="catalog-section__link-img" src="<?=CFile::GetPath($arSectionChild['PICTURE'])?>"
								alt="<?=$arSectionChild['NAME']?>">
							<span class="catalog-section__link-span"><?=$arSectionChild['NAME']?></span>
						</a>

						<?endif;?>
						<?endforeach;?>
						</div>
					</div>
					<?//if($count_slides > 7):?>
						<div class="button button-next">
							<div class="arrow-right"></div>
						</div>
					<?//endif;?>
				</div>
			</div>
			<div class="catalog-list-slider-pagination_wrapper">
				<div class="container catalog-list-slider-pagination collection-slider-<?=$i?>-pagination"></div>
			</div>
			<script type="text/javascript">
				const collect<?=$i?> = new Swiper('.collection-slider-<?=$i?>', {
					direction: 'horizontal',
					watchOverflow: true,
					loop: false,
					pagination: {
						el: ".collection-slider-<?=$i?>-pagination",
						type: 'bullets'
					},
					navigation: {
						nextEl: '.catalog-section__collection-<?=$i?> .button-next',
						prevEl: '.catalog-section__collection-<?=$i?> .button-prev',
					},
					breakpoints: {
						320: {
							slidesPerView: 2.65,
							spaceBetween: 30,
						},
						440:{
							slidesPerView: 3.5,
							spaceBetween: 30,
						},
						768: {
							slidesPerView: 4.5,
							spaceBetween: 20,
						},
						992: {
							slidesPerView: 5,
							spaceBetween: 30,
						},
						1200: {
							slidesPerView: 6,
							spaceBetween: 30,
						},
						1400: {
							slidesPerView: 7,
							spaceBetween: 30,
						}
					},

				});
			</script>

			<?$i++?>
		<?endif;?>
	<?endif;?>
<?endforeach;?>

