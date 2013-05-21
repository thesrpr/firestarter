<?php

/* Nav Menu */
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

// add home link to nav menu 
function home_page_menu_args( $args ) {
$args['show_home'] = true;
return $args;
}
add_filter( 'wp_page_menu_args', 'home_page_menu_args' );

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
/* post nav */
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