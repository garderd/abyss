$(document).ready(function() {
    // прокинем информацию о том, что элемент "просмотрен"
    var jsDataJSON = $("#productJSData").data('json');

    // запрос на добавление элемента в "просмотренные"
    $.ajax({
        url: '/bitrix/components/bitrix/catalog.element/ajax.php',
        method: 'POST',
        data: {
            AJAX: 'Y',
            SITE_ID: jsDataJSON.siteId,
            PRODUCT_ID: jsDataJSON.id,
            PARENT_ID: jsDataJSON.id
        },
        success: function(obj) {
            // some action on success
        },
        error: function(p1,p2,p3) {
            console.log('ERROR',p1,p2,p3);
        }
    });
});