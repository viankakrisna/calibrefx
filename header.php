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
	<meta http-equiv="Content-Type" content="<?php bloginfo( 'html_type' ); ?>; charset=<?php bloginfo( 'charset' ); ?>" />
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php
	if ( 'open' == get_option( 'default_ping_status' ) ) {
		echo '<link rel="pingback" href="' . esc_url( get_bloginfo( 'pingback_url' ) ) . '" />' . "\n";
	}
	if ( calibrefx_is_responsive_enabled() ){
		$width = "device-width";
	} else {
		$width = calibrefx_get_option( 'calibrefx_layout_width' );
	}

	echo '<meta name="viewport" content="width=' . $width . ', initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />' . "\n";
	do_action( 'calibrefx_meta' );
	wp_head();
	?>
</head>
<body <?php body_onload(); ?> <?php body_class(); ?> <?php body_attr(); ?>>
<?php
	do_action( 'calibrefx_before_wrapper' );
	do_action( 'calibrefx_wrapper' );

	do_action( 'calibrefx_before_header' );
	do_action( 'calibrefx_header' );
	do_action( 'calibrefx_after_header' );