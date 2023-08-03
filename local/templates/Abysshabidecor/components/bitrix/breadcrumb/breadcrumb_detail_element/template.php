<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
function array_swap(array &$array, $key, $key2)
{
    if (isset($array[$key]) && isset($array[$key2])) {
        list($array[$key], $array[$key2]) = array($array[$key2], $array[$key]);
        return true;
    }

    return false;
}
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
array_swap($arResult, $itemSize-2, $itemSize - 1);
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
