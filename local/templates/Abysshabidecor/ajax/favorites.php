<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
global $APPLICATION;
$APPLICATION->SetTitle(" ");
$GLOBALS['APPLICATION']->RestartBuffer();
use Bitrix\Main\Application;
use Bitrix\Main\Web\Cookie;
$application = Application::getInstance();
$context = $application->getContext();
/* Избранное */
if($_GET['id'])
{
    if(!$USER->IsAuthorized()) // Для неавторизованного
    {
        $arElements = unserialize($_COOKIE["favorites"]);
        if(!in_array($_GET['id'], $arElements))
        {
            $arElements[] = $_GET['id'];
            $result = 1; // Датчик. Добавляем
        }
        else {
            $key = array_search($_GET['id'], $arElements); // Находим элемент, который нужно удалить из избранного
            unset($arElements[$key]);
            
            $result = 2; // Датчик. Удаляем
        }
        setcookie("favorites", serialize($arElements), time() + 60*60*24*60, "/", "abysshabidecor.ru");
    }
    else { // Для авторизованного
        $idUser = $USER->GetID();
        $rsUser = CUser::GetByID($idUser);
        $arUser = $rsUser->Fetch();
        $arElements = $arUser['UF_FAVORITES'];  // Достаём избранное пользователя
        if(!in_array($_GET['id'], $arElements)) // Если еще нету этой позиции в избранном
        {
            $arElements[] = $_GET['id'];
            $result = 1;
        }
        else {
            $key = array_search($_GET['id'], $arElements); // Находим элемент, который нужно удалить из избранного
            unset($arElements[$key]);
            $result = 2;
        }
        $USER->Update($idUser, Array("UF_FAVORITES" => $arElements)); // Добавляем элемент в избранное
    }
}
/* Избранное */
echo json_encode($result);
die(); ?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
