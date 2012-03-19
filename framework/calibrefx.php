<?php
/**
 * CalibreFx
 *
 * WordPress Themes Framework by CalibreWorks Team
 *
 * @package		CalibreFx
 * @author		CalibreWorks Team
 * @copyright	Copyright (c) 2012, Suntech Inti Perkasa.
 * @license		Commercial
 * @link		http://calibrefx.com
 * @since		Version 1.0
 * @filesource 
 *
 * WARNING: This file is part of the core CalibreFx framework. DO NOT edit
 * this file under any circumstances. 
 *
 * This file calls the init.php file to initialize the framework
 *
 * @package CalibreFx
 */
require_once( dirname(__FILE__) . '/lib/init.php' );

/**
 * Fire everything and display it.
 */
function calibrefx() {
    get_header();

    do_action('calibrefx_before_content_wrapper');
    ?>
    <div id="content-wrapper" class="row" >
        <?php do_action('calibrefx_before_content'); ?>
        <div id="content" class="<?php echo calibrefx_content_span(); ?>">
            <?php
            do_action('calibrefx_before_loop');
            do_action('calibrefx_loop');
            do_action('calibrefx_after_loop');
            ?>
        </div><!-- end #content -->
        <?php do_action('calibrefx_after_content'); ?>
    </div><!-- end #content-wrapper -->
    <?php
    do_action('calibrefx_after_content_wrapper');

    get_footer();
}

/* End of file calibrefx.php */
/* Location: ./calibrefx/calibrefx.php */