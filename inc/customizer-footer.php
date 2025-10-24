<?php
/**
 * Footer Customizer Settings
 *
 * @package Betting_Theme_Max
 */

function betting_theme_max_footer_customizer( $wp_customize ) {
    
    // Footer Section
    $wp_customize->add_section( 'footer_settings', array(
        'title'    => __( 'Footer Settings', 'betting-theme-max' ),
        'priority' => 120,
    ) );

    // Footer Logo
    $wp_customize->add_setting( 'footer_logo', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ) );

    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'footer_logo', array(
        'label'    => __( 'Footer Logo', 'betting-theme-max' ),
        'section'  => 'footer_settings',
        'settings' => 'footer_logo',
    ) ) );

    // Footer Text
    $wp_customize->add_setting( 'footer_text', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_textarea_field',
    ) );

    $wp_customize->add_control( 'footer_text', array(
        'label'    => __( 'Footer Description Text', 'betting-theme-max' ),
        'section'  => 'footer_settings',
        'type'     => 'textarea',
    ) );

    // Footer Apps Title
    $wp_customize->add_setting( 'footer_apps_title', array(
        'default'           => 'Download the verified App',
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'footer_apps_title', array(
        'label'    => __( 'App Downloads Title', 'betting-theme-max' ),
        'section'  => 'footer_settings',
        'type'     => 'text',
    ) );

    // iOS App Link
    $wp_customize->add_setting( 'footer_ios_link', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ) );

    $wp_customize->add_control( 'footer_ios_link', array(
        'label'    => __( 'iOS App Download Link', 'betting-theme-max' ),
        'section'  => 'footer_settings',
        'type'     => 'url',
    ) );

    // iOS Button Text
    $wp_customize->add_setting( 'footer_ios_text', array(
        'default'           => 'iOS',
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'footer_ios_text', array(
        'label'    => __( 'iOS Button Text', 'betting-theme-max' ),
        'section'  => 'footer_settings',
        'type'     => 'text',
    ) );

    // Android App Link
    $wp_customize->add_setting( 'footer_android_link', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ) );

    $wp_customize->add_control( 'footer_android_link', array(
        'label'    => __( 'Android App Download Link', 'betting-theme-max' ),
        'section'  => 'footer_settings',
        'type'     => 'url',
    ) );

    // Android Button Text
    $wp_customize->add_setting( 'footer_android_text', array(
        'default'           => 'Android',
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'footer_android_text', array(
        'label'    => __( 'Android Button Text', 'betting-theme-max' ),
        'section'  => 'footer_settings',
        'type'     => 'text',
    ) );

    // Copyright Text
    $wp_customize->add_setting( 'footer_copyright', array(
        'default'           => '© ' . date('Y') . ' ' . get_bloginfo( 'name' ) . '. All rights reserved.',
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'footer_copyright', array(
        'label'    => __( 'Copyright Text', 'betting-theme-max' ),
        'section'  => 'footer_settings',
        'type'     => 'text',
    ) );

    // Partner Logos (5 logos)
    for ( $i = 1; $i <= 5; $i++ ) {
        // Logo Image
        $wp_customize->add_setting( 'footer_logo_' . $i, array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ) );

        $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'footer_logo_' . $i, array(
            'label'    => sprintf( __( 'Partner Logo %d', 'betting-theme-max' ), $i ),
            'section'  => 'footer_settings',
            'settings' => 'footer_logo_' . $i,
        ) ) );

        // Logo Alt Text
        $wp_customize->add_setting( 'footer_logo_' . $i . '_alt', array(
            'default'           => 'Partner Logo ' . $i,
            'sanitize_callback' => 'sanitize_text_field',
        ) );

        $wp_customize->add_control( 'footer_logo_' . $i . '_alt', array(
            'label'    => sprintf( __( 'Partner Logo %d Alt Text', 'betting-theme-max' ), $i ),
            'section'  => 'footer_settings',
            'type'     => 'text',
        ) );
    }
}
add_action( 'customize_register', 'betting_theme_max_footer_customizer' );
