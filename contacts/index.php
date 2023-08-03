<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Контакты");
$APPLICATION->SetTitle("Контакты");
?><div class="container">
	 <?$APPLICATION->IncludeComponent(
	"bitrix:breadcrumb",
	"breadcrumb",
	Array(
		"PATH" => "",
		"SITE_ID" => "s1",
		"START_FROM" => "0"
	)
);?>
</div>
<div class="container">
	<h1 class="contacts__h1"><?$APPLICATION->showTitle(false)?></h1>
</div>
<div class="container contacts__container">
	 <?$APPLICATION->IncludeComponent(
		"bitrix:main.include",
		".default",
		Array(
			"AREA_FILE_SHOW" => "file",
			"COMPONENT_TEMPLATE" => ".default",
			"PATH" => "/local/templates/Abysshabidecor/includes/contacts.php"
		)
	);?>
</div>

 

<?
$path = SITE_TEMPLATE_PATH."/includes/feedback_block.php"; 
$APPLICATION->IncludeComponent(
	"bitrix:main.include",
	".default",
	Array(
		"AREA_FILE_SHOW" => "file",
		"COMPONENT_TEMPLATE" => ".default",
		"PATH" => $path
	)
);?>


<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>