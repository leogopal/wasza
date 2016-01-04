<?php get_header(); ?>

	<div id="content" class="container">
		<div class="row">
			<div id="page">
				<?php if ( function_exists('yoast_breadcrumb') ) {
					yoast_breadcrumb('<div id="breadcrumbs">','</div>');
				} ?>

				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); 
				$thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' ); ?>
					
					
					<div class="row">
						
						<div class="productextras pull-right col-lg-6 col-md-12 col-xs-12">
							<div class="productpictures">
								<div class="svgpic">
									<div class="svgbackground"></div>
									<div class="svgbg">
										<img src="<?php if( get_field('blank_jpg') ) { the_field('blank_jpg'); } else { echo $thumbnail[0]; } ?>" />
									</div>
									<div class="thesvg">
										<a href="<?php echo $thumbnail[0]; ?>">
											<?php 
											if ( get_field('svg_file') ) {
												$url = wp_get_attachment_url(get_field('svg_file'));
												$uploads = wp_upload_dir();
												$file_path = str_replace( $uploads['baseurl'], $uploads['basedir'], $url );
												echo file_get_contents($file_path);
											}
											?>
										</a>
									</div>
								</div>
							</div><!-- product pictures -->

							<?php if ( get_field('svg_file') ) { ?>

							<div class="extras">
								<div class="productgallery">
									<?php get_template_part('woocommerce/single-product/product-thumbnails'); ?>
								</div>
							</div>

							<div class="palette">
								<div class="paletteheader">Wall Background <span>(Use this if you'd like to preview this design on a flat colour instead)</span></div>
								<div class="palettecolors clearfix">
									<?php 
										get_template_part('includes/content/colors'); 
										foreach($colors as $color) {
											echo '<a href="#" data-svglayer="svgbackground" data-color="'.$color['hex'].'" rel="tooltip" data-original-title="'.$color['color'].'"></a>';
										} ?>
									<a href="#" class="clearbackground">Remove background color</a>
								</div>
							</div><!-- palette -->

							<?php } ?>
							<p><i>Actual colours may vary from the colour on your screen due to monitor colour restrictions. The sizes indicated for the design are the overall area it will cover.</i></p>
							<?php the_content(); ?>
						</div><!-- product extras -->

						<div class="productinfo thecontent pull-left col-lg-6 col-md-12 col-xs-12">

							<div class="summary entry-summary">
								<?php
									/**
									 * woocommerce_single_product_summary hook
									 *
									 * @hooked woocommerce_template_single_title - 5
									 * @hooked woocommerce_template_single_price - 10
									 * @hooked woocommerce_template_single_excerpt - 20
									 * @hooked woocommerce_template_single_add_to_cart - 30
									 * @hooked woocommerce_template_single_meta - 40
									 * @hooked woocommerce_template_single_sharing - 50
									 */

									remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
									
									add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 10 );


									do_action( 'woocommerce_single_product_summary' );
								?>
							</div><!-- .summary -->
						</div><!-- productinfo -->

					</div>
				<?php endwhile; endif; ?>

				<div class="productpagination pull-right">
					<?php nmpza_product_pagination(); ?>
				</div>
				
				<div id="relatedstuff" class="row">
					<?php echo do_shortcode('[related_products posts_per_page="3"]'); ?>
				</div>

			</div><!-- page -->

			<?php get_sidebar(); ?>
		</div>
	</div><!-- content -->
	
<?php get_footer(); ?>
