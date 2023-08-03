<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$this->setFrameMode(true);
$prices = array();
$offers_can_buy = array();
$show_element = 0;


?>
<div class="container catalog-section__element-wrapper">
    <? if (is_countable($arResult["ITEMS"]) && count($arResult["ITEMS"]) > 0) : ?>
        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4">

            <? foreach ($arResult["ITEMS"] as $cell => $arElement) : ?>
                    <?
                    $this->AddEditAction($arElement['ID'], $arElement['EDIT_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT"));
                    $this->AddDeleteAction($arElement['ID'], $arElement['DELETE_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BCS_ELEMENT_DELETE_CONFIRM')));
                    ?>

                    <div class="catalog-section__element" id="<?= $this->GetEditAreaId($arElement['ID']); ?>">
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
                                    <? //debug($arOffer); ?>
                                    <? 
                                        if($arOffer['CAN_BUY'] == ""){
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
                    
                    <? $show_element++; ?>
            <? endforeach; ?>
        </div>
        <?if($show_element == 0):?>
            <h2 class="contacts__h1">Раздел пока что пуст</h2>
        <?endif;?>
    <? else : ?>
        <h2 class="contacts__h1">Раздел пока что пуст</h2>
    <? endif; ?>
</div>
<? if ($arParams["DISPLAY_BOTTOM_PAGER"]) : ?>
    <?= $arResult["NAV_STRING"] ?>
<? endif; ?>

<?
if (substr_count($APPLICATION->GetCurPage(false), '/') > 3) : ?>
    <a href="<?= $arResult['ORIGINAL_PARAMETERS']['SECTION_PAGE_URL'] ?>" class="all_kolekt">Все коллекции</a>
<? endif; ?>