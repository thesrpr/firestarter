<!DOCTYPE html>
<!--[if IE 8]> <html class="no-js lt-ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title><?php bloginfo('name'); ?> <?php wp_title('-',true); ?></title>
	
		
	<!-- wordpress head functions -->
		<?php if ( is_singular() && get_option( 'thread_comments' ) ) { wp_enqueue_script( 'comment-reply' ); } ?>
		<?php wp_head(); ?>
	<!-- end of wordpress head -->

	<!-- theme options info -->

		
</head>
<body <?php body_class();?>>
<div class="sticky">
	<nav class="top-bar">
		<ul class="title-area">
			<li class="name">
				<h1><a href="<?php echo esc_url(home_url()); ?>" title="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" rel="home"><?php bloginfo('name'); ?></a></h1>
			</li>
			<li class="toggle-topbar menu-icon"><a href="#"><span><?php _e('Menu', 'thesrpr'); ?></span></a></li>
		</ul>
		<section class="top-bar-section">
			<?php foundation_top_bar('right');?>
		</section>
	</nav>
</div>