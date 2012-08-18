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
    var $min_serveController;
    
    function __construct(){
        set_include_path(CALIBREFX_MODULES_DIR . '/minify' . PATH_SEPARATOR . get_include_path());
        $this->config = array(
            'enable_cache' => false,
            'cache_path' => CALIBREFX_CACHE_DIR,
            'cache_locking' => true,
            'debug' => false,
            'maxAge' => 1,
            'encodeOutput' => true,
            'encodeMethod' => '',
            'quiet' => true,
        );
        
        require_once CALIBREFX_MODULES_DIR.'/minify/Minify/Controller/CalibrefxMin.php';
	$this->min_serveController = new Minify_Controller_CalibrefxMin();
        
    }
    
    public function minified_css($css_files){
        $min_serveOptions = array();
        
        if(!is_dir(CHILD_CACHE_DIR)){
            $cache_dir = CALIBREFX_CACHE_DIR;
            $cache_url = CALIBREFX_CACHE_URL;
        }else{
            //Cache dir in framework should be exist
            $cache_dir = CHILD_CACHE_DIR;
            $cache_url = CHILD_CACHE_URL;
        }
        
        if(file_exists($cache_dir . '/min.css' )){
           return $cache_url . '/min.css';
        }
        
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
        $min_serveOptions['debug'] = $this->config['debug'];
        $min_serveOptions['maxAge'] = $this->config['maxAge'];
        $min_serveOptions['quiet'] = $this->config['quiet'];
        $min_serveOptions['encodeOutput'] = $this->config['encodeOutput'];
        $min_serveOptions['encodeMethod'] = $this->config['encodeMethod'];
        $min_serveOptions['files'] = $css_files;
        
        $minified_css = Minify::serve($this->min_serveController, $min_serveOptions);
        $minified_css_data = $minified_css['content'];
        calibrefx_write_cache($cache_dir . '/min.css', $minified_css_data);
        
        return $cache_url . '/min.css';
    }
    
    public function minified_js($js_files){
        $min_serveOptions = array();
        
        if(!is_dir(CHILD_CACHE_DIR)){
            $cache_dir = CALIBREFX_CACHE_DIR;
            $cache_url = CALIBREFX_CACHE_URL;
        }else{
            //Cache dir in framework should be exist
            $cache_dir = CHILD_CACHE_DIR;
            $cache_url = CHILD_CACHE_URL;
        }
        
        if(file_exists($cache_dir . '/min.js' )){
           return $cache_url . '/min.js';
        }
        
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
        $min_serveOptions['debug'] = $this->config['debug'];
        $min_serveOptions['maxAge'] = $this->config['maxAge'];
        $min_serveOptions['quiet'] = $this->config['quiet'];
        $min_serveOptions['encodeOutput'] = $this->config['encodeOutput'];
        $min_serveOptions['encodeMethod'] = $this->config['encodeMethod'];
        $min_serveOptions['files'] = $js_files;
        
        require_once CALIBREFX_MODULES_DIR.'/minify/Minify/Controller/CalibrefxMin.php';
	$min_serveController = new Minify_Controller_CalibrefxMin();
        
        $minified_js = Minify::serve($this->min_serveController, $min_serveOptions);
        $minified_js_data = $minified_js['content'];
        calibrefx_write_cache($cache_dir . '/min.js', $minified_css_data);
        
        return $cache_url . '/min.js';
    }
    
    public function clear_cache(){
        if(!is_dir(CHILD_CACHE_DIR)){
            $cache_dir = CALIBREFX_CACHE_DIR;
        }else{
            //Cache dir in framework should be exist
            $cache_dir = CHILD_CACHE_DIR;
        }
        
        $cachedir = opendir($cache_dir);
        
        while(false !== ($file = readdir($cachedir))) {
            if($file != "." && $file != "..") {
                if(is_dir($cache_dir.'/'.$file)) {
                    chdir('.');
                    destroy($cache_dir.'/'.$file.'/');
                    @rmdir($cache_dir.'/'.$file);
                }
                else
                    @unlink($cache_dir.'/'.$file);
            }
        }
        closedir($cachedir);
        return true;
    }
}

global $cfx_minify;
$cfx_minify =  new CFX_Minify();

