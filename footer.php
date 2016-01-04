<div id="footer" class="container-fluid">
<div class="container">
	<div class="row">
		<p class="pull-left">Copyright &copy; <?php echo date("Y"); ?> Wall Art Studios <br />All Rights Reserved. E&OE</p>
		<?php wp_nav_menu('menu=2&container=menu&menu_id=footernav&menu_class=pull-right&depth=1'); ?>
	</div>
	
	<div class="row socialicons">
		<a href="https://www.facebook.com/wallartstudios" target="_blank"><i class="fa fa-facebook-official"></i></a>
		<a href="https://twitter.com/VixJay" target="_blank"><i class="fa fa-twitter-square"></i></a>
		<a href="http://www.pinterest.com/wallartstudios/" target="_blank"><i class="fa fa-pinterest-square"></i></a>
	</div>
	
	<div class="row corplinks">
		<div class="pull-left">
			Made with <i class="fa fa-heart"></i> by <a href="https://nmp.co.za/">Net Media Planet</a>  <span>|</span> <a href="<?php echo get_permalink(325); ?>">Privacy Policy</a>  <span>|</span>  <a href="<?php echo get_permalink(327); ?>">Sitemap</a>  <span>|</span>  <a href="<?php echo get_permalink(323); ?>">Report a Problem</a>
		</div>
		
		<div class="logos pull-right">
			<img src="<?php echo bloginfo('template_directory'); ?>/images/logo-visa.png" />
			<img src="<?php echo bloginfo('template_directory'); ?>/images/logo-mastercard.png" />
			<img src="<?php echo bloginfo('template_directory'); ?>/images/logo-payfast.png" />
		</div>
	</div>
</div>

</div>

<?php wp_footer(); ?>

</body>
</html>
