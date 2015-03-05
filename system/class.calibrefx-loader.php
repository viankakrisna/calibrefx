<?php
/**
 * Calibrefx Loader Class
 */

class Calibrefx_Loader {

	/**
	 * Reference to the global Plugin instance
	 *
	 * @var object
	 */
	protected static $instance;

	/**
	 * List of paths to load libraries from
	 *
	 * @var array
	 */
	public $_library_paths = array();

	/**
	 * List of paths to load modules from
	 *
	 * @var array
	 */
	public $_module_paths = array();

	/**
	 * List of loaded classes
	 *
	 * @var array
	 */
	protected $_classes = array();

	/**
	 * List of loaded files
	 *
	 * @var array
	 */
	protected $_loaded_files = array();


	/**
	 * Constructor
	 *
	 * Sets the path to the helper and library files
	 *
	 * @return	void
	 */
	public function __construct() {
		$this->_library_paths = array( CALIBREFX_LIBRARY_URI );
		$this->_module_paths = array( CALIBREFX_MODULE_URI );

		$this->_classes = array();
		$this->_loaded_files = array();
	}

	/**
	 * Singleton
	 *
	 * @return  object
	 */
	public static function get_instance() {
		if ( ! self::$instance ){
			self::$instance = new Calibrefx_Loader();
		}

		return self::$instance;
	}

	/**
	 * Is Loaded
	 *
	 * A utility function to test if a class is in the self::$_classes array.
	 * This function returns the object name if the class tested for is loaded,
	 * and returns FALSE if it isn't.
	 *
	 * @param 	string	class being checked for
	 * @return 	mixed	class object name on the CI SuperObject or FALSE
	 */
	public function is_loaded( $class ) {
		return isset( $this->_classes[ $class ] ) ? $this->_classes[ $class ] : false;
	}

	/**
	 * Load all helpers
	 */
	public function load_helpers(){

		$helpers_include = apply_filters( 'calibrefx_helpers_to_include', Calibrefx::glob_php( CALIBREFX_HELPER_URI ) );

		foreach ( $helpers_include as $include ) {
			include_once $include;
		}
		do_action( 'calibrefx_helpers_loaded' );
	}

	/**
	 * Load all shortcodes
	 */
	public function load_shortcodes(){

		$shortcodes_include = apply_filters( 'calibrefx_shortcodes_to_include', Calibrefx::glob_php( CALIBREFX_SHORTCODE_URI ) );

		foreach ( $shortcodes_include as $include ) {
			include_once $include;
		}
		do_action( 'calibrefx_shortcodes_loaded' );
	}

	/**
	 * Load all hooks
	 */
	public function load_hooks(){

		$hooks_include = apply_filters( 'calibrefx_hooks_to_include', Calibrefx::glob_php( CALIBREFX_HOOK_URI ) );

		foreach ( $hooks_include as $include ) {
			include_once $include;
		}
		do_action( 'calibrefx_hooks_loaded' );
	}

	function load_widgets() {

		$widgets_include = apply_filters( 'calibrefx_widgets_to_include', Calibrefx::glob_php( CALIBREFX_WIDGET_URI ) );

		foreach ( $widgets_include as $include ) {
			include $include;
		}
	}

	/**
	 * Load all modules and shortcodes
	 */
	public function load_modules(){

		do_action( 'calibrefx_modules_loaded' );
	}

	/**
	 * Class Loader
	 *
	 * This function lets users load and instantiate classes.
	 * It is designed to be called from a user's app controllers.
	 *
	 * @param	string	the name of the class
	 * @param	mixed	the optional parameters
	 * @param	string	an optional object name
	 * @return	void
	 */
	public function library( $library = '', $params = null ) {

		if ( is_array( $library ) ) {
			foreach ( $library as $class ) {
				$this->library( $class, $params );
			}

			return;
		}

		if ( $library === '' ) {
			return false;
		}

		if ( ! is_null( $params ) && ! is_array( $params ) ) {
			$params = null;
		}

		$this->_load_class( $library, $params );
	}

	/**
	 * Load class
	 *
	 * This function loads the requested class.
	 *
	 * @param	string	the item that is being loaded
	 * @param	mixed	any additional parameters
	 * @param	string	an optional object name
	 * @return	void
	 */
	protected function _load_class( $class, $params = null ) {

		// We clean the $class to get the filename
		$class = str_replace( '.php', '', trim( $class, '/' ) );

		// We look for a slash to determine subfolder
		$subdir = '';
		if ( false !== ( $last_slash = strrpos( $class, '/' ) ) ) {
			// Extract the path
			$subdir = substr( $class, 0, ++$last_slash );

			// Get the filename from the path
			$class = substr( $class, $last_slash );
		}

		// We'll test for both lowercase and capitalized versions of the file name
		foreach ( array( ucfirst( $class ), strtolower( $class ) ) as $class ) {
			// Lets search for the requested library file and load it.
			$is_duplicate = false;
			foreach ( $this->_library_paths as $path ) {
				if ( $subdir === '' ) {
					$filepath = $path . '/' . $class . '.php'; }
				else {
					$filepath = $path . '/' . $subdir . $class . '.php'; }

				// Does the file exist? No? Bummer...
				if ( ! file_exists( $filepath ) ) {
					continue;
				}

				if ( isset( $this->_loaded_files[ $filepath ] ) ) {
					return;
				}

				include_once( $filepath );
				$this->_loaded_files[] = $filepath;
				return $this->_init_class( $class, 'CFX_', $params );
			}
		} // END FOREACH
	}

	/**
	 * Instantiates a class
	 *
	 * @param	string
	 * @param	string
	 * @param	bool
	 * @param	string	an optional object name
	 * @return	void
	 */
	protected function _init_class( $class, $prefix = '', $config = false ) {
		global $calibrefx;
		$name = $prefix . $class;

		$classvar = strtolower( $class );

		// Save the class name and object name
		$this->_classes[ $class ] = $classvar;

		if ( $config !== null ) {
			$calibrefx->$classvar = new $name( $config );
		} else {
			$calibrefx->$classvar = new $name();
		}
	}

	/**
	 * Prep filename
	 *
	 * This function preps the name of various items to make loading them more reliable.
	 *
	 * @param	mixed
	 * @param 	string
	 * @return	array
	 */
	protected function _prep_filename( $filename, $extension ) {

		if ( ! is_array( $filename ) ) {
			return array( strtolower( str_replace( array( $extension, '.php' ), '', $filename ) . $extension ) );
		} else {
			foreach ( $filename as $key => $val ) {
				$filename[ $key ] = strtolower( str_replace( array( $extension, '.php' ), '', $val ) . $extension );
			}

			return $filename;
		}
	}
}