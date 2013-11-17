<?php
/**
 * CalibreFx
 *
 * WordPress Themes Framework by CalibreFx Team
 *
 * @package		CalibreFx
 * @author		CalibreFx Team
 * @authorlink	http://www.calibrefx.com
 * @copyright   Copyright (c) 2012, CalibreWorks. (http://www.calibreworks.com/)
 * @link		http://www.calibrefx.com
 * @filesource 
 *
 * WARNING: This file is part of the core CalibreFx framework. DO NOT edit
 * this file under any circumstances. 
 * 
 *
 * @package CalibreFx
 */
 
do_action('calibrefx_html_header');

wp_head();

?>
</head>
<body <?php body_onload(); ?> <?php body_class(); ?>>
<?php 
	do_action( 'calibrefx_before_wrapper' ); 
	$wrapper_class = apply_filters( 'wrapper_class', calibrefx_container_class() );
?>
<div id="wrapper" class="<?php echo $wrapper_class; ?>">
<?php
do_action('calibrefx_before_header');
do_action('calibrefx_header');
do_action('calibrefx_after_header');

if(current_theme_supports('calibrefx-version-1.0')){
	$inner_class = apply_filters( 'inner_class', calibrefx_row_class() );
	echo '<div id="inner" class="'.$inner_class.'">';
}else{
	echo '<div id="inner">';
}
?>