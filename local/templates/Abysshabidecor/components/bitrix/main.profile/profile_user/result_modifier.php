<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)die();
foreach($arResult['arUser']['UF_FAVORITES'] as $arFavoritesId){
        $idFavorites[] = $arFavoritesId;
}
    
$arResult["FAVORITES"] =  $idFavorites;

?>

