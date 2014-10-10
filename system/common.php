<?php 

/**
 * Check the php version
 * 
 * @return bool
 */
if ( !function_exists( 'is_php' ) ) {

    function is_php( $version = '5.3.0' ) {
        static $_is_php;
        $version = (string) $version;

        if ( !isset( $_is_php[$version] ) ) {
            $_is_php[$version] = ( version_compare( PHP_VERSION, $version ) >= 0 );
        }

        return $_is_php[$version];
    }
}

// ------------------------------------------------------------------------
/**
 * Get all active calibrefx modules
 * 
 * @return bool
 */
if ( !function_exists( 'calibrefx_get_active_modules' ) ) {

    function calibrefx_get_active_modules() {
        global $active_modules;
        $modules = array();
        $active_modules = (array) get_option( 'calibrefx_active_modules', array() );

        if ( empty( $active_modules ) ) {
            return $modules;
        }

        foreach ( $active_modules as $module ) {
            if ( '.php' == substr( $module, -4 ) // $module must end with '.php'
                && (
                    file_exists( CALIBREFX_MODULE_URI . '/' . $module ) OR
                    file_exists( CHILD_MODULE_URI . '/' . $module )
                ) // $module must exist
                )
            $modules[] = $module;
        }

        return $modules;
    }

}

// ------------------------------------------------------------------------
/**
 * Fire everything and display it.
 */
function calibrefx() {
    get_header();

    do_action( 'calibrefx_inner' ); 
    do_action('calibrefx_before_content_wrapper');

    $content_wrapper_class = calibrefx_row_class() . ' ' . apply_filters( 'content_wrapper_class', '' );
    ?>
    <div id="content-wrapper" class="<?php echo $content_wrapper_class; ?>" >
        <?php do_action( 'calibrefx_before_content' ); ?>
        <div id="content" class="<?php echo calibrefx_content_span(); ?>">
            <?php
            do_action( 'calibrefx_before_loop' );
            do_action( 'calibrefx_loop' );
            do_action( 'calibrefx_after_loop' );
            ?>
        </div><!-- end #content -->
        <?php do_action( 'calibrefx_after_content' ); ?>
    </div><!-- end #content-wrapper -->
    <?php
    do_action('calibrefx_after_content_wrapper');
    do_action( 'calibrefx_after_inner' ); 
    
    get_footer();
}