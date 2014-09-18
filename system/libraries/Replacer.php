<?php defined( 'CALIBREFX_URL' ) OR exit();
/**
 * CalibreFx Framework
 *
 * WordPress Themes Framework by CalibreFx Team
 *
 * @package     CalibreFx
 * @author      CalibreFx Team
 * @authorlink  http://www.calibrefx.com
 * @copyright   Copyright (c) 2012-2013, CalibreWorks. (http://www.calibreworks.com/)
 * @license     GNU GPL v2
 * @link        http://www.calibrefx.com
 * @filesource 
 *
 * WARNING: This file is part of the core CalibreFx framework. DO NOT edit
 * this file under any circumstances. 
 *
 * This define the framework constants
 *
 * @package CalibreFx
 */

/**
 * CalibreFx Replacer Class
 *
 * Tags Replacer by CalibreFX
 *
 * @author		Ivan Kristianto
 * @version		1.0
 */
class CFX_Replacer {
    
    function __construct( $arr=array() ) {
        
    }
    
    public function set_replace_tag( $arr=array() ) {
        $this->arr=$arr;
        
        return $this;
    }

    private function replaceCallback( $m) {
        return isset( $this->arr[$m[1]]) ? $this->arr[$m[1]] : '';
    }

    function get( $s) {
        return preg_replace_callback( '/%(.*?)%/',array(&$this,'replaceCallback' ),$s);
    }

}

