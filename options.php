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
	
	$options[] = array(
		"name" => __("Basic Settings"),
		"type" => "heading");
		
						
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
									
	return $options;
}