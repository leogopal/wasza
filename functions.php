<?php
/**
 * wallart engine room
 *
 * @package wallart
 */
	
/**
 * Set the content width based on the theme's design and stylesheet.
 */

if ( ! isset( $content_width ) ) {
	$content_width = 980; /* pixels */
}

/**
 * Assign the Wallart Theme version to a var
 */
$wallart_theme 					= wp_get_theme();
$wallart_version				= $wallart_theme['Version'];

add_action( 'after_setup_theme',			'wallart_theme_setup' );

if ( ! function_exists( 'wallart_theme_setup' ) ) :

	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function wallart_theme_setup() {
		/*
		 * Load Localisation files.
		 *
		 * Note: the first-loaded translation file overrides any following ones if the same translation is present.
		 */
		load_theme_textdomain( 'wallart', trailingslashit( WP_LANG_DIR ) . 'themes/' );
		load_theme_textdomain( 'wallart', get_stylesheet_directory() . '/languages' );
		load_theme_textdomain( 'wallart', get_template_directory() . '/languages' );
		/**
		 * Add default posts and comments RSS feed links to head.
		 */
		add_theme_support( 'automatic-feed-links' );
		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
		 */
		add_theme_support( 'post-thumbnails' );
		
		// This theme uses wp_nav_menu() in four locations.
		register_nav_menus( array(
			
		) );
		if ( function_exists( 'register_nav_menus' ) ) {
			register_nav_menus( array(
				'topmenu' 		=> __( 'Top Menu', 			'wallart' ),
				'primary'		=> __( 'Primary Menu', 		'wallart' ),
				'secondary'		=> __( 'Secondary Menu',	'wallart' ),
				'handheld'		=> __( 'Handheld Menu',		'wallart' ),
				)
			);
		}
		// Declare WooCommerce support
		add_theme_support( 'woocommerce' );
		// Declare support for title theme feature
		add_theme_support( 'title-tag' );
	}
endif; // wallart_theme_setup

/* Add an extra Google Font (hosted) 
* * http://themeshaper.com/2014/08/13/how-to-add-google-fonts-to-wordpress-themes/
* Since 1.0
*/
if( ! function_exists( 'wallart_font_url' ) ) {	
	
	function wallart_font_url() {
	    $fonts_url = '';
	 
	    /* Translators: If there are characters in your language that are not
	    * supported by Lora, translate this to 'off'. Do not translate
	    * into your own language.
	    */
	    $roboto = _x( 'on', 'Roboto font: on or off', 'wallart' );
	 
	    /* Translators: If there are characters in your language that are not
	    * supported by Open Sans, translate this to 'off'. Do not translate
	    * into your own language.
	    */
	    $droid_serif = _x( 'on', 'Droid Serif font: on or off', 'wallart' );
	 
	    if ( 'off' !== $roboto || 'off' !== $droid_serif ) {
	        $font_families = array();
	 
	        if ( 'off' !== $roboto ) {
	            $font_families[] = 'Roboto:300,400,700';
	        }
	        
	 
	        if ( 'off' !== $droid_serif ) {
	            $font_families[] = 'Droid Serif:400,700';
	        }
	 
	        $query_args = array(
	            'family' => urlencode( implode( '|', $font_families ) ),
	            'subset' => urlencode( 'latin,latin-ext' ),
	        );
	 
	        $fonts_url = add_query_arg( $query_args, '//fonts.googleapis.com/css' );
	    }
	 
	    return esc_url_raw( $fonts_url );
	}
	
}

/**
 * Enqueue scripts and styles.
 * @since  1.0.0
 */

add_action( 'wp_enqueue_scripts', 'wallart_scripts', 10 );

function wallart_scripts() {
	global $wallart_version;

	wp_enqueue_script(
		'pace', 
		get_template_directory_uri().'/js/pace.min.js', 
		array('jquery'), 
		$wallart_version, false 
	);

	wp_enqueue_script(
		'bootstrap-js', 
		get_template_directory_uri().'/includes/bootstrap/js/bootstrap.min.js', 
		array('jquery'), $wallart_version, true ); 
	
	wp_enqueue_script(
		'wallart-theme-js', 
		get_template_directory_uri().'/js/theme.js', 
		array('jquery'), $wallart_version, true ); 

	wp_enqueue_style(
		'bootstrap', 
		get_template_directory_uri() . '/includes/bootstrap/css/bootstrap.min.css', 
		'',
		$wallart_version
	);

	wp_enqueue_style( 
		'wallart-styles', 
		get_stylesheet_uri(), 
		'', 
		$wallart_version 
	);

	// Load our custom font
	wp_enqueue_style( 
		'wallart-fonts', 
		wallart_font_url(),
		array(), null );

	wp_enqueue_style(
		'wallart-theme-styles', 
		get_template_directory_uri() . '/css/style.css', 
		'',
		$wallart_version
	);

	wp_enqueue_style(
		'wallart-custom-styles', 
		get_template_directory_uri() . '/css/custom.css', 
		'',
		$wallart_version
	);

	wp_enqueue_style(
		'wallart-fontawesome', 
		get_template_directory_uri() . '/includes/font-awesome/css/font-awesome.min.css', 
		'',
		$wallart_version
	);

	wp_enqueue_script(
		'signet', 
		get_template_directory_uri().'/js/signet.min.js', 
		'', 
		$wallart_version, true
	);
}

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
// Hook into the 'widgets_init' action
add_action( 'widgets_init', 'wallart_widgets_init' );

if ( ! function_exists( 'wallart_widgets_init' ) ) {
	function wallart_widgets_init() {
		register_sidebar( array(
			'name'          => __( 'Sidebar', 'wobble' ),
			'id'            => 'mainsidebar',
			'description'   => __( 'The Main Site Sidebar', 'wobble' ),
			'before_widget'	=>	'<div id="%1$s" class="widget %2$s">',
			'after_widget'	=>	'</div>',
			'before_title'	=>	'<h3 class="widget-title">',
			'after_title'	=>	'</h3>',
		) );
		register_sidebar( array(
			'name'          => __( 'Header', 'storefront' ),
			'id'            => 'header-1',
			'description'   => '',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		) );
	}
}

require get_template_directory() . '/includes/paginate.php';
require get_template_directory() . '/includes/customizer.php';

// define user id
	
if (is_user_logged_in()) {
	global $current_user;
	get_currentuserinfo();
	define('USERID', $current_user->ID);
}

/**
 * Fetching additional scripts
 */

get_template_part('includes/functions/advanced-custom-fields/acf');
get_template_part('includes/functions/acf-repeater/acf-repeater');
get_template_part('includes/functions/acf-gallery/acf-gallery');
get_template_part('includes/types/slider');
// titan
get_template_part('includes/titan-framework/titan-framework');
get_template_part('includes/titan');

function custom_excerpt($count, $syntax) {
	$return = get_the_content($id);
	$return = preg_replace('`\[[^\]]*\]`','',$return);
	$return = strip_tags($return);
	$return = substr($return, 0, $count);
	$return = substr($return, 0, strripos($return, " "));
	$return = $return.$syntax;
	return $return;
}

/**
 * Allow SVG Uploads via mime types.
 */

add_filter( 'upload_mimes', 'cc_mime_types' );
function cc_mime_types( $mimes ){
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}
/**
 * Custom WooCommerce Functionality
 */

// Ensure cart contents update when products are added to the cart via AJAX (place the following in functions.php)
add_filter( 'woocommerce_add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment' );

function woocommerce_header_add_to_cart_fragment( $fragments ) {
	ob_start();
	?>
	<a class="cart-contents" href="<?php echo WC()->cart->get_cart_url(); ?>" title="<?php _e( 'View your shopping cart' ); ?>"><?php echo sprintf (_n( '%d item', '%d items', WC()->cart->cart_contents_count ), WC()->cart->cart_contents_count ); ?> - <?php echo WC()->cart->get_cart_total(); ?></a> 
	<?php
	
	$fragments['a.cart-contents'] = ob_get_clean();
	
	return $fragments;
}
		
add_action( 'woocommerce_archive_description', 'woocommerce_category_image', 2 );
function woocommerce_category_image() {
    if ( is_product_category() ){
	    global $wp_query;
	    $cat = $wp_query->get_queried_object();
	    $thumbnail_id = get_woocommerce_term_meta( $cat->term_id, 'thumbnail_id', true );
	    $image = wp_get_attachment_url( $thumbnail_id );
	    if ( $image ) {
		    echo '<img src="' . $image . '" alt="" />';
		}
	}
}

add_action('woocommerce_before_add_to_cart_button','extend_product_options');
function extend_product_options(){
	global $post;
	$layers = get_field('layers');
	if ($layers) {
		foreach($layers as $layer) {
			echo '<div><input id="'.$layer['layer_class'].'" type="hidden" name="'.$layer['layer_name'].'" value="" class="layer_color_items" /></div>';
		}
		echo '<div class="hide"><textarea name="layer_colors" id="layer_colors" rows="10"></textarea></div>';
	}
}

add_filter('woocommerce_add_cart_item_data', 'custom_add_item_data', 10, 2);

function custom_add_item_data($cart_item_meta, $product_id){
    //var_dump($_POST);
    if(isset($_POST['layer_colors'])){
        $cart_item_meta['layer_colors_data']['layer_colors'] = $_POST['layer_colors'];
    }
    return $cart_item_meta;
}

add_filter('woocommerce_get_cart_item_from_session','wc_get_cart_item_from_session', 10, 2);

function wc_get_cart_item_from_session($cart_item, $values) {
    //var_dump($values);
    //var_dump($cart_item);
    if (isset($values['layer_colors_data'])) {
        $cart_item['layer_colors_data'] = $values['layer_colors_data'];
    }
    return $cart_item;
}

add_filter('woocommerce_get_item_data', 'nmpza_wc_get_item_data', 10, 2);

function nmpza_wc_get_item_data($other_data, $cart_item) {
        if (isset($cart_item['layer_colors_data'])) {
            $data = $cart_item['layer_colors_data'];
            $other_data[] = array('name' => 'Layer Colours', 'value' => $data['layer_colors']);
        }
    return $other_data;
}

add_action('woocommerce_add_order_item_meta', 'nmpza_wc_order_item_meta', 10, 2);

function nmpza_wc_order_item_meta($item_id, $cart_item) {
    var_dump($item_id);
    var_dump($cart_item);
	$data = $cart_item['layer_colors_data'];
    if ( ! empty( $cart_item['layer_colors_data'] ) )
        woocommerce_add_order_item_meta( $item_id, 'Layer Colours', $data['layer_colors'] );
}

// hide empty categories from widget
add_filter( 'woocommerce_product_categories_widget_args', 'woo_hide_product_categories_widget' );

function woo_hide_product_categories_widget( $list_args ){
	$list_args[ 'hide_empty' ] = 1;
	
	return $list_args;
}

// Removing unnecessary options page
function custom_menu_page_removing() {
    remove_menu_page( 'wallart-studios-options' );
}
add_action( 'admin_menu', 'custom_menu_page_removing' );

// Head file
add_action( 'wp_head', 'nmpza_header_insert' );

function nmpza_header_insert() {
	?>
	
<script type="text/javascript">
	var siteurl = '<?php echo bloginfo('url'); ?>', 
	templatedir = '<?php echo bloginfo('template_directory'); ?>', 
	ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
</script>
	<?php
}

/*
	Remove Vouchers from the Product Category Widget
*/
//* Used when the widget is displayed as a dropdown
add_filter( 'woocommerce_product_categories_widget_dropdown_args', 'rv_exclude_wc_widget_categories' );

//* Used when the widget is displayed as a list
add_filter( 'woocommerce_product_categories_widget_args', 'rv_exclude_wc_widget_categories' );

function rv_exclude_wc_widget_categories( $cat_args ) {
	$cat_args['exclude'] = array('71'); // Insert the product category IDs you wish to exclude
	return $cat_args;
}