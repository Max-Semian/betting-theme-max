<?php
/**
 * The header for our theme
 *
 * @package Betting_Theme_Max
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'betting-theme-max' ); ?></a>

    <header id="masthead" class="site-header">
        <div class="header-container">
            <!-- Logo -->
            <div class="site-branding">
                <?php if ( has_custom_logo() ) : ?>
                    <div class="custom-logo-wrapper">
                        <?php the_custom_logo(); ?>
                    </div>
                <?php else : ?>
                    <div class="site-title">
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                            <?php bloginfo( 'name' ); ?>
                        </a>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Main Navigation -->
            <nav id="site-navigation" class="main-navigation">
                <?php
                wp_nav_menu(
                    array(
                        'theme_location' => 'primary',
                        'menu_id'        => 'primary-menu',
                        'container'      => false,
                        'menu_class'     => 'primary-menu',
                        'fallback_cb'    => false,
                        'walker'         => new Betting_Theme_Walker_Nav_Menu(),
                    )
                );
                ?>
            </nav>

            <!-- Header Actions -->
            <div class="header-actions">
                <!-- Registration Button -->
                <a href="<?php echo esc_url( get_theme_mod( 'registration_url', '#register' ) ); ?>" class="btn-registration">
                    <span><?php esc_html_e( 'Registration', 'betting-theme-max' ); ?></span>
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/User-icon.png" alt="<?php esc_attr_e( 'App Icon', 'betting-theme-max' ); ?>">

                </a>

                <!-- Promotions Button -->
                <a href="<?php echo esc_url( get_theme_mod( 'promotions_url', '#promotions' ) ); ?>" class="btn-promotions">
                    
                    <span><?php esc_html_e( 'Application', 'betting-theme-max' ); ?></span>
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/Cloud-icon.png" alt="<?php esc_attr_e( 'App Icon', 'betting-theme-max' ); ?>">
                </a>
            </div>

            <!-- Mobile Menu Toggle -->
            <button class="mobile-menu-toggle" aria-controls="primary-menu" aria-expanded="false">
                <span class="hamburger-icon">
                    <span></span>
                    <span></span>
                    <span></span>
                </span>
            </button>
        </div>
    </header>

    <div id="content" class="site-content">
