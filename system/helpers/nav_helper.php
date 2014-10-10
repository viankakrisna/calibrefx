<?php 
/**
 * Calibrefx Navigation Helper
 *
 */

/**
 * Check if the nav menu is supported by the child themes
 */
function calibrefx_nav_menu_supported( $menu ) {

    if ( !current_theme_supports( 'calibrefx-menus' ) ) {
        return false;
    }

    $menus = get_theme_support( 'calibrefx-menus' );

    if ( array_key_exists( $menu, (array) $menus[0]) ) {
        return true;
    }

    return false;
}