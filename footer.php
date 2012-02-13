<?php
/**
 * SalesMaxThemes
 *
 * WordPress Themes by CalibreWorks Team
 *
 * @package		SalesMaxThemes
 * @author		CalibreWorks Team
 * @authorlink	http://SalesMaxThemes.com
 * @copyright	Copyright (c) 2012, Suntech Inti Perkasa.
 * @license		Commercial
 * @link		http://SalesMaxThemes.com
 * @since		Version 1.0
 * @filesource 
 *
 * The WordPress functions.php file. initialize CalibreFx framework and themes.
 *
 * @package SalesMaxThemes
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