<?php
/**
 * The template for displaying product category thumbnails within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product_cat.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
global $woocommerce_loop;
// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) )
	$woocommerce_loop['loop'] = 0;
// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) )
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );
// Increase loop count
$woocommerce_loop['loop']++;
if ( $category->count > 0 ) {
?>
	<div class="product-category col-lg-4 col-md-6 col-xs-12 product<?php
	    if ( ( $woocommerce_loop['loop'] - 1 ) % $woocommerce_loop['columns'] == 0 || $woocommerce_loop['columns'] == 1 )
	        echo ' first';
		if ( $woocommerce_loop['loop'] % $woocommerce_loop['columns'] == 0 )
			echo ' last';
		if ($category->name == 'Vouchers')
			echo ' vouchers-hide';
		?>">
		<div class="col-inner <?php echo $category->name; ?>">
		
		<?php do_action( 'woocommerce_before_subcategory', $category ); ?>

		<a href="<?php echo get_term_link( $category->slug, 'product_cat' ); ?>">

			<?php
				/**
				 * woocommerce_before_subcategory_title hook
				 *
				 * @hooked woocommerce_subcategory_thumbnail - 10
				 */
				do_action( 'woocommerce_before_subcategory_title', $category );
			?>

			<h3> <?php echo $category->name; ?> </h3>
			<a class="productview btn btn-view" href="<?php echo get_term_link( $category->slug, 'product_cat' ); ?>">View &#8594;</a>

			<?php
				/**
				 * woocommerce_after_subcategory_title hook
				 */
				do_action( 'woocommerce_after_subcategory_title', $category );
			?>

		</a>

		<?php do_action( 'woocommerce_after_subcategory', $category ); ?>
		</div>
	</div>

<?php } ?>