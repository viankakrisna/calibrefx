<?php

return array(
	'id'          => 'page_builder',
	'types'       => array('page'),
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
					'label' => __('Custom CSS Style', 'calibrefx')
				),
				array(
                    'type' => 'color',
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
							'type' => 'select',
							'name' => 'content_type',
							'label' => __('Element', 'calibrefx'),
							'items' => array(
								array(
									'value' => 'breadcrumb',
									'label' => __('Breadcrumb', 'calibrefx'),
								),
								array(
									'value' => 'carousel',
									'label' => __('Carousel', 'calibrefx'),
								),
								array(
									'value' => 'heading',
									'label' => __('Heading', 'calibrefx'),
								),
								array(
									'value' => 'html_editor',
									'label' => __('HTML Editor', 'calibrefx'),
								),
								array(
									'value' => 'raw_html',
									'label' => __('Raw HTML', 'calibrefx'),
								),
								array(
									'value' => 'slider',
									'label' => __('Slider', 'calibrefx'),
								)
							),
						),
						array(
				            'type' => 'upload',
				            'name' => 'breadcrumb_image',
				            'label' => __('Breadcrumb Image', 'jg_textdomain'),
				            'validation' => 'required',
				            'dependency' => array(
				                'field' => 'content_type',
				                'function' => 'vp_dep_is_breadcrumb',
				            )
				        ),
				        array(
							'type'      => 'textarea',
							'name'      => 'raw_html',
							'title'     => __('Raw HTML Code', 'calibrefx'),
				            'dependency' => array(
				                'field' => 'content_type',
				                'function' => 'vp_dep_is_raw_html',
				            )
						),
						array(
							'type'      => 'group',
							'repeating' => true,
							'name'      => 'carousel',
							'title'     => __('Carousel', 'calibrefx'),
				            'dependency' => array(
				                'field' => 'content_type',
				                'function' => 'vp_dep_is_carousel',
				            ),
							'fields'    => array(
		                        array(
		                            'type' => 'upload',
		                            'name' => 'image',
		                            'validation' => 'required',
		                            'label' => __('Image', 'calibrefx')
		                        )
							),
						),
						array(
							'type' => 'textbox',
							'name' => 'heading_text',
							'label' => __('Heading Text', 'calibrefx'),
							'validation' > 'required',
				            'dependency' => array(
				                'field' => 'content_type',
				                'function' => 'vp_dep_is_heading',
				            )
						),
						array(
							'type' => 'textbox',
							'name' => 'sub_heading_text',
							'label' => __('Sub Heading Text', 'calibrefx'),
							'validation' > 'required',
				            'dependency' => array(
				                'field' => 'content_type',
				                'function' => 'vp_dep_is_heading',
				            )
						),
						array(
				            'type' => 'select',
				            'name' => 'slider_id',
				            'label' => __('Slider', 'jg_textdomain'),
				            'validation' => 'required',
				            'dependency' => array(
				                'field' => 'content_type',
				                'function' => 'vp_dep_is_slider',
				            ),
				            'items' => array(
					            'data' => array(
					                array(
					                    'source' => 'function',
					                    'value' => 'get_revolution_sliders'
					                )
					            )
					        )
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