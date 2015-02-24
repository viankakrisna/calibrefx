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
		$this->templates = self::template_pages();

        add_action( 'calibrefx_meta', array( $this, 'builder_styles' ) );
        add_action( 'calibrefx_meta', array( $this, 'builder_scripts' ) );
        
        add_action( 'admin_enqueue_scripts', array( $this, 'builder_admin_script' ), 10, 1 );

	}
	
	public static function template_pages(){
	    return apply_filters( 'vp_get_builder_template_pages', array( 'template-page-builder.php' => 'Page Builder' ) );
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

        $include_templates = SELF::template_pages();
        $current_template = basename( get_page_template_slug( ) );

        if( !array_key_exists( $current_template, $include_templates ) ) return $content;
    	
    	// Remove filter to avoid infinite looping
    	remove_filter( 'the_content', array( $this, 'build_the_content' ) );
    	
    	// TODO: Need to find out the best way to build the view
    	$sections = get_post_meta( get_the_ID(), 'section', true );
        
    	if( $sections ){
	    	foreach( $sections as $section_key => $section ){
	    	    $class = array('section');
	    	    $style = array();
	    	    if(!empty( $section['section_class'] )) $class[] = $section['section_class'];
                if(!empty( $section['section_style'] )) $style[] = $section['section_style'];
                
                if ( isset( $section['section_bg'][0]['section_bg_color'] ) && !empty( $section['section_bg'][0]['section_bg_color'] ) ) {
                   $style[] = 'background-color: ' . $section['section_bg'][0]['section_bg_color'];
                }

                if ( isset( $section['section_bg'][0]['section_bg_image'] ) && !empty( $section['section_bg'][0]['section_bg_image'] ) ) {
                    $style[] = 'background-image: url(' . $section['section_bg'][0]['section_bg_image'] . ')';
                }
                
                if ( isset( $section['section_bg'][0]['section_bg_parallax'] ) && !empty( $section['section_bg'][0]['section_bg_parallax'] ) ) {
                    $class[] = 'paraxify';
                }else{
                    if ( isset( $section['section_bg'][0]['section_bg_size'] ) && !empty( $section['section_bg'][0]['section_bg_size'] ) ) {
                        $style[] = 'background-size: ' . $section['section_bg'][0]['section_bg_size'];
                    }
    
                    if ( isset( $section['section_bg'][0]['section_bg_position'] ) && !empty( $section['section_bg'][0]['section_bg_position'] ) ) {
                        $style[] = 'background-position: ' . $section['section_bg'][0]['section_bg_position'];
                    }
    
                    if ( isset( $section['section_bg'][0]['section_bg_repeat'] ) && !empty( $section['section_bg'][0]['section_bg_repeat'] ) ) {
                        $style[] = 'background-repeat: ' . $section['section_bg'][0]['section_bg_repeat'];
                    }
                }
                
                $section_output = "<div id=\"section-$section_key\" class=\"".implode(" ", $class)."\" style=\"".implode(";", $style)."\">";
                if( isset( $section['section_container'] ) && !empty( $section['section_container'] ) ){
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

                        if($column['content']){
                            foreach ($column['content'] as $element_key => $element) {
                                $return = apply_filters( 
                                    'section_content_type_' . $element['content_type'], 
                                    $element[$element['content_type']],
                                    $element_key,
                                    $column_key,
                                    $section_key
                                );

                                if( is_string( $return ) ){
                                    $column_output .= $return;
                                }       
                            }
                        }

                        $column_output .= '</div>';

                        $section_output .= $column_output;

                    }
                    $section_output .= "</div>";
	    		}

                if( isset( $section['section_container'] ) ){
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
			$file = dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'page-builder' . DIRECTORY_SEPARATOR . get_post_meta( $post->ID, '_wp_page_template', true );
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

    public function builder_styles(){
        wp_enqueue_style( 'paraxify', CALIBREFX_MODULE_URL . '/page-builder/assets/css/paraxify.css' );
        wp_enqueue_style( 'calibrefx-builder', CALIBREFX_MODULE_URL . '/page-builder/assets/css/builderfx.css' );
    }

    public function builder_scripts(){
        wp_enqueue_script( 'paraxify', CALIBREFX_MODULE_URL . '/page-builder/assets/js/paraxify.js' );
        wp_enqueue_script( 'calibrefx-builder', CALIBREFX_MODULE_URL . '/page-builder/assets/js/builderfx.js' );
    }

    public function builder_admin_script( $hook ){
        global $post;
        
        //Only load on page
        if ( $hook == 'post-new.php' || $hook == 'post.php' ) {
            if ( 'page' === $post->post_type ) {     
                wp_enqueue_script( 'calibrefx-builder-admin', CALIBREFX_MODULE_URL . '/page-builder/assets/js/page-builder-admin.js' );
                wp_enqueue_style( 'calibrefx-builder-admin', CALIBREFX_MODULE_URL . '/page-builder/assets/css/page-builder-admin.css' );
            }
        }
    }
}

$calibrefx_builder = Calibrefx_Builder::getInstance();
$calibrefx_builder->load();
