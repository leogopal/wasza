<?php
/**
 * Related Products
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product, $woocommerce_loop;

$related = $product->get_related( $posts_per_page );

if ( sizeof( $related ) == 0 ) return;

$args = apply_filters( 'woocommerce_related_products_args', array(
	'post_type'            => 'product',
	'ignore_sticky_posts'  => 1,
	'no_found_rows'        => 1,
	'posts_per_page'       => $posts_per_page,
	'orderby'              => $orderby,
	'post__in'             => $related,
	'post__not_in'         => array( $product->id )
) );

$products = new WP_Query( $args );

$woocommerce_loop['columns'] = $columns;

if ( $products->have_posts() ) : ?>

	<div class="related products">

		<h2>You may also like</h2>

		<?php woocommerce_product_loop_start(); ?>
		
		<div class="row">
			<?php while ( $products->have_posts() ) : $products->the_post(); $thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id($products->ID), 'full' ); ?>
				
					<div class="product col-lg-4 col-md-6 col-xs-12">
						<div class="col-inner">
							<a href="<?php the_permalink(); ?>" class="productpic"><img src="<?php echo $thumbnail[0]; ?>" width="100%" /></a>
							<div class="productinfo clearfix">
								<h3 class="pull-left"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
								<a class="productview btn btn-view" href="<?php the_permalink(); ?>">View &#8594;</a>
							</div>
						</div>
					</div>				

			<?php endwhile; // end of the loop. ?>
		</div>
		
		<?php woocommerce_product_loop_end(); ?>

	</div>

<?php endif;

wp_reset_postdata();
