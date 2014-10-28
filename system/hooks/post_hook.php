<?php 
/**
 * Calibrefx Post Hooks
 *
 */

$calibrefx->hooks->calibrefx_before_content_wrapper = array(
	array( 'function' => 'calibrefx_do_inner_wrap_open', 'priority' => 5 )
);

$calibrefx->hooks->calibrefx_before_loop = array(
	array( 'function' => 'calibrefx_do_breadcrumbs', 'priority' => 10 ),
	array( 'function' => 'calibrefx_do_notification', 'priority' => 20 ),
);

$calibrefx->hooks->calibrefx_loop = array(
		array( 'function' => 'calibrefx_do_loop', 'priority' => 10 )
	);

	//This is inside the loop: calibrefx_do_loop

	//This is inside content.php
	$calibrefx->hooks->calibrefx_before_post_title = array();
	$calibrefx->hooks->calibrefx_post_title = array(
			array( 'function' => 'calibrefx_do_post_title', 'priority' => 10)
		);
	$calibrefx->hooks->calibrefx_after_post_title = array();

	$calibrefx->hooks->calibrefx_before_post_content = array(
			array( 'function' => 'calibrefx_post_info', 'priority' => 10)
		);

	$calibrefx->hooks->calibrefx_post_content = array(
		array( 'function' => 'calibrefx_do_post_image', 'priority' => 10), 
		array( 'function' => 'calibrefx_do_post_content', 'priority' => 15)
	);

	$calibrefx->hooks->calibrefx_after_post_content = array(
		array( 'function' => 'calibrefx_post_meta', 'priority' => 10)
	);
	
	//End of content.php
	
	$calibrefx->hooks->calibrefx_after_post_content = array(
		array( 'function' => 'calibrefx_do_author_box_single', 'priority' => 20)
	);
	//Loop End here

$calibrefx->hooks->calibrefx_after_loop = array(
	array( 'function' => 'calibrefx_posts_nav','priority' => 20)
);

$calibrefx->hooks->calibrefx_after_content_wrapper = array(
	array( 'function' => 'calibrefx_do_inner_wrap_close','priority' => 15)
);

/********************
 * FUNCTIONS BELOW  *
 ********************/

/**
 * Display Breadcrumbs before the Loop
 */
function calibrefx_do_breadcrumbs() {
	// Conditional Checks
	if ( ( is_front_page() || is_home() ) && !calibrefx_get_option( 'breadcrumb_home' ) )
		return;
	if ( is_single() && !calibrefx_get_option( 'breadcrumb_single' ) )
		return;
	if ( is_page() && !calibrefx_get_option( 'breadcrumb_page' ) )
		return;
	if ( ( is_archive() || is_search() ) && !calibrefx_get_option( 'breadcrumb_archive' ) )
		return;
	if ( is_404() && !calibrefx_get_option( 'breadcrumb_404' ) )
		return;

	calibrefx_breadcrumb();
}

/**
 * Display Flash notification when user do submit form
 */
function calibrefx_do_notification() {
	global $calibrefx;

	$calibrefx->notification->show_flashmessage();
}

/**
 * Add wrapper after .inner
 */
function calibrefx_do_inner_wrap_open() {
	calibrefx_put_wrapper( 'inner', 'open' );
}

/**
 * Add close wrapper before .inner close
 */
function calibrefx_do_inner_wrap_close() {
	calibrefx_put_wrapper( 'inner', 'close' );
}

/**
 * Do content loop and display
 *
 */
function calibrefx_do_loop() {
	//Provide space to override the default loop
	calibrefx_default_loop();
}

/**
 * calibrefx_do_post_title callback
 *
 * It outputs the post title
 *
 */
function calibrefx_do_post_title() {
	$title = get_the_title();

	if ( strlen( $title ) == 0 ) {
		return;
	}

	if ( is_singular() ) {
		$title = sprintf( '<h1 class="entry-title">%s</h1>', apply_filters( 'calibrefx_post_title_text', $title) );
	} else {
		$title = sprintf( '<h2 class="entry-title"><a href="%s" title="%s" rel="bookmark">%s</a></h2>', get_permalink(), the_title_attribute( 'echo=0' ), apply_filters( 'calibrefx_post_title_text', $title) );
	}

	echo apply_filters( 'calibrefx_post_title_output', $title ) . "\n";
}

/**
 * Echo the post info before the post content.
 *
 * Use several content shortcode, refered to shortcodes/content.php
 *
 */
function calibrefx_post_info() {
	global $post;

	$post_date = '';
	if( calibrefx_get_option( 'post_date' ) ){
		$post_date = '[post_date]';
	}

	$post_author = '';
	if( calibrefx_get_option( 'post_author' ) ){
		$post_author = __( 'By', 'calibrefx' ) . ' [post_author_posts_link]';
	}

	$post_comment = '';
	if( calibrefx_get_option( 'post_comment' ) ){
		$post_comment = ' [post_comments]';
	}

	$post_info = "$post_date $post_author $post_comment [post_edit]";
	printf( '<div class="post-info">%s</div>', apply_filters( 'calibrefx_post_info', $post_info ) );
}
add_filter( 'calibrefx_post_info', 'do_shortcode', 20 );

/**
 * Echo the post meta after the post content. Will not show in page.
 *
 * Use several content shortcode, refered to shortcodes/content.php
 */
function calibrefx_post_meta() {
	global $post;

	if ( is_page( $post->ID) ) {
		return;
	}

	$post_category = '';
	if( calibrefx_get_option( 'post_category' ) ){
		$post_category = '[post_categories]';
	}

	$post_tags = '';
	if( calibrefx_get_option( 'post_tags' ) ){
		$post_tags = '[post_tags]';
	}	

	$post_meta = "$post_category $post_tags";
	printf( '<div class="post-meta">%s</div>', apply_filters( 'calibrefx_post_meta', $post_meta ) );
}
add_filter( 'calibrefx_post_meta', 'do_shortcode', 20 );

/**
 * Post Image
 */
function calibrefx_do_post_image() {
	if ( !is_singular() ) { // This is an archive page
		$default_post_archive_image_size = apply_filters( 'post_archive_image_size', 'thumbnail' );
		$img = calibrefx_get_image( array( 'format' => 'html', 'size' => $default_post_archive_image_size, 'attr' => array( 'class' => 'alignleft post-image' ) ) );
		
		if( $img ) {
			printf( '<a href="%s" title="%s" class="post-image-link">%s</a>', get_permalink(), the_title_attribute( 'echo=0' ), apply_filters( 'post_archive_image', $img, $img ) );
		}
		
	} else {
		$default_post_single_image_size = apply_filters( 'post_single_image_size', 'full' );
		$img = calibrefx_get_image( array( 'format' => 'html', 'size' => $default_post_single_image_size, 'attr' => array( 'class' => 'alignnone post-image' ) ) );
		
		if ( $img ) {
			printf( '<p class="post-featured-image">%s</p>', apply_filters( 'post_single_image', $img, $img ) );
		}
	}
}

/**
 * calibrefx_do_post_content callback
 *
 * It outputs the post content
 *
 */
function calibrefx_do_post_content() {
	if ( is_singular() ) {
		the_content(); // display content on posts/pages

		if ( is_single() && get_option( 'default_ping_status' ) == 'open' ) {
			echo '<!--';
			trackback_rdf();
			echo '-->' . "\n";
		}

		if ( is_page() ) {
			edit_post_link(__( '(Edit)', 'calibrefx' ), '', '' );
		}
	} elseif ( 'excerpts' == calibrefx_get_option( 'content_archive' ) ) {
		the_excerpt();
	} else {
		if ( calibrefx_get_option( 'content_archive_limit' ) ) {
			$read_more_text = apply_filters( 'calibrefx_readmore_text', __( '[Read more...]', 'calibrefx' ) );
			the_content_limit( (int) calibrefx_get_option( 'content_archive_limit' ), $read_more_text );
		} else {
			the_content();
		}
	}

	wp_link_pages( array( 'before' => '<p class="pages">' . __( 'Pages:', 'calibrefx' ), 'after' => '</p>' ) );
}

/**
 * Conditionally adds the author box after single posts or pages.
 *
 */
function calibrefx_do_author_box_single() {
	if ( ! is_single() ) {
		return;
	}

	if ( get_the_author_meta( 'calibrefx_author_box_single', get_the_author_meta( 'ID' ) ) ) {
		calibrefx_author_box( 'single' );
	}
}

/**
 * Outputs the no post text.
 */
function calibrefx_do_no_post() {
	printf( '<p>%s</p>', apply_filters( 'calibrefx_noposts_text', __( 'Sorry, no posts matched your criteria.', 'calibrefx' ) ));
}
add_action( 'calibrefx_no_post', 'calibrefx_do_no_post' );

/**
 * Display Post Navigation
 */
function calibrefx_posts_nav() {
	$nav = calibrefx_get_option( 'posts_nav' );

	switch ( $nav ) {
		case 'disabled':
			//do nothing
			break;
		case 'numeric':
			calibrefx_numeric_posts_nav();
			break;
		case 'prev-next':
			calibrefx_prev_next_posts_nav();
			break;
		case 'older-newer':
		default:
			calibrefx_older_newer_posts_nav();
			break;
	}
}

/**
 * Disable Self-Pingbacks
 */
function calibrefx_no_self_ping ( $links ) {
	$home =  home_url() ;

	foreach ( $links as $l => $link ) :
		//Find the position of the first occurrence of a substring in a string.
		//( $a === $b) Identical operator. TRUE if $a is equal to $b, and they are of the same type.
		if ( 0 === strpos( $link, $home ) ) :
			//Unset the variable
			unset( $links[$l]);
		endif;
	endforeach;
}
add_action( 'pre_ping', 'calibrefx_no_self_ping' );

function add_featured_image_to_feed( $content ) {
	global $post;
  
	if ( has_post_thumbnail( $post->ID ) ) {
		$content = '' . get_the_post_thumbnail( $post->ID, 'post-thumbnail-image' ) . '' . $content;
	}
	return $content;
}
add_filter( 'the_excerpt_rss', 'add_featured_image_to_feed', 1000, 1 );
add_filter( 'the_content_feed', 'add_featured_image_to_feed', 1000, 1 );