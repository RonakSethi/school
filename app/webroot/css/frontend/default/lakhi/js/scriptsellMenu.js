/*
 /*
 * File: scriptsellMenu.js
 * Version: 1.0
 * Description: Responsive jQuery CSS3 Menu plugin
 * Author: saif Sohel (proscriptsell@gmail.com)
 * Copyright 2014,.http://scriptsell.net/
 * 
 /* Licensed: You should purchase !
 */
 
(function($){	
	$.fn.scriptsellMenu= function(options){
		var defaults = {
			animationSpeed:150,
			theme:'light-sky-blue',
			animation:'rotate',
			arrow:true,
			tooltrip:'top',
			hoverelements:'<span>',
			dropdownWidth:250,
			menuheight:38,
			deviceswidth:768
		};
		var obj = {};
		$.extend(obj, defaults, options);
		return this.each(function(j){
			var $this=$(this);
			/*-----------------CHECK UL ELEMENTS----------------*/
			if(!$(this).is('ul')){
				return true;
			}
			if(!$(this).is('.nav')){
				$(this).addClass('nav')
			}
		
			/*----------SET THEME ----------*/
			$(this).addClass(obj.theme).css('min-height',obj.menuheight+'px');
			$(this).find('li a').css('line-height',obj.menuheight+'px');
			/* RESPONSIVE ELEMNTS */
			var res=$('<div>',{class:'menu-toggle-button inactive-devices '+ obj.theme,text:obj.responsivemenutext})
			.append('<span>≡</span>').css({'min-height':obj.menuheight+'px','line-height':obj.menuheight+'px'});
			$this.before(res);
			
			/**--------- SET ELEMENTS ----------*/
			$this.find("li").each(function(){
				var target_animation;
				/*----------------- ANIMATION EFFECTS SET-----------------*/
				if($(this).find('a').length){
					if(obj.animation=="slide-top"){
						$(this).prepend($(obj.hoverelements,{class:'hover',height:+$(this).innerWidth()}).css('top','0px'));
					}else if(obj.animation=="slide"){
						$(this).prepend($(obj.hoverelements,{class:'hover',height:+$(this).innerWidth()}).css('bottom','0px'));
					}else if(obj.animation=="fadeinout"){
						$(this).prepend($(obj.hoverelements,{class:'mask'}));
					}else if(obj.animation=="zoom"){
						$(this).prepend($(obj.hoverelements,{class:'mask zoom'}));
					}else if(obj.animation=="bounce"){
						$(this).prepend($(obj.hoverelements,{class:'mask bounce'}));
					}
					else if(obj.animation=="rotate"){
						$(this).prepend($(obj.hoverelements,{class:'mask rotate'}));
					}
					
				}else{
					$(this).addClass('html_content');
				}	
				
				/*----------------- ARROW SET-----------------*/
				if($(this).find('ul').length && obj.arrow==true){
						$(this).append('<i class="arrow"></i>');
						if($(document).width() <=  obj.deviceswidth){
							$(this).find('ul').addClass('responsivedropdown');
						}else{
							$(this).find('ul').addClass('dropdownmenu');
						}
					}
				/*-----------------TOOL TRIP----------------*/
				if($(this).data('tool')){
					var toolTrip=$('<div>',{class:'navToolTrip '+ obj.tooltrip,text:$(this).data('tool')})
					.append('<i class="toolTripArrows"></i>');
					$(this).prepend(toolTrip);
				}
				/*----------------- SET MULTI CLOUMN DROP DOWN----------------*/
				$(this).find(">ul").each(function(i){
					$(this).css('min-width',obj.dropdownWidth+'px');
					var left_move=$(this).width()*i;
					if(i!=0){
						$(this).css('left',left_move);
					}
				})
				/*----------------- ARROW SET-----------------*/
				if($(this).find('>ul').length && obj.arrow==true){
					$(this).addClass('submenu');
					if($(this).innerHeight()==0){
						$this.find('.submenu>.arrow')
						.css('top',Math.round(obj.menuheight/2)-2+'px');
					}else{
						$this.find('.submenu>.arrow')
						.css('top',Math.round($(this).innerHeight()/2)-2+'px');
						
					}
				}
				
				/*-----------------Data Align SET----------------*/
				if($(this).data('align')){
					$(this).css('float',$(this).data('align'));
					if($(this).data('align')=='right'){
						$(this).find('ul').css({'left':'auto','right':'0px'});
					}
				}
				/*-----------------Data Align SET----------------*/
				if($(this).data('bg')){
					$(this).css('background',$(this).data('bg'));
				}
			
			})
			$this.prev('.menu-toggle-button').click(function(){
				if($(this).hasClass('devices-active')) {
					$(this)
					.removeClass('devices-active')
					.next('ul')
					.hide();
				}else{
					$(this)
					.addClass('devices-active')
					.next('ul')
					.show();
				}
				
			})
					
			/*-----------------HOVER EVENTS----------------*/
			$this.find("li").hover(
				
				//Mouseover, fadeIn the hidden hover class	
				function() {
					//hide its Hover Effects
					if($('.hover').length && ! $(this).is('.selected')){
						$(this).children('.hover').css('height',$(this).innerHeight()).stop(true).slideDown(obj.animationSpeed);
					}					
					if($('.mask').length && ! $(this).is('.selected')){
						$(this).children('.mask').addClass('maskhover')
						.delay(obj.animationSpeed).height((Math.round($(this).innerHeight())));
					}
					//ToolTrip
					if($(document).width() <=  obj.deviceswidth){
						if($(this).find('>.navToolTrip').length && obj.tooltrip=='top'){
							$(this).find('>.navToolTrip').css({left:'0px',top:'-'+(obj.menuheight+10)+'px'}).show();
						}else{
							$(this).find('>.navToolTrip').css({left:'0px',top:(obj.menuheight+10)+'px'}).show();
						}
					}else{
						if($(this).find('>.navToolTrip').length && obj.tooltrip=='top'){
							$(this).find('>.navToolTrip')
							.css({left:($(this).width()-7)+'px',bottom:(Math.round($(this).innerHeight())+10)+'px'}).show();
						}else{
							$(this).find('>.navToolTrip')
							.css({left:($(this).width()-7)+'px',top:(Math.round($(this).innerHeight())+10)+'px'}).show();
						}
					}
					//show its submenu
					if($(this).parents('li').length){
						if($(this).parents('li').data('align')=='right'){
							$('>ul.dropdownmenu', this).stop(true)
							.slideDown(obj.animationSpeed).css({right:($(this).width())+'px'});
						}else{
							$('>ul.dropdownmenu', this).stop(true)
							.slideDown(obj.animationSpeed).css({left:($(this).width())+'px'});
						}
					}else{
						$('>ul.dropdownmenu', this).stop(true).slideDown(obj.animationSpeed);	
					}
					
					
				}, 
				//Mouseout, fadeOut the hover class
				function() {
					//hide its Hover Effects
					$(this).children('.hover').stop(true).slideUp(obj.animationSpeed);
					//hide its submenu
					$('>ul.dropdownmenu', this).stop(true).slideUp(obj.animationSpeed);
					if($('.mask').length){
						$(this).children('.mask').removeClass('maskhover').delay(obj.animationSpeed);
					}
					if($(this).find('>.navToolTrip').length){
						$(this).find('>.navToolTrip').hide();
					}
				}
			).find('a').click (function () {
				//Add selected class if user clicked on it
					$(this).parent('li').addClass('selected');
					if($(document).width() <=  obj.deviceswidth){
						if($(this).parent('li').find('>ul').is('.activedropdown')){
							$(this).parent('li').find('>ul').slideUp(obj.animationSpeed).removeClass('activedropdown').eq(0);
						}else{
							$(this).parent('li').find('>ul').slideDown(obj.animationSpeed).addClass('activedropdown').eq(0);
						}
					}
					
				})
			
		
			
			
			$(window).resize(function(){
					if($(document).width() <=  obj.deviceswidth){
						$('li>ul').addClass('responsivedropdown').removeClass('dropdownmenu').hide();
					}else{
						$('li>ul').addClass('dropdownmenu').removeClass('responsivedropdown').hide();
					}
			});	
			
		})

	
	}
})(jQuery)