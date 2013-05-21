<?php

/**
 * Title         : Aqua Resizer
 * Description   : Resizes WordPress images on the fly
 * Version       : 1.1.7
 * Author        : Syamil MJ
 * Author URI    : http://aquagraphite.com
 * License       : WTFPL - http://sam.zoy.org/wtfpl/
 * Documentation : https://github.com/sy4mil/Aqua-Resizer/
 *
 * @param string  $url    - (required) must be uploaded using wp media uploader
 * @param int     $width  - (required)
 * @param int     $height - (optional)
 * @param bool    $crop   - (optional) default to soft crop
 * @param bool    $single - (optional) returns an array if false
 * @uses  wp_upload_dir()
 * @uses  image_resize_dimensions() | image_resize()
 * @uses  wp_get_image_editor()
 *
 * @return str|array
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


function aq_upscale( $default, $orig_w, $orig_h, $dest_w, $dest_h, $crop ) {
	if ( ! $crop ) return null; // Let the wordpress default function handle this.

	// Here is the point we allow to use larger image size than the original one.
	$aspect_ratio = $orig_w / $orig_h;
	$new_w = $dest_w;
	$new_h = $dest_h;

	if ( ! $new_w ) {
		$new_w = intval( $new_h * $aspect_ratio );
	}

	if ( ! $new_h ) {
		$new_h = intval( $new_w / $aspect_ratio );
	}

	$size_ratio = max( $new_w / $orig_w, $new_h / $orig_h );

	$crop_w = round( $new_w / $size_ratio );
	$crop_h = round( $new_h / $size_ratio );

	$s_x = floor( ( $orig_w - $crop_w ) / 2 );
	$s_y = floor( ( $orig_h - $crop_h ) / 2 );

	return array( 0, 0, (int) $s_x, (int) $s_y, (int) $new_w, (int) $new_h, (int) $crop_w, (int) $crop_h );
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
