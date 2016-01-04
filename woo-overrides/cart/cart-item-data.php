<?php
/**
 * Cart item data (when outputting non-flat)
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version 	2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

?>

<ul class="list-unstyled">
	<?php
		foreach ( $item_data as $data ) :
			$key = sanitize_text_field( $data['key'] );
	?>
	<li class="variation-<?php echo sanitize_html_class( $key ); ?>"><strong><?php echo wp_kses_post( $data['key'] ); ?>: </strong><?php echo wp_kses_post( $data['value'] ); ?></li>
	<?php endforeach; ?>
</ul>
