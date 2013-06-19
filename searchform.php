<form id="searchform" action="<?php echo home_url('/'); ?>" method="get" role="search">
	<section class="row collapse">
		<section class="small-8 columns">
			<input type="text" id="search" placeholder="Search" name="s" value="<?php the_search_query(); ?>" />
		</section>
		<section class="small-4 columns">
			<button type="submit" id="search-button" class="postfix button radius"><i class="icon-search"></i></a>
		</section>
	</section>
</form>
