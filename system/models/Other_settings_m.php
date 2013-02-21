<?php
/**
 * CalibreFx
 *
 * WordPress Themes Framework by CalibreFx Team
 *
 * @package		CalibreFx
 * @author		CalibreFx Team
 * @copyright           Copyright (c) 2012, CalibreWorks. (http://www.calibreworks.com/)
 * @link		http://www.calibrefx.com
 * @filesource 
 *
 * WARNING: This file is part of the core CalibreFx framework. DO NOT edit
 * this file under any circumstances. 
 * 
 * @package CalibreFx
 */

/**
 * Other Settings Model Class
 *
 * @package		Calibrefx
 * @subpackage          Model
 * @author		CalibreFx Team
 * @since		Version 1.0
 * @link		http://www.calibrefx.com
 */

class Other_settings_m extends CFX_Model{
    
    public function __construct() {
        parent::__construct(apply_filters('calibrefx_other_settings_field', 'calibrefx-other-settings'));
    }
}