<?php defined( 'CALIBREFX_URL' ) OR exit();
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
 * Calibrefx Module Hooks
 *
 * @package		Calibrefx
 * @subpackage  Hook
 * @author		CalibreFx Team
 * @since		Version 1.0
 * @link		http://www.calibrefx.com
 */

/**
 * Initialize a module and include it in the process
 */
function calibrefx_initialize_module() {
	foreach ( calibrefx_get_active_modules() as $module ) {
		$module = file_exists( CALIBREFX_MODULE_URI . '/' . $module )? CALIBREFX_MODULE_URI . '/' . $module : CHILD_MODULE_URI . '/' . $module;
		include_once( $module );
	}
}
add_action( 'calibrefx_init', 'calibrefx_initialize_module', 20 );

/**
 * Activate a module
 */
function calibrefx_activate_module( $module ) {
	$active_modules = calibrefx_get_active_modules();

	//windows compatibility
	$module = str_replace("\\", "/", $module );
	$module = str_replace("//", "/", $module );
	
	if(!in_array( $module, $active_modules ) ) {
		$active_modules[] = $module;
		
		update_option( 'calibrefx_active_modules', $active_modules );
		return true;
	}
	return false;
}

function calibrefx_is_module_active( $module ) {
	$active_modules = calibrefx_get_active_modules();
	
	//windows compatibility
	$module = str_replace("\\", "/", $module );
	$CALIBREFX_MODULE_URI = str_replace("\\", "/", CALIBREFX_MODULE_URI );
	$CHILD_MODULE_URI = str_replace("\\", "/", CHILD_MODULE_URI );
	$module = str_replace( $CALIBREFX_MODULE_URI . '/', '', $module );
	$module = str_replace( $CHILD_MODULE_URI . '/', '', $module );
	return in_array( $module, $active_modules );
}

/**
 * Deactivate a module
 */
function calibrefx_deactivate_module( $module ) {
	$active_modules = calibrefx_get_active_modules();
	//windows compatibility
	$module = str_replace("\\", "/", $module );
	$module = str_replace("//", "/", $module );

	if ( in_array( $module, $active_modules) ) {
		$key = array_search( $module, $active_modules );

		unset( $active_modules[$key] );
		update_option( 'calibrefx_active_modules', $active_modules );
	}	
}

/**
 * Check the modules directory and retrieve all module files with module data.
 *
 * Calibrefx only supports module files in the base modules directory
 * (calibrefx/system/modules) and (child/app/modules). The file it looks for has the module data and
 * must be found in those two locations. It is recommended that do keep your
 * module files in directories.
 *
 * @since 1.1.0
 *
 * @return array Key is the module file path and the value is an array of the module data.
 */
function get_modules() {
	global $calibrefx;

	$cfx_modules = array();
	$module_files = array();
	foreach ( $calibrefx->load->_module_paths as $modules_path ) {
		$modules_dir = @opendir( $modules_path );
		if( $modules_dir ) {
			while ( ( $file = readdir( $modules_dir ) ) !== false ) {
				if ( substr( $file, 0, 1 ) == '.' ) {
					continue;
				}

				if ( is_dir( $modules_path.'/'.$file ) ) {
					$modules_subdir = @opendir( $modules_path . '/' . $file );
					if ( $modules_subdir ) {
						while ( ( $subfile = readdir( $modules_subdir ) ) !== false ) {
							if ( substr( $subfile, 0, 1) == '.' ) {
								continue;
							}

							if ( substr( $subfile, -4 ) == '.php' ) {
								$module_files[] = "$modules_path/$file/$subfile";
							}
						}
						closedir( $modules_subdir );
					}
				} else {
					if ( substr( $file, -4) == '.php' ) {
						$module_files[] = $file;
					}
				}
			}
			closedir( $modules_dir );
		}
	}

	if ( empty( $module_files ) ) {
		return $cfx_modules;
	}

	foreach ( $module_files as $module_file ) {
		if ( !is_readable( "$module_file" ) ) {
			continue;
		}

		$module_data = get_module_data( "$module_file", false, false );
		
		if ( empty ( $module_data['Name'] ) ) {
			continue;
		}

		$module_file = str_replace( CALIBREFX_MODULE_URI . '/', '', $module_file );
		$module_file = str_replace( CHILD_MODULE_URI . '/', '', $module_file );

		$cfx_modules[$module_file] = $module_data;
	}
	
	return $cfx_modules;
}

/**
 * Parse the module contents to retrieve module's metadata.
 *
 * The metadata of the module's data searches for the following in the module's
 * header. All module data must be on its own line. For module description, it
 * must not have any newlines or only parts of the description will be displayed
 * and the same goes for the module data. The below is formatted for printing.
 *
 * <code>
 * /*
 * Module Name: Name of Module
 * Module URI: Link to module information
 * Description: Module Description
 * Author: Module author's name
 * Author URI: Link to the author's web site
 * Version: Must be set in the module for WordPress 2.3+
 *  * / # Remove the space to close comment
 * </code>
 *
 * Module data returned array contains the following:
 *		'Name' - Name of the module, must be unique.
 *		'Title' - Title of the module and the link to the module's web site.
 *		'Description' - Description of what the module does and/or notes
 *		from the author.
 *		'Author' - The author's name
 *		'AuthorURI' - The authors web site address.
 *		'Version' - The module version number.
 *		'ModuleURI' - Module web site address.
 *
 * The module file is assumed to have permissions to allow for scripts to read
 * the file. This is not checked however and the file is only opened for
 * reading.
 *
 * @param string $module_file Path to the module file
 * @param bool $markup Optional. If the returned data should have HTML markup applied. Defaults to true.
 * @param bool $translate Optional. If the returned data should be translated. Defaults to true.
 * @return array See above for description.
 */
function get_module_data( $module_file, $markup = true, $translate = true ) {

	$default_headers = array(
		'Name' => 'Module Name',
		'ModuleURI' => 'Module URI',
		'Version' => 'Version',
		'Description' => 'Description',
		'Author' => 'Author',
		'AuthorURI' => 'Author URI',
		'TextDomain' => 'Text Domain',
		'DomainPath' => 'Domain Path',
		'Network' => 'Network',
		// Site Wide Only is deprecated in favor of Network.
		'_sitewide' => 'Site Wide Only',
	);

	$module_data = get_file_data( $module_file, $default_headers, 'module' );
	if ( $markup || $translate ) {
		$module_data = _get_module_data_markup_translate( $module_file, $module_data, $markup, $translate );
	} else {
		$module_data['Title']      = $module_data['Name'];
		$module_data['AuthorName'] = $module_data['Author'];
	}

	return $module_data;
}

/**
 * Sanitizes module data, optionally adds markup, optionally translates.
 *
 * @since 1.1.0
 * @access private
 * @see get_module_data()
 */
function _get_module_data_markup_translate( $module_file, $module_data, $markup = true, $translate = true ) {

	// Sanitize the module filename to a WP_PLUGIN_DIR relative path
	// $module_file = module_basename( $module_file );

	// Translate fields
	if ( $translate ) {
		if ( $textdomain = $module_data['TextDomain'] ) {
			if ( $module_data['DomainPath'] )
				load_module_textdomain( $textdomain, false, dirname( $module_file ) . $module_data['DomainPath'] );
			else
				load_module_textdomain( $textdomain, false, dirname( $module_file ) );
		} elseif ( in_array( basename( $module_file ), array( 'hello.php', 'akismet.php' ) ) ) {
			$textdomain = 'default';
		}
		if ( $textdomain ) {
			foreach ( array( 'Name', 'ModuleURI', 'Description', 'Author', 'AuthorURI', 'Version' ) as $field )
				$module_data[ $field ] = translate( $module_data[ $field ], $textdomain );
		}
	}

	// Sanitize fields
	$allowed_tags = $allowed_tags_in_links = array(
		'abbr'    => array( 'title' => true ),
		'acronym' => array( 'title' => true ),
		'code'    => true,
		'em'      => true,
		'strong'  => true,
	);
	$allowed_tags['a'] = array( 'href' => true, 'title' => true );

	// Name is marked up inside <a> tags. Don't allow these.
	// Author is too, but some modules have used <a> here (omitting Author URI).
	$module_data['Name']        = wp_kses( $module_data['Name'],        $allowed_tags_in_links );
	$module_data['Author']      = wp_kses( $module_data['Author'],      $allowed_tags );

	$module_data['Description'] = wp_kses( $module_data['Description'], $allowed_tags );
	$module_data['Version']     = wp_kses( $module_data['Version'],     $allowed_tags );

	$module_data['ModuleURI']   = esc_url( $module_data['ModuleURI'] );
	$module_data['AuthorURI']   = esc_url( $module_data['AuthorURI'] );

	$module_data['Title']      = $module_data['Name'];
	$module_data['AuthorName'] = $module_data['Author'];

	// Apply markup
	if ( $markup ) {
		if ( $module_data['ModuleURI'] && $module_data['Name'] )
			$module_data['Title'] = '<a href="' . $module_data['ModuleURI'] . '" title="' . esc_attr__( 'Visit module homepage' ) . '">' . $module_data['Name'] . '</a>';

		if ( $module_data['AuthorURI'] && $module_data['Author'] )
			$module_data['Author'] = '<a href="' . $module_data['AuthorURI'] . '" title="' . esc_attr__( 'Visit author homepage' ) . '">' . $module_data['Author'] . '</a>';

		$module_data['Description'] = wptexturize( $module_data['Description'] );

		if ( $module_data['Author'] )
			$module_data['Description'] .= ' <cite>' . sprintf( __( 'By %s.' ), $module_data['Author'] ) . '</cite>';
	}

	return $module_data;
}

/**
 * Get a list of a module's files.
 *
 * @since 2.8.0
 *
 * @param string $module Module ID
 * @return array List of files relative to the module root.
 */
function get_module_files( $module) {
	$module_file = WP_PLUGIN_DIR . '/' . $module;
	$dir = dirname( $module_file);
	$module_files = array( $module);
	if ( is_dir( $dir) && $dir != WP_PLUGIN_DIR ) {
		$modules_dir = @ opendir( $dir );
		if ( $modules_dir ) {
			while (( $file = readdir( $modules_dir ) ) !== false ) {
				if ( substr( $file, 0, 1) == '.' )
					continue;
				if ( is_dir( $dir . '/' . $file ) ) {
					$modules_subdir = @ opendir( $dir . '/' . $file );
					if ( $modules_subdir ) {
						while (( $subfile = readdir( $modules_subdir ) ) !== false ) {
							if ( substr( $subfile, 0, 1) == '.' )
								continue;
							$module_files[] = module_basename("$dir/$file/$subfile");
						}
						@closedir( $modules_subdir );
					}
				} else {
					if ( module_basename("$dir/$file") != $module )
						$module_files[] = module_basename("$dir/$file");
				}
			}
			@closedir( $modules_dir );
		}
	}

	return $module_files;
}