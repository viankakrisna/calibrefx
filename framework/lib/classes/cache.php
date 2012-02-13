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
 * @link		http://calibreworks.com
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
 * CalibreFx Cache Class
 *
 * Cache Class for CalibreFx Framework to wrap wo object cache
 *
 * @author		Ivan Kristianto
 * @version		1.0
 */
 
class cfx_cache{
	
	/**
	 * Constructor - Initializes
	 */
	function __construct()	{}
	
	/**
	 * Set Cache
	 *
	 * @access	public
	 * @param	string cache key
	 * @param	mixed data to store to the cache
	 * @param 	string group name, default CALIBREFX_SETTINGS_FIELD
	 * @return	void
	 */
	public function cache_set($key, $data, $group = null, $expire = 0){
		$group = $group ? $group : CALIBREFX_SETTINGS_FIELD;
		return wp_cache_set( $key, $data, $group, $expire );
	}
	
	/**
	 * Get Cache
	 *
	 * @access	public
	 * @param	string cache key
	 * @param 	string group name, default CALIBREFX_SETTINGS_FIELD
	 * @return	mixed data from the cache
	 */
	public function cache_get($key, $group = null){
		$group = $group ? $group : CALIBREFX_SETTINGS_FIELD;
		return wp_cache_get( $key, $group );
	}
	
	/**
	 * Delete Cache
	 *
	 * @access	public
	 * @param	string cache key
	 * @param 	string group name, default CALIBREFX_SETTINGS_FIELD
	 * @return	bool
	 */
	public function cache_delete($key, $group = null){
		$group = $group ? $group : CALIBREFX_SETTINGS_FIELD;
		return wp_cache_delete( $key, $group );
	}
	
	/**
	 * Flush all caches
	 *
	 * @access	public
	 * @return	void
	 */
	public function cache_flush(){
		wp_cache_flush();
	}
}