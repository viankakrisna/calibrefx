<?php 
/**
 * Reset calibrefx_admin_menu
 */
function calibrefx_clear_admin_menu() {
    global $calibrefx_admin_menu;
    unset($calibrefx_admin_menu);

    if (!isset($calibrefx_admin_menu))
        $calibrefx_admin_menu = array();
}

/**
 * calibrefx_add_admin_menu
 * 
 * Add menu in top admin menu
 * 
 * @param type $menu_title
 * @param type $capability
 * @param type $menu_slug
 * @param type $url
 */
function calibrefx_add_admin_menu($menu_title, $capability, $menu_slug, $url) {
    global $calibrefx_admin_menu;
    
    $calibrefx_admin_menu[$menu_slug] = array(
        'slug' => $menu_slug,
        'capability' => $capability,
        'title' => $menu_title,
        'url' => $url,
        'submenu' => array(),
    );
}

/**
 * calibrefx_add_admin_submenu
 * 
 * Add submenu in top menu admin menu
 * 
 * @param type $parent_slug
 * @param type $menu_title
 * @param type $capability
 * @param type $menu_slug
 * @param type $url
 */
function calibrefx_add_admin_submenu($parent_slug, $menu_title, $capability, $menu_slug, $url) {
    global $calibrefx_admin_menu;
    
    $calibrefx_admin_menu[$parent_slug]["submenu"][$menu_slug] = array(
        'slug' => $menu_slug,
        'capability' => $capability,
        'title' => $menu_title,
        'url' => $url,
    );
}

/**
 * Add Menu Separator
 */
function calibrefx_add_admin_menu_separator($position) {
  global $menu;
  $index = 0;
  foreach($menu as $offset => $section) {
    if (substr($section[2],0,9)=='separator')
      $index++;
    if ($offset>=$position) {
      $menu[$position] = array('','read',"separator{$index}",'','wp-menu-separator');
      break;
    }
  }
  ksort( $menu );
}

/**
 *  Output a body class for Calibrefx Admin Area
 */
function calibrefx_admin_body_class($classes){
  $screen = get_current_screen();
  if (strpos($screen->id,'calibrefx') !== false) {
    $classes .= ' calibrefx-admin-page';
  }

  return $classes;
}