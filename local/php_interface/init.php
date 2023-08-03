<?

/**
 * Терминология:
 * Наименовнание товара - это свойство NAIMENOVANIE_ANGL 
 * Артикул товара - это свойство ARTIKUL_ANGL
 * Цвет - свойство TSVET_IZDELIYA
 */
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
	die();
}
define("LOG_FILENAME", $_SERVER["DOCUMENT_ROOT"] . "/log-45664445665.txt");

use Bitrix\Highloadblock\HighloadBlockTable as HLBT;
//подключаем модуль highloadblock
CModule::IncludeModule('highloadblock');
AddEventHandler("sale", "OnOrderStatusSendEmail", "test");
function test($orderID, &$eventName, &$arFields)
{
	$name = '';
	$arFields["USER"] = '';
	if (CModule::IncludeModule("sale") && CModule::IncludeModule("iblock")) {
		$order_props = CSaleOrderPropsValue::GetOrderProps($orderID);
		while ($arProps = $order_props->Fetch()) {
			if ($arProps['ORDER_PROPS_ID'] == 1) {
				$name .= $arProps['VALUE'];
			}
		}
		$arFields["USER"] = $name;
	}
}

if (CModule::IncludeModule("iblock")) {
	//получаем древовидный список разделов инфоблока 
	$arFilter = array('IBLOCK_ID' => 33, 'GLOBAL_ACTIVE' => 'Y', 'SECTION_ID' => false);
	$arSelect = array("ID", "IBLOCK_ID",  "CODE", "NAME", "UF_ARTIKUL", "UF_NAIMENOVANIE_ANGL");
	$res = CIBlockSection::GetList(array(), $arFilter, false, $arSelect);
	while ($sect = $res->Fetch()) {
		$arSections[] = $sect;
	}
	unset($arFilter);
	unset($arSelect);
	unset($res);

	foreach ($arSections as $key => $arParentSection) {
		$arFilter = array('IBLOCK_ID' => 33, "UF_NAIMENOVANIE_ANGL" => $arParentSection["UF_NAIMENOVANIE_ANGL"]);
		$arSelect = array("ID", "IBLOCK_ID", "SECTION_ID", "CODE", "UF_ARTIKUL", "UF_NAIMENOVANIE_ANGL");
		$res = CIBlockSection::GetList(array(), $arFilter, false, $arSelect);
		while ($sect = $res->Fetch()) {
			if ($arParentSection['ID'] != $sect['ID']) {
				$arChildSections[] = $sect;
			}
		}


		$arSections[$key]['CHILD_SECTIONS'] = $arChildSections;
		unset($arFilter);
		unset($arSelect);
		unset($res);
		unset($arChildSections);
	}
}


//Класс чтобы получить список товаров по акции КОНЕЦ//
AddEventHandler("sale", "OnOrderNewSendEmail", "ModifyOrderSaleMails");
function ModifyOrderSaleMails($orderID, &$eventName, &$arFields)
{
	if (CModule::IncludeModule("sale") && CModule::IncludeModule("iblock")) {
		$arOrder = CSaleOrder::GetByID($orderID);
		//СОСТАВ ЗАКАЗА РАЗБИРАЕМ SALE_ORDER НА ЗАПЧАСТИ
		$phone = '';
		$address = '';
		//$city = '';
		$ulitsa = '';
		$dom = '';
		$delivery_name = '';
		$mail = '';
		$name = '';
		$user = '';
		$strOrderList = '';
		$kw = '';
		$delivery_name = '';
		$pay_system_name = '';

		$arSelectedFields = '';
		$strCustomOrderList = '';
		$arFields["USER"] = '';
		$arFields["PAY"] = '';
		$arFields["PHONE"] = '';
		$arFields["NAME"] = '';
		$arFields["ADDRESS"] = '';
		$arFields["DELIVERY"] =  '';
		$arFields["ORDER_TABLE_ITEMS"] =  "";

		$dbBasketItems = CSaleBasket::GetList(
			array("NAME" => "ASC"),
			array("ORDER_ID" => $orderID),
			false,
			false,
			array("PRODUCT_ID", "ID", "NAME", "QUANTITY", "PRICE", "CURRENCY")
		);


		while ($arProps = $dbBasketItems->Fetch()) {

			//достаем картинку
			$mxResult = CCatalogSku::GetProductInfo(
				$arProps["PRODUCT_ID"]
			);
			if (is_array($mxResult)) {
				$res = CIBlockElement::GetByID($mxResult['ID']);
				if ($ar_res = $res->GetNext()) {
					$img = CFile::GetPath($ar_res['PREVIEW_PICTURE']);
				}
			} else {
				$res = CIBlockElement::GetByID($arProps["PRODUCT_ID"]);
				if ($ar_res = $res->GetNext()) {
					$img = CFile::GetPath($ar_res['PREVIEW_PICTURE']);
				}
			}

			//СОБИРАЕМ ВЕРСТКУ СПИСКА ТОВАРОВ
			$strCustomOrderList .=  '<div style="border:1px solid #f7f7f7;margin-bottom:30px;padding:10px 20px 10px 20px;">
				<table style="width: 100%;">
					<tbody>
						<tr>
							<td>
								<span style="background:url(' . $img . ') 0% 0%/cover;display:inline-block;height:100px;width:100px;background-size: cover;background-position: center;"></span>
							</td>
							<td>
								<span style="color:#969696;font-size:16px;font-weight:400;line-height:19px;margin-top:20px;text-align:center;text-transform:uppercase;width:40%;font-family: Roboto, Arial, sans-serif;">'  . $arProps['NAME'] . ' x' . $arProps['QUANTITY'] . '</span>   
							</td>
							<td>
								<span style="color:#707070;font-size:20px;font-weight:400;line-height:23px;margin-top:20px;text-align:center;text-transform:uppercase;width:30%;font-family: Roboto, Arial, sans-serif;">'  . intval($arProps['PRICE']) .  ' ₽</span> 
							</td> 
						</tr>
					</tbody>
				</table>
			</div>';
		}



		//ЗНАЧЕНИЯ СВОЙСТВ
		$order_props = CSaleOrderPropsValue::GetOrderProps($orderID);
		while ($arProps = $order_props->Fetch()) {
			if ($arProps['ORDER_PROPS_ID'] == 1) {
				$name .= '<div style="line-height: 20px; padding-bottom: 20px; margin-bottom: 20px; border-bottom: 1px solid #A7A9AC;">
					<span style="font-weight: 400;font-size: 16px;line-height: 24px;color: #969696;">Получатель</span>
					<span style="float: right;font-weight: 400;font-size: 20px;line-height: 23px;color: #707070;">' . $arProps['VALUE'] . '</span>
					</div>';
				$user .= $arProps['VALUE'];
			}
			if ($arProps['ORDER_PROPS_ID'] == 3) {
				$phone .= '<div style="line-height: 20px; padding-bottom: 20px; margin-bottom: 20px; border-bottom: 1px solid #A7A9AC;">
					<span style="font-weight: 400;font-size: 16px;line-height: 24px;color: #969696;">Телефон</span>
					<span style="float: right;font-weight: 400;font-size: 20px;line-height: 23px;color: #707070;">' . $arProps['VALUE'] . '</span>
				</div>';
			}
			//if ($arProps['ORDER_PROPS_ID']==2){ $mail.=$arProps['VALUE'];} 
			//Город
			if ($arProps['ORDER_PROPS_ID'] == 6) {
				$city .= $arProps['VALUE'];
			}
			//Улица
			if ($arProps['ORDER_PROPS_ID'] == 8) {
				$ulitsa .= $arProps['VALUE'];
			}
			//Дом
			if ($arProps['ORDER_PROPS_ID'] == 9) {
				$dom .= $arProps['VALUE'];
			}
			//кв
			if ($arProps['ORDER_PROPS_ID'] == 10) {
				$kw .= $arProps['VALUE'];
			}
		}
		if ($ulitsa and $dom and $kw) {
			$address .= '<div style="line-height: 20px; margin-bottom: 20px;">
			<span style="font-weight: 400;font-size: 16px;line-height: 24px;color: #969696;">Адрес</span>
			<span style="float: right;font-weight: 400;font-size: 20px;line-height: 23px;color: #707070;">' . $ulitsa . " " . $dom . " " . $kw . '</span>
		</div>';
		}


		//-- получаем название службы доставки
		$arDeliv = CSaleDelivery::GetByID($arOrder["DELIVERY_ID"]);
		if ($arDeliv) {
			$delivery_name .= '<div style="line-height: 20px;margin-bottom: 20px;">
				<span style="font-weight: 400;font-size: 16px;line-height: 24px;color: #969696;">Способ получения</span>
				<span style="float: right;font-weight: 400;font-size: 20px;line-height: 23px;color: #707070;">' . $arDeliv["NAME"] . '</span>
			</div>';
		}
		//-- получаем название платежной системы   
		$arPaySystem = CSalePaySystem::GetByID($arOrder["PAY_SYSTEM_ID"]);

		if ($arPaySystem) {
			$pay_system_name .= '<div style="line-height: 20px; padding-bottom: 20px; margin-bottom: 20px; border-bottom: 1px solid #A7A9AC;">
					<span style="font-weight: 400;font-size: 16px;line-height: 24px;color: #969696;">Способ оплаты</span>
					<span style="float: right;font-weight: 400;font-size: 20px;line-height: 23px;color: #707070;">' . $arPaySystem["NAME"] . '</span>
				</div>';
		}

		//ОБЪЯВЛЯЕМ ПЕРЕМЕННУЮ ДЛЯ ПИСЬМА
		$arFields["USER"] = $user;
		$arFields["ORDER_TABLE_ITEMS"] = $strCustomOrderList;
		$arFields["PAY"] = $pay_system_name;
		$arFields["PHONE"] = $phone;
		//$arFields["EMAIL"] = $mail;
		$arFields["NAME"] = $name;
		$arFields["ADDRESS"] = $address;
		$arFields["DELIVERY"] =  $delivery_name;
	}
}


function debug($array)
{
	global $USER;
	if ($USER->IsAdmin()) {
		echo '<pre style="width:100%" class="container">';
		print_r($array);
		echo '</pre>';
	}
}


AddEventHandler("iblock", "OnAfterIBlockElementAdd", array("ImportedElements", "CheckElementSectionAdd"));
AddEventHandler("iblock", "OnAfterIBlockElementUpdate", array("ImportedElements", "CheckElementSectionUpdate"));



class ImportedElements
{
	public static function GetEntityDataClass($HlBlockId)
	{
		if (empty($HlBlockId) || $HlBlockId < 1) {
			return false;
		}
		$hlblock = HLBT::getById($HlBlockId)->fetch();
		$entity = HLBT::compileEntity($hlblock);
		$entity_data_class = $entity->getDataClass();
		return $entity_data_class;
	}

	//Делаем привязку к разделу по совпадающим свойствам раздела и элемента инфоблока
	public static function Link2Section(int $iblock_id = 33, string $property_element = 'ARTIKUL_ANGL', string $type_element = "NAIMENOVANIE_ANGL", string $property_section = "UF_ARTIKUL", string $type_section = "UF_NAIMENOVANIE_ANGL", $modified_by = 1)
	{
		if (CModule::IncludeModule("iblock")) {
			$el = new CIBlockElement;
		}

		global $arSections;

		foreach ($arSections as $arSection) {
			foreach ($arSection["CHILD_SECTIONS"] as $arChildSection) {

				//получаем список элементов
				$arSelect = array("ID", "IBLOCK_ID", "IBLOCK_SECTION_ID", "NAME", "DATE_ACTIVE_FROM", "PROPERTY_" . $property_element, "PROPERTY_" . $type_element,);
				$arFilter = array("IBLOCK_ID" => $iblock_id, "ACTIVE_DATE" => "Y", "ACTIVE" => "Y", "PROPERTY_" . $property_element => $arChildSection["UF_ARTIKUL"], "PROPERTY_" . $type_element => $arChildSection["UF_NAIMENOVANIE_ANGL"]);
				$res = CIBlockElement::GetList(array("ID" => "ASC"), $arFilter, false, array(), $arSelect);
				while ($ob = $res->GetNextElement()) {
					$arElements[] = $ob->GetFields();
				}


				foreach ($arElements as $arElement) {
					if ($arChildSection[$property_section] == $arElement["PROPERTY_" . $property_element . "_VALUE"]) {
						$update_section_id = array('MODIFIED_BY' => $modified_by, 'IBLOCK_SECTION_ID' => $arChildSection["ID"]);
						$res = $el->Update($arElement["ID"], $update_section_id);
						if ($res == false) {
							AddMessage2Log("Ошибка в функции Link2Section в init.php: " . $res->LAST_ERROR);
						}
					}
				}


				unset($arFilter);
				unset($arSelect);
				unset($res);
				unset($arElements);
			}
		}
		echo "<div class='container'>Товары успешно распределены по разделам</div><br>";
		// AddMessage2Log("Товары успешно распределены по разделам");
	}



	/**
	 * Функция для размещения картинок в товары. Картинки размещаются в папке /upload/image/<Наименовнание товара>/<Артикул товара>
	 * У картинок должно быть определённое название: <Артикул> <Цвет> <Порядковый номер>.webp Пример: SUPER PILE 100 1.webp
	 * 
	 * @var string $name - Наименование(англ) товара
	 * @var string $article - Артикул(англ) товара
	 * @var int $number_preview - Номер картинки для превью
	 * @var int $number_detail - Номер картинки для деталки
	 * 
	 * Пример: ImportedElements::PutPicture('Towel', 'Abelha', 1, 2);
	 * 
	 * Пример для всех товаров одного наименования(для всех ковриков):
	 *   	$rsParentSection = CIBlockSection::GetByID(42);
	 *		if ($arParentSection = $rsParentSection->GetNext())
	 *		{
	 *		    $arFilter = array('IBLOCK_ID' => $arParentSection['IBLOCK_ID'],'>LEFT_MARGIN' => $arParentSection['LEFT_MARGIN'],'<RIGHT_MARGIN' => $arParentSection['RIGHT_MARGIN'],'>DEPTH_LEVEL' => $arParentSection['DEPTH_LEVEL']); 
	 *		    $rsSect = CIBlockSection::GetList(array('left_margin' => 'asc'),$arFilter, true, array("UF_ARTIKUL"));
	 *		    while ($arSect = $rsSect->GetNext())
	 *		    {
	 *		      ImportedElements::PutPicture('Rug', $arSect["UF_ARTIKUL"], 2, 1);
	 *		       echo $arSect["NAME"];
	 *		       ;
	 *		    }
	 *		}
	 */
	public static function PutPicture(string $name, string $article, int $number_preview = 2, int $number_detail = 1)
	{
		$delete = true;
		$article_count = count(explode(' ', $article));
		$file_array = array();
		$path = $_SERVER['DOCUMENT_ROOT'] . '/upload/image/' . $name . '/' . $article . '/';
		$f = scandir($path);
		$i = 0;
		foreach ($f as $key1 => $file) {
			if (preg_match('/\.(webp)/', $file)) {
				$file_explode = explode('.', $file);
				$file_array[$i] = explode(" ", $file_explode[0]);
				$file_array[$i]["PATH"] = '/upload/image/' . $name . '/' . $article . '/' . $file;
				$i++;
			}
		}

		foreach ($file_array as $key => $el) {
			if ($el[$article_count + 1] == $number_preview) {
				$arFile[$file_array[$key][$article_count]]['PREVIEW_PICTURE'] = CFile::MakeFileArray($el["PATH"]);
				$arFile[$file_array[$key][$article_count]]['MORE_PHOTO'][$key]["VALUE"] = CFile::MakeFileArray($el["PATH"]);
				$arFile[$file_array[$key][$article_count]]['MORE_PHOTO'][$key]["DESCRIPTION"] = "";
				$preview_key = $key;
			} elseif ($el[$article_count + 1] == $number_detail) {
				$arFile[$file_array[$key][$article_count]]['DETAIL_PICTURE'] = CFile::MakeFileArray($el["PATH"]);
				$arFile[$file_array[$key][$article_count]]['MORE_PHOTO'][$key]["VALUE"] = CFile::MakeFileArray($el["PATH"]);
				$arFile[$file_array[$key][$article_count]]['MORE_PHOTO'][$key]["DESCRIPTION"] = "";
				$detail_key = $key;
			}
		}
		foreach ($file_array as $key => $el) {
			if ($detail_key != $key && $preview_key != $key) {
				$arFile[$file_array[$key][$article_count]]['MORE_PHOTO'][$key]["VALUE"] = CFile::MakeFileArray($el["PATH"]);
				$arFile[$file_array[$key][$article_count]]['MORE_PHOTO'][$key]["DESCRIPTION"] = "";
			}
		}

		if (CModule::IncludeModule("iblock")) {
			$el = new CIBlockElement;
		}

		$arSelect = array("ID", "IBLOCK_ID", "NAME", "PREVIEW_PICTURE", "DETAIL_PICTURE");
		$arFilter = array("IBLOCK_ID" => 33, "ACTIVE_DATE" => "Y", "ACTIVE" => "Y", "PROPERTY_ARTIKUL_ANGL" => $article, "PROPERTY_NAIMENOVANIE_ANGL" => $name);
		$res = CIBlockElement::GetList(array("ID" => "ASC"), $arFilter, false, array(), $arSelect);
		$i = 0;
		while ($ob = $res->GetNextElement()) {
			$arElements[$i] = $ob->GetFields();
			$prop = $ob->GetProperties();
			$arElements[$i]["MORE_PHOTO"] = $prop['MORE_PHOTO']["VALUE"];
			$arElements[$i]["TSVET_IZDELIYA"] = $prop["TSVET_IZDELIYA"]["VALUE"];
			$arElements[$i]["ARTIKUL_ANGL"] = $prop["ARTIKUL_ANGL"]["VALUE"];
			$arElements[$i]["NAIMENOVANIE_ANGL"] = $prop["NAIMENOVANIE_ANGL"]["VALUE"];
			$i++;
		}


		foreach ($arElements as $key => $arElement) {
			if ($delete) {

				$PROPERTY_VALUE = array(
					0 => array("VALUE" => "", "DESCRIPTION" => "")
				);
				$result	= CIBlockElement::SetPropertyValuesEx($arElement["ID"], 33, array("MORE_PHOTO" => $PROPERTY_VALUE));

				unset($result);
			}



			if (isset($arFile[$arElement["TSVET_IZDELIYA"]]) && $arElement['ARTIKUL_ANGL'] == $article && $arElement['NAIMENOVANIE_ANGL'] == $name) {
				$arFields['PREVIEW_PICTURE'] = $arFile[$arElement["TSVET_IZDELIYA"]]['PREVIEW_PICTURE'];
				$arFields['DETAIL_PICTURE'] = $arFile[$arElement["TSVET_IZDELIYA"]]['DETAIL_PICTURE'];

				$result = $el->Update($arElement['ID'], $arFields);
				if (!$result) {
					echo $result->LAST_ERROR;
					return $result->LAST_ERROR;
				}

				unset($result);
				$result = CIBlockElement::SetPropertyValueCode($arElement['ID'], "MORE_PHOTO", $arFile[$arElement["TSVET_IZDELIYA"]]['MORE_PHOTO']);
				if (!$result) {
					echo $result->LAST_ERROR;
					return $result->LAST_ERROR;
				}


				unset($arFields);
				unset($result);
			}
			flush();
		}
		echo "<div class='container'>$name $article OK </div><br>";
		return true;
	}


	/**
	 * Удаляет все картинки у товаров определённого артикула и наименования
	 */
	public static function DeletePicture(string $name, string $article)
	{


		if (CModule::IncludeModule("iblock")) {
			$el = new CIBlockElement;
		}

		$arSelect = array("ID", "IBLOCK_ID", "NAME", "PREVIEW_PICTURE", "DETAIL_PICTURE");
		if (isset($other_article) && $other_article != '') {
			$article = $other_article;
		}
		$arFilter = array("IBLOCK_ID" => 33, "ACTIVE_DATE" => "Y", "ACTIVE" => "Y", "PROPERTY_ARTIKUL_ANGL" => $article, "PROPERTY_NAIMENOVANIE_ANGL" => $name);
		$res = CIBlockElement::GetList(array("ID" => "ASC"), $arFilter, false, array(), $arSelect);
		$i = 0;
		while ($ob = $res->GetNextElement()) {
			$arElements[$i] = $ob->GetFields();
			$prop = $ob->GetProperties();
			$arElements[$i]["MORE_PHOTO"] = $prop['MORE_PHOTO']["VALUE"];
			$arElements[$i]["TSVET_IZDELIYA"] = $prop["TSVET_IZDELIYA"]["VALUE"];
			$arElements[$i]["ARTIKUL_ANGL"] = $prop["ARTIKUL_ANGL"]["VALUE"];
			$arElements[$i]["NAIMENOVANIE_ANGL"] = $prop["NAIMENOVANIE_ANGL"]["VALUE"];
			$i++;
		}
		foreach ($arElements as $key => $arElement) {

			$arFields['PREVIEW_PICTURE'] = array('del' => 'Y');
			$arFields['DETAIL_PICTURE'] = array('del' => 'Y');

			$result = $el->Update($arElement['ID'], $arFields);

			$PROPERTY_VALUE = array(0 => array("VALUE" => "", "DESCRIPTION" => ""));
			$result	= CIBlockElement::SetPropertyValuesEx($arElement["ID"], 33, array("MORE_PHOTO" => $PROPERTY_VALUE));

			unset($result);
		}

		echo "<div class='container'>$name $article DELETE OK </div><br>";
		return true;
	}


	public static function GroupByColor(int $iblock_id = 33)
	{

		if (CModule::IncludeModule("iblock")) {
			$el = new CIBlockElement;
		}

		//получаем список элементов
		$arSelect = array("ID", "IBLOCK_ID", "IBLOCK_SECTION_ID", "NAME", "DATE_ACTIVE_FROM", "PROPERTY_TSVET", "PROPERTY_TSVET_IZDELIYA");
		$arFilter = array("IBLOCK_ID" => $iblock_id, "ACTIVE_DATE" => "Y", "ACTIVE" => "Y");
		$res = CIBlockElement::GetList(array("ID" => "ASC"), $arFilter, false, array(), $arSelect);
		while ($ob = $res->GetNextElement()) {
			$arElements[] = $ob->GetFields();
		}

		unset($arFilter);
		unset($arSelect);
		unset($res);


		//Напишем функцию получения экземпляра класса:


		$entity_data_class = self::GetEntityDataClass(2);
		$rsData = $entity_data_class::getList(array(
			'select' => array('*')
		));



		while ($el1 = $rsData->fetch()) {
			$colors[] = $el1;
		}

		foreach ($arElements as $arElement) {

			foreach ($colors as $color) {
				if (in_array($arElement['PROPERTY_TSVET_IZDELIYA_VALUE'], $color['UF_CODE_LIST'])) {
					$update_color = array('TSVET' => $color["UF_XML_ID"]);
					echo $res = $el->SetPropertyValuesEx($arElement["ID"], false, $update_color);
					break;
				}
			}
		}

		echo "<div class='container'>Group by color success</div><br>";
		return true;
	}

	public static function ActiveElements(int $iblock_id = 33)
	{

		if (CModule::IncludeModule("iblock")) {
			$el = new CIBlockElement;
		}

		//получаем список элементов
		$arSelect = array("ID", "IBLOCK_ID", "IBLOCK_SECTION_ID", "NAME", "DATE_ACTIVE_FROM", "PROPERTY_TSVET", "PROPERTY_TSVET_IZDELIYA", "ACTIVE", "IBLOCK_SECTION_ID");
		$arFilter = array("IBLOCK_ID" => $iblock_id);
		$res = CIBlockElement::GetList(array("ID" => "ASC"), $arFilter, false, array(), $arSelect);
		while ($ob = $res->GetNextElement()) {
			$arElements[] = $ob->GetFields();
		}


		foreach ($arElements as $arElement) {
			$el = new CIBlockElement;
			$el->Update(
				$arElement["ID"],
				['ACTIVE' => 'Y'],
				true
			);
		}

		echo "<div class='container'>Active element success</div><br>";
		return true;
	}


	public static $disableHandler = false;
	public static $element_id = '';

	/**
	 * Обработчик создания элемента
	 * Нужен чтобы при приходе элемента из импорта по полям NAIMENOVANIE_ANGL и ARTIKUL_ANGL элемент распределялся в раздел
	 * А также при существовании элемента с такими же наименованием, артикулом, размером и цветом - деактивировать существующий товар
	 * 
	 * На данный момент на сайте эти четыре параметра определяют уникальность товара, поэтому по ним и сравниваю
	 */
	public static function CheckElementSectionAdd(&$arFields)
	{
		if (CModule::IncludeModule("iblock")) {
			$el = new CIBlockElement;
		}
		self::$disableHandler = true;
		self::$element_id = $arFields['ID'];

		if (
			isset($arFields["PROPERTY_VALUES"][1081]['n0']["VALUE"]) && $arFields["PROPERTY_VALUES"][1081]['n0']["VALUE"] != ""
			&& isset($arFields["PROPERTY_VALUES"][1082]['n0']["VALUE"]) && $arFields["PROPERTY_VALUES"][1082]['n0']["VALUE"] != ""
			&& isset($arFields["PROPERTY_VALUES"][1075]['n0']["VALUE"]) && $arFields["PROPERTY_VALUES"][1075]['n0']["VALUE"] != ""
			&& isset($arFields["PROPERTY_VALUES"][1069]['n0']["VALUE"]) && $arFields["PROPERTY_VALUES"][1069]['n0']["VALUE"] != ""
		) {
			$arFilter = array("!ID" => $arFields["ID"], "IBLOCK_ID" => $arFields["IBLOCK_ID"], "PROPERTY_ARTIKUL_ANGL" => $arFields["PROPERTY_VALUES"][1081]['n0']["VALUE"], "PROPERTY_NAIMENOVANIE_ANGL" => $arFields["PROPERTY_VALUES"][1082]['n0']["VALUE"], "PROPERTY_TSVET_IZDELIYA" => $arFields["PROPERTY_VALUES"]["1075"]['n0']["VALUE"], "PROPERTY_RAZMER" => $arFields["PROPERTY_VALUES"]['1069']['n0']["VALUE"]);

			$res = CIBlockElement::GetList(array(), $arFilter, false, false, array("ID", "NAME"));
			while ($ob = $res->GetNextElement()) {
				$arElements[] = $ob->GetFields();
			}
			if (is_array($arElements)) {
				foreach ($arElements as $arElement) {
					if (isset($arElement['ID']) && $arElement['ID'] != "") {
						$arChange = array('ACTIVE' => "N");
						$res = $el->Update($arElement["ID"], $arChange);
						if ($res == false) {
							AddMessage2Log("Ошибка в функции CheckElementSectionAdd в init.php: " . $res->LAST_ERROR);
						}
					}
				}
			}
		}


		if (!isset($arFields["IBLOCK_SECTION"]) == array()) {
			global $arSections;

			foreach ($arSections as $arSection) {
				if ($arSection["UF_NAIMENOVANIE_ANGL"] == $arFields["PROPERTY_VALUES"][1082]['n0']["VALUE"]) {
					foreach ($arSection["CHILD_SECTIONS"] as $arChildSection) {
						if ($arChildSection["UF_ARTIKUL"] == $arFields["PROPERTY_VALUES"][1081]['n0']["VALUE"]) {
							$update_section_id = array('IBLOCK_SECTION_ID' => $arChildSection["ID"]);
							$res = $el->Update($arFields["ID"], $update_section_id);
							if ($res == false) {
								AddMessage2Log("Ошибка в функции CheckElementSection в init.php: " . $res->LAST_ERROR);
							}
						}
					}
				}
			}
			$result = "<div class='container'>Товар " . $arFields['NAME'] . " успешно распределен в раздел " . $update_section_id['IBLOCK_SECTION_ID'] . "</div><br>";
			echo $result;
			// AddMessage2Log("Товар " . $arFields['NAME'] . " успешно распределен в раздел " . $update_section_id['IBLOCK_SECTION_ID']);
		}
	}


	/**
	 * Обработчик изменения товара
	 * Нужен чтобы при приходе элемента из импорта по полям NAIMENOVANIE_ANGL и ARTIKUL_ANGL элемент распределялся в раздел
	 * А так же сравнивает имя товара с именем из списка товаров, которые нужно скрыть, и при совпадении деактивирует товар и перемещает в раздел "Сняты с производства"
	 */
	public static function CheckElementSectionUpdate(&$arFields)
	{
		// AddMessage2Log(print_r($arFields, true));
		//избежать зацикливания на update
		if ((self::$disableHandler) && ($arFields['ID'] == self::$element_id)) {
			return;
		}

		self::$disableHandler = true;
		self::$element_id = $arFields['ID'];

		if (is_array($arFields["IBLOCK_SECTION"]) && !in_array(207, $arFields['IBLOCK_SECTION'])) {
			if (CModule::IncludeModule("iblock")) {
				$el = new CIBlockElement;
			}

			global $arSections;

			foreach ($arSections as $arSection) {
				foreach ($arFields["PROPERTY_VALUES"][1082] as $naim) {
					if ($arSection["UF_NAIMENOVANIE_ANGL"] == $naim["VALUE"]) {
						foreach ($arSection["CHILD_SECTIONS"] as $arChildSection) {
							foreach ($arFields["PROPERTY_VALUES"][1081] as $artikul) {
								if ($arChildSection["UF_ARTIKUL"] == $artikul["VALUE"]) {
									$update_section_id = array('IBLOCK_SECTION_ID' => $arChildSection["ID"]);
									$res = $el->Update($arFields["ID"], $update_section_id);
									if ($res == false) {
										AddMessage2Log("Ошибка в функции CheckElementSection в init.php: " . $res->LAST_ERROR);
									}
								}
							}
						}
					}
				}
			}

			$result = "<div class='container'>Товар " . $arFields['NAME'] . " успешно распределен в раздел " . $update_section_id['IBLOCK_SECTION_ID'] . "</div><br>";
			echo $result;
			// AddMessage2Log("Товар " . $arFields['NAME'] . " успешно распределен в раздел " . $update_section_id['IBLOCK_SECTION_ID']);
		}
	}

	public static function RemoveDuplicatesElements()
	{
		$el = new CIBlockElement;
		$arSelect = array("ID", "NAME", "CREATED_USER_NAME", "CREATED_BY", "CODE");
		$arFilter = array("IBLOCK_ID" => 33, "ACTIVE_DATE" => "Y", "ACTIVE" => "Y");
		$res = CIBlockElement::GetList(array(), $arFilter, false, array(), $arSelect);
		$i = 0;
		$ElementArray = array("ACTIVE" => "N",);
		while ($ob = $res->GetNextElement()) {
			$arFields = $ob->GetFields();
			if ($arFields['CREATED_BY'] == 1) {
				$arSelect = array("ID", "NAME", "CREATED_BY", "CODE");
				$new_code = str_replace("x", "kh", $arFields['CODE']);
				$arFilter = array("IBLOCK_ID" => 33, "CODE" => $new_code, "!ID" => $arFields['ID']);
				$result = CIBlockElement::GetList(array(), $arFilter, false, array(), $arSelect);
				while ($obj = $result->GetNextElement()) {
					$arFieldsDuplicate = $obj->GetFields();
					if (isset($arFieldsDuplicate) && !empty($arFieldsDuplicate)) {
						$arFields["HAVE_DUPLUCATES"] = 1;
					}
				}
				if ($arFields["HAVE_DUPLUCATES"] == 1) {
					// debug($arFields);
					$el->Update($arFields['ID'], $ElementArray);
					echo "Элемент " . $arFields['NAME'] . " деактевирован<br>";
				}
			}
		}
	}

	/**
	 * Выводит элементы без картинок
	 */
	public static function ShowNoImage()
	{
		$el = new CIBlockElement;
		$arSelect = array("ID", "NAME", "CREATED_USER_NAME", "CREATED_BY", "CODE", "PREVIEW_PICTURE", "PROPERTY_TSVET_IZDELIYA", "PROPERTY_RAZMER", "DETAIL_PAGE_URL");
		$arFilter = array("IBLOCK_ID" => 33, "ACTIVE_DATE" => "Y", "ACTIVE" => "Y",);
		$res = CIBlockElement::GetList(array("NAME" => "ASC"), $arFilter, false, array(), $arSelect);
		$i = 0;
		echo "<table>";
		echo "<tr><th>Название</th><th>Размер</th><th>Цвет</th></tr>";
		while ($ob = $res->GetNextElement()) {
			$arFields = $ob->GetFields();
			if (!isset($arFields["PREVIEW_PICTURE"]) || $arFields["PREVIEW_PICTURE"] == "") {
				echo "<tr><td>" . $arFields["NAME"] . "</td><td>" . $arFields["PROPERTY_RAZMER_VALUE"] . "</td><td>" . $arFields['PROPERTY_TSVET_IZDELIYA_VALUE'] . "</td></tr>";
			}
		}

		echo "</table>";
	}
}
//чтобы не выводились товары из неактивного раздела
AddEventHandler('search', 'BeforeIndex', "onBeforeIndexHandler");
function onBeforeIndexHandler($arFields)
{
	if ($arFields["MODULE_ID"] == "iblock") {
		$check = substr($arFields["ITEM_ID"], 0, 1);
		if ($check == "S") {
			$res = CIBlockSection::GetList(
				array('SORT' => 'ASC'),
				array("IBLOCK_ID" => $arFields["PARAM2"], "ACTIVE" => "Y", "ID" => substr($arFields["ITEM_ID"], 1), "GLOBAL_ACTIVE" => "Y"),
				false,
				array("ID")
			);
		} else {
			$res = CIBlockElement::GetList(
				array("SORT" => "ASC"),
				array("IBLOCK_ID" => $arFields["PARAM2"], "ACTIVE" => "Y", "ID" => $arFields["ITEM_ID"], "SECTION_GLOBAL_ACTIVE" => "Y"),
				false,
				false,
				array("ID")
			);
		}
		if (!$res->Fetch()) {
			$arFields["BODY"] = "";
			$arFields["TITLE"] = "";
		}
	}

	return $arFields;
}

AddEventHandler("catalog", "OnProductAdd", array("ChangeElement", "UpdatePropPriceAndAvailable"));
AddEventHandler("catalog", "OnProductUpdate", array("ChangeElement", "UpdatePropPriceAndAvailable"));
// AddEventHandler("catalog", "OnProductUpdate", array("ChangeElement", "UpdateAvalable"));
class ChangeElement
{
	public static $disableHandler = false;
	public static $element_id = '';

	/**
	 * При создании или изменении товара, например при покупке изменятся количество, или при изменении цен товаров, в свойства товара записывается количество всех отстатков торговых предложений и макс и мин цена торговых предложений
	 */
	public static function UpdatePropPriceAndAvailable($ID, &$arFields)
	{
		//избежать зацикливания на update
		if ((self::$disableHandler) && ($arFields['ID'] == self::$element_id)) {
			return;
		}
		self::$disableHandler = true;
		self::$element_id = $arFields['ID'];
		$offersCount = 0;
		\Bitrix\Main\Loader::includeModule("catalog");
		\Bitrix\Main\Loader::includeModule("iblock");
		$el = new CIBlockElement;
		$IBLOCK_ID = $arFields['IBLOCK_ID'];

		$arInfo = CCatalogSKU::GetInfoByProductIBlock($IBLOCK_ID);
		if (is_array($arInfo)) {
			$rsOffers = CIBlockElement::GetList(array(), array('IBLOCK_ID' => $arInfo['IBLOCK_ID'], 'PROPERTY_' . $arInfo['SKU_PROPERTY_ID'] => $ID));
			$i = 0;
			while ($arOffer = $rsOffers->GetNext()) {
				/**
				 * Получаем макс и мин цены 
				 */
				$allProductPrice = \Bitrix\Catalog\PriceTable::getList([
					"filter" => [
						"PRODUCT_ID" => $arOffer['ID'],
					]
				])->fetchAll();
				foreach ($allProductPrice as $arPrice) {

					$allProductPrices[] = $arPrice['PRICE'];
				}
				$i++;

				/**
				 * Складываем остатки товаров 
				 */
				$offerParameters = CCatalogProduct::GetByID($arOffer["ID"]);
				$offersCount += $offerParameters["QUANTITY"];
			}
			if (is_array($allProductPrices) && !empty($allProductPrices)) {
				$updatePrice = array('MIN_PRICE_PRINT' => CurrencyFormat(min($allProductPrices), "RUB"), 'MAX_PRICE_PRINT' =>  CurrencyFormat(max($allProductPrices), "RUB"), "AVAILABLE_COUNT" => $offersCount);
				$el->SetPropertyValuesEx($ID, $IBLOCK_ID, $updatePrice);
			}
		}

		/**
		 * Если это торговое предложение - ищем родительский элемент и находим количество остатков 
		 */
		$arParentProduct = CCatalogSku::GetProductInfo($ID, $IBLOCK_ID);

		if (is_array($arParentProduct) && $arParentProduct["ID"] != '') {
			$arInfoblockInfo = CCatalogSKU::GetInfoByProductIBlock($arParentProduct["IBLOCK_ID"]);
			if (is_array($arInfoblockInfo)) {
				$rsOffersProdust = CIBlockElement::GetList(array(), array('IBLOCK_ID' => $arInfoblockInfo['IBLOCK_ID'], 'PROPERTY_' . $arInfoblockInfo['SKU_PROPERTY_ID'] => $arParentProduct["ID"]));
				while ($arOffer = $rsOffersProdust->GetNext()) {
					$offerParameters = CCatalogProduct::GetByID($arOffer["ID"]);
					$offersCount += $offerParameters["QUANTITY"];
				}
				$update = array("AVAILABLE_COUNT" => $offersCount);
				$el->SetPropertyValuesEx($arParentProduct["ID"], $arParentProduct['IBLOCK_ID'], $update);
			}
		}
	}
}
AddEventHandler("currency", "CurrencyFormat", "myFormat");
function myFormat($fSum, $strCurrency)
{
	return number_format($fSum, 0, '.', ' ') . ' ₽';
}
