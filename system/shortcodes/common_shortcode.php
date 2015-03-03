<?php

/* Site URL */
function calibrefx_site_url( $atts, $content = null ) {
	extract( shortcode_atts( array(
				'path' => '',
				'scheme' => null,
					), $atts ) );

	return site_url( $path, $scheme );
}
add_shortcode( 'site_url', 'calibrefx_site_url' );

/* Home URL */
function calibrefx_home_url( $atts, $content = null ) {
	extract( shortcode_atts( array(
				'path' => '',
				'scheme' => null,
					), $atts ) );

	return home_url( $path, $scheme );
}
add_shortcode( 'home_url', 'calibrefx_home_url' );

/**
 * ==============================================================
 * Text Heading
 * ==============================================================
 */

function calibrefx_h1( $atts, $content = '' ) {
	extract( shortcode_atts( array(
				'before' => '',
				'after' => '',
				'class' => '',
				'style' => '',
				'color' => '',
				'font' => '',
				'font_style' => ''
	), $atts ) );

	$classes = 'heading';
	if ( ! empty( $class ) ) {
		$classes .= ' ' . $class; }
	if ( ! empty( $color ) ) {
		$classes .= ' ' . $color; }
	if ( ! empty( $font ) ) {
		$classes .= ' font-' . $font; }
	if ( ! empty( $font_style ) ) {
		$classes .= ' font-' . $font_style; }

	return $before . "<h1 class='$classes' style='$style'>" . do_shortcode( $content ) . '</h1>' . $after;
}
add_shortcode( 'h1', 'calibrefx_h1' );

function calibrefx_h2( $atts, $content = '' ) {
	extract( shortcode_atts( array(
				'before' => '',
				'after' => '',
				'class' => '',
				'style' => '',
				'color' => '',
				'font' => '',
				'font_style' => ''
	), $atts ) );

	$classes = 'heading';
	if ( ! empty( $class ) ) {
		$classes .= ' ' . $class; }
	if ( ! empty( $color ) ) {
		$classes .= ' ' . $color; }
	if ( ! empty( $font ) ) {
		$classes .= ' font-' . $font; }
	if ( ! empty( $font_style ) ) {
		$classes .= ' font-' . $font_style; }

	return $before . "<h2 class='$classes' style='$style'>" . do_shortcode( $content ) . '</h2>' . $after;
}
add_shortcode( 'h2', 'calibrefx_h2' );


function calibrefx_h3( $atts, $content = '' ) {
	extract( shortcode_atts( array(
				'before' => '',
				'after' => '',
				'class' => '',
				'style' => '',
				'color' => '',
				'font' => '',
				'font_style' => ''
	), $atts ) );

	$classes = 'heading';
	if ( ! empty( $class ) ) {
		$classes .= ' ' . $class; }
	if ( ! empty( $color ) ) {
		$classes .= ' ' . $color; }
	if ( ! empty( $font ) ) {
		$classes .= ' font-' . $font; }
	if ( ! empty( $font_style ) ) {
		$classes .= ' font-' . $font_style; }

	return $before . "<h3 class='$classes' style='$style'>" . do_shortcode( $content ) . '</h3>' . $after;
}
add_shortcode( 'h3', 'calibrefx_h3' );

function calibrefx_h4( $atts, $content = '' ) {
	extract( shortcode_atts( array(
				'before' => '',
				'after' => '',
				'class' => '',
				'style' => '',
				'color' => '',
				'font' => '',
				'font_style' => ''
	), $atts ) );

	$classes = 'heading';
	if ( ! empty( $class ) ) {
		$classes .= ' ' . $class; }
	if ( ! empty( $color ) ) {
		$classes .= ' ' . $color; }
	if ( ! empty( $font ) ) {
		$classes .= ' font-' . $font; }
	if ( ! empty( $font_style ) ) {
		$classes .= ' font-' . $font_style; }

	return $before . "<h4 class='$classes' style='$style'>" . do_shortcode( $content ) . '</h4>' . $after;
}
add_shortcode( 'h4', 'calibrefx_h4' );

function calibrefx_h5( $atts, $content = '' ) {
	extract( shortcode_atts( array(
				'before' => '',
				'after' => '',
				'class' => '',
				'style' => '',
				'color' => '',
				'font' => '',
				'font_style' => ''
	), $atts ) );

	$classes = 'heading';
	if ( ! empty( $class ) ) {
		$classes .= ' ' . $class; }
	if ( ! empty( $color ) ) {
		$classes .= ' ' . $color; }
	if ( ! empty( $font ) ) {
		$classes .= ' font-' . $font; }
	if ( ! empty( $font_style ) ) {
		$classes .= ' font-' . $font_style; }

	return $before . "<h5 class='$classes' style='$style'>" . do_shortcode( $content ) . '</h5>' . $after;
}
add_shortcode( 'h5', 'calibrefx_h5' );

function calibrefx_h6( $atts, $content = '' ) {
	extract( shortcode_atts( array(
				'before' => '',
				'after' => '',
				'class' => '',
				'style' => '',
				'color' => '',
				'font' => '',
				'font_style' => ''
	), $atts ) );

	$classes = 'heading';
	if ( ! empty( $class ) ) {
		$classes .= ' ' . $class; }
	if ( ! empty( $color ) ) {
		$classes .= ' ' . $color; }
	if ( ! empty( $font ) ) {
		$classes .= ' font-' . $font; }
	if ( ! empty( $font_style ) ) {
		$classes .= ' font-' . $font_style; }

	return $before . "<h6 class='$classes' style='$style'>" . do_shortcode( $content ) . '</h6>' . $after;
}
add_shortcode( 'h6', 'calibrefx_h6' );

/**
 * ==============================================================
 * Video Section
 * ==============================================================
 */

/* Youtube */
function calibrefx_youtube( $atts, $content = null ) {
	extract( shortcode_atts( array(
				'before' => '',
				'after' => '',
				'width' => '',
				'height' => '',
				'title' => '',
					), $atts ) );

	return '<div class="flexible-container youtube"><iframe title="' . $title . '" width="' . $width . '" height="' . $height . '" src="http://www.youtube.com/embed/' . $content . '" frameborder="0" allowfullscreen></iframe></div>';
}
add_shortcode( 'youtube', 'calibrefx_youtube' );

/* Youtube Thumbnail */
function calibrefx_youtube_thumbnail( $atts, $content = null ) {

	extract( shortcode_atts( array(
		'width' => '',
		'height' => '',
		'title' => '',
		'id' => '',
		'class' => 'thumbnail',
		'style' => ''
	), $atts ) );

	if ( empty( $content ) ) { return '<div class="alert alert-error">' . __( 'Not a valid Youtube video ID. The video cannot be shown . ', 'calibrefx' ) . '</div>'; }

	$url = 'http://www.youtube.com/watch?v=' . $content;

	// get var from v variable
	$video_query = parse_url( $url, PHP_URL_QUERY );
	$vars = array();
	parse_str( $video_query, $vars );

	// get image url from youtube
	$remote = wp_remote_retrieve_body(
		wp_remote_request(
			sprintf( 'http://gdata.youtube.com/feeds/api/videos/%s?v=2&alt=json',
			$vars['v'] ),
			array( 'timeout' => 100 )
		) );

		$youtube_data = json_decode( $remote, true );

		if ( $youtube_data === null ) {
			return '<div class="alert alert-error">' . __( 'The youtube video is currently not available. The video cannot be shown . ', 'calibrefx' ) . '</div>'; }

		$video_title = $youtube_data['entry']['media$group']['media$title']['$t'];
		$video_desc = $youtube_data['entry']['media$group']['media$description']['$t'];

		$title = ( ! empty( $title ) ? $title : $video_title );

		$imageurl = $youtube_data['entry']['media$group']['media$thumbnail'][3]['url'];

		if ( ! empty( $height ) ) {
			if ( $height <= 90 ) {
				$imageurl = $youtube_data['entry']['media$group']['media$thumbnail'][0]['url'];
			} elseif ( $height <= 180 ) {
				$imageurl = $youtube_data['entry']['media$group']['media$thumbnail'][1]['url'];
			} elseif ( $height <= 360 ) {
				$imageurl = $youtube_data['entry']['media$group']['media$thumbnail'][2]['url'];
			} elseif ( $height <= 480 ) {
				$imageurl = $youtube_data['entry']['media$group']['media$thumbnail'][3]['url'];
			}

			$style .= 'height:' . $height . 'px;';
		}

		if ( ! empty( $width ) ) {
			$style .= 'width:' . $width . 'px;';
		}

		return '<img class="youtube-thumbnail ' . $class . '" id="' . $id . '" style="' . $style . '" src="' . $imageurl . '" alt="' . $title . '" />';
}
add_shortcode( 'youtube_thumbnail', 'calibrefx_youtube_thumbnail' );

/* Vimeo */
function calibrefx_vimeo( $atts, $content = null ) {
	extract( shortcode_atts( array(
				'before' => '',
				'after' => '',
				'width' => '',
				'height' => '',
				'title' => '',
					), $atts ) );

	return '<div class="flexible-container vimeo"><iframe title="' . $title . '" width="' . $width . '" height="' . $height . '" src="http://player.vimeo.com/video/' . $content . '" frameborder="0"></iframe></div>';
}
add_shortcode( 'vimeo', 'calibrefx_vimeo' );

/**
 * ==============================================================
 * Typography Section
 * ==============================================================
 */

/* Text */
function calibrefx_text( $atts, $content = '' ) {
	extract( shortcode_atts( array(
				'before' => '',
				'after' => '',
				'class' => '',
				'color' => '',
				'font' => '',
				'style' => '',
				'weight' => '',
				'type' => 'normal',
				'id' => ''
					), $atts ) );

	$classes = 'text';
	if ( ! empty( $class ) ) {
		$classes .= ' ' . $class; }
	if ( ! empty( $color ) ) {
		$classes .= ' ' . $color; }
	if ( ! empty( $font ) ) {
		$classes .= ' font-' . $font; }
	if ( ! empty( $style ) ) {
		$classes .= ' font-' . $style; }
	if ( ! empty( $weight ) ) {
		$classes .= ' font-weight-' . $weight; }

	if ( $type == 'normal' ) {
		$elm = 'span'; }
	elseif ( $type == 'paragraph' )
		$elm = 'p';
	elseif ( $type == 'div' )
		$elm = 'div';

	$attr = '';
	if ( ! empty( $id ) ) { $attr .= ' id="' . $id . '"'; }

	return $before . '<' .  $elm  . ' class="' . $classes . '"' . $attr . '>' . do_shortcode( $content ) . '</' . $elm . '>' . $after;
}
add_shortcode( 'text', 'calibrefx_text' );

/* Bold */
function calibrefx_bold( $atts, $content = '' ) {
	extract( shortcode_atts( array(
				'before' => '',
				'after' => '',
					), $atts ) );

	return $before . '<strong>' . do_shortcode( $content ) . '</strong>' . $after;
}
add_shortcode( 'bold', 'calibrefx_bold' );

/* Italic */
function calibrefx_italic( $atts, $content = '' ) {
	extract( shortcode_atts( array(
				'before' => '',
				'after' => '',
					), $atts ) );

	return $before . '<i>' . do_shortcode( $content ) . '</i>' . $after;
}
add_shortcode( 'italic', 'calibrefx_italic' );

/* Em */
function calibrefx_em( $atts, $content = '' ) {
	extract( shortcode_atts( array(
				'before' => '',
				'after' => '',
					), $atts ) );

	return $before . '<em>' . do_shortcode( $content ) . '</em>' . $after;
}
add_shortcode( 'em', 'calibrefx_em' );

/* Cite */
function calibrefx_cite( $atts, $content = '' ) {
	extract( shortcode_atts( array(
				'before' => '',
				'after' => '',
					), $atts ) );

	return $before . '<cite>' . do_shortcode( $content ) . '</cite>' . $after;
}
add_shortcode( 'cite', 'calibrefx_cite' );

/* Blockquote */
function calibrefx_blockquote( $atts, $content = '' ) {
	extract( shortcode_atts( array(
				'before' => '',
				'after' => '',
					), $atts ) );

	return $before . '<blockquote>' . do_shortcode( $content ) . '</blockquote>' . $after;
}
add_shortcode( 'blockquote', 'calibrefx_blockquote' );

/**
 * ==============================================================
 * Icon Section
 * ==============================================================
 */
function calibrefx_icon( $atts, $content = '' ) {
	extract( shortcode_atts( array(
				'before' => '',
				'after' => '',
				'name' => '',
				'class' => '',
				'style' => '',
					), $atts ) );

	$attr = '';
	$classes = 'glyphicon';

	if ( ! empty( $name) ) { $classes .= ' ' . $name; }
	if ( ! empty( $class ) ) { $classes .= ' ' . $class; }

	if ( ! empty( $style ) ) { $attr .= ' style="' . $style . '"'; }

	return $before . '<i class="' . $classes . '"' . $attr . '></i>' . $after;
}
add_shortcode( 'i', 'calibrefx_icon' );

/**
 * ==============================================================
 * Image Section
 * ==============================================================
 */
function calibrefx_img( $atts, $content = null ) {

	extract( shortcode_atts( array(
				'before' => '',
				'after' => '',
				'width' => '',
				'height' => '',
				'title' => '',
				'class' => '',
				'alt' => '',
				'id' => '',
					), $atts ) );

	$attr = '';
	if ( ! empty( $width) ) { $attr .= ' width="' . $width . '"'; }
	if ( ! empty( $height) ) { $attr .= ' height="' . $height . '"'; }
	if ( ! empty( $title) ) { $attr .= ' title="' . $title . '"'; }
	if ( ! empty( $class ) ) { $attr .= ' width="' . $class . '"'; }
	if ( ! empty( $alt) ) { $attr .= ' alt="' . $alt . '"'; }
	if ( ! empty( $id ) ) { $attr .= ' id="' . $id . '"'; }

	return $before . '<img src="' . do_shortcode( $content ) . '"' . $attr . ' />' . $after;
}
add_shortcode( 'img', 'calibrefx_img' );

/**
 * ==============================================================
 * User Section
 * ==============================================================
 */

/* Loggedin User First Name */
function calibrefx_user_firstname( $atts, $content = '' ) {
	global $current_user;
	get_currentuserinfo();

	extract( shortcode_atts( array(
				'before' => '',
				'after' => '',
					), $atts ) );

	return $before . $current_user->user_firstname . $after;
}
add_shortcode( 'user_firstname', 'calibrefx_user_firstname' );

/* Loggedin User Last Name */
function calibrefx_user_lastname( $atts, $content = '' ) {
	global $current_user;
	get_currentuserinfo();

	extract( shortcode_atts( array(
				'before' => '',
				'after' => '',
					), $atts ) );

	return $before . $current_user->user_lastname . $after;
}
add_shortcode( 'user_lastname', 'calibrefx_user_lastname' );

/* Loggedin User Email Address */
function calibrefx_user_email( $atts, $content = '' ) {
	global $current_user;
	get_currentuserinfo();

	extract( shortcode_atts( array(
				'before' => '',
				'after' => '',
					), $atts ) );

	return $before . $current_user->user_email . $after;
}
add_shortcode( 'user_email', 'calibrefx_user_email' );

/**
 * ==============================================================
 * Buttons
 * ==============================================================
 */
function calibrefx_button( $atts, $content = '' ) {
	extract( shortcode_atts( array(
				'before' => '',
				'after' => '',
				'class' => '',
				'style' => '',
				'active' => '',
				'disabled' => '',
				'block' => '',
				'id' => '',
				'url' => '#',
				'type' => '',
				'size' => '',
				'rel' => 'nofollow'
					), $atts ) );

	$classes = 'btn';
	if ( ! empty( $class ) ) {
		$classes .= ' ' . $class; }
	if ( ! empty( $type ) ) {
		$classes .= ' btn-' . $type; }
	if ( ! empty( $type ) ) {
		$classes .= ' btn-' . $size; }
	if ( ! empty( $active ) ) {
		$classes .= ' active'; }
	if ( ! empty( $disabled ) ) {
		$classes .= ' disabled'; }
	if ( ! empty( $block ) ) {
		$classes .= ' btn-block'; }

	$attr = '';
	if ( ! empty( $style ) ) {
		$attr .= ' style="' . $style . '"'; }
	if ( ! empty( $rel ) ) {
		$attr .= ' rel="' . $rel . '"'; }
	if ( ! empty( $id ) ) {
		$attr .= ' id="' . $id . '"'; }

	return $before . '<a href="' . $url . '" class="' . $classes . '"' . $attr . '>' . do_shortcode( $content ) . '</a>' . $after;
}
add_shortcode( 'button', 'calibrefx_button' );

/**
 * ==============================================================
 * Tooltip
 * ==============================================================
 */
function calibrefx_tooltip( $atts, $content = '' ) {
	extract( shortcode_atts( array(
		'before' => '',
		'after' => '',
		'class' => '',
		'id' => '',
		'position' => 'top',
		'text' => '',
		'url' => '#'
	), $atts ) );

	$classes  = ' class="' . $class . '"';
	$ids = ' id="' . $id . '"';

	return $before . '<a href="' . $url . '" data-toggle="tooltip" data-placement="' . $position . '" title="' . $text . '"' . $classes . $ids . '>' . advance_shortcode_unautop( $content ) . '</a>' . $after;
}
add_shortcode( 'tooltip', 'calibrefx_tooltip' );

/**
 * ==============================================================
 * Dropcap
 * ==============================================================
 */
function calibrefx_dropcap( $atts, $content = '' ) {
	extract( shortcode_atts( array(
				'before' => '',
				'after' => '',
				'class' => '',
				'color' => '',
				'font' => '',
				'style' => '',
				'size' => ''
					), $atts ) );

	$classes = 'dropcap';
	if ( ! empty( $class ) ) {
		$classes .= ' ' . $class; }
	if ( ! empty( $color ) ) {
		$classes .= ' ' . $color; }
	if ( ! empty( $font ) ) {
		$classes .= ' font-' . $font; }
	if ( ! empty( $style ) ) {
		$classes .= ' font-' . $style; }
	if ( ! empty( $size ) ) {
		$classes .= ' size-' . $size; }

	return $before . '<span class="' . $classes . '">' . do_shortcode( $content ) . '</span>' . $after;
}
add_shortcode( 'dropcap', 'calibrefx_dropcap' );

/**
 * ==============================================================
 * List
 * ==============================================================
 */

/* Main List Element */
function calibrefx_list( $atts, $content = '' ) {
	extract( shortcode_atts( array(
				'before' => '',
				'after' => '',
				'class' => '',
				'style' => ''
					), $atts ) );

	$classes = 'custom-list';
	if ( ! empty( $class ) ) {
		$classes .= ' ' . $class; }
	if ( ! empty( $style ) ) {
		$classes .= ' ' . $style; }

	return $before . '<div class="' . $classes . '">' . do_shortcode( $content ) . '</div>' . $after;
}
add_shortcode( 'list', 'calibrefx_list' );

/* List Element */
function calibrefx_list_item( $atts, $content = '' ) {
	extract( shortcode_atts( array(
				'class' => ''
					), $atts ) );

	return '<li class="' . $class . '">' . do_shortcode( $content ) . '</li>';
}
add_shortcode( 'li', 'calibrefx_list_item' );

/**
 * ==============================================================
 * Row
 * ==============================================================
 */
function calibrefx_row( $atts, $content = '' ) {
	extract( shortcode_atts( array(
				'class' => '',
				'style' => '',
				'id' => '',
					), $atts ) );

	$attr = '';
	$classes = calibrefx_row_class();
	if ( ! empty( $class ) ) { $classes .= ' ' . $class; }
	if ( ! empty( $style ) ) { $attr .= ' style="' . $style . '"'; }
	if ( ! empty( $id ) ) { $attr .= ' id="' . $id . '"'; }

	return '<div class="' . $classes . '"' . $attr . '>' . do_shortcode( advance_shortcode_unautop( $content ) ) . '</div>';
}
add_shortcode( 'row', 'calibrefx_row' );

/**
 * ==============================================================
 * Column
 * ==============================================================
 */
function calibrefx_column( $atts, $content = '' ) {
	extract( shortcode_atts( array(
				'class' => '',
				'cols' => '',
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

	if ( ! empty( $class ) ) {
		$classes .= ' ' . $class; }
	if ( ! empty( $cols ) ) {
		$classes .= ' ' . $cols; }
	if ( ! empty( $align ) ) {
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
add_shortcode( 'column', 'calibrefx_column' );

function calibrefx_tbel( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'id' => '',
		'class' => '',
		'src' => '',
	), $atts ) );

	$style = '';
	if ( $src ) {
		$style .= 'background-image: url(' . $src . ');';
	}

	return "<div id='$id' class='$class' style='$style'>".do_shortcode( advance_shortcode_unautop( $content ) ).'</div>';
}
add_shortcode( 'tbel', 'calibrefx_tbel' );


function calibrefx_tbcontainer( $atts, $content = null ) {
	return "<div class='container'>" . do_shortcode( advance_shortcode_unautop( $content ) ) . '</div>';
}
add_shortcode( 'tbcontainer', 'calibrefx_tbcontainer' );

function calibrefx_tbrow( $atts, $content = null ) {
	return "<div class='row'>" . do_shortcode( advance_shortcode_unautop( $content ) ) . '</div>';
}
add_shortcode( 'tbrow', 'calibrefx_tbrow' );

function calibrefx_tbcol( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'col' => '1',
		'offset' => '',
	), $atts ) );

	$offset_class = '';
	if ( $offset != '' ) {
		$offset_class = ' ' . col_offset_class( explode( ',', $offset ) );
	}

	return "<div class='". col_class( explode( ',', $col ) ) . "$offset_class'>".do_shortcode( advance_shortcode_unautop( $content ) ).'</div>';
}
add_shortcode( 'tbcol', 'calibrefx_tbcol' );

/**
 * ==============================================================
 * Separator
 * ==============================================================
 */

function calibrefx_separator( $atts, $content = '' ) {
	extract( shortcode_atts( array(
				'class' => '',
				'style' => '',
					), $atts ) );

	$classes = ' separator ';
	if ( ! empty( $class ) ) {
		$classes .= ' ' . $class; }

	$attr = '';
	if ( ! empty( $style ) ) { $attr .= ' style="' . $style . '"'; }
	return '<div class="' . $classes . '" style="' . $style . '">' . do_shortcode( advance_shortcode_unautop( $content ) ) . '</div>';
}
add_shortcode( 'separator', 'calibrefx_separator' );

function calibrefx_clear() {
	return '<div class="clearfix"></div>';
}
add_shortcode( 'clear', 'calibrefx_clear' );

/**
 * ==============================================================
 * HEADLINE
 * ==============================================================
 */
function calibrefx_headline( $atts, $content = '' ) {
	extract( shortcode_atts( array(
		'class' => '',
		'id' => '',
		'style' => '',
		'top_separator' => 0,
		'bottom_separator' => 0,
	), $atts ) );

	$attr = '';
	if ( ! empty( $id ) ) { $attr .= ' id="' . $id . '"'; }
	if ( ! empty( $style ) ) { $attr .= ' style="' . $style . '"'; }

	$classes = 'headline';
	if ( ! empty( $class ) ) { $classes .= ' ' . $class; }

	$html = '';
	$html .= '<div class="' . $class . '"' . $attr . '>';
	if ( $top_separator ) {
		$html .= '<div class="headline-separator top"></div>'; }
	$html .= '<div class="headline-content">';
	$html .= advance_shortcode_unautop( $content );
	$html .= '</div>';
	if ( $bottom_separator ) {
		$html .= '<div class="headline-separator bottom"></div>'; }
	$html .= '</div>';

	return $html;
}
add_shortcode( 'headline', 'calibrefx_headline' );

/**
 * ==============================================================
 * SOCIAL LINK
 * ==============================================================
 */
function calibrefx_gplus_url() {
	$gplus_page = calibrefx_get_option( 'gplus_page' );

	return $gplus_page;
}
add_shortcode( 'gplus_url', 'calibrefx_gplus_url' );

function calibrefx_facebook_url() {
	$facebook_fanpage = calibrefx_get_option( 'facebook_fanpage' );

	return $facebook_fanpage;
}
add_shortcode( 'facebook_url', 'calibrefx_facebook_url' );

function calibrefx_twitter_url() {
	$twitter_profile = calibrefx_get_option( 'twitter_profile' );

	return $twitter_profile;
}
add_shortcode( 'twitter_url', 'calibrefx_twitter_url' );

function calibrefx_youtube_url() {
	$youtube_channel = calibrefx_get_option( 'youtube_channel' );

	return $youtube_channel;
}
add_shortcode( 'youtube_url', 'calibrefx_youtube_url' );

function calibrefx_linkedin_url() {
	$linkedin_profile = calibrefx_get_option( 'linkedin_profile' );

	return $linkedin_profile;
}
add_shortcode( 'linkedin_url', 'calibrefx_linkedin_url' );

function calibrefx_pinterest_url() {
	$pinterest_profile = calibrefx_get_option( 'pinterest_profile' );

	return $pinterest_profile;
}
add_shortcode( 'pinterest_url', 'calibrefx_pinterest_url' );

function calibrefx_instagram_url() {
	$instagram_profile = calibrefx_get_option( 'instagram_profile' );

	return $instagram_profile;
}
add_shortcode( 'instagram_url', 'calibrefx_instagram_url' );

function calibrefx_github_url() {
	$github_profile = calibrefx_get_option( 'github_profile' );

	return $github_profile;
}
add_shortcode( 'github_url', 'calibrefx_github_url' );

function calibrefx_feed_url() {
	$feed_uri = calibrefx_get_option( 'feed_uri' );

	return $feed_uri;
}
add_shortcode( 'feed_url', 'calibrefx_feed_url' );

/**
 * ==============================================================
 * Google Maps
 * ==============================================================
 */
function calibrefx_gmap( $atts, $content = '' ) {
	extract( shortcode_atts( array(
		'before' => '',
		'after' => '',
		'class' => ''
	), $atts ) );

	return $before . '<div class="flexible-container gmaps">' . $content . '</div>' . $after;
}
add_shortcode( 'gmap', 'calibrefx_gmap' );

/**
 * ==============================================================
 * Slider
 * ==============================================================
 */
function calibrefx_slider( $atts, $content = '' ) {
	extract( shortcode_atts( array(
		'before' => '',
		'after' => '',
		'id' => '',
		'class' => '',
		'interval' => '3000',
		'speed' => 800,
		'fx' => 'fade',
		'pager' => 0,
		'next_prev' => 0,
		'slide_elm' => '> div',
		'auto_height' => 0,
		'height' => '',
		'width' => '',
		'caption' => 0,
		'carousel_visible' => '',
		'carousel_fluid' => '',
		'wrap' => '',
		'attr' => '',
		'loader' => 'wait'
	), $atts ) );

	if ( ! empty( $class ) ) {
		$class = ' ' . $class; }

	$pager_class = '';
	$style = '';

	if ( $pager || $next_prev ) {
		// Create custom ID for pager
		$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
		$size = strlen( $chars );
		for ( $i = 0; $i < 8; $i++ ) {
			$pager_class .= $chars[ rand( 0, $size - 1 ) ];
		}
	}

	$style_item = '';

	if ( ! empty( $width ) ) {
		$style_item .= 'width:' . $width . ';'; }

	if ( ! empty( $height ) ) {
		$style_item .= 'height:' . $height . ';'; }

	if ( ! empty( $width) || ! empty( $height ) ) {
		$style .= ' style="' . $style_item . '"'; }

	$data_cycle = '';
	$data_cycle .= ' data-cycle-fx="' . $fx . '"';
	$data_cycle .= ' data-cycle-timeout="' . $interval . '"';

	if ( ! empty( $speed ) ) {
		$data_cycle .= ' data-cycle-speed="' . $speed . '"'; }

	if ( ! empty( $slide_elm ) ) {
		if ( $caption ) {
			$data_cycle .= ' data-cycle-slides="' . $slide_elm . ':not(.cycle-overlay)"';
			$data_cycle .= ' data-cycle-overlay-fx-sel="div.cycle-overlay"';
		} else {
			$data_cycle .= ' data-cycle-slides="' . $slide_elm . '"';
		}
	}

	if ( $pager ) {
		$data_cycle .= ' data-cycle-pager="#' . $pager_class . '" data-cycle-pager-template=\'<a href="#" class="slider-pager-item">{{slideNum}}</a>\''; }

	if ( $next_prev ) {
		$data_cycle .= ' data-cycle-prev="#slider-prev-' . $pager_class . '" data-cycle-next="#slider-next-' . $pager_class . '"'; }

	if ( $auto_height !== 0 ) {
		$data_cycle .= ' data-cycle-auto-height="' . $auto_height . '"'; }

	if ( $caption ) {
		$data_cycle .= ' data-cycle-caption-plugin=caption2'; }

	if ( ! empty( $carousel_visible ) ) {
		$data_cycle .= ' data-cycle-carousel-visible="' . $carousel_visible . '"'; }

	if ( ! empty( $carousel_fluid ) ) {
		$data_cycle .= ' data-cycle-carousel-fluid="' . $carousel_fluid . '"'; }

	if ( ! empty( $wrap ) ) {
		$data_cycle .= ' data-allow-wrap="' . $wrap . '"'; }

	if ( ! empty( $loader ) ) {
		$data_cycle .= ' data-allow-loader="' . $loader . '"'; }

	$data_cycle .= ' data-cycle-pause-on-hover="true"';

	$attr = '';
	if ( ! empty( $id ) ) {
		$attr .= ' id="' . $id . '"'; }

	$html = '';
	$html .= '<div class="slider-container' . $class . '"' . $attr . '>';
	$html .= '<div class="slider-wrapper">';
	$html .= '<div class="slider cycle-slideshow"' . $data_cycle.$style . '>';

	if ( $caption ) {
		$html .= '<div class="cycle-overlay"></div>'; }

	$html .= advance_shortcode_unautop( $content );
	$html .= '</div><!-- end .slider -->';

	if ( $pager ) {
		$html  .= '<div id="' . $pager_class . '" class="slider-pager"></div><!-- end .slider-pager -->'; }

	if ( $next_prev ) {
		$html  .= '<a href="#" class="slider-nav slider-prev" id="slider-prev-' . $pager_class . '">&laquo; prev</a><a href="#" class="slider-nav slider-next" id="slider-next-' . $pager_class . '">next &raquo;</a>'; }

	$html .= '</div><!-- end .slider-wrapper -->';
	$html .= '</div><!-- end .slider-container -->';

	return $before.$html.$after;
}
add_shortcode( 'slider', 'calibrefx_slider' );

function calibrefx_slider_item( $atts, $content = '' ) {
	extract( shortcode_atts( array(
		'before' => '',
		'after' => '',
		'class' => '',
		'src' => '',
		'url' => '',
		'title' => '',
		'desc' => ''
	), $atts ) );

	if ( ! empty( $url ) && $url != '#' ) {
		return '<div class="item ' . $class . '" data-cycle-title=\'<a href="' . $url . '">' . $title . '</a>\' data-cycle-desc="' . $desc . '">' . $before . '<a href="' . $url . '" title="' . $title . '"><img src="' . $src . '" alt="' . $title . '" /></a>'  . $after . '</div>';
	} else {
		return '<div class="item ' . $class . '" data-cycle-title="' . $title . '" data-cycle-desc="' . $desc . '">' . $before . '<img src="' . $src . '" alt="' . $title . '" />'  . $after . '</div>';
	}
}
add_shortcode( 'slider_item', 'calibrefx_slider_item' );

function calibrefx_slider_caption( $atts, $content = '' ) {
	extract( shortcode_atts( array(
				'before' => '',
				'after' => '',
				'class' => '',
					), $atts ) );

	return '<div class="carousel-caption ' . $class . '">' . $before . advance_shortcode_unautop( $content ) . $after . '</div>';
}
add_shortcode( 'slider_caption', 'calibrefx_slider_caption' );


/**
 * ==============================================================
 * Tabbed Content
 * ==============================================================
 */
add_shortcode( 'tabs', 'calibrefx_tabs' );

function calibrefx_tabs( $atts, $content = null ) {
	global $tab_elm_id;

	extract( shortcode_atts( array(
		'before' => '',
		'after' => '',
		'id' => 'entry-tab',
		'tab' => 'tab1|tab2|tab3',
		'class' => 'entry-tab',
		'headings' => 'Tab1|Tab2|Tab3' ),
	$atts ) );

	$tabs_headings = explode( '|', $headings );
	$tabs_elements = explode( '|', $tab );

	$classes = '';
	$ids = '';

	if ( ! empty( $class ) ) {
		$classes .= ' ' . $class; }

	if ( ! empty( $id ) ) {
		$ids .= ' id="' . $id . '"';
	} else {
		// Create custom ID for tabs
		$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
		$size = strlen( $chars );
		for ( $i = 0; $i < 8; $i++ ) {
			$id .= $chars[ rand( 0, $size - 1 ) ];
		}

		$ids .= ' id="' . $id . '"';
	}

	$tab_elm_id = $id;

	$output = '<ul class="nav nav-tabs' . $classes . '"' . $ids . '>';

	$i = 0;
	//iterate through tabs headings
	foreach ( $tabs_headings as $tab_heading ) {
		$tab_id = '#' . $id . '-' . $tabs_elements[$i];
		$output .= '<li>';
		$output .= '<a href="' . $tab_id . '" data-toggle="tab">';
		$output .= $tab_heading;
		$output .= '</a>';
		$output .= '</li>';
		$i++;
	}

	$output .= '</ul>';

	$output .= '<div class="tab-content">' . advance_shortcode_unautop( $content ) . '</div>';
	$output .= '<script type="text/javascript">jQuery(function() { jQuery("#' . $id . ' a:first").tab("show"); });</script>';

	return $before.$output . $after;
}

// slides
function calibrefx_tabs_item( $atts, $content = null ) {
	global $tab_elm_id;

	extract( shortcode_atts( array( 'id' => '' ), $atts ) );

	return '<div class="tab-pane" id="' . $tab_elm_id . '-' . $id . '">' . advance_shortcode_unautop( $content ) . '</div>';
}
add_shortcode( 'tab', 'calibrefx_tabs_item' );

/**
 * ==============================================================
 * Togglebox
 * ==============================================================
 */
function calibrefx_togglebox( $atts, $content = null ) {
	global $togglebox_id;

	extract( shortcode_atts( array(
		'before' => '',
		'after' => '',
		'id' => '',
		'class' => '',
	), $atts ) );

	if ( empty( $id ) ) {
		$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
		$size = strlen( $chars );
		for ( $i = 0; $i < 8; $i++ ) {
			$id .= $chars[ rand( 0, $size - 1 ) ];
		}
	}

	$togglebox_id = $id;

	if ( ! empty( $class ) ) {
		$class = ' ' . $class; }

	return $before . '<div class="panel-group' . $class . '" id="' . $id . '">' . advance_shortcode_unautop( $content ) . '</div>' . $after;
}
add_shortcode( 'togglebox', 'calibrefx_togglebox' );

function calibrefx_togglebox_item( $atts, $content = null ) {
	global $togglebox_id;

	extract( shortcode_atts( array(
		'title' => '',
		'id' => '',
		'in' => 0
	), $atts ) );

	$class = '';
	if ( $in ) {
		$class = ' in'; }

	$output = '<div class="panel panel-default">
		<div class="panel-heading">
			<h4 class="panel-title">
				<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#' . $togglebox_id . '" href="#' . $togglebox_id . '-' . $id . '">
					' . $title . '
				</a>
			</h4>
		</div>
		<div id="' . $togglebox_id . '-' . $id . '" class="panel-collapse collapse' . $class . '">
			<div class="panel-body">
				' . advance_shortcode_unautop( $content ) . '
			</div>
		</div>
	</div>';

	return $output;
}
add_shortcode( 'togglebox_item', 'calibrefx_togglebox_item' );

/**
 * ==============================================================
 * alert Shortcode
 * ==============================================================
 */
function calibrefx_alert( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'close_button' => 1,
		'class' => '',
		'type' => '',
		'option' => '',
		'style' => '',
		'id' => ''
	), $atts ) );

	$output = '';

	$classes = 'alert alert-dismissable';
	if ( ! empty( $class ) ) {
		$classes .= ' ' . $class; }
	if ( ! empty( $type ) ) {
		$classes .= ' alert-' . $type; }
	if ( ! empty( $option) ) {
		$classes .= ' alert-' . $option; }

	$attr = '';
	if ( ! empty( $style ) ) {
		$attr .= ' style="' . $style . '"'; }
	if ( ! empty( $id ) ) {
		$attr .= ' id="' . $id . '"'; }

	$output .= '<div class="' . $classes . '"' . $attr . '>';

	if ( $close_button ) {
		$output .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'; }

	$output .= do_shortcode( $content );

	$output .= '</div>';

	return $output;
}
add_shortcode( 'alert', 'calibrefx_alert' );

/**
 * ==============================================================
 * bar Shortcode
 * ==============================================================
 */
function calibrefx_bar( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'active' => 0,
		'class' => '',
		'option' => '',
		'style' => '',
		'id' => '',
	), $atts ) );

	$output = '';

	$classes = 'progress';
	if ( ! empty( $class ) ) {
		$classes .= ' ' . $class; }
	if ( ! empty( $option) ) {
		$classes .= ' progress-' . $option; }
	if ( ! empty( $active) && $active == '1' ) {
		$classes .= ' active'; }

	$attr = '';
	if ( ! empty( $style ) ) {
		$attr .= ' style="' . $style . '"'; }
	if ( ! empty( $id ) ) {
		$attr .= ' id="' . $id . '"'; }

	$output .= '<div class="' .  $classes  . '"' . $attr . '>';

	$output .= do_shortcode( advance_shortcode_unautop( $content ) );

	$output .= '</div>';

	return $output;
}
add_shortcode( 'bar', 'calibrefx_bar' );

/**
 * ==============================================================
 * bar item Shortcode
 * ==============================================================
 */
function cronos_bar_item( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'length' => '10%',
		'title' => '',
		'class' => '',
		'type' => '',
		'style' => '',
	), $atts ) );

	$output = '';

	$classes = 'progress-bar';
	if ( ! empty( $class ) ) {
		$classes .= ' ' . $class; }
	if ( ! empty( $type ) ) {
		$classes .= ' progress-bar-' . $type; }

	$styles = '';
	if ( ! empty( $length) ) {
		$styles .= 'width:' . $length . ';'; }
	if ( ! empty( $style ) ) {
		$styles .= $style; }

	$output .= '<div class="' .  $classes  . '" style="' .  $styles  . '">';
	$output .= $title;
	$output .= '</div>';

	return $output;
}
add_shortcode( 'bar_item', 'cronos_bar_item' );

/**
 * ==============================================================
 * Social Icon Shortcode
 * ==============================================================
 */
function calibrefx_fblike( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'href' => '',
		'send' => 'false',
		'width' => '450',
		'faces' => 'false',
		'layout' => 'box_count',
		'color' => '',
		'action' => '',
	), $atts ) );

	$attr = '';

	if ( ! empty( $href ) ) {
		$attr .= ' data-href="' . $href . '"';
	} else {
		$attr .= ' data-href="' . get_permalink() . '"';
	}

	$attr .= ' data-send="' . $send . '"';
	$attr .= ' data-width="' . $width . '"';
	$attr .= ' data-show-faces="' . $faces . '"';

	if ( ! empty( $layout ) ) {
		$attr .= ' data-layout="' . $layout . '"'; }
	if ( ! empty( $color ) ) {
		$attr .= ' data-colorscheme="' . $color . '"'; }
	if ( ! empty( $action) ) {
		$attr .= ' data-action="' . $action . '"'; }

	$output = '<span class="social-bookmark facebook-like"><span class="fb-like"' . $attr . '></span></span>';

	return $output;
}
add_shortcode( 'fblike', 'calibrefx_fblike' );

function calibrefx_tweet( $atts, $content = null ) {
	global $post;

	extract( shortcode_atts( array(
		'url' => get_permalink(),
		'count' => 'vertical',
		'size' => 'medium',
		'text' => '',
		'related' => '',
		'via' => '',
		'lang' => '',
		'hashtags' => '',
		'dnt' => ''
	), $atts ) );

	$attr = '';

	if ( ! empty( $url) ) { $attr .= ' data-url="' . $url . '"'; }
	if ( ! empty( $count) ) { $attr .= ' data-count="' . $count . '"'; }
	if ( ! empty( $size ) ) { $attr .= ' data-size="' . $size . '"'; }
	if ( ! empty( $text) ) { $attr .= ' data-text="' . $text . '"'; }
	if ( ! empty( $related) ) { $attr .= ' data-related="' . $related . '"'; }
	if ( ! empty( $via) ) { $attr .= ' data-via="' . $via . '"'; }
	if ( ! empty( $lang) ) { $attr .= ' data-lang="' . $lang . '"'; }
	if ( ! empty( $hashtags) ) { $attr .= ' data-hashtags="' . $hashtags . '"'; }
	if ( ! empty( $dnt) ) { $attr .= ' data-dnt="' . $dnt . '"'; }

	$output = '<span class="social-bookmark tweet-share"><a href="https://twitter.com/share" class="twitter-share-button"' . $attr . '>Tweet</a></span>';

	return $output;
}
add_shortcode( 'tweet', 'calibrefx_tweet' );

function calibrefx_gplus( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'width' => 300,
		'size' => 'tall',
		'annotation' => 'bubble',
		'url' => get_permalink(),
	), $atts ) );

	$attr = '';

	if ( ! empty( $width) ) { $attr .= ' data-width="' . $width . '"'; }
	if ( ! empty( $url) ) { $attr .= ' data-href="' . $url . '"'; }
	if ( ! empty( $size ) ) { $attr .= ' data-size="' . $size . '"'; }
	if ( ! empty( $annotation) ) { $attr .= ' data-annotation="' . $annotation . '"'; }

	$output = '<span class="social-bookmark gplus-button"><span class="g-plusone"' . $attr . '></span></span>';

	return $output;
}
add_shortcode( 'gplus', 'calibrefx_gplus' );

function calibrefx_pinterest( $atts, $content = null ) {
	global $post;

	extract( shortcode_atts( array(
		'count' => 'above',
		'url' => get_permalink(),
		'media' => '',
	), $atts ) );

	if ( empty( $media ) ) {
		$image_id = get_post_thumbnail_id( $post->ID );

		$img_url = calibrefx_get_image( array( 'format' => 'url', 'id' => $image_id ) );

		if ( ! empty( $img_url) ) {
			$media = $img_url; }
	}

	$output = '<span class="social-bookmark pinterest-button"><a data-pin-config="' . $count . '" href="http://pinterest.com/pin/create/button/?url=' . urlencode( $url ) . '&media=' . urlencode( $media ) . '&description=' . urlencode( $content ) . '" data-pin-do="buttonPin" ><img src="http://assets.pinterest.com/images/pidgets/pin_it_button.png" /></a></span>';

	wp_enqueue_script( 'calibrefx-pinterest-widget', 'http://assets.pinterest.com/js/pinit.js', array(), false, true );

	return $output;
}
add_shortcode( 'pinterest', 'calibrefx_pinterest' );

function calibrefx_linkedin( $atts, $content = null ) {
	global $post;

	extract( shortcode_atts( array(
		'counter' => 'right',
		'url' => get_permalink()
	), $atts ) );

	$attr = '';

	if ( ! empty( $width ) ) { $attr .= ' data-counter="' . $counter . '"'; }
	if ( ! empty( $url ) ) { $attr .= ' data-url="' . $url . '"'; }

	$output = '<span class="social-bookmark linkedin-button"><script type="IN/Share"' . $attr . '></script></span>';

	wp_enqueue_script( 'calibrefx-linkedin-widget', 'http://platform.linkedin.com/in.js', array(), false, true );

	return $output;
}
add_shortcode( 'linkedin', 'calibrefx_linkedin' );


function calibrefx_feedburner( $atts, $content = null ) {
	$calibrefx_feedburner = get_option( 'calibrefx_feedburner' );
	extract( shortcode_atts( array(
				'name' => 'name'
					), $atts ) );
	if ( $calibrefx_feedburner ) {
		$output = "<a href='http://feeds.feedburner.com/{$calibrefx_feedburner}'><img src='http://feeds.feedburner.com/~fc/{$calibrefx_feedburner}?bg=99CCFF&amp;fg=444444&amp;anim=0' height='26' width='88' style='border:0' alt='' />
</a>"; }
	return $output;
}
add_shortcode( 'feedburner', 'calibrefx_feedburner' );

function fb_comment_box( $atts, $content = null ) {
	extract( shortcode_atts( array(
				'before' => '',
				'after' => '',
				'width' => 470,
				'numberpost' => 10,
				'url' => get_current_url(),
					), $atts ) );
	$output = '<div class="fb-comments" data-href="' . $url . '" data-width="' . $width . '" data-num-posts="' . $numberpost . '"></div>';

	return $before . $output . $after;
}
add_shortcode( 'facebook_comment', 'fb_comment_box' );

/**
 * ==============================================================
 * Post
 * ==============================================================
 */

function calibrefx_post_item( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'post_type' => 'post',
		'post_id' => '',
		'limit' => 0,
		'limit_text' => 'Read More',
		'show_title' => 1,
		'is_title_link' => 0,
		'show_featured_image' => 0,
		'before' => '',
		'after' => '',
		'class' => '',
		'id' => '',
		'style' => '',
	), $atts ) );

	if ( empty( $post_id ) ) { return; }

	$args = array();

	if ( $post_type != 'post' ) {
		$args['post_type'] = $post_type;

		if ( ! empty( $post_id ) ) {
			$args['page_id'] = $post_id;
		}
	} else {
		if ( ! empty( $post_id ) ) {
			$args['p'] = $post_id;
		}
	}

	$args['posts_per_page'] = 1;

	$query = new WP_Query( $args );

	$html = '';

	if ( $query->have_posts() ) :
		$post_class = '';
		foreach ( get_post_class() as $class_item => $val ) {
			$post_class .= ' ' . $val;
		}

		$html .= '<div class="post-item' . $post_class . ' ' . $class . '">';

		while ( $query->have_posts() ) : $query->the_post();
			if ( $show_title ) {
				if ( $is_title_link ) {
					$html .= '<h2 class="post-item-title"><a href="' . get_permalink() . '">' . get_the_title() . '</a></h2>';
				} else {
					$html .= '<h2 class="post-item-title">' . get_the_title() . '</h2>';
				}
			}

			if ( $show_featured_image ) {
				$post_img = calibrefx_get_image( array( 'format' => 'html', 'size' => '' ) );

				$html .= $post_img;
			}

			if ( $limit ) {
				$html .= get_the_content_limit( $limit, $limit_text );
			} else {
				$html .= wpautop( get_the_content(), true );
			}
		endwhile;

		$html .= '</div><!-- end .post-item -->';
	endif;

	wp_reset_query();
	wp_reset_postdata();

	return do_shortcode( $html );
}
add_shortcode( 'post', 'calibrefx_post_item' );

/**
 * Produces the date of post publication.
 *
 * Supported shortcode attributes are:
 *   after (output after link, default is empty string),
 *   before (output before link, default is empty string),
 *   format (date format, default is value in date_format option field),
 *   label (text following 'before' output, but before date).
 *
 */
function calibrefx_post_date_shortcode( $atts ) {
	$defaults = array(
			'after'  => '',
			'before' => '',
			'format' => get_option( 'date_format' ),
			'label'  => '',
	);
	$atts = shortcode_atts( $defaults, $atts );

	$display = '';

	switch ( $atts['format'] ) {
		case 'relative' :
			$display = calibrefx_human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ) . ' ' . __( 'ago', 'calibrefx' );
			break;
		case 'time-ago' :
			$display = calibrefx_time_ago( get_the_date( 'Y/m/d' ) );
			break;
		default:
			$display = get_the_time( $atts['format'] );
			break;
	}

	$output = sprintf( '<span class="date published time" title="%5$s">%1$s%3$s%4$s%2$s</span> ', $atts['before'], $atts['after'], $atts['label'], $display, get_the_time( 'c' ) );
	return apply_filters( 'calibrefx_post_date_shortcode', $output, $atts );
}
add_shortcode( 'post_date', 'calibrefx_post_date_shortcode' );

/**
 * Produces the time of post publication.
 *
 * Supported shortcode attributes are:
 *   after (output after link, default is empty string),
 *   before (output before link, default is empty string),
 *   format (date format, default is value in date_format option field),
 *   label (text following 'before' output, but before date).
 *
 */
function calibrefx_post_time_shortcode( $atts ) {
	$defaults = array(
			'after'  => '',
			'before' => '',
			'format' => get_option( 'time_format' ),
			'label'  => '',
	);
	$atts = shortcode_atts( $defaults, $atts );
	$output = sprintf( '<span class="published time" title="%5$s">%1$s%3$s%4$s%2$s</span> ', $atts['before'], $atts['after'], $atts['label'], get_the_time( $atts['format'] ), get_the_time( 'Y-m-d\TH:i:sO' ) );
	return apply_filters( 'calibrefx_post_time_shortcode', $output, $atts );
}
add_shortcode( 'post_time', 'calibrefx_post_time_shortcode' );

/**
 * Produces the author of the post (unlinked display name).
 *
 * Supported shortcode attributes are:
 *   after (output after link, default is empty string),
 *   before (output before link, default is empty string).
 *
 */
function calibrefx_post_author_shortcode( $atts ) {
	$defaults = array(
			'after'  => '',
			'before' => '',
	);
	$atts = shortcode_atts( $defaults, $atts );
	$output = sprintf( '<span class="author vcard">%2$s<span class="fn">%1$s</span>%3$s</span>', esc_html( get_the_author() ), $atts['before'], $atts['after'] );
	return apply_filters( 'calibrefx_post_author_shortcode', $output, $atts );
}
add_shortcode( 'post_author', 'calibrefx_post_author_shortcode' );

/**
 * Produces the author of the post (link to author URL).
 *
 * Supported shortcode attributes are:
 *   after (output after link, default is empty string),
 *   before (output before link, default is empty string).
 *
 */
function calibrefx_post_author_link_shortcode( $atts ) {
	$defaults = array(
			'after'    => '',
			'before'   => '',
	);
	$atts = shortcode_atts( $defaults, $atts );
	$author = get_the_author();
	$author_url = get_the_author_meta( 'url' );

	if ( ! $author ) {
		global $post;
		$author_url = get_the_author_meta( 'url', $post->post_author );
	}
	if ( $author_url ) {
			$author = '<a href="' . $author_url . '" title="' . esc_attr( sprintf( __( 'Visit %s&#8217;s website', 'calibrefx' ), $author ) ) . '" rel="author external">' . $author . '</a>'; }

	$output = sprintf( '<span class="author vcard">%2$s<span class="fn">%1$s</span>%3$s</span>', $author, $atts['before'], $atts['after'] );
	return apply_filters( 'calibrefx_post_author_link_shortcode', $output, $atts );
}
add_shortcode( 'post_author_link', 'calibrefx_post_author_link_shortcode' );

/**
 * Produces the author of the post (link to author archive).
 *
 * Supported shortcode attributes are:
 *   after (output after link, default is empty string),
 *   before (output before link, default is empty string).
 *
 */
function calibrefx_post_author_posts_link_shortcode( $atts ) {
	global $post;

	$defaults = array(
			'after'  => '',
			'before' => '',
	);
	$atts = shortcode_atts( $defaults, $atts );

	$author = get_the_author_meta( 'ID' );
	$author_name = get_the_author();

	if ( ! $author ) {
		global $post;
		$author = $post->post_author;
		$author_name = get_the_author_meta( 'user_nicename', $post->post_author );
	}

	if ( is_custom_post_type( $post ) ) { $author = sprintf( '<span class="fn n">%s</span>', $author_name ); }
	else { $author = sprintf( '<a href="%s" class="fn n" title="%s" rel="author">%s</a>', get_author_posts_url( $author ), $author_name, $author_name ); }

	$output = sprintf( '<span class="author vcard">%2$s<span class="fn">%1$s</span>%3$s</span>', $author, $atts['before'], $atts['after'] );
	return apply_filters( 'calibrefx_post_author_posts_link_shortcode', $output, $atts );
}
add_shortcode( 'post_author_posts_link', 'calibrefx_post_author_posts_link_shortcode' );

/**
 * Produces the link to the current post comments.
 *
 * Supported shortcode attributes are:
 *   after (output after link, default is empty string),
 *   before (output before link, default is empty string),
 *   hide_if_off (hide link if comments are off, default is 'enabled' (true) ),
 *   more (text when there is more than 1 comment, use % character as placeholder
 *     for actual number, default is '% Comments' )
 *   one (text when there is exactly one comment, default is '1 Comment' ),
 *   zero (text when there are no comments, default is 'Leave a Comment' ).
 *
 */
function calibrefx_post_comments_shortcode( $atts ) {
	$defaults = array(
			'after'       => '',
			'before'      => ' &#8226; ',
			'hide_if_off' => 'enabled',
			'more'        => __( '% Comments', 'calibrefx' ),
			'one'         => __( '1 Comment', 'calibrefx' ),
			'zero'        => __( 'Leave a Comment', 'calibrefx' ),
	);

	$is_facebook_comment_enabled = calibrefx_get_option( 'facebook_comments' );
	if ( $is_facebook_comment_enabled ) { return; }

	$atts = shortcode_atts( $defaults, $atts );
	if ( ( ! calibrefx_get_option( 'comments_posts' ) || ! comments_open() ) && 'enabled' === $atts['hide_if_off'] ) {
			return; }

	ob_start();
	comments_number( $atts['zero'], $atts['one'], $atts['more'] );
	$comments = ob_get_clean();
	$comments = sprintf( '<a href="%s">%s</a>', get_comments_link(), $comments );
	$output = sprintf( '<span class="post-comments">%2$s%1$s%3$s</span>', $comments, $atts['before'], $atts['after'] );
	return apply_filters( 'calibrefx_post_comments_shortcode', $output, $atts );
}
add_shortcode( 'post_comments', 'calibrefx_post_comments_shortcode' );

/**
 * Produces the tag links list.
 *
 * Supported shortcode attributes are:
 *   after (output after link, default is empty string),
 *   before (output before link, default is 'Tagged With: ' ),
 *   sep (separator string between tags, default is ', ' ).
 *
 */
function calibrefx_post_tags_shortcode( $atts ) {
	$defaults = array(
			'after'  => '',
			'before' => __( 'Tagged With: ', 'calibrefx' ),
			'sep'    => ', ',
	);
	$atts = shortcode_atts( $defaults, $atts );
	$tags = get_the_tag_list( $atts['before'], trim( $atts['sep'] ) . ' ', $atts['after'] );
	if ( ! $tags ) { return; }
	$output = sprintf( '<span class="tags">%s</span> ', $tags );
	return apply_filters( 'calibrefx_post_tags_shortcode', $output, $atts );
}
add_shortcode( 'post_tags', 'calibrefx_post_tags_shortcode' );

/**
 * Produces the category links list.
 *
 * Supported shortcode attributes are:
 *   after (output after link, default is empty string),
 *   before (output before link, default is 'Tagged With: ' ),
 *   sep (separator string between tags, default is ', ' ).
 *
 */
function calibrefx_post_categories_shortcode( $atts ) {
	$defaults = array(
			'sep'    => ', ',
			'before' => __( 'Filed Under: ', 'calibrefx' ),
			'after'  => '',
	);
	$atts = shortcode_atts( $defaults, $atts );
	$cats = get_the_category_list( trim( $atts['sep'] ) . ' ' );
	$output = sprintf( '<span class="categories">%2$s%1$s%3$s</span> ', $cats, $atts['before'], $atts['after'] );
	return apply_filters( 'calibrefx_post_categories_shortcode', $output, $atts );
}
add_shortcode( 'post_categories', 'calibrefx_post_categories_shortcode' );

/**
 * Produces the linked post taxonomy terms list.
 *
 * Supported shortcode attributes are:
 *   after (output after link, default is empty string),
 *   before (output before link, default is 'Tagged With: ' ),
 *   sep (separator string between tags, default is ', ' ),
 *    taxonomy (name of the taxonomy, default is 'category' ).
 *
 */
function calibrefx_post_terms_shortcode( $atts ) {
	global $post;
	$defaults = array(
		'after'    => '',
		'before'   => __( 'Filed Under: ', 'calibrefx' ),
		'sep'      => ', ',
		'taxonomy' => 'category',
	);
	$atts = shortcode_atts( $defaults, $atts );
	$terms = get_the_term_list( $post->ID, $atts['taxonomy'], $atts['before'], trim( $atts['sep'] ) . ' ', $atts['after'] );
	if ( is_wp_error( $terms ) ) { return false; }
	if ( empty( $terms ) ) {  return false; }
	$output = '<span class="terms">' . $terms . '</span>';
	return apply_filters( 'calibrefx_post_terms_shortcode', $output, $terms, $atts );
}
add_shortcode( 'post_terms', 'calibrefx_post_terms_shortcode' );

/**
 * Produces the edit post link for logged in users.
 *
 * Supported shortcode attributes are:
 *   after (output after link, default is empty string),
 *   before (output before link, default is 'Tagged With: ' ),
 *   link (link text, default is '(Edit)' ).
 */
function calibrefx_post_edit_shortcode( $atts ) {
	if ( ! apply_filters( 'calibrefx_edit_post_link', true ) ) { return; }
	$defaults = array(
		'after'  => '',
		'before' => '',
		'link'   => __( '(Edit)', 'calibrefx' ),
	);
	$atts = shortcode_atts( $defaults, $atts );
	ob_start();
	edit_post_link( $atts['link'], $atts['before'], $atts['after'] );
	$edit = ob_get_clean();
	$output = $edit;
	return apply_filters( 'calibrefx_post_edit_shortcode', $output, $atts );
}
add_shortcode( 'post_edit', 'calibrefx_post_edit_shortcode' );

/**
 * ==============================================================
 * Contact Form
 * ==============================================================
 */

//@TODO: Form submit handler for this is removed, need to work on something
function calibrefx_contact_form( $atts, $content = null ) {
	global $calibrefx, $post;
	extract( shortcode_atts( array(
				'target' => '',
				'redirect' => ''
			), $atts ) );

	if ( empty( $target ) ) { $target = 'ADMIN_EMAIL'; }
	if ( empty( $redirect ) ) { $redirect = get_permalink( $post->ID ); }

	//General Settings
	$rows = array();

	$rows[] = array(
		'id' => 'name',
		'label' => __( 'Name','calibrefx' ),
		'desc' => __( 'Fill with your name','calibrefx' ),
		'tooltip' => __( 'Your name','calibrefx' ),
		'content' => $calibrefx->form->textinput( 'name', '', 'required' ),
	);

	$rows[] = array(
		'id' => 'email',
		'label' => __( 'Email','calibrefx' ),
		'desc' => __( 'Fill with your email','calibrefx' ),
		'tooltip' => __( 'Your email','calibrefx' ),
		'content' => $calibrefx->form->textinput( 'email', '', 'required email' ),
	);

	$rows[] = array(
		'id' => 'subject',
		'label' => __( 'Subject','calibrefx' ),
		'desc' => __( 'Your subject','calibrefx' ),
		'tooltip' => __( 'Your subject','calibrefx' ),
		'content' => $calibrefx->form->textinput( 'subject', '', 'required' ),
	);

	$rows[] = array(
		'id' => 'message',
		'label' => __( 'Message','calibrefx' ),
		'desc' => __( 'Your message','calibrefx' ),
		'tooltip' => __( 'Your message','calibrefx' ),
		'content' => $calibrefx->form->textarea( 'message', '', 'required' ),
	);

	$rows[] = array(
		'id' => 'action',
		'label' => '',
		'desc' => '',
		'tooltip' => '',
		'content' => $calibrefx->form->hidden( 'action', 'contact-form' ),
	);

	$rows[] = array(
		'id' => 'target',
		'label' => '',
		'desc' => '',
		'tooltip' => '',
		'content' => $calibrefx->form->hidden( 'target', $target ),
	);

	$rows[] = array(
		'id' => 'redirect',
		'label' => '',
		'desc' => '',
		'tooltip' => '',
		'content' => $calibrefx->form->hidden( 'redirect', $redirect ),
	);

	$rows[] = array(
		'id' => 'submit',
		'label' => '',
		'desc' => '',
		'tooltip' => '',
		'content' => $calibrefx->form->save_button( 'Submit', 'Send' ),
	);

	return $calibrefx->form->open( 'calibrefx_contact_form', get_permalink( $post->ID ), 'post', false )->build( $rows );
}
add_shortcode( 'contactform', 'calibrefx_contact_form' );


/**
 * ==============================================================
 * Footer Area
 * ==============================================================
 */

/**
 * This function produces the "Return to Top" link
 *
 * @param array $atts Shortcode attributes
 * @return string
 */
function calibrefx_footer_scrolltop_shortcode( $atts ) {

	$defaults = array(
		'text' => __( 'Return To Top', 'calibrefx' ),
		'href' => '#wrapper',
		'nofollow' => true,
		'before' => '',
		'after' => ''
	);
	$atts = shortcode_atts( $defaults, $atts );

	$nofollow = $atts['nofollow'] ? 'rel="nofollow"' : '';

	$output = sprintf( '%s<a href="%s" %s><i class="fa fa-chevron-circle-up"></i> %s</a>%s', $atts['before'], esc_url( $atts['href'] ), $nofollow, $atts['text'], $atts['after'] );

	return apply_filters( 'calibrefx_footer_scrolltop_shortcode', $output, $atts );
}
add_shortcode( 'footer_scrolltop', 'calibrefx_footer_scrolltop_shortcode' );


/**
 * Show Footer Copyright Text
 *
 * @param array $atts Shortcode attributes
 * @return string
 */
function calibrefx_footer_copyright_shortcode( $atts ) {
	$defaults = array(
		'copyright' => '&copy;',
		'first' => '',
		'before' => '',
		'after' => ''
	);
	$atts = shortcode_atts( $defaults, $atts );

	$output = $atts['before'] . $atts['copyright'];
	if ( '' != $atts['first'] && date( 'Y' ) != $atts['first'] ) {
		$output .= $atts['first'] . g_ent( '&ndash;' ); }
	$output .= ' ' . date( 'Y' ) . $atts['after'];

	return apply_filters( 'calibrefx_footer_copyright_shortcode', $output, $atts );
}
add_shortcode( 'footer_copyright', 'calibrefx_footer_copyright_shortcode' );


/**
 * Show Footer Theme Name and Link
 *
 * @param array $atts Shortcode attributes
 * @return string
 */
function calibrefx_footer_theme_link_shortcode( $atts ) {

	$defaults = array(
		'before' => '&middot; ',
		'after' => ''
	);
	$atts = shortcode_atts( $defaults, $atts );

	if ( ! is_child_theme() || ! defined( 'CHILD_THEME_NAME' ) || ! defined( 'CHILD_THEME_URL' ) ) {
		return; }

	$output = sprintf( '%s<a href="%s" title="%s">%s</a>%s', $atts['before'], esc_url( CHILD_THEME_URL ), esc_attr( CHILD_THEME_NAME ), esc_html( CHILD_THEME_NAME ), $atts['after'] );

	return apply_filters( 'calibrefx_footer_theme_link_shortcode', $output, $atts );
}
add_shortcode( 'footer_theme_link', 'calibrefx_footer_theme_link_shortcode' );


/**
 * Show Footer CalibreFx Links
 *
 * @param array $atts Shortcode attributes
 * @return string
 */
function calibrefx_footer_calibrefx_link_shortcode( $atts ) {

	$defaults = array(
		'before' => '',
		'after' => ' &middot;'
	);
	$atts = shortcode_atts( $defaults, $atts );

	$output = sprintf( '%s<a href="%s" title="%s">%s</a>%s', $atts['before'], esc_url( FRAMEWORK_URL ), esc_attr( FRAMEWORK_NAME ), esc_html( FRAMEWORK_NAME ), $atts['after'] );

	return apply_filters( 'calibrefx_footer_calibrefx_link_shortcode', $output, $atts );
}
add_shortcode( 'footer_calibrefx_link', 'calibrefx_footer_calibrefx_link_shortcode' );


/**
 * Show Footer WordPress links
 *
 * @param array $atts Shortcode attributes
 * @return string
 */
function calibrefx_footer_wordpress_link_shortcode( $atts ) {

	$defaults = array(
		'before' => '',
		'after' => ' &middot;'
	);
	$atts = shortcode_atts( $defaults, $atts );

	$output = sprintf( '%s<a href="%s" title="%s">%s</a>%s', $atts['before'], esc_url( 'http://wordpress.org/' ), esc_attr( 'WordPress' ), esc_html( 'WordPress' ), $atts['after'] );

	return apply_filters( 'calibrefx_footer_wordpress_link_shortcode', $output, $atts );
}
add_shortcode( 'footer_wordpress_link', 'calibrefx_footer_wordpress_link_shortcode' );


/**
 * Show Footer Home Name and Link
 *
 * @param array $atts Shortcode attributes
 * @return string
 */
function calibrefx_footer_home_link_shortcode( $atts ) {

	$defaults = array(
		'before' => '&middot; ',
		'after' => ''
	);
	$atts = shortcode_atts( $defaults, $atts );

	$output = sprintf( '%s<a href="%s" title="%s">%s</a>%s', $atts['before'], esc_url( home_url() ), esc_attr( get_bloginfo() ), esc_html( get_bloginfo() ), $atts['after'] );

	return apply_filters( 'calibrefx_footer_home_link_shortcode', $output, $atts );
}
add_shortcode( 'footer_home_link', 'calibrefx_footer_home_link_shortcode' );