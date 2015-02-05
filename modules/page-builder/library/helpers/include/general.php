<?php
function vp_get_formidable_forms() {
    $result = array();
    if( !class_exists( 'FrmForm' ) ){
        return $result;
    }
    $where = apply_filters('frm_forms_dropdown', " (status is NULL OR status = '' OR status = 'published') AND default_template=0", '');
	$frm_form = new FrmForm();
	$forms = $frm_form->getAll($where, ' ORDER BY name');
	foreach($forms as $form){
		$result[] = array('value' => $form->id, 'label' => $form->name);
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
    if( class_exists( 'FrmAppController' ) ){
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
	if( class_exists( 'FrmForm' ) ){
        $result[] = array(
    		'value' => 'formidable',
    		'label' => __( 'Formidable', 'calibrefx' )
    	);
	}
    return apply_filters( 'vp_get_content_type_list', $result);
}

function vp_get_content_type_fields(){
    $result = array();
    $result[] = array(
		'type' => 'select',
		'name' => 'content_type',
		'label' => __( 'Content Type', 'calibrefx'),
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
        'title'     => __( 'Autoresponder Settings', 'calibrefx'),
        'dependency' => array(
            'field' => 'content_type',
            'function' => 'vp_dep_custom',
        ),
        'fields'    => array(
            array(
                'type' => 'select',
                'name' => 'provider',
                'validation' => 'required',
                'label' => __( 'Provider', 'calibrefx'),
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
                'label' => __( 'Api Url', 'calibrefx'),
                'dependency' => array(
                    'field' => 'provider',
                    'function' => 'vp_dep_custom',
                ),
            ),
            array(
                'type' => 'textbox',
                'name' => 'api_key',
                'validation' => 'required',
                'label' => __( 'Api Key', 'calibrefx'),
                'dependency' => array(
                    'field' => 'provider',
                    'function' => 'vp_dep_custom',
                ),
            ),
            array(
                'type' => 'textbox',
                'name' => 'campaign_name',
                'validation' => 'required',
                'label' => __( 'Campaign Name', 'calibrefx'),
                'dependency' => array(
                    'field' => 'provider',
                    'function' => 'vp_dep_custom',
                ),
            ),
            array(
                'type' => 'textbox',
                'name' => 'form_id',
                'validation' => 'required',
                'label' => __( 'Form ID', 'calibrefx'),
                'dependency' => array(
                    'field' => 'provider',
                    'function' => 'vp_dep_custom',
                ),
            ),
            array(
                'type' => 'textarea',
                'name' => 'form_code',
                'validation' => 'required',
                'label' => __( 'Autoresponder Form Code', 'calibrefx'),
                'dependency' => array(
                    'field' => 'provider',
                    'function' => 'vp_dep_custom',
                ),
            ),
            array(
                'type' => 'textbox',
                'name' => 'css_class',
                'validation' => 'required',
                'label' => __( 'CSS Class', 'calibrefx'),
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
        'title'     => __( 'Formidable Settings', 'calibrefx'),
        'dependency' => array(
            'field' => 'content_type',
            'function' => 'vp_dep_custom',
        ),
        'fields'    => array(
            array(
                'type' => 'select',
                'name' => 'form_id',
                'validation' => 'required',
                'label' => __( 'Choose Form', 'calibrefx'),
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
                'label' => __( 'CSS Class', 'calibrefx'),
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
        'title'     => __( 'Google Map Settings', 'calibrefx'),
        'dependency' => array(
            'field' => 'content_type',
            'function' => 'vp_dep_custom',
        ),
        'fields'    => array(
            array(
                'type' => 'upload',
                'name' => 'image',
                'validation' => 'required',
                'label' => __( 'Icon Marker', 'calibrefx')
            ),
            array(
                'type' => 'textbox',
                'name' => 'latitude',
                'label' => __( 'Latitude', 'calibrefx'),
            ),
            array(
                'type' => 'textbox',
                'name' => 'longitude',
                'validation' => 'required',
                'label' => __( 'Longitude', 'calibrefx'),
            ),
            array(
                'type' => 'textbox',
                'name' => 'zoom',
                'validation' => 'required',
                'label' => __( 'Zoom', 'calibrefx'),
            ),
            array(
                'type' => 'textbox',
                'name' => 'height',
                'validation' => 'required',
                'label' => __( 'Height', 'calibrefx'),
            ),
            array(
                'type' => 'textbox',
                'name' => 'title',
                'validation' => 'required',
                'label' => __( 'Title', 'calibrefx'),
            ),
            array(
                'type' => 'textarea',
                'name' => 'address',
                'validation' => 'required',
                'label' => __( 'Address Line', 'calibrefx'),
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
        'title'     => __( 'Heading Settings', 'calibrefx'),
        'dependency' => array(
            'field' => 'content_type',
            'function' => 'vp_dep_custom',
        ),
        'fields'    => array(
            array(
                'type' => 'textbox',
                'name' => 'header_text',
                'validation' => 'required',
                'label' => __( 'Header Text', 'calibrefx'),
            ),
            array(
                'type' => 'textbox',
                'name' => 'sub_header_text',
                'validation' => 'required',
                'label' => __( 'Sub Header Text', 'calibrefx'),
            ),
            array(
                'type' => 'select',
                'name' => 'heading_alignment',
                'validation' => 'required',
                'label' => __( 'Alignment', 'calibrefx'),
                'items' => array(
                    array(
                        'value' => 'left',
                        'label' => __('Left', 'calibrefx'),
                    ),
                    array(
                        'value' => 'center',
                        'label' => __('Center', 'calibrefx'),
                    ),
                    array(
                        'value' => 'right',
                        'label' => __('Right', 'calibrefx'),
                    ),
                )
            ),
            array(
                'type' => 'upload',
                'name' => 'heading_icon',
                'validation' => 'required',
                'label' => __( 'Icon', 'calibrefx'),
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
        'title'     => __( 'Image Settings', 'calibrefx'),
        'dependency' => array(
            'field' => 'content_type',
            'function' => 'vp_dep_custom',
        ),
        'fields'    => array(
            array(
                'type' => 'upload',
                'name' => 'image_url',
                'validation' => 'required',
                'label' => __( 'Image URL', 'calibrefx'),
            ),
            array(
                'type' => 'textbox',
                'name' => 'alt_text',
                'validation' => 'required',
                'label' => __( 'Alternative Text', 'calibrefx'),
            ),
            array(
                'type' => 'textbox',
                'name' => 'link',
                'validation' => 'required',
                'label' => __( 'URL', 'calibrefx'),
            ),
            array(
                'type' => 'toggle',
                'name' => 'link_target',
                'label' => __( 'Open in New Tab', 'calibrefx'),
                'dependency' => array(
                    'field' => 'link',
                    'function' => 'vp_dep_boolean',
                ),
            ),
            array(
                'type' => 'select',
                'name' => 'image_alignment',
                'validation' => 'required',
                'label' => __( 'Alignment', 'calibrefx'),
                'items' => array(
                    array(
                        'value' => 'left',
                        'label' => __('Left', 'calibrefx'),
                    ),
                    array(
                        'value' => 'center',
                        'label' => __('Center', 'calibrefx'),
                    ),
                    array(
                        'value' => 'right',
                        'label' => __('Right', 'calibrefx'),
                    ),
                )
            ),
            array(
                'type' => 'select',
                'name' => 'image_animation',
                'label' => __( 'Animation', 'calibrefx'),
                'items' => array(
                    array(
                        'value' => 'fade_in',
                        'label' => __('Fade In', 'calibrefx'),
                    ),
                    array(
                        'value' => 'fade_in_left',
                        'label' => __('Fade in From Left', 'calibrefx'),
                    ),
                    array(
                        'value' => 'fade_in_right',
                        'label' => __('Fade In From Right', 'calibrefx'),
                    ),
                    array(
                        'value' => 'grow_in',
                        'label' => __('Grow In', 'calibrefx'),
                    ),
                )
            ),
            array(
                'type' => 'textbox',
                'name' => 'delay',
                'validation' => 'required',
                'label' => __( 'Delay', 'calibrefx'),
                'dependency' => array(
                    'field' => 'image_animation',
                    'function' => 'vp_dep_boolean',
                ),
            ),
            array(
                'type' => 'textbox',
                'name' => 'css_class',
                'validation' => 'required',
                'label' => __( 'CSS Class', 'calibrefx'),
            ),
        )
    );

    return apply_filters( 'vp_content_type_field_image', $fields );
}

function vp_content_type_field_raw_html(){

    $fields = array(
        'type'      => 'textarea',
        'name'      => 'raw_html',
        'label'     => __( 'Raw HTML Code', 'calibrefx'),
        'dependency' => array(
            'field' => 'content_type',
            'function' => 'vp_dep_is_raw_html',
        )
    );

    return apply_filters( 'vp_content_type_field_raw_html', $fields );
}

/*function vp_content_type_field_breadcrumb(){
    return apply_filters( 'vp_content_type_field_breadcrumb', array(
        'type' => 'upload',
        'name' => 'breadcrumb',
        'label' => __( 'Breadcrumb Image', 'calibrefx'),
        'validation' => 'required',
        'dependency' => array(
            'field' => 'content_type',
            'function' => 'vp_dep_is_breadcrumb',
        )
    ) );
}*/

function vp_content_type_field_html_editor(){
    return apply_filters( 'vp_content_type_field_html_editor', array(
			'type'       => 'wpeditor',
			'name'       => 'html_editor',
			'label'      => __( 'HTML Editor', 'calibrefx'),
            'dependency' => array(
                'field'  => 'content_type',
                'function' => 'vp_dep_is_html_editor',
            )
		)
    );
}

function vp_content_type_field_slider(){
    return apply_filters( 'vp_content_type_field_slider', array(
			'type'      => 'group',
			'repeating' => true,
			'sortable'  => true,
			'name'      => 'slider',
			'title'     => __( 'slider', 'calibrefx'),
            'dependency' => array(
                'field' => 'content_type',
                'function' => 'vp_dep_is_slider',
            ),
			'fields'    => array(
                array(
                    'type' => 'upload',
                    'name' => 'image',
                    'validation' => 'required',
                    'label' => __( 'Image', 'calibrefx')
                )
			),
		)
    );
}

function vp_content_type_field_slider_revolution(){
    return apply_filters( 'vp_content_type_field_slider_revolution', array(
            'type' => 'select',
            'name' => 'slider_revolution',
            'label' => __( 'Slider Revolution', 'jg_textdomain'),
            'validation' => 'required',
            'dependency' => array(
                'field' => 'content_type',
                'function' => 'vp_dep_is_slider_revolution',
            ),
            'items' => array(
	            'data' => array(
	                array(
	                    'source' => 'function',
	                    'value' => 'vp_get_revolution_sliders'
	                )
	            )
	        )
        )
    );
}