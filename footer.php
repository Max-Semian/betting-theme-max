<?php
/**
 * The template for displaying the footer
 *
 * @package Betting_Theme_Max
 */
?>

    </div><!-- #content -->

    <footer id="colophon" class="site-footer">
        <!-- Footer Menu Level -->
        <div class="footer-menu-section">
            <div class="footer-container">
                <nav class="footer-navigation">
                    <?php
                    wp_nav_menu(
                        array(
                            'theme_location' => 'footer',
                            'menu_id'        => 'footer-menu',
                            'container'      => false,
                            'menu_class'     => 'footer-menu',
                            'fallback_cb'    => false,
                        )
                    );
                    ?>
                </nav>
            </div>
        </div>

        <!-- Footer Main Level - Logo, Text & App Downloads -->
        <div class="footer-main-section">
            <div class="footer-container">
                <div class="footer-brand">
                    <?php if ( get_theme_mod( 'footer_logo' ) ) : ?>
                        <img src="<?php echo esc_url( get_theme_mod( 'footer_logo' ) ); ?>" alt="<?php bloginfo( 'name' ); ?>" class="footer-logo">
                    <?php else : ?>
                        <div class="footer-site-title"><?php bloginfo( 'name' ); ?></div>
                    <?php endif; ?>
                    
                    <?php if ( get_theme_mod( 'footer_text' ) ) : ?>
                        <p class="footer-description"><?php echo esc_html( get_theme_mod( 'footer_text' ) ); ?></p>
                    <?php endif; ?>
                </div>

                <div class="footer-apps">
                    <h3 class="footer-apps-title"><?php echo esc_html( get_theme_mod( 'footer_apps_title', 'Download the verified App' ) ); ?></h3>
                    <div class="app-buttons">
                        <?php if ( get_theme_mod( 'footer_ios_link' ) ) : ?>
                            <a href="<?php echo esc_url( get_theme_mod( 'footer_ios_link' ) ); ?>" class="app-btn app-btn-ios" target="_blank">
                                <span><?php echo esc_html( get_theme_mod( 'footer_ios_text', 'iOS' ) ); ?></span>
                            </a>
                        <?php endif; ?>
                        
                        <?php if ( get_theme_mod( 'footer_android_link' ) ) : ?>
                            <a href="<?php echo esc_url( get_theme_mod( 'footer_android_link' ) ); ?>" class="app-btn app-btn-android" target="_blank">
                                <span><?php echo esc_html( get_theme_mod( 'footer_android_text', 'Android' ) ); ?></span>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sub Footer - Copyright & Logos -->
        <div class="footer-sub-section">
            <div class="footer-container">
                <div class="footer-copyright">
                    <p><?php echo esc_html( get_theme_mod( 'footer_copyright', '© ' . date('Y') . ' ' . get_bloginfo( 'name' ) . '. All rights reserved.' ) ); ?></p>
                </div>
                
                <div class="footer-logos">
                    <?php for ( $i = 1; $i <= 5; $i++ ) : ?>
                        <?php if ( get_theme_mod( 'footer_logo_' . $i ) ) : ?>
                            <img src="<?php echo esc_url( get_theme_mod( 'footer_logo_' . $i ) ); ?>" alt="<?php echo esc_attr( get_theme_mod( 'footer_logo_' . $i . '_alt', 'Partner Logo ' . $i ) ); ?>" class="footer-partner-logo">
                        <?php endif; ?>
                    <?php endfor; ?>
                </div>
            </div>
        </div>
    </footer>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
