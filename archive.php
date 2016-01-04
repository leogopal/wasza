<?php get_header(); ?>

	<div id="content" class="container">
		<div class="row">
			<div id="page" class="col-lg-9">
				<?php if ( function_exists('yoast_breadcrumb') ) {yoast_breadcrumb('<div id="breadcrumbs">','</div>');} ?>

				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); $thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' ); ?>
					<div class="blogitem">
						<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
						<div class="blogpic"><img src="<?php echo $thumbnail[0]; ?>" alt="" /></div>
						<div class="thecontent"><?php the_excerpt(); ?></div>
						
						<div class="blogmeta">
							<a href="<?php the_permalink(); ?>" class="btn btn-primary">Read More</a>
							<span class="commentcount"><?php echo comments_number(); ?></span>
						</div>
					</div>
				<?php endwhile; endif; ?>
			</div><!-- page -->

			<?php get_sidebar(); ?>
		</div>
	</div><!-- content -->
	
<?php get_footer(); ?>
