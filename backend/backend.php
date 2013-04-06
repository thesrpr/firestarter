<?php

/* Theme Options */
if ( is_admin() ) {
    $of_page= 'appearance_page_options-framework';
    add_action( "admin_print_scripts-$of_page", 'optionsframework_custom_js', 0 );
}
function optionsframework_custom_js () {
     wp_enqueue_script( 'optionsframework_custom_js', get_bloginfo('template_directory') .'/js/optionsframework_custom.js', array( 'jquery') );
}

/* Custom Metaboxes */
add_filter( 'cmb_meta_boxes', 'cmb_thesrpr_metaboxes' );
function cmb_thesrpr_metaboxes( array $meta_boxes ) {

  $prefix = '_cmb_';
  $meta_boxes[] = array(
    'id'         => 'contact_options',
    'title'      => 'Contact Form Options',
    'pages'      => array( 'page' ),
    'show_on' => array( 'key' => 'page-template', 'value' => 'contact.php' ),
    'context'    => 'normal',
    'priority'   => 'high',
    'show_names' => true, 
    'fields'     => array(  
      array(
        'name' => 'Management Email',
        'desc' => 'Enter address for management contact',
        'id'   => $prefix . 'mgmt_contact',
        'type' => 'text_medium',
      ),
      array(
        'name' => 'Booking Email',
        'desc' => 'Enter address for booking contact',
        'id'   => $prefix . 'booking_contact',
        'type' => 'text_medium',
      ),
      array(
        'name' => 'Press Email',
        'desc' => 'Enter address for press contact',
        'id'   => $prefix . 'press_contact',
        'type' => 'text_medium',
      ),
      array(
        'name' => 'Web/Technical Email',
        'desc' => 'Enter address for technical contact',
        'id'   => $prefix . 'web_contact',
        'type' => 'text_medium',
      ),            
    ),
  );  
  
  return $meta_boxes;
}

add_action( 'init', 'cmb_initialize_cmb_meta_boxes', 9999 );
function cmb_initialize_cmb_meta_boxes() {

  if ( ! class_exists( 'cmb_Meta_Box' ) )
    require_once 'metaboxes/init.php';

}

/* Adds an archive checkbox to the nav menu meta box for Custom Post Types that support archives */
class cptArchiveNavMenu {
  public function __construct() {
    add_action( 'admin_head-nav-menus.php', array( $this, 'add_filters' ) );
  }

  public function add_filters() {
    $post_type_args = array(
      'show_in_nav_menus' => true
    );

    $post_types = get_post_types( $post_type_args, 'object' );

    foreach ( $post_types as $post_type ) {
      if ( $post_type->has_archive ) {
        add_filter( 'nav_menu_items_' . $post_type->name, array( $this, 'add_archive_checkbox' ), null, 3 );
      }
    }
  }

  public function add_archive_checkbox( $posts, $args, $post_type ) {
    global $_nav_menu_placeholder, $wp_rewrite;
    $_nav_menu_placeholder = ( 0 > $_nav_menu_placeholder ) ? intval($_nav_menu_placeholder) - 1 : -1;
    $archive_slug = $post_type['args']->has_archive === true ? $post_type['args']->rewrite['slug'] : $post_type['args']->has_archive;
    if ( $post_type['args']->rewrite['with_front'] )
      $archive_slug = substr( $wp_rewrite->front, 1 ) . $archive_slug;
    else
      $archive_slug = $wp_rewrite->root . $archive_slug;

    array_unshift( $posts, (object) array(
      'ID' => 0,
      'object_id' => $_nav_menu_placeholder,
      'post_content' => '',
      'post_excerpt' => '',
      'post_title' => $post_type['args']->labels->all_items,
      'post_type' => 'nav_menu_item',
      'type' => 'custom',
      'url' => site_url( $archive_slug ),
    ) );

    return $posts;
  }
}

$cptArchiveNavMenu = new cptArchiveNavMenu(); 

/* Add all custom post types to the "Right Now" box on the Dashboard */
add_action( 'right_now_all_content' , 'right_now_all_content' );

function right_now_all_content() {
  $args = array(
    'public' => true ,
    '_builtin' => false
  );
  $output = 'object';
  $operator = 'and';

  $post_types = get_post_types( $args , $output , $operator );

  foreach( $post_types as $post_type ) {
    $num_posts = wp_count_posts( $post_type->name );
    $num = number_format_i18n( $num_posts->publish );
    $text = _n( $post_type->labels->singular_name, $post_type->labels->name , intval( $num_posts->publish ) );
    if ( current_user_can( 'edit_posts' ) ) {
      $num = "<a href='edit.php?post_type=$post_type->name'>$num</a>";
      $text = "<a href='edit.php?post_type=$post_type->name'>$text</a>";
    }
    echo '<tr><td class="first b b-' . $post_type->name . '">' . $num . '</td>';
    echo '<td class="t ' . $post_type->name . '">' . $text . '</td></tr>';
  }
} 

/* Automatically close missing tags from the WYSIWYG editor */
 function clean_bad_content($bPrint = false) {
 global $post;
 $szPostContent  = $post->post_content;
 $szRemoveFilter = array("~<p[^>]*>\s?</p>~", "~<a[^>]*>\s?</a>~", "~<font[^>]*>~", "~<\/font>~", "~style\=\"[^\"]*\"~", "~<span[^>]*>\s?</span>~");
 $szPostContent  = preg_replace($szRemoveFilter, '', $szPostContent);
 $szPostContent  = apply_filters('the_content', $szPostContent);
 if ($bPrint == false) return $szPostContent; 
 else echo $szPostContent;
} 

/*Only show posts than belong to author
function mypo_parse_query_useronly( $wp_query ) {
    if ( strpos( $_SERVER[ 'REQUEST_URI' ], '/wp-admin/edit.php' ) !== false ) {
        if ( !current_user_can( 'edit_others_posts' ) ) {
            global $current_user;
            $wp_query->set( 'author', $current_user->id );
        }
    }
}
add_filter('parse_query', 'mypo_parse_query_useronly' );
*/

/* Shortcodes Widget */

// Function that outputs the contents of the dashboard widget
function thesrpr_theme_dashboard_instructions() {?>
  <h2>Columns</h2>
  <p>Rememeber that the columns need to add up to twelve.  If you are having weirdness try wrapping the columns in<br/> [row][/row]</p>
  <p>[one_half]6 columns[/one_half]</p>
  <p>[one_third]4 columns[/one_third]</p>
  <p>[one_fourth]3 columns[/one_fourth]</p>
  <p>[one_sixth]2 columns[/one_sixth]</p>
  <p>[five_sixth]10 columns[/five_sixth]</p>
  <h2>Centered Columns</h2>
  <p>Already have the row wrap</p>
  <p>[center_three_fourth]9 columns centered[/center_three_fourth]</p>
  <p>[center_half]6 columns centered[/center_half]</p>
  <p>[center_third]4 columns centered[/center_third]</p>
  <p>[center_fourth]3 columns centered[/center_fourth]</p>
   <h2>Block Grid</h2>
   <p>Works very similar to the gallery</p>
   <p>[grid columns="number"][list-item]stuff[/list-item][/grid]</p>
   <h2>Video</h2>
   <p>[video type="'',vimeo" size="'',widescreen"]embed code[/video]</p>
   <h2>Buttons</h2>
   <p>[button url=" " size="'', tiny, small, large" type="'', secondary, alert, success", shape="'', radius, round"]<br/>button text[/button]</p>
   <h2>Alerts</h2>
   <p>[alert type="blank, secondary, success, alert"]stuff[/alert]</p>
  <h5>You can reference the Foundation Docs to figure out most of the terminology <a href="http://foundation.zurb.com/old-docs/f3/">here</a>
<?php }

// Function used in the action hook
function thesrpr_add_dashboard_widgets() {
  wp_add_dashboard_widget(1906, 'Shortcodes', 'thesrpr_theme_dashboard_instructions');
}

// Register the new dashboard widget with the 'wp_dashboard_setup' action
add_action('wp_dashboard_setup', 'thesrpr_add_dashboard_widgets' );


?>