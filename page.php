<?php get_header();?>
<section id="sitewrap" role="document">
	<section id="content" role="main">	
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>	
				<?php get_template_part('content', get_post_format()); ?>
			</article>
		<?php endwhile;  endif; ?>	
	</section><!--  content -->	
<section role="complementary"><?php get_sidebar(); ?></section>	
</section>
<?php get_footer();?>
