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
$this->setFrameMode(true);?>
<div class="search-form">
    <form class="d-flex" action="<?=$arResult["FORM_ACTION"]?>">
        <input class="search-form__text" type="text" name="q" value="" maxlength="50" />
        <input class="search-form__submit" name="s" type="submit" value="" />
    </form>
</div>