<?php

// register the widget + give it a custom name
add_action("widgets_init", create_function('', 'return register_widget("wallart_news_Widget");'));

# make sure it extends the WP_Widget class

// create the custom class
class wallart_news_Widget extends WP_Widget {
	
	 /** constructor */
    function wallart_news_Widget() {
		parent::WP_Widget(false, $name = 'Wallart News');	
    }	
	
	// these are the options for the widget... info that you want to be able to save for this widget. 
	function form($instance) { ?>

			<p>
				<label>Widget Title</label>
				<input class="widefat" type="text" name="<?php echo $this->get_field_name('widget_title'); ?>" value="<?php echo $instance['widget_title']; ?>" />
			</p>

        <?php 
	}


	// the visible widget, ie what is actually seen on the site
	function widget($args, $instance){
		# makes the arguments into normal variables example $args['before_widget'] is now $before_widget
		extract( $args );
    
		echo $before_widget;
		echo "<div class='wallart_news_widget'>";
		echo $before_title . $instance['widget_title'] . $after_title; ?>
			
			<ul>
			<?php $latestnews = get_posts('post_type=post&posts_per_page=3'); foreach($latestnews as $post) { setup_postdata($post); ?>
				<li><strong><a href="<?php echo get_permalink($post->ID); ?>"><?php echo get_the_title($post->ID); ?></a></strong><br /><p><?php echo custom_excerpt(50, '...');?></p></li>
			<?php } ?>
			</ul>
						
		<?php echo "</div>" . $after_widget;
	}
	
	 /** @see WP_Widget::update function that updates the widget */
    function update($new_instance, $old_instance) {				
		  $instance = $old_instance;

		  # you must list all the elements in the widget form here, this is how the $_POST variable is handled 		  
		  $instance['widget_title'] = strip_tags($new_instance['widget_title']);
		  
        return $instance;
    }	
		
}