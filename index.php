<?php get_header(); ?>

	<?php 
	if ( function_exists( 'soliloquy' ) ) { soliloquy( 'homepage-slider', 'slug' ); }

	// get_template_part('includes/content/slider'); ?>
	
	<div id="content" class="container">
		<div class="row">
			<div id="page" class="col-lg-8">
				<?php if ( have_posts() ) : ?>

					<?php if ( is_home() && ! is_front_page() ) : ?>
						<header>
							<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
						</header>
						
					<?php endif; ?>

					<?php /* Start the Loop */ ?>
					<?php while ( have_posts() ) : the_post(); ?>
						<div class="thecontent"><?php the_content(); ?></div>
					<?php endwhile; ?>

					<?php the_posts_navigation(); ?>

					<?php else : ?>

						<?php  ?>

					<?php endif; ?>

			</div><!-- page -->

			<?php get_sidebar(); ?>
		</div>
	</div><!-- content -->
	
<?php get_footer(); ?>
