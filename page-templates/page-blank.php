<?php
/* 
 * Template Name: Blank Page
 */

add_filter( 'body_class', 'blank_page_body_class' );
function blank_page_body_class( $classes ){
	$classes[] = 'blank';
	return $classes;
}
?>
<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) & !(IE 8)]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<meta http-equiv="Content-Type" content="<?php bloginfo( 'html_type' ); ?>; charset=<?php bloginfo('charset'); ?>" />
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php 
	if ('open' == get_option( 'default_ping_status' ) ) {
        echo '<link rel="pingback" href="' . get_bloginfo( 'pingback_url' ) . '" />' . "\n";
    }
	if ( current_theme_supports( 'calibrefx-responsive-style' ) ){ 
		echo '<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />' . "\n";
    }
	do_action( 'calibrefx_meta' );
	wp_head();
	?>
</head>
<body <?php body_onload(); ?> <?php body_class(); ?>>
	<?php 
	do_action( 'calibrefx_before_wrapper' ); 
	do_action( 'calibrefx_wrapper' ); 
    
    if ( have_posts() ) : 
        while ( have_posts() ) : the_post(); ?>
    		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			    <?php do_action( 'calibrefx_before_post_content' ); ?>
			    <div class="entry-content">
			        <?php do_action( 'calibrefx_post_content' ); ?>
			    </div><!-- end .entry-content -->
			    <?php do_action( 'calibrefx_after_post_content' ); ?>

			</div><!-- end .postclass -->
    	<?php
        endwhile;
    else : 
        /** if no posts exist * */
        do_action( 'calibrefx_no_post' );
    endif;
	
	do_action( 'calibrefx_after_wrapper' );
	wp_footer(); 
	?>
</body>
</html>