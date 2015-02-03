<?php
class Calibrefx_Builder{

	private static $_instance = null;

    private $library_directory = 'library';

    private $excludes = array();

    private $priority = array(
    	'constants' => 1,
    	'helpers'   => 2,
    	'class'     => 3,
    	'filters'   => 4,
    	'actions'   => 5,
    	'metabox'   => 6
    );
    
    protected $templates = array();

	public static function getInstance(){
		if( is_null( self::$_instance ) ){
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	
	private function __construct(){
	    // Add a filter to the attributes metabox to inject template into the cache.
        add_filter(
			'page_attributes_dropdown_pages_args',
			 array( $this, 'set_page_template' ) 
		);
		
		// Add a filter to the save post to inject out template into the page cache
        add_filter(
			'wp_insert_post_data', 
			array( $this, 'set_page_template' ) 
		);
		
		// Add a filter to the template include to determine if the page has our 
		// template assigned and return it's path
        add_filter(
			'template_include', 
			array( $this, 'get_page_template' ) 
		);
		
		add_filter( 'the_content', array( $this, 'build_the_content' ) );

        add_action( 'init', array( $this, 'remove_elements' ), 99 );
		
		// Add your templates to this array
		$this->templates = apply_filters( 'page_builder_templates', array( 'template-page-builder.php' => 'Page Builder' ) );
	}
	
	/**
     * Adds our template to the pages cache in order to trick WordPress
     * into thinking the template file exists where it doens't really exist.
     *
     */

    public function set_page_template( $atts ) {

        // Create the key used for the themes cache
        $cache_key = 'page_templates-' . md5( get_theme_root() . '/' . get_stylesheet() );

        // Retrieve the cache list. 
		// If it doesn't exist, or it's empty prepare an array
        $templates = wp_get_theme()->get_page_templates();
        if ( empty( $templates ) ) {
                $templates = array();
        } 

        // New cache, therefore remove the old one
        wp_cache_delete( $cache_key , 'themes' );

        // Now add our template to the list of templates by merging our templates
        // with the existing templates array from the cache.
        $templates = array_merge( $templates, $this->templates );

        // Add the modified cache to allow WordPress to pick it up for listing
        // available templates
        wp_cache_add( $cache_key, $templates, 'themes', 1800 );

        return $atts;
    }
    
    public function build_the_content( $content ){
    	global $post;
    	$output = '';
    	
    	// Remove filter to avoid infinite looping
    	remove_filter( 'the_content', array( $this, 'build_the_content' ) );
    	
    	// TODO: Need to find out the best way to build the view
    	$sections = get_post_meta( get_the_ID(), 'section', true );
        
    	if( $sections ){
	    	foreach( $sections as $section_key => $section ){
                $class = !empty( $section['section_class'] )? $section['section_class'] : '';
                $style = !empty( $section['section_style'] )? $section['section_style'] : '';
                if ( $section['section_bg_image'] ) {
                    $style .= 'background-image: url(' . $section['section_bg_image'] . ')';
                }

                if ( $section['section_bg_color'] ) {
                    $style .= 'background-color: ' . $section['section_bg_color'];
                }

                if ( $section['section_bg_parallax'] ) {
                    $class .= 'parallax-bg';
                }

                $section_output = "<div id=\"section-$section_key\" class=\"section $class\" style=\"$style\">";
                if( $section['section_container'] ){
                    $section_output .= '<div class="container">';
                }

	    		if( $section['column'] ){
	    			$section_output .= "<div class=\"row\">";
                    foreach( $section['column'] as $column_key => $column ){
                        $column_class = array('col-md-'.$column['grid']);
                        if($column['offset']){
                            $column_class[] = 'col-md-offset-'.$column['offset'];
                        }
                        if($column['pull']){
                            $column_class[] = 'col-md-pull-'.$column['pull'];
                        }
                        if($column['push']){
                            $column_class[] = 'col-md-push-'.$column['push'];
                        }

                        $column_output = '<div class="'.implode(" ", $column_class).'">';

                        $return = apply_filters( 
                                    'section_content_type_' . $column['content_type'], 
                                    $section, 
                                    $section_key, 
                                    $column, 
                                    $column_key );

	    				if( !is_array( $return ) ){
	    					$column_output .= $return;
	    				}

                        $column_output .= '</div>';

                        $section_output .= $column_output;

                    }
                    $section_output .= "</div>";
	    		}

                if( $section['section_container'] ){
                    $section_output .= '</div>';
                }
                $section_output .= '</div>';

                $output .= $section_output;
	    	}
    	}
    	
    	// add back filter for later use
    	add_filter( 'the_content', array( $this, 'build_the_content' ) );
    	
        // return $content.$output;
    	return $output;
    }

    /**
     * Checks if the template is assigned to the page
     */
    public function get_page_template( $template ) {
        global $post;

        if ( !isset( $this->templates[get_post_meta( $post->ID, '_wp_page_template', true )] ) ) {
        	return $template;
        } 
		
		if( file_exists( get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'page-builder' . DIRECTORY_SEPARATOR . get_post_meta( $post->ID, '_wp_page_template', true ) ) ){
			$file = $file = dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'page-builder' . DIRECTORY_SEPARATOR . get_post_meta( $post->ID, '_wp_page_template', true );
		}else{
			$file = dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'page-template' . DIRECTORY_SEPARATOR . get_post_meta( $post->ID, '_wp_page_template', true );
		}
        
		
        // Just to be safe, we check if the file exist first
        if( file_exists( $file ) ) {
        	return $file;
        }

        return $template;
    }

    public function remove_elements(){
        remove_theme_support( 'calibrefx-inpost-layouts' );
    }

	public function excludes( $items = array() ) {
		$this->excludes = array_merge( $this->excludes, (array) $items );
	}

	public function priority( $items = array() ) {
		if( $items ){
			$this->priority = array_merge( $this->priority, $items );			
		}
	}

    private function get_items() {
    	$items = array();
    	$dirs = glob( dirname( __FILE__ ) . DIRECTORY_SEPARATOR . $this->library_directory . DIRECTORY_SEPARATOR . "*", GLOB_ONLYDIR );
    	foreach( $dirs as $dir ){
    		$basename_dir = basename($dir);
			if( !in_array( $basename_dir, $this->excludes ) ){
				if( isset( $this->priority[$basename_dir] ) ){
  					$items[$dir] = (int) $this->priority[$basename_dir];
  				}else{
					$items[$dir] = 10;
  				}
			}
		}
		asort( $items, SORT_NUMERIC );
    	return array_keys( $items );
    }

    private function get_item_file( $path ) {
    	return $path . DIRECTORY_SEPARATOR . basename( $path ) . ".php";
    }

	public function load(){
		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		$items = $this->get_items();
		foreach( $items as $item ){
			if( file_exists( $this->get_item_file( $item ) ) ){
				include( $this->get_item_file( $item ) );
			}
		}
	}
}

$calibrefx_builder = Calibrefx_Builder::getInstance();
$calibrefx_builder->load();
