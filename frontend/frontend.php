<?php 

/**
 * Function Aqua Resizer
 * Courtesy of Syamil MJ https://github.com/sy4mil/Aqua-Resizer
 */
function aq_resize( $url, $width, $height = null, $crop = null, $single = true ) {
  
  //validate inputs
  if(!$url OR !$width ) return false;
  
  //define upload path & dir
  $upload_info = wp_upload_dir();
  $upload_dir = $upload_info['basedir'];
  $upload_url = $upload_info['baseurl'];
  
  //check if $img_url is local
  if(strpos( $url, home_url() ) === false) return false;
  
  //define path of image
  $rel_path = str_replace( $upload_url, '', $url);
  $img_path = $upload_dir . $rel_path;
  
  //check if img path exists, and is an image indeed
  if( !file_exists($img_path) OR !getimagesize($img_path) ) return false;
  
  //get image info
  $info = pathinfo($img_path);
  $ext = $info['extension'];
  list($orig_w,$orig_h) = getimagesize($img_path);
  
  //get image size after cropping
  $dims = image_resize_dimensions($orig_w, $orig_h, $width, $height, $crop);
  $dst_w = $dims[4];
  $dst_h = $dims[5];
  
  //use this to check if cropped image already exists, so we can return that instead
  $suffix = "{$dst_w}x{$dst_h}";
  $dst_rel_path = str_replace( '.'.$ext, '', $rel_path);
  $destfilename = "{$upload_dir}{$dst_rel_path}-{$suffix}.{$ext}";
  
  //if orig size is smaller
  if($width >= $orig_w) {
    
    if(!$dst_h) :
      //can't resize, so return original url
      $img_url = $url;
      $dst_w = $orig_w;
      $dst_h = $orig_h;
      
    else :
      //else check if cache exists
      if(file_exists($destfilename) && getimagesize($destfilename)) {
        $img_url = "{$upload_url}{$dst_rel_path}-{$suffix}.{$ext}";
      } 
      //else resize and return the new resized image url
      else {
        $resized_img_path = image_resize( $img_path, $width, $height, $crop );
        $resized_rel_path = str_replace( $upload_dir, '', $resized_img_path);
        $img_url = $upload_url . $resized_rel_path;
      }
      
    endif;
    
  }
  //else check if cache exists
  elseif(file_exists($destfilename) && getimagesize($destfilename)) {
    $img_url = "{$upload_url}{$dst_rel_path}-{$suffix}.{$ext}";
  } 
  //else, we resize the image and return the new resized image url
  else {
    $resized_img_path = image_resize( $img_path, $width, $height, $crop );
    $resized_rel_path = str_replace( $upload_dir, '', $resized_img_path);
    $img_url = $upload_url . $resized_rel_path;
  }
  
  //return the output
  if(!$single) {
    //array return
    $image = array (
      'url' => $img_url,
      'width' => $dst_w,
      'height' => $dst_h
    );
    
  } else {
    //str return
    $image = $img_url;
  }
  
  return $image;
}

/*** Responsive Image **/
function responsive_featured_image() {
	global $post; 
	$thumb = get_post_thumbnail_id();
	$img_url = wp_get_attachment_url( $thumb,'full' ); 
	$small_image = aq_resize( $img_url, 400, 300, false );
	$medium_image = aq_resize( $img_url, 800, 600, false );
	$large_image = aq_resize( $img_url, 1200, 800, false );
	$title = get_the_title($thumb); 
	

	 echo '<div class="featured-image" data-picture data-alt="'.$title.'">';
       echo '<div data-src="'.$small_image.'"></div>';
        echo '<div data-src="'.$medium_image.'" data-media="(min-width: 600px)"></div>';
        echo '<div data-src="'.$large_image.'" data-media="(min-width: 1200px)"></div>';

        echo '<noscript>';
            echo '<img src="'.$small_image.'" alt="'.$title.'">';
       echo '</noscript>';
    echo '</div>';
}

//shortcodes
include_once('shortcodes.php');

//Foundation Top Bar
function foundation_top_bar($location) {
    wp_nav_menu(array( 
        'container' => false,                           // remove nav container
        'container_class' => 'menu',           		// class of container
        'menu_id' => 'primary',                      	        // menu name
        'menu_class' => $location,         	// adding custom nav class
        'theme_location' => 'primary',                // where it's located in the theme
        'depth' => 5,                                   // limit the depth of the nav
    	'fallback_cb' => false,                         // fallback function (see below)
        'walker' => new top_bar_walker()
	));
}

class top_bar_walker extends Walker_Nav_Menu {
 
    function display_element($element, &$children_elements, $max_depth, $depth=0, $args, &$output) {
        $element->has_children = !empty($children_elements[$element->ID]);
        $element->classes[] = ($element->current || $element->current_item_ancestor) ? 'active' : '';
        $element->classes[] = ($element->has_children) ? 'has-dropdown' : '';
		
        parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
    }
	
    function start_el(&$output, $item, $depth, $args) {
        $item_html = '';
        parent::start_el($item_html, $item, $depth, $args);	
				
        $classes = empty($item->classes) ? array() : (array) $item->classes;	
		
        if(in_array('section', $classes)) {
            $output .= '<li class="divider"></li>';
            $item_html = preg_replace('/<a[^>]*>(.*)<\/a>/iU', '<label>$1</label>', $item_html);
        }
		
        $output .= $item_html;
    }
	
    function start_lvl(&$output, $depth = 0, $args = array()) {
        $output .= "\n<ul class=\"dropdown\">\n";
    }
    
}

/* Nav Menu */

//Deletes all CSS classes and id's, except for those listed in the array below
function thesrpr_custom_wp_nav_menu($var) {
        return is_array($var) ? array_intersect($var, array(
                //List of allowed menu classes
                'current_page_item',
                'current_page_parent',
                'current_page_ancestor',
                'first',
                'last',
                'vertical',
                'horizontal',
                'name'
                )
        ) : '';
}
add_filter('nav_menu_css_class', 'thesrpr_custom_wp_nav_menu');
add_filter('nav_menu_item_id', 'thesrpr_custom_wp_nav_menu');
add_filter('page_css_class', 'thesrpr_custom_wp_nav_menu');
 
//Replaces "current-menu-item" with "active"
function thesrpr_current_to_active($text){
        $replace = array(
                //List of menu item classes that should be changed to "active"
                'current_page_item' => 'active',
                'current_page_parent' => 'active',
                'current_page_ancestor' => 'active',
        );
        $text = str_replace(array_keys($replace), $replace, $text);
                return $text;
        }
add_filter ('wp_nav_menu','thesrpr_current_to_active');
 
//Deletes empty classes and removes the sub menu class
function thesrpr_strip_empty_classes($menu) {
    $menu = preg_replace('/ class=""| class="sub-menu"/','',$menu);
    return $menu;
}
add_filter ('wp_nav_menu','thesrpr_strip_empty_classes');

/* Pagination */
function foundation_pagination($pages = '', $range = 2)
{  
     $showitems = ($range * 2)+1;  

     global $paged;
     if(empty($paged)) $paged = 1;

     if($pages == '')
     {
         global $wp_query;
         $pages = $wp_query->max_num_pages;
         if(!$pages)
         {
             $pages = 1;
         }
     }   

     if(1 != $pages)
     {
         echo "<div class='pagination-centered'><ul class='pagination'>";
         if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='".get_pagenum_link(1)."'>&laquo;</a>";
         if($paged > 1 && $showitems < $pages) echo "<a href='".get_pagenum_link($paged - 1)."'>&lsaquo;</a>";

         for ($i=1; $i <= $pages; $i++)
         {
             if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
             {
                 echo ($paged == $i)? "<li class='current'><a href=''>".$i."</a></li>":"<li><a href='".get_pagenum_link($i)."' >".$i."</a></li>";
             }
         }

         if ($paged < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($paged + 1)."'>&rsaquo;</a>";  
         if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($pages)."'>&raquo;</a>";
         echo "</ul></div>\n";
     }
}

/* add Swipebox to post images */
function thesrpr_swipebox_rel($content) {
  $pattern = '/<a(.*?)href="(.*?).(bmp|gif|jpeg|jpg|png)"(.*?)>/i';
    $replacement = '<a$1href="$2.$3" rel=\'swipebox\'$4>';
  $content = preg_replace( $pattern, $replacement, $content );
  return $content;
}
add_filter( 'the_content', 'thesrpr_swipebox_rel' );

/* Stop images getting wrapped up in p tags when they get dumped out with the_content() for easier theme styling */
function thesrpr_remove_img_ptags($content){
  return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
}
add_filter('the_content', 'thesrpr_remove_img_ptags');

/* post header meta */
  function thesrpr_pre_meta() {
    printf(__('<p>Posted by <a href="%s" rel="author">%s</a> on <a href="%s"><time datetime="%s">%s</time></a></p>'),
      get_author_posts_url(get_the_author_meta('ID')),
      get_the_author(),
      get_month_link(get_the_time('Y'), get_the_time('m')),
      get_the_time('c'),
      get_the_time('F j Y')
    );
  }

/* post footer meta */
	//post nav
	function thesrpr_post_nav() {?>
		<section class="post_nav">
			<?php if (get_adjacent_post(false, '', true)): // if there are older posts ?>
    			<section class="left">
					<i class="icon-double-angle-left"></i>&nbsp;<?php previous_post_link( '%link','Previous Post' ); ?>
				</section>
			<?php endif; ?>
			<?php if (get_adjacent_post(false, '', false)): // if there are newer posts ?>
				<section class="right">
					<?php next_post_link('%link', 'Next Post' ); ?>&nbsp;<i class="icon-double-angle-right"></i>
				</section>
			<?php endif; ?>
		</section>
	<?php }

  // checks if the post has any tag's. if true: post the tags with foundation labels
    function thesrpr_post_tags($before = null, $after = null) {
      if (has_tag()) {
        echo '<section class="post-tags">';
        // Translators: Only translate "Tags:"
        the_tags(__('Tags: '));
        echo '</section>';
      }
    }

  // Prints the categories
    function thesrpr_post_categories() {
      // Translators: used between list items, there is a space after the comma.
      $categories_list = get_the_category_list(__(', '));
      $utility_text = __('Posted in %s %s');
      echo '<section class="post-categories">';

      printf($utility_text, $categories_list,'');

      echo '</section>';
    }

  //show the comment count (if comments is enabled).
    function thesrpr_post_comments() {
    if (comments_open()) {
      // get the number of comments
      $num_comment = get_comments_number();

      if ($num_comment == 0) {
        $comment = __('Leave a response');
      } else {
        $comment = sprintf(_n('one response', '%s responses', $num_comment, 'thesrpr'), $num_comment);  
      }
      // add the permalink + #respond anchor so it directs the user to the form
      $comment = '<a href="'.get_permalink().'#respond">'.$comment.'</a>';
    }
    else {
      $comment = __('Comments are locked for this post', 'thesrpr');
    }

    echo '<section class="post-comments">';

    printf($comment);

    echo '</section>';
  } 


 /* password protected post form */
add_filter( 'the_password_form', 'thesrpr_custom_password_form' );

function thesrpr_custom_password_form() {
  global $post;
  $label = 'pwbox-'.( empty( $post->ID ) ? rand() : $post->ID );
  $o = '<div class="clearfix"><form action="' . get_option('siteurl') . '/wp-login.php?action=postpass" method="post">
  ' . __( "This post is password protected. To view it please enter your password below:", "thesrpr" ) . '
  <div class="row collapse">
        <div class="small-2 columns"><label class="right inline" for="' . $label . '">' . __( "Password:", "thesrpr" ) . ' </label></div>
        <div class="small-8 columns">
            <input name="post_password" id="' . $label . '" type="password" size="20" class="input-text" />
        </div>
        <div class="small-2 columns">
            <input type="submit" name="Submit" class="postfix button expand" value="' . esc_attr__( "Submit", "thesrpr" ) . '" />
        </div>
  </div>
    </form></div>';
  return $o;
}


/* Comments */
function foundation_comments($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; ?>
    <li id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
        <section class="row">
        	<header class="comment-author">
            	<section class="small-3 columns">
	            	<?php echo get_avatar($comment,$size='125',$default='<path_to_url>' ); ?>
            	</section>
            	<section class="small-9 columns">
	            	<time datetime="<?php echo comment_time('Y-m-j'); ?>">
	            		<i class="icon-calendar"></i>
	            		<a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>">
		            	<?php comment_time('F jS, Y'); ?> </a>
		            </time>
		            <?php edit_comment_link(__('Edit'),'<span><i class="icon-edit"></i>', '</span>'); ?>
		            <?php printf(__('<h4>%s</h4>'), get_comment_author_link()) ?>
            	</section>
        	</header>
        	<section class="small-10 columns">
            	<?php if ($comment->comment_approved == '0') : ?>
                  <div class="alert-box success"><?php _e('Your comment is awaiting moderation.', 'thesrpr') ?></div>
				    <?php endif; ?>
				    <?php comment_text() ?>
          </section>
          <section class="small-2 columns">
                <i class="icon-comment"></i>
                <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
        	</section>
        </section><!-- row -->
    </li>
<?php }

?>