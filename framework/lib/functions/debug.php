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
 * This file only for development to do debugging
 *
 * @package CalibreFx
 */
 
function debug_var($var){
    $before = '<div style="padding:10px 20px 10px 20px; background-color:#fbe6f2; border:1px solid #d893a1; color: #000; font-size: 12px;>'."\n";
    $before .= '<h5 style="font-family:verdana,sans-serif; font-weight:bold; font-size:18px;">Debug Helper Output</h5>'."\n";
    $before .= '<pre>'."\n";

    echo $before;
    var_dump($var);
    $after = '</pre>'."\n";
    $after .= '</div>'."\n";

    echo $after;
}

function fire_debug($var){
    $firephp = FirePHP::getInstance();
    $firephp->log($var);
}