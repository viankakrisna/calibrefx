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
 * Calibrefx Cache Class
 *
 * @package		Calibrefx
 * @subpackage          Library
 * @author		CalibreWorks Team
 * @since		Version 1.0
 * @link		http://calibrefx.com
 * @uses                WP_Cache
 */
class CFX_Cache {

    /**
     * Constructor - Initializes
     */
    function __construct() {
        
    }

    /**
     * Set Cache
     *
     * @access	public
     * @param	string cache key
     * @param	mixed data to store to the cache
     * @param 	string group name
     * @return	void
     */
    public function cache_set($key, $data, $group, $expire = 0) {
        return wp_cache_set($key, $data, $group, $expire);
    }

    /**
     * Get Cache
     *
     * @access	public
     * @param	string cache key
     * @param 	string group name
     * @return	mixed data from the cache
     */
    public function cache_get($key, $group) {
        return wp_cache_get($key, $group);
    }

    /**
     * Delete Cache
     *
     * @access	public
     * @param	string cache key
     * @param 	string group name
     * @return	bool
     */
    public function cache_delete($key) {
        return wp_cache_delete($key, $group);
    }

    /**
     * Flush all caches
     *
     * @access	public
     * @return	void
     */
    public function cache_flush() {
        wp_cache_flush();
    }

    /**
     * Write cache data to file
     * 
     * @param string $file Filename
     * @param string $data Data to write
     */
    public function write_cache($file, $data) {
        $fh = fopen($file, 'w');
        fwrite($fh, $data);
        fclose($fh);
        return $file;
    }

}