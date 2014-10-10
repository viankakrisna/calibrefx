<?php 
/**
 * Calibrefx Core Class
 */
class Calibrefx {

    /**
     * Reference to the global Plugin instance
     *
     * @var	object
     */
    protected static $instance;

    /**
     * Return the Calibrefx object
     *
     * @return	object
     */

    public static function get_instance() {
        if( ! self::$instance ){
            self::$instance = new Calibrefx;
        }
        
        return self::$instance;
    }

    /**
     * Constructor
     */
    function __construct() {
        $this->load = Calibrefx_Loader::get_instance();
        $this->hooks = Calibrefx_Generator::get_instance();
        $this->model = new Calibrefx_Model;

        load_theme_textdomain( 'calibrefx', CALIBREFX_LANG_URI );

        // Do some initialization
        add_action( 'calibrefx_pre_init', array( $this, 'theme_support' ) );
        add_action( 'calibrefx_pre_init', array( Calibrefx_Loader::get_instance(), 'load_helpers' ) );
        add_action( 'calibrefx_pre_init', array( Calibrefx_Loader::get_instance(), 'load_shortcodes' ) );
        add_action( 'calibrefx_pre_init', array( Calibrefx_Loader::get_instance(), 'load_hooks' ) );
        add_action( 'calibrefx_pre_init', array( Calibrefx_Loader::get_instance(), 'load_widgets' ) );
        add_action( 'calibrefx_pre_init', array( Calibrefx_Loader::get_instance(), 'load_modules' ) );
        
        add_action( 'calibrefx_init', array( $this, 'run_autoload' ) );

    }

    /**
     * Add our calibrefx theme support
     */
    public function theme_support() {
        
        add_theme_support( 'calibrefx-admin-menu' );
        add_theme_support( 'calibrefx-custom-header' );
        add_theme_support( 'calibrefx-custom-background' );
        add_theme_support( 'calibrefx-default-styles' );
        add_theme_support( 'calibrefx-inpost-layouts' );
        add_theme_support( 'calibrefx-responsive-style' );
        add_theme_support( 'calibrefx-footer-widgets' );
        add_theme_support( 'calibrefx-header-right-widgets' );

        if ( !current_theme_supports( 'calibrefx-menus' ) ) {
            add_theme_support( 'calibrefx-menus', array(
                'primary' => __( 'Primary Navigation Menu', 'calibrefx' ),
                'secondary' => __( 'Secondary Navigation Menu', 'calibrefx' )
                )
            );
        }

        $menus = get_theme_support( 'calibrefx-menus' );
        foreach ( $menus as $menu ) {
            register_nav_menus( $menu);
        }

        if ( !current_theme_supports( 'calibrefx-wraps' ) ){
            add_theme_support( 'calibrefx-wraps', 
                array( 'header', 'nav', 'subnav', 'inner', 'footer', 'footer-widget' ) );
        }

        add_post_type_support( 'post', array( 'calibrefx-layouts' ) );
        add_post_type_support( 'page', array( 'calibrefx-layouts' ) );
    }

    public function run_autoload(){
        // Load required library
        $this->load->library( 'form' );
        
        if( is_admin() ){
            //Only load this on admin area        
            $this->load->library( 'replacer' );
            $this->load->library( 'security' );
            $this->load->library( 'walker_nav_menu_edit' );
        } else{
            //Only load this on frontend
            $this->load->library( 'breadcrumb' );
            $this->load->library( 'notification' );
        }
        
        $this->hooks->run_hook();
    }

    /**
     * This function will run everything
     */
    public function run() {
        
        /** Run the calibrefx_pre_init hook */
        do_action( 'calibrefx_pre_init' );

        /** Run the calibrefx_init hook */
        do_action( 'calibrefx_init' );

        /** Run the calibrefx_post_init hook */
        do_action( 'calibrefx_post_init' );
    }

    /**
     * Returns an array of all PHP files in the specified absolute path.
     * Equivalent to glob( "$absolute_path/*.php" ).
     *
     * @param string $absolute_path The absolute path of the directory to search.
     * @return array Array of absolute paths to the PHP files.
     */
    public static function glob_php( $absolute_path ) {
        $absolute_path = untrailingslashit( $absolute_path );
        $files = array();
        if ( ! $dir = @opendir( $absolute_path ) ) {
            return $files;
        }

        while ( false !== $file = readdir( $dir ) ) {
            if ( '.' == substr( $file, 0, 1 ) || '.php' != substr( $file, -4 ) ) {
                continue;
            }

            $file = "$absolute_path/$file";

            if ( ! is_file( $file ) ) {
                continue;
            }

            $files[] = $file;
        }

        closedir( $dir );

        return $files;
    }

    /**
     * Tests for file writability
     *
     * is_writable() returns TRUE on Windows servers when you really can't write to
     * the file, based on the read-only attribute. is_writable() is also unreliable
     * on Unix servers if safe_mode is on.
     *
     * @param   string
     * @return  void
     */
    public static function calibrefx_is_really_writable( $file ) {
        // If we're on a Unix server with safe_mode off we call is_writable
        if ( DIRECTORY_SEPARATOR === '/' && (bool) @ini_get( 'safe_mode' ) === FALSE ) {
            return is_writable( $file );
        }

        /* For Windows servers and safe_mode "on" installations we'll actually
         * write a file then read it. Bah...
         */
        if ( is_dir( $file ) ) {
            $file = rtrim( $file, '/' ) . '/' . md5( mt_rand( 1, 100 ) . mt_rand( 1, 100 ) );
            if ( ( $fp = @fopen( $file, FOPEN_WRITE_CREATE) ) === FALSE ) {
                return FALSE;
            }

            fclose( $fp );
            @chmod( $file, DIR_WRITE_MODE );
            @unlink( $file );
            return TRUE;
        } elseif ( !is_file( $file ) OR ( $fp = @fopen( $file, FOPEN_WRITE_CREATE ) ) === FALSE ) {
            return FALSE;
        }

        fclose( $fp );
        return TRUE;
    }
}