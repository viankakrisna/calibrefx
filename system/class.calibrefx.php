<?php
/**
 * Calibrefx Core Class
 */
class Calibrefx {

	/**
	 * Singleton
	 *
	 * @var object
	 */
	protected static $instance;

	/**
	 * Return the Calibrefx object
	 *
	 * @return  object
	 */

	public static function get_instance() {
		if ( ! self::$instance ){
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
		add_theme_support( 'calibrefx-custom-background' );
		add_theme_support( 'calibrefx-default-styles' );
		add_theme_support( 'calibrefx-inpost-layouts' );
		add_theme_support( 'calibrefx-responsive-style' );
		add_theme_support( 'calibrefx-footer-widgets' );
		add_theme_support( 'calibrefx-header-right-widgets' );

		add_theme_support( 'custom-header', apply_filters( 'calibrefx_custom_header_args', array(
	        'default-text-color'	=> '000000',
	        'width'					=> 260,
	        'height'				=> 100,
	        'header-text'			=> get_bloginfo( 'site_title' ),
	        'wp-head-callback'		=> 'calibrefx_custom_header_style',
	    ) ) );

		if ( ! current_theme_supports( 'calibrefx-menus' ) ) {
			add_theme_support( 'calibrefx-menus', array(
				'primary' => __( 'Primary Navigation Menu', 'calibrefx' ),
				'secondary' => __( 'Secondary Navigation Menu', 'calibrefx' )
				)
			);
		}

		$menus = get_theme_support( 'calibrefx-menus' );
		foreach ( $menus as $menu ) {
			register_nav_menus( $menu );
		}

		if ( ! current_theme_supports( 'calibrefx-wraps' ) ){
			add_theme_support( 'calibrefx-wraps',
			array( 'header', 'nav', 'subnav', 'inner', 'footer', 'footer-widget' ) );
		}

		add_post_type_support( 'post', array( 'calibrefx-layouts' ) );
		add_post_type_support( 'page', array( 'calibrefx-layouts' ) );
	}

	public function run_autoload(){
		// Load required library
		$this->load->library( 'form' );

		if ( is_admin() ){
			//Only load this on admin area
			$this->load->library( 'replacer' );
			$this->load->library( 'security' );
			$this->load->library( 'walker_nav_menu_edit' );
			$this->load->library( 'shortcode' );
		} else {
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
	}

	public static function admin_url( $args = null ) {
		$args = wp_parse_args( $args, array( 'page' => 'calibrefx' ) );
		$url = add_query_arg( $args, admin_url( 'admin.php' ) );
		return $url;
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
	 * List available Calibrefx modules. Simply lists .php files in /modules/.
	 * Make sure to tuck away module "library" files in a sub-directory.
	 */
	public static function get_available_modules( ) {
		static $modules = null;

		if ( ! isset( $modules ) ) {
			$available_modules_option = get_option( 'calibrefx_available_modules', array() );
			// Use the cache if we're on the front-end and it's available...
			if ( ! is_admin() && ! empty( $available_modules_option ) ) {
				$modules = $available_modules_option;
			} else {
				$calibrefx_module_files = self::glob_php( CALIBREFX_MODULE_URI );

				$child_module_files = self::glob_php( CHILD_MODULE_URI );

				$files = array_merge( $calibrefx_module_files, $child_module_files );

				$modules = array();

				foreach ( $files as $file ) {
					if ( ! $headers = self::get_module( $file ) ) {
						continue;
					}

					$modules[ self::get_module_slug( $file ) ] = $headers['introduced'];
				}

				update_option( 'calibrefx_available_modules', $modules );
			}
		}

		$modules = apply_filters( 'calibrefx_get_available_modules', $modules );

		$r = array();
		foreach ( $modules as $slug => $introduced ) {
			$r[] = $slug;
		}

		return $r;
	}

	/**
	 * Extract a module's slug from its full path.
	 */
	public static function get_module_slug( $file ) {
		return str_replace( '.php', '', basename( $file ) );
	}

	/**
	 * Generate a module's path from its slug.
	 */
	public static function get_module_path( $slug ) {
		$child_module_files = self::glob_php( CHILD_MODULE_URI );

		if ( in_array( CHILD_MODULE_URI . "/$slug.php", $child_module_files ) ){
			return CHILD_MODULE_URI . "/$slug.php";
		}

		return CALIBREFX_MODULE_URI . "/$slug.php";
	}

	/**
	 * Load module data from module file. Headers differ from WordPress
	 * plugin headers to avoid them being identified as standalone
	 * plugins on the WordPress plugins page.
	 */
	public static function get_module( $module ) {
		$headers = array(
			'name'                => 'Module Name',
			'description'         => 'Module Description',
			'sort'                => 'Sort Order',
			'introduced'          => 'First Introduced',
			'changed'             => 'Major Changes In',
			'deactivate'          => 'Deactivate',
			'free'                => 'Free',
			'requires_connection' => 'Requires Connection',
			'auto_activate'       => 'Auto Activate',
			'module_tags'         => 'Module Tags',
		);

		$file = self::get_module_path( self::get_module_slug( $module ) );

		//Use Core's get_file_data
		$mod = get_file_data( $file, $headers );

		if ( empty( $mod['name'] ) ) {
			return false;
		}

		$mod['name']                = translate( $mod['name'], 'calibrefx' );
		$mod['description']         = translate( $mod['description'], 'calibrefx' );
		$mod['sort']                = empty( $mod['sort'] ) ? 10 : (int) $mod['sort'];
		$mod['deactivate']          = empty( $mod['deactivate'] );
		$mod['free']                = empty( $mod['free'] );
		$mod['requires_connection'] = ( ! empty( $mod['requires_connection'] ) && 'No' == $mod['requires_connection'] ) ? false : true;

		if ( empty( $mod['auto_activate'] ) || ! in_array( strtolower( $mod['auto_activate'] ), array( 'yes', 'no', 'public' ) ) ) {
			$mod['auto_activate'] = 'No';
		} else {
			$mod['auto_activate'] = (string) $mod['auto_activate'];
		}

		if ( $mod['module_tags'] ) {
			$mod['module_tags'] = explode( ',', $mod['module_tags'] );
			$mod['module_tags'] = array_map( 'trim', $mod['module_tags'] );
			$mod['module_tags'] = array_map( array( __CLASS__, 'translate_module_tag' ), $mod['module_tags'] );
		} else {
			$mod['module_tags'] = array( self::translate_module_tag( 'Other' ) );
		}

		return $mod;
	}

	public static function translate_module_tag( $untranslated_tag ) {
		return _x( $untranslated_tag, 'Module Tag', 'calibrefx' );

		// Calls here are to populate translation files.
		_x( 'Photos and Videos',   'Module Tag', 'calibrefx' );
		_x( 'Social',              'Module Tag', 'calibrefx' );
		_x( 'WordPress.com Stats', 'Module Tag', 'calibrefx' );
		_x( 'Writing',             'Module Tag', 'calibrefx' );
		_x( 'Appearance',          'Module Tag', 'calibrefx' );
		_x( 'Developers',          'Module Tag', 'calibrefx' );
		_x( 'Mobile',              'Module Tag', 'calibrefx' );
		_x( 'Other',               'Module Tag', 'calibrefx' );
	}

	/**
	 * Get a list of activated modules as an array of module slugs.
	 */
	public static function get_active_modules() {
		$active = get_option( 'calibrefx_active_modules' );
		if ( ! is_array( $active ) ){
			$active = array();
		}

		return array_unique( $active );
	}

	/**
	 * Check whether or not a Calibrefx module is active.
	 *
	 * @param string $module The slug of a Calibrefx module.
	 * @return bool
	 *
	 * @static
	 */
	public static function is_module_active( $module ) {
		return in_array( $module, self::get_active_modules() );
	}

	public static function is_module( $module ) {
		return ! empty( $module ) && ! validate_file( $module, Calibrefx::get_available_modules() );
	}

	/**
	 * Loads the currently active modules.
	 */
	public static function load_modules() {

		$modules = array_filter( self::get_active_modules(), array( 'Calibrefx', 'is_module' ) );

		$modules_data = array();

		foreach ( $modules as $module ) {
			if ( empty( $modules_data[ $module ] ) ) {
				$modules_data[ $module ] = Calibrefx::get_module( $module );
			}

			require Calibrefx::get_module_path( $module );
			do_action( 'calibrefx_module_loaded_' . $module );
		}

		do_action( 'calibrefx_modules_loaded' );
	}

	public static function activate_module( $module, $exit = true, $redirect = true ) {
		do_action( 'calibrefx_pre_activate_module', $module, $exit );

		if ( ! strlen( $module ) ) {
			return false; }

		if ( ! Calibrefx::is_module( $module ) ) {
			return false; }

		// If it's already active, then don't do it again
		$active = self::get_active_modules();
		foreach ( $active as $act ) {
			if ( $act == $module ) {
				return true; }
		}

		$module_data = self::get_module( $module );

		require Calibrefx::get_module_path( $module );
		do_action( 'calibrefx_activate_module', $module );
		$active[] = $module;
		update_option( 'calibrefx_active_modules', array_unique( $active ) );

		if ( $redirect ) {
			wp_safe_redirect( Calibrefx::admin_url( 'page=calibrefx-modules' ) );
		}
		if ( $exit ) {
			exit;
		}
	}

	public static function deactivate_module( $module ) {
		do_action( 'calibrefx_pre_deactivate_module', $module );

		$active = Calibrefx::get_active_modules();
		$new    = array_filter( array_diff( $active, (array) $module ) );

		do_action( "calibrefx_deactivate_module_$module", $module );
		return update_option( 'calibrefx_active_modules', array_unique( $new ) );
	}

	public static function sort_modules( $a, $b ) {
		if ( $a['sort'] == $b['sort'] ){
			return 0;
		}

		return ( $a['sort'] < $b['sort'] ) ? -1 : 1;
	}
}