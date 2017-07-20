(function($) {
    var Mnav = {
        init: function(options, elem) { // Initialize
            var base = this;
            base.$elem = $(elem);
            base.options = $.extend({}, $.fn.Mnav.options, base.$elem.data(), options);
            base.userOptions = options;
            base.prepContainer();
            base.buildWidget();
        },
        /** This is where the buttons are added to the nav **/
        buildWidget: function() {
            var base = this;
            var mobileContainer = $('<div/>', {
                class: "mnav-mobile-btn"
            });
            base.$elem.addClass(base.options.theme);
            base.$elem.prepend(mobileContainer);
            
            if(base.options.mobileButtonPos === 'left') {
                mobileContainer.css({left:0});
            } else if(base.options.mobileButtonPos === 'right') {
                mobileContainer.css({right:0});
            } else if(base.options.mobileButtonPos === 'center') {
                mobileContainer.css({margin:'auto',position:'relative'});
                base.$elem.css({padding:'0'});
            }
            
            if(!base.options.subMenuOpen) {
                base.$elem.children('.mnav-menu').children('.mnav-menu-item').has('ul').prepend('<span class="mnav-open-close"><b class="mnav-mobile-arrow"></b></span>'); 
            }
            base.addListeners();
        },
        /** Adds listeners to the buttons **/
        addListeners: function() {
            var base = this;
            // Open the main menu
            base.$elem.children('.mnav-mobile-btn').on('click', function() {
                base.openMenu();      
            });
            // Eww jQuery dropwdown for when we're in desktop view (hover)
            base.$elem.children('.mnav-menu').on('mouseenter', '.mnav-menu-item', function(e) {
                if(!base.$elem.children('.mnav-mobile-btn').is(':visible')) {
                    $(this).children('.mnav-submenu').slideToggle(base.options.subMenuSpeed);
                }
            });
            // Same as abot but when the mouse leaves
            base.$elem.children('.mnav-menu').on('mouseleave', '.mnav-menu-item', function(e) {
                if(!base.$elem.children('.mnav-mobile-btn').is(':visible')) {
                    $(this).children('.mnav-submenu').delay(base.options.delayCloseSpeed).slideToggle(base.options.subMenuSpeed);
                }          
            });
            if(!base.options.subMenuOpen) {
                // Showing sub menus
                base.$elem.children('.mnav-menu').on('click', '.mnav-open-close', function() {
                    $(this).siblings('.mnav-submenu:not(li)').slideToggle(base.options.subMenuSpeed);
                    $(this).children('.mnav-mobile-arrow').toggleClass('mnav-mobile-arrow-mirror');
                });
            }
            // Show the menu again just in case
            $(window).resize(function() {
                if(!base.$elem.children('.mnav-mobile-btn').is(':visible')) {
                    base.$elem.find('.mnav-submenu').hide();    
                }
                if(!base.$elem.children('.mnav-mobile-btn').is(':visible') && !base.$elem.children('.mnav-menu').is(':visible')) {
                    base.$elem.children('.mnav-menu').show();
                }
                if(base.$elem.children('.mnav-mobile-btn').is(':visible') && base.options.subMenuOpen) {
                    base.$elem.find('.mnav-submenu').show();
                }
            });
        },
        /** **/
        prepEvents: function() {
            var base = this;
            base.$elem.on('mnav.open', function() {
                base.openMenu();
            });
        },
        /** This is where the necessary classes are added to the elements in your  nav **/
        prepContainer: function() {
            var base = this; 
            base.$elem.children('ul').addClass('mnav-menu');
            base.$elem.children('.mnav-menu')
                .children('li').addClass('mnav-menu-item');
            base.$elem.children('.mnav-menu')
                .children('li')
                    .children('ul').addClass('mnav-submenu');
            base.$elem.children('.mnav-menu')
                .children('li').children('ul')
                    .children('li')
                        .addClass('mnav-submenu-item');    
        },
        openMenu: function() {
            var base = this;
            if(base.options.subMenuOpen) {
                base.$elem.find('.mnav-submenu').show();
            }
            base.$elem.children('.mnav-menu:not(li)').slideToggle(base.options.mainMenuSpeed);            
        }
    };
    $.fn.Mnav = function(options) {
        return this.each(function() {
          var mnav = Object.create(Mnav);
          mnav.init(options, this);
          $.data(this, 'Mnav', mnav);
        });
    };
    $.fn.Mnav.options = {
        theme: null,                // Base class to be used
        
        mainMenuSpeed: 200,         // How fast will the main menu slide down?
        subMenuSpeed: 200,          // How fast will the sub menu slide down?
        delayCloseSpeed: 250,       // How long to wait before the dropdown closes
        
        mobileButtonPos: 'right',   // Which side will the button be?
        
        subMenuOpen: false,         // Sub Menu open by default?
    };
})(jQuery);
