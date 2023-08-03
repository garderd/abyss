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
?>

<div class="background-super-light-gray">
    <div class="container">
        <div class="d-flex align-items-center main-block section-main-page <?if(count($arResult['ITEMS']) > 1) echo 'section-slider'?>">
            <div class="swiper-wrapper">
                <?foreach($arResult['ITEMS'] as $arItem):?>
                <div class="swiper-slide">
                    <div class="d-flex flex-row justify-content-center align-items-center">
                        <div class="slide-content">
                            <h3 class="section-main-page__header"><?=$arItem['NAME']?></h3>
                            <p class="section-main-page__description">
                                <?=$arItem['PREVIEW_TEXT']?>
                            </p>
                            <p>
                                <img class="img-small" src="<?=CFile::GetPath($arItem['PROPERTIES']['IMAGE_SMALL']['VALUE'])?>"
                                    alt="<?=$arItem['NAME']?>">
                            </p>
                            <p>
                                <a class="link-arrow"
                                    href="<?=$arItem['PROPERTIES']['SECTION_PAGE_URL']['VALUE']?>"><span>Подробнее</span></a>
                            </p>
                        </div>
                        <div class="slide-content">
                            <p>
                                <img class="img-big" src="<?=CFile::GetPath($arItem['PROPERTIES']['IMAGE_BIG']['VALUE'])?>"
                                    alt="<?=$arItem['NAME']?>">
                            </p>
                        </div>
                    </div>
                </div>
                <?endforeach;?>
            </div>
            <?if(count($arResult['ITEMS']) > 1):?>
                <div class="section-slider__button-wrapper">
                    <div class="button button_super-light-gray button-prev">
                        <div class="arrow-left"></div>
                    </div>
                    <div class="button button_super-light-gray button-next">
                        <div class="arrow-right"></div>
                    </div>
                </div>
            <?endif;?>
        </div>
    </div>
</div>
