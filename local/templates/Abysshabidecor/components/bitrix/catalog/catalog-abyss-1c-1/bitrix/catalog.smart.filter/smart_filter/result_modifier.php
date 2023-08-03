<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();


 use Bitrix\Highloadblock\HighloadBlockTable as HLBT;

//подключаем модуль highloadblock
CModule::IncludeModule('highloadblock');
//Напишем функцию получения экземпляра класса:
function GetEntityDataClass($HlBlockId) 
{
    if (empty($HlBlockId) || $HlBlockId < 1)
    {
        return false;
    }
    $hlblock = HLBT::getById($HlBlockId)->fetch();
    $entity = HLBT::compileEntity($hlblock);
    $entity_data_class = $entity->getDataClass();
    return $entity_data_class;
}

// $entity_data_class = GetEntityDataClass($arParams['ID_HIGHLOAD']);
// $rsData = $entity_data_class::getList(array(
//    	'select' => array('*'),
// ));

// while($el = $rsData->fetch()){
//     $colors[] = $el;
// }

// unset($entity_data_class);
// unset($rsData);

$entity_data_class = GetEntityDataClass(2);
$rsData = $entity_data_class::getList(array(
   'select' => array('*')
));



while($el = $rsData->fetch()){
    $colors[] = $el;
}


foreach($arResult['ITEMS'][1067]['VALUES'] as $key => $arColor){
	foreach($colors as $color){
		if($key == $color['UF_XML_ID']){
			$arResult['ITEMS'][1067]['VALUES'][$key]["HEX"] = $color['UF_COLOR'];
			break;
		}    
	}
}

	$arResult['ITEMS'][1067]['CLASS_FOR_NAME_WRAPPER'] = 'section-filter__p-color';
	$arResult['ITEMS'][1067]['ORDER'] = 3;
	$arResult['ITEMS'][1067]['NAME'] = "Цвет";


	$arResult['ITEMS'][45] = array(
		'ID' => 45,
		'NAME' => 'По популярности',
		'CLASS_FOR_NAME_WRAPPER' => 'section-filter__p-popular',
		'CHANGE_NAME'=>'Y',
		'PROPERTY_TYPE' => 'L',
		'USER_TYPE' => '',
		'USER_TYPE_SETTINGS' => '',
		'DISPLAY_TYPE' => 'K',
		'DISPLAY_EXPANDED' => 'Y',
		'FILTER_HINT' => '',
		'ORDER' => 1,
		'NOT_HIDE_MOBILE' => 'Y',
		'VALUES' => Array(
				'0' => Array
				(	
					'CONTROL_ID' => 'shows',
					'CONTROL_NAME' => 'shows',
					'CONTROL_NAME_ALT' => 'sort_field',
					'HTML_VALUE_ALT' => 'shows',
					'HTML_VALUE' => 'Y',
					'VALUE' => 'По популярности',
					'FLAG' => 1,
					'CLASS' => 'radio-custom',
					'CHECKED' => 1,
				),
				'1' => Array
				(
					'CONTROL_ID' => 'date_active_from',
					'CONTROL_NAME' => 'date_active_from',
					'CONTROL_NAME_ALT' => 'sort_field',
					'HTML_VALUE_ALT' => 'date_active_from desc',
					'CONTROL_ID' => 'active_from',
					'CONTROL_NAME' => 'active_from',
					'HTML_VALUE' => 'Y',
					'VALUE' => 'По новинкам',
					'CLASS' => 'radio-custom',
					'FLAG' => 1,
				),
				'2' => Array
				(
					'CONTROL_NAME_ALT' => 'sort_field',
					'HTML_VALUE_ALT' => 'catalog_PRICE_1 asc',
					'CONTROL_ID' => 'catalog_PRICE_asc',
					'CONTROL_NAME' => 'catalog_PRICE_1',
					'HTML_VALUE' => 'Y',
					'SORT' => 'asc',
					'VALUE' => 'По возрастанию цены',
					'CLASS' => 'radio-custom',
					'FLAG' => 1,
				),
				'3' => Array
				(
					'CONTROL_NAME_ALT' => 'sort_field',
					'HTML_VALUE_ALT' => 'catalog_PRICE_1 desc',
					'CONTROL_ID' => 'catalog_PRICE_1_desc',
					'CONTROL_NAME' => 'catalog_PRICE_1',
					'HTML_VALUE' => 'Y',
					'SORT' => 'desc',
					'VALUE' => 'По убыванию цены',
					'CLASS' => 'radio-custom',
					'FLAG' => 1,
				),
				
			)
	
	);

	// $arResult['ITEMS'][48] = array(
	// 	'ID' => 48,
	// 	'NAME' => 'Есть в наличии',
	// 	'CHANGE_NAME'=>'Y',
	// 	'PROPERTY_TYPE' => 'L',
	// 	'USER_TYPE' => '',
	// 	'CLASS_FOR_NAME_WRAPPER' => 'section-filter__p-available',
	// 	'USER_TYPE_SETTINGS' => '',
	// 	'DISPLAY_TYPE' => 'K',
	// 	'DISPLAY_EXPANDED' => 'Y',
	// 	'FILTER_HINT' => '',
	// 	'ORDER' => 4,
	// 	'VALUES' => Array(
	// 			'0' => Array
	// 			(	
	// 				'CONTROL_ID' => 'available1',
	// 				'CONTROL_NAME' => 'available',
	// 				'CONTROL_NAME_ALT' => 'available',
	// 				'HTML_VALUE_ALT' => 'available',
	// 				'HTML_VALUE' => 'Y',
	// 				'VALUE' => 'Есть в наличии',
	// 				'FLAG' => 1,
	// 				'CLASS' => 'radio-custom-available',
	// 				'CHECKED' => 1,
	// 			),
	// 			'1' => Array
	// 			(
	// 				'CONTROL_ID' => 'available2',
	// 				'CONTROL_NAME' => 'available',
	// 				'CONTROL_NAME_ALT' => 'available',
	// 				'HTML_VALUE_ALT' => 'all',
	// 				'HTML_VALUE' => 'Y',
	// 				'VALUE' => 'Все товары',
	// 				'CLASS' => 'radio-custom-available',
	// 				'FLAG' => 1,
	// 			),
	// 		)
	
	// );
	ksort($arResult);
	ksort($arResult['ITEMS']);

?>
