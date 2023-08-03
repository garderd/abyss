<?
global $APPLICATION;
 
if(!$USER->IsAuthorized())
{
    $arFavorites = unserialize($_COOKIE["favorites"]);
}
else {
    $idUser = $USER->GetID();
    $rsUser = CUser::GetByID($idUser);
    $arUser = $rsUser->Fetch();
    $arFavorites = $arUser['UF_FAVORITES'];  // Достаём избранное пользователя
}
/* Меняем отображение сердечка товара */
foreach($arFavorites as $k => $favoriteItem):?>

    <script>
        if($('.catalog-section__button-favorite[id-el="'+<?=$favoriteItem?>+'"]'))
            $('.catalog-section__button-favorite[id-el="'+<?=$favoriteItem?>+'"]').addClass('catalog-section__button-favorite_active');
    </script>
<?endforeach;?>
