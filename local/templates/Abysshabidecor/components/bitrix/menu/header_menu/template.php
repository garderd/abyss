<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<? if (!empty($arResult)) : ?>
    <div class="container mobile-menu">
        <menu class="header__menu">
            <ul>

                <?
                $previousLevel = 0;
                foreach ($arResult as $key => $arItem) : ?>

                    <? if ($previousLevel && $arItem["DEPTH_LEVEL"] < $previousLevel) : ?>
                        <?= str_repeat("</ul></li>", ($previousLevel - $arItem["DEPTH_LEVEL"])); ?>
                    <? endif ?>

                    <? if ($arItem["IS_PARENT"]) : ?>

                        <? if ($arItem["DEPTH_LEVEL"] == 1) : ?>
                            <li>
                                <div class="menu-item">
                                    <a href="<?= $arItem["LINK"] ?>" class="<? if ($arItem["SELECTED"]) : ?>root-item-selected
                        <? else : ?>root-item
                        <? endif ?>"><?= $arItem["TEXT"] ?>
                                    </a>
                                    <div class="menu-item-arrow-wrapper">
                                        <div class="menu-item-arrow"></div>
                                    </div>
                                </div>
                                <ul class="header__submenu">
                                    <? $i = 0; ?>
                                    <? else : ?>
                                        <li <? if ($arItem["SELECTED"]) : ?> class="item-selected" <? endif ?>><a href="<?= $arItem["LINK"] ?>" class="parent"><?= $arItem["TEXT"] ?></a>
                                            <ul>
                                            <? endif ?>

                                            <? else : ?>

                                            <? if ($arItem["PERMISSION"] > "D") : ?>

                                                <? if ($arItem["DEPTH_LEVEL"] == 1) : ?>
                                                        <li>
                                                            <div class="menu-item">
                                                                <a href="<?= $arItem["LINK"] ?>" class="<? if ($arItem["SELECTED"]) : ?>selected <? endif ?>"><?= $arItem["TEXT"] ?></a>
                                                                <div class="fake"></div>
                                                            </div>
                                                        </li>
                                                        
                                                <? elseif($i < 8) : ?>
                                                    <li <? if ($arItem["SELECTED"]) : ?> class="item-selected" <? endif ?>><a href="<?= $arItem["LINK"] ?>"><?= $arItem["TEXT"] ?></a>
                                                    </li>
                                                 
                                                    <?$i++;?>
                                                <? endif ?>

                                            <? else : ?>

                                                <? if ($arItem["DEPTH_LEVEL"] == 1) : ?>
                                                    <li><a href="" class="<? if ($arItem[" SELECTED"]) : ?>root-item-selected
                                        <? else : ?>root-item
                                        <? endif ?>" title="<?= GetMessage("MENU_ITEM_ACCESS_DENIED") ?>"><?= $arItem["TEXT"] ?>
                                                        </a></li>
                                                <? else : ?>
                                                    <li><a href="" class="denied" title="<?= GetMessage("MENU_ITEM_ACCESS_DENIED") ?>"><?= $arItem["TEXT"] ?></a></li>
                                                <? endif ?>

                                            <? endif ?>

                                        <? endif ?>

                                        <? $previousLevel = $arItem["DEPTH_LEVEL"]; ?>

                                    <? endforeach ?>

                                    <? if ($previousLevel > 1) : //close last item tags
                                    ?>
                                        <?= str_repeat("</ul></li>", ($previousLevel - 1)); ?>
                                    <? endif ?>

                                            </ul>
                                            <div class="menu-clear-left"></div>
                                </ul>
                                <div class="header__top-icons ">
                                    <a <? if (!$USER->IsAuthorized()) echo 'class="icons__person"';
                                        else echo 'href="/personal/"' ?> style="margin-left: 0">
                                        <img src="<?= SITE_TEMPLATE_PATH ?>/assets/img/icons/person.svg" alt="">
                                    </a>
                                    <a href="/favorities/" ?>
                                        <img src="<?= SITE_TEMPLATE_PATH ?>/assets/img/icons/heart.svg" alt="">
                                    </a>
                                    <a href="/cart/" class="header__basket">
                                        <img src="<?= SITE_TEMPLATE_PATH ?>/assets/img/icons/bag.svg" alt="">
                                        <? if ($GLOBALS['basketItems'] > 0) : ?>
                                            <div class="header-basket__circle"><?= $GLOBALS['basketItems']; ?></div>
                                        <? endif; ?>
                                    </a>
                                    <a href="javascript:void(0)">
                                        <img class="form-button" src="<?= SITE_TEMPLATE_PATH ?>/assets/img/icons/search.svg" alt="">
                                        <? $APPLICATION->IncludeComponent(
                                            "bitrix:search.form",
                                            "search_form",
                                            array(
                                                "PAGE" => "#SITE_DIR#search/index.php", // Страница выдачи результатов поиска (доступен макрос #SITE_DIR#)
                                                "USE_SUGGEST" => "N",   // Показывать подсказку с поисковыми фразами
                                            ),
                                            false
                                        ); ?>
                                    </a>
                                </div>

                                <a class="mobile_link" href="/o-nas/">О нас</a>
                                <a class="mobile_link" href="/contacts/">Контакты</a>
                                <a class="mobile_link" href="/payment_and_delivery/">Оплата и доставка</a>

        </menu>
    <? endif; ?>

