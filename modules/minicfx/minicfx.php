<?php
/**
 * Calibrefx Mobile Helper
 *
 */

/**
 * calibrefx_get_mobile_template
 * this function will return the mobile folder from the child themes folder
 * this will use in add_filter 'template_directory'
 **/
function calibrefx_get_mobile_template( $template ) {
	//TODO: This code need review
	$mobile_template = str_replace( CHILD_URI, CHILD_MOBILE_URI, $template );
	
	if ( file_exists( $mobile_template ) ) {
		return $mobile_template;
	} else {
		return $template;
	}
}

function calibrefx_mobile_scripts(){
	if( wp_is_mobile() ){
		wp_enqueue_style( 'jquery.mobile', CALIBREFX_MODULE_URL . '/minicfx/theme/assets/css/jquery-mobile.min.css' );
		wp_enqueue_style( 'jquery.mobile.style', CALIBREFX_MODULE_URL . '/minicfx/theme/style.css' );
		wp_enqueue_script( 'jquery.mobile', CALIBREFX_MODULE_URL . '/minicfx/theme/assets/js/jquery-mobile.js', array( 'jquery' )  );
		wp_enqueue_script( 'function.mobile', CALIBREFX_MODULE_URL . '/minicfx/theme/assets/js/function-mobile.js', array( 'jquery', 'jquery.mobile' )  );
	}
}
add_action( 'wp_enqueue_scripts', 'calibrefx_mobile_scripts' );

/**
 * If mobile site is enable and there is a mobile template, then display mobile layout on mobile
 */
function calibrefx_init_mobile_site() {
	global $calibrefx; 

	//Register mobile menu
	register_nav_menus( 
		array ( 'mobile' => apply_filters( 'mobile_menu_text', __( 'Mobile Navigation Menu', 'calibrefx' ) ) )
	);

	if( is_admin() OR ! wp_is_mobile() ) {
		return;
	}

	add_filter( 'body_class', 'calibrefx_mobile_site_body_class' );

	remove_action( 'calibrefx_after_header', 'calibrefx_do_nav' );
	remove_action( 'calibrefx_after_header', 'calibrefx_do_subnav', 15 );

	add_action( 'calibrefx_before_header', 'calibrefx_do_top_mobile_nav' );
	add_action( 'calibrefx_before_wrapper', 'calibrefx_mobile_open_nav' );
	add_action( 'calibrefx_after_wrapper', 'calibrefx_mobile_close_nav' );

	add_filter( 'template_include', 'calibrefx_get_mobile_template' );
}
add_action( 'calibrefx_post_init', 'calibrefx_init_mobile_site', 15 );

/**
 * calibrefx_mobile_site_body_class
 * Add special body class on mobile view
 * 
 * @param  array $body_classes 
 * @return array
 */
function calibrefx_mobile_site_body_class( $body_classes ) {
	
	$body_classes[] = apply_filters( 'calibrefx_mobile_body_class', 'mobile-site' );

	return $body_classes;
}

/**
 * Show mobile menu navigation
 */
function calibrefx_do_top_mobile_nav() {
	?>

	<div id="top-mobile-nav" class="navbar navbar-default">
		<div class="mobile-header-top">
			<a href="#m" class="mobile-main-menu"> <i class="icon-mobile-planning"></i> Menu</a>
		</div>
	</div>
	<?php
}

/**
 * Fill the mobile menu
 */
function calibrefx_mobile_open_nav() {
	?>
	<div id="super-wrapper">
		<div class="mobile-sidebar">
			<?php calibrefx_do_mobile_nav(); ?>
		</div>

	<?php
}


function calibrefx_mobile_close_nav() {
	?>
	</div>
	<?php
}

/**
 * Show the mobile special menu 
 */
function calibrefx_do_mobile_nav() {
	global $calibrefx;

	$calibrefx->load->library( 'walker_nav_menu' );

	$nav = '';
	$args = '';

	//@TODO: This need to be a settings from the menu. Right now it is hardcoded
	$args = array(
		'theme_location' => 'mobile',
		'container' => '',
		'menu_class' => calibrefx_get_option( 'nav_fixed_top' ) ? 'navbar navbar-default navbar-fixed-top menu-primary menu ' : 'nav navbar-nav menu-primary menu ',
		'echo' => 0,
		'walker' => $calibrefx->walker_nav_menu,
	);

	$nav = wp_nav_menu( $args );

	$nav_class = apply_filters( 'nav_class', calibrefx_row_class() );

	$nav_output = sprintf( '
		<div id="mobile-nav" class="navbar navbar-default">
			 %1$s
		</div>
		<!-- end #mobile-nav -->', $nav );

	echo apply_filters( 'calibrefx_do_nav', $nav_output, $nav, $args );

}

/**
 * calibrefx_mobile_themes_exist
 * Check if the mobile theme exist in Child themes
 **/
function calibrefx_mobile_themes_exist() {
	return file_exists( CHILD_MOBILE_URI );
}
