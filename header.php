<?php 
// Calibrefx Header
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
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php
	do_action('calibrefx_meta');
	wp_head();
	?>
</head>
<body <?php body_onload(); ?> <?php body_class(); ?>>
	<?php 
	do_action( 'calibrefx_before_wrapper' ); 
	do_action( 'calibrefx_wrapper' ); 
		
	do_action('calibrefx_before_header');
	do_action('calibrefx_header');
	do_action('calibrefx_after_header');