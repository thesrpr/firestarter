<?php get_header();?>
<section id="sitewrap" role="document">
	<section id="content" role="main">
		<h1 class="page_title text-center">
			<?php if ( is_search() ) : ?>
				<i class="icon-search"></i>
				<?php _e('Search Results for', 'thesrpr'); ?> "<?php echo get_search_query(); ?>"
			<?php elseif ( is_tax() ) : ?>
				<?php echo single_term_title( "", false ); ?>
			<?php endif; ?>
		</h1>
		
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>	
				<?php get_template_part('content', get_post_format()); ?>
			</article>
		<?php endwhile; else : get_404_template(); endif; ?>	
		<?php echo foundation_pagination();?>				
	</section><!--  content -->	
<section role="complementary"><?php get_sidebar(); ?></section>
</section>
<?php get_footer();?>
