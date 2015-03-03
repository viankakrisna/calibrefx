<?php
/**
 * Calibrefx Post Helper
 *
 */

/**
 * Helper function used to check that we're targeting a specific Calibrefx admin page.
 *
 */
function calibrefx_is_menu_page( $pagehook = '' ) {
	global $page_hook;

	if ( isset( $page_hook ) && $page_hook == $pagehook ){
		return true;
	}

	if ( isset( $_REQUEST['page'] ) && $_REQUEST['page'] == $pagehook ) {
		return true;
	}

	return false;
}

/**
 * Helper function used to get all post meta based on the post ID given.
 */
function calibrefx_get_post_meta_all( $post_id ) {
	global $wpdb;
	$data = array();
	$wpdb->query("
        SELECT `meta_key`, `meta_value`
        FROM $wpdb->postmeta
        WHERE `post_id` = $post_id"
	);

	foreach ( $wpdb->last_result as $k => $v ) {
		$data[$v->meta_key] = $v->meta_value;
	};

	return $data;
}

/**
 * Helper function used to get post meta based on the post ID and the meta Key
 */
function calibrefx_get_custom_post_meta( $post_id, $meta_key ) {
	global $wpdb;

	$result = $wpdb->get_row("
        SELECT `meta_value`
        FROM $wpdb->postmeta
        WHERE `post_id` = $post_id and `meta_key` = '$meta_key'"
	);

	return $result->meta_value;
}

/**
 * Helper function for to display Calibrefx BreadCrumb
 *
 */
function calibrefx_breadcrumb( $args = array() ) {
	global $calibrefx;

	$calibrefx->breadcrumb->output( $args );
}

/**
 * CalibreFx default loop
 *
 * It outputs basic wrapping HTML, but uses hooks to do most of its
 * content output like Title, Content, Post information, and Comments.
 *
 */
function calibrefx_default_loop() {
	if ( have_posts() ) :
		while ( have_posts() ) : the_post(); // the loop
			get_template_part( 'content', get_post_format() );
		endwhile;
	else :
		/** if no posts exist * */
		do_action( 'calibrefx_no_post' );
	endif;
	/** end loop * */
}

/**
 * Echoes post navigation in Older Posts / Newer Posts format.
 */
function calibrefx_older_newer_posts_nav() {

	$older_link = get_next_posts_link( apply_filters( 'calibrefx_older_link_text', '&larr; ' . __( 'Older Posts', 'calibrefx' ) ) );
	$newer_link = get_previous_posts_link( apply_filters( 'calibrefx_newer_link_text', __( 'Newer Posts', 'calibrefx' ) . ' &rarr;' ) );

	$older = $older_link ? '<li class="previous">' . $older_link . '</li>' : '';
	$newer = $newer_link ? '<li class="next">' . $newer_link . '</li>' : '';

	$pagination_class = apply_filters( 'calibrefx_older_newer_pagination_class', '' );
	$pagination_container_class = apply_filters( 'calibrefx_older_newer_pagination_container_class', '' );

	$nav = '<div class="pagination-container older-newer-pager '.$pagination_container_class.'"><ul class="pager '.$pagination_class.'">' . $older . $newer . '</ul></div>';

	if ( $older || $newer ) {
		echo $nav;
	}
}

/**
 * Echoes post navigation in Previous Posts / Next Posts format.
 *
 */
function calibrefx_prev_next_posts_nav() {

	$prev_link = get_previous_posts_link( apply_filters( 'calibrefx_prev_link_text', '&larr; ' . __( 'Previous Page', 'calibrefx' ) ) );
	$next_link = get_next_posts_link( apply_filters( 'calibrefx_next_link_text', __( 'Next Page', 'calibrefx' ) . ' &rarr;' ) );

	$prev = $prev_link ? '<li class="previous">' . $prev_link . '</li>' : '';
	$next = $next_link ? '<li class="next">' . $next_link . '</li>' : '';

	$pagination_class = apply_filters( 'calibrefx_prev_next_pagination_class', '' );
	$pagination_container_class = apply_filters( 'calibrefx_prev_next_pagination_container_class', '' );

	$nav = '<div class="pagination-container prev-next-pager '.$pagination_container_class.'"><ul class="pager '.$pagination_class.'">' . $prev . $next . '</ul></div>';

	if ( $prev || $next ) {
		echo $nav;
	}
}

/**
 * Echoes post navigation in page numbers format (similar to WP-PageNavi).
 *
 * The links, if needed, are ordered as:
 *   previous page arrow,
 *   first page,
 *   up to two pages before current page,
 *   current page,
 *   up to two pages after the current page,
 *   last page,
 *   next page arrow.
 */
function calibrefx_numeric_posts_nav($max = null, $echo = true) {

	if ( is_singular() && ! $max ) {
		return;
	}

	if ( ! $max ){
		global $wp_query;
		$max = intval( $wp_query->max_num_pages );
	}else {
		$max = intval( $max );
	}

	/** Stop execution if there's only 1 page */
	if ( $max <= 1 ) {
		return;
	}

	$paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;

	/** Add current page to the array */
	if ( $paged >= 1 ) {
		$links[] = $paged;
	}

	/** Add the pages around the current page to the array */
	if ( $paged >= 3 ) {
		$links[] = $paged - 1;
		$links[] = $paged - 2;
	}

	if ( ( $paged + 2 ) <= $max ) {
		$links[] = $paged + 2;
		$links[] = $paged + 1;
	}

	$pagination_class = apply_filters( 'calibrefx_numeric_pagination_class', 'pagination-right' );
	$pagination_container_class = apply_filters( 'calibrefx_numeric_pagination_container_class', '' );

	$output = '';
	$output .= '<div class="pagination-container paginantion-numeric '.$pagination_container_class.'"><ul class="pagination '.$pagination_class.'">' . "\n";

	/** Previous Post Link */
	if ( get_previous_posts_link() ) {
		$output .= sprintf( '<li class="previous">%s</li>' . "\n", get_previous_posts_link( apply_filters( 'calibrefx_prev_link_text', '&laquo; ' . __( 'Previous Page', 'calibrefx' ) ) ) );
	}

	/** Link to first page, plus ellipses if necessary */
	if ( ! in_array( 1, $links ) ) {
		$class = 1 == $paged ? ' class="active"' : '';

		$output .= sprintf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, get_pagenum_link( 1 ), '1' );

		if ( ! in_array( 2, $links ) ) {
			$output .= '<li class="disabled"><span class="hellip">&hellip;</span></li>';
		}
	}

	/** Link to current page, plus 2 pages in either direction if necessary */
	sort( $links );

	foreach ( (array) $links as $link ) {
		$class = $paged == $link ? ' class="active"' : '';
		$output .= sprintf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, get_pagenum_link( $link ), $link );
	}

	/** Link to last page, plus ellipses if necessary */
	if ( ! in_array( $max, $links ) ) {
		if ( ! in_array( $max - 1, $links ) ) {
			$output .= '<li class="disabled"><span class="hellip">&hellip;</span></li>' . "\n";
		}

		$class = $paged == $max ? ' class="active"' : '';

		$output .= sprintf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, get_pagenum_link( $max ), $max );
	}

	/** Next Post Link */
	if ( get_next_posts_link() ) {
		$output .= sprintf( '<li class="next">%s</li>' . "\n", get_next_posts_link( apply_filters( 'calibrefx_next_link_text', __( 'Next Page', 'calibrefx' ) . ' &raquo;' ) ) );
	}

	$output .= '</ul></div>' . "\n";

	if ( $echo ){
		echo $output;
	}else {
		return $output;
	}
}

/**
 * Display links to previous - next post.
 *
 * @return null Returns early if not a post
 */
function calibrefx_prev_next_post_nav() {
	if ( ! is_singular( 'post' ) ) {
		return;
	}
	?>
    <div class="navigation">
        <div class="alignleft"><?php previous_post_link(); ?></div>
        <div class="alignright"><?php next_post_link(); ?></div>
    </div>
    <?php
}

/**
 * Examine a url and try to determine the post ID it represents.
 *
 * Checks are supposedly from the hosted site blog.
 * Taken from the url_to_postid but not only for built in post type
 *
 * @since 1.0.9
 *
 * @param string $url Permalink to check.
 * @return int Post ID, or 0 on failure.
 */
function calibrefx_url_to_postid( $url) {
	global $wp_rewrite;

	$url = apply_filters( 'url_to_postid', $url );

	// First, check to see if there is a 'p=N' or 'page_id=N' to match against
	if ( preg_match( '#[?&](p|page_id|attachment_id)=(\d+)#', $url, $values ) ) {
		$id = absint( $values[2] );
		if ( $id ) {
			return $id;
		}
	}

	// Check to see if we are using rewrite rules
	$rewrite = $wp_rewrite->wp_rewrite_rules();

	// Not using rewrite rules, and 'p=N' and 'page_id=N' methods failed, so we're out of options
	if ( empty( $rewrite ) ) {
		return 0;
	}

	// Get rid of the #anchor
	$url_split = explode( '#', $url );
	$url = $url_split[0];

	// Get rid of URL ?query=string
	$url_split = explode( '?', $url );
	$url = $url_split[0];

	// Add 'www.' if it is absent and should be there
	if ( false !== strpos( home_url(), '://www.' ) && false === strpos( $url, '://www.' ) ) {
		$url = str_replace( '://', '://www.', $url );
	}

	// Strip 'www.' if it is present and shouldn't be
	if ( false === strpos( home_url(), '://www.' ) ) {
		$url = str_replace( '://www.', '://', $url );
	}

	// Strip 'index.php/' if we're not using path info permalinks
	if ( ! $wp_rewrite->using_index_permalinks() ) {
		$url = str_replace( 'index.php/', '', $url );
	}

	if ( false !== strpos( $url, home_url() ) ) {
		// Chop off http://domain.com
		$url = str_replace( home_url(), '', $url );
	} else {
		// Chop off /path/to/blog
		$home_path = parse_url( home_url() );
		$home_path = isset( $home_path['path'] ) ? $home_path['path'] : '' ;
		$url = str_replace( $home_path, '', $url );
	}

	// Trim leading and lagging slashes
	$url = trim( $url, '/' );

	$request = $url;

	// Look for matches.
	$request_match = $request;

	foreach ( (array)$rewrite as $match => $query ) {
		// If the requesting file is the anchor of the match, prepend it
		// to the path info.
		if ( ! empty( $url) && ( $url != $request ) && (strpos( $match, $url ) === 0 ) ) {
			$request_match = $url . '/' . $request;
		}

		if ( preg_match( "!^$match!", $request_match, $matches ) ) {
				// Got a match.
				// Trim the query of everything up to the '?'.
				$query = preg_replace( '!^.+\?!', '', $query );

				// Substitute the substring matches into the query.
				$query = addslashes( WP_MatchesMapRegex::apply( $query, $matches ) );

				// Filter out non-public query vars
				global $wp;
				parse_str( $query, $query_vars );
				$query = array();
			foreach ( (array) $query_vars as $key => $value ) {
				if ( in_array( $key, $wp->public_query_vars ) ) {
					$query[$key] = $value;
				}
			}

			// Taken from class-wp.php
			foreach ( $GLOBALS['wp_post_types'] as $post_type => $t ) {
				if ( $t->query_var ) {
					$post_type_query_vars[$t->query_var] = $post_type;
				}
			}

			foreach ( $wp->public_query_vars as $wpvar ) {
				if ( isset( $wp->extra_query_vars[$wpvar] ) ) {
					$query[$wpvar] = $wp->extra_query_vars[$wpvar];
				} elseif ( isset( $_POST[$wpvar] ) ) {
					$query[$wpvar] = $_POST[$wpvar];
				} elseif ( isset( $_GET[$wpvar] ) ) {
					$query[$wpvar] = $_GET[$wpvar];
				} elseif ( isset( $query_vars[$wpvar] ) ) {
					$query[$wpvar] = $query_vars[$wpvar];
				}

				if ( ! empty( $query[$wpvar] ) ) {
					if ( ! is_array( $query[$wpvar] ) ) {
						$query[$wpvar] = (string) $query[$wpvar];
					} else {
						foreach ( $query[$wpvar] as $vkey => $v ) {
							if ( ! is_object( $v ) ) {
								$query[$wpvar][$vkey] = (string) $v;
							}
						}
					}

					if ( isset( $post_type_query_vars[$wpvar] ) ) {
						$query['post_type'] = $post_type_query_vars[$wpvar];
						$query['name'] = $query[$wpvar];
					}
				}
			}

			// Do the query
			$query = new WP_Query( $query );

			if ( ! empty( $query->posts) && $query->is_singular ) {
				return $query->post->ID;
			} else {
				return 0;
			}
		}
	}
	return 0;
}

function calibrefx_get_post_types() {
	$args = array(
	  'public'   => true,
	  '_builtin' => false
	);
	$output = 'names'; // names or objects, note names is the default
	$operator = 'and'; // 'and' or 'or'
	$post_types = get_post_types( $args,$output,$operator );
	return $post_types;
}

function is_custom_post_type( $post ) {
	$all_custom_post_types = calibrefx_get_post_types();

	// there are no custom post types
	if ( empty ( $all_custom_post_types ) ) {
		return false;
	}

	$custom_types      = array_keys( $all_custom_post_types );
	$current_post_type = get_post_type( $post );

	// could not detect current type
	if ( ! $current_post_type ) {
		return false;
	}

	return in_array( $current_post_type, $custom_types );
}