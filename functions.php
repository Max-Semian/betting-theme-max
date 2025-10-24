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
            'primary' => esc_html__( 'Primary Menu', 'betting-theme-max' ),
            'footer'  => esc_html__( 'Footer Menu', 'betting-theme-max' ),
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

    // Header styles
    wp_enqueue_style( 'betting-theme-max-header', get_template_directory_uri() . '/assets/css/header.css', array( 'betting-theme-max-style' ), '1.0.0' );

    // Header JavaScript
    wp_enqueue_script( 'betting-theme-max-header', get_template_directory_uri() . '/assets/js/header.js', array(), '1.0.0', true );

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

/**
 * Custom Walker for Menu Icons
 */
class Betting_Theme_Walker_Nav_Menu extends Walker_Nav_Menu {
    function start_lvl( &$output, $depth = 0, $args = null ) {
        $indent = str_repeat( "\t", $depth );
        $output .= "\n$indent<ul class=\"sub-menu\">\n";
    }
    
    function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
        
        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;
        
        if ( in_array( 'menu-item-has-children', $classes ) ) {
            $classes[] = 'has-dropdown';
        }
        
        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
        $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';
        
        $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
        $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';
        
        $output .= $indent . '<li' . $id . $class_names .'>';
        
        $atts = array();
        $atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
        $atts['target'] = ! empty( $item->target )     ? $item->target     : '';
        $atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
        $atts['href']   = ! empty( $item->url )        ? $item->url        : '';
        
        $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );
        
        $attributes = '';
        foreach ( $atts as $attr => $value ) {
            if ( ! empty( $value ) ) {
                $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }
        
        // Get icon from custom fields
        $menu_item_icon = get_post_meta( $item->ID, '_menu_item_icon', true );
        $menu_item_media_icon = get_post_meta( $item->ID, '_menu_item_media_icon', true );
        $title = apply_filters( 'the_title', $item->title, $item->ID );
        
        $icon = '';
        $text = $title;
        
        // Priority: Media icon > dropdown icon
        if ( ! empty( $menu_item_media_icon ) ) {
            $attachment_url = wp_get_attachment_url( $menu_item_media_icon );
            $attachment_mime = get_post_mime_type( $menu_item_media_icon );
            
            if ( $attachment_url ) {
                if ( $attachment_mime === 'image/svg+xml' ) {
                    $svg_content = file_get_contents( $attachment_url );
                    if ( $svg_content ) {
                        $icon = '<span class="menu-icon menu-media-svg-icon">' . $svg_content . '</span>';
                    }
                } else {
                    $attachment = wp_get_attachment_image_src( $menu_item_media_icon, array( 24, 24 ) );
                    if ( $attachment ) {
                        $icon = '<span class="menu-icon menu-media-icon"><img src="' . esc_url( $attachment[0] ) . '" alt="" style="width: 20px; height: 20px; vertical-align: middle;" /></span>';
                    }
                }
            }
        } elseif ( ! empty( $menu_item_icon ) ) {
            if ( strpos( $menu_item_icon, 'svg:' ) === 0 ) {
                $svg_filename = str_replace( 'svg:', '', $menu_item_icon );
                $svg_content = betting_theme_max_get_svg_content( $svg_filename );
                if ( $svg_content ) {
                    $icon = '<span class="menu-icon menu-svg-icon">' . $svg_content . '</span>';
                }
            } else {
                $icon = '<span class="menu-icon">' . $menu_item_icon . '</span>';
            }
        } else {
            if ( preg_match( '/^([^\w\s]+)\s*(.+)$/', $title, $matches ) ) {
                $icon = '<span class="menu-icon">' . $matches[1] . '</span>';
                $text = $matches[2];
            }
        }
        
        // Add dropdown arrow for items with children
        $dropdown_arrow = '';
        if ( in_array( 'menu-item-has-children', $classes ) && $depth === 0 ) {
            $dropdown_arrow = '<span class="dropdown-arrow"><svg width="10" height="6" viewBox="0 0 10 6" fill="currentColor"><path d="M1 1L5 5L9 1"/></svg></span>';
        }
        
        $item_output = isset( $args->before ) ? $args->before : '';
        $item_output .= '<a' . $attributes .'>';
        $item_output .= ( isset( $args->link_before ) ? $args->link_before : '' ) . $icon . '<span class="menu-text">' . $text . '</span>' . $dropdown_arrow . ( isset( $args->link_after ) ? $args->link_after : '' );
        $item_output .= '</a>';
        $item_output .= isset( $args->after ) ? $args->after : '';
        
        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }
}

/**
 * Get SVG content for inline display
 */
function betting_theme_max_get_svg_content( $icon_filename ) {
    $icons_dir = get_template_directory() . '/assets/icons/';
    $file_path = $icons_dir . $icon_filename . '.svg';
    
    if ( file_exists( $file_path ) ) {
        $svg_content = file_get_contents( $file_path );
        $svg_content = preg_replace( '/width="[^"]*"/', 'width="16"', $svg_content );
        $svg_content = preg_replace( '/height="[^"]*"/', 'height="16"', $svg_content );
        $svg_content = str_replace( 'fill="none"', '', $svg_content );
        $svg_content = preg_replace( '/fill="[^"]*"/', 'fill="currentColor"', $svg_content );
        return $svg_content;
    }
    
    return '';
}

/**
 * Get custom SVG icons from theme directory
 */
function betting_theme_max_get_custom_icons() {
    $icons_dir = get_template_directory() . '/assets/icons/';
    $icons_url = get_template_directory_uri() . '/assets/icons/';
    $custom_icons = array();
    
    if ( is_dir( $icons_dir ) ) {
        $files = glob( $icons_dir . '*.svg' );
        foreach ( $files as $file ) {
            $filename = basename( $file, '.svg' );
            $icon_name = ucfirst( str_replace( array( '-', '_' ), ' ', $filename ) );
            $custom_icons[$filename] = array(
                'name' => $icon_name,
                'file' => $filename . '.svg',
                'path' => $file,
                'url' => $icons_url . $filename . '.svg'
            );
        }
    }
    
    return $custom_icons;
}

/**
 * Add custom fields to menu items
 */
function betting_theme_max_menu_item_custom_fields( $item_id, $item, $depth, $args ) {
    $menu_item_icon = get_post_meta( $item_id, '_menu_item_icon', true );
    $menu_item_media_icon = get_post_meta( $item_id, '_menu_item_media_icon', true );
    $custom_icons = betting_theme_max_get_custom_icons();
    
    ?>
    <div class="field-icon description-wide" style="margin: 5px 0;">
        <label for="edit-menu-item-icon-<?php echo $item_id; ?>">
            <strong><?php esc_html_e( 'Menu Icon', 'betting-theme-max' ); ?></strong><br />
            <select name="menu-item-icon[<?php echo $item_id; ?>]" id="edit-menu-item-icon-<?php echo $item_id; ?>" class="widefat icon-selector" style="width: 100%;">
                <option value=""><?php esc_html_e( 'No Icon', 'betting-theme-max' ); ?></option>
                
                <?php if ( ! empty( $custom_icons ) ) : ?>
                <optgroup label="<?php esc_attr_e( 'Custom SVG Icons', 'betting-theme-max' ); ?>">
                    <?php foreach ( $custom_icons as $filename => $icon_data ) : ?>
                        <option value="svg:<?php echo esc_attr( $filename ); ?>" <?php selected( $menu_item_icon, 'svg:' . $filename ); ?>>
                            <?php echo esc_html( $icon_data['name'] ); ?>
                        </option>
                    <?php endforeach; ?>
                </optgroup>
                <?php endif; ?>
                
                <optgroup label="<?php esc_attr_e( 'Emoji Icons', 'betting-theme-max' ); ?>">
                    <option value="🏠" <?php selected( $menu_item_icon, '🏠' ); ?>>🏠 <?php esc_html_e( 'Home', 'betting-theme-max' ); ?></option>
                    <option value="⚽" <?php selected( $menu_item_icon, '⚽' ); ?>>⚽ <?php esc_html_e( 'Sports', 'betting-theme-max' ); ?></option>
                    <option value="🎰" <?php selected( $menu_item_icon, '🎰' ); ?>>🎰 <?php esc_html_e( 'Casino', 'betting-theme-max' ); ?></option>
                    <option value="🎮" <?php selected( $menu_item_icon, '🎮' ); ?>>🎮 <?php esc_html_e( 'Gaming', 'betting-theme-max' ); ?></option>
                    <option value="🎁" <?php selected( $menu_item_icon, '🎁' ); ?>>🎁 <?php esc_html_e( 'Bonuses', 'betting-theme-max' ); ?></option>
                    <option value="💰" <?php selected( $menu_item_icon, '💰' ); ?>>💰 <?php esc_html_e( 'Money', 'betting-theme-max' ); ?></option>
                    <option value="🏆" <?php selected( $menu_item_icon, '🏆' ); ?>>🏆 <?php esc_html_e( 'Trophy', 'betting-theme-max' ); ?></option>
                    <option value="⭐" <?php selected( $menu_item_icon, '⭐' ); ?>>⭐ <?php esc_html_e( 'Star', 'betting-theme-max' ); ?></option>
                    <option value="🔥" <?php selected( $menu_item_icon, '🔥' ); ?>>🔥 <?php esc_html_e( 'Hot', 'betting-theme-max' ); ?></option>
                    <option value="📞" <?php selected( $menu_item_icon, '📞' ); ?>>📞 <?php esc_html_e( 'Contact', 'betting-theme-max' ); ?></option>
                    <option value="ℹ️" <?php selected( $menu_item_icon, 'ℹ️' ); ?>>ℹ️ <?php esc_html_e( 'Info', 'betting-theme-max' ); ?></option>
                </optgroup>
            </select>
        </label>
        
        <div style="margin-top: 10px;">
            <label for="edit-menu-item-media-icon-<?php echo $item_id; ?>">
                <strong><?php esc_html_e( 'Or Upload Custom Icon', 'betting-theme-max' ); ?></strong><br />
                <input type="hidden" name="menu-item-media-icon[<?php echo $item_id; ?>]" id="edit-menu-item-media-icon-<?php echo $item_id; ?>" value="<?php echo esc_attr( $menu_item_media_icon ); ?>" />
                <input type="text" id="edit-menu-item-media-icon-url-<?php echo $item_id; ?>" value="<?php echo $menu_item_media_icon ? wp_get_attachment_url( $menu_item_media_icon ) : ''; ?>" readonly style="width: 70%; margin-right: 10px;" placeholder="<?php esc_attr_e( 'No icon selected', 'betting-theme-max' ); ?>" />
                <button type="button" class="button menu-media-upload-simple" data-item-id="<?php echo $item_id; ?>">
                    <?php esc_html_e( 'Browse', 'betting-theme-max' ); ?>
                </button>
                <?php if ( $menu_item_media_icon ) : ?>
                    <button type="button" class="button menu-media-remove" data-item-id="<?php echo $item_id; ?>" style="margin-left: 5px;"><?php esc_html_e( 'Remove', 'betting-theme-max' ); ?></button>
                <?php endif; ?>
            </label>
            
            <div id="media-icon-preview-<?php echo $item_id; ?>" style="margin-top: 5px;">
                <?php if ( $menu_item_media_icon ) : 
                    $attachment = wp_get_attachment_image_src( $menu_item_media_icon, 'thumbnail' );
                    if ( $attachment ) : ?>
                        <img src="<?php echo esc_url( $attachment[0] ); ?>" style="max-width: 50px; max-height: 50px; display: block;" />
                    <?php endif;
                endif; ?>
            </div>
        </div>
        
        <div class="icon-preview" style="margin-top: 5px; font-size: 14px; color: #666;">
            <span id="icon-preview-<?php echo $item_id; ?>">
                <?php if ( $menu_item_icon ) : ?>
                    <?php if ( strpos( $menu_item_icon, 'svg:' ) === 0 ) : ?>
                        <?php 
                        $svg_filename = str_replace( 'svg:', '', $menu_item_icon );
                        echo betting_theme_max_get_svg_content( $svg_filename );
                        ?>
                    <?php else : ?>
                        <?php echo $menu_item_icon; ?>
                    <?php endif; ?>
                <?php endif; ?>
            </span>
        </div>
    </div>
    <?php
}
add_action( 'wp_nav_menu_item_custom_fields', 'betting_theme_max_menu_item_custom_fields', 10, 4 );

/**
 * Save custom menu item fields
 */
function betting_theme_max_save_menu_item_custom_fields( $menu_id, $menu_item_db_id ) {
    if ( isset( $_POST['menu-item-icon'][$menu_item_db_id] ) ) {
        $icon_value = sanitize_text_field( $_POST['menu-item-icon'][$menu_item_db_id] );
        if ( empty( $icon_value ) ) {
            delete_post_meta( $menu_item_db_id, '_menu_item_icon' );
        } else {
            update_post_meta( $menu_item_db_id, '_menu_item_icon', $icon_value );
        }
    }
    
    if ( isset( $_POST['menu-item-media-icon'][$menu_item_db_id] ) ) {
        $media_icon_value = absint( $_POST['menu-item-media-icon'][$menu_item_db_id] );
        if ( empty( $media_icon_value ) ) {
            delete_post_meta( $menu_item_db_id, '_menu_item_media_icon' );
        } else {
            update_post_meta( $menu_item_db_id, '_menu_item_media_icon', $media_icon_value );
        }
    }
}
add_action( 'wp_update_nav_menu_item', 'betting_theme_max_save_menu_item_custom_fields', 10, 2 );

/**
 * Enqueue media scripts on nav-menus page
 */
function betting_theme_max_nav_menu_media_scripts( $hook ) {
    // Only load on nav-menus page
    if ( 'nav-menus.php' !== $hook ) {
        return;
    }
    
    // Enqueue WordPress media uploader
    wp_enqueue_media();
    
    // Enqueue custom admin CSS
    wp_enqueue_style(
        'betting-theme-menu-icons',
        get_template_directory_uri() . '/assets/css/admin-menu-icons.css',
        array(),
        '1.0.0'
    );
    
    // Enqueue custom admin script
    wp_enqueue_script(
        'betting-theme-menu-icons',
        get_template_directory_uri() . '/assets/js/admin-menu-icons.js',
        array( 'jquery', 'media-upload', 'media-views' ),
        '1.0.0',
        true
    );
}
add_action( 'admin_enqueue_scripts', 'betting_theme_max_nav_menu_media_scripts' );
