<?php

return array(
	'id'          => 'page_builder',
	'types'       => array('page'),
	'include_template' => array_keys(Calibrefx_Builder::template_pages()),
	'title'       => __('Page Builder', 'calibrefx'),
	'priority'    => 'high',
	'hide_editor' => TRUE,
	'mode' 		  => WPALCHEMY_MODE_EXTRACT,
	'template'    => array(
		array(
			'type'      => 'group',
			'repeating' => true,
			'sortable'  => true,
			'name'      => 'section',
			'title'     => __('Section', 'calibrefx'),
			'fields'    => array(
				array(
                    'type' => 'toggle',
                    'name' => 'section_container',
                    'label' => __('Container', 'calibrefx')
                ),
				array(
					'type' => 'textbox',
					'name' => 'section_class',
					'label' => __('Custom CSS Class', 'calibrefx')
				),
				array(
					'type' => 'textbox',
					'name' => 'section_style',
					'label' => __('Custom CSS Style', 'calibrefx'),
				),
				array(
                    'type' => 'wpcolor',
                    'name' => 'section_bg_color',
                    'label' => __('Background Color', 'calibrefx'),
                    'format' => 'rgba',
                ),
				array(
					'type'      => 'group',
					'repeating' => false,
					'sortable'  => false,
					'name'      => 'section_bg',
					'title'     => __('Section Background', 'calibrefx'),
					'fields'    => array(
						array(
		                    'type' => 'color',
		                    'name' => 'section_bg_color',
		                    'label' => __('Color', 'calibrefx'),
		                    'format' => 'rgba',
		                ),
		                array(
		                    'type' => 'upload',
		                    'name' => 'section_bg_image',
		                    'label' => __('Image', 'calibrefx')
		                ),
		                array(
		                    'type' => 'select',
		                    'name' => 'section_bg_size',
		                    'label' => __('Size', 'calibrefx'),
		                    'validation' => 'required',
		                    'items' => array(
			                    array(
			                        'value' => 'auto',
			                        'label' => __('Auto', 'calibrefx' ),
			                    ),
			                    array(
			                        'value' => 'cover',
			                        'label' => __('Cover', 'calibrefx' ),
			                    ),
			                    array(
			                        'value' => 'contain',
			                        'label' => __('Contain', 'calibrefx' ),
			                    ),
			                    array(
			                        'value' => 'initial',
			                        'label' => __('Initial', 'calibrefx' ),
			                    ),
			                    array(
			                        'value' => 'inherit',
			                        'label' => __('Inherit', 'calibrefx' ),
			                    )
			                ),
		                    'dependency' => array(
				                'field' => 'section_bg_image',
				                'function' => 'vp_dep_boolean',
				            )
		                ),
						array(
		                    'type' => 'select',
		                    'name' => 'section_bg_position',
		                    'label' => __('Position', 'calibrefx'),
		                    'validation' => 'required',
		                    'items' => array(
			                    array(
			                        'value' => 'left top',
			                        'label' => __('left top', 'calibrefx' ),
			                    ),
			                    array(
			                        'value' => 'left center',
			                        'label' => __('left center', 'calibrefx' ),
			                    ),
			                    array(
			                        'value' => 'left bottom',
			                        'label' => __('left bottom', 'calibrefx' ),
			                    ),
			                    array(
			                        'value' => 'right top',
			                        'label' => __('right top', 'calibrefx' ),
			                    ),
			                    array(
			                        'value' => 'right center',
			                        'label' => __('right center', 'calibrefx' ),
			                    ),
			                    array(
			                        'value' => 'right bottom',
			                        'label' => __('right bottom', 'calibrefx' ),
			                    ),
			                    array(
			                        'value' => 'center top',
			                        'label' => __('center top', 'calibrefx' ),
			                    ),
			                    array(
			                        'value' => 'center center',
			                        'label' => __('center center', 'calibrefx' ),
			                    ),
			                    array(
			                        'value' => 'center bottom',
			                        'label' => __('center bottom', 'calibrefx' ),
			                    ),
			                    array(
			                        'value' => 'initial',
			                        'label' => __('initial', 'calibrefx' ),
			                    )
			                ),
		                    'dependency' => array(
				                'field' => 'section_bg_image',
				                'function' => 'vp_dep_boolean',
				            )
		                ),
						array(
		                    'type' => 'select',
		                    'name' => 'section_bg_repeat',
		                    'label' => __('Repeat', 'calibrefx'),
		                    'validation' => 'required',
		                    'items' => array(
			                    array(
			                        'value' => 'repeat',
			                        'label' => __('repeat', 'calibrefx' ),
			                    ),
			                    array(
			                        'value' => 'repeat-x',
			                        'label' => __('repeat horizontally', 'calibrefx' ),
			                    ),
			                    array(
			                        'value' => 'repeat-y',
			                        'label' => __('repeat vertically', 'calibrefx' ),
			                    ),
			                    array(
			                        'value' => 'no-repeat',
			                        'label' => __('no-repeat', 'calibrefx' ),
			                    ),
			                    array(
			                        'value' => 'initial',
			                        'label' => __('initial', 'calibrefx' ),
			                    )
			                ),
		                    'dependency' => array(
				                'field' => 'section_bg_image',
				                'function' => 'vp_dep_boolean',
				            )
		                ),
						array(
		                    'type' => 'toggle',
		                    'name' => 'section_bg_parallax',
		                    'label' => __('Background Parallax', 'calibrefx'),
		                    'dependency' => array(
				                'field' => 'section_bg_image',
				                'function' => 'vp_dep_boolean',
				            )
		                )
					)
				),
				array(
					'type'      => 'group',
					'repeating' => true,
					'sortable' => true,
					'name'      => 'column',
					'title'     => __('Column', 'calibrefx'),
					'fields'    => array(
                        array(
                            'type' => 'slider',
                            'name' => 'grid',
                            'label' => __('Grid', 'calibrefx'),
                            'min' => 1,
                            'max' => 12,
                            'default' => 12
                        ),
                        array(
                            'type' => 'slider',
                            'name' => 'offset',
                            'label' => __('Grid Offset', 'calibrefx'),
                            'min' => 0,
                            'max' => 11,
                            'default' => 0
                        ),
                        array(
                            'type' => 'slider',
                            'name' => 'pull',
                            'label' => __('Grid Pull Left', 'calibrefx'),
                            'min' => 0,
                            'max' => 11,
                            'default' => 0
                        ),
                        array(
                            'type' => 'slider',
                            'name' => 'push',
                            'label' => __('Grid Push Right', 'calibrefx'),
                            'min' => 0,
                            'max' => 11,
                            'default' => 0
                        ),
                        array(
							'type'      => 'group',
							'repeating' => true,
							'sortable'  => true,
							'name'      => 'content',
							'title'     => __('Content', 'vp_textdomain'),
							'fields'    => vp_get_content_type_fields()
						)
					)
				)
			)
		)
	)
);

/**
 * EOF
 */