/* Foundation Scripts */
//@codekit-prepend "foundation.js";
//@codekit-prepend "foundation.alerts.js";
//@codekit-prepend "foundation.cookie.js;
//@codekit-prepend "foundation.forms.js";
//@codekit-prepend "foundation.placeholder.js";
//@codekit-prepend "foundation.section.js";
//@codekit-prepend "foundation.topbar.js";


/* Sitewide Scripts */
//@codekit-prepend "jquery.easing.min.js";
//@codekit-prepend "picturefill.min.js";
//@codekit-prepend "jquery-timing.min.js";
//@codekit-append "jquery.scrolltop.min.js"; 


jQuery(document).foundation();

(function ($) {


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
if ($('iframe[src*="vimeo.com"]').exists()) { 
	$('iframe[src*="vimeo.com"]').wrap('<div class="flex-video vimeo widescreen" />');
};

if ($('iframe[src*="vimeo.com"]').exists()) { 
	$('iframe[src*="vimeo.com"]').wrap('<div class="flex-video widescreen" />');
};

// Add Lightbox Functions
if ($('a[rel="swipebox"]').exists()) {
	$('a[rel="swipebox"]').swipebox();
}

})(jQuery, this);
