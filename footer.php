<?php
/**
 * CalibreFx
 *
 * WordPress Themes Framework by CalibreFx Team
 *
 * @package		CalibreFx
 * @author		CalibreFx Team
 * @authorlink	http://www.calibrefx.com
 * @copyright   Copyright (c) 2012, Suntech Inti Perkasa.
 * @license		GNU/GPL v2
 * @link		http://www.calibrefx.com
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

do_action('calibrefx_before_footer');
do_action('calibrefx_footer');
do_action('calibrefx_after_footer');
?>
</div><!-- end #wrapper -->
<?php
do_action('calibrefx_after_wrapper');
wp_footer(); //wp_footer funtion for plugins
?>
</body>
</html>