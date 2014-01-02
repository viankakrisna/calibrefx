<?php 
defined('CALIBREFX_URL') OR exit();
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
 * Calibrefx Module Setting Class
 *
 * @package		Calibrefx
 * @subpackage          Library
 * @author		CalibreFx Team
 * @since		Version 1.0
 * @link		http://www.calibrefx.com
 */

class CFX_Module_Settings extends CFX_Admin {
	/**
     * Constructor - Initializes
     */
    function __construct() {
        global $calibrefx;

        $this->page_id = 'calibrefx-module';
        $this->settings_field = apply_filters('calibrefx_module_field', 'calibrefx-module');
        //we need to initialize the model
        $calibrefx->load->model('module_settings_m');
        $this->_model = $calibrefx->module_settings_m;
        
        $this->initialize();
    }

    /**
     * Register Our Security Filters
     *
     * $return void
     */
    public function security_filters(){
        //Nothing to add here
    }

    public function meta_sections() {
        global $calibrefx_current_section, $calibrefx_sections;

        calibrefx_clear_meta_section();

        calibrefx_add_meta_section('installed', __('Installed Modules', 'calibrefx'), '', 1);
        calibrefx_add_meta_section('available', __('Available Modules', 'calibrefx'), '', 2);

        $calibrefx_current_section = 'installed';
        if (!empty($_GET['section'])) {
            $calibrefx_current_section = sanitize_text_field($_GET['section']);
        }
    }

    public function meta_boxes() {
        calibrefx_add_meta_box('installed', 'basic', 'calibrefx-installed-modules', __('Modules Installed / Downloaded', 'calibrefx'), array(&$this,'installed_modules'), $this->pagehook, 'main', 'low');
    }

    public function installed_modules(){
        global $calibrefx;

        // $calibrefx->load->library('list_table');

        $action = $calibrefx->list_module_table->current_action();
        $pagenum = $calibrefx->list_module_table->get_pagenum();

        $module = isset($_REQUEST['module']) ? $_REQUEST['module'] : '';
        $s = isset($_REQUEST['s']) ? urlencode($_REQUEST['s']) : '';

        // Clean up request URI from temporary args for screen options/paging uri's to work as expected.
        $_SERVER['REQUEST_URI'] = remove_query_arg(array('error', 'deleted', 'activate', 'activate-multi', 'deactivate', 'deactivate-multi', '_error_nonce'), $_SERVER['REQUEST_URI']);
        if ( $action ) {
            switch ( $action ) {
                case 'activate': 
                    if ( ! current_user_can('activate_plugins') )
                        wp_die(__('You do not have sufficient permissions to activate plugins for this site.'));

                    // check_admin_referer('activate-module_' . $module);
                    
                    $result = calibrefx_activate_module($module);
                    // wp_redirect( admin_url("admin.php?page=calibrefx-module&activate=true"));//&module_status=$status&paged=$page&s=$s") ); // overrides the ?error=true one above
                    break;
                case 'deactivate': 
                    if ( ! current_user_can('activate_plugins') )
                        wp_die(__('You do not have sufficient permissions to activate plugins for this site.'));

                    // check_admin_referer('activate-module_' . $module);
                    
                    $result = calibrefx_deactivate_module($module);
                    // wp_redirect( admin_url("admin.php?page=calibrefx-module&deactivate=true"));//&module_status=$status&paged=$page&s=$s") ); // overrides the ?error=true one above
                    break;
            }
        }
        
        // Fill the data with all available modules
        $calibrefx->list_module_table->prepare_items();
        
        $calibrefx->list_module_table->views();

        ?>

        <form method="get" action="">
        <?php $calibrefx->list_module_table->search_box( __( 'Search Installed Plugins' ), 'plugin' ); ?>
        </form>
        
        <?php
        $calibrefx->list_module_table->display();
        ?>
        <style type="text/css">
            .main-postbox{
                width: 96%;
            }

            .side-postbox{
                display: none;
            }

            .calibrefx-metaboxes span {
                display: inline;
            }

            .calibrefx-metaboxes span.paging-input .current-page {
                display: inline;
                width: auto;
            }

            .calibrefx-tab ul.calibrefx-tab-option {
                display: none;  
            }

            .calibrefx-option{
                margin-left: 0px;
            }

            .wp-list-table.widefat{
                width: 100%;
            }
        </style>
        <?php
    }
   
}