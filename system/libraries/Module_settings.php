<?php 
/**
 * Calibrefx Module Setting Class
 *
 */

class CFX_Module_Settings extends Calibrefx_Admin {
	/**
     * Constructor - Initializes
     */
    function __construct() {
        parent::__construct('calibrefx-modules');

        global $calibrefx;

        $this->page_id = 'calibrefx-module';
        $this->_form_method = 'get';
        $this->settings_field = apply_filters( 'calibrefx_module_field', 'calibrefx-module' );
        
        $this->initialize();

        add_action( 'load_'.$this->pagehook, array( $this, 'module_activation' ) );
    }

    public function meta_sections() {
        global $calibrefx_current_section, $calibrefx_sections;

        calibrefx_add_meta_section( 'available', __( 'Available Modules', 'calibrefx' ), '', 1);

        $calibrefx_current_section = 'available';
    }

    public function meta_boxes() {
        calibrefx_add_meta_box( 'available', 'basic', 'calibrefx-render-page', __( 'Modules Available', 'calibrefx' ), array( $this,'render_page' ), $this->pagehook, 'main', 'high' );
    }

    public function render_page() {
        $list_table = Calibrefx_Modules_List_Table::get_instance(); 

        ?>
        <div class="page-content configure">
            <div class="frame top hide-if-no-js">
                <div class="wrap">
                    <div class="manage-left">
                        <form class="jetpack-modules-list-table-form" onsubmit="return false;">
                        <table class="<?php echo implode( ' ', $list_table->get_table_classes() ); ?>">
                            <tbody id="the-list">
                                <?php $list_table->display_rows_or_placeholder(); ?>
                            </tbody>
                        </table>
                        </form>
                    </div>
                </div><!-- /.wrap -->
            </div><!-- /.frame -->
        </div>
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

    public function module_activation(){
        $list_table = Calibrefx_Modules_List_Table::get_instance(); 

        $action = $list_table->current_action();
        
        if ( $action ) {
            switch ( $action ) {
                case 'activate':  
                    $module = stripslashes( $_GET['module'] );
                    check_admin_referer( "calibrefx_activate-$module" );
                    Calibrefx::activate_module( $module );
                    
                    wp_safe_redirect( Calibrefx::admin_url( 'page=calibrefx-modules' ) );
                    exit;
                case 'deactivate':  
                    $modules = stripslashes( $_GET['module'] );
                    check_admin_referer( "calibrefx_deactivate-$modules" );
                    foreach ( explode( ',', $modules ) as $module ) {
                        Calibrefx::deactivate_module( $module );
                    }
                    wp_safe_redirect( Calibrefx::admin_url( 'page=calibrefx-modules' ) );
                    exit;
            }
        }
    }
}