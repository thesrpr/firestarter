<?php
/*
Template Name: Foundation Sections
*/
?>

<?php get_header();?>
<section id="sitewrap" role="document">
	<section id="content" role="main">	
		<h2><?php single_post_title();?></h2>
		
		<h3>Mobile Accordion/Full Size Tabs</h3>
		<div class="section-container auto" data-section>
			<section class="section">
				<p class="title"><a href="#">Section 1</a></p>
				<div class="content"><p>Content of section 1.</p></div>
			</section>
			<section class="section">
				<p class="title"><a href=" #">Section 2</a></p>
				<div class="content"><p>Content of section 2.</p></div>
			</section>
		</div>
		
		<h3>Tabs</h3>
		<div class="section-container tabs" data-section="tabs">
			<section class="section">
				<p class="title"><a href="#">Section 1</a></p>
				<div class="content"><p>Content of section 1.</p></div>
			</section>
			<section class="section">
				<p class="title"><a href="#">Section 2</a></p>
				<div class="content"><p>Content of section 2.</p></div>
			</section>
		</div>
		
		<h3>Accordion</h3>
		<div  class="section-container accordion" data-section="accordion">
			<section class="section">
				<p class="title"><a href="#">Section 1</a></p>
				<div class="content"><p>Content of section 1.</p></div>
			</section>
			<section class="section">
				<p class="title"><a href="#">Section 2</a></p>
				<div class="content"><p>Content of section 2.</p></div>
			</section>
		</div>
	</section><!--  content -->	
	<section role="complementary"><?php get_sidebar(); ?></section>
</section>
<?php get_footer();?>
