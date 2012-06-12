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
 * @extend Walker_Nav_Menu From WordPress
 *
 * WARNING: This file is part of the core CalibreFx framework. DO NOT edit
 * this file under any circumstances. 
 *
 * This file to handle css, js and htm minification
 *
 * @package CalibreFx
 */
require_once CALIBREFX_MODULES_DIR.'/minify/Minify.php';

class CFX_Minify {
    
    var $config;
    
    function __construct(){
        set_include_path(CALIBREFX_MODULES_DIR . '/minify' . PATH_SEPARATOR . get_include_path());
        $this->config = array(
            'enable_cache' => true,
            'cache_path' => CALIBREFX_CACHE_DIR,
            'cache_locking' => true,
            'debug' => false,
            'max_age' => 1440,
            'encodeOutput' => false,
            'encodeMethod' => 'gzip',
            'quiet' => true,
        );
        
    }
    
    public function get_minified_css(){
        $min_serveOptions = array();
        
        if(!is_dir(CHILD_CACHE_DIR)){
            $cache_dir = CALIBREFX_CACHE_DIR;
        }else{
            //Cache dir in framework should be exist
            $cache_dir = CHILD_CACHE_DIR;
        }
        
        $css_files = array(
            CALIBREFX_CSS_DIR . "/bootstrap.min.css",
        );
        
        if($this->config['enable_cache'] && !empty($this->config['cache_path'])){
            Minify::setCache(
                $this->config['cache_path']
                ,$this->config['cache_locking']
            );
        }
        
        if($this->config['debug']){
            require_once CALIBREFX_MODULES_DIR . '/minify/Minify/DebugDetector.php';
            require_once CALIBREFX_MODULES_DIR . '/minify/Minify/Logger.php';
            require_once CALIBREFX_MODULES_DIR . '/minify/FirePHP.php';
            $min_errorLogger = FirePHP::getInstance(true);
            Minify_Logger::setLogger($min_errorLogger);
            //$min_serveOptions['debug'] = Minify_DebugDetector::shouldDebugRequest($_COOKIE, $_GET, $_SERVER['REQUEST_URI']);
        }
        
        $min_serveOptions['bubbleCssImports'] = true;
        $min_serveOptions['maxAge'] = $this->config['max_age'];
        $min_serveOptions['quiet'] = $this->config['quiet'];
        $min_serveOptions['encodeOutput'] = $this->config['encodeOutput'];
        $min_serveOptions['encodeMethod'] = $this->config['encodeMethod'];
        
        $min_serveOptions['files'] = $css_files;
        
        require CALIBREFX_MODULES_DIR.'/minify/Minify/Controller/Files.php';
	$min_serveController = new Minify_Controller_Files();
        
        return Minify::serve($min_serveController, $min_serveOptions);
    }
    
    public function get_minified_js(){
        if(!is_dir(CHILD_CACHE_DIR)){
            $cache_dir = CALIBREFX_CACHE_DIR;
        }else{
            //Cache dir in framework should be exist
            $cache_dir = CHILD_CACHE_DIR;
        }
        
        return FALSE;
    }
    
    
}