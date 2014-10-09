<?php 

/**
 *  Output a body class for Calibrefx Admin Area
 */
function calibrefx_admin_body_class( $classes ) {
  $screen = get_current_screen();
  if (strpos( $screen->id,'calibrefx' ) !== false ) {
    $classes .= ' calibrefx-admin-page';
  }

  return $classes;
}