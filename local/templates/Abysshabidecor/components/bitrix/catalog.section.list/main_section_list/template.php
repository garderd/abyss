<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
?>

<?
$TOP_DEPTH = $arResult["SECTION"]["DEPTH_LEVEL"];
$CURRENT_DEPTH = $TOP_DEPTH;
?>
<div class="container catalog-list-main-page" style="padding: 0 !important">
<?
foreach($arResult["SECTIONS"] as $arSection):
	$this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], CIBlock::GetArrayByID($arSection["IBLOCK_ID"], "SECTION_EDIT"));
	$this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], CIBlock::GetArrayByID($arSection["IBLOCK_ID"], "SECTION_DELETE"), array("CONFIRM" => GetMessage('CT_BCSL_ELEMENT_DELETE_CONFIRM')));
	if($CURRENT_DEPTH < $arSection["DEPTH_LEVEL"])
		echo "\n",str_repeat("\t", $arSection["DEPTH_LEVEL"]-$TOP_DEPTH),"<ul class='catalog-list-slider d-flex'><div class='swiper-wrapper'>";
	elseif($CURRENT_DEPTH == $arSection["DEPTH_LEVEL"])
		echo "</li>";
	else
	{
		while($CURRENT_DEPTH > $arSection["DEPTH_LEVEL"])
		{
			echo "</li>";
			echo "\n",str_repeat("\t", $CURRENT_DEPTH-$TOP_DEPTH),"</ul>","\n",str_repeat("\t", $CURRENT_DEPTH-$TOP_DEPTH-1);
			$CURRENT_DEPTH--;
		}
		echo "\n",str_repeat("\t", $CURRENT_DEPTH-$TOP_DEPTH),"</li>";
	}

	echo "\n",str_repeat("\t", $arSection["DEPTH_LEVEL"]-$TOP_DEPTH);
	?>
	<li class="swiper-slide catalog-list-slide" id="<?=$this->GetEditAreaId($arSection['ID']);?>">
		<a href="<?=$arSection["SECTION_PAGE_URL"]?>">
			<div class="img-wrapper">
				<?
					$resize_image = CFile::ResizeImageGet($arSection['PICTURE']['ID'],
					Array("width" => 240, "height" => 263),
					BX_RESIZE_IMAGE_EXACT, false);
				?>
				<img src="<?=$resize_image['src']?>" alt="<?=$arSection["NAME"]?>">
			</div>
			<span><?=$arSection["NAME"]?></span>
		</a>
		<?
	$CURRENT_DEPTH = $arSection["DEPTH_LEVEL"];
endforeach;
while($CURRENT_DEPTH > $TOP_DEPTH)
{
	echo "</li>";
	echo "\n",str_repeat("\t", $CURRENT_DEPTH-$TOP_DEPTH),"</div></ul> <div class='catalog-list-slider-pagination'></div>","\n",str_repeat("\t", $CURRENT_DEPTH-$TOP_DEPTH-1);
	$CURRENT_DEPTH--;
}
?>
</div>

