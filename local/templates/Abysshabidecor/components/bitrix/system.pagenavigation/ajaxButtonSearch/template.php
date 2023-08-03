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
        getParams = document.location.search.substring(1);
        var targetContainer = $('.catalog-section__element-wrapper .row');         //  Контейнер, в котором хранятся элементы
        var targetNavContainer = $('.catalog-section__element-wrapper');         //  Контейнер, в котором хранится навигация
        var url =  $('#ajaxNav').attr('data-url');    //  URL, из которого будем брать элементы
        if (url !== undefined) {
            $.ajax({
                type: 'GET',
                url: url + '&' + getParams,
                dataType: 'html',
                success: function(data){

                    var elements = $(data).find('.catalog-section__element');  //  Ищем элементы
                    var pagination = $(data).find('#navigatsia');//  Ищем навигацию

                    if(elements.length != 0 && pagination.length != 0){
                        $('#navigatsia').remove();
                    }
                    else{
                        console.log('Произошла ошибка постраничной навигации');
                    }

                    targetContainer.append(elements);   //  Добавляем посты в конец контейнера
                    targetNavContainer.after(pagination); //  добавляем навигацию следом

                }
            })
        }

    });
 </script>