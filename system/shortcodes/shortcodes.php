<?php

/* One Half */
function calibrefx_one_half( $atts, $content = '' ) {
	extract( shortcode_atts( array(
			'class' 		=> '',
			'align' 		=> '',
			'id' 			=> '',
			'centered_text' => 'false',
			'animation' 	=> '',
			'delay' 		=> '0'
		), $atts ) );

	$column_classes = '';
	$attr = '';

	$column_classes .= 'col-lg-6 col-md-6 col-sm-12 col-xs-12';
	if ( ! empty( $class ) ) {
		$column_classes .= ' ' . $class; }
	if ( ! empty( $align ) ) {
		$column_classes .= ' ' . $align; }

	if ( ! empty( $id ) ) { $attr .= ' id="' . $id . '"'; }

	if ( $centered_text == 'true' ) { $column_classes .= ' cfx-text-centered'; }

	if ( ! empty( $animation ) ) {
		 $column_classes .= ' has-animation';

		 $parsed_animation = str_replace( ' ', '-', $animation );
		 $delay = intval( $delay );
	}

	return '<div class="cfx-column ' . $column_classes . '"' . $attr . ' data-animation="'.strtolower( $parsed_animation ).'" data-delay="'.$delay.'" >' . do_shortcode( $content ) . '</div>';
}
add_shortcode( 'one_half', 'calibrefx_one_half' );

/* One Third */
function calibrefx_one_third_column( $atts, $content = '' ) {
	extract( shortcode_atts( array(
			'class' 		=> '',
			'align' 		=> '',
			'id' 			=> '',
			'centered_text' => 'false',
			'animation' 	=> '',
			'delay' 		=> '0'
				), $atts ) );

	$column_classes = '';
	$attr = '';

	$column_classes .= 'col-lg-4 col-md-4 col-sm-12 col-xs-12';
	if ( ! empty( $class ) ) {
		$column_classes .= ' ' . $class; }
	if ( ! empty( $align ) ) {
		$column_classes .= ' ' . $align; }

	if ( ! empty( $id ) ) { $attr .= ' id="' . $id . '"'; }

	if ( $centered_text == 'true' ) { $column_classes .= ' cfx-text-centered'; }

	if ( ! empty( $animation ) ) {
		 $column_classes .= ' has-animation';

		 $parsed_animation = str_replace( ' ', '-', $animation );
		 $delay = intval( $delay );
	}

	return '<div class="cfx-column ' . $column_classes . '"' . $attr . ' data-animation="'.strtolower( $parsed_animation ).'" data-delay="'.$delay.'" >' . do_shortcode( $content ) . '</div>';
}
add_shortcode( 'one_third', 'calibrefx_one_third_column' );

/* Two Third */
function calibrefx_two_third_column( $atts, $content = '' ) {
	extract( shortcode_atts( array(
				'class' => '',
				'style' => '',
				'align' => '',
				'last' => 'no',
				'first' => 'no',
				'id' => ''
					), $atts ) );

	$before = '';
	$after = '';
	$classes = '';
	$attr = '';

	$classes .= ' col-lg-8 col-md-8 col-sm-12 col-xs-12';
	if ( ! empty( $class ) ) {
		$classes .= ' ' . $class; }
	if ( ! empty( $align) ) {
		$classes .= ' ' . $align; }

	if ( ! empty( $first ) ) {
		if ( $first == 'yes' ) {
			$before = '<div class="' . calibrefx_row_class() . '">';
		}
	}
	if ( ! empty( $last ) ) {
		if ( $last == 'yes' ) {
			$after = '</div>';
		}
	}

	if ( ! empty( $style ) ) { $attr .= ' style="' . $style . '"'; }
	if ( ! empty( $id ) ) { $attr .= ' id="' . $id . '"'; }

	return $before . '<div class="' . $classes . '"' . $attr . '>' . do_shortcode( advance_shortcode_unautop( $content ) ) . '</div>' . $after;
}
add_shortcode( 'two_third', 'calibrefx_two_third_column' );

/* One Fourth */
function calibrefx_one_fourth_column( $atts, $content = '' ) {
	extract( shortcode_atts( array(
				'class' => '',
				'style' => '',
				'align' => '',
				'last' => 'no',
				'first' => 'no',
				'id' => ''
					), $atts ) );

	$before = '';
	$after = '';
	$classes = '';
	$attr = '';

	$classes .= ' col-lg-3 col-md-3 col-sm-12 col-xs-12';
	if ( ! empty( $class ) ) {
		$classes .= ' ' . $class; }
	if ( ! empty( $align) ) {
		$classes .= ' ' . $align; }

	if ( ! empty( $first ) ) {
		if ( $first == 'yes' ) {
			$before = '<div class="' . calibrefx_row_class() . '">';
		}
	}
	if ( ! empty( $last ) ) {
		if ( $last == 'yes' ) {
			$after = '</div>';
		}
	}

	if ( ! empty( $style ) ) { $attr .= ' style="' . $style . '"'; }
	if ( ! empty( $id ) ) { $attr .= ' id="' . $id . '"'; }

	return $before . '<div class="' . $classes . '"' . $attr . '>' . do_shortcode( advance_shortcode_unautop( $content ) ) . '</div>' . $after;
}
add_shortcode( 'one_fourth', 'calibrefx_one_fourth_column' );

/* Three Fourth */
function calibrefx_three_fourth_column( $atts, $content = '' ) {
	extract( shortcode_atts( array(
				'class' => '',
				'style' => '',
				'align' => '',
				'last' => 'no',
				'first' => 'no',
				'id' => ''
					), $atts ) );

	$before = '';
	$after = '';
	$classes = '';
	$attr = '';

	$classes .= ' col-lg-9 col-md-9 col-sm-12 col-xs-12';
	if ( ! empty( $class ) ) {
		$classes .= ' ' . $class; }
	if ( ! empty( $align) ) {
		$classes .= ' ' . $align; }

	if ( ! empty( $first ) ) {
		if ( $first == 'yes' ) {
			$before = '<div class="' . calibrefx_row_class() . '">';
		}
	}
	if ( ! empty( $last ) ) {
		if ( $last == 'yes' ) {
			$after = '</div>';
		}
	}

	if ( ! empty( $style ) ) { $attr .= ' style="' . $style . '"'; }
	if ( ! empty( $id ) ) { $attr .= ' id="' . $id . '"'; }

	return $before . '<div class="' . $classes . '"' . $attr . '>' . do_shortcode( advance_shortcode_unautop( $content ) ) . '</div>' . $after;
}
add_shortcode( 'three_fourth', 'calibrefx_three_fourth_column' );

//image with animation
function cfx_image_with_animation($atts, $content = null) {
	extract(
		shortcode_atts(
			array(
				'animation' => 'Fade In',
				'delay' => '0',
				'image_url' => '',
				'alt' => '',
				'lightbox' => 'false',

			), $atts ) );

			$parsed_animation = str_replace( ' ', '-', $animation );
			( ! empty( $alt ) ) ? $alt_tag = $alt : $alt_tag = null;

			if ( preg_match( '/^\d+$/', $image_url ) ){
				$image_src = wp_get_attachment_image_src( $image_url, 'full' );
				$image_url = $image_src[0];
			}

			if ( $lightbox ){
				return '<a href="' . $image_url . '" data-lightbox="lightbox"><img class="img-with-animation" data-delay="' . $delay . '" data-animation="' . strtolower( $parsed_animation ).'" src="' . $image_url . '" alt="' . $alt_tag . '" /></a>';
			}

			return '<img class="img-with-animation" data-delay="' . $delay . '" data-animation="' . strtolower( $parsed_animation ) . '" src="'.$image_url.'" alt="' . $alt_tag . '" />';
}
add_shortcode( 'image_with_animation', 'cfx_image_with_animation' );

//divider
function cfx_divider( $atts, $content = null ) {
	extract(
		shortcode_atts(
			array(
				'custom_height' => '',
				'line_type' => 'No Line',
			), $atts));

			if ( $line_type == 'Small Thick Line' || $line_type == 'Small Line' ){
				$height = ( ! empty( $custom_height ) ) ? 'style="margin-top: ' . intval( $custom_height / 2 ).'px; margin-bottom: ' . intval( $custom_height / 2 ) . 'px;"' : null;
				$divider = '<div ' . $height . ' class="cfx-divider-small-border"></div>';
			} else if ( $line_type == 'Full Width Line' ){
				$height = ( ! empty( $custom_height ) ) ? 'style="margin-top: ' . intval( $custom_height / 2 ).'px; margin-bottom: ' . intval( $custom_height / 2 ).'px;"' : null;
				$divider = '<div ' . $height . ' class="cfx-divider-border"></div>';
			} else {
				$height = ( ! empty( $custom_height ) ) ? 'style="height: ' . intval( $custom_height ) . 'px;"' : null;
				$divider = '<div ' . $height . ' class="cfx-divider"></div>';
			}

			return $divider;
}
add_shortcode( 'divider', 'cfx_divider' );

//icon
function cfx_icon( $atts, $content = null ) {
	extract(
		shortcode_atts(
			array(
				'size' => 'large',
				'background_color' => '',
				'text_color' => '',
				'image' => 'icon-circle'
			), $atts ) );

			$style = null;

			if ( ! empty( $background_color ) AND $size != 'large-alt' ) {
				$style .= 'background-color: ' . $background_color . '; ';
			}
			else if ( $size == 'large-alt' ) {
				$style .= 'border: 2px solid ' . $background_color . ';';
			}

			if ( ! empty( $text_color ) ) {
				$style .= 'color: ' . $text_color . '; ';
			}

			if ( $size == 'large' ) {
				$size_class = 'fa fa-3x';
			}
			else if ( $size == 'regular' ) {
				$size_class = 'fa fa-2x';
			}
			else if ( $size == 'tiny' ) {
				$size_class = 'fa';
			}
			else {
				$size_class = 'fa fa-2x';
			}

			return '<i class="' . $size_class . ' ' . $image . '" style="' . $style . '"></i>';
}
add_shortcode( 'icon', 'cfx_icon' );

function cfx_google_map( $atts ) {
	extract(
		shortcode_atts(
			array(
				'latitude' => '',
				'longitude' => '',
				'zoom' => '16',
				'height' => '320',
				'title' => '',
				'address' => '',
				'image_url' => '',
			), $atts ) );
			$output = '';

			if ( $latitude AND $longitude ){
				$map_canvas_id = 'map_canvas_' . sanitize_title( $latitude ) . '_' . sanitize_title( $longitude );
				$output .= '<div id="' . $map_canvas_id . '" style="width: 100%; height: ' . $height . 'px;"></div>'."\n\r";
				$output .= '<script type="text/javascript">' . "\n\r";
				$output .= '(function($){'."\n\r";
				$output .= '$( document ).ready(function() {' . "\n\r";

				$output .= 'var map_lat = ' . $latitude . ';' . "\n\r";
				$output .= 'var map_long = ' . $longitude . ';' . "\n\r";
				$output .= 'var map_style = [{"featureType": "all","stylers": [{"saturation": -100},{"gamma": 0.5}]}];' . "\n\r";
				$output .= 'var map_zoom = ' . $zoom . ';' . "\n\r";

				$output .= '$("#' . $map_canvas_id . '").googleMap({' . "\n\r";
				$output .= 'coords: [map_lat, map_long],' . "\n\r";
				$output .= 'styles: map_style,' . "\n\r";
				$output .= 'zoom: map_zoom' . "\n\r";
				$output .= '});' . "\n\r";

				$output .= '$("#' . $map_canvas_id . '").addMarker({' . "\n\r";
				$output .= 'coords: [map_lat, map_long],' . "\n\r";
				$output .= 'icon: "' . $image_url . '",' . "\n\r";
				$output .= 'title: "' . addslashes( $title ) . '",' . "\n\r";
				$output .= 'text: "' . addslashes( $address ) . '"' . "\n\r";
				$output .= '});' . "\n\r";

				$output .= '});' . "\n\r";
				$output .= '})(jQuery);' . "\n\r";
				$output .= '</script>' . "\n\r";
			}
			return $output;
}
add_shortcode( 'google_map', 'cfx_google_map' );

//button
function cfx_button( $atts, $content = null ) {
	extract(
		shortcode_atts(
			array(
				'id' => 'btn-'.rand( 1, 600 ),
				'text' => 'Submit',
				'url' => '#',
				'target' => '_self',
				'text_color' => '',
				'background_color' => '',
				'shadow_color' => '',
				'class' => '',
			), $atts));

			$outer_style = '<style type="text/css">
		#'.$id.':focus,
		#'.$id.":active{
            -moz-box-shadow: none !important;
            -webkit-box-shadow: none !important;
            -webkit-transform: translate3d(0, 3px, 0);
            -moz-transform: translate3d(0, 3px, 0);
            -ms-transform: translate3d(0, 3px, 0);
            -o-transform: translate3d(0, 3px, 0);
            transform: translate3d(0, 3px, 0);
            background-color: $background_color !important ;
        }
    </style>";

			$style = "color: $text_color; background-color: $background_color; box-shadow: 0 3px 0px $shadow_color;";

			$output = '<a id="' . $id . '" href="' . $url . '" class="btn btn-shadow ' . $class . '" style=" ' . $style . '" target="' . $target . '">' . $text . '</a>';

			return $outer_style . $output;
}
add_shortcode( 'button', 'cfx_button' );