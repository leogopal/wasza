<?php get_header(); ?>

	<div id="content" class="container">
		<div class="row">
			<?php get_sidebar(); ?>
			
			<div id="page" class="col-lg-8">
				<?php if ( function_exists('yoast_breadcrumb') ) {yoast_breadcrumb('<div id="breadcrumbs">','</div>');} ?>

				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
					<h1><?php the_title(); ?></h1>
					<div class="thecontent"><?php the_content(); ?></div>
				<?php endwhile; endif; ?>
			</div><!-- page -->
		</div>
	</div><!-- content -->
	
<?php get_footer(); ?>
