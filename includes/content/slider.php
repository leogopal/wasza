	<div id="slider" class="container">
		<div id="theslider" class="carousel slide row" data-interval="3000" data-ride="carousel">
			<div class="slider-controls">
				<a href="#theslider" data-slide="prev"><img src="<?php echo bloginfo('template_directory'); ?>/images/sliderarrow.png" /></a>
				<a href="#theslider" data-slide="next"><img src="<?php echo bloginfo('template_directory'); ?>/images/sliderarrow.png" /></a>
			</div>
			
			<div class="carousel-inner">
				<?php
					$count = 0;
					$slides = get_posts('post_type=slider&posts_per_page=-1');
					$link = '';
					foreach($slides as $slide) {

						$count++;
						
						if (get_field('slider_url', $slide->ID)) {
							$link = get_field('slider_url', $slide->ID);
							$href = '<a href="'.get_permalink($link->ID).'">';
						} else {
							$href = '';
						}
				?>
				<div class="item <?php if ($count == 1) { echo 'active'; } ?>"><?php echo $href; ?><img src="<?php the_field('slider_image', $slide->ID); ?>" /><?php if ($link) { echo '</a>'; } ?></div>
				<?php } ?>
			</div>
		</div>
	</div><!-- slider -->
