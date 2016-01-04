<?php

	add_action('init', 'slider_post_type');
	add_action('init', 'slider_comments');

	function slider_comments() {
		add_post_type_support( 'slider', 'comments' );
	}
	
	function slider_post_type() 
	{
	  $slider_labels = array(
		'name' => _x('Slider', 'post type general name'),
		'singular_name' => _x('Slider', 'post type singular name'),
		'add_new' => _x('Add Slider', 'article'),
		'add_new_item' => __('Add New Slider'),
		'edit_item' => __('Edit Slider'),
		'new_item' => __('New Slider'),
		'view_item' => __('View Slider'),
		'search_items' => __('Search Sliders'),
		'not_found' =>  __('No Sliders found'),
		'not_found_in_trash' => __('No Sliders found in Trash'), 
		'parent_item_colon' => '',
		'menu_name' => 'Slider'
	
	  );
	  $slider_settings = array(
		'labels' => $slider_labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true, 
		'show_in_menu' => true,
		'menu_position' => '100',
		'query_var' => true,
		'rewrite' => true,
		'capability_type' => 'post',
		'has_archive' => true, 
		'hierarchical' => false,
		'menu_position' => null,
		'supports' => array('title','editor','author','thumbnail','comments'),
		'menu_icon' => get_bloginfo('template_directory').'/images/icon-slider.png'
	  ); 
	  register_post_type('slider',$slider_settings);

	};
