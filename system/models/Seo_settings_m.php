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
 * SEO Settings Model Class
 *
 * @package		Calibrefx
 * @subpackage          Model
 * @author		CalibreWorks Team
 * @since		Version 1.0
 * @link		http://calibrefx.com
 */

class Seo_settings_m extends CFX_Model{
    
    public function __construct() {
        parent::__construct(apply_filters('calibrefx_seo_settings_field', 'calibrefx-seo-settings'));
    }
}