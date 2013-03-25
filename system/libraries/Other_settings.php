<?php
/**
 * CalibreFx
 *
 * WordPress Themes Framework by CalibreFx Team
 *
 * @package		CalibreFx
 * @author		CalibreFx Team
 * @copyright           Copyright (c) 2012, Suntech Inti Perkasa.
 * @license		Commercial
 * @link		http://www.calibrefx.com
 * @since		Version 1.0
 * @filesource 
 *
 * WARNING: This file is part of the core CalibreFx framework. DO NOT edit
 * this file under any circumstances. 
 *
 * This File will handle theme-settings and provide default settings
 *
 * @package CalibreFx
 */

/**
 * Calibrefx Other Settings Class
 *
 * @package		Calibrefx
 * @subpackage          Library
 * @author		CalibreFx Team
 * @since		Version 1.0
 * @link		http://www.calibrefx.com
 */
class CFX_Other_Settings extends CFX_Admin {

    /**
     * Constructor - Initializes
     */
    function __construct() {
        $this->page_id = 'calibrefx-other';
        $this->default_settings = apply_filters('calibrefx_other_settings_defaults', array(
                
            )
        );

        //we need to initialize the model
        $CFX = & calibrefx_get_instance();
        $CFX->load->model('other_settings_m');
        $this->_model = & $CFX->other_settings_m;

        $this->initialize();
    }

    /**
     * Register Our Security Filters
     *
     * $return void
     */
    public function security_filters() {
        $CFX = & calibrefx_get_instance();

        $CFX->security->add_sanitize_filter(
                'one_zero', $this->settings_field, array(
            
            )
        );

        $CFX->security->add_sanitize_filter(
                'safe_text', $this->settings_field, array(
           )
        );

        $CFX->security->add_sanitize_filter(
                'integer', $this->settings_field, array(
            )
        );
    }

    public function meta_sections() {
        global $calibrefx_current_section;

        calibrefx_clear_meta_section();

        calibrefx_add_meta_section('tosgen', __('TOS Generator', 'calibrefx'), '');

        do_action('more_other_setting');

        $calibrefx_current_section = 'tosgen';
        if (!empty($_GET['section'])) {
            $calibrefx_current_section = sanitize_text_field($_GET['section']);
        }
    }

    public function meta_boxes() {
        calibrefx_add_meta_box('tosgen', 'basic', 'calibrefx-other-settings-tosgen', __('TOS Generator', 'calibrefx'), array($this, 'tos_generator'), $this->pagehook, 'main', 'high');
    }

    public function tos_generator(){
        $name = '';
        $url = '';
        $info = '';


        $asp = '';
        $cn = '';
        $disclaimer = '';
        $dmca = '';
        $federal = '';
        $privacy = '';
        $social = '';
        $terms = '';


if(isset($_POST['name']) && isset($_POST['url']) ){

    $name = $_POST['name'];
    $url = $_POST['url'];
    $info = $_POST['info'];

    $response = wp_remote_post( 'http://www.calibreworks.com/tosgen/api.php', array(
            'method' => 'POST',
            'timeout' => 60,
            'redirection' => 5,
            'httpversion' => '1.0',
            'blocking' => true,
            'headers' => array(),
            'body' => array( 
                'company_name' => $_POST['name'], 
                'company_url' => $_POST['url'],
                'company_info' => $_POST['info'],
                ),
            'cookies' => array(),
        )
    );

    $json = json_decode($response['body']);

    $asp = $json->data->asp;
    $cn = $json->data->cn;
    $disclaimer = $json->data->disclaimer;
    $dmca = $json->data->dmca;
    $federal = $json->data->federal;
    $privacy = $json->data->privacy;
    $social = $json->data->social;
    $terms = $json->data->terms;

}
    ?>
        <p>
            <legend><strong>Company Info</strong></legend>
        </p>
        <div class="control-group">
            <label class="control-label" for="name">Company Name</label>
            <div class="controls">
                <input type="text" id="name" name="name" value="<?php echo $name;?>" placeholder="Type your company name">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="url">Company Site URL</label>
            <div class="controls">
                <input type="text" id="url" name="url" value="<?php echo $url;?>" placeholder="Type your site company URL">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="info">Company Info</label>
            <div class="controls">
                <textarea id="info" name="info" class="span12" rows="8" cols="15" placeholder="Type your company Info"><?php echo $info;?></textarea>
            </div>
        </div>

        <hr class="div" />

        <p>
            <legend><strong>Result</strong></legend>
        </p>
        <div class="control-group">
            <label class="control-label" for="asp">Anti-Spam Policy</label>
            <div class="controls">
                <textarea id="asp" name="asp" class="span12" rows="10" cols="15"><?php echo $asp;?></textarea>
            </div>
        </div>  
        <div class="control-group">
            <label class="control-label" for="cn">Copyright Notice</label>
            <div class="controls">
                <textarea id="cn" name="cn" class="span12" rows="10" cols="15"><?php echo $cn;?></textarea>
            </div>
        </div>  
        <div class="control-group">
            <label class="control-label" for="disclaimer">Disclaimer</label>
            <div class="controls">
                <textarea id="disclaimer" name="disclaimer" class="span12" rows="10" cols="15"><?php echo $disclaimer;?></textarea>
            </div>
        </div>  
        <div class="control-group">
            <label class="control-label" for="dmca">DMCA Compliance</label>
            <div class="controls">
                <textarea id="dmca" name="dmca" class="span12" rows="10" cols="15"><?php echo $dmca;?></textarea>
            </div>
        </div>  
        <div class="control-group">
            <label class="control-label" for="federal">Federal Trade Commission Compliance</label>
            <div class="controls">
                <textarea id="federal" name="federal" class="span12" rows="10" cols="15"><?php echo $federal;?></textarea>
            </div>
        </div>  
        <div class="control-group">
            <label class="control-label" for="privacy">Privacy Policy</label>
            <div class="controls">
                <textarea id="privacy" name="privacy" class="span12" rows="10" cols="15"><?php echo $privacy;?></textarea>
            </div>
        </div>  
        <div class="control-group">
            <label class="control-label" for="social">Social Media Disclosure</label>
            <div class="controls">
                <textarea id="social" name="social" class="span12" rows="10" cols="15"><?php echo $social;?></textarea>
            </div>
        </div>  
        <div class="control-group">
            <label class="control-label" for="terms">Terms Of Service &amp; Conditions Of Use</label>
            <div class="controls">
                <textarea id="terms" name="terms" class="span12" rows="10" cols="15"><?php echo $terms;?></textarea>
            </div>
        </div>
        <style type="text/css">
            .main-postbox{
                width: 98%;
            }

            .side-postbox{
                display: none;
            }

            .calibrefx-metaboxes span {
                display: inline;
            }

            .control-group{
                margin-bottom: 12px;
            }
        </style>
    <?php
    }

    

}