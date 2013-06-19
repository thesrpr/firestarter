<?php 
// Laying out elements to match the foundation styling
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
	            		<i class="icon-calendar"></i><?php comment_time('F jS, Y'); ?> 
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
          <section class="large-3 columns">
                <i class="icon-comment"></i>
                <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
        	</section>
        </section><!-- row -->
    </li>
<?php }