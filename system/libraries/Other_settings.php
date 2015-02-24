<?php
/**
 * Calibrefx Other Settings Class
 *
 */
class CFX_Other_Settings extends Calibrefx_Admin {

    /**
     * Constructor - Initializes
     */
    function __construct() {
        parent::__construct();

        $this->page_id = 'calibrefx-other';
        $this->default_settings = apply_filters( 'calibrefx_other_settings_defaults', array() );

        add_action( 'calibrefx_before_save_core', array( $this,'do_export' ) );
        add_action( 'calibrefx_before_save_core', array( $this,'do_import' ) );
        $this->initialize();
    }

    /**
     * Register Our Security Filters
     *
     * $return void
     */
    public function security_filters() { }

    /**
     * Register our meta sections
     *
     * $return null
     */
    public function meta_sections() {
        global $calibrefx_current_section;

        calibrefx_clear_meta_section();

        calibrefx_add_meta_section( 'system', __( 'System Information', 'calibrefx' ), 'options.php', 1, "fa fa-cogs");
        calibrefx_add_meta_section( 'tosgen', __( 'TOS Generator', 'calibrefx' ), '', 5, "fa fa-rocket" );
        calibrefx_add_meta_section( 'importexport', __( 'Import / Export Settings', 'calibrefx' ), '', 10, "fa fa-share-square-o" );

        do_action( 'calibrefx_other_settings_meta_section' );

        $calibrefx_current_section = 'system';
        if (!empty( $_GET['section']) ) {
            $calibrefx_current_section = sanitize_text_field( $_GET['section']);
        }
    }

    public function meta_boxes() {
        //System Information
        calibrefx_add_meta_box( 'system', 'basic', 'calibrefx-about-version', __( 'Information', 'calibrefx' ), array(&$this,'info_box' ), $this->pagehook, 'main', 'high' );

        // Terms of Services Generator
        calibrefx_add_meta_box( 'tosgen', 'basic', 'calibrefx-other-settings-tosgen', __( 'TOS Generator', 'calibrefx' ), array( $this, 'tos_generator' ), $this->pagehook, 'main', 'high' );
        
        // Export - Import
        calibrefx_add_meta_box( 'importexport', 'basic', 'calibrefx-import-settings', __( 'Import Settings', 'calibrefx' ), array( $this, 'import_settings' ), $this->pagehook, 'main', 'high' );
        calibrefx_add_meta_box( 'importexport', 'basic', 'calibrefx-export-settings', __( 'Export Settings', 'calibrefx' ), array( $this, 'export_settings' ), $this->pagehook, 'main', 'high' );

        do_action( 'calibrefx_other_settings_meta_box' );
    }

    public function info_box() {
        ?>
        <p>
            <span class="description">
            Below is the CalibreFx Framework Informations. All the codes and informations is copyrighted by <a href="http://www.calibreworks.com" target="_blank">Calibreworks</a>. 
            CalibreFx is released under the GPL v2. For license information please refer to the license.txt in themes folder.
            </span>
        </p>
        <p><strong><?php _e( 'Framework Name: ', 'calibrefx' ); ?></strong><?php echo FRAMEWORK_NAME; ?> (<?php _e( 'Codename: ', 'calibrefx' ); echo FRAMEWORK_CODENAME; ?>)</p>
        <p><strong><?php _e( 'Version:', 'calibrefx' ); ?></strong> <?php echo FRAMEWORK_VERSION; ?> <?php echo '&middot;'; ?> <strong><?php _e( 'Released:', 'calibrefx' ); ?></strong> <?php echo FRAMEWORK_RELEASE_DATE; ?></p>
        <p><strong><?php _e( 'DB Version: ', 'calibrefx' ); ?></strong><?php echo FRAMEWORK_DB_VERSION; ?></p>
        <?php

        if( is_child_theme() ) { ?>
            <hr class="div" />
            <h4>Themes Information</h4>
            <p><strong><?php _e( 'Themes Name: ', 'calibrefx' ); ?></strong><?php echo CHILD_THEME_NAME; ?> </p>
            <p><strong><?php _e( 'Version:', 'calibrefx' ); ?></strong> <?php echo CHILD_THEME_VERSION; ?> </p>
            <p><strong><?php _e( 'Themes Author URL:', 'calibrefx' ); ?></strong> <?php echo CHILD_THEME_URL; ?> </p>
        <?php
        }
    }

    public function latest_news_box() {
        echo '<div>';
        wp_widget_rss_output(array(
            'url' => 'http://www.calibreworks.com/feed/',
            'title' => 'Latest news from Calibreworks Team',
            'items' => 5,
            'show_summary' => 1,
            'show_author' => 0,
            'show_date' => 1
        ) );
        echo "</div>";
    }

    public function tos_generator() {
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


if(isset( $_POST['name']) && isset( $_POST['url']) ) {

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

    $json = json_decode( $response['body']);

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
                <p class="description">Please press the button to create the page <button class="button button-secondary button-large button-ajax" data-action="create-legal-page" data-param="asp" data-nonce="<?php echo wp_create_nonce( 'cfx_create-legal-page_asp' ); ?>">Create Anti Spam Policy Page</button> </p>
            </div>
        </div>  
        <div class="control-group">
            <label class="control-label" for="cn">Copyright Notice</label>
            <div class="controls">
                <textarea id="cn" name="cn" class="span12" rows="10" cols="15"><?php echo $cn;?></textarea>
                <p class="description">Please press the button to create the page <button class="button button-secondary button-large button-ajax" data-action="create-legal-page" data-param="cn" data-nonce="<?php echo wp_create_nonce( 'cfx_create-legal-page_cn' ); ?>">Copyright Notice Page</button> </p>
            </div>
        </div>  
        <div class="control-group">
            <label class="control-label" for="disclaimer">Disclaimer</label>
            <div class="controls">
                <textarea id="disclaimer" name="disclaimer" class="span12" rows="10" cols="15"><?php echo $disclaimer;?></textarea>
                <p class="description">Please press the button to create the page <button class="button button-secondary button-large button-ajax" data-action="create-legal-page" data-param="disclaimer" data-nonce="<?php echo wp_create_nonce( 'cfx_create-legal-page_disclaimer' ); ?>">Create Disclaimer Page</button> </p>
            </div>
        </div>  
        <div class="control-group">
            <label class="control-label" for="dmca">DMCA Compliance</label>
            <div class="controls">
                <textarea id="dmca" name="dmca" class="span12" rows="10" cols="15"><?php echo $dmca;?></textarea>
                <p class="description">Please press the button to create the page <button class="button button-secondary button-large button-ajax" data-action="create-legal-page" data-param="dmca" data-nonce="<?php echo wp_create_nonce( 'cfx_create-legal-page_dmca' ); ?>">Create DMCA Page</button> </p>
            </div>
        </div>  
        <div class="control-group">
            <label class="control-label" for="federal">Federal Trade Commission Compliance</label>
            <div class="controls">
                <textarea id="federal" name="federal" class="span12" rows="10" cols="15"><?php echo $federal;?></textarea>
                <p class="description">Please press the button to create the page <button class="button button-secondary button-large button-ajax" data-action="create-legal-page" data-param="federal" data-nonce="<?php echo wp_create_nonce( 'cfx_create-legal-page_federal' ); ?>">Create Federal Compliance Page</button> </p>
            </div>
        </div>  
        <div class="control-group">
            <label class="control-label" for="privacy">Privacy Policy</label>
            <div class="controls">
                <textarea id="privacy" name="privacy" class="span12" rows="10" cols="15"><?php echo $privacy;?></textarea>
                <p class="description">Please press the button to create the page <button class="button button-secondary button-large button-ajax" data-action="create-legal-page" data-param="privacy" data-nonce="<?php echo wp_create_nonce( 'cfx_create-legal-page_privacy' ); ?>">Create Privacy Policy Page</button> </p>
            </div>
        </div>  
        <div class="control-group">
            <label class="control-label" for="social">Social Media Disclosure</label>
            <div class="controls">
                <textarea id="social" name="social" class="span12" rows="10" cols="15"><?php echo $social;?></textarea>
                <p class="description">Please press the button to create the page <button class="button button-secondary button-large button-ajax" data-action="create-legal-page" data-param="social" data-nonce="<?php echo wp_create_nonce( 'cfx_create-legal-page_social' ); ?>">Create Social Media Disclosure Page</button> </p>
            </div>
        </div>  
        <div class="control-group">
            <label class="control-label" for="terms">Terms Of Service &amp; Conditions Of Use</label>
            <div class="controls">
                <textarea id="terms" name="terms" class="span12" rows="10" cols="15"><?php echo $terms;?></textarea>
                <p class="description">Please press the button to create the page <button class="button button-secondary button-large button-ajax" data-action="create-legal-page" data-param="tos" data-nonce="<?php echo wp_create_nonce( 'cfx_create-legal-page_tos' ); ?>">Create TOS Page</button> </p>
            </div>
        </div>
        <style type="text/css">
            .main-postbox{
                width: 98%;
            }

            .side-postbox{
                display: none;
            }

            .control-group{
                margin-bottom: 12px;
            }
        </style>

        <script type="text/javascript">tos_bind_events();</script>
    <?php
    }

    public function import_settings() {
    ?>
        <p><?php _e( 'Upload the data file (<code>.json</code>) from your computer and we\'ll import your settings.', 'calibrefx' ); ?></p>
        <p><?php _e( 'Choose the file from your computer and click "Upload file and Import"', 'calibrefx' ); ?></p>
        <p>
            <input type="hidden" name="calibrefx-import" value="1" />
            <label for="calibrefx-import-upload"><?php sprintf( __( 'Upload File: (Maximum Size: %s)', 'calibrefx' ), ini_get( 'post_max_size' ) ); ?></label>
            <input type="file" id="calibrefx-import-upload" name="calibrefx-import-upload" size="25" />
            <!-- <input type="hidden" name="calibrefx_do_import" value="1" /> -->
            <br/><br/>
            <input type="submit" name="calibrefx_do_import" class="button-primary calibrefx-h2-button" value="<?php _e( 'Import Settings', 'calibrefx' ) ?>" />
        </p>
    <?php
    }

    public function export_settings() {
    ?>
        <p><span class="description"><?php _e( 'Press the download button below to export all the settings to file', 'calibrefx' ); ?></span></p>
        <p>
            <!-- <input type="hidden" name="calibrefx_do_export" value="1" /> -->
            <input type="submit" name="calibrefx_do_export" class="button-primary calibrefx-h2-button" value="<?php _e( 'Export Settings', 'calibrefx' ) ?>" />
        </p>
        
    <?php
    }

    protected function get_export_options() {
        global $calibrefx;

        $options = array(
            'theme_settings' => array(
                'label'          => __( 'Theme Settings', 'calibrefx' ),
                'settings-field' => 'calibrefx-settings',
            ),
        );

        return (array) apply_filters( 'calibrefx_export_options', $options );

    }

    public function do_export() {
        if(!$_POST) return; 

        if(empty( $_POST['calibrefx_do_export']) ) return;

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

    public function do_import() {
        if(!$_POST) return;

        if(empty( $_POST['calibrefx_do_import']) ) return;

        /** Extract file contents */
        $upload = file_get_contents( $_FILES['calibrefx-import-upload']['tmp_name'] );

        /** Decode the JSON */
        $options = json_decode( $upload, true );

        /** Check for errors */
        if ( ! $options || $_FILES['calibrefx-import-upload']['error'] ) {
            $redir_url = admin_url( 'admin.php?page=' . $this->page_id . '&section=importexport&error=true' );
            wp_redirect(esc_url_raw( $redir_url) );
            exit;
        }

        //die_dump( $options);
        /** Cycle through data, import settings */
        foreach ( (array) $options as $key => $settings ) {
            update_option( $key, $settings );
        }
        
        /** Redirect, add success flag to the URI */
        $redir_url = admin_url( 'admin.php?page=' . $this->page_id . '&section=importexport&import=true' );
        wp_redirect(esc_url_raw( $redir_url) );
        exit;
    }

}