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
 * This file to handle cache mechanism
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
    
    function __construct($arr=array()){
        $this->arr=$arr;
    }

    private function replaceCallback($m){
        return isset($this->arr[$m[1]]) ? $this->arr[$m[1]] : '';
    }

    function get($s){
        return preg_replace_callback('/%(.*?)%/',array(&$this,'replaceCallback'),$s);
    }

}

