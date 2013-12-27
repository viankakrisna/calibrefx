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
        global $calibrefx;
        $calibrefx->load->model('other_settings_m');
        $this->_model = $calibrefx->other_settings_m;

        add_action( 'calibrefx_before_save_core', array($this,'do_export'));
        add_action( 'calibrefx_before_save_core', array($this,'do_import'));
        $this->initialize();
    }

    /**
     * Register Our Security Filters
     *
     * $return void
     */
    public function security_filters() {
        global $calibrefx;

        $calibrefx->security->add_sanitize_filter(
                'one_zero', $this->settings_field, array(
            
            )
        );

        $calibrefx->security->add_sanitize_filter(
                'safe_text', $this->settings_field, array(
           )
        );

        $calibrefx->security->add_sanitize_filter(
                'integer', $this->settings_field, array(
            )
        );
    }

    public function meta_sections() {
        global $calibrefx_current_section;

        calibrefx_clear_meta_section();

        calibrefx_add_meta_section('tosgen', __('TOS Generator', 'calibrefx'), '');
        calibrefx_add_meta_section('importexport', __('Import / Export Settings', 'calibrefx'), '');
        //calibrefx_add_meta_section('autoresponder', __('Autoresponder Settings', 'calibrefx'));

        do_action('calibrefx_other_settings_meta_section');

        $calibrefx_current_section = 'tosgen';
        if (!empty($_GET['section'])) {
            $calibrefx_current_section = sanitize_text_field($_GET['section']);
        }
    }

    public function meta_boxes() {
        // Terms of Services Generator
        calibrefx_add_meta_box('tosgen', 'basic', 'calibrefx-other-settings-tosgen', __('TOS Generator', 'calibrefx'), array($this, 'tos_generator'), $this->pagehook, 'main', 'high');
        
        // Export - Import
        calibrefx_add_meta_box('importexport', 'basic', 'calibrefx-import-settings', __('Import Settings', 'calibrefx'), array($this, 'import_settings'), $this->pagehook, 'main', 'high');
        calibrefx_add_meta_box('importexport', 'basic', 'calibrefx-export-settings', __('Export Settings', 'calibrefx'), array($this, 'export_settings'), $this->pagehook, 'side', 'high');

        do_action('calibrefx_other_settings_meta_box');
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
            <label class="control-label" for="info">Company Address</label>
            <div class="controls">
                <textarea id="info" name="info" class="span12" rows="8" cols="15" placeholder="Type your company Address"><?php echo $info;?></textarea>
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
                <p class="description">Please press the button to create the page <button class="button button-secondary button-large button-ajax" data-action="create-legal-page" data-param="asp" data-nonce="<?php echo wp_create_nonce( 'cfx_create-legal-page_asp'); ?>">Create Anti Spam Policy Page</button> </p>
            </div>
        </div>  
        <div class="control-group">
            <label class="control-label" for="cn">Copyright Notice</label>
            <div class="controls">
                <textarea id="cn" name="cn" class="span12" rows="10" cols="15"><?php echo $cn;?></textarea>
                <p class="description">Please press the button to create the page <button class="button button-secondary button-large button-ajax" data-action="create-legal-page" data-param="cn" data-nonce="<?php echo wp_create_nonce( 'cfx_create-legal-page_cn'); ?>">Copyright Notice Page</button> </p>
            </div>
        </div>  
        <div class="control-group">
            <label class="control-label" for="disclaimer">Disclaimer</label>
            <div class="controls">
                <textarea id="disclaimer" name="disclaimer" class="span12" rows="10" cols="15"><?php echo $disclaimer;?></textarea>
                <p class="description">Please press the button to create the page <button class="button button-secondary button-large button-ajax" data-action="create-legal-page" data-param="disclaimer" data-nonce="<?php echo wp_create_nonce( 'cfx_create-legal-page_disclaimer'); ?>">Create Disclaimer Page</button> </p>
            </div>
        </div>  
        <div class="control-group">
            <label class="control-label" for="dmca">DMCA Compliance</label>
            <div class="controls">
                <textarea id="dmca" name="dmca" class="span12" rows="10" cols="15"><?php echo $dmca;?></textarea>
                <p class="description">Please press the button to create the page <button class="button button-secondary button-large button-ajax" data-action="create-legal-page" data-param="dmca" data-nonce="<?php echo wp_create_nonce( 'cfx_create-legal-page_dmca'); ?>">Create DMCA Page</button> </p>
            </div>
        </div>  
        <div class="control-group">
            <label class="control-label" for="federal">Federal Trade Commission Compliance</label>
            <div class="controls">
                <textarea id="federal" name="federal" class="span12" rows="10" cols="15"><?php echo $federal;?></textarea>
                <p class="description">Please press the button to create the page <button class="button button-secondary button-large button-ajax" data-action="create-legal-page" data-param="federal" data-nonce="<?php echo wp_create_nonce( 'cfx_create-legal-page_federal'); ?>">Create Federal Compliance Page</button> </p>
            </div>
        </div>  
        <div class="control-group">
            <label class="control-label" for="privacy">Privacy Policy</label>
            <div class="controls">
                <textarea id="privacy" name="privacy" class="span12" rows="10" cols="15"><?php echo $privacy;?></textarea>
                <p class="description">Please press the button to create the page <button class="button button-secondary button-large button-ajax" data-action="create-legal-page" data-param="privacy" data-nonce="<?php echo wp_create_nonce( 'cfx_create-legal-page_privacy'); ?>">Create Privacy Policy Page</button> </p>
            </div>
        </div>  
        <div class="control-group">
            <label class="control-label" for="social">Social Media Disclosure</label>
            <div class="controls">
                <textarea id="social" name="social" class="span12" rows="10" cols="15"><?php echo $social;?></textarea>
                <p class="description">Please press the button to create the page <button class="button button-secondary button-large button-ajax" data-action="create-legal-page" data-param="social" data-nonce="<?php echo wp_create_nonce( 'cfx_create-legal-page_social'); ?>">Create Social Media Disclosure Page</button> </p>
            </div>
        </div>  
        <div class="control-group">
            <label class="control-label" for="terms">Terms Of Service &amp; Conditions Of Use</label>
            <div class="controls">
                <textarea id="terms" name="terms" class="span12" rows="10" cols="15"><?php echo $terms;?></textarea>
                <p class="description">Please press the button to create the page <button class="button button-secondary button-large button-ajax" data-action="create-legal-page" data-param="tos" data-nonce="<?php echo wp_create_nonce( 'cfx_create-legal-page_tos'); ?>">Create TOS Page</button> </p>
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

        <script type="text/javascript">tos_bind_events();</script>
    <?php
    }

    public function import_settings(){
    ?>
        <p><?php _e( 'Upload the data file (<code>.json</code>) from your computer and we\'ll import your settings.', 'calibrefx' ); ?></p>
        <p><?php _e( 'Choose the file from your computer and click "Upload file and Import"', 'calibrefx' ); ?></p>
        <p>
            <input type="hidden" name="calibrefx-import" value="1" />
            <label for="calibrefx-import-upload"><?php sprintf( __( 'Upload File: (Maximum Size: %s)', 'calibrefx' ), ini_get( 'post_max_size' ) ); ?></label>
            <input type="file" id="calibrefx-import-upload" name="calibrefx-import-upload" size="25" />
            <!-- <input type="hidden" name="calibrefx_do_import" value="1" /> -->
            <br/><br/>
            <input type="submit" name="calibrefx_do_import" class="button-primary calibrefx-h2-button" value="<?php _e('Import Settings', 'calibrefx') ?>" />
        </p>
    <?php
    }

    public function export_settings(){
    ?>
        <p><span class="description"><?php _e('Press the download button below to export all the settings to file', 'calibrefx'); ?></span></p>
        <p>
            <!-- <input type="hidden" name="calibrefx_do_export" value="1" /> -->
            <input type="submit" name="calibrefx_do_export" class="button-primary calibrefx-h2-button" value="<?php _e('Export Settings', 'calibrefx') ?>" />
        </p>
        
    <?php
    }

    /*public function autoresponder_settings(){
    ?>
        <p>
            <label for="autoresponder_type"><strong><?php _e('Choose your autoresponder:', 'calibrefx'); ?></strong></label>
            <select name="<?php echo $this->settings_field; ?>[autoresponder_type]" id="autoresponder_type">
                <option value="-1" <?php echo ($this->_model->get('autoresponder_type') == -1)? ' selected="selected"' : '' ?>>Disabled</option>
                <option value="mailventure" <?php echo ($this->_model->get('autoresponder_type') == 'mailventure')? ' selected="selected"' : '' ?>>Mailventure</option>
                <option value="aweber" <?php echo ($this->_model->get('autoresponder_type') == 'aweber')? ' selected="selected"' : '' ?>>Aweber</option>
                <option value="getresponse" <?php echo ($this->_model->get('autoresponder_type') == 'getresponse')? ' selected="selected"' : '' ?>>GetResponse</option>
            </select>
            <span class="description"><?php _e("Choose your autoreponsder. If you do not want to integrate choose disabled.", 'calibrefx'); ?></span>
        </p> 

        <div id="autoresponder_aweber_container" style="display:none">
            <hr class="div" />

            <p>
                <label for="<?php echo $this->settings_field; ?>[autoreponder_aweber]"><strong><?php _e('Aweber Forms', 'calibrefx'); ?></strong></label>
                <textarea name="<?php echo $this->settings_field; ?>[autoreponder_aweber]" cols="78" rows="8"><?php echo stripslashes(esc_textarea($this->_model->get('autoreponder_aweber'))); ?></textarea>
            </p>

            <p><span class="description"><?php _e('Paste your aweber form for your aweber', 'calibrefx'); ?></span></p>
        </div>

        <div id="autoresponder_getresponse_container" style="display:none">
            <hr class="div" />

            <p>
                <label for="<?php echo $this->settings_field; ?>[autoreponder_getresponse_api]"><strong><?php _e('GetResponse API Key', 'calibrefx'); ?></strong></label>
                <input type="text" size="30" value="<?php echo $this->_model->get('autoreponder_getresponse_api'); ?>" id="<?php echo $this->settings_field; ?>[autoreponder_getresponse_api]" name="<?php echo $this->settings_field; ?>[autoreponder_getresponse_api]" />
                <label for="<?php echo $this->settings_field; ?>[autoreponder_getresponse_campaign]"><strong><?php _e('GetResponse Campaign Name', 'calibrefx'); ?></strong></label>
                <input type="text" size="30" value="<?php echo $this->_model->get('autoreponder_getresponse_campaign'); ?>" id="<?php echo $this->settings_field; ?>[autoreponder_getresponse_campaign]" name="<?php echo $this->settings_field; ?>[autoreponder_getresponse_campaign]" />
            </p>

            <p><span class="description"><?php _e('GetResponse API Key and Campaign', 'calibrefx'); ?></span></p>
            <div class="controls">
                <a class="button-primary calibrefx-h2-button check-getresponse" href="#">Check</a>
                <span class="result hidden"></span>
            </div>
            <script type="text/javascript">
                jQuery(document).ready(function($){
                    $('.check-getresponse').click(function(){
                        $this = $(this);

                        var data = {
                            action: 'check_getresponse_api'
                        };
                        

                        $.post(ajaxurl , data, function(response) {
                            console.info(response);
                            if(response.status == 'success'){
                                $this.siblings().html(response.message);
                            }
                        }, "json");

                        return false;
                    });
                });
            </script>
        </div>

        <div id="autoresponder_mailventure_container" style="display:none">
            <hr class="div" />

            <p>
                <label for="<?php echo $this->settings_field; ?>[autoreponder_mailventure_url]"><strong><?php _e('MailVenture API URL', 'calibrefx'); ?></strong></label>
                <input type="text" size="30" value="<?php echo $this->_model->get('autoreponder_mailventure_url'); ?>" id="<?php echo $this->settings_field; ?>[autoreponder_mailventure_url]" name="<?php echo $this->settings_field; ?>[autoreponder_mailventure_url]" />

                <label for="<?php echo $this->settings_field; ?>[autoreponder_mailventure_api]"><strong><?php _e('MailVenture API Key', 'calibrefx'); ?></strong></label>
                <input type="text" size="30" value="<?php echo $this->_model->get('autoreponder_mailventure_api'); ?>" id="<?php echo $this->settings_field; ?>[autoreponder_mailventure_api]" name="<?php echo $this->settings_field; ?>[autoreponder_mailventure_api]" />
                
                <label for="<?php echo $this->settings_field; ?>[autoreponder_mailventure_campaign]"><strong><?php _e('Campaign ID', 'calibrefx'); ?></strong></label>
                <input type="text" size="30" value="<?php echo $this->_model->get('autoreponder_mailventure_campaign'); ?>" id="<?php echo $this->settings_field; ?>[autoreponder_mailventure_campaign]" name="<?php echo $this->settings_field; ?>[autoreponder_mailventure_campaign]" />

                <label for="<?php echo $this->settings_field; ?>[autoreponder_mailventure_form]"><strong><?php _e('Form ID', 'calibrefx'); ?></strong></label>
                <input type="text" size="30" value="<?php echo $this->_model->get('autoreponder_mailventure_form'); ?>" id="<?php echo $this->settings_field; ?>[autoreponder_mailventure_form]" name="<?php echo $this->settings_field; ?>[autoreponder_mailventure_form]" />
            </p>

            <p><span class="description"><?php _e('Paste your Mailventure Form. Dont\'t have one? FREE REGISTER <a href="http://www.mailventure.com" target="_blank">here</a>.', 'calibrefx'); ?></span></p>
        </div>

        <script type="text/javascript">
            jQuery(document).ready(function($){
                var autoresponder_type = $('#autoresponder_type').find('option:selected').val();

                switch(autoresponder_type){
                    case "aweber": 
                        $('#autoresponder_aweber_container').show();
                        break;
                    case "getresponse": 
                        $('#autoresponder_getresponse_container').show();
                        break;
                    case "mailventure": 
                        $('#autoresponder_mailventure_container').show();
                        break;
                    default: 
                        $('#autoresponder_aweber_container').hide();
                        $('#autoresponder_getresponse_container').hide();
                        $('#autoresponder_mailventure_container').hide();
                        break;
                }   

                $('#autoresponder_type').change(function(){
                    var autoresponder_type_sel = $(this).find('option:selected').val();

                    switch(autoresponder_type_sel){
                        case "aweber": 
                            $('#autoresponder_aweber_container').slideDown();
                            $('#autoresponder_getresponse_container').slideUp();
                            $('#autoresponder_mailventure_container').slideUp();
                            break;
                        case "getresponse": 
                            $('#autoresponder_aweber_container').slideUp();
                            $('#autoresponder_getresponse_container').slideDown();
                            $('#autoresponder_mailventure_container').slideUp();
                            break;
                        case "mailventure": 
                            $('#autoresponder_aweber_container').slideUp();
                            $('#autoresponder_getresponse_container').slideUp();
                            $('#autoresponder_mailventure_container').slideDown();
                            break;
                        default: 
                            $('#autoresponder_aweber_container').slideUp();
                            $('#autoresponder_getresponse_container').slideUp();
                            $('#autoresponder_mailventure_container').slideUp();
                            break;
                    }
                });
            });
        </script>
    <?php    
    }*/

    protected function get_export_options() {
        $CFX = & calibrefx_get_instance();

        $options = array(
            'theme_settings' => array(
                'label'          => __( 'Theme Settings', 'calibrefx' ),
                'settings-field' => $CFX->theme_settings_m->get_settings_field(),
            ),
            'seo_settings' => array(
                'label' => __( 'SEO Settings', 'calibrefx' ),
                'settings-field' => $CFX->seo_settings_m->get_settings_field(),
            )
        );

        return (array) apply_filters( 'calibrefx_export_options', $options );

    }

    public function do_export(){
        if(!$_POST) return; 

        if(empty($_POST['calibrefx_do_export'])) return;

        $options = $this->get_export_options();
        
        $settings = array();
        
        foreach ( $options as $option ) {
            /** Grab settings field name (key) */
            $settings_field = $option['settings-field'];

            /** Grab all of the settings from the database under that key */
            $settings[$settings_field] = get_option( $settings_field );
        }

        /** Check there's something to export */
        if ( ! $settings )
            return;

        $output = json_encode( (array) $settings );

        /** Prepare and send the export file to the browser */
        header( 'Content-Description: File Transfer' );
        header( 'Cache-Control: public, must-revalidate' );
        header( 'Pragma: hack' );
        header( 'Content-Type: text/plain' );
        header( 'Content-Disposition: attachment; filename="calibrefx-' . date( 'Ymd-His' ) . '.json"' );
        header( 'Content-Length: ' . strlen( $output ) );
        echo $output;
        exit;
    }

    public function do_import(){
        if(!$_POST) return;

        if(empty($_POST['calibrefx_do_import'])) return;

        /** Extract file contents */
        $upload = file_get_contents( $_FILES['calibrefx-import-upload']['tmp_name'] );

        /** Decode the JSON */
        $options = json_decode( $upload, true );

        /** Check for errors */
        if ( ! $options || $_FILES['calibrefx-import-upload']['error'] ) {
            $redir_url = admin_url( 'admin.php?page=' . $this->page_id . '&section=importexport&error=true' );
            wp_redirect(esc_url_raw($redir_url));
            exit;
        }

        //die_dump($options);
        /** Cycle through data, import settings */
        foreach ( (array) $options as $key => $settings ){
            update_option( $key, $settings );
        }
        
        /** Redirect, add success flag to the URI */
        $redir_url = admin_url( 'admin.php?page=' . $this->page_id . '&section=importexport&import=true' );
        wp_redirect(esc_url_raw($redir_url));
        exit;
    }

}