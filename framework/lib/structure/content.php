<?php
/**
 * CalibreFx
 *
 * WordPress Themes Framework by CalibreWorks Team
 *
 * @package		CalibreFx
 * @author		CalibreWorks Team
 * @copyright	Copyright (c) 2012, Suntech Inti Perkasa.
 * @license		Commercial
 * @link		http://calibrefx.com
 * @since		Version 1.0
 * @filesource 
 *
 * WARNING: This file is part of the core CalibreFx framework. DO NOT edit
 * this file under any circumstances. 
 *
 * This file hold all the functions to control content
 *
 * @package CalibreFx
 */
add_action('calibrefx_loop', 'calibrefx_do_loop');

/**
 * Do content loop and display
 *
 */
function calibrefx_do_loop() {

    //Provide space to override the default loop

    calibrefx_default_loop();
}

/**
 * CalibreFx default loop
 *
 * It outputs basic wrapping HTML, but uses hooks to do most of its
 * content output like Title, Content, Post information, and Comments.
 *
 */
function calibrefx_default_loop() {

    if (have_posts()) : while (have_posts()) : the_post(); // the loop

            do_action('calibrefx_before_post');
            ?>
            <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                <?php do_action('calibrefx_before_post_title'); ?>
                <?php do_action('calibrefx_post_title'); ?>
                <?php do_action('calibrefx_after_post_title'); ?>

                <?php do_action('calibrefx_before_post_content'); ?>
                <div class="entry-content">
                    <?php do_action('calibrefx_post_content'); ?>
                </div><!-- end .entry-content -->
                <?php do_action('calibrefx_after_post_content'); ?>

            </div><!-- end .postclass -->
            <?php
            do_action('calibrefx_after_post');
            $loop_counter++;

        endwhile;/** end of one post * */
        do_action('calibrefx_after_post_loop');

    else : /** if no posts exist * */
        do_action('calibrefx_no_post');
    endif;/** end loop * */
}

add_action('calibrefx_before_post', 'calibrefx_do_before_post');

/**
 * calibrefx_do_before_post callback
 *
 * It outputs content every before posts in loop
 *
 */
function calibrefx_do_before_post() {
    return;
}

add_action('calibrefx_post_title', 'calibrefx_do_post_title');
/**
 * calibrefx_do_post_title callback
 *
 * It outputs the post title
 *
 */
function calibrefx_do_post_title() {
    $title = get_the_title();

    if (strlen($title) == 0)
        return;

    if (is_singular()) {
        $title = sprintf('<h1 class="entry-title">%s</h1>', apply_filters('calibrefx_post_title_text', $title));
    } else {
        $title = sprintf('<h2 class="entry-title"><a href="%s" title="%s" rel="bookmark">%s</a></h2>', get_permalink(), the_title_attribute('echo=0'), apply_filters('calibrefx_post_title_text', $title));
    }

    echo apply_filters('calibrefx_post_title_output', $title) . "\n";
}

add_action('calibrefx_before_post_content', 'calibrefx_do_before_post_content');
/**
 * calibrefx_do_before_post_content callback
 *
 * It outputs content before the post content
 *
 */
function calibrefx_do_before_post_content() {
    return;
}

add_filter('calibrefx_post_info', 'do_shortcode', 20);
add_action('calibrefx_before_post_content', 'calibrefx_post_info');

/**
 * Echo the post info before the post content.
 *
 * Use several content shortcode, refered to shortcodes/content.php
 *
 */
function calibrefx_post_info() {

    global $post;

    if (is_page($post->ID))
        return;

    $post_info = '[post_date] ' . __('By', 'calibrefx') . ' [post_author_posts_link] [post_comments] [post_edit]';
    printf('<div class="post-info">%s</div>', apply_filters('calibrefx_post_info', $post_info));
}

add_filter('calibrefx_post_meta', 'do_shortcode', 20);
add_action('calibrefx_after_post_content', 'calibrefx_post_meta');

/**
 * Echo the post meta after the post content. Will not show in page.
 *
 * Use several content shortcode, refered to shortcodes/content.php
 */
function calibrefx_post_meta() {

    global $post;

    if (is_page($post->ID))
        return;

    $post_meta = '[post_categories] [post_tags]';
    printf('<div class="post-meta">%s</div>', apply_filters('calibrefx_post_meta', $post_meta));
}

add_action('calibrefx_post_content', 'calibrefx_do_post_image');

/**
 * Post Image
 */
function calibrefx_do_post_image() {
    // && calibrefx_get_option('content_thumbnail')
    if (!is_singular()) {
        $img = calibrefx_get_image(array('format' => 'html', 'size' => calibrefx_get_option('image_size'), 'attr' => array('class' => 'pull-left post-image')));
        printf('<a href="%s" title="%s">%s</a>', get_permalink(), the_title_attribute('echo=0'), $img);
    }
}

add_action('calibrefx_post_content', 'calibrefx_do_post_content');

/**
 * calibrefx_do_post_content callback
 *
 * It outputs the post content
 *
 */
function calibrefx_do_post_content() {

    if (is_singular()) {
        the_content(); // display content on posts/pages

        if (is_single() && get_option('default_ping_status') == 'open') {
            echo '<!--';
            trackback_rdf();
            echo '-->' . "\n";
        }

        if (is_page()) {
            edit_post_link(__('(Edit)', 'calibrefx'), '', '');
        }
    } elseif ('excerpts' == calibrefx_get_option('content_archive')) {
        the_excerpt();
    } else {
        if (calibrefx_get_option('content_archive_limit'))
            the_content_limit((int) calibrefx_get_option('content_archive_limit'), __('[Read more...]', 'calibrefx'));
        else
            the_content(__('[Read more...]', 'calibrefx'));
    }

    wp_link_pages(array('before' => '<p class="pages">' . __('Pages:', 'calibrefx'), 'after' => '</p>'));
}

add_action('calibrefx_after_post', 'calibrefx_do_author_box_single');

/**
 * Conditionally adds the author box after single posts or pages.
 *
 */
function calibrefx_do_author_box_single() {

    if (!is_single())
        return;

    if (get_the_author_meta('calibrefx_author_box_single', get_the_author_meta('ID')))
        calibrefx_author_box('single');
}

add_action('calibrefx_no_post', 'calibrefx_do_no_post');

/**
 * calibrefx_do_no_post callback
 *
 * It outputs the no post text when no post is selected
 *
 */
function calibrefx_do_no_post() {
    printf('<p>%s</p>', apply_filters('calibrefx_noposts_text', __('Sorry, no posts matched your criteria.', 'calibrefx')));
}