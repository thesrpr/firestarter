<?php if  ( 'product' == get_post_type() ) {?>
<section id="store_sidebar">
	<center>
		<?php global $current_user; get_currentuserinfo(); ?>
		<?php if ( is_user_logged_in() ) { ?>
			<a href="#" id="accountbutton" data-dropdown="account-dropdown"><i class="icon-cog-alt icon-large"></i>
			<?php echo($current_user->user_firstname);?>'s <?php _e('Account', 'thesrpr')?></a>
			<ul id="account-dropdown" class="f-dropdown">
			 	<li>
					<a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" title="My Account"><i class="icon-user"></i><?php _e('My Account', 'thesrpr')?></a>
				</li>
				<li>
					<a href="<?php echo get_permalink( get_page_by_title( 'Track your order' ) ); ?>" title="Track"><i class="icon-truck"></i><?php _e('Track Order', 'thesrpr')?></a>
				</li>
				<li>
					<a href="<?php echo get_permalink( woocommerce_get_page_id('change_password') ); ?>" title="Change Password"><i class="icon-lock"></i><?php _e('Change Password', 'thesrpr')?></a>
				</li>
				<li>
					<a href="<?php echo wp_logout_url( home_url() ); ?>" title="Logout"><i class="icon-logout"></i><?php _e('Logout', 'thesrpr')?></a>
				</li>
			</ul>
		 <?php } ?>
	</center>	 
		<?php dynamic_sidebar('store');?>
</section>
<?php } else if ( is_single() || is_page_template( 'blog.php' ) ) {  dynamic_sidebar('blog'); } else if ( is_page() ) {
	
 dynamic_sidebar('pages'); } 	