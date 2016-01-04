<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section.
 *
 * @package wallart
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<!-- Regular Injected Meta and Link items -->
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

	<link rel="shortcut icon" href="<?php bloginfo('template_directory'); ?>/images/favicon.png" />

	<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

<meta name="signet:authors" content="Leo Gopal, Richard Miles, Net Media Planet">
<meta name="signet:links" content="http://leogopal.com, http://github.com/leogopal, http://twitter.com/leogopal, http://richmiles.co.za/, https://github.com/richlloydmiles/, https://twitter.com/RichLloydMiles, http://nmp.co.za">

<!-- Start of wp_head() -->
<?php wp_head(); ?>
<!-- End of wp_head() -->

</head>

<body <?php body_class(); ?>>
	<?php global $woocommerce;?>
	<div id="header" class="container">
		<div class="row">
			<div class="col-sm-4">
				<div class="header-contact">
					<div class="sa-tel">
						<img src="<?php if ( get_theme_mod('sa_image') ) { echo get_theme_mod('sa_image', ''); } ?>">
						<a href="tel:<?php echo get_theme_mod('sa_phone', ''); ?>"><?php echo get_theme_mod('sa_phone', ''); ?></a>
					</div>
					<div class="uk-tel">
						<img src="<?php if ( get_theme_mod('uk_image') ) { echo get_theme_mod('uk_image', ''); } ?>">
						<a class="not-for-desktop" href="tel:<?php echo get_theme_mod('uk_phone', ''); ?>"><?php echo get_theme_mod('uk_phone', ''); ?></a>
					</div>
				</div>
			</div>
			<div class="col-sm-4">
				<a href="<?php bloginfo('url'); ?>" id="logo">
					<img src="<?php echo bloginfo('template_directory'); ?>/images/logo.png" />
				</a>	
			</div>
			<div class="col-sm-4" style="text-align:right;">
				<div class="header-cart">
				<i style="color:#5b435c;" class="fa fa-shopping-cart fa-2x"></i>
					<a class="cart-contents" href="<?php echo WC()->cart->get_cart_url(); ?>" title="<?php _e( 'View your shopping cart' ); ?>"><?php echo sprintf (_n( '%d item', '%d items', WC()->cart->cart_contents_count ), WC()->cart->cart_contents_count ); ?> - <?php echo WC()->cart->get_cart_total(); ?></a>
				</div>
			</div>
		</div>

	</div>

	<nav class="navbar navbar-default">
		<div class="container">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			</div>
			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<?php wp_nav_menu( array( 
					'theme_location' => 'topmenu',
					'items_wrap'      => '	<ul class="nav navbar-nav">%3$s</ul>',
					) ); ?>

				</div><!-- /.navbar-collapse -->
			</div><!-- /.container-fluid -->
		</nav>
