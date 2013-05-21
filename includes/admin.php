<?php 
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