<?php
/* Template Name: Blog
 *
 * CalibreFx Framework
 *
 * WordPress Themes by CalibreFx Team
 *
 * @package		CalibreFx
 * @author		CalibreFx Team
 * @authorlink	http://www.calibrefx.com
 * @copyright	Copyright (c) 2012, Suntech Inti Perkasa.
 * @license		Commercial
 * @link		http://www.calibrefx.com
 * @since		Version 1.0
 * @filesource 
 *
 * CalibreFx Page file
 *
 * @package CalibreFx
 */

remove_action( 'calibrefx_loop', 'calibrefx_do_loop' );
add_action('calibrefx_loop', 'calibrefx_do_blog_loop');

/**
 * CalibreFx Loop for blog bage
 *
 * It's just like the default loop except it is used for displaying blog post category
 *
 */
function calibrefx_do_blog_loop() {
    $query = new WP_Query('category_name=blog&paged=' . get_query_var('paged') . '&posts_per_page=5');

    if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post(); // the loop

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

calibrefx();