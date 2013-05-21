<?php
/*
Template Name: Blog Template
*/
?>
<?php get_header();?>
<section class="row">	
	<section id="content" class="multiposts">	
		<section class="eight columns">
			<?php 
				$paged = get_query_var('paged') ? get_query_var('paged') : 1; 
				$query = new WP_Query( array('post_type' => 'post', 'paged' => $paged )); 
				$multi_layout = of_get_option('layout_images', '' ); 
			?>	
			<ul class="block-grid <?php if ($multi_layout == "three columns") {echo "four-up";} else if ($multi_layout == "six columns") {echo "two-up";} else if ($multi_layout == "four columns") {echo "three-up";} else {echo "one-up";}?>">
			<?php if ($query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post(); ?>
				<li id="post-<?php the_ID(); ?>" <?php post_class(); ?>>	
					<section class="post_format"><?php get_template_part('post', 'format');?></section>
					<section class="post_content">	
						<?php 
							$thumb = get_post_thumbnail_id(); 
							$img_url = wp_get_attachment_url( $thumb,'full' );
							$image = aq_resize( $img_url, 600, 400, false); 
						?>
						<?php if ( has_post_thumbnail() ) {?>
							<a  class="th" href="<?php the_permalink();?>"><img src="<?php echo($image);?>"/></a>
						<?php } ?>
						<a href="<?php the_permalink();?>"><?php the_title('<h3 class="post_title">','</h3>');?></a>
						<?php the_excerpt();?>
						<center>
							<a href="<?php the_permalink();?>" class="secondary button"><i class="icon-link"></i>More</a>
						</center>
					</section>
				</li>
				<?php endwhile; else : get_404_template(); endif; ?>
			</ul>
			<?php echo foundation_pagination($query->max_num_pages);?>
		</section>
		<section class="four columns"><?php get_sidebar();?></section>	
	</section><!--  content -->	
</section><!--  row -->					
<?php get_footer();?>
	