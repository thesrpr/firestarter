<?php if (is_home()) {?>
	<header>
		<a href="<?php the_permalink(); ?>"><?php the_title('<h2 class="entry-title">','</h2>'); ?></a>
		<section class="entry-meta"><?php thesrpr_pre_meta();?></section>
	</header>
	<section class="entry-content">
		<?php if ( has_post_thumbnail() ) {?>
			<a href="<?php the_permalink();?>"><?php echo responsive_featured_image(); ?></a>
		<?php } ?>
		<?php the_excerpt(__("Continue...", "thesrpr"));  wp_link_pages(); ?>
	</section>
	<footer class="post-meta">
		<?php thesrpr_post_categories();?>
		<?php thesrpr_post_comments();?>
		<?php thesrpr_post_tags();?>
	</footer>

<?php } elseif (is_single()) {?>
	<header>
		<?php the_title('<h2 class="entry-title">','</h2>'); ?>
		<section class="entry-meta"><?php thesrpr_pre_meta();?></section>
	</header>
	<section class="entry-content">
		<?php the_content(__("Continue...", "thesrpr"));  wp_link_pages(); ?>
	</section>
	<footer class="post-meta">
		<?php thesrpr_post_categories();?>
		<?php thesrpr_post_tags();?>
	</footer>
	<?php thesrpr_post_nav();?>
	<?php comments_template('',true);?>

<?php } elseif (is_page()) {?>
	<header>
		<?php the_title('<h2 class="entry-title">','</h2>'); ?>
	</header>
	<section class="entry-content">
		<?php the_content(__("Continue...", "thesrpr"));  wp_link_pages(); ?>
	</section>
	
<?php } elseif (is_author() ) {?>
	<header>
		<a href="<?php the_permalink(); ?>"><?php the_title('<h2 class="entry-title">','</h2>'); ?></a>
		<section class="entry-meta"><?php the_time('F j Y'); ?></section>
	</header>
	<section class="entry-content">
		<?php the_content(__("Continue...", "thesrpr"));  wp_link_pages(); ?>>
	</section>
	<footer class="post-meta">
		<?php thesrpr_post_categories();?>
		<?php thesrpr_post_comments();?>
		<?php thesrpr_post_tags();?>
	</footer>
	
<?php } else {?>
	<header>
		<a href="<?php the_permalink(); ?>"><?php the_title('<h2 class="entry-title">','</h2>'); ?></a>
		<section class="entry-meta"><?php thesrpr_pre_meta();?></section>
	</header>
	<section class="entry-content">
		<?php the_content(__("Continue...", "thesrpr"));  wp_link_pages(); ?>
	</section>
	<footer class="post-meta">
		<?php thesrpr_post_categories();?>
		<?php thesrpr_post_comments();?>
		<?php thesrpr_post_tags();?>
	</footer>
<?php } ?>
	
