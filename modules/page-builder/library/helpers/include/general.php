<?php

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

function vp_get_content_type_list(){
    $result = array();
    $result[] = array(
		'value' => 'breadcrumb',
		'label' => __( 'Breadcrumb', 'calibrefx' )
	);
    $result[] = array(
		'value' => 'carousel',
		'label' => __( 'Carousel', 'calibrefx' )
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
		'value' => 'raw_html',
		'label' => __( 'Raw HTML', 'calibrefx' )
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

function vp_content_type_field_breadcrumb(){
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
}

function vp_content_type_field_raw_html(){
    return apply_filters( 'vp_content_type_field_raw_html', array(
			'type'      => 'textarea',
			'name'      => 'raw_html',
			'label'     => __( 'Raw HTML Code', 'calibrefx'),
            'dependency' => array(
                'field' => 'content_type',
                'function' => 'vp_dep_is_raw_html',
            )
		)
    );
}

function vp_content_type_field_html_editor(){
    return apply_filters( 'vp_content_type_field_html_editor', array(
			'type'      => 'wpeditor',
			'name'      => 'html_editor',
			'label'     => __( 'HTML Editor', 'calibrefx'),
            'dependency' => array(
                'field' => 'content_type',
                'function' => 'vp_dep_is_html_editor',
            )
		)
    );
}

function vp_content_type_field_carousel(){
    return apply_filters( 'vp_content_type_field_carousel', array(
			'type'      => 'group',
			'repeating' => true,
			'sortable' => true,
			'name'      => 'carousel',
			'title'     => __( 'Carousel', 'calibrefx'),
            'dependency' => array(
                'field' => 'content_type',
                'function' => 'vp_dep_is_carousel',
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

function vp_content_type_field_heading(){
    return apply_filters( 'vp_content_type_field_heading', array(
			'type' => 'textbox',
			'name' => 'heading',
			'label' => __( 'Heading Text', 'calibrefx'),
			'validation' > 'required',
            'dependency' => array(
                'field' => 'content_type',
                'function' => 'vp_dep_is_heading',
            )
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