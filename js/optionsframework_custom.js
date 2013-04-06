jQuery(document).ready(function($) {
    // Delta Color Options
    var delta = new Array();
    delta['font_color']='#222222';
    delta['link_color']='#be2110';
    delta['link_hover_color']='#a61d0e';
    delta['light_accent_color']='#a3a3a3';
    delta['light_accent_hover_color']='#8e8e8e';
    delta['dark_accent_color']='#49433C';
    delta['dark_accent_hover_color']='#433E37'; 

    delta['nav_bg_color']='#222222';
    delta['nav_link_color']='#ffffff'; 
    delta['nav_link_hover_color']='#e6e6e6';
    delta['nav_active_bg_color']='#be2110';

    // Mandolin Color Options
    var mandolin = new Array();
    mandolin['font_color']='#8F783D';
    mandolin['link_color']='#191610';
    mandolin['link_hover_color']='#312C20';
    mandolin['light_accent_color']='#d5bf89';
    mandolin['light_accent_hover_color']='#e2cb92'; 
    mandolin['dark_accent_color']='#3d382e';
    mandolin['dark_accent_hover_color']='#574f3b';     

    mandolin['nav_bg_color']='#4E3704';
    mandolin['nav_link_color']='#E9E4D8';
    mandolin['nav_link_hover_color']='#392F18';
    mandolin['nav_active_bg_color']='#ADA285';     

    // Morning Frost Color Options
    var morningfrost = new Array();
    morningfrost['font_color']='#40484F';
    morningfrost['link_color']='#4D7B88';
    morningfrost['link_hover_color']='#204B6E';
    morningfrost['light_accent_color']='#E8FDFF';
    morningfrost['light_accent_hover_color']='#D6FCFF';     
    morningfrost['dark_accent_color']='#AAB3AB';
    morningfrost['dark_accent_hover_color']='#9da6b1'; 

    morningfrost['nav_bg_color']='#204B6E';
    morningfrost['nav_link_color']='#BABDA2';
    morningfrost['nav_link_hover_color']='#EFF5FA';
    morningfrost['nav_active_bg_color']='#0E202F';  

    // Vibrant Options
    var vibrant = new Array();
    vibrant['font_color']='#992C61';
    vibrant['link_color']='#C70060';
    vibrant['link_hover_color']='#BE3778';
    vibrant['light_accent_color']='#FD355D';
    vibrant['light_accent_hover_color']='#F54E00'; 
    vibrant['dark_accent_color']='#FCD228';
    vibrant['dark_accent_hover_color']='#f2d36d';     

    vibrant['nav_bg_color']='#0300A3';
    vibrant['nav_link_color']='#FD2851'; 
    vibrant['nav_link_hover_color']='#041270';
    vibrant['nav_active_bg_color']='#33b0e1'; 

    // Purple Night Options
    var purplenight = new Array();
    purplenight['font_color']='#2e2738';
    purplenight['link_color']='#3A0264';
    purplenight['link_hover_color']='#2E0250';
    purplenight['light_accent_color']='#906090';
    purplenight['light_accent_hover_color']='#6E496E'; 
    purplenight['dark_accent_color']='#483078';
    purplenight['dark_accent_hover_color']='#2C1D49'; 

    purplenight['nav_bg_color']='#483078';
    purplenight['nav_link_color']='#140014'; 
    purplenight['nav_link_hover_color']='#290029';
    purplenight['nav_active_bg_color']='#514C5D';                


    // When the select box #base_color_scheme changes
    // it checks which value was selected and calls of_update_color
    $('#base_color_scheme').change(function() {
        colorscheme = $(this).val();
        if (colorscheme == 'delta') { colorscheme = delta; }
        if (colorscheme == 'mandolin') { colorscheme = mandolin; }
        if (colorscheme == 'morningfrost') { colorscheme = morningfrost; }
        if (colorscheme == 'vibrant') { colorscheme = vibrant; }
        if (colorscheme == 'purplenight') { colorscheme = purplenight; }

        for (id in colorscheme) {
            of_update_color(id,colorscheme[id]);
        }
    });

    // This does the heavy lifting of updating all the colorpickers and text
    function of_update_color(id,hex) {
        $('#section-' + id + ' .of-color').css({backgroundColor:hex});
        $('#section-' + id + ' .colorSelector').ColorPickerSetColor(hex);
        $('#section-' + id + ' .colorSelector').children('div').css('backgroundColor', hex);
        $('#section-' + id + ' .of-color').val(hex);
        $('#section-' + id + ' .of-color').animate({backgroundColor:'#ffffff'}, 600);
    }


    // hide and show hidden fields

    $('#top_bar_logo').click(function() {
        $('#section-top_bar_logo_img').fadeToggle(400);
    });

    if ($('#top_bar_logo:checked').val() !== undefined) {
        $('#section-top_bar_logo_img').show();
    }   

    $('#landing_modal').click(function() {
        $('#section-landing_page_editor').fadeToggle(400);
    });

    if ($('#landing_modal:checked').val() !== undefined) {
        $('#section-landing_page_editor').show();
    }   

    $('#hero_show').click(function() {
        $('#section-featured_offer_title').fadeToggle(400);
    });

    if ($('#hero_show:checked').val() !== undefined) {
        $('#section-featured_offer_title').show();
    }

    $('#hero_show').click(function() {
        $('#section-hero_content').fadeToggle(400);
    });

    if ($('#hero_show:checked').val() !== undefined) {
        $('#section-hero_content').show();
    }


    $('#hero_show').click(function() {
        $('#section-featured_offer_type').fadeToggle(400);
    });

    if ($('#hero_show:checked').val() !== undefined) {
        $('#section-featured_offer_type').show();
    }


	$('#facebook_show').click(function() {
  		$('#section-facebook_url').fadeToggle(400);
	});

	if ($('#facebook_show:checked').val() !== undefined) {
		$('#section-facebook_url').show();
	}

	$('#twitter_show').click(function() {
  		$('#section-twitter_url').fadeToggle(400);
	});

	if ($('#twitter_show:checked').val() !== undefined) {
		$('#section-twitter_url').show();
	}
	
	$('#youtube_show').click(function() {
  		$('#section-youtube_url').fadeToggle(400);
	});

	if ($('#youtube_show:checked').val() !== undefined) {
		$('#section-youtube_url').show();
	}
	
		$('#instagram_show').click(function() {
  		$('#section-instagram_url').fadeToggle(400);
	});

	if ($('#instagram_show:checked').val() !== undefined) {
		$('#section-instagram_url').show();
	}
		$('#pinterest_show').click(function() {
  		$('#section-pinterest_url').fadeToggle(400);
	});

	if ($('#pinterest_show:checked').val() !== undefined) {
		$('#section-pinterest_url').show();
	}

        $('#soundcloud_show').click(function() {
        $('#section-soundcloud_url').fadeToggle(400);
    });

    if ($('#soundcloud_show:checked').val() !== undefined) {
        $('#section-soundcloud_url').show();
    }

        $('#itunes_show').click(function() {
        $('#section-itunes_url').fadeToggle(400);
    });

    if ($('#itunes_show:checked').val() !== undefined) {
        $('#section-itunes_url').show();
    }

        $('#lastfm_show').click(function() {
        $('#section-lastfm_url').fadeToggle(400);
    });

    if ($('#lastfm_show:checked').val() !== undefined) {
        $('#section-lastfm_url').show();
    }

        $('#vimeo_show').click(function() {
        $('#section-vimeo_url').fadeToggle(400);
    });

    if ($('#vimeo_show:checked').val() !== undefined) {
        $('#section-vimeo_url').show();
    }                
	
	$('#tumblr_show').click(function() {
  		$('#section-tumblr_url').fadeToggle(400);
	});

	if ($('#tumblr_show:checked').val() !== undefined) {
		$('#section-tumblr_url').show();
	}
	
	$('#googleplus_show').click(function() {
  		$('#section-googleplus_url').fadeToggle(400);
	});

	if ($('#googleplus_show:checked').val() !== undefined) {
		$('#section-googleplus_url').show();
	}

});
