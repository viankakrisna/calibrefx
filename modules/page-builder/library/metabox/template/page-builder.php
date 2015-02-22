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
                    'type' => 'textbox',
                    'name' => 'section_name',
                    'label' => __('Section Name', 'calibrefx'),
                    'description' => __('Only shown in admin area', 'calibrefx'),
                ),
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
                    'type' => 'upload',
                    'name' => 'section_bg_image',
                    'label' => __('Background Image', 'calibrefx')
                ),
				array(
                    'type' => 'toggle',
                    'name' => 'section_bg_parallax',
                    'label' => __('Background Parallax', 'calibrefx'),
                    'dependency' => array(
		                'field' => 'section_bg_image',
		                'function' => 'vp_dep_boolean',
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
		                    'type' => 'textbox',
		                    'name' => 'column_name',
		                    'label' => __('Column Name', 'calibrefx'),
		                    'description' => __('Only shown in admin area', 'calibrefx'),
		                ),
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