<?php

return array(
	'id'          => 'page_builder',
	'types'       => array('page','post'),
	'title'       => __('Page Builder', 'vp_textdomain'),
	'priority'    => 'high',
	'hide_editor' => TRUE,
	'mode' => WPALCHEMY_MODE_EXTRACT,
	'template'    => array(
		array(
			'type'      => 'group',
			'repeating' => true,
			'sortable' => true,
			'name'      => 'section',
			'title'     => __('Section', 'vp_textdomain'),
			'fields'    => array(
				array(
                    'type' => 'toggle',
                    'name' => 'section_container',
                    'label' => __('Container', 'vp_textdomain')
                ),
				array(
					'type' => 'textbox',
					'name' => 'section_class',
					'label' => __('Custom CSS Class', 'vp_textdomain')
				),
				array(
					'type' => 'textbox',
					'name' => 'section_style',
					'label' => __('Custom CSS Style', 'vp_textdomain')
				),
				array(
                    'type' => 'color',
                    'name' => 'section_bg_color',
                    'label' => __('Background Color', 'vp_textdomain'),
                    'format' => 'rgba',
                ),
				array(
                    'type' => 'upload',
                    'name' => 'section_bg_image',
                    'label' => __('Background Image', 'vp_textdomain')
                ),
				array(
                    'type' => 'toggle',
                    'name' => 'section_bg_parallax',
                    'label' => __('Background Parallax', 'vp_textdomain'),
                    'dependency' => array(
		                'field' => 'section_bg_image',
		                'function' => 'vp_dep_boolean',
		            )
                ),
				array(
					'type'      => 'group',
					'repeating' => true,
					'name'      => 'column',
					'title'     => __('Column', 'vp_textdomain'),
					'fields'    => array(
                        array(
                            'type' => 'slider',
                            'name' => 'grid',
                            'label' => __('Grid', 'vp_textdomain'),
                            'min' => 1,
                            'max' => 12,
                            'default' => 12
                        ),
                        array(
                            'type' => 'slider',
                            'name' => 'offset',
                            'label' => __('Grid Offset', 'vp_textdomain'),
                            'min' => 0,
                            'max' => 11,
                            'default' => 0
                        ),
                        array(
                            'type' => 'slider',
                            'name' => 'pull',
                            'label' => __('Grid Pull Left', 'vp_textdomain'),
                            'min' => 0,
                            'max' => 11,
                            'default' => 0
                        ),
                        array(
                            'type' => 'slider',
                            'name' => 'push',
                            'label' => __('Grid Push Right', 'vp_textdomain'),
                            'min' => 0,
                            'max' => 11,
                            'default' => 0
                        ),
                        array(
							'type' => 'select',
							'name' => 'content_type',
							'label' => __('Content Type', 'vp_textdomain'),
							'items' => array(
								array(
									'value' => 'breadcrumb',
									'label' => __('Breadcrumb', 'vp_textdomain'),
								),
								array(
									'value' => 'carousel',
									'label' => __('Carousel', 'vp_textdomain'),
								),
								array(
									'value' => 'heading',
									'label' => __('Heading', 'vp_textdomain'),
								),
								array(
									'value' => 'html_editor',
									'label' => __('HTML Editor', 'vp_textdomain'),
								),
								array(
									'value' => 'raw_html',
									'label' => __('Raw HTML', 'vp_textdomain'),
								),
								array(
									'value' => 'slider',
									'label' => __('Slider', 'vp_textdomain'),
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
							'title'     => __('Raw HTML Code', 'vp_textdomain'),
				            'dependency' => array(
				                'field' => 'content_type',
				                'function' => 'vp_dep_is_raw_html',
				            )
						),
						array(
							'type'      => 'group',
							'repeating' => true,
							'name'      => 'carousel',
							'title'     => __('Carousel', 'vp_textdomain'),
				            'dependency' => array(
				                'field' => 'content_type',
				                'function' => 'vp_dep_is_carousel',
				            ),
							'fields'    => array(
		                        array(
		                            'type' => 'upload',
		                            'name' => 'image',
		                            'validation' => 'required',
		                            'label' => __('Image', 'vp_textdomain')
		                        )
							),
						),
						array(
							'type' => 'textbox',
							'name' => 'heading_text',
							'label' => __('Heading Text', 'vp_textdomain'),
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