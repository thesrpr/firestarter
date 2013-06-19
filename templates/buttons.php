<?php
/*
Template Name: Foundation Buttons
*/
?>

<?php get_header();?>
<section id="sitewrap" role="document">
	<section id="content" role="main">	
		<h2><?php single_post_title();?></h2>
		
		<h3>Button Group</h3>
		<ul class="button-group even-4">
			<li><a href="#" class="button">Button 1</a></li>
			<li><a href="#" class="button">Button 2</a></li>
			<li><a href="#" class="button">Button 3</a></li>
			<li><a href="#" class="button">Button 4</a></li>
		</ul>
		
		<h3>Button Bars</h3>
		<div class="button-bar">
			<ul class="button-group">
				<li><a href="#" class="small button">Button 1</a></li>
				<li><a href="#" class="small button">Button 2</a></li>
				<li><a href="#" class="small button">Button 3</a></li>
			</ul>
			<ul class="button-group">
				<li><a href="#" class="small button">Button 1</a></li>
				<li><a href="#" class="small button">Button 2</a></li>
				<li><a href="#" class="small button">Button 3</a></li>
			</ul>
		</div>
		
		<h3>Dropdowns</h3>
		<a href="#" class="secondary button split" data-dropdown="drop1">Has Dropdown<span></span></a>
		<a href="#" class="large secondary dropdown button" data-dropdown="drop2">Has Content Dropdown</a>
		
		<ul id="drop1" class="f-dropdown" data-dropdown-content>
			<li><a href="#">This is a link</a></li>
			<li><a href="#">This is another</a></li>
			<li><a href="#">Yet another</a></li>
		</ul>
		
		<ul id="drop2" class="f-dropdown large content" data-dropdown-content>
			<li><h4>Con los terriositas</h4></li>
			<li><a href="#"><img src="http://placehold.it/600x400"/></a></li>
		</ul>
	</section><!--  content -->	
<section role="complementary"><?php get_sidebar(); ?></section>
</section>
<?php get_footer();?>
