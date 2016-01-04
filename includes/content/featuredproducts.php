<div id="featuredproducts" class="productrow">
	<h4>Featured Products</h4>
	
	<div class="clearfix">
		<?php 
		$products = get_posts('post_type=product&posts_per_page=6&meta_key=_featured&meta_value=yes'); 
		foreach($products as $post) { 
			setup_postdata( $post ); 
			$thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' ); 
			?>
		<div class="product">
			<a href="<?php the_permalink(); ?>" class="productpic"><img src="<?php echo $thumbnail[0]; ?>" /></a>
			<div class="productinfo clearfix">
				<h3 class="pull-left"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
				<div class="productprice pull-right"><?php echo get_post_meta($post->ID, 'price', true); ?></div>
			</div>
		</div>
		<?php } ?>
	</div>
</div>
