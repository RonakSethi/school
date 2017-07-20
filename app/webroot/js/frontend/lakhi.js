jQuery(document).ready(function() {
    jQuery(".nav1").scriptsellMenu({
        animationSpeed: 150,
        animationForm: 'top',
        theme: 'light-brown',
        animation: 'slide',
        arrow: true,
        tooltrip: 'bottom',
        hoverelements: '<span>',
        dropdownWidth: 250,
        menuheight: 37,
        deviceswidth: 768
    });


    jQuery('#horizontalTab_new').easyResponsiveTabs({
        type: 'default', //Types: default, vertical, accordion           
        width: 'auto', //auto or any width like 600px
        fit: true, // 100% fit in a container
        closed: 'accordion', // Start closed if in accordion view
        activate: function(event) { // Callback function if tab is switched
            var $tab = jQuery(this);
            var $info = jQuery('#tabInfo');
            var $name = jQuery('span', $info);

            $name.text($tab.text());

            $info.show();
        }
    });

    jQuery('#verticalTab').easyResponsiveTabs({
        type: 'vertical',
        width: 'auto',
        fit: true,
    });



    jQuery("#contactLink").click(function(e) {
        if (jQuery("#contactForm").is(":hidden")) {
            jQuery("#contactForm").slideDown("slow");
        }
        else {
            jQuery("#contactForm").slideUp("slow");
        }
        
    });

    jQuery('.slide-out-div').tabSlideOut({
        tabHandle: '.handle', //class of the element that will be your tab
        pathToTabImage: 'http://bhstore.in/skin/frontend/default/lakhi/images/needhelp.png', //path to the image for the tab (optionaly can be set using css)
        imageHeight: '155px', //height of tab image
        imageWidth: '41px', //width of tab image    
        tabLocation: 'right', //side of screen where tab lives, top, right, bottom, or left
        speed: 300, //speed of animation
        action: 'click', //options: 'click' or 'hover', action to trigger animation
        topPos: '200px', //position from the top
        fixedPosition: true                               //options: true makes it stick(fixed position) on scroll
    });
    
    jQuery(".video_display").fancybox({
		'transitionIn'	: 'none',
		'transitionOut'	: 'none',
                'type': 'iframe'
	});


});


jQuery(window).load(function() {
    jQuery('#slider').nivoSlider();
});

jQuery(window).load(function() {
    //jQuery('.sp-wrap').smoothproducts();
});


jQuery(document).ready(function() {
    jQuery('.accordion-toggle').on('click', function(event) {
        event.preventDefault();
        // create accordion variables
        var accordion = jQuery(this);
        var accordionContent = accordion.next('.accordion-content');
        var accordionToggleIcon = jQuery(this).children('.toggle-icon');

        // toggle accordion link open class
        accordion.toggleClass("open");
        // toggle accordion content
        accordionContent.slideToggle(250);

        // change plus/minus icon
        if (accordion.hasClass("open")) {
            accordionToggleIcon.html("<i class='fa fa-angle-down'></i>");
        } else {
            accordionToggleIcon.html("<i class='fa fa-angle-right'></i>");
        }
    });
});


jQuery(document).ready(function() {
    jQuery(".second").owlCarousel({
        lazyLoad: true,
        autoPlay: true,
        navigation: true,
        pagination: false,
        autoPlay : false,
                items: 4,
        itemsDesktop: [1199, 4],
        itemsDesktopSmall: [980, 2],
        itemsTablet: [768, 2],
        itemsTabletSmall: false,
        itemsMobile: [479, 1],
    });
});

jQuery(document).ready(function() {
    jQuery(".third").owlCarousel({
        lazyLoad: true,
        autoPlay: true,
        navigation: false,
        pagination: false,
        autoPlay : true,
                items: 4,
        itemsDesktop: [1199, 4],
        itemsDesktopSmall: [980, 3],
        itemsTablet: [768, 3],
        itemsTabletSmall: false,
        itemsMobile: [479, 1],
    });

    jQuery(".related").owlCarousel({
        lazyLoad: true,
        autoPlay: true,
        navigation: false,
        pagination: false,
        autoPlay : true,
                items: 4,
        itemsDesktop: [1199, 3],
        itemsDesktopSmall: [980, 2],
        itemsTablet: [768, 2],
        itemsTabletSmall: false,
        itemsMobile: [479, 1],
    });
});

function opnePop()
{

    jQuery('#button_to_pop_up').bPopup({
        modalClose: false,
        opacity: 0.6,
        positionStyle: 'absolute' //'fixed' or 'absolute'
    });

    //jQuery('#button_to_pop_up').bPopup();
    return false;

}

function closePop() {
    jQuery('#button_to_pop_up').bPopup().close();
    return false;
}

function opnePop1()
{

    jQuery('#quick-view').bPopup({
        modalClose: false,
        opacity: 0.6,
        positionStyle: 'absolute' //'fixed' or 'absolute'
    });

    //jQuery('#button_to_pop_up').bPopup();
    return false;

}

function closePop1() {
    jQuery('#quick-view').bPopup().close();
    return false;
}


var dropdown = 'nav li:has(ul)',
        dropdown_ul = 'nav li ul',
        nav_ul = 'nav > ul',
        nav_toggle = 'nav .nav-toggle',
        open_class = 'open',
        desktop_class = 'desktop',
        breakpoint = 768,
        anim_delay = 200;


function isDesktop() {
    return (jQuery(window).width() > breakpoint);
}



jQuery(function() {
    jQuery(document).click(function(e) {
        var target = jQuery(e.target).parent();
        var target_ul = target.children('ul');

        if (!isDesktop()) {
            jQuery(dropdown).not(target).removeClass(open_class);
            jQuery(dropdown_ul).not(target_ul).slideUp(anim_delay);

            if (target.is(dropdown)) {
                target.toggleClass(open_class);
                target_ul.slideToggle(anim_delay);
            }

            if (target.is(nav_toggle)) {
                target.toggleClass(open_class);
                jQuery(nav_ul).slideToggle(anim_delay);
            }
        }
    })

    jQuery(window).resize(function() {
        jQuery('body').toggleClass(desktop_class, isDesktop());

        if (isDesktop()) {
            jQuery(dropdown).removeClass(open_class);
            jQuery(dropdown_ul).hide();
            jQuery(nav_toggle).addClass(open_class);
            jQuery(nav_ul).show();
        }
    });

    jQuery(window).resize();
    
    
});









        