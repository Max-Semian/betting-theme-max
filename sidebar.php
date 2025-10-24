<?php
/**
 * The sidebar containing the main widget area
 *
 * @package Betting_Theme_Max
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
    return;
}
?>

<aside id="secondary" class="widget-area">
    <?php dynamic_sidebar( 'sidebar-1' ); ?>
</aside>
