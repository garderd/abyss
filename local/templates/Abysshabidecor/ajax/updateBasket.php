<?require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

CModule::IncludeModule("catalog");
CModule::IncludeModule("sale");


$dbBasketItems = CSaleBasket::GetList(
	array(
		"NAME" => "ASC",
		"ID" => "ASC"
	),
	array(
		"FUSER_ID" => CSaleBasket::GetBasketUserID(),
		"LID" => SITE_ID,
		"ORDER_ID" => "NULL"
	),
	false,
	false,
	array("PRODUCT_ID", "ID","QUANTITY")
);
while ($arItems = $dbBasketItems->Fetch())
{
	if ($_POST["id"] == $arItems["PRODUCT_ID"]) {
		$basketID = $arItems["ID"];
	}
}

$arFields = array(
   "QUANTITY" => $_POST["count"]
);

CSaleBasket::Update($basketID, $arFields);



$dbBasketItems = CSaleBasket::GetList(
	array(
		"NAME" => "ASC",
		"ID" => "ASC"
	),
	array(
		"FUSER_ID" => CSaleBasket::GetBasketUserID(),
		"LID" => SITE_ID,
		"ORDER_ID" => "NULL"
	),
	false,
	false,
	array("PRODUCT_ID", "ID","QUANTITY")
);
while ($arItems = $dbBasketItems->Fetch())
{
	$quanity['res'] = $arItems["QUANTITY"]; 
}
$quanity['currentCount'] = $_POST["count"];
echo json_encode($quanity);