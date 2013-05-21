<?php if (is_home()) {?>
	<header>
		<a href="<?php the_permalink(); ?>"><?php the_title('<h2 class="entry-title">','</h2>'); ?></a>
		<section class="entry-meta"></section>
	</header>
	<section class="entry-content">
		<?php if ( has_post_thumbnail() ) {?>
			<a href="<?php the_permalink();?>"><?php echo responsive_featured_image(); ?></a>
		<?php } ?>
		<?php the_excerpt();  wp_link_pages(); ?>
	</section>
	<footer class="post-meta">
	</footer>

<?php } elseif (is_single()) {?>
	<header>
		<?php the_title('<h2 class="entry-title">','</h2>'); ?>
		<section class="entry-meta"></section>
	</header>
	<section class="entry-content">
		<?php the_content();  wp_link_pages(); ?>
	</section>
	<footer class="post-meta">
	</footer>
	<?php thesrpr_post_nav();?>
	<?php comments_template('',true);?>

<?php } elseif (is_page()) {?>
	<header>
		<?php the_title('<h2 class="entry-title">','</h2>'); ?>
	</header>
	<section class="entry-content">
		<?php the_content();  wp_link_pages(); ?>
	</section>
	
<?php } elseif (is_author() ) {?>
	<header>
		<a href="<?php the_permalink(); ?>"><?php the_title('<h2 class="entry-title">','</h2>'); ?></a>
		<section class="entry-meta"><?php the_time('F j Y'); ?></section>
	</header>
	<section class="entry-content">
		<?php the_content();  wp_link_pages(); ?>>
	</section>
	<footer class="post-meta">

	</footer>
	
<?php } else {?>
	<header>
		<a href="<?php the_permalink(); ?>"><?php the_title('<h2 class="entry-title">','</h2>'); ?></a>
		<section class="entry-meta"></section>
	</header>
	<section class="entry-content">
		<?php the_content();  wp_link_pages(); ?>
	</section>
	<footer class="post-meta">
	</footer>
<?php } ?>