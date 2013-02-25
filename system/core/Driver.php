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
 * Calibrefx Driver Class
 *
 * @package		Calibrefx
 * @subpackage  Core
 * @author		CalibreFx Team
 * @since		Version 1.0.0
 * @link		http://www.calibrefx.com
 */
class CFX_Driver {

    protected $parent;
    private $methods = array();
    private $properties = array();
    private static $reflections = array();

    /**
     * Decorate
     *
     * Decorates the child with the parent driver lib's methods and properties
     *
     * @param	object
     * @return	void
     */
    public function decorate($parent) {
        $this->parent = $parent;

        // Lock down attributes to what is defined in the class
        // and speed up references in magic methods

        $class_name = get_class($parent);

        if (!isset(self::$reflections[$class_name])) {
            $r = new ReflectionObject($parent);

            foreach ($r->getMethods() as $method) {
                if ($method->isPublic()) {
                    $this->methods[] = $method->getName();
                }
            }

            foreach ($r->getProperties() as $prop) {
                if ($prop->isPublic()) {
                    $this->properties[] = $prop->getName();
                }
            }

            self::$reflections[$class_name] = array($this->methods, $this->properties);
        } else {
            list($this->methods, $this->properties) = self::$reflections[$class_name];
        }
    }

    // --------------------------------------------------------------------

    /**
     * __call magic method
     *
     * Handles access to the parent driver library's methods
     *
     * @access	public
     * @param	string
     * @param	array
     * @return	mixed
     */
    public function __call($method, $args = array()) {
        if (in_array($method, $this->methods)) {
            return call_user_func_array(array($this->parent, $method), $args);
        }

        $trace = debug_backtrace();
        _exception_handler(E_ERROR, "No such method '{$method}'", $trace[1]['file'], $trace[1]['line']);
        exit;
    }

    // --------------------------------------------------------------------

    /**
     * __get magic method
     *
     * Handles reading of the parent driver library's properties
     *
     * @param	string
     * @return	mixed
     */
    public function __get($var) {
        if (in_array($var, $this->properties)) {
            return $this->parent->$var;
        }
    }

    // --------------------------------------------------------------------

    /**
     * __set magic method
     *
     * Handles writing to the parent driver library's properties
     *
     * @param	string
     * @param	array
     * @return	mixed
     */
    public function __set($var, $val) {
        if (in_array($var, $this->properties)) {
            $this->parent->$var = $val;
        }
    }

}