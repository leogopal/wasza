<?php get_header(); ?>

	<?php //get_template_part('includes/content/slider'); ?>
	
	<div id="content" class="container">
		<div class="row">
			<div id="page" class="col-lg-9">
				<h1 class="page-title">Error 404 - Page Not Found</h1>
				<p>Something seems to have gone wrong. Perhaps go back to the <a href="/">home page</a>, or use the search at the top of the page to find what you're after.</p>
				<p>If all else fails, please <a href="<?php echo get_permalink(12); ?>">contact us</a>.</p>
			</div><!-- page -->

			<?php get_sidebar(); ?>
		</div>
	</div><!-- content -->
	
<?php get_footer(); ?>
