<?php
/**
 * Variable product add to cart
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce, $product, $post;
?>

<?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>

<form class="variations_form cart" method="post" enctype='multipart/form-data' data-product_id="<?php echo $post->ID; ?>" data-product_variations="<?php echo esc_attr( json_encode( $available_variations ) ) ?>">
	<?php if ( ! empty( $available_variations ) ) : ?>
		<table class="variations" cellspacing="0">
			<tbody>
				<?php $loop = 0; foreach ( $attributes as $name => $options ) : $loop++; ?>
					<tr>
						<td class="value productoption">
							<label for="<?php echo sanitize_title($name); ?>"><strong><?php echo wc_attribute_label( $name ); ?></strong></label>
							<select id="<?php echo esc_attr( sanitize_title( $name ) ); ?>" name="attribute_<?php echo sanitize_title( $name ); ?>">
							<option value=""><?php echo __( 'Choose an option', 'woocommerce' ) ?>&hellip;</option>
							<?php
								if ( is_array( $options ) ) {

									if ( isset( $_REQUEST[ 'attribute_' . sanitize_title( $name ) ] ) ) {
										$selected_value = $_REQUEST[ 'attribute_' . sanitize_title( $name ) ];
									} elseif ( isset( $selected_attributes[ sanitize_title( $name ) ] ) ) {
										$selected_value = $selected_attributes[ sanitize_title( $name ) ];
									} else {
										$selected_value = '';
									}

									// Get terms if this is a taxonomy - ordered
									if ( taxonomy_exists( $name ) ) {

										$orderby = wc_attribute_orderby( $name );

										switch ( $orderby ) {
											case 'name' :
												$args = array( 'orderby' => 'name', 'hide_empty' => false, 'menu_order' => false );
											break;
											case 'id' :
												$args = array( 'orderby' => 'id', 'order' => 'ASC', 'menu_order' => false, 'hide_empty' => false );
											break;
											case 'menu_order' :
												$args = array( 'menu_order' => 'ASC', 'hide_empty' => false );
											break;
										}

										$terms = get_terms( $name, $args );

										foreach ( $terms as $term ) {
											if ( ! in_array( $term->slug, $options ) )
												continue;

											echo '<option value="' . esc_attr( $term->slug ) . '" ' . selected( sanitize_title( $selected_value ), sanitize_title( $term->slug ), false ) . '>' . apply_filters( 'woocommerce_variation_option_name', $term->name ) . '</option>';
										}
									} else {

										foreach ( $options as $option ) {
											echo '<option value="' . esc_attr( sanitize_title( $option ) ) . '" ' . selected( sanitize_title( $selected_value ), sanitize_title( $option ), false ) . '>' . esc_html( apply_filters( 'woocommerce_variation_option_name', $option ) ) . '</option>';
										}

									}
								}
							?>
						</select> <?php
							if ( sizeof( $attributes ) == $loop )
								echo '<a class="reset_variations" href="#reset">' . __( 'Clear selection', 'woocommerce' ) . '</a>';
						?></td>
					</tr>
		        <?php endforeach;?>
			</tbody>
		</table>

		<div class="productoption productcolor clearfix">
			<div><strong>SELECT YOUR COLOUR:</strong></div>
			
			<?php
				global $colors;
				
				$colors = array(
					array('color' => 'White', 'hex' => '#ffffff'),
					array('color' => 'Ivory Cream', 'hex' => '#fff8af'),
					array('color' => 'Yellow', 'hex' => '#fff212'),
					array('color' => 'Mango Orange', 'hex' => '#fdb92e'),
					array('color' => 'Bright Orange', 'hex' => '#f58634'),
					array('color' => 'Postbox Red', 'hex' => '#ef4737'),
					array('color' => 'Dark Red', 'hex' => '#e13236'),
					array('color' => 'Rustic Red', 'hex' => '#910d18'),
					array('color' => 'Plum Burgundy', 'hex' => '#891c2e'),
					array('color' => 'Aubergine', 'hex' => '#5d455c'),
					array('color' => 'Magenta', 'hex' => '#ec268f'),
					array('color' => 'Soft Pink', 'hex' => '#ff8bb5'),
					array('color' => 'Coral Pink', 'hex' => '#ff6257'),
					array('color' => 'Light Pink', 'hex' => '#fcdee0'),
					array('color' => 'Lilac', 'hex' => '#ecb5dd'),
					array('color' => 'Lavender Purple', 'hex' => '#976298'),
					array('color' => 'Violet Purple', 'hex' => '#724178'),
					array('color' => 'Baby Blue', 'hex' => '#8fd7ff'),
					array('color' => 'Sky Blue', 'hex' => '#00afef'),
					array('color' => 'Azure Blue', 'hex' => '#074294'),
					array('color' => 'Brilliant Blue', 'hex' => '#3e3699'),
					array('color' => 'Navy Blue', 'hex' => '#122b5c'),
					array('color' => 'Turquoise Green', 'hex' => '#007968'),
					array('color' => 'Mint', 'hex' => '#90e8b2'),
					array('color' => 'Lime Green', 'hex' => '#7cb228'),
					array('color' => 'Bright Green', 'hex' => '#0aad4f'),
					array('color' => 'Green', 'hex' => '#038a4b'),
					array('color' => 'Dark Green', 'hex' => '#023d27'),
					array('color' => 'Sage', 'hex' => '#92996d'),
					array('color' => 'Taupe', 'hex' => '#be9d72'),
					array('color' => 'Beige', 'hex' => '#f0e0aa'),
					array('color' => 'Nut Brown', 'hex' => '#ce7318'),
					array('color' => 'Choc Brown', 'hex' => '#4d2501'),
					array('color' => 'Light Grey', 'hex' => '#e6e6e6'),
					array('color' => 'Medium Grey', 'hex' => '#b3b3b3'),
					array('color' => 'Charcoal', 'hex' => '#333333'),
					array('color' => 'Black', 'hex' => '#000000'),
					array('color' => 'Gold', 'hex' => '#efbb4d'),
					array('color' => 'Silver', 'hex' => '#bdbfc2')
				);
		
				function searchColorByHex($hex, $colors) { 
					foreach($colors as $color) { 
						if ($color['hex'] == $hex) {
							return $color['color'];
						}
					}
				}
			?>
			
			<?php $layers = get_field('layers'); foreach($layers as $layer) { ?>
				<div class="palette" id="palette-<?php echo $layer['layer_class']; ?>" data-default="<?php echo $layer['layer_name']; ?>: <?php echo searchColorByHex($layer['layer_color'], $colors); ?>">
					<div class="paletteheader"><?php echo $layer['layer_name']; ?>: <span>(Currently: <span class="currentcolor"><?php echo searchColorByHex($layer['layer_color'], $colors); ?></span>)</span></div>
					<div class="palettecolors clearfix">
						<?php foreach($colors as $color) {
							echo '<a href="#" data-svglayer="'.$layer['layer_class'].'" data-layername="'.$layer['layer_name'].'" data-color="'.$color['hex'].'" rel="tooltip" data-original-title="'.$color['color'].'"></a>';
						} ?>
					</div>
				</div><!-- palette -->
				<style type="text/css">.<?php echo $layer['layer_class']; ?> {fill: <?php echo $layer['layer_color']; ?>;}</style>
			<?php } ?>
		</div><!-- product color -->


		<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

		<div class="single_variation_wrap" style="display:none;">
			<?php do_action( 'woocommerce_before_single_variation' ); ?>

			<div class="single_variation productprice"></div>

			<div class="variations_button">
				<?php woocommerce_quantity_input(); ?>
				<button type="submit" class="single_add_to_cart_button btn btn-primary"><?php echo $product->single_add_to_cart_text(); ?></button>
			</div>

			<input type="hidden" name="add-to-cart" value="<?php echo $product->id; ?>" />
			<input type="hidden" name="product_id" value="<?php echo esc_attr( $post->ID ); ?>" />
			<input type="hidden" name="variation_id" value="" />

			<?php do_action( 'woocommerce_after_single_variation' ); ?>
		</div>

		<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>

	<?php else : ?>

		<p class="stock out-of-stock"><?php _e( 'This product is currently out of stock and unavailable.', 'woocommerce' ); ?></p>

	<?php endif; ?>

</form>

<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>
