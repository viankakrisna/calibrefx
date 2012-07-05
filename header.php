<?php
/**
 * CalibreFx Framework
 *
 * WordPress Themes by CalibreWorks Team
 *
 * @package		CalibreFx
 * @author		CalibreWorks Team
 * @authorlink	http://calibrefx.com
 * @copyright	Copyright (c) 2012, Suntech Inti Perkasa.
 * @license		Commercial
 * @link		http://calibrefx.com
 * @since		Version 1.0
 * @filesource 
 *
 * SalesVenture Header file
 *
 * @package SalesVenture
 */
 
 /* Edited By Hilal */
do_action('calibrefx_html_header');

wp_head();

?>
</head>
<body <?php body_onload(); ?> <?php body_class(); ?>>
<?php do_action( 'calibrefx_before_wrapper' ); ?>
<div id="wrapper" class="container">
<?php
do_action('calibrefx_before_header');
do_action('calibrefx_header');
do_action('calibrefx_after_header');
?>
<div id="inner" class="row">