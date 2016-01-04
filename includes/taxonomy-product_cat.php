<?php get_header(); ?>

	<div id="content" class="container">
		<div class="row">
			<div id="page" class="col-lg-9">
				<?php if ( function_exists('yoast_breadcrumb') ) { yoast_breadcrumb('<div id="breadcrumbs">','</div>'); } ?>
				<h1><?php echo single_cat_title(); ?></h1>

				<div class="row">
				<?php $i = 0; ?>
				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); 
				$thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' ); ?>
					<div class="product col-lg-4 col-md-6 col-xs-12">
						<div class="col-inner">
							<a href="<?php the_permalink(); ?>" class="productpic"><img src="<?php echo $thumbnail[0]; ?>" /></a>
							<div class="productinfo clearfix">
								<h3 class="pull-left"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
								<a class="productview btn btn-view" href="<?php the_permalink(); ?>">View &#8594;</a>
							</div>
						</div>
					</div>

				<?php 
				$i++;
				if ($i % 3 == 0) {
					?>
						</div><div class="row">
					<?php

				} 
				endwhile; endif; ?>
				
				</div>
				<div class="productpagination row">
					<?php nmpza_pagination(); ?>
				</div>
			</div><!-- page -->

			<?php get_sidebar(); ?>
		</div>
	</div><!-- content -->
	
<?php get_footer(); ?>
