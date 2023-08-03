<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

/** @var array $arParams */
/** @var array $arResult */
/** @var CBitrixComponentTemplate $this */

$this->setFrameMode(true);

?>
	

<div id="navigatsia" class="bx-pagination <?=$colorScheme?>">
	<div class="bx-pagination-container">

		<?if($arResult["NavPageNomer"] < $arResult["NavPageCount"]):?>		
		<a id="ajaxNav" class="all_kolekt" data-url="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]+1)?>">Показать ещё</a>
		<?endif?>

	</div>
</div>
<script type="text/javascript">

    $(document).on('click', '#ajaxNav', function(){
        var targetContainer = $('.catalog-section__element-wrapper .row');         //  Контейнер, в котором хранятся элементы
        var targetNavContainer = $('.catalog-section__element-wrapper');         //  Контейнер, в котором хранится навигация
        var url =  $('#ajaxNav').attr('data-url');    //  URL, из которого будем брать элементы

        if (url !== undefined) {
            $.ajax({
                type: 'GET',
                url: url,
                dataType: 'html',
                success: function(data){

                    //  Удаляем старую навигацию
                    $('#navigatsia').remove();

                    var elements = $(data).find('.catalog-section__element');  //  Ищем элементы
                    var pagination = $(data).find('#navigatsia');//  Ищем навигацию

                    targetContainer.append(elements);   //  Добавляем посты в конец контейнера
                    targetNavContainer.after(pagination); //  добавляем навигацию следом

                }
            })
        }

    });
 </script>