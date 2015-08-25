<?php
/**
 * Calibrefx Header Hooks
 *
 */

global $calibrefx;

$calibrefx->hooks->template_redirect = array(
	array( 'function' => 'calibrefx_submit_handler', 'priority' => 99 ),
);

$calibrefx->hooks->wp_head = array(
	array( 'function' => 'calibrefx_print_wrap', 'priority' => 10 ),
	array( 'function' => 'calibrefx_header_scripts', 'priority' => 30 ),
	array( 'function' => 'calibrefx_header_custom_styles', 'priority' => 30 ),
);

$calibrefx->hooks->calibrefx_meta = array(
	array( 'function' => 'calibrefx_do_meta', 'priority' => 10 ),
	array( 'function' => 'calibrefx_do_link_author', 'priority' => 10 ),
	array( 'function' => 'calibrefx_do_fb_og', 'priority' => 10 ),
);

$calibrefx->hooks->calibrefx_do_header = array(
	array( 'function' => 'calibrefx_do_header', 'priority' => 10 )
);

$calibrefx->hooks->calibrefx_site_title = array(
	array( 'function' => 'calibrefx_do_site_title', 'priority' => 10 ),
);

$calibrefx->hooks->calibrefx_site_description = array(
	array( 'function' => 'calibrefx_do_site_description', 'priority' => 10 ),
);

$calibrefx->hooks->calibrefx_header = array(
	array( 'function' => 'calibrefx_header_area', 'priority' => 10 ),
);

$calibrefx->hooks->calibrefx_header_right_widget = array(
	array( 'function' => 'calibrefx_do_header_right_widget', 'priority' => 10 ),
);

/**
 * Handle form submit from contact form
 */
function calibrefx_submit_handler() {
	global $calibrefx;

	if ( ! $_POST OR ! isset( $_POST['action'] ) ) { return; }

	$action = sanitize_text_field( $_POST['action'] );

	do_action( "calibrefx_submit_{$action}_handler" );
	do_action( 'calibrefx_submit_handler' );
}

/**
 * Print meta description and keywords, get from blog description
 * Will be override by seo addon later
 *
 * @todo Add compatibility with seo plugin
 */
function calibrefx_do_meta() {
	echo '<meta name="description" content="' . calibrefx_meta_description() . '" />' . "\n";

	$keywords = apply_filters( 'calibrefx_do_meta_keywords', '' );

	// Add the description, but only if one exists
	if ( ! empty( $keywords ) ) {
		echo '<meta name="keywords" content="' . esc_attr( $keywords ) . '" />' . "\n";
	}
}

/**
 * Print meta keywords
 * Will be override by seo addon later
 */
function calibrefx_do_link_author() {
	$link_author = apply_filters( 'calibrefx_do_link_author', '' );
	$link_publisher = apply_filters( 'calibrefx_do_link_publisher', '' );

	// Add the description, but only if one exists
	if ( ! empty( $link_author ) ) {
		echo '<link rel="author" content="' . esc_attr( $link_author ) . '" />' . "\n";
	}

	// Add the description, but only if one exists
	if ( ! empty( $link_author ) ) {
		echo '<link rel="publisher" content="' . esc_attr( $link_publisher ) . '" />' . "\n";
	}
}

/**
 * This function adds dublin core meta in header
 */
function calibrefx_do_fb_og() {

	// Add compatibilty with other plugins
	$conflicting_plugins = array(
		'facebook/facebook.php',                                                        // Official Facebook plugin
		'wordpress-seo/wp-seo.php',                                                     // WordPress SEO by Yoast
		'add-link-to-facebook/add-link-to-facebook.php',                                // Add Link to Facebook
		'facebook-awd/AWD_facebook.php',                                                // Facebook AWD All in one
		'header-footer/plugin.php',                                                     // Header and Footer
		'nextgen-facebook/nextgen-facebook.php',                                        // NextGEN Facebook OG
		'seo-facebook-comments/seofacebook.php',                                        // SEO Facebook Comments
		'seo-ultimate/seo-ultimate.php',                                                // SEO Ultimate
		'sexybookmarks/sexy-bookmarks.php',                                             // Shareaholic
		'shareaholic/sexy-bookmarks.php',                                               // Shareaholic
		'social-discussions/social-discussions.php',                                    // Social Discussions
		'social-networks-auto-poster-facebook-twitter-g/NextScripts_SNAP.php',          // NextScripts SNAP
		'wordbooker/wordbooker.php',                                                    // Wordbooker
		'socialize/socialize.php',                                                      // Socialize
		'simple-facebook-connect/sfc.php',                                              // Simple Facebook Connect
		'social-sharing-toolkit/social_sharing_toolkit.php',                            // Social Sharing Toolkit
		'wp-facebook-open-graph-protocol/wp-facebook-ogp.php',                          // WP Facebook Open Graph protocol
		'opengraph/opengraph.php',                                                      // Open Graph
		'sharepress/sharepress.php',                                                    // SharePress
		'wp-facebook-like-send-open-graph-meta/wp-facebook-like-send-open-graph-meta.php',  // WP Facebook Like Send & Open Graph Meta
		'network-publisher/networkpub.php',                         // Network Publisher
		'wp-ogp/wp-ogp.php',                                    // WP-OGP
		'open-graph-protocol-framework/open-graph-protocol-framework.php',          // Open Graph Protocol Framework
		'all-in-one-seo-pack/all_in_one_seo_pack.php',                      // All in One SEO Pack
		'facebook-featured-image-and-open-graph-meta-tags/fb-featured-image.php',       // Facebook Featured Image & OG Meta Tags
	);

	$active_plugins = get_option( 'active_plugins', array() );

	foreach ( $conflicting_plugins as $plugin ) {
		if ( in_array( $plugin, $active_plugins ) ) {
			return;
		}
	}

	echo '<meta property="locale" content="' . calibrefx_meta_locale() . '" />'."\n";
	echo '<meta property="og:site_name" content="' . get_bloginfo( 'name' ) . '" />'."\n";
	if ( calibrefx_get_option( 'facebook_admins' ) ) { echo '<meta property="fb:admins" content="' . calibrefx_get_option( 'facebook_admins' ) . '" />'."\n"; }
	if ( calibrefx_get_option( 'facebook_og_type' ) ) { echo '<meta property="og:type" content="' . calibrefx_get_option( 'facebook_og_type' ) . '" />'."\n"; }
	echo '<meta property="og:title" content="' . calibrefx_meta_title() . '" />'."\n";
	echo '<meta property="og:url" content="' . calibrefx_meta_url() . '" />'."\n";
	echo '<meta property="og:description" content="' . calibrefx_meta_description() . '" />'."\n";
	$image = calibrefx_meta_image();
	if ( $image ) {
		echo '<meta property="og:image" content="' . $image . '" />'."\n";
	}

	do_action( 'calibrefx_do_another_fb_og' );
}

/**
 * Print .wrap style
 */
function calibrefx_print_wrap() {
	$wrap = '';
	$body = '';

	// if using fluid layout then do nothing
	if ( calibrefx_layout_is_fluid() ){
		return;
	}

	if ( ! current_theme_supports( 'calibrefx-responsive-style' ) ){
		$body = sprintf('
body{
	min-width: %1dpx;
}', calibrefx_get_option( 'calibrefx_layout_width' ) );

	}

	if ( current_theme_supports( 'calibrefx-responsive-style' ) ) {
		$wrap = sprintf('
.layout-wrapper-fluid .container, 
.layout-wrapper-fixed #wrapper {
max-width: %dpx;
}', calibrefx_get_option( 'calibrefx_layout_width' ) );

	} else {
		$wrap = sprintf('
.layout-wrapper-fluid .container, 
.layout-wrapper-fixed #wrapper {
	max-width: none;
	width: %dpx;
}', calibrefx_get_option( 'calibrefx_layout_width' ) );

	}

	printf( '<style type="text/css">%1$s %2$s'."\n".'</style>'."\n", $body, $wrap );
}

/**
 * Echo the header scripts, defined in Theme Settings.
 */
function calibrefx_header_scripts() {
	echo apply_filters( 'calibrefx_header_scripts', cap_attr( calibrefx_get_option( 'header_scripts' ) ) );
}

/**
 * Echo the header custom styles, defined in Theme Settings.
 */
function calibrefx_header_custom_styles() {
	$custom_css = stripslashes( calibrefx_get_option( 'custom_css' ) );
	if ( ! empty($custom_css) ) {
		printf( '<style type="text/css">%1$s</style>', apply_filters( 'calibrefx_header_custom_styles', $custom_css ) ); }

	// If singular, echo scripts from custom field
	if ( is_singular() ) {
		printf( '<style type="text/css">%1$s</style>', calibrefx_custom_field( '_calibrefx_custom_styles' ) );
	}
}

/**
 * Echo the site title into the #header.
 *
 */
function calibrefx_do_site_title() {

	// Set what goes inside the wrapping tags
	$inside = sprintf( '<a href="%s" title="%s" class="site-title">%s</a>', trailingslashit( home_url() ), esc_attr( get_bloginfo( 'name' ) ), get_bloginfo( 'name' ) );

	// Build the Title
	if ( is_home() ||is_front_page() ) {
		$title = sprintf( '<h1 id="title" class="site-title">%s</h1>', $inside );
	} else {
		$title = sprintf( '<h2 id="title" class="site-title">%s</h2>', $inside );
	}

	echo apply_filters( 'calibrefx_title', $title, $inside, $wrap = '' );
}


/**
 * Echo the site description into the #header.
 *
 */
function calibrefx_do_site_description() {
	// Set what goes inside the wrapping tags
	$inside = esc_html( get_bloginfo( 'description' ) );

	// Determine which wrapping tags to use
	$wrap = 'p';

	// Build the Description
	$description = $inside ? sprintf( '<%s id="description" class="site-description">%s</%s>', $wrap, $inside, $wrap ) : '';

	// Return (filtered)
	echo apply_filters( 'calibrefx_description', $description, $inside, $wrap );
}

/**
 * Markup the header area
 */
function calibrefx_header_area() {
	echo '<div id="header">';
	calibrefx_put_wrapper( 'header', 'open' );
	do_action( 'calibrefx_do_header' );
	calibrefx_put_wrapper( 'header', 'close' );
	echo '</div><!--end #header-->';
}

/**
 * Do Header Callback
 */
function calibrefx_do_header() {
	$header_title_class = apply_filters( 'header_title_class', 'pull-left', '' );
	echo '<div id="header-title" class="' . $header_title_class . '">';
	do_action( 'calibrefx_site_title' );
	do_action( 'calibrefx_site_description' );
	echo '</div><!-- end #header-title -->';
	$header_right_widget = current_theme_supports( 'calibrefx-header-right-widgets' );
	$header_right_class = apply_filters( 'header_right_class', 'pull-right', '' );

	if ( $header_right_widget ) {
		echo '<div id="header-right" class="' . $header_right_class . '">';
		do_action( 'calibrefx_header_right_widget' );
		echo '</div><!-- end #header-right -->';
	}
}

/**
 * Print header right widget
 */
function calibrefx_do_header_right_widget() {
	if ( is_active_sidebar( 'header-right' ) ) {
		dynamic_sidebar( 'header-right' );
	}
}


/**
 * Filter the feed URI if the user has input a custom feed URI.
 */
function calibrefx_feed_links_filter( $output, $feed ) {
	$feed_uri = calibrefx_get_option( 'feed_uri' );
	$comments_feed_uri = calibrefx_get_option( 'comments_feed_uri' );

	if ( $feed_uri && ! strpos( $output, 'comments' ) && ( '' == $feed || 'rss2' == $feed || 'rss' == $feed || 'rdf' == $feed || 'atom' == $feed ) ) {
		$output = esc_url( $feed_uri );
	}

	if ( $comments_feed_uri && strpos( $output, 'comments' ) ) {
		$output = esc_url( $comments_feed_uri );
	}

	return $output;
}
add_filter( 'feed_link', 'calibrefx_feed_links_filter', 10, 2 );
