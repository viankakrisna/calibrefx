<?php defined('CALIBREFX_URL') OR exit();
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
 * Generator Class
 *
 * Generator Class to generate all hooks
 *
 * @package		Core
 * @category    Config
 * @author		CalibreFx Dev Team
 * @link		http://www.CalibreFx.com
 */

class CFX_Generator{

	/**
     * Store all hooks
     *
     * @var	object
     */
    private $_hooks = array();

    /**
     * Constructor
     *
     * Initialize
     *
     * @return	void
     */
    public function __construct() {
    	$this->_hooks = array();
    }

    /**
     * Set hook
     */
    public function setHook($hooks){
    	$this->_hooks = $hooks;
    }

    /**
     * Get Hook
     */
    public function getHook($hooks = NULL){
        if(is_null($hooks))
	       return $this->_hooks;

       return $this->_hooks[$hooks];
    }

    /**
     * Get the hook list
     *
     * @return array
     */
    public function __get($name){
    	if(empty($this->_hooks[$name]))
    		return array();

    	return $this->_hooks[$name];
    }

    /**
     * Set the hook list
     *
     * @return array
     */
    public function __set($name, $value){
    	if(!array($value)) return;

    	if(empty($this->_hooks[$name]))
    		$this->_hooks[$name] = array();
    	foreach ($value as $function) {
    		if(is_string($function)){
    			$this->add($name, $function);
	    	}elseif(is_array($function)){
	    		$this->add(
	    			$name, 
	    			$function['function'], 
	    			isset($function['priority'])? $function['priority']:10, 
	    			isset($function['args'])? $function['args']:0);
	    	}
    	}
    }

    /**
     * Check if the hook isset
     */
    public function __isset($name){
    	return isset($this->_hooks[$name]);
    }

    /**
     * Add a hook
     */
    public function add($hook, $function, $priority = 10, $args = 0){
    	$this->_hooks[$hook][] = array(
    		'function'	=> $function,
    		'priority'	=> $priority,
    		'args'		=> $args
    	);
    }

    /**
     * Remove a function from a hook
     */
    public function remove($name, $function){
    	if(!isset($this->_hooks[$name])) return;
    	
    	$keysearch = -1;
    	foreach ($this->$name as $key => $haystack) {
    		if($haystack['function'] == $function){
    			$keysearch=$key;
    			break;
    		}
    	}

    	if($keysearch == -1) return false;
    	unset($this->_hooks[$name][$keysearch]);
    	return true;
    }

    /**
     * Move a function to another hook
     */
    public function move($function, $orig, $target){
    	if(!isset($this->_hooks[$orig])) return;
    	
    	$keysearch = -1;
    	foreach ($this->$orig as $key => $haystack) {
    		if($haystack['function'] == $function){
    			$keysearch=$key;
    			break;
    		}
    	}

    	if($keysearch == -1) return false;
    	$func_array = $this->_hooks[$orig][$keysearch];
    	unset($this->_hooks[$orig][$keysearch]);
    	$this->add($target, $func_array['function'], $func_array['priority'], $func_array['args']);
    	
    	return true;
    }

    /**
     * Run all the stored hooks
     */
    public function run_hook(){
    	if(empty($this->_hooks)){
    		return;
    	}

    	foreach ($this->_hooks as $hook => $list) {
    		foreach ($list as $value) {
    			add_action( $hook, $value['function'], $value['priority'], $value['args'] );
    		}
    	}
    }
}