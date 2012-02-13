<?php
/**
 * CalibreFx Framework
 *
 * WordPress Themes by CalibreWorks Team
 *
 * @package		CalibreFx
 * @author		CalibreWorks Team
 * @authorlink	http://calibreworks.com
 * @copyright	Copyright (c) 2012, Suntech Inti Perkasa.
 * @license		Commercial
 * @link		http://calibreworks.com
 * @since		Version 1.0
 * @filesource 
 *
 * SalesVenture Header file
 *
 * @package SalesVenture
 */
do_action('calibrefx_html_header');

wp_head(); //wp_head funtion for plugins
?>
</head>
<body <?php body_class(); ?>>
<?php do_action( 'calibrefx_before_wrapper' ); ?>
<div id="wrapper" class="container<?php echo calibrefx_layout_type(); ?>">
<?php
do_action('calibrefx_before_header');
do_action('calibrefx_header');
do_action('calibrefx_after_header');
?>
<div id="inner" class="row<?php echo calibrefx_layout_type(); ?>">