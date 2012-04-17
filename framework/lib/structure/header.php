<?php
/**
 * CalibreFx
 *
 * WordPress Themes Framework by CalibreWorks Team
 *
 * @package		CalibreFx
 * @author		CalibreWorks Team
 * @copyright	Copyright (c) 2012, Suntech Inti Perkasa.
 * @license		Commercial
 * @link		http://calibrefx.com
 * @since		Version 1.0
 * @filesource 
 *
 * WARNING: This file is part of the core CalibreFx framework. DO NOT edit
 * this file under any circumstances. 
 *
 * This file hold all the function to handle the headers
 *
 * @package CalibreFx
 */
 
/**
 * Adds header structures.
 *
 * @package CalibreFx
 */

add_action( 'calibrefx_doctype', 'calibrefx_print_doctype' );
/**
 * This function handles the doctype. Default HTML5.
 */
function calibrefx_print_doctype() {

?>
<!doctype html>
<!--[if lt IE 7 ]> <html class="ie ie6 no-js" lang="<?php bloginfo( 'language' ); ?>"> <![endif]-->
<!--[if IE 7 ]>    <html class="ie ie7 no-js" lang="<?php bloginfo( 'language' ); ?>"> <![endif]-->
<!--[if IE 8 ]>    <html class="ie ie8 no-js" lang="<?php bloginfo( 'language' ); ?>"> <![endif]-->
<!--[if IE 9 ]>    <html class="ie ie9 no-js" lang="<?php bloginfo( 'language' ); ?>"> <![endif]-->
<!--[if gt IE 9]><!--><html class="no-js" lang="<?php bloginfo( 'language' ); ?>"><!--<![endif]-->
<!-- the "no-js" class is for Modernizr. -->
<head id="<?php echo calibrefx_get_site_url(); ?>" data-template-set="html5-reset">
	<meta http-equiv="Content-Type" content="<?php bloginfo( 'html_type' ); ?>; charset=<?php bloginfo( 'charset' ); ?>" />
	<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame -->
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<?php
}

add_action( 'get_header', 'calibrefx_doc_head_control' );
/**
 * Remove unnecessary code that WordPress puts in the <head>
 */
function calibrefx_doc_head_control() {

	remove_action( 'wp_head', 'wp_generator' );
}

add_action('calibrefx_title', 'wp_title');
add_filter('wp_title', 'calibrefx_do_title');
/**
 * Print html title, this will override by seo addon later
 */
function calibrefx_do_title(){
	return get_bloginfo('name');
}

add_filter( 'wp_title', 'calibrefx_do_title_wrap', 20 );
/**
 * Wraps the html doc title in <title></title> tags.
 *
 * @param string $title
 * @return string Plain text or HTML markup
 */
function calibrefx_do_title_wrap( $title ) {
	return is_feed() || is_admin() ? $title : sprintf( "<title>%s</title>\n", $title );
}

add_action('calibrefx_meta', 'calibrefx_do_meta_description');
/**
 * Print meta description, get from blog description
 * Will be override by seo addon later
 */
function calibrefx_do_meta_description(){
	$description = get_bloginfo( 'description' );
	
	// Add the description, but only if one exists
	if ( ! empty( $description ) ) {
		echo '<meta name="description" content="' . esc_attr( $description ) . '" />' . "\n";
	}
}

add_action( 'calibrefx_meta', 'calibrefx_print_favicon' );
/**
 * Print outs favicon
 */
function calibrefx_print_favicon() {

	//allow overriding
	$pre = apply_filters( 'calibrefx_pre_load_favicon', false );

	if ( $pre !== false )
		$favicon = $pre;
	elseif ( file_exists( CALIBREFX_IMAGES_DIR . '/ico/favicon.ico' ) )
		$favicon = CALIBREFX_IMAGES_URL . '/favicon.ico';
	else
		$favicon = CALIBREFX_IMAGES_URL . '/favicon.ico';
		
	//Check if child themes have the favicon.ico
	if ( file_exists( CALIBREFX_IMAGES_DIR . '/ico/favicon.ico' ) )
		$favicon = CALIBREFX_IMAGES_URL . '/favicon.ico';
	else
		$favicon = CALIBREFX_IMAGES_URL . '/favicon.ico';
		
	$favicon = apply_filters( 'calibrefx_favicon_url', $favicon );

	if ( $favicon )
		echo '<link rel="Shortcut Icon" href="' . esc_url( $favicon ) . '" type="image/x-icon" />' . "\n";

}

add_action( 'calibrefx_meta', 'calibrefx_print_media57_icon' );
/**
 * Print outs media icon for apple touch 57x57x in pixels
 */
function calibrefx_print_media57_icon() {

	//allow overriding
	$pre = apply_filters( 'calibrefx_pre_load_media57_icon', false );

	if ( $pre !== false )
		$media57 = $pre;
	elseif ( file_exists( CALIBREFX_IMAGES_DIR . '/ico/media-57x57.png' ) )
		$media57 = CALIBREFX_IMAGES_URL . '/ico/media-57x57.png';
	else
		$media57 = CALIBREFX_IMAGES_URL . '/media-57x57.png';

	$media57 = apply_filters( 'calibrefx_media57_url', $media57 );

	if ( $media57 )
		echo '<link rel="apple-touch-icon" href="' . esc_url( $media57 ) . '"/>' . "\n";

}

add_action( 'calibrefx_meta', 'calibrefx_print_media72_icon' );
/**
 * Print outs media icon for apple touch 72x72 pixels
 */
function calibrefx_print_media72_icon() {

	//allow overriding
	$pre = apply_filters( 'calibrefx_pre_load_media72_icon', false );

	if ( $pre !== false )
		$media72 = $pre;
	elseif ( file_exists( CALIBREFX_IMAGES_DIR . '/ico/media-72x72.png' ) )
		$media72 = CALIBREFX_IMAGES_URL . '/ico/media-72x72.png';
	else
		$media72 = CALIBREFX_IMAGES_URL . '/media-72x72.png';

	$media72 = apply_filters( 'calibrefx_media72_url', $media72 );

	if ( $media72 )
		echo '<link rel="apple-touch-icon" sizes="72x72" href="' . esc_url( $media72 ) . '"/>' . "\n";

}

add_action( 'calibrefx_meta', 'calibrefx_print_media114_icon' );
/**
 * Print outs media icon for apple touch 114x114 pixels
 */
function calibrefx_print_media114_icon() {

	//allow overriding
	$pre = apply_filters( 'calibrefx_pre_load_media114_icon', false );

	if ( $pre !== false )
		$media114 = $pre;
	elseif ( file_exists( CALIBREFX_IMAGES_DIR . '/ico/media-72x72.png' ) )
		$media114 = CALIBREFX_IMAGES_URL . '/ico/media-72x72.png';
	else
		$media114 = CALIBREFX_IMAGES_URL . '/media-72x72.png';

	$media114 = apply_filters( 'calibrefx_media114_url', $media114 );

	if ( $media114 )
		echo '<link rel="apple-touch-icon" sizes="114x114" href="' . esc_url( $media114 ) . '"/>' . "\n";

}

//always load the child theme stylesheet at the end for overriding
add_action('calibrefx_meta', 'calibrefx_load_stylesheet'); 
/**
 * This function loads the stylesheet.
 * If a child theme is active, it loads the child theme's stylesheet.
 *
 */
function calibrefx_load_stylesheet() {
	wp_enqueue_style('calibrefx-child-style', get_bloginfo('stylesheet_url'));
}

add_action( 'after_setup_theme', 'calibrefx_custom_header' );
/**
 * This function will activate the custom header image from WordPress
 *
 * It gets arguments passed through add_theme_support(), defines the constants,
 * and calls add_custom_image_header().
 *
 * @return void
 */
function calibrefx_custom_header() {

	$custom_header = get_theme_support('calibrefx-custom-header');

	/** If not active, do nothing */
	if ( ! $custom_header )
		return;

	/** Blog title option is obsolete when custom header is active */
	add_filter( 'calibrefx_pre_get_option_blog_title', '__return_empty_array' );

	/** Cast, if necessary */
	$custom_header = isset( $custom_header[0] ) && is_array( $custom_header[0] ) ? $custom_header[0] : array( );

	/** Merge defaults with passed arguments */
	$args = wp_parse_args( $custom_header, array(
		'width'                 => 960,
		'height'                => 80,
		'textcolor'             => '333333',
		'no_header_text'        => false,
		'header_image'          => '%s/header.png',
		'header_callback'       => 'calibrefx_custom_header_style',
		'admin_header_callback' => 'calibrefx_custom_header_admin_style'
	) );

	/** Define all the constants */
	if ( !defined( 'HEADER_IMAGE_WIDTH' ) && is_numeric( $args['width'] ) )
		define( 'HEADER_IMAGE_WIDTH', $args['width'] );

	if ( !defined( 'HEADER_IMAGE_HEIGHT' ) && is_numeric( $args['height'] ) )
		define( 'HEADER_IMAGE_HEIGHT', $args['height'] );

	if ( !defined( 'HEADER_TEXTCOLOR' ) && $args['textcolor'] )
		define( 'HEADER_TEXTCOLOR', $args['textcolor'] );

	if ( !defined( 'NO_HEADER_TEXT' ) && $args['no_header_text'] )
		define( 'NO_HEADER_TEXT', $args['no_header_text'] );

	if ( !defined( 'HEADER_IMAGE' ) && $args['header_image'] )
		define( 'HEADER_IMAGE', sprintf( $args['header_image'], apply_filters('calibrefx_images_url', CALIBREFX_IMAGES_URL) ) );

	/** Activate Custom Header */
	add_custom_image_header( $args['header_callback'], $args['admin_header_callback'] );

}

/**
 * Header callback. It outputs special CSS to the document
 * head, modifying the look of the header based on user input.
 *
 */
function calibrefx_custom_header_style() {
	/** If no options set, don't waste the output. Do nothing. */
	if ( HEADER_TEXTCOLOR == get_header_textcolor() && HEADER_IMAGE == get_header_image())
		return;
	
	$header = sprintf( '#header { background: url(%s) no-repeat; width:%dpx; height: %dpx}', esc_url( get_header_image() ), HEADER_IMAGE_WIDTH,  HEADER_IMAGE_HEIGHT );
	$text = sprintf( '#title a, #title a:hover, #description { color: #%s; }', esc_html( get_header_textcolor() ) );

	printf( '<style type="text/css">%1$s %2$s</style>', $header, $text );

}

/**
 * Header admin callback. It outputs special CSS to the admin
 * document head, modifying the look of the header area based on user input.
 *
 * Will probably need to be overridden in the child theme with a custom callback.
 */
function calibrefx_custom_header_admin_style() {

	$headimg = sprintf( '.appearance_page_custom-header #headimg { background: url(%s) no-repeat; min-height: %spx; }', get_header_image(), HEADER_IMAGE_HEIGHT );
	$h1 = sprintf( '#headimg h1, #headimg h1 a { color: #%s; font-size: 24px; font-weight: normal; line-height: 30px; margin: 20px 0 0; text-decoration: none; }', esc_html( get_header_textcolor() ) );
	$desc = sprintf( '#headimg #desc { color: #%s; font-size: 12px; font-style: italic; line-height: 1; margin: 0; }', esc_html( get_header_textcolor() ) );

	printf( '<style type="text/css">%1$s %2$s %3$s</style>', $headimg, $h1, $desc );

}

add_action('calibrefx_html_header', 'calibrefx_do_html_header');
/**
 * Print html header
 */
function calibrefx_do_html_header(){
	do_action('calibrefx_doctype');
	do_action('calibrefx_title');
	do_action('calibrefx_meta');
}

add_action( 'wp_head', 'calibrefx_do_meta_pingback' );
/**
 * This function adds the pingback meta tag to the <head> so that other
 * sites can know how to send a pingback to our site.
 */
function calibrefx_do_meta_pingback() {

	if ( 'open' == get_option( 'default_ping_status' ) ) {
		echo '<link rel="pingback" href="' . get_bloginfo( 'pingback_url' ) . '" />' . "\n";
	}

}

add_action( 'wp_head', 'calibrefx_header_scripts' );
/**
 * Echo the header scripts, defined in Theme Settings.
 */
function calibrefx_header_scripts() {

	echo apply_filters( 'calibrefx_header_scripts', calibrefx_get_option( 'header_scripts' ) );
	
	// If singular, echo scripts from custom field
	if ( is_singular() ) {
		calibrefx_custom_field( '_calibrefx_scripts' );
	}

}

add_action( 'wp_head', 'calibrefx_header_custom_styles' );
/**
 * Echo the header custom styles, defined in Theme Settings.
 */
function calibrefx_header_custom_styles() {

	$custom_css = calibrefx_get_option( 'custom_css' );
	if(!empty($custom_css))
		printf( '<style type="text/css">%1$s</style>', apply_filters( 'calibrefx_header_custom_styles', $custom_css ) );
	
	// If singular, echo scripts from custom field
	if ( is_singular() ) {
		printf( '<style type="text/css">%1$s</style>',  calibrefx_custom_field( '_calibrefx_custom_styles' ) );
	}

}

add_action('calibrefx_header', 'calibrefx_do_header_open',5);
/**
 * Open header markup
 */
function calibrefx_do_header_open(){
	echo '<div id="header" class="row">';
}

add_action('calibrefx_header', 'calibrefx_do_header_close',15);
/**
 * Close header markup
 */
function calibrefx_do_header_close(){
	echo '</div><!--end #header-->';
}

add_action( 'calibrefx_site_title', 'calibrefx_do_site_title' );
/**
 * Echo the site title into the #header.
 *
 */
function calibrefx_do_site_title() {

	// Set what goes inside the wrapping tags
	$inside = sprintf( '<a href="%s" title="%s">%s</a>', trailingslashit( home_url() ), esc_attr( get_bloginfo( 'name' ) ), get_bloginfo( 'name' ) );

	// Determine which wrapping tags to use
	$wrap = is_home() ? 'h1' : 'p';

	// Build the Title
	$title = sprintf( '<%s id="title">%s</%s>', $wrap, $inside, $wrap );

	// Echo (filtered)
	echo apply_filters( 'calibrefx_seo_title', $title, $inside, $wrap );

}

add_action( 'calibrefx_site_description', 'calibrefx_do_site_description' );
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
	$description = $inside ? sprintf( '<%s id="description">%s</%s>', $wrap, $inside, $wrap ) : '';

	// Return (filtered)
	echo apply_filters( 'genesis_seo_description', $description, $inside, $wrap );

}

add_action('calibrefx_header', 'calibrefx_do_header');
/**
 * Do Header Callback
 */
function calibrefx_do_header(){
	echo '<div id="header-title" class="pull-left">';
	do_action( 'calibrefx_site_title' );
	do_action( 'calibrefx_site_description' );
	echo '</div><!-- end #header-title -->';

	if ( is_active_sidebar( 'header-right' ) ) {
		echo '<div class="pull-right header-right">';
		do_action( 'calibrefx_header_right_widget' );
		dynamic_sidebar( 'header-right' );
		echo '</div><!-- end .widget-wrap -->';
	}
}

add_action( 'calibrefx_after_header', 'calibrefx_add_socials_script' );
function calibrefx_add_socials_script() {
	global $fbappid, $fbsecret, $twitteruser;
	
	$fbappid = calibrefx_get_option('facebook_app_id');
	$fbsecret = calibrefx_get_option('facebook_app_secret');
	$twitteruser = calibrefx_get_option('twitter_username');
	
	if(!empty($fbappid)){
		echo '<div id="fb-root"></div>';
		echo '<script type="text/javascript" src="http://connect.facebook.net/en_US/all.js"></script>';
		echo '<script type="text/javascript">FB.init({appId  : \''. $fbappid .'\',status : true, cookie : true, xfbml  : true, oauth: true  });';
		echo 'FB.Event.subscribe("auth.login", function(response) {
			  window.location.reload();
			});
			FB.Event.subscribe("auth.logout", function(response) {
			  window.location.reload();
			});';
		echo '</script>';
	}
	
	if(!empty($twitteruser)){
		echo '<script charset="utf-8" src="http://widgets.twimg.com/j/2/widget.js"></script>';
	}
}