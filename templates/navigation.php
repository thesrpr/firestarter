<?php
/*
Template Name: Foundation Navigation
*/
?>

<?php get_header();?>
<section id="sitewrap" role="document">
	<section id="content" role="main">	
		<h2><?php single_post_title();?></h2>
		
		<h3>Horizontal Nav</h3>
		<div class="section-container horizontal-nav" data-section="horizontal-nav">
			<section class="section">
				<p class="title"><a href="#">Section 1</a></p>
				<div class="content">
					<ul class="side-nav">
						<li><a href="#">Link 1</a></li>
						<li><a href="#">Link 2</a></li>
						<li><a href="#">Link 3</a></li>
					</ul>
				</div>
			</section>
			<section class="section">
				<p class="title"><a href="#">Section 2</a></p>
				<div class="content">
					<ul class="side-nav">
						<li><a href="#">Link 1</a></li>
						<li><a href="#">Link 2</a></li>
						<li><a href="#">Link 3</a></li>
					</ul>
				</div>
			</section>
			<section class="section">
				<p class="title"><a href="#">Section 3</a></p>
				<div class="content">
					<ul class="side-nav">
						<li><a href="#">Link 1</a></li>
						<li><a href="#">Link 2</a></li>
						<li><a href="#">Link 3</a></li>
					</ul>
				</div>
			</section>
		</div>
		
		<h3>Vertical Nav</h3>
		<div class="row"><div class="large-6 columns">
			<div class="section-container vertical-nav" data-section="vertical-nav">
				<section class="section">
					<p class="title"><a href="#">Section 1</a></p>
					<div class="content">
						<ul class="side-nav">
							<li><a href="#">Link 1</a></li>
							<li><a href="#">Link 2</a></li>
							<li><a href="#">Link 3</a></li>
						</ul>
					</div>
				</section>
				<section class="section">
					<p class="title"><a href="#">Section 2</a></p>
					<div class="content">
						<ul class="side-nav">
							<li><a href="#">Link 1</a></li>
							<li><a href="#">Link 2</a></li>
							<li><a href="#">Link 3</a></li>
						</ul>
					</div>
				</section>
				<section class="section">
					<p class="title"><a href="#">Section 3</a></p>
					<div class="content">
						<ul class="side-nav">
							<li><a href="#">Link 1</a></li>
							<li><a href="#">Link 2</a></li>
							<li><a href="#">Link 3</a></li>
						</ul>
					</div>
				</section>
			</div>
		</div></div>
		
		<h3>Side Nav</h3>
		<ul class="side-nav">
			<li class="active"><a href="#">Link 1</a></li>
			<li><a href="#">Link 2</a></li>
			<li><a href="#">Link 3</a></li>
			<li><a href="#">Link 4</a></li>
		</ul>
		
		<h3>Sub Nav</h3>
		<dl class="sub-nav">
		  <dt>Filter:</dt>
		  <dd class="active"><a href="#">All</a></dd>
		  <dd><a href="#">Active</a></dd>
		  <dd><a href="#">Pending</a></dd>
		  <dd><a href="#">Suspended</a></dd>
		</dl>
	</section><!--  content -->	
<section role="complementary"><?php get_sidebar(); ?></section>
</section>
<?php get_footer();?>
