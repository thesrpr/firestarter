<?php

//Galleries
remove_shortcode('gallery', 'gallery_shortcode');
add_shortcode('gallery', 'thesrpr_gallery_shortcode');

function thesrpr_gallery_shortcode($attr) {
	$post = get_post();

	static $instance = 0;
	$instance++;

	if ( ! empty( $attr['ids'] ) ) {
		if ( empty( $attr['orderby'] ) )
			$attr['orderby'] = 'post__in';
		$attr['include'] = $attr['ids'];
	}

	$output = apply_filters('post_gallery', '', $attr);
	if ( $output != '' )
		return $output;

	if ( isset( $attr['orderby'] ) ) {
		$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
		if ( !$attr['orderby'] )
			unset( $attr['orderby'] );
	}

	extract(shortcode_atts(array(
		'order'      => 'ASC',
		'orderby'    => 'menu_order ID',
		'id'         => $post->ID,
		'itemtag'    => 'li',
		'columns'    => 3,
		'size'       => 'medium',
		'include'    => '',
		'exclude'    => ''
	), $attr));

	$id = intval($id);
	if ( 'RAND' == $order )
		$orderby = 'none';

	if ( !empty($include) ) {
		$_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );

		$attachments = array();
		foreach ( $_attachments as $key => $val ) {
			$attachments[$val->ID] = $_attachments[$key];
		}
	} elseif ( !empty($exclude) ) {
		$attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
	} else {
		$attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
	}

	if ( empty($attachments) )
		return '';

	if ( is_feed() ) {
		$output = "\n";
		foreach ( $attachments as $att_id => $attachment )
			$output .= wp_get_attachment_link($att_id, $size, true) . "\n";
		return $output;
	}

	$itemtag = tag_escape($itemtag);

	$selector = "gallery-{$instance}";
			
	$output = "<ul id='$selector' class='gallery small-block-grid-2 large-block-grid-{$columns}'>";

	$i = 0;
	foreach ( $attachments as $id => $attachment ) {
		$img = wp_get_attachment_image_src( $id, $size );
		$link =  wp_get_attachment_url( $id );
		$title=   get_the_title($id);

		$output .= "<{$itemtag}>";
		$output .= "<a href='$link' rel='swipebox' title='@$title'><img src='$img[0]'/></a>";
		$output .= "</{$itemtag}>";
	}

	$output .= "</ul>\n";

	return $output;
}	

// Buttons
function foundation_buttons( $atts, $content = null ) {
	extract( shortcode_atts( array(
	'shape' => '', /* radius, round */
	'size' => 'medium', /* tiny, small, medium, large */
	'type' => '',
	'url'  => '',
	'text' => '', 
	), $atts ) );
	
	$output = '<a href="' . $url . '" class="button '. $shape . ' ' . $size . ' ' ;
	if( $type == 'secondary' ){ $output .= ' secondary';}
	if( $type == 'alert' ){ $output .= ' alert';}
	if( $type == 'success' ){ $output .= ' success';}
	$output .= '">';
	$output .= $text;
	$output .= '</a>';
	
	return $output;
}

add_shortcode('button', 'foundation_buttons'); 

// Alerts
function foundation_alerts( $atts, $content = null ) {
	extract( shortcode_atts( array(
	'type' => '	', /* alert, success, secondary */
	'text' => '', 
	), $atts ) );
	
	$output = '<div class="alert-box '. $type . '">';
	
	$output .= $text;
	$output .= '<a class="close" href="#">×</a></div>';
	
	return $output;
}

add_shortcode('alert', 'foundation_alerts');

// Labels
function foundation_labels( $atts, $content = null ) {
	extract( shortcode_atts( array(
	'type' => '	', /* alert, success, secondary */
	'shape' => '', /* radius, round */
	'text' => '', 
	), $atts ) );
	
	$output = '<span class="label '. $type . ''. $shape . '">';
	$output .= $text;
	$output .= '</span>';
	
	return $output;
}

add_shortcode('label', 'foundation_labels');

// Highlight
function foundation_highlight( $atts, $content = null ) {
	return '<span class="highlight">&nbsp;' . $content . '&nbsp;</span>';
}

add_shortcode('highlight', 'foundation_highlight');

// Blockquote
function foundation_quote( $atts, $content = null ) {
	extract( shortcode_atts( array('source' => ''), $atts ) );
	
	$output = '<blockquote>';
	$output .= $content;
	$output .= '<cite>'. $source . '</cite>';
	$output .= '</blockquote>';
	
	return $output;
}
add_shortcode('quote', 'foundation_quote');

// Panels
function foundation_panels( $atts, $content = null ) {
	extract( shortcode_atts( array(
	'type' => ' ', /* secondary */
	'shape' => '', /* radius */
	'text' => '', 
	), $atts ) );
	
	if( $type == 'secondary' ){ $output = '<div class="panel callout '.$shape.'">';} else { $output = '<div class="panel '.$shape.'">';}
	$output .= $text;
	$output .= '</div>';
	
	return $output;
}

add_shortcode('panel', 'foundation_panels');

// Video
function foundation_video( $atts, $content = null ) {
	extract( shortcode_atts( array(
	'size' => '', /* widescreen */
	'type' => '', /* video */
	), $atts ) );

	return '<section class="flex-video '. $size . ' '. $type . '">' .($content) . '</section>';
}
add_shortcode('video', 'foundation_video');

function foundation_spacer( $atts, $content = null ) {
		extract( shortcode_atts( array(
				'size' => 0
				), $atts ) );

		return '<div class="spacer" style="height:' . $size . 'em"></div>';
	}
add_shortcode( 'spacer', 'foundation_spacer' );

function foundation_row( $atts, $content = null ) {
   return '<section class="row">' . do_shortcode($content) . '</section>';
}
add_shortcode('row', 'foundation_row');

function foundation_one_half( $atts, $content = null ) {
   return '<section class="small-6 columns">' . do_shortcode($content) . '</section>';
}
add_shortcode('one_half', 'foundation_one_half');

function foundation_one_half_end( $atts, $content = null ) {
   return '<section class="small-6 columns end">' . do_shortcode($content) . '</section>';
}
add_shortcode('one_half_end', 'foundation_one_half_end');

function foundation_one_third( $atts, $content = null ) {
   return '<section class="small-4 columns">' . do_shortcode($content) . '</section>';
}
add_shortcode('one_third', 'foundation_one_third');

function foundation_one_third_end( $atts, $content = null ) {
   return '<section class="small-4 columns end">' . do_shortcode($content) . '</section>';
}
add_shortcode('one_third_end', 'foundation_one_third_end');

function foundation_two_third( $atts, $content = null ) {
   return '<section class="small-8 columns">' . do_shortcode($content) . '</section>';
}
add_shortcode('two_third', 'foundation_two_third');

function foundation_two_third_end( $atts, $content = null ) {
   return '<section class="small-8 columns end">' . do_shortcode($content) . '</section>';
}
add_shortcode('two_third_end', 'foundation_two_third_end');

function foundation_one_fourth( $atts, $content = null ) {
   return '<section class="smal-3 columns">' . do_shortcode($content) . '</section>';
}
add_shortcode('one_fourth', 'foundation_one_fourth');

function foundation_one_fourth_end( $atts, $content = null ) {
   return '<section class="smal-3 columns end">' . do_shortcode($content) . '</section>';
}
add_shortcode('one_fourth_end', 'foundation_one_fourth_end');

function foundation_three_fourth( $atts, $content = null ) {
   return '<section class="small-9 columns">' . do_shortcode($content) . '</section>';
}
add_shortcode('three_fourth', 'foundation_three_fourth');

function foundation_three_fourth_end( $atts, $content = null ) {
   return '<section class="smal-9 columns end">' . do_shortcode($content) . '</section>';
}
add_shortcode('three_fourth_end', 'foundation_three_fourth_end');

function foundation_one_sixth( $atts, $content = null ) {
   return '<section class="small-2 columns">' . do_shortcode($content) . '</section>';
}
add_shortcode('one_sixth', 'foundation_one_sixth');

function foundation_one_sixth_end( $atts, $content = null ) {
   return '<section class="small-2 columns end">' . do_shortcode($content) . '</section>';
}
add_shortcode('one_sixth_end', 'foundation_one_sixth_end');

function foundation_five_sixth( $atts, $content = null ) {
   return '<section class="small-10 columns">' . do_shortcode($content) . '</section>';
}
add_shortcode('five_sixth', 'foundation_five_sixth');

function foundation_five_sixth_end( $atts, $content = null ) {
   return '<section class="small-10 columns end">' . do_shortcode($content) . '</section>';
}
add_shortcode('five_sixth_end', 'foundation_five_sixth_end');

function foundation_center_three_fourth( $atts, $content = null ) {
   return '<section class="small-9 small-centered columns">' . do_shortcode($content) . '</section>';
}
add_shortcode('center_three_fourth', 'foundation_center_three_fourth');

function foundation_center_half( $atts, $content = null ) {
   return '<section class="small-6 small-centered columns">' . do_shortcode($content) . '</section>';
}
add_shortcode('center_half', 'foundation_center_half');

function foundation_center_third( $atts, $content = null ) {
   return '<section class="small-4 small-centered columns">' . do_shortcode($content) . '</section>';
}
add_shortcode('center_third', 'foundation_center_third');

function foundation_center_fourth( $atts, $content = null ) {
   return '<section class="small-9 small-centered columns">' . do_shortcode($content) . '</section>';
}
add_shortcode('center_fourth', 'foundation_center_fourth');

function foundation_block_grid( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'number' => '' /*number */
		), $atts ) );

   return '<ul class="small-block-grid-2 large-block-grid-'.$number.'>' . do_shortcode($content) . '</ul>';
}
add_shortcode('grid', 'foundation_block_grid');

function foundation_block_grid_item( $atts, $content = null ) {

   return '<li>' . do_shortcode($content) . '</li>';
}
add_shortcode('grid-item', 'foundation_block_grid_item');

function foundation_column_formatter($content) {
	$new_content = '';

	/* Matches the contents and the open and closing tags */
	$pattern_full = '{(\[raw\].*?\[/raw\])}is';

	/* Matches just the contents */
	$pattern_contents = '{\[raw\](.*?)\[/raw\]}is';

	/* sectionide content into pieces */
	$pieces = preg_split($pattern_full, $content, -1, PREG_SPLIT_DELIM_CAPTURE);

	/* Loop over pieces */
	foreach ($pieces as $piece) {
		/* Look for presence of the shortcode */
		if (preg_match($pattern_contents, $piece, $matches)) {

			/* Append to content (no formatting) */
			$new_content .= $matches[1];
		} else {

			/* Format and append to content */
			$new_content .= wptexturize(wpautop($piece));
		}
	}

	return $new_content;
}

// Remove the 2 main auto-formatters
remove_filter('the_content', 'wpautop');
remove_filter('the_content', 'wptexturize');

// Before displaying for viewing, apply this function
add_filter('the_content', 'foundation_column_formatter', 99);
add_filter('widget_text', 'foundation_column_formatter', 99);


?>