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
add_action('calibrefx_doctype', 'calibrefx_print_doctype');

/**
 * This function handles the doctype. Default HTML5.
 */
function calibrefx_print_doctype() {?>
<!doctype html>
<!--[if lt IE 7 ]> <html class="ie ie6 no-js" lang="<?php bloginfo('language'); ?>" <?php html_xmlns();?> <![endif]-->
<!--[if IE 7 ]>    <html class="ie ie7 no-js" lang="<?php bloginfo('language'); ?>" <?php html_xmlns();?>> <![endif]-->
<!--[if IE 8 ]>    <html class="ie ie8 no-js" lang="<?php bloginfo('language'); ?>" <?php html_xmlns();?>> <![endif]-->
<!--[if IE 9 ]>    <html class="ie ie9 no-js" lang="<?php bloginfo('language'); ?>" <?php html_xmlns();?>> <![endif]-->
<!--[if gt IE 9]><!--><html class="no-js" lang="<?php bloginfo('language'); ?>" <?php html_xmlns();?>><!--<![endif]-->
<!-- the "no-js" class is for Modernizr. -->
<head id="<?php echo calibrefx_get_site_url(); ?>" data-template-set="html5-reset">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame -->
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<meta name="viewport" content="width=device-width; initial-scale=1.0" />
<?php
}

add_action('get_header', 'calibrefx_doc_head_control');

/**
 * Remove unnecessary code that WordPress puts in the <head>
 */
function calibrefx_doc_head_control() {

    remove_action('wp_head', 'wp_generator');
}

add_action('calibrefx_title', 'wp_title');
add_filter('wp_title', 'calibrefx_do_title');

/**
 * Print html title, this will override by seo addon later
 */
function calibrefx_do_title() {
    return apply_filters('calibrefx_do_title', get_bloginfo('name'));
}

add_filter('wp_title', 'calibrefx_do_title_wrap', 20);

/**
 * Wraps the html doc title in <title></title> tags.
 *
 * @param string $title
 * @return string Plain text or HTML markup
 */
function calibrefx_do_title_wrap($title) {
    return is_feed() || is_admin() ? $title : sprintf("<title>%s</title>\n", $title);
}

add_action('calibrefx_meta', 'calibrefx_do_meta_description');

/**
 * Print meta description, get from blog description
 * Will be override by seo addon later
 */
function calibrefx_do_meta_description() {
    $description = apply_filters('calibrefx_do_meta_description', get_bloginfo('description'));

    // Add the description, but only if one exists
    if (!empty($description)) {
        echo '<meta name="description" content="' . esc_attr($description) . '" />' . "\n";
    }
}

add_action('calibrefx_meta', 'calibrefx_do_meta_keywords');

/**
 * Print meta keywords
 * Will be override by seo addon later
 */
function calibrefx_do_meta_keywords() {
    $keywords = apply_filters('calibrefx_do_meta_keywords', '');

    // Add the description, but only if one exists
    if (!empty($keywords)) {
        echo '<meta name="keywords" content="' . esc_attr($keywords) . '" />' . "\n";
    }
}

add_action('calibrefx_meta', 'calibrefx_print_favicon');

/**
 * Print outs favicon
 */
function calibrefx_print_favicon() {

    //allow overriding
    $pre = apply_filters('calibrefx_pre_load_favicon', false);

    if ($pre !== false)
        $favicon = $pre;
    elseif (file_exists(CALIBREFX_IMAGES_DIR . '/ico/favicon.ico'))
        $favicon = CALIBREFX_IMAGES_URL . '/ico/favicon.ico';
    else
        $favicon = CALIBREFX_IMAGES_URL . '/favicon.ico';

    //Check if child themes have the favicon.ico
    if (file_exists(CHILD_DIR . '/favicon.ico'))
        $favicon = CHILD_URL . '/favicon.ico';
    
    if (file_exists(CHILD_IMAGES_DIR . '/favicon.ico'))
        $favicon = CHILD_IMAGES_URL . '/favicon.ico';

    $favicon = apply_filters('calibrefx_favicon_url', $favicon);

    if ($favicon)
        echo '<link rel="Shortcut Icon" href="' . esc_url($favicon) . '" type="image/x-icon" />' . "\n";
}

add_action('calibrefx_meta', 'calibrefx_print_media57_icon');

/**
 * Print outs media icon for apple touch 57x57x in pixels
 */
function calibrefx_print_media57_icon() {

    //allow overriding
    $pre = apply_filters('calibrefx_pre_load_media57_icon', false);

    if ($pre !== false)
        $media57 = $pre;
    elseif (file_exists(CALIBREFX_IMAGES_DIR . '/ico/media-57x57.png'))
        $media57 = CALIBREFX_IMAGES_URL . '/ico/media-57x57.png';
    else
        $media57 = CALIBREFX_IMAGES_URL . '/media-57x57.png';

    $media57 = apply_filters('calibrefx_media57_url', $media57);

    if ($media57)
        echo '<link rel="apple-touch-icon" href="' . esc_url($media57) . '"/>' . "\n";
}

add_action('calibrefx_meta', 'calibrefx_print_media72_icon');

/**
 * Print outs media icon for apple touch 72x72 pixels
 */
function calibrefx_print_media72_icon() {

    //allow overriding
    $pre = apply_filters('calibrefx_pre_load_media72_icon', false);

    if ($pre !== false)
        $media72 = $pre;
    elseif (file_exists(CALIBREFX_IMAGES_DIR . '/ico/media-72x72.png'))
        $media72 = CALIBREFX_IMAGES_URL . '/ico/media-72x72.png';
    else
        $media72 = CALIBREFX_IMAGES_URL . '/media-72x72.png';

    $media72 = apply_filters('calibrefx_media72_url', $media72);

    if ($media72)
        echo '<link rel="apple-touch-icon" sizes="72x72" href="' . esc_url($media72) . '"/>' . "\n";
}

add_action('calibrefx_meta', 'calibrefx_print_media114_icon');

/**
 * Print outs media icon for apple touch 114x114 pixels
 */
function calibrefx_print_media114_icon() {

    //allow overriding
    $pre = apply_filters('calibrefx_pre_load_media114_icon', false);

    if ($pre !== false)
        $media114 = $pre;
    elseif (file_exists(CALIBREFX_IMAGES_DIR . '/ico/media-72x72.png'))
        $media114 = CALIBREFX_IMAGES_URL . '/ico/media-72x72.png';
    else
        $media114 = CALIBREFX_IMAGES_URL . '/media-72x72.png';

    $media114 = apply_filters('calibrefx_media114_url', $media114);

    if ($media114)
        echo '<link rel="apple-touch-icon" sizes="114x114" href="' . esc_url($media114) . '"/>' . "\n";
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

add_action('after_setup_theme', 'calibrefx_custom_header');

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
    if (!$custom_header)
        return;

    /** Blog title option is obsolete when custom header is active */
    add_filter('calibrefx_pre_get_option_blog_title', '__return_empty_array');

    /** Cast, if necessary */
    $custom_header = isset($custom_header[0]) && is_array($custom_header[0]) ? $custom_header[0] : array();

    /** Merge defaults with passed arguments */
    $args = wp_parse_args($custom_header, array(
        'width' => 260,
        'height' => 100,
        'textcolor' => '333333',
        'no_header_text' => false,
        'header_image' => '%s/header.png',
        'header_callback' => 'calibrefx_custom_header_style',
        'admin_header_callback' => 'calibrefx_custom_header_admin_style'
            ));

    /** Define all the constants */
    if (!defined('HEADER_IMAGE_WIDTH') && is_numeric($args['width']))
        define('HEADER_IMAGE_WIDTH', $args['width']);

    if (!defined('HEADER_IMAGE_HEIGHT') && is_numeric($args['height']))
        define('HEADER_IMAGE_HEIGHT', $args['height']);

    if (!defined('HEADER_TEXTCOLOR') && $args['textcolor'])
        define('HEADER_TEXTCOLOR', $args['textcolor']);

    if (!defined('NO_HEADER_TEXT') && $args['no_header_text'])
        define('NO_HEADER_TEXT', $args['no_header_text']);

    if (!defined('HEADER_IMAGE') && $args['header_image'])
        define('HEADER_IMAGE', sprintf($args['header_image'], apply_filters('calibrefx_images_url', CALIBREFX_IMAGES_URL)));

    /** Activate Custom Header */
    add_custom_image_header($args['header_callback'], $args['admin_header_callback']);
}

/**
 * Header callback. It outputs special CSS to the document
 * head, modifying the look of the header based on user input.
 *
 */
function calibrefx_custom_header_style() {
    /** If no options set, don't waste the output. Do nothing. */
    if (HEADER_TEXTCOLOR == get_header_textcolor() && HEADER_IMAGE == get_header_image())
        return;

	if( calibrefx_get_option( 'enable_responsive' )){
		$header = sprintf('@media (min-width:961px){#header-title { background: url(%1$s) no-repeat left center; width:%2$s; height: %3$dpx}} @media (max-width:960px){#header-title {background: url(%1$s) no-repeat left center; width:%4$s; height: %3$dpx}}', esc_url(get_header_image()), HEADER_IMAGE_WIDTH . 'px', HEADER_IMAGE_HEIGHT, '100%');
	}else{
		$header = sprintf('#header-title { background: url(%1$s) no-repeat left center; width:%2$s; height: %3$dpx}', esc_url(get_header_image()), HEADER_IMAGE_WIDTH . 'px', HEADER_IMAGE_HEIGHT);
	}
	
    $text = sprintf('#title, #title a, #title a:hover{ display: block; margin: 0; overflow: hidden; padding: 0;text-indent: -9999px; color: #%s; width:%dpx; height: %dpx }', esc_html(get_header_textcolor()), HEADER_IMAGE_WIDTH, HEADER_IMAGE_HEIGHT);
    $header_ie = sprintf('#header-title { background: url(%1$s) no-repeat left center; width:%2$s; height: %3$dpx}', esc_url(get_header_image()), HEADER_IMAGE_WIDTH . 'px', HEADER_IMAGE_HEIGHT);
	
    printf('<style type="text/css">%1$s %2$s</style>'."\n", $header, $text);
	printf('<!--[if lt IE 9]><style type="text/css">%1$s</style><![endif]-->'."\n", $header_ie);
}

/**
 * Header admin callback. It outputs special CSS to the admin
 * document head, modifying the look of the header area based on user input.
 *
 * Will probably need to be overridden in the child theme with a custom callback.
 */
function calibrefx_custom_header_admin_style() {

    $headimg = sprintf('.appearance_page_custom-header #headimg { background: url(%s) no-repeat; min-height: %spx; }', get_header_image(), HEADER_IMAGE_HEIGHT);
    $h1 = sprintf('#headimg h1, #headimg h1 a { color: #%s; font-size: 24px; font-weight: normal; line-height: 30px; margin: 20px 0 0; text-decoration: none; }', esc_html(get_header_textcolor()));
    $desc = sprintf('#headimg #desc { color: #%s; font-size: 12px; font-style: italic; line-height: 1; margin: 0; }', esc_html(get_header_textcolor()));

    printf('<style type="text/css">%1$s %2$s %3$s</style>', $headimg, $h1, $desc);
}

add_action('calibrefx_html_header', 'calibrefx_do_html_header');

/**
 * Print html header
 */
function calibrefx_do_html_header() {
    do_action('calibrefx_doctype');
    do_action('calibrefx_title');
    do_action('calibrefx_meta');
}

add_action('wp_head', 'calibrefx_print_wrap');
/**
 * Print .wrap style
 */
function calibrefx_print_wrap(){
	if( calibrefx_get_option( 'enable_responsive' )){
		$wrap = sprintf('@media (min-width:%dpx){.wrap.row{width: %dpx;margin: 0 auto;}}', calibrefx_get_option("calibrefx_layout_width"), calibrefx_get_option("calibrefx_layout_width"));
	}else{
		$wrap = sprintf('.wrap.row{width: %dpx;margin-left:auto;margin-right:auto} @media (max-width:%dpx){ #header.row, #nav.row, #subnav.row, #inner.row, #footer.row{width: %dpx;margin-left:auto;margin-right:auto}}', calibrefx_get_option("calibrefx_layout_width"), calibrefx_get_option("calibrefx_layout_width"), calibrefx_get_option("calibrefx_layout_width"));
	}
    $wrap_ie = sprintf('.wrap.row{width: %dpx;margin: 0 auto;}', calibrefx_get_option("calibrefx_layout_width"));
    
    printf('<style type="text/css">%1$s</style>', $wrap);
	printf('<!--[if lt IE 9]><style type="text/css">%1$s</style><![endif]-->', $wrap_ie);
}

add_action('wp_head', 'calibrefx_do_meta_pingback');

/**
 * This function adds the pingback meta tag to the <head> so that other
 * sites can know how to send a pingback to our site.
 */
function calibrefx_do_meta_pingback() {

    if ('open' == get_option('default_ping_status')) {
        echo '<link rel="pingback" href="' . get_bloginfo('pingback_url') . '" />' . "\n";
    }
}

add_action('calibrefx_meta', 'calibrefx_do_dublin_core');
/**
 * This function adds dublin core meta in header
 */
function calibrefx_do_dublin_core() {
    echo '<meta name="DC.title" content="'.apply_filters('calibrefx_do_title', get_bloginfo('name')).'">';
    echo '<meta name="DC.description" content="'.apply_filters('calibrefx_seo_description', get_bloginfo('description')).'">';
    echo '<meta name="DC.subject" content="'.apply_filters('calibrefx_do_title', get_bloginfo('name')).'">';
    echo '<meta name="DC.language" content="'.get_bloginfo('language').'">'."\n";
//    echo '<meta name="DC.creator" content="'.calibrefx_get_author().'">';
}

add_action('calibrefx_meta', 'calibrefx_do_fb_og');
/**
 * This function adds dublin core meta in header
 */
function calibrefx_do_fb_og() {
    echo '<meta property="fb:admins" content="'.calibrefx_get_option('facebook_admins').'"/>';
    echo '<meta property="og:title" content="'.apply_filters('calibrefx_do_title', get_bloginfo('name')).'"/>';
    echo '<meta property="og:type" content="'.calibrefx_get_option('facebook_og_type').'"/>';
    echo '<meta property="og:url" content="' . get_permalink() . '"/>';
    echo '<meta property="og:site_name" content="'.get_bloginfo('name').'"/>';
    $image = calibrefx_get_image(array('format' => 'url'));
    if($image){
        echo '<meta property="og:image" content="' . $image . '"/>';
    }
}

add_action('wp_head', 'calibrefx_header_scripts');

/**
 * Echo the header scripts, defined in Theme Settings.
 */
function calibrefx_header_scripts() {

    echo apply_filters('calibrefx_header_scripts', calibrefx_get_option('header_scripts'));

    // If singular, echo scripts from custom field
    if (is_singular()) {
        calibrefx_custom_field('_calibrefx_scripts');
    }
}

add_action('wp_head', 'calibrefx_header_custom_styles');

/**
 * Echo the header custom styles, defined in Theme Settings.
 */
function calibrefx_header_custom_styles() {

    $custom_css = calibrefx_get_option('custom_css');
    if (!empty($custom_css))
        printf('<style type="text/css">%1$s</style>', apply_filters('calibrefx_header_custom_styles', $custom_css));

    // If singular, echo scripts from custom field
    if (is_singular()) {
        printf('<style type="text/css">%1$s</style>', calibrefx_custom_field('_calibrefx_custom_styles'));
    }
}

add_action('calibrefx_header', 'calibrefx_do_header_open', 5);

/**
 * Open header markup
 */
function calibrefx_do_header_open() {
    echo '<div id="header" class="row">';
    calibrefx_put_wrapper('header');
}

add_action('calibrefx_header', 'calibrefx_do_header_close', 15);

/**
 * Close header markup
 */
function calibrefx_do_header_close() {
    calibrefx_put_wrapper('header','close');
    echo '</div><!--end #header-->';
}

add_action('calibrefx_site_title', 'calibrefx_do_site_title');

/**
 * Echo the site title into the #header.
 *
 */
function calibrefx_do_site_title() {

    // Set what goes inside the wrapping tags
    $inside = sprintf('<a href="%s" title="%s">%s</a>', trailingslashit(home_url()), esc_attr(get_bloginfo('name')), get_bloginfo('name'));

    // Determine which wrapping tags to use
    //$wrap = is_home() ? 'h1' : 'p';

    // Build the Title
    $title = sprintf('<h1 id="title">%s</h1>', $inside);

    // Echo (filtered)
    echo apply_filters('calibrefx_seo_title', $title, $inside, $wrap);
}

add_action('calibrefx_site_description', 'calibrefx_do_site_description');

/**
 * Echo the site description into the #header.
 *
 */
function calibrefx_do_site_description() {

    // Set what goes inside the wrapping tags
    $inside = esc_html(get_bloginfo('description'));

    // Determine which wrapping tags to use
    $wrap = 'p';

    // Build the Description
    $description = $inside ? sprintf('<%s id="description">%s</%s>', $wrap, $inside, $wrap) : '';

    // Return (filtered)
    echo apply_filters('calibrefx_seo_description', $description, $inside, $wrap);
}

add_action('calibrefx_header', 'calibrefx_do_header');

/**
 * Do Header Callback
 */
function calibrefx_do_header() {
    echo '<div id="header-title" class="pull-left">';
    do_action('calibrefx_site_title');
    do_action('calibrefx_site_description');
    echo '</div><!-- end #header-title -->';

    if (is_active_sidebar('header-right')) {
        echo '<div class="pull-right header-right">';
        do_action('calibrefx_header_right_widget');
        dynamic_sidebar('header-right');
        echo '</div><!-- end .widget-wrap -->';
    }
}

add_action('calibrefx_after_header', 'calibrefx_add_socials_script');

/**
 * Add Social javascript after header
 */
function calibrefx_add_socials_script() {
    global $twitteruser;

    $twitteruser = calibrefx_get_option('twitter_username');

    //@TODO: add enable facebook in theme setting
    echo '
        <div id="fb-root"></div>
        <script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=184690738325056";
        fjs.parentNode.insertBefore(js, fjs);
        }(document, \'script\', \'facebook-jssdk\'));</script>';

    if (!empty($twitteruser)) {
        echo '<script charset="utf-8" src="http://widgets.twimg.com/j/2/widget.js"></script>';
    }
}

add_filter( 'feed_link', 'calibrefx_feed_links_filter', 10, 2 );
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

add_action('wp_head', 'calirbefx_show_feeds_meta');
/**
 * Show Feed Meta
 */
function calirbefx_show_feeds_meta(){
    echo '<link rel="alternate" type="application/rss+xml" title="'.get_bloginfo('name') . ' ' . __("RSS Feed", 'calibrefx') .'" href="'. get_bloginfo('rss2_url') .'" />';
    echo '<link rel="alternate" type="application/atom+xml" title="'.get_bloginfo('name') . ' ' . __("Atom Feed", 'calibrefx') .'" href="'. get_bloginfo('atom_url') .'" />';
    echo '<link rel="alternate" type="application/rss+xml" title="'.get_bloginfo('name') . ' ' . __("Comment Feed", 'calibrefx') .'" href="'. get_bloginfo('comments_rss2_url') .'" />';
}