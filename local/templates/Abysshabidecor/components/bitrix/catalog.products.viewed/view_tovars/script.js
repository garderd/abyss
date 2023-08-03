(function() {
	'use strict';

	if (!!window.JCCatalogProductsViewedComponent)
		return;

	window.JCCatalogProductsViewedComponent = function(params) {
		this.container = document.querySelector('[data-entity="' + params.container + '"]');

		if (params.initiallyShowHeader)
		{
			BX.ready(BX.delegate(this.showHeader, this));
		}
	};

	window.JCCatalogProductsViewedComponent.prototype =
	{
		showHeader: function(animate)
		{
			var parentNode = BX.findParent(this.container, {attr: {'data-entity': 'parent-container'}}),
				header;

			if (parentNode && BX.type.isDomNode(parentNode))
			{
				header = parentNode.querySelector('[data-entity="header"]');

				if (header && header.getAttribute('data-showed') != 'true')
				{
					header.style.display = '';

					if (animate)
					{
						new BX.easing({
							duration: 2000,
							start: {opacity: 0},
							finish: {opacity: 100},
							transition: BX.easing.makeEaseOut(BX.easing.transitions.quad),
							step: function(state){
								header.style.opacity = state.opacity / 100;
							},
							complete: function(){
								header.removeAttribute('style');
								header.setAttribute('data-showed', 'true');
							}
						}).animate();
					}
					else
					{
						header.style.opacity = 100;
					}
				}
			}
		}
	}
})();
/******************* /Добавляем товар в просмотренные ********************/
$(document).ready(function(){

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
            },
            error: function(p1,p2,p3) {
                console.log('ERROR',p1,p2,p3);
            }
        });
	});
    /******************* /Добавляем товар в просмотренные ********************/