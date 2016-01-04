<?php

// register the widget + give it a custom name
add_action("widgets_init", create_function('', 'return register_widget("connectwithus_Widget");'));

# make sure it extends the WP_Widget class

// create the custom class
class connectwithus_Widget extends WP_Widget {
	
	 /** constructor */
    function connectwithus_Widget() {
		parent::WP_Widget(false, $name = 'Connect With Us');	
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
		echo "<div class='connectwithus_widget'>";
		echo $before_title . $instance['widget_title'] . $after_title; ?>
		
			<?php if (get_titan('facebook')) { ?><a href="<?php titan('facebook'); ?>"><i class="fa fa-facebook"></i></a><?php } ?>
			<?php if (get_titan('twitter')) { ?><a href="<?php titan('twitter'); ?>"><i class="fa fa-twitter"></i></a><?php } ?>
			<?php if (get_titan('pinterest')) { ?><a href="<?php titan('pinterest'); ?>"><i class="fa fa-pinterest"></i></a><?php } ?>
						
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

?>
