<?php 

// add content width
if ( ! isset( $content_width ) ) $content_width = 1200;
 

/****** 
Register & Enqueue Styles & Scripts
*******/
 
function thesrpr_register_styles_scripts() {
if (!is_admin()) {
    global $is_IE;
    
    wp_enqueue_style('stylesheet', get_stylesheet_uri(),'','','all');

	wp_deregister_script('jquery');
	wp_enqueue_script('jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js');
	wp_enqueue_script('modernizr',  get_template_directory_uri().'/js/modernizr.custom.js');

	if ($is_IE) 
		{	wp_enqueue_script('html5shiv', "http://html5shiv.googlecode.com/svn/trunk/html5.js"); 
			wp_enqueue_script('selectivizr',  get_template_directory_uri().'/js/selectivizr-min.js', array('jquery'));
		}
	wp_enqueue_script('foundation', get_template_directory_uri().'/js/foundation.min.js', array('jquery'),'',true);
	wp_enqueue_script('picturefill', get_template_directory_uri().'/js/picturefill.min.js', array('jquery'),'',true);
	wp_enqueue_script('swipebox',  get_template_directory_uri().'/js/jquery.swipebox.min.js', array('jquery'), '', true);

	wp_enqueue_script('easing',  get_template_directory_uri().'/js/jquery.easing.min.js', array('jquery'), '', true);
	wp_enqueue_script('jquery-timing',  get_template_directory_uri().'/js/jquery-timing.min.js', array('jquery'), '', true);
	wp_enqueue_script('custom',  get_template_directory_uri().'/js/custom.js', array('jquery','foundation'),'', true);
	}
}
add_action('init', 'thesrpr_register_styles_scripts');

/* Global Includes */
include_once('includes/admin.php');
include_once('includes/foundation.php');
include_once('includes/images.php');
include_once('includes/metaboxes.php');
include_once('includes/navigation.php');
include_once('includes/shortcodes.php');

/* Theme Options */
if ( !function_exists( 'optionsframework_init' ) ) {
	define( 'OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/includes/options/' );
	require_once dirname( __FILE__ ) . '/includes/options/options-framework.php';
}

/* add theme support */
add_theme_support( 'post-thumbnails' );
add_theme_support( 'post-formats', array( 'status', 'gallery', 'audio', 'video', 'link', 'image', 'quote', 'chat' ) );

$args = array(
  'flex-width'    => true,
  'flex-height'    => true,
  'uploads'       => true,
);
add_theme_support( 'custom-header', $args );

$args = array(
  'default-color' => 'FFFFFF',
  'default-image' => get_template_directory_uri() . '/images/',
);
add_theme_support( 'custom-background', $args );

/* translation ready info */
load_theme_textdomain( 'thesrpr', TEMPLATEPATH.'/languages' );
 
$locale = get_locale();
$locale_file = TEMPLATEPATH."/languages/$locale.php";
if ( is_readable($locale_file) )
	require_once($locale_file);
	
/* Flush Rewrites */
add_action( 'after_switch_theme', 'thesrpr_flush_rewrite_rules' );
function thesrpr_flush_rewrite_rules() {
	// place custom post type functions here as well to flush permalinks
	flush_rewrite_rules();
}

/*******
Theme Specific Functions
*******/

/* login image link */
add_filter( 'login_headerurl', 'custom_login_header_url' );
function custom_login_header_url($url) {
  return 'http://yourwebsite.com';
}	
	
?>