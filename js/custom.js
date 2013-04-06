jQuery(document).foundation();

(function ($, window, undefined) {


/* Functions */
$.fn.invisible = function() {
    return this.css("visibility", "hidden");
    };
$.fn.visible = function() {
    return this.css("visibility", "visible");
};
$.fn.exists = function() { 
   return this.length > 0; 
}; 

// Adds support for the top-bar with dropdowns in WordPress
$('.top-bar li').has('ul').addClass("has-dropdown");
$('.top-bar li ul').addClass("dropdown");

// Adds wrap to video iframe embeds
if ( $('iframe[src*="vimeo.com"]').exists() ) { 
	$('iframe[src*="vimeo.com"]').wrap('<div class="flex-video vimeo widescreen" />');
};

if ( $('iframe[src*="vimeo.com"]').exists() ) { 
	$('iframe[src*="vimeo.com"]').wrap('<div class="flex-video widescreen" />');
};

})(jQuery, this);


// Scroll Top
(function($){addScrollTopAnimation();function addScrollTopAnimation(){var $scrolltop_link=$('#scroll-top');$scrolltop_link.on('click',function(ev){ev.preventDefault();$('html, body').animate({scrollTop:0},700);}).data('hidden',1).hide();var scroll_event_fired=false;$(window).on('scroll',function(){scroll_event_fired=true;});setInterval(function(){if(scroll_event_fired){scroll_event_fired=false;var is_hidden=$scrolltop_link.data('hidden');if($(this).scrollTop()>$(this).height()/2){if(is_hidden){$scrolltop_link.fadeIn(600).data('hidden',0);}}
else{if(!is_hidden){$scrolltop_link.slideUp().data('hidden',1);}}}},300);}})(jQuery);  
