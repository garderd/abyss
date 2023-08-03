<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
if(isset($arResult['SECTIONS']['SECTIONS_CHILD'])){
    $count_slides = count($arResult['SECTIONS']['SECTIONS_CHILD']);
}
else{
    $count_slides = 0;
}

?>

<div class="catalog-section__header"
    style="background-image: url(<?=CFile::GetPath($arResult['SECTIONS'][0]['PICTURE'])?>);">
    <div class="container">
        <h1 class="catalog-section__h1"><?=$arResult['SECTIONS'][0]['NAME']?></h1>
    </div>
</div>
<?if(isset($arResult['SECTIONS']['SECTIONS_CHILD'])):?>
<div class="catalog-section__collection">
    <div class="container catalog-section-slider-wrapper" style="padding: 0 !important">
        <?if($count_slides > 7):?>
            <div class="button button-prev">
                <div class="arrow-left"></div>
            </div>
        <?endif?>
        <div class="catalog-section__link-slider <?if($count_slides <= 7) echo 'noafter nobefore'?>">
            <div class="catalog-section__link-wrapper swiper-wrapper">
                <?foreach($arResult['SECTIONS']['SECTIONS_CHILD'] as $arSection):?>
                <?if($arSection['DEPTH_LEVEL'] != 1):?>
                <a class="catalog-section__link swiper-slide" href="<?=$arSection['SECTION_PAGE_URL']?>">
                    <?
                        $resImage = CFile::ResizeImageGet(
                            $arSection['PICTURE'],
                            array("width" => 300, "height" => 300),
                            BX_RESIZE_IMAGE_PROPORTIONAL
                            );
                    ?>
                    <img class="catalog-section__link-img" src="<?=$resImage['src']?>"
                        alt="<?=$arSection['NAME']?>">
                    <span class="catalog-section__link-span"><?=$arSection['NAME']?></span>
                </a>
                <?endif;?>
                <?endforeach;?>
            </div>
        </div>
        <?if($count_slides > 7):?>
            <div class="button button-next">
                <div class="arrow-right"></div>
            </div>
        <?endif;?>
    </div>
</div>
<div class="catalog-list-slider-pagination_wrapper">
    <div class="container catalog-list-slider-pagination"></div>
</div>
<?endif;?>
<?
if($arResult['COUNT_SLASH'] > 3){
    $APPLICATION->AddChainItem('Коллекции','/katalog/kollektsii/');
}
?>
<?$APPLICATION->AddChainItem($arResult['SECTIONS'][0]['NAME']);?>

<script type="text/javascript">
const collect = new Swiper('.catalog-section__link-slider', {
    direction: 'horizontal',
    watchOverflow: true,
    loop: false,
    pagination: {
        el: ".catalog-list-slider-pagination",
        type: 'bullets'
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
$(".catalog-section__collection .button-prev").on("click", function() {
    collect.slidePrev();
});
$(".catalog-section__collection .button-next").on("click", function() {
    collect.slideNext();
})
</script>
<style>
    <?if($count_slides >= 5):?>
    @media screen and (max-width: 1400px) {
            
        .catalog-section__link-slider.noafter:after{
            display: block;
        }
        .catalog-section__link-slider.nobefore:before{
            display: block;
        }
    }
    <?endif?>
</style>