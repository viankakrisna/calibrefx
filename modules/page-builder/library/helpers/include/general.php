<?php
function vp_get_formidable_forms() {
    $result = array();
    if( !class_exists( 'FrmForm' ) ){
        return $result;
    }
    $where = apply_filters('frm_forms_dropdown', " (status is NULL OR status = '' OR status = 'published' ) AND default_template=0", '' );
	//@TODO: This cause error in Formidable create template
    $frm_form = new FrmForm();
	$forms = $frm_form->getAll($where, ' ORDER BY name' );
	foreach($forms as $form){
		$result[] = array('value' => $form->id, 'label' => $form->name);
	}
    return $result;
}

function vp_get_menu(){
    $result = array();

    $menus = wp_get_nav_menus( );
    foreach ($menus as $menu) {
        $result[] = array('value' => $menu->slug, 'label' => $menu->name);   
    }

    return $result;
}

function vp_get_post_type(){
    $result = array();

    $post_types = get_post_types( array( 'public' => true ), 'objects' );
    foreach ($post_types as $post_type) {
        $result[] = array('value' => $post_type->name, 'label' => $post_type->labels->singular_name);   
    }

    return $result;   
}

function vp_get_revolution_sliders() {    
    $result = array();
    if( !class_exists( 'RevSlider' ) ){
        return $result;
    }
    
    $sliders = new RevSlider();
    foreach ( $sliders->getAllSliderAliases() as $slider ) {
        $result[] = array( 'value' => $slider, 'label' => $slider );
    }
    return $result;
}

function vp_get_autoresponder_providers(){
    $result = array();
    $result[] = array( 'value' => 'mailventure', 'label' => 'Mailventure' );
    $result[] = array( 'value' => 'aweber', 'label' => 'Aweber' );
    $result[] = array( 'value' => 'getresponse', 'label' => 'Getresponse' );
    $result[] = array( 'value' => 'other', 'label' => 'Other' );
    return $result;
}

function vp_get_content_type_list(){
    $result = array();
    $result[] = array(
        'value' => 'autoresponder',
        'label' => __( 'Autoresponder Form', 'calibrefx' )
    );
    if( class_exists( 'FrmForm' ) ){
        $result[] = array(
            'value' => 'formidable',
            'label' => __( 'Formidable', 'calibrefx' )
        );
    }
    $result[] = array(
		'value' => 'google_map',
		'label' => __( 'Google Map', 'calibrefx' )
	);
    $result[] = array(
        'value' => 'heading',
        'label' => __( 'Heading', 'calibrefx' )
    );
    $result[] = array(
        'value' => 'html_editor',
        'label' => __( 'HTML Editor', 'calibrefx' )
    );
    $result[] = array(
        'value' => 'image',
        'label' => __( 'Image', 'calibrefx' )
    );
    $result[] = array(
        'value' => 'menu',
        'label' => __( 'Menu', 'calibrefx' )
    );
    $result[] = array(
        'value' => 'archive',
        'label' => __( 'Post Archive', 'calibrefx' )
    );
    $result[] = array(
        'value' => 'raw_html',
        'label' => __( 'Raw HTML', 'calibrefx' )
    );
    $result[] = array(
        'value' => 'simple_text',
        'label' => __( 'Simple Text', 'calibrefx' )
    );

    $result[] = array(
		'value' => 'slider',
		'label' => __( 'Slider', 'calibrefx' )
	);
        
	if( class_exists( 'RevSlider' ) ){
        $result[] = array(
    		'value' => 'slider_revolution',
    		'label' => __( 'Slider Revolution', 'calibrefx' )
    	);
	}
	
    return apply_filters( 'vp_get_content_type_list', $result);
}

function vp_get_content_type_fields(){
    $result = array();
    $result[] = array(
		'type' => 'select',
		'name' => 'content_type',
		'label' => __( 'Content Type', 'calibrefx' ),
		'items' => array(
			'data' => array(
				array(
					'source' => 'function',
					'value'  => 'vp_get_content_type_list',
				)
			)
		)
	);
    foreach( vp_get_content_type_list() as $content_type ){
        $content_type_function = 'vp_content_type_field_' . $content_type['value'];
        if( function_exists( $content_type_function ) ){
            $result[] = call_user_func( $content_type_function );
        }
    }
    return apply_filters( 'vp_get_content_type_fields', $result );
}

/**
 * We Define All the Elements Field Below
 */

function vp_content_type_field_autoresponder(){

    $fields = array(
        'type'      => 'group',
        'repeating' => false,
        'sortable'  => false,
        'name'      => 'autoresponder',
        'title'     => __( 'Autoresponder Settings', 'calibrefx' ),
        'dependency' => array(
            'field' => 'content_type',
            'function' => 'vp_dep_custom',
        ),
        'fields'    => array(
            array(
                'type' => 'select',
                'name' => 'provider',
                'validation' => 'required',
                'label' => __( 'Provider', 'calibrefx' ),
                'items' => array(
                    'data' => array(
                        array(
                            'source' => 'function',
                            'value' => 'vp_get_autoresponder_providers'
                        )
                    )
                )
            ),
            array(
                'type' => 'textbox',
                'name' => 'api_url',
                'validation' => 'required',
                'label' => __( 'Api Url', 'calibrefx' ),
                'dependency' => array(
                    'field' => 'provider',
                    'function' => 'vp_dep_custom',
                ),
            ),
            array(
                'type' => 'textbox',
                'name' => 'api_key',
                'validation' => 'required',
                'label' => __( 'Api Key', 'calibrefx' ),
                'dependency' => array(
                    'field' => 'provider',
                    'function' => 'vp_dep_custom',
                ),
            ),
            array(
                'type' => 'textbox',
                'name' => 'campaign_name',
                'validation' => 'required',
                'label' => __( 'Campaign Name', 'calibrefx' ),
                'dependency' => array(
                    'field' => 'provider',
                    'function' => 'vp_dep_custom',
                ),
            ),
            array(
                'type' => 'textbox',
                'name' => 'form_id',
                'validation' => 'required',
                'label' => __( 'Form ID', 'calibrefx' ),
                'dependency' => array(
                    'field' => 'provider',
                    'function' => 'vp_dep_custom',
                ),
            ),
            array(
                'type' => 'textarea',
                'name' => 'form_code',
                'validation' => 'required',
                'label' => __( 'Autoresponder Form Code', 'calibrefx' ),
                'dependency' => array(
                    'field' => 'provider',
                    'function' => 'vp_dep_custom',
                ),
            ),
            array(
                'type' => 'textbox',
                'name' => 'css_class',
                'validation' => 'required',
                'label' => __( 'CSS Class', 'calibrefx' ),
            ),
        ),
    );

    return apply_filters( 'vp_content_type_field_autoresponder', $fields );
}

function vp_content_type_field_formidable(){
    $fields = array(
        'type'      => 'group',
        'repeating' => false,
        'sortable'  => false,
        'name'      => 'formidable',
        'title'     => __( 'Formidable Settings', 'calibrefx' ),
        'dependency' => array(
            'field' => 'content_type',
            'function' => 'vp_dep_custom',
        ),
        'fields'    => array(
            array(
                'type' => 'select',
                'name' => 'form_id',
                'validation' => 'required',
                'label' => __( 'Choose Form', 'calibrefx' ),
                'items' => array(
                    'data' => array(
                        array(
                            'source' => 'function',
                            'value' => 'vp_get_formidable_forms'
                        )
                    )
                )
            ),
            array(
                'type' => 'textbox',
                'name' => 'css_class',
                'label' => __( 'CSS Class', 'calibrefx' ),
            ),
        )
    );

    return apply_filters( 'vp_content_type_field_formidable', $fields );
}

function vp_content_type_field_google_map(){
    $fields = array(
        'type'      => 'group',
        'repeating' => false,
        'sortable'  => false,
        'name'      => 'google_map',
        'title'     => __( 'Google Map Settings', 'calibrefx' ),
        'dependency' => array(
            'field' => 'content_type',
            'function' => 'vp_dep_custom',
        ),
        'fields'    => array(
            array(
                'type' => 'upload',
                'name' => 'image',
                'validation' => 'required',
                'label' => __( 'Icon Marker', 'calibrefx' )
            ),
            array(
                'type' => 'textbox',
                'name' => 'latitude',
                'label' => __( 'Latitude', 'calibrefx' ),
            ),
            array(
                'type' => 'textbox',
                'name' => 'longitude',
                'validation' => 'required',
                'label' => __( 'Longitude', 'calibrefx' ),
            ),
            array(
                'type' => 'textbox',
                'name' => 'zoom',
                'validation' => 'required',
                'label' => __( 'Zoom', 'calibrefx' ),
            ),
            array(
                'type' => 'textbox',
                'name' => 'height',
                'validation' => 'required',
                'label' => __( 'Height', 'calibrefx' ),
            ),
            array(
                'type' => 'textbox',
                'name' => 'title',
                'validation' => 'required',
                'label' => __( 'Title', 'calibrefx' ),
            ),
            array(
                'type' => 'textarea',
                'name' => 'address',
                'validation' => 'required',
                'label' => __( 'Address Line', 'calibrefx' ),
            ),
        )
    );

    return apply_filters( 'vp_content_type_field_google_map', $fields );
}

function vp_content_type_field_heading(){
    $fields = array(
        'type'      => 'group',
        'repeating' => false,
        'sortable'  => false,
        'name'      => 'heading',
        'title'     => __( 'Heading Settings', 'calibrefx' ),
        'dependency' => array(
            'field' => 'content_type',
            'function' => 'vp_dep_custom',
        ),
        'fields'    => array(
            array(
                'type' => 'textbox',
                'name' => 'header_text',
                'validation' => 'required',
                'label' => __( 'Header Text', 'calibrefx' ),
            ),
            array(
                'type' => 'textbox',
                'name' => 'sub_header_text',
                'validation' => 'required',
                'label' => __( 'Sub Header Text', 'calibrefx' ),
            ),
            array(
                'type' => 'select',
                'name' => 'heading_alignment',
                'validation' => 'required',
                'label' => __( 'Alignment', 'calibrefx' ),
                'items' => array(
                    array(
                        'value' => 'left',
                        'label' => __('Left', 'calibrefx' ),
                    ),
                    array(
                        'value' => 'center',
                        'label' => __('Center', 'calibrefx' ),
                    ),
                    array(
                        'value' => 'right',
                        'label' => __('Right', 'calibrefx' ),
                    ),
                )
            ),
            array(
                'type' => 'upload',
                'name' => 'heading_icon',
                'validation' => 'required',
                'label' => __( 'Icon', 'calibrefx' ),
                'dependency' => array(
                    'field' => 'heading_alignment',
                    'function' => 'vp_dep_custom',
                )
            ),
        )
    );

    return apply_filters( 'vp_content_type_field_heading', $fields );
}

function vp_content_type_field_image(){
    $fields = array(
        'type'      => 'group',
        'repeating' => false,
        'sortable'  => false,
        'name'      => 'image',
        'title'     => __( 'Image Settings', 'calibrefx' ),
        'dependency' => array(
            'field' => 'content_type',
            'function' => 'vp_dep_custom',
        ),
        'fields'    => array(
            array(
                'type' => 'upload',
                'name' => 'image_url',
                'validation' => 'required',
                'label' => __( 'Image URL', 'calibrefx' ),
            ),
            array(
                'type' => 'textbox',
                'name' => 'alt_text',
                'validation' => 'required',
                'label' => __( 'Alternative Text', 'calibrefx' ),
            ),
            array(
                'type' => 'textbox',
                'name' => 'link',
                'validation' => 'required',
                'label' => __( 'URL', 'calibrefx' ),
            ),
            array(
                'type' => 'toggle',
                'name' => 'link_target',
                'label' => __( 'Open in New Tab', 'calibrefx' ),
                'dependency' => array(
                    'field' => 'link',
                    'function' => 'vp_dep_boolean',
                ),
            ),
            array(
                'type' => 'select',
                'name' => 'image_alignment',
                'validation' => 'required',
                'label' => __( 'Alignment', 'calibrefx' ),
                'items' => array(
                    array(
                        'value' => 'left',
                        'label' => __('Left', 'calibrefx' ),
                    ),
                    array(
                        'value' => 'center',
                        'label' => __('Center', 'calibrefx' ),
                    ),
                    array(
                        'value' => 'right',
                        'label' => __('Right', 'calibrefx' ),
                    ),
                )
            ),
            array(
                'type' => 'select',
                'name' => 'image_animation',
                'label' => __( 'Animation', 'calibrefx' ),
                'items' => array(
                    array(
                        'value' => 'fade_in',
                        'label' => __('Fade In', 'calibrefx' ),
                    ),
                    array(
                        'value' => 'fade_in_left',
                        'label' => __('Fade in From Left', 'calibrefx' ),
                    ),
                    array(
                        'value' => 'fade_in_right',
                        'label' => __('Fade In From Right', 'calibrefx' ),
                    ),
                    array(
                        'value' => 'grow_in',
                        'label' => __('Grow In', 'calibrefx' ),
                    ),
                )
            ),
            array(
                'type' => 'textbox',
                'name' => 'delay',
                'validation' => 'required',
                'label' => __( 'Delay', 'calibrefx' ),
                'dependency' => array(
                    'field' => 'image_animation',
                    'function' => 'vp_dep_boolean',
                ),
            ),
            array(
                'type' => 'textbox',
                'name' => 'css_class',
                'validation' => 'required',
                'label' => __( 'CSS Class', 'calibrefx' ),
            ),
        )
    );

    return apply_filters( 'vp_content_type_field_image', $fields );
}

function vp_content_type_field_html_editor(){
    $fields = array(
        'type'      => 'group',
        'repeating' => false,
        'sortable'  => false,
        'name'      => 'html_editor',
        'title'     => __( 'Content Settings', 'calibrefx' ),
        'dependency' => array(
            'field' => 'content_type',
            'function' => 'vp_dep_custom',
        ),
        'fields'    => array(
            array(
                'type' => 'wpeditor',
                'name' => 'html_content',
                'validation' => 'required',
                'label' => __( 'Content', 'calibrefx' ),
            ),
        )
    );

    return apply_filters( 'vp_content_type_field_html_editor', $fields );
}

function vp_content_type_field_menu(){
    $fields = array(
        'type'      => 'group',
        'repeating' => false,
        'sortable'  => false,
        'name'      => 'menu',
        'title'     => __( 'Menu', 'calibrefx' ),
        'dependency' => array(
            'field' => 'content_type',
            'function' => 'vp_dep_custom',
        ),
        'fields'    => array(
            array(
                'type' => 'select',
                'name' => 'menu_id',
                'validation' => 'required',
                'label' => __( 'Choose Menu', 'calibrefx' ),
                'items' => array(
                    'data' => array(
                        array(
                            'source' => 'function',
                            'value' => 'vp_get_menu'
                        )
                    )
                )
            ),
            array(
                'type' => 'textbox',
                'name' => 'css_class',
                'validation' => 'required',
                'label' => __( 'CSS Class', 'calibrefx' ),
            ),
        )
    );

    return apply_filters( 'vp_content_type_field_menu', $fields );
}

function vp_content_type_field_archive(){
    $fields = array(
        'type'      => 'group',
        'repeating' => false,
        'sortable'  => false,
        'name'      => 'archive',
        'title'     => __( 'Archive', 'calibrefx' ),
        'dependency' => array(
            'field' => 'content_type',
            'function' => 'vp_dep_custom',
        ),
        'fields'    => array(
            array(
                'type' => 'select',
                'name' => 'post_type',
                'validation' => 'required',
                'label' => __( 'Post Type', 'calibrefx' ),
                'items' => array(
                    'data' => array(
                        array(
                            'source' => 'function',
                            'value' => 'vp_get_post_type'
                        )
                    )
                )
            ),
            array(
                'type' => 'textbox',
                'name' => 'posts_per_page',
                'label' => __( 'Posts per page', 'calibrefx' ),
            ),
            array(
                'type' => 'toggle',
                'name' => 'show_pagination',
                'label' => __( 'Show Pagination', 'calibrefx' ),
            ),
            array(
                'type' => 'select',
                'name' => 'layout',
                'validation' => 'required',
                'label' => __( 'Layout', 'calibrefx' ),
                'items' => array(
                    array(
                        'value' => 'grid',
                        'label' => __('Grid', 'calibrefx' ),
                    ),
                    array(
                        'value' => 'list',
                        'label' => __('List', 'calibrefx' ),
                    ),
                )
            ),
            array(
                'type' => 'textbox',
                'name' => 'read_more',
                'label' => __( 'Read more text', 'calibrefx' ),
                'dependency' => array(
                    'field' => 'layout',
                    'function' => 'vp_dep_custom',
                ),
            ),
            array(
                'type' => 'textbox',
                'name' => 'excerpt_length',
                'label' => __( 'Post excerpt length', 'calibrefx' ),
                'dependency' => array(
                    'field' => 'layout',
                    'function' => 'vp_dep_custom',
                ),
            ),
            array(
                'type' => 'textbox',
                'name' => 'columns_per_row',
                'label' => __( 'Columns per row', 'calibrefx' ),
                'dependency' => array(
                    'field' => 'layout',
                    'function' => 'vp_dep_custom',
                ),
            ),
        )
    );

    return apply_filters( 'vp_content_type_field_menu', $fields );
}

function vp_content_type_field_raw_html(){
    $fields = array(
        'type'      => 'group',
        'repeating' => false,
        'sortable'  => false,
        'name'      => 'raw_html',
        'title'     => __( 'Raw HTML', 'calibrefx' ),
        'dependency' => array(
            'field' => 'content_type',
            'function' => 'vp_dep_custom',
        ),
        'fields'    => array(
            array(
                'type'      => 'textarea',
                'name'      => 'raw_html_code',
                'label'     => __( 'Raw HTML Code', 'calibrefx' ),
            )
        ),
    );

    return apply_filters( 'vp_content_type_field_raw_html', $fields );
}

function vp_content_type_field_simple_text(){
    $fields = array(
        'type'      => 'group',
        'repeating' => false,
        'sortable'  => false,
        'name'      => 'simple_text',
        'title'     => __( 'Text Settings', 'calibrefx' ),
        'dependency' => array(
            'field' => 'content_type',
            'function' => 'vp_dep_custom',
        ),
        'fields'    => array(
            array(
                'type' => 'textbox',
                'name' => 'Text',
                'validation' => 'required',
                'label' => __( 'Text', 'calibrefx' ),
            ),
            array(
                'type' => 'color',
                'name' => 'text_color',
                'label' => __( 'Text Color', 'calibrefx' ),
            ),
            array(
                'type' => 'textbox',
                'name' => 'font_size',
                'label' => __( 'Font Size', 'calibrefx' ),
            ),
            array(
                'type' => 'select',
                'name' => 'font_weight',
                'label' => __( 'Font Weight', 'calibrefx' ),
                'items' => array(
                    array(
                        'value' => 'normal',
                        'label' => __( 'Normal', 'calibrefx' ),
                    ),
                    array(
                        'value' => 'bold',
                        'label' => __( 'Bold', 'calibrefx' ),
                    ),
                    array(
                        'value' => 'italic',
                        'label' => __( 'Italic', 'calibrefx' ),
                    ),
                )
            ),
            array(
                'type' => 'color',
                'name' => 'background_color',
                'label' => __( 'Background Color', 'calibrefx' ),
            ),
            array(
                'type' => 'upload',
                'name' => 'image_url',
                'label' => __( 'Image URL', 'calibrefx' ),
            ),
            array(
                'type' => 'textbox',
                'name' => 'css_class',
                'label' => __( 'CSS Class', 'calibrefx' ),
            ),
        ),
    );

    return apply_filters( 'vp_content_type_field_raw_html', $fields );
}

function vp_content_type_field_slider(){

    $fields = array(
        'type'      => 'group',
        'repeating' => true,
        'sortable'  => true,
        'name'      => 'slider',
        'title'     => __( 'Slider Item', 'calibrefx' ),
        'dependency' => array(
            'field' => 'content_type',
            'function' => 'vp_dep_custom',
        ),
        'fields'    => array(
            array(
                'type' => 'upload',
                'name' => 'image',
                'validation' => 'required',
                'label' => __( 'Image', 'calibrefx' )
            ),
            array(
                'type' => 'textbox',
                'name' => 'css_class',
                'label' => __( 'CSS Class', 'calibrefx' ),
            ),
        ),
    );

    return apply_filters( 'vp_content_type_field_slider', $fields );
}

function vp_content_type_field_slider_revolution(){

    $fields = array(
        'type'      => 'group',
        'repeating' => false,
        'sortable'  => false,
        'name'      => 'slider_revolution',
        'title'     => __( 'Slider Revolution', 'calibrefx' ),
        'dependency' => array(
            'field' => 'content_type',
            'function' => 'vp_dep_custom',
        ),
        'fields'    => array(
            array(
                'type' => 'select',
                'name' => 'slider_revolution_item',
                'validation' => 'required',
                'label' => __( 'Choose Slider', 'calibrefx' ),
                'items' => array(
                'data' => array(
                        array(
                            'source' => 'function',
                            'value' => 'vp_get_revolution_sliders'
                        )
                    )
                )
            ),
        ),
    );

    return apply_filters( 'vp_content_type_field_slider_revolution', $fields );
}