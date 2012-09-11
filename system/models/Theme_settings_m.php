<?php
/**
 * CalibreFx
 *
 * WordPress Themes Framework by CalibreWorks Team
 *
 * @package		CalibreFx
 * @author		CalibreWorks Team
 * @copyright           Copyright (c) 2012, CalibreWorks. (http://www.calibreworks.com/)
 * @link		http://calibrefx.com
 * @filesource 
 *
 * WARNING: This file is part of the core CalibreFx framework. DO NOT edit
 * this file under any circumstances. 
 * 
 * @package CalibreFx
 */

/**
 * Themes Settings Model Class
 *
 * @package		Calibrefx
 * @subpackage          Model
 * @author		CalibreWorks Team
 * @since		Version 1.0
 * @link		http://calibrefx.com
 */

class Theme_settings_m extends CFX_Model{
    
    public function __construct() {
        parent::__construct(apply_filters('calibrefx_settings_field', 'calibrefx-settings'));
    }
}