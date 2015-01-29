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
    if ( !empty( $class ) )
        $column_classes .= ' ' . $class;
    if ( !empty( $align ) )
        $column_classes .= ' ' . $align;

    if ( !empty( $id ) ) $attr .= ' id="' . $id . '"';

    if( $centered_text == 'true' ) $column_classes .= ' cfx-text-centered';

    if( !empty( $animation ) ) {
		 $column_classes .= ' has-animation';
		
		 $parsed_animation = str_replace( " ", "-", $animation );
		 $delay = intval( $delay );
	}

    return '<div class="cfx-column ' . $column_classes . '"' . $attr . ' data-animation="'.strtolower($parsed_animation).'" data-delay="'.$delay.'" >' . do_shortcode( $content ) . '</div>';
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
    if ( !empty( $class ) )
        $column_classes .= ' ' . $class;
    if ( !empty( $align ) )
        $column_classes .= ' ' . $align;

    if ( !empty( $id ) ) $attr .= ' id="' . $id . '"';

    if( $centered_text == 'true' ) $column_classes .= ' cfx-text-centered';

    if( !empty( $animation ) ) {
		 $column_classes .= ' has-animation';
		
		 $parsed_animation = str_replace( " ", "-", $animation );
		 $delay = intval( $delay );
	}

    return '<div class="cfx-column ' . $column_classes . '"' . $attr . ' data-animation="'.strtolower($parsed_animation).'" data-delay="'.$delay.'" >' . do_shortcode( $content ) . '</div>';
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
    if ( !empty( $class ) )
        $classes .= ' ' . $class; 
    if ( !empty( $align) )
        $classes .= ' ' . $align;

    if ( !empty( $first ) ) {
        if ( $first == 'yes' ) {
            $before = '<div class="' . calibrefx_row_class() . '">';
        }
    }
    if ( !empty( $last ) ) {
        if ( $last == 'yes' ) {
            $after = '</div>';
        }
    }

    if ( !empty( $style ) ) $attr .= ' style="' . $style . '"';
    if ( !empty( $id ) ) $attr .= ' id="' . $id . '"';

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
    if ( !empty( $class ) )
        $classes .= ' ' . $class;
    if ( !empty( $align) )
        $classes .= ' ' . $align;

    if ( !empty( $first ) ) {
        if ( $first == 'yes' ) {
            $before = '<div class="' . calibrefx_row_class() . '">';
        }
    }
    if ( !empty( $last ) ) {
        if ( $last == 'yes' ) {
            $after = '</div>';
        }
    }

    if ( !empty( $style ) ) $attr .= ' style="' . $style . '"';
    if ( !empty( $id ) ) $attr .= ' id="' . $id . '"';

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
    if ( !empty( $class ) )
        $classes .= ' ' . $class;   
    if ( !empty( $align) )
        $classes .= ' ' . $align;

    if ( !empty( $first ) ) {
        if ( $first == 'yes' ) {
            $before = '<div class="' . calibrefx_row_class() . '">';
        }
    }
    if ( !empty( $last ) ) {
        if ( $last == 'yes' ) {
            $after = '</div>';
        }
    }

    if ( !empty( $style ) ) $attr .= ' style="' . $style . '"';
    if ( !empty( $id ) ) $attr .= ' id="' . $id . '"';

    return $before . '<div class="' . $classes . '"' . $attr . '>' . do_shortcode( advance_shortcode_unautop( $content ) ) . '</div>' . $after;
}
add_shortcode( 'three_fourth', 'calibrefx_three_fourth_column' );

//image with animation
function cfx_image_with_animation($atts, $content = null) { 
    extract(
        shortcode_atts(
            array(
                "animation" => 'Fade In', 
                "delay" => '0', 
                "image_url" => '', 
                'alt' => '', 
                'img_link_target' => 
                '_self', 
                'img_link' => '', 
                'img_link_large' => ''
            ), $atts ) );
    
    $parsed_animation = str_replace( " ", "-", $animation );
    ( !empty( $alt ) ) ? $alt_tag = $alt : $alt_tag = null;
    
    if( preg_match( '/^\d+$/', $image_url ) ){
        $image_src = wp_get_attachment_image_src( $image_url, 'full' );
        $image_url = $image_src[0];
    }
    
    if( !empty( $img_link ) OR !empty( $img_link_large ) ){
        
        if( !empty( $img_link ) AND empty( $img_link_large ) ) {
            
            return '<a href="' . $img_link . '" target="' . $img_link_target . '"><img class="img-with-animation" data-delay="' . $delay . '" data-animation="' . strtolower( $parsed_animation ) . '" src="' . $image_url . '" alt="' . $alt_tag . '" /></a>';
            
        } elseif( !empty( $img_link_large ) ) {
            
            return '<a href="' . $image_url . '" class="pp"><img class="img-with-animation" data-delay="' . $delay . '" data-animation="' . strtolower( $parsed_animation ).'" src="' . $image_url . '" alt="' . $alt_tag . '" /></a>';
        }
        
    } else {
        return '<img class="img-with-animation" data-delay="' . $delay . '" data-animation="' . strtolower( $parsed_animation ) . '" src="'.$image_url.'" alt="' . $alt_tag . '" />';
    }
   
}
add_shortcode('image_with_animation', 'cfx_image_with_animation');

//divider
function cfx_divider( $atts, $content = null ) {  
    extract( 
        shortcode_atts(
            array(
                "custom_height" => '', 
                "line_type" => 'No Line'
            ), $atts));
    
    if( $line_type == 'Small Thick Line' || $line_type == 'Small Line' ){
        $height = ( !empty( $custom_height ) ) ? 'style="margin-top: ' . intval( $custom_height/2 ).'px; margin-bottom: ' . intval( $custom_height/2 ) . 'px;"' : null;
        $divider = '<div ' . $height . ' class="cfx-divider-small-border"></div>';
    } else if($line_type == 'Full Width Line'){
        $height = ( !empty( $custom_height ) ) ? 'style="margin-top: ' . intval( $custom_height/2 ).'px; margin-bottom: ' . intval( $custom_height/2 ).'px;"' : null;
        $divider = '<div ' . $height . ' class="cfx-divider-border"></div>';
    } else {
        $height = ( !empty( $custom_height ) ) ? 'style="height: ' . intval( $custom_height ) . 'px;"' : null;
        $divider = '<div ' . $height . ' class="cfx-divider"></div>';
    }
    
    return $divider;
}
add_shortcode( 'divider', 'cfx_divider' );