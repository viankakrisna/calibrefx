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
 * This file contain functions to improve performance and reduce load time
 *
 * @package CalibreFx
 */

add_action('init', 'calibrefx_gzip_compression');

function calibrefx_gzip_compression() {
    // don't use on TinyMCE
    if (stripos($_SERVER['REQUEST_URI'], 'wp-includes/js/tinymce') !== false) {
        return false;
    }
    // can't use zlib.output_compression and ob_gzhandler at the same time
    if (( ini_get('zlib.output_compression') == 'On' || ini_get('zlib.output_compression_level') > 0 ) || ini_get('output_handler') == 'ob_gzhandler') {
        return false;
    }

    if (extension_loaded('zlib')) {
        ob_start('ob_gzhandler');
    }
}