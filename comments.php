<!-- Begin Comments -->
<?php
// Do not delete these lines
    if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
        die (__('Please do not load this page directly. Thanks!', 'thesrpr'));

    if ( post_password_required() ) { ?>
    <section id="comments">
        <div class="alert-box alert">
            <p><?php _e('This post is password protected. Enter the password to view comments.', 'thesrpr'); ?></p>
        </div>
    </section>
    <?php
        return;
    }
?>

<?php // You can start editing here. Customize the respond form below ?>
<?php if ( have_comments() ) : ?>

    <?php $ping_count = $comment_count = 0;
    foreach ( $comments as $comment )
        get_comment_type() == "comment" ? ++$comment_count : ++$ping_count;
    ?>

    <section id="comments">
        <h3 class="subheader"><i class="icon-comments-alt"></i><?php printf( _n( 'One thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), 'thesrpr' ),
					number_format_i18n( get_comments_number() ), '<span>' . get_the_title() . '</span>' );?></h3>            
     
        <ol class="commentlist">
            <?php wp_list_comments('type=comment&callback=foundation_comments'); ?>
        </ol>   
        <footer>
            <nav id="comments-nav">
                <div class="comments-previous"><?php previous_comments_link( __( '&larr; Older comments', 'thesrpr' ) ); ?></div>
                <div class="comments-next"><?php next_comments_link( __( 'Newer comments &rarr;', 'thesrpr' ) ); ?></div>
            </nav>
        </footer>
    </section>
<?php else : // this is displayed if there are no comments so far ?>
    <?php if ( comments_open() ) : ?>
    <?php else : // comments are closed ?>
    <section id="comments">
        <div class="alert-box alert">
            <p class="bottom"><?php _e('Comments are closed.', 'thesrpr') ?></p>
        </div>
    </section>
    <?php endif; ?>
<?php endif; ?>
<?php if ( comments_open() ) : ?>


    <fieldset id="commentform">
        <legend>
        <h4 class="subheader">
            <i class="icon-comment-alt"></i><?php comment_form_title( __('Post a Comment', 'thesrpr'), __('Post a Reply to %s', 'thesrpr') ); ?>
        </h4>
        </legend>
                 
 
        <div id="cancel-comment-reply"><?php cancel_comment_reply_link() ?></div>
 
        <?php if ( get_option('comment_registration') && !$user_ID ) : ?>
            <p id="login-req"><?php printf(__('You must be <a href="%s" title="Sign in">Sign In</a> to post a comment.', 'thesrpr'),
            get_option('siteurl') . '/wp-login.php?redirect_to=' . get_permalink() ) ?></p>
         
        <?php else : ?>

            <div>   
 
                <form id="respond" action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post">
 
                    <?php if ( $user_ID ) : ?>
                        <p id="login">
                            <?php printf(__('<span>Signed in as <a href="%1$s" title="Logged in as %2$s">%2$s<i class="icon-user"></i></a></span> <span><a href="%3$s" title="Log out of this account"><i class="icon-logout"></i>Sign out?</a></span>', 'thesrpr'),
                            get_option('siteurl') . '/wp-admin/profile.php', esc_html($user_identity, true), wp_logout_url(get_permalink()) ) ?>
                        </p>
 
                    <?php else : ?>
 
                        <p id="comment-notes"><?php _e('Your email is <em>never</em> published nor shared.', 'thesrpr') ?> <?php if ($req) _e('Required fields are marked <i class="icon-asterisk"></i>', 'thesrpr') ?></p>
 
                        <div id="form-section-author" class="form-section">
                            <div class="form-label"><label for="author"><?php _e('Name') ?><?php if ($req) _e('<span class="required">*</span>', 'thesrpr') ?></label></div>
                            <div class="form-input"><input class="nice" id="author" name="author" type="text" value="<?php echo $comment_author ?>" size="30" maxlength="20" tabindex="3" /></div>
                        </div><!-- #form-section-author .form-section -->
 
                        <div id="form-section-email" class="form-section">
                            <div class="form-label"><label for="email"><?php _e('Email') ?><?php if ($req) _e('<span class="required">*</span>', 'thesrpr') ?></label></div>
                            <div class="form-input"><input id="email" name="email" type="text" value="<?php echo $comment_author_email ?>" size="30" maxlength="50" tabindex="4" /></div>
                        </div><!-- #form-section-email .form-section -->
 
                    <?php endif /* if ( $user_ID ) */ ?>
 
                    <div id="form-section-comment" class="form-section">
                        <div class="form-label"><label for="comment"><?php _e('Comment', 'thesrpr') ?></label></div>
                        <div class="form-textarea"><textarea id="comment" name="comment" cols="45" rows="8" tabindex="6"></textarea></div>
                    </div><!-- #form-section-comment .form-section -->
         
                    <div id="form-allowed-tags" class="form-section">
                        <p><span><?php _e('You may use these <abbr title="HyperText Markup Language">HTML</abbr> tags and attributes:', 'thesrpr') ?></span> <code><?php echo allowed_tags(); ?></code></p>
                    </div>
         
                    <?php do_action('comment_form', $post->ID); ?>
         
                    <div class="form-submit"><button class="secondary button" name="submit" tabindex="7"><i class="icon-check"></i><?php _e('Post Comment', 'thesrpr') ?></button><input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" /></div>
         
                    <?php comment_id_fields(); ?>  
 
 
                </form><!-- #commentform -->
                   
            </div><!-- .formcontainer -->
            <?php endif /* if ( get_option('comment_registration') && !$user_ID ) */ ?>
        </div><!-- #respond -->
    </fieldset>
<?php endif; // if you delete this the sky will fall on your head ?>