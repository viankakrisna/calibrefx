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
        $this->load = new Calibrefx_Loader;
        $this->hooks = Calibrefx_Generator::get_instance();
        $this->model = new Calibrefx_Model;

        $this->load_theme_support();
        load_theme_textdomain( 'calibrefx', CALIBREFX_LANG_URI );

        add_action( 'calibrefx_pre_init', array( $this, 'load_helpers' ) );
        add_action( 'calibrefx_pre_init', array( $this, 'load_shortcodes' ) );
        add_action( 'calibrefx_pre_init', array( $this, 'load_modules' ) );
        
        add_action( 'calibrefx_init', array( $this, 'run_autoload' ) );

    }

    /**
     * Add our calibrefx theme support
     */
    public function load_theme_support() {
        
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

    /**
     * Load all modules and shortcodes
     */
    public function load_helpers(){
        $helpers_include = array();

        foreach ( Calibrefx::glob_php( CALIBREFX_HELPER_URI ) as $file ) {
            $helpers_include[] = $file;
        }

        $helpers_include = apply_filters( 'calibrefx_helpers_to_include', $helpers_include );

        foreach( $helpers_include as $include ) {
            include_once $include;
        }
        do_action( 'calibrefx_helpers_loaded' );
    }

    /**
     * Load all modules and shortcodes
     */
    public function load_shortcodes(){
        $shortcodes_include = array();

        foreach ( Calibrefx::glob_php( CALIBREFX_SHORTCODE_URI ) as $file ) {
            $shortcodes_include[] = $file;
        }

        $shortcodes_include = apply_filters( 'calibrefx_shortcodes_to_include', $shortcodes_include );

        foreach( $shortcodes_include as $include ) {
            include_once $include;
        }
        do_action( 'calibrefx_shortcodes_loaded' );
    }

    /**
     * Load all modules and shortcodes
     */
    public function load_modules(){

        do_action( 'calibrefx_modules_loaded' );
    }

    public function run_autoload(){
        $this->load->do_autoload();
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
}