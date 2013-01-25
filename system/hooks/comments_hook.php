<?php

/**
 * CalibreFx
 *
 * WordPress Themes Framework by CalibreFx Team
 *
 * @package		CalibreFx
 * @author		CalibreFx Team
 * @copyright           Copyright (c) 2012, CalibreWorks. (http://www.calibreworks.com/)
 * @link		http://www.calibrefx.com
 * @filesource 
 *
 * WARNING: This file is part of the core CalibreFx framework. DO NOT edit
 * this file under any circumstances. 
 * 
 *
 * @package CalibreFx
 */
/**
 * Calibrefx Comments Hooks
 *
 * @package		Calibrefx
 * @subpackage          Hook
 * @author		CalibreFx Team
 * @since		Version 1.0
 * @link		http://www.calibrefx.com
 */

add_action( 'calibrefx_after_post', 'calibrefx_get_comments_template' );
/**
 * Output the comments at the end of posts / pages.
 *
 * Load comments only if we are on a page or post and only if comments or
 * trackbacks are enabled.
 *
 */
function calibrefx_get_comments_template() {
    if ( is_single() && ( calibrefx_get_option( 'trackbacks_posts' ) || calibrefx_get_option( 'comments_posts' ) ) )
        comments_template( '', true );
    elseif ( is_page() && ( calibrefx_get_option( 'trackbacks_pages' ) || calibrefx_get_option( 'comments_pages' ) ) )
        comments_template( '', true );
}

add_action( 'calibrefx_comments', 'calibrefx_do_comments' );
/**
 * Echo CalibreFx default comment structure.
 *
 * @uses calibrefx_get_option()
 *
 */
function calibrefx_do_comments() {
    global $post, $wp_query;

    /** Bail if comments are off for this post type */
    if ( ( is_page() && ! calibrefx_get_option( 'comments_pages' ) ) || ( is_single() && ! calibrefx_get_option( 'comments_posts' ) ) )
            return;
    if ( have_comments() && ! empty( $wp_query->comments_by_type['comment'] ) ) { ?>
        <div id="comments">
                <?php echo apply_filters( 'calibrefx_title_comments', __( '<h3>Comments</h3>', 'calibrefx' ) ); ?>
                <ol class="comment-list">
                        <?php do_action( 'calibrefx_list_comments' ); ?>
                </ol>
                <div class="navigation">
                        <div class="alignleft"><?php previous_comments_link() ?></div>
                        <div class="alignright"><?php next_comments_link() ?></div>
                </div>
        </div><!--end #comments-->
        <?php
    }
    /** No comments so far */
    else {?>
        <div id="comments">
                <?php
                /** Comments are open, but there are no comments */
                if ( 'open' == $post->comment_status )
                        echo apply_filters( 'calibrefx_no_comments_text', '' );
                else /** Comments are closed */
                        echo apply_filters( 'calibrefx_comments_closed_text', '' );
                ?>
        </div><!--end #comments-->
        <?php
    }
}

add_action( 'calibrefx_pings', 'calibrefx_do_pings' );
/**
 * Echo CalibreFx default trackback structure.
 *
 * @uses calibrefx_get_option()
 *
 */
function calibrefx_do_pings() {
    global $post, $wp_query;

    /** Bail if trackbacks are off for this post type */
    if ( ( is_page() && ! calibrefx_get_option( 'trackbacks_pages' ) ) || ( is_single() && ! calibrefx_get_option( 'trackbacks_posts' ) ) )
        return;

    /** If have pings */
    if ( have_comments() && !empty( $wp_query->comments_by_type['pings'] ) ) {
    ?>
        <div id="pings">
                <?php echo apply_filters( 'calibrefx_title_pings', __( '<h3>Trackbacks</h3>', 'calibrefx' ) ); ?>
                <ol class="ping-list">
                        <?php do_action( 'calibrefx_list_pings' ); ?>
                </ol>
        </div><!-- end #pings -->
        <?php
    }
    /** No pings so far */
    else {
        echo apply_filters( 'calibrefx_no_pings_text', '' );
    }

}

add_action( 'calibrefx_list_comments', 'calibrefx_default_list_comments' );
/**
 * Outputs the comment list to the <code>calibrefx_comment_list()</code> hook.
 */
function calibrefx_default_list_comments() {
    $args = array(
            'type'			=> 'comment',
            'avatar_size'	=> 48,
            'callback'		=> 'calibrefx_comment_callback',
    );
    $args = apply_filters( 'calibrefx_comment_list_args', $args );
    wp_list_comments( $args );
}

add_action( 'calibrefx_list_pings', 'calibrefx_default_list_pings' );
/**
 * Outputs the ping list to the <code>calibrefx_ping_list()</code> hook.
 *
 */
function calibrefx_default_list_pings() {
    $args = array( 'type' => 'pings', );
    $args = apply_filters( 'calibrefx_ping_list_args', $args );
    wp_list_comments( $args );
}

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
            <?php if ($comment->comment_approved == '0') : ?>
                    <p class="alert"><?php echo apply_filters( 'calibrefx_comment_awaiting_moderation', __( 'Your comment is awaiting moderation.', 'calibrefx' ) ); ?></p>
            <?php endif; ?>

            <?php comment_text(); ?>
    </div><!-- end .comment-content -->

    <div class="reply">
            <?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
    </div>

    <?php do_action( 'calibrefx_after_comment' );

    /** No ending </li> tag because of comment threading */

}

add_action( 'calibrefx_comment_form', 'calibrefx_do_comment_form' );
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

add_filter( 'comment_form_defaults', 'calibrefx_comment_form_args' );
/**
 * Filters the default comment form arguments, used by <code>comment_form()</code>
 *
 */
function calibrefx_comment_form_args( $defaults ) {

    global $user_identity, $id;

    $commenter = wp_get_current_commenter();
    $req       = get_option( 'require_name_email' );
    $aria_req  = ( $req ? ' aria-required="true"' : '' );

    $author = '<p class="comment-form-author">' .
              '<label for="author" class="comment-form-label">'.__('Your Name (required)','calibrefx').'</label>' .
              '<input id="author" name="author" type="text" class="required" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" tabindex="1"' . $aria_req . ' />' .
              '</p><!-- #form-section-author .form-section -->';

    $email = '<p class="comment-form-email">' .
             '<label for="email" class="comment-form-label">'.__('Your Email (required)','calibrefx').'</label>' .
             '<input id="email" name="email" type="text" class="required" value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30" tabindex="2"' . $aria_req . ' />' .
             '<span class="help-block">'.__('Your email will be keep safe and won\'t be shared with third party','calibrefx').'</span>'.
             '</p><!-- #form-section-email .form-section -->';

    $url = '<p class="comment-form-url">' .
           '<label for="url" class="comment-form-label">'.__('Your Website Url','calibrefx').'</label>' .
           '<input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" tabindex="3" />' .
           '<span class="help-block">'.__('(start with http://)','calibrefx').'</span>'.
           '</p><!-- #form-section-url .form-section -->';

    $comment_field = '<p class="comment-form-comment">' .
                     '<textarea id="comment" name="comment" cols="45" rows="8" tabindex="4" aria-required="true"></textarea>' .
                     '</p><!-- #form-section-comment .form-section -->';

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

    /** Merge $args with $defaults */
    $args = wp_parse_args( $args, $defaults );

    /** Return filterable array of $args, along with other optional variables */
    return apply_filters( 'calibrefx_comment_form_args', $args, $user_identity, $id, $commenter, $req, $aria_req );
}