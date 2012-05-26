<?php
/**
 * CalibreFx
 *
 * WordPress Themes Framework by CalibreWorks Team
 *
 * @package		CalibreFx
 * @author		CalibreWorks Team
 * @copyright           Copyright (c) 2012, Suntech Inti Perkasa.
 * @license		Commercial
 * @link		http://calibrefx.com
 * @since		Version 1.0
 * @filesource 
 *
 * WARNING: This file is part of the core CalibreFx framework. DO NOT edit
 * this file under any circumstances. 
 *
 * Footer Page
 *
 * @package CalibreFx
 */
 
echo '</div><!-- end #inner -->';

do_action( 'calibrefx_before_footer' );
do_action( 'calibrefx_footer' );
do_action( 'calibrefx_after_footer' );
?>
</div><!-- end #wrapper -->
<?php
	do_action( 'calibrefx_after_wrapper' );
	wp_footer(); //wp_footer funtion for plugins
?>
</body>
</html>