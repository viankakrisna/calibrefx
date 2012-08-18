<?php
/**
 * CalibreFx
 *
 * WordPress Themes Framework by CalibreWorks Team
 *
 * @package		CalibreFx
 * @author		CalibreWorks Team
 * @copyright           Copyright (c) 2012, CalibreWorks. (http://www.calibreworks.com/)
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

!defined('CALIBREFX_URI') && define('CALIBREFX_URI', get_template_directory());
!defined('CALIBREFX_URL') && define('CALIBREFX_URL', get_template_directory_uri());

/** Run the calibrefx_pre Hook */
do_action('calibrefx_pre');

/*
 * ------------------------------------------------------
 *  Load the global functions
 * ------------------------------------------------------
 */
require_once( CALIBREFX_URI . '/core/Common.php' );

/*
 * ------------------------------------------------------
 *  Load Base Class
 * ------------------------------------------------------
 */
require_once( CALIBREFX_URI . '/core/Calibrefx.php' );

/** Run the calibrefx_pre_init hook */
do_action('calibrefx_pre_init');

/** Run the calibrefx_init hook */
do_action('calibrefx_init');

/** Run the calibrefx_post_init hook */
do_action('calibrefx_post_init');

/** Run the calibrefx_setup hook */
do_action('calibrefx_setup');

/**
 * Fire everything and display it.
 */
/*function calibrefx() {
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
}*/

/* End of file calibrefx.php */
/* Location: ./calibrefx/calibrefx.php */