<?php get_header(); 
$curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));
?>
<section id="sitewrap" role="document">
	<section id="content" role="main">	
		<header id="author">
			<section class="image"><?php echo get_avatar( ($curauth->ID), 200 );?></section>
			<section class="info">	
				<?php $nickname = $curauth->nickname; ?>
				<h1>
					<?php if ($nickname) { echo  $curauth->nickname; } else { echo $curauth->first_name . '&nbsp;' . $curauth->last_name; }; ?>
				</h1>
				<section class="small-8 small-centered columns">
					<dl>
				        <dt>Website:</dt>
				        <dd><a href="<?php echo $curauth->user_url; ?>"><?php echo $curauth->user_url; ?></a></dd>
				        <dt>Profile:</dt>
				        <dd><?php echo $curauth->user_description; ?></dd>
				    </dl>
				</section>
			</header>
		</section><!-- row -->
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
