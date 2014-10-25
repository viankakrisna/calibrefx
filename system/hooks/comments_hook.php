<?php 
/**
 * Calibrefx Comments Hooks
 *
 */


/**
 * Output the comments at the end of posts / pages.
 *
 * Load comments only if we are on a page or post and only if comments or
 * trackbacks are enabled.
 *
 */
function calibrefx_get_comments_template() {
    $is_facebook_comment_enabled = calibrefx_get_option( 'facebook_comments' );

    $comment_box_title = apply_filters( 'calibrefx_comment_box_title',  __( 'Leave us your thought', 'calibrefx' ) );

    if ( !$is_facebook_comment_enabled ) {
        if ( is_single() && ( calibrefx_get_option( 'trackbacks_posts' ) || calibrefx_get_option( 'comments_posts' ) ) ) {
            comments_template( '', true );
        } elseif ( is_page() && ( calibrefx_get_option( 'trackbacks_pages' ) || calibrefx_get_option( 'comments_pages' ) ) ) {
            comments_template( '', true );
        }
    } else {
        if ( ( is_page() && calibrefx_get_option( 'comments_pages' ) ) || ( is_single() && calibrefx_get_option( 'comments_posts' ) ) ) {
            echo '<div id="comments">';
            echo '<h3 id="reply-title">' . $comment_box_title . '</h3>';

            echo do_shortcode( '[facebook_comment]' );

            echo '</div>';
        }
    }
}
add_action( 'calibrefx_after_post_content', 'calibrefx_get_comments_template', 30 );

/**
 * Output comment structure.
 *
 * @uses calibrefx_get_option()
 *
 */
function calibrefx_do_comments() {
    global $post, $wp_query;

    /** Bail if comments are off for this post type */
    if ( ( is_page() && !calibrefx_get_option( 'comments_pages' ) ) || ( is_single() && ! calibrefx_get_option( 'comments_posts' ) ) ) {
        return;
    }

    if ( have_comments() && !empty( $wp_query->comments_by_type['comment'] ) ) { ?>
        <div id="comments">
                <?php echo apply_filters( 'calibrefx_title_comments', __( '<h3>Comments</h3>', 'calibrefx' ) ); ?>
                <ol class="comment-list">
                        <?php do_action( 'calibrefx_list_comments' ); ?>
                </ol>
                <div class="comment-navigation">
                    <ul class="pager">
                        <li class="previous"><?php previous_comments_link() ?></li>
                        <li class="next"><?php next_comments_link() ?></li>
                    </ul>
                </div>
        </div><!--end #comments-->
        <?php
    } else {
        echo '<div id="comments" class="no-comments">';
        if ( 'open' == $post->comment_status ) {
            echo apply_filters( 'calibrefx_no_comments_text', '' );
        } else {
            echo apply_filters( 'calibrefx_comments_closed_text', '' );
        }
        echo '</div><!--end #comments-->';
    }
}
add_action( 'calibrefx_comments', 'calibrefx_do_comments' );

/**
 * Output trackback structure.
 *
 * @uses calibrefx_get_option()
 *
 */
function calibrefx_do_pings() {
    global $post, $wp_query;

    if ( ( is_page() && ! calibrefx_get_option( 'trackbacks_pages' ) ) || ( is_single() && ! calibrefx_get_option( 'trackbacks_posts' ) ) ) {
        return;
    }

    if ( have_comments() && !empty( $wp_query->comments_by_type['pings'] ) ) {
    ?>
        <div id="pings">
                <?php echo apply_filters( 'calibrefx_title_pings', __( '<h3>Trackbacks</h3>', 'calibrefx' ) ); ?>
                <ol class="ping-list">
                    <?php do_action( 'calibrefx_list_pings' ); ?>
                </ol>
        </div><!-- end #pings -->
        <?php
    } else {
        echo apply_filters( 'calibrefx_no_pings_text', '' );
    }
}
add_action( 'calibrefx_pings', 'calibrefx_do_pings' );

/**
 * Outputs the comment list to the <code>calibrefx_comment_list()</code> hook.
 */
function calibrefx_default_list_comments() {
    $args = array(
            'type'          => 'comment',
            'avatar_size'   => 48,
            'callback'      => 'calibrefx_comment_callback',
    );
    $args = apply_filters( 'calibrefx_comment_list_args', $args );
    wp_list_comments( $args );
}
add_action( 'calibrefx_list_comments', 'calibrefx_default_list_comments' );

/**
 * Outputs the ping list to the <code>calibrefx_ping_list()</code> hook.
 *
 */
function calibrefx_default_list_pings() {
    $args = array( 'type' => 'pings', );
    $args = apply_filters( 'calibrefx_ping_list_args', $args );
    wp_list_comments( $args );
}
add_action( 'calibrefx_list_pings', 'calibrefx_default_list_pings' );

/**
 * Defines the comment form, hooked to <code>calibrefx_comment_form()</code>
 *
 */
function calibrefx_do_comment_form() {

    /** Bail if comments are closed for this post type */
    if ( ( is_page() && ! calibrefx_get_option( 'comments_pages' ) ) || ( is_single() && ! calibrefx_get_option( 'comments_posts' ) ) )
        return;

    comment_form();
}
add_action( 'calibrefx_comment_form', 'calibrefx_do_comment_form' );

/**
 * Filters the default comment form arguments, used by <code>comment_form()</code>
 *
 */
function calibrefx_comment_form_args( $defaults ) {

    global $user_identity, $id;

    $commenter = wp_get_current_commenter();
    $req       = get_option( 'require_name_email' );
    $aria_req  = ( $req ? ' aria-required="true"' : '' );

    $author = '<div class="form-group comment-form-author">' .
              '<label for="author" class="comment-form-label">'.__( 'Your Name (required)','calibrefx' ).'</label>' .
              '<input id="author" name="author" type="text" class="form-control required" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" tabindex="1"' . $aria_req . ' />' .
              '</div><!-- #form-section-author .form-section -->';

    $email = '<div class="form-group comment-form-email">' .
             '<label for="email" class="comment-form-label">'.__( 'Your Email (required)','calibrefx' ).'</label>' .
             '<input id="email" name="email" type="text" class="form-control required" value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30" tabindex="2"' . $aria_req . ' />' .
             '<span class="help-block">'.__( 'Your email will be keep safe and won\'t be shared with third party','calibrefx' ).'</span>'.
             '</div><!-- #form-section-email .form-section -->';

    $url = '<div class="form-group comment-form-url">' .
           '<label for="url" class="comment-form-label">'.__( 'Your Website Url','calibrefx' ).'</label>' .
           '<input id="url" name="url" type="text" class="form-control url" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" tabindex="3" />' .
           '<span class="help-block">'.__( '(start with http://)','calibrefx' ).'</span>'.
           '</div><!-- #form-section-url .form-section -->';

    $comment_field = '<div class="form-group comment-form-comment">' .
                     '<textarea id="comment" name="comment" class="form-control required" cols="45" rows="8" tabindex="4" aria-required="true"></textarea>' .
                     '</div><!-- #form-section-comment .form-section -->';

    $args = array(
            'fields'               => array(
                    'author' => $author,
                    'email'  => $email,
                    'url'    => $url,
            ),
            'comment_field'        => $comment_field,
            'title_reply'          => __( 'Leave us your thought', 'calibrefx' ),
            'comment_notes_before' => '',
            'comment_notes_after'  => '',
    );

    $args = wp_parse_args( $args, $defaults );

    return apply_filters( 'calibrefx_comment_form_args', $args, $user_identity, $id, $commenter, $req, $aria_req );
}
add_filter( 'comment_form_defaults', 'calibrefx_comment_form_args' );

/**
 * Comment callback for {@link calibrefx_default_comment_list()}.
 *
 */
function calibrefx_comment_callback( $comment, $args, $depth ) {

    $GLOBALS['comment'] = $comment; ?>

    <li <?php comment_class(); ?> id="comment-<?php comment_ID() ?>">

    <?php do_action( 'calibrefx_before_comment' ); ?>

    <div class="comment-author vcard">
            <?php echo get_avatar( $comment, $size = $args['avatar_size'] ); ?>
            <?php printf( __( '<cite class="fn">%s</cite> <span class="says">%s:</span>', 'calibrefx' ), get_comment_author_link(), apply_filters( 'comment_author_says_text', __( 'says', 'calibrefx' ) ) ); ?>
    </div><!-- end .comment-author -->

    <div class="comment-meta commentmetadata">
            <a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>"><?php printf( __( '%1$s at %2$s', 'calibrefx' ), get_comment_date(), get_comment_time() ); ?></a>
            <?php edit_comment_link( __( 'Edit', 'calibrefx' ),  '&bull; ', '' ); ?>
    </div><!-- end .comment-meta -->

    <div class="comment-content">
            <?php if ( $comment->comment_approved == '0' ) : ?>
                    <p class="alert"><?php echo apply_filters( 'calibrefx_comment_awaiting_moderation', __( 'Your comment is awaiting moderation.', 'calibrefx' ) ); ?></p>
            <?php endif; ?>

            <?php comment_text(); ?>
    </div><!-- end .comment-content -->

    <div class="reply">
        <?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
    </div>

    <?php do_action( 'calibrefx_after_comment' );
}