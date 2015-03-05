<?php
/**
 * Calibrefx Inpost Hooks
 *
 */

/**
 * Show layout choice per page or per post
 */
function calibrefx_add_inpost_layout_box() {
    if ( !current_theme_supports( 'calibrefx-inpost-layouts' ) ) {
        return;
    }

    //Add Post Meta Box
    calibrefx_add_post_meta_boxes(
        'calibrefx_inpost_layout_box', //slug
        __( 'Calibrefx Custom Settings', 'calibrefx' ), //title
        function() {
            calibrefx_do_post_meta_options( 'calibrefx_inpost_layout_box' );
        }, //callback
        array( 'post', 'page' ) //post types
    );

    //Add post meta option to post layout box
    calibrefx_add_post_meta_options(
        'calibrefx_inpost_layout_box', //slug
        '_calibrefx_layout', //option name
        __( 'Custom Layout','calibrefx' ), // Label
        array(
            'option_type' => 'custom',
            'option_custom' => calibrefx_layout_selector( array(
                    'name' =>'_calibrefx_layout', 
                    'selected' => get_post_meta( isset( $_GET['post'] )? $_GET['post'] : -1, "_calibrefx_layout", true),
                    'echo' => false) ),
            'option_default' => '',
            'option_filter' => '',
            'option_description' => '',
            'option_attr' => array( "class" => "calibrefx-layout-selector calibrefx-post-meta-heading"),
        ), // Settings config
        1 //Priority
    );

    calibrefx_add_post_meta_options(
        'calibrefx_inpost_layout_box', //slug
        '_calibrefx_advance_label', //option name
        'Style Settings', //option label
        array(
            'option_type' => 'custom',
            'option_custom' => '',
            'option_default' => '',
            'option_filter' => '',
            'option_description' => '',
            'option_attr' => array( "class" => "calibrefx-post-meta-heading"),
        ), // Settings config
        20 //Priority
    ); 

    calibrefx_add_post_meta_options(
        'calibrefx_inpost_layout_box', //slug
        '_calibrefx_custom_body_class', //option name
        __( 'Custom Body CSS Class', 'calibrefx' ), //option label
        array(
            'option_type' => 'textinput',
            'option_default' => '',
            'option_filter' => 'safe_text',
            'option_description' => '',
        ), // Settings config
        20 //Priority
    );    

    calibrefx_add_post_meta_options(
        'calibrefx_inpost_layout_box', //slug
        '_calibrefx_custom_post_class', //option name
        __( 'Custom Post CSS Class', 'calibrefx' ), //option label
        array(
            'option_type' => 'textinput',
            'option_default' => '',
            'option_filter' => 'safe_text',
            'option_description' => '',
        ), // Settings config
        21 //Priority
    );

    calibrefx_add_post_meta_options(
        'calibrefx_inpost_layout_box', //slug
        '_calibrefx_post_settings', //option name
        'Post Settings', //option label
        array(
            'option_type' => 'custom',
            'option_custom' => '',
            'option_default' => '',
            'option_filter' => '',
            'option_description' => '',
            'option_attr' => array( "class" => "calibrefx-post-meta-heading"),
        ), // Settings config
        25 //Priority
    );

    calibrefx_add_post_meta_options(
        'calibrefx_inpost_layout_box',  // group id
        '_calibrefx_custom_hide_breadcrumb', // field id and option name
        __( 'Hide Breadcrumb', 'calibrefx' ), // Label
        array(
            'option_type' => 'checkbox',
            'option_items' => '1',
            'option_default' => '0',
            'option_filter' => 'one_zero',
        ), // Settings config
        30 //Priority
    );

    calibrefx_add_post_meta_options(
        'calibrefx_inpost_layout_box',  // group id
        '_calibrefx_custom_hide_title', // field id and option name
        __( 'Hide Post Title', 'calibrefx' ), // Label
        array(
            'option_type' => 'checkbox',
            'option_items' => '1',
            'option_default' => '0',
            'option_filter' => 'one_zero',
        ), // Settings config
        30 //Priority
    );

    calibrefx_add_post_meta_options(
        'calibrefx_inpost_layout_box',  // group id
        '_calibrefx_custom_hide_date', // field id and option name
        __( 'Hide Post Published Date', 'calibrefx' ), // Label
        array(
            'option_type' => 'checkbox',
            'option_items' => '1',
            'option_default' => '0',
            'option_filter' => 'one_zero',
        ), // Settings config
        30 //Priority
    );

    calibrefx_add_post_meta_options(
        'calibrefx_inpost_layout_box',  // group id
        '_calibrefx_custom_hide_author', // field id and option name
        __( 'Hide Post Author', 'calibrefx' ), // Label
        array(
            'option_type' => 'checkbox',
            'option_items' => '1',
            'option_default' => '0',
            'option_filter' => 'one_zero',
        ), // Settings config
        30 //Priority
    );

    calibrefx_add_post_meta_options(
        'calibrefx_inpost_layout_box',  // group id
        '_calibrefx_custom_hide_comment_count', // field id and option name
        __( 'Hide Post Comment Count', 'calibrefx' ), // Label
        array(
            'option_type' => 'checkbox',
            'option_items' => '1',
            'option_default' => '0',
            'option_filter' => 'one_zero',
        ), // Settings config
        30 //Priority
    );

    calibrefx_add_post_meta_options(
        'calibrefx_inpost_layout_box',  // group id
        '_calibrefx_custom_hide_category', // field id and option name
        __( 'Hide Post Category', 'calibrefx' ), // Label
        array(
            'option_type' => 'checkbox',
            'option_items' => '1',
            'option_default' => '0',
            'option_filter' => 'one_zero',
        ), // Settings config
        30 //Priority
    );

    calibrefx_add_post_meta_options(
        'calibrefx_inpost_layout_box',  // group id
        '_calibrefx_custom_hide_tags', // field id and option name
        __( 'Hide Post Tags', 'calibrefx' ), // Label
        array(
            'option_type' => 'checkbox',
            'option_items' => '1',
            'option_default' => '0',
            'option_filter' => 'one_zero',
        ), // Settings config
        30 //Priority
    );


}
add_action( 'admin_menu', 'calibrefx_add_inpost_layout_box' );

/**
 * Register a new meta box to the post / page edit screen, so that the user can
 * set layout options on a per-post or per-page basis.
 *
 * @access public
 * @author Hilaladdiyar <hilal@calibrefx.com>
 * @return void
 *
 */
function calibrefx_add_inpost_box() {
    global $calibrefx_post_sections;
    do_action( "calibrefx_post_meta_options" );
    
    foreach ( (array) get_post_types( array( 'public' => true ) ) as $type ) {
        foreach ( $calibrefx_post_sections as $section => $value ) {
            if( in_array( $type, $value['post_types'] ) ) {
                add_meta_box( $section, $value['title'], $value['callback'], $type, 'normal', $value['priority'] );
            }
        }
    }
}
add_action( 'admin_menu', 'calibrefx_add_inpost_box', 99);

/**
 * Show inpost layout box
 */
function calibrefx_inpost_layout_box() {

    wp_nonce_field( 'calibrefx_inpost_layout_action', 'calibrefx_inpost_layout_nonce' );

    $layout = calibrefx_get_custom_field( 'site_layout' );
    ?>
    <div class="calibrefx-layout-selector">
        <p><input type="radio" name="_calibrefx_layout" id="default-layout" value="" <?php checked( $layout, '' ); ?> /> <label class="default" for="default-layout"><?php printf(__( 'Default Layout set in <a href="%s">Theme Settings</a>', 'calibrefx' ), menu_page_url( 'calibrefx', 0) ); ?></label></p>

        <p><?php calibrefx_layout_selector( array( 'name' => '_calibrefx_layout', 'selected' => $layout, 'type' => 'site' ) ); ?></p>
    </div>

    <br class="clear" />

    <p><label for="calibrefx_custom_body_class"><b><?php _e( 'Custom Body Class', 'calibrefx' ); ?></b></label></p>
    <p><label for="calibrefx_custom_post_class"><b><?php _e( 'Custom Post Class', 'calibrefx' ); ?></b></label></p>
    <p><input class="large-text" type="text" name="_calibrefx_custom_post_class" id="calibrefx_custom_post_class" value="<?php echo esc_attr(sanitize_html_class(calibrefx_get_custom_field( '_calibrefx_custom_post_class' ) )); ?>" /></p>
    <?php
}

/**
 * Saves the layout options when we save a post / page.
 *
 * It does so by grabbing the array passed in $_POST, looping through it, and
 * saving each key / value pair as a custom field.
 *
 * @access public
 * @return null
 */
function calibrefx_inpost_save( $post_id, $post ) {
    global $calibrefx, $calibrefx_post_meta_options;

    //Only run in admin site
    if( !is_admin() ) return;
    
    if( !in_array( $post->post_type, get_post_types( array( 'public' => true ) ) ) ) {
        return $post->ID;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
        return;
    }

    if ( defined( 'DOING_CRON' ) && DOING_CRON ) {
        return;
    }

    if( !is_array( $calibrefx_post_meta_options ) ) return;
    
    if( !is_array( $calibrefx_post_meta_options ) ) {
        return;
    }

    foreach ( $calibrefx_post_meta_options as $sections ) {
        foreach ( $sections as $options ) {
            foreach ( $options as $option_priority ) {
                foreach ( $option_priority as $option_name => $option ) {
                    if ( isset( $_POST[$option_name] ) ) {
                        //sanitize first
                        $sanitized_value = $calibrefx->security->do_sanitize_filter( $option['option_filter'], $_POST[$option_name] );
                        //update post meta
                        update_post_meta( $post_id, $option_name, $sanitized_value );
                    }
                }
            }
        }
    }
}
add_action( 'save_post', 'calibrefx_inpost_save', 1, 2 );
