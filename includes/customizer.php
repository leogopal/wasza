<?php

add_action( 'customize_register', function($wp_customize ) {
    // Contact Section
    $wp_customize->add_section( 'contact-numbers' , array(
        'title' => 'Contact Information',
        'priority' => 30
        ) );
    //sa section
//sa image

    $wp_customize->add_setting( 'sa_phone' , array( 'default' => '' ));
    $wp_customize->add_setting( 'sa_image' );
    
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'sa_image', array(
        'label'    => 'South African Image',
        'section'  => 'contact-numbers',
        'settings' => 'sa_image',
        ) ) );

//sa phone
    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'sa_phone', array(
        'label' => 'South African Number',
        'section' => 'contact-numbers',
        'settings' => 'sa_phone',
        ) ) );

    //uk section
//uk image

    $wp_customize->add_setting( 'uk_phone' , array( 'default' => '' ));
    $wp_customize->add_setting( 'uk_image' );
    
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'uk_image', array(
        'label'    => 'United Kingdom Image',
        'section'  => 'contact-numbers',
        'settings' => 'uk_image',
        ) ) );
//uk phone
    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'uk_phone', array(
        'label' => 'United Kingdom Number',
        'section' => 'contact-numbers',
        'settings' => 'uk_phone',
        ) ) );


} );