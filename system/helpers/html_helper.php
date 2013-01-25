<?php

/**
 * CalibreFx
 *
 * WordPress Themes Framework by CalibreFx Team
 *
 * @package		CalibreFx
 * @author		CalibreFx Team
 * @copyright           Copyright (c) 2012, CalibreWorks. (http://www.calibreworks.com/)
 * @link		http://www.calibrefx.com
 * @filesource 
 *
 * WARNING: This file is part of the core CalibreFx framework. DO NOT edit
 * this file under any circumstances. 
 * 
 *
 * @package CalibreFx
 */
/**
 * Calibrefx HTML Helper
 *
 * @package         CalibreFx
 * @subpackage      Helpers
 * @category        Helpers
 * @author          CalibreFx Team
 * @link            http://www.calibrefx.com
 * 
 */

/**
 * Output special xmlns on html tags
 */
function html_xmlns($xml = '') {
    $xmls = array();
    $xmls = array_map('esc_attr', $xmls);

    $xmlns = apply_filters('html_xmlns', $xmls, $xml);

    echo join(' ', $xmlns);
}

/**
 * Output if any body onload script defined
 */
function body_onload($script = '') {
    $scripts = array();

    if (!empty($script)) {
        if (!is_array($script))
            $script = preg_split('#\s+#', $script);
        $scripts = array_merge($scripts, $script);
    } else {
        // Ensure that we always coerce class to being an array.
        $script = array();
    }

    $scripts = array_map('esc_attr', $scripts);

    $onload_scripts = apply_filters('body_onload_script', $scripts, $script);

    echo 'onload="' . join(';', $onload_scripts) . '"';
}