<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * By default it uses the theme name, in lowercase and without spaces, but this can be changed if needed.
 * If the identifier changes, it'll appear as if the options have been reset.
 */

function optionsframework_option_name() {

	// This gets the theme name from the stylesheet
	$themename = get_option( 'stylesheet' );
	$themename = preg_replace("/\W/", "_", strtolower($themename) );

	$optionsframework_settings = get_option( 'optionsframework' );
	$optionsframework_settings['id'] = $themename;
	update_option( 'optionsframework', $optionsframework_settings );
}

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the 'id' fields, make sure to use all lowercase and no spaces.
 *
 * If you are making your theme translatable, you should replace 'options_framework_theme'
 * with the actual text domain for your theme.  Read more:
 * http://codex.wordpress.org/Function_Reference/load_theme_textdomain
 */

function optionsframework_options() {

	// Typography Defaults
	$typography_defaults = array(
		'size' => '15px',
		'face' => 'Helvetica Neue ',
		'style' => 'normal'
	);
		
	// Typography Options
	$typography_options = array(
		'sizes' => array( '12','14','16','20' ),
		'faces' => array( 'Helvetica Neue' => 'Helvetica Neue','Arial' => 'Arial' ),
		'styles' => array( 'normal' => 'Normal','bold' => 'Bold' ),
		'color' => false
	);

	// Pull all the categories into an array
	$options_categories = array();
	$options_categories_obj = get_categories();
	foreach ($options_categories_obj as $category) {
		$options_categories[$category->cat_ID] = $category->cat_name;
	}
	
	// Pull all tags into an array
	$options_tags = array();
	$options_tags_obj = get_tags();
	foreach ( $options_tags_obj as $tag ) {
		$options_tags[$tag->term_id] = $tag->name;
	}


	// Pull all the pages into an array
	$options_pages = array();
	$options_pages_obj = get_pages('sort_column=post_parent,menu_order');
	$options_pages[''] = 'Select a page:';
	foreach ($options_pages_obj as $page) {
		$options_pages[$page->ID] = $page->post_title;
	}
		
	// If using image radio buttons, define a directory path
	$imagepath =  get_template_directory_uri() . '/images/';

	$wp_editor_settings = array(
		'wpautop' => true, 
		'textarea_rows' => 5,
		'tinymce' => array( 'plugins' => 'wordpress' )
	);	
		
	$options = array();
	
	$base_color_scheme_array = array("delta" => "Delta" , "mandolin" => "Mandolin", "morningfrost" => "Morning Frost", "vibrant" => "Vibrant", "purplenight" => "Purple Night");
	
	$options[] = array(
	    "name" => "Colors",
	    "type" => "heading");
	
	$options[] = array(
	    "name" => "Base Color Scheme",
	    "desc" => "Choose an overall color scheme.  Each color picker can be changed individually",
	    "id" => "base_color_scheme",
	    "std" => "delta",
	    "type" => "select",
	    "class" => "mini",
	    "options" => $base_color_scheme_array);
		
						
	$options[] = array( "name" => "Font Color",
						"desc" => "Default used if no color is selected.",
						"id" => "font_color",
						"std" => "#222222",
						"type" => "color");						
						
	$options[] = array( "name" => "Link Color",
						"desc" => "Default used if no color is selected.",
						"id" => "link_color",
						"std" => "#be2110",
						"type" => "color");
					
	$options[] = array( "name" => "Link: Hover Color",
						"desc" => "Default used if no color is selected.",
						"id" => "link_hover_color",
						"std" => "#a61d0e",
						"type" => "color");

	$options[] = array( "name" => "Navigation Background Color",
						"desc" => "Default used if no color is selected.",
						"id" => "nav_bg_color",
						"std" => "#222222",
						"type" => "color");
						
	$options[] = array( "name" => "Navigation Bar Link Color",
						"desc" => "Navigation Bar link color.",
						"id" => "nav_link_color",
						"std" => "#ffffff",
						"type" => "color");

	$options[] = array( "name" => "Navigation Bar Link Hover Color",
						"desc" => "Navigation Bar link hover color and active foreground color.",
						"id" => "nav_link_hover_color",
						"std" => "#e6e6e6",
						"type" => "color");									
				
	$options[] = array( "name" => "Navigation Bar Active Background Color",
						"desc" => "active background color and hover background color",
						"id" => "nav_active_bg_color",
						"std" => "#be2110",
						"type" => "color");		

	$options[] = array( "name" => "Dark Accent Color",
						"desc" => "buttons, post format box, category label, tag label, pagination, alert box, callout panel and a few others",
						"id" => "dark_accent_color",
						"std" => "#49433C",
						"type" => "color");

	$options[] = array( "name" => "Dark Accent Hover Color",
						"id" => "dark_accent_hover_color",
						"std" => "#433E37",
						"type" => "color");	

	$options[] = array( "name" => "Light Accent Color",
						"desc" => "secondary buttons, secondary labels, highlight, price tag (when using woocommerce) and a few others",
						"id" => "light_accent_color",
						"std" => "#a3a3a3",
						"type" => "color");

	$options[] = array( "name" => "Light Accent Hover Color",
						"id" => "light_accent_hover_color",
						"std" => "#8e8e8e",
						"type" => "color");		
											

	$options[] = array( "name" => "Layout",
						"type" => "heading");
						
	$options[] = array( 
		"name" => "Top Bar Logo",
		"desc" => "Show logo in top bar? If not provided the site name will be shown instead",
		"id" => "top_bar_logo",
		"std" => "0",
		"type" => "checkbox");	
						
	$options[] = array(
		"name" => __("Top Bar Logo Upload"),
		"desc" => __("Upload or choose a logo image"),
		"id" => "top_bar_logo_img",
		"class" => 'hidden',	
		"type" => "upload");									
						
	$options[] = array( "name" => "Home Posts",
						"desc" => "Show posts on home page?",
						"id" => "homeposts",
						"std" => "1",
						"type" => "checkbox");						
						
	$options[] = array( "name" => "Show Landing Page Modal",
						"desc" => "Show landing modal on home page?  This will produce an overlay area on the home page.  A great way to share a special announcement",
						"id" => "landing_modal",
						"std" => "0",
						"type" => "checkbox");
	
	$options[] = array(
		"name" => "Landing Page Information",
		"desc" => "Information for the landing page modal on the home page (html and shortcodes welcome)",
		"id" => 'landing_page_editor',
		"class" => 'hidden',		
		"type" => 'editor',
		"settings" => $wp_editor_settings );

	$options[] = array( "name" => "Featured Offer Check",
						"desc" => "Show featured offer area on home page",
						"id" => "hero_show",
						"std" => "0",
						"type" => "checkbox");	
						
	$options[] = array(
		'name' => __('Featured Offer Title'),
		'desc' => __('Name your featured offer'),
		'id' => 'featured_offer_title',
		'std' => 'Featured Offer',
		'class' => 'hidden',
		'type' => 'text');						

	$options[] = array(
		"name" => "Featured Offer",
		"desc" => "Place your featured offer information here",
		"id" => 'hero_content',
		"type" => 'editor',
		"class" => 'hidden',
		"settings" => $wp_editor_settings );


	$options[] = array( "name" => "Featured Offer Type",
						"desc" => "Is this offer a video, topspin email for media or other type of iframe embed?",
						"id" => "featured_offer_type",
						"std" => "1",
						"class" => "hidden",
						"type" => "checkbox");			
		
					
	$options[] = array(
		'name' => "Multipost Layout",
		'desc' => "Choose a column layout for blog and archive pages (tag, date, author, etc)",
		'id' => "layout_images",
		'type' => "images",
		'options' => array(
			'' => $imagepath . '1col.png',
			'six columns' => $imagepath . '2col.png',
			'four columns' => $imagepath . '3col.png',
			'three columns' => $imagepath . '4col.png'
			)
	);				

	$options[] = array( "name" => "Footer",
						"type" => "heading");	
						
	$options[] = array(
		'name' => __('Soundcloud Stratus'),
		'desc' => sprintf( __( 'The music player at the bottom is controlled by Soundcloud Stratus.  Read more about <a href="%1$s" target="_blank">Stratus</a>'), 'http://stratus.sc/' ),
				'type' => 'info');						
						
	$options[] = array(
		'name' => __('Soundcloud Stratus url'),
		'desc' => __('Complete Soundcloud Stratus here'),
		'id' => 'stratus_url',
		'std' => 'https://soundcloud.com/djyonny/sets/yonny-original-productions',
		'type' => 'text');						

	$options[] = array(
		'name' => __('Show Facebook Icon'),
		'id' => 'facebook_show',
		"std" => "1",
		'type' => 'checkbox');
		
	$options[] = array(
		'name' => __('Facebook url'),
		'desc' => __('Complete Facebook url here'),
		'id' => 'facebook_url',
		'std' => 'https://facebook.com/',
		'class' => 'hidden',
		'type' => 'text');

	$options[] = array(
		'name' => __('Show Twitter Icon'),
		'id' => 'twitter_show',
		"std" => "1",
		'type' => 'checkbox');
		
	$options[] = array(
		'name' => __('Twitter url'),
		'desc' => __('Complete Twitter url here'),
		'id' => 'twitter_url',
		'std' => 'https://twitter.com/',
		'class' => 'hidden',
		'type' => 'text');
		
	$options[] = array(
		'name' => __('Show Youtube Icon'),
		'id' => 'youtube_show',
		"std" => "1",
		'type' => 'checkbox');
		
	$options[] = array(
		'name' => __('Youtube url'),
		'desc' => __('Complete Youtube url here'),
		'id' => 'youtube_url',
		'std' => 'http://www.youtube.com/user/',
		'class' => 'hidden',
		'type' => 'text');
		
		$options[] = array(
		'name' => __('Show Instagram Icon'),
		'id' => 'instagram_show',
		"std" => "1",
		'type' => 'checkbox');
		
	$options[] = array(
		'name' => __('Instagram url'),
		'desc' => __('Complete Instagram url here'),
		'id' => 'instagram_url',
		'std' => 'http://instagram.com/',
		'class' => 'hidden',
		'type' => 'text');	
		
	$options[] = array(
		'name' => __('Show Pinterest Icon'),
		'id' => 'pinterest_show',
		"std" => "1",
		'type' => 'checkbox');
		
	$options[] = array(
		'name' => __('Pinterest url'),
		'desc' => __('Complete Pinterest url here'),
		'id' => 'pinterest_url',
		'std' => 'http://pinterest.com/',
		'class' => 'hidden',
		'type' => 'text');

	$options[] = array(
		'name' => __('Show Soundcloud Icon'),
		'id' => 'soundcloud_show',
		"std" => "1",
		'type' => 'checkbox');
		
	$options[] = array(
		'name' => __('Soundcloud url'),
		'desc' => __('Complete Soundcloud url here'),
		'id' => 'soundcloud_url',
		'std' => 'http://soundcloud.com/',
		'class' => 'hidden',
		'type' => 'text');	

	$options[] = array(
		'name' => __('Show iTunes Icon'),
		'id' => 'itunes_show',
		"std" => "1",
		'type' => 'checkbox');
		
	$options[] = array(
		'name' => __('iTunes url'),
		'desc' => __('Complete iTunes url here'),
		'id' => 'itunes_url',
		'std' => 'http://itunes.apple.com/',
		'class' => 'hidden',
		'type' => 'text');

	$options[] = array(
		'name' => __('Show Last.fm Icon'),
		'id' => 'lastfm_show',
		"std" => "1",
		'type' => 'checkbox');
		
	$options[] = array(
		'name' => __('Last.fm url'),
		'desc' => __('Complete Last.fm url here'),
		'id' => 'lastfm_url',
		'std' => 'http://last.fm/',
		'class' => 'hidden',
		'type' => 'text');

	$options[] = array(
		'name' => __('Show Vimeo Icon'),
		'id' => 'vimeo_show',
		"std" => "1",
		'type' => 'checkbox');
		
	$options[] = array(
		'name' => __('Vimeo url'),
		'desc' => __('Complete Vimeo url here'),
		'id' => 'vimeo_url',
		'std' => 'http://vimeo.com/',
		'class' => 'hidden',
		'type' => 'text');								
		
	$options[] = array(
		'name' => __('Show Tumblr Icon'),
		'id' => 'tumblr_show',
		"std" => "1",
		'type' => 'checkbox');
		
	$options[] = array(
		'name' => __('Tumblr url'),
		'desc' => __('Complete Tumblr url here'),
		'id' => 'tumblr_url',
		'std' => 'http://username.tumblr.com/',
		'class' => 'hidden',
		'type' => 'text');
		
	$options[] = array(
		'name' => __('Show Google + Icon'),
		'id' => 'googleplus_show',
		"std" => "1",
		'type' => 'checkbox');
		
	$options[] = array(
		'name' => __('Google + url'),
		'desc' => __('Complete Google + url here'),
		'id' => 'googleplus_url',
		'std' => 'https://plus.google.com/',
		'class' => 'hidden',
		'type' => 'text');																						
									
	return $options;
}

/* Turns off the default options panel from Twenty Eleven */
 
add_action('after_setup_theme','remove_twentyeleven_options', 100);

function remove_twentyeleven_options() {
	remove_action( 'admin_menu', 'twentyeleven_theme_options_add_page' );
}