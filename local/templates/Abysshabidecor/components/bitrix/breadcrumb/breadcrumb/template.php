<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

/**
 * @global CMain $APPLICATION
 */

global $APPLICATION;

//delayed function must return a string
if(empty($arResult))
	return "";

$strReturn = '';
$itemSize = count($arResult);
$strReturn .= '<div class="breadcrumb">';
for($index = 0; $index < $itemSize; $index++)
{
	$title = htmlspecialcharsex($arResult[$index]["TITLE"]);

	if($arResult[$index]["LINK"] <> "" && $index != $itemSize-1)
	{
		$strReturn .= '
				<a href="'.$arResult[$index]["LINK"].'">'.$title.'</a><span class="separator">/</span>';
	}
	else
	{
		$strReturn .= '<span>'.$title.'</span>';
	}
}
$strReturn .= '</div>';
return $strReturn;
