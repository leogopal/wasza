<?php get_header(); ?>

	<div id="content" class="container">
		<div class="row">
			<div id="page" class="col-lg-9">
				<?php if ( function_exists('yoast_breadcrumb') ) {yoast_breadcrumb('<div id="breadcrumbs">','</div>');} ?>
				<h1>Search results: '<?php echo $s; ?>'</h1>

				<div class="productrow">
				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); $thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), full ); ?>
					<div class="product">
						<a href="<?php the_permalink(); ?>" class="productpic"><img src="<?php echo $thumbnail[0]; ?>" /></a>
						<div class="productinfo clearfix">
							<h3 class="pull-left"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
							<div class="productprice pull-right"><?php echo get_post_meta($post->ID, 'price', true); ?></div>
						</div>
					</div>
				<?php endwhile; endif; ?>
				</div>
				
			</div><!-- page -->

			<?php get_sidebar(); ?>
		</div>
	</div><!-- content -->
	
<?php get_footer(); ?>
