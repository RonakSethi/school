/**
 * EM QuickShop
 *
 * @license commercial software
 * @copyright (c) 2012 Codespot Software JSC - EMThemes.com. (http://www.emthemes.com)
 */

// disable QuickShop:
// EM_QUICKSHOP_DISABLED = true;

jQuery.noConflict();
qs = null;
jQuery(function ($) {

	//get IE version
	function ieVersion() {
		var rv = -1; // Return value assumes failure.
		if (navigator.appName == 'Microsoft Internet Explorer') {
			var ua = navigator.userAgent;
			var re = new RegExp("MSIE ([0-9]{1,}[\.0-9]{0,})");
			if (re.exec(ua) != null) rv = parseFloat(RegExp.$1);
		}
		return rv;
	}

	//read href attr in a tag
	
	function readHref() {
		var result = arguments[0].replace(EM.QuickShop.BASE_URL, '');
		var patn = /catalog\/product\/view\/id\/(.*?)\//i;
		if (patn.test(result)) {
		var s = patn.exec(result);
		result = 'catalog/product/view/id/' +  s[1];
		} else {
		result = result.replace(/\//gi,"_!_");
		}
		return result;
	}

	//string trim
	function strTrim() {
		return arguments[0].replace(/^\s+|\s+$/g, "");
	}
	
	// quickshop init
	var _qsJnit = function() {
		var selectorObj = arguments[0];
		var listprod = $(selectorObj.itemClass);	// selector chon tat ca cac li chua san pham tren luoi
		var mypath = 'quickshop/index/view/path/';
		var baseUrl = EM.QuickShop.BASE_URL + mypath;

		var _qsHref = "<a id=\"em_quickshop_handler\" href=\"#\" style=\"visibility:hidden;position:absolute;top:0;left:0\"><span><img src='http://bhstore.in/skin/frontend/default/lakhi/images/quick_view_button.png' /></span></a>";
		$(document.body).append(_qsHref);
		var qsHandlerImg = $('#em_quickshop_handler span');

		$.each(listprod, function (index, value) {
			if($(value).parents(".no_quickshop").length <= 0){
				var reloadurl = baseUrl;

				//get reload url
				var prodLinkTag = $(value).find(selectorObj.aClass);
				if (!prodLinkTag || prodLinkTag.length == 0) return;
				var prodHref = readHref(prodLinkTag.attr('href'));
				reloadurl = baseUrl + prodHref;
				// show quickshop handle when hover product image
				$(selectorObj.imgClass, this).bind('mouseover', function () {

					var o = $(this).offset();
					$('#em_quickshop_handler').attr('href', reloadurl).show().css({
							'top': o.top+($(this).height() - qsHandlerImg.height() - 12)/2+'px',
							'left': o.left+($(this).outerWidth(true) - qsHandlerImg.outerWidth(true)-40)/2+'px',
							'visibility': 'visible',
							'z-index':	999
					});
					

					
				
					
					
				});
				$(value, this).bind('mouseover', function () {

					var ele = $(value).find('.product-image').find('img');
					
					var o =  $(ele).offset();
				
					$('#em_quickshop_handler').attr('href', reloadurl).show().css({
							'top': o.top + ($(ele).height() - qsHandlerImg.height() - 12)/2+'px',
							'left': o.left + ($(ele).outerWidth(true) - qsHandlerImg.outerWidth(true)-40)/2+'px',
							'visibility': 'visible',
							'z-index':	999
					});
					

					
				
					
					
				});
				$(value).bind('mouseout', function () {
					$('#em_quickshop_handler').hide();
				});
				
			}
		});

		//fix bug image disapper when hover
		$('#em_quickshop_handler').bind('mouseover', function () {
			$(this).show();
		}).bind('click', function () {
			$(this).hide();
		});

		//insert quickshop popup
		$('#em_quickshop_handler').fancybox({
			'width': EM.QuickShop.QS_FRM_WIDTH,
			'height': EM.QuickShop.QS_FRM_HEIGHT,
			'autoScale': false,
//			'padding': 20,
//			'margin': 20,
			//'transitionIn'		: 'none',
			//'transitionOut'		: 'none',
			'type': 'iframe',
			onStart: function () {$('#em_quickshop_handler').css({'z-index':0})},
			onComplete: function () {
				$.fancybox.showActivity();
				$('#fancybox-frame').unbind('load');
				$('#fancybox-frame').bind('load', function () {
					$.fancybox.hideActivity();
				});
			}
		});
	}

	
		_qsJnit({
			itemClass: '.product_row .product_box, .owl-wrapper .rp_box, li.item .cate_product, .product-upsell-slideshow li.item, .mini-products-list li.item, #crosssell-products-list li.item', //selector for each items in catalog product list,use to insert quickshop image
			aClass: 'a.more_button', //selector for each a tag in product items,give us href for one product
			imgClass: '.re_image_box img' //class for quickshop href
		});
		qs = _qsJnit;
});

