<?php
/**
 * Theme functions and definitions
 *
 * @package Betting_Theme_Max
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/**
 * Theme setup
 */
function betting_theme_max_setup() {
    // Add default posts and comments RSS feed links to head
    add_theme_support( 'automatic-feed-links' );

    // Let WordPress manage the document title
    add_theme_support( 'title-tag' );

    // Enable support for Post Thumbnails
    add_theme_support( 'post-thumbnails' );

    // Register navigation menus
    register_nav_menus(
        array(
            'menu-1' => esc_html__( 'Primary Menu', 'betting-theme-max' ),
            'footer' => esc_html__( 'Footer Menu', 'betting-theme-max' ),
        )
    );

    // Switch default core markup to output valid HTML5
    add_theme_support(
        'html5',
        array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'style',
            'script',
        )
    );

    // Add theme support for custom logo
    add_theme_support(
        'custom-logo',
        array(
            'height'      => 100,
            'width'       => 400,
            'flex-height' => true,
            'flex-width'  => true,
        )
    );

    // Add support for editor styles
    add_theme_support( 'editor-styles' );

    // Add support for responsive embedded content
    add_theme_support( 'responsive-embeds' );

    // Add support for Block Styles
    add_theme_support( 'wp-block-styles' );

    // Add support for full and wide align images
    add_theme_support( 'align-wide' );
}
add_action( 'after_setup_theme', 'betting_theme_max_setup' );

/**
 * Set the content width in pixels
 */
function betting_theme_max_content_width() {
    $GLOBALS['content_width'] = apply_filters( 'betting_theme_max_content_width', 1200 );
}
add_action( 'after_setup_theme', 'betting_theme_max_content_width', 0 );

/**
 * Enqueue scripts and styles
 */
function betting_theme_max_scripts() {
    // Main stylesheet
    wp_enqueue_style( 'betting-theme-max-style', get_stylesheet_uri(), array(), '1.0.0' );

    // Main JavaScript
    wp_enqueue_script( 'betting-theme-max-script', get_template_directory_uri() . '/js/main.js', array(), '1.0.0', true );

    // Comment reply script
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'betting_theme_max_scripts' );

/**
 * Register widget areas
 */
function betting_theme_max_widgets_init() {
    register_sidebar(
        array(
            'name'          => esc_html__( 'Sidebar', 'betting-theme-max' ),
            'id'            => 'sidebar-1',
            'description'   => esc_html__( 'Add widgets here.', 'betting-theme-max' ),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        )
    );

    register_sidebar(
        array(
            'name'          => esc_html__( 'Footer', 'betting-theme-max' ),
            'id'            => 'footer-1',
            'description'   => esc_html__( 'Add footer widgets here.', 'betting-theme-max' ),
            'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        )
    );
}
add_action( 'widgets_init', 'betting_theme_max_widgets_init' );
