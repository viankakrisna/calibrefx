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
 
do_action( 'calibrefx_html_header' );
?>
</head>
<body <?php body_onload(); ?> <?php body_class(); ?> <?php body_attr(); ?>>

<?php 
do_action( 'calibrefx_before_wrapper' ); 
do_action( 'calibrefx_wrapper' ); 
	
do_action( 'calibrefx_before_header' );
do_action( 'calibrefx_header' );
do_action( 'calibrefx_after_header' );

do_action( 'calibrefx_inner' ); 