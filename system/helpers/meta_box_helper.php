<?php 
/**
 * Reset Calibrefx Meta Sections in Theme Settings
 */
function calibrefx_clear_meta_section() {
    global $calibrefx_sections;
    unset( $calibrefx_sections);

    if ( !isset( $calibrefx_sections ) ) {
        $calibrefx_sections = array();
    }
}

/**
 * Check if meta section is exist
 */
function calibrefx_is_meta_section_exist( $slug ) {
    global $calibrefx_sections;

    if ( !isset( $calibrefx_sections ) ) {
        return false;
    }

    if ( !isset( $calibrefx_sections[$slug] ) ) {
        return false;
    }

    //if the section already exist then we do nothing
    if ( !empty( $calibrefx_sections[$slug] ) ) {
        return true;
    }
}

/**
 * Add Section tab in the Theme Settings
 *
 * @since 1.0.2
 *
 * @param string $slug String section slug.
 * @param string $title Title of the section.
 * @param string $ability Optional. The ability that can see the settings ( 'general', 'professor' ).
 */
function calibrefx_add_meta_section( $slug, $title, $target='options.php', $priority = 10, $icon = '', $active_icon = '' ) {
    global $calibrefx_sections;

    if ( !isset( $calibrefx_sections ) )
        $calibrefx_sections = array();

    if ( !isset( $calibrefx_sections[$slug] ) ) {
        $calibrefx_sections[$slug] = array();
    }

    //if the section already exist then we do nothing
    if ( !empty( $calibrefx_sections[$slug] ) ) {
        return;
    }

    $calibrefx_sections[$slug] = array(
        'slug'        => $slug,
        'title'       => $title,
        'basic'       => array(),
        'professor'   => array(),
        'priority'    => $priority,
        'icon'        => $icon,
        'active_icon' => $active_icon
    );

    uasort( $calibrefx_sections, 'calibrefx_compare_meta_section_priority' );

    $func = create_function( '', 'return "' . $target . '";' );
    add_filter( 'calibrefx_' . $slug . '_form_url', $func );
}

function calibrefx_compare_meta_section_priority( $x, $y ) {
    return $x['priority'] - $y['priority'];
}

function calibrefx_do_meta_sections( $section, $screen, $context, $object ) {
    global $calibrefx_sections, $calibrefx_user_ability, $wp_meta_boxes;

    if ( !isset( $calibrefx_sections ) ) {
        return;
    }

    if ( !isset( $calibrefx_user_ability ) ) {
        $calibrefx_user_ability = 'basic';
    }

    if ( empty( $screen ) ) {
        $screen2 = get_current_screen();
    } elseif ( is_string( $screen ) ) {
        $screen2 = convert_to_screen( $screen);
    }

    $page = $screen2->id;
    $sorted = get_user_option( "meta-box-order_$page" );
    
    if ( empty( $wp_meta_boxes[$page][$context]['sorted'] ) ) {
        if ( !empty( $calibrefx_sections[$section]['basic'] ) ) {
            foreach ( $calibrefx_sections[$section]['basic'] as $metas ) {
                add_meta_box( $metas['id'], $metas['title'], $metas['callback'], $metas['screen'], $metas['context'], $metas['priority'], $metas['callback'] );
            }
        }

        if ( !empty( $calibrefx_sections[$section]['professor']) && $calibrefx_user_ability === 'professor' ) {
            foreach ( $calibrefx_sections[$section]['professor'] as $metas ) {
                add_meta_box( $metas['id'], $metas['title'], $metas['callback'], $metas['screen'], $metas['context'], $metas['priority'], $metas['callback'] );
            }
        }
    }

    do_meta_boxes( $screen, $context, $object );
}

/**
 * Add a meta box to an edit form.
 *
 * @since 1.0.2
 *
 * @use add_meta_box
 * @param string $section String for use in the 'id' attribute of tags.
 * @param string $ability current user ability. professor|general.
 * @param string $id String for use in the 'id' attribute of tags.
 * @param string $title Title of the meta box.
 * @param string $callback Function that fills the box with the desired content. The function should echo its output.
 * @param string|object $screen Optional. The screen on which to show the box (post, page, link). Defaults to current screen.
 * @param string $context Optional. The context within the page where the boxes should show ( 'normal', 'advanced' ).
 * @param string $priority Optional. The priority within the context where the boxes should show ( 'high', 'low' ).
 */
function calibrefx_add_meta_box( $section, $ability, $id, $title, $callback, $screen = null, $context = 'advanced', $priority = 'default', $callback_args = null ) {
    global $calibrefx_sections;

    if ( !isset( $calibrefx_sections ) ) {
        return;
    }

    if ( !isset( $calibrefx_sections[$section] ) ) {
        return;
    }
    
    $calibrefx_sections[$section][$ability][] = array(
        "id"            => $id,
        "title"         => $title,
        "callback"      => $callback,
        "screen"        => $screen,
        "context"       => $context,
        "priority"      => $priority,
        "callback_args" => $callback_args,
    );
}

/**
 * [calibrefx_add_meta_group description]
 * @param  [type] $metabox_id  [description]
 * @param  [type] $group_id    [description]
 * @param  [type] $group_title [description]
 * @return [type]              [description]
 */
function calibrefx_add_meta_group( $metabox_id, $group_id, $group_title ) {
    global $calibrefx_meta_options;

    if( !is_array( $calibrefx_meta_options ) ) $calibrefx_meta_options = array();


    $calibrefx_meta_options[$group_id] = array(
        'title'   => $group_title,
        'metabox' => $metabox_id
    );
}

/**
 * calibrefx_add_meta_option create option fields for theme settings
 * 
 * @param  string $metabox_id  metabox id where the settings display
 * @param  string $group_title the title of the options group
 * @param  array $options store theme options, accepted: option_name, option_type, option_values, option_description
 * @return void
 */
function calibrefx_add_meta_option( $group_id, $option_name, $option_label, $options, $priority, $atts = array() ) {
    global $calibrefx_meta_options, $calibrefx;

    if( !is_array( $calibrefx_meta_options ) ) {
        $calibrefx_meta_options = array();
    }

    $options = array_merge( array( 'option_label' => $option_label ), $options);

    //add sanitize filter
    if( !empty( $options['option_filter'] ) ) {
        $calibrefx->security->add_sanitize_filter(
                    $options['option_filter'], 
                    'calibrefx-settings', 
                    $option_name );
    }

    $calibrefx_meta_options[$group_id]['options'][$priority][$option_name] = $options;
}

/**
 * Output All the meta options based on given metabox id
 * 
 * @param  Object $settings_obj Screen Object
 * @param  string $metabox_id   Meta box id
 * @return void
 */
function calibrefx_do_meta_options( $settings_obj, $metabox_id ) {
    global $calibrefx_meta_options, $calibrefx;

    do_action( $metabox_id.'_options' );

    $calibrefx->load->library( 'form' );
    
    $settings_field = $settings_obj->settings_field;

    foreach ( $calibrefx_meta_options as $option_group_id => $option_group ) {

        if ( !isset( $option_group['metabox'] ) OR $option_group['metabox'] != $metabox_id ) continue;
        
        if ( empty( $option_group['options'] ) ) continue;

        $options = $option_group['options'];

        if ( !$options ) continue;
        
        ksort( $options);
    ?>
        
        <h3 class="section-title"><?php echo $option_group['title']; ?></h3>
        <div id="<?php echo $option_group_id; ?>">
            <?php
                foreach ( $options as $option_priority ) {
                    foreach ( $option_priority as $option_name => $option ) {
                        //backward compatibility
                        if ( empty( $option['option_attr'] ) ) {
                            $option['option_attr'] = array();
                        }

                        $attr = '';
                        
                        foreach( $option['option_attr'] as $key => $val ) {
                            $attr .= ' ' . $key . '="' . $val .'"';
                        }
                        ?>
                        <div class="option-item">
                            <p <?php echo $attr; ?> >
                                <?php 
                                    switch ( $option['option_type'] ) {
                                        case 'hidden':
                                            echo $calibrefx->form->hidden( $settings_field."[".$option_name."]", calibrefx_get_option( $option_name ), $option['option_attr'] );
                                            break;

                                        case 'textinput':
                                        case 'textarea':
                                        case 'password':
                                        case 'colorpicker':
                                            //we need to extract the class from the array
                                            $classes = "";
                                            if( isset( $option['option_attr']['class']) ) {
                                                $classes = $option['option_attr']['class'];
                                                unset( $option['option_attr']['class'] );
                                            }
                                            echo '<label for="'.$settings_field.'['.$option_name.']">'.$option["option_label"].'</label>';
                                            echo $calibrefx->form->{$option['option_type']}( $settings_field."[".$option_name."]", calibrefx_get_option( $option_name ), $classes, $option['option_attr'] );
                                            break;

                                        case 'upload':
                                            //we need to extract the class from the array
                                            $classes = "";
                                            if( isset( $option['option_attr']['class'] ) ) {
                                                $classes = $option['option_attr']['class'];
                                                unset( $option['option_attr']['class'] );
                                            }

                                            $option_name_id = $option_name . '_id';
                                            $image = calibrefx_get_option( $option_name );

                                            if( $image ) echo '<div class="preview_image image_preview" id="preview_'.$option_name.'"><img src="'.calibrefx_get_option( $option_name ).'" /></div>';
                                            else echo '<div class="preview_image image_preview" id="preview_'.$option_name.'"></div>';

                                            echo '<label for="'.$settings_field.'['.$option_name.']">'.$option["option_label"].'</label>';
                                            echo $calibrefx->form->textinput( $settings_field."[".$option_name."]", calibrefx_get_option( $option_name ), $classes, $option['option_attr'] );
                                            echo $calibrefx->form->hidden( $settings_field."[".$option_name_id."]", calibrefx_get_option( $option_name_id ), array("id" => $option_name_id, "class" => "image_id" ) );
                                            echo '<div class="upload_button_div">
                                                    <span class="button upload_image_button" id="upload_custom_logo">Upload Image</span>
                                                    <span class="button image_reset_button hide image_reset" id="reset_custom_logo">Remove</span>
                                                    <div class="clear"></div>
                                                </div>';

                                            break;

                                        case 'checkbox':
                                            $classes = "calibrefx-settings-checkbox";
                                            if ( isset( $option['option_attr']['class'] ) ) {
                                                $classes .= ' '.$option['option_attr']['class'];
                                                unset( $option['option_attr']['class'] );
                                            }

                                            $attr = array_merge( array( "target" => $settings_field."-".$option_name, "class" => $classes ), $option['option_attr'] );
                                            
                                            echo $calibrefx->form->{$option['option_type']}( $settings_field."-checkbox-".$option_name, $option['option_items'],
                                                calibrefx_get_option( $option_name ), $option['option_label'], false, 
                                                $attr);

                                            echo $calibrefx->form->hidden( $settings_field."[".$option_name."]", calibrefx_get_option( $option_name ), 
                                               array("id" => $settings_field."-".$option_name ) );
                                            break;

                                        case 'radio':
                                        case 'select':
                                            echo '<label for="'.$settings_field.'['.$option_name.']">'.$option["option_label"].'</label>';
                                            echo $calibrefx->form->{$option['option_type']}( $settings_field."[".$option_name."]", $option['option_items'],calibrefx_get_option( $option_name ), '', $option['option_attr'] );
                                            break;
                                        case 'description':
                                            echo '<p class="description">'.
                                                 $option['option_label'] .
                                                 '</p>';
                                            break;
                                        case 'custom':
                                            if ( isset( $option['option_custom'] ) ) {
                                                echo $option['option_custom'];
                                            }
                                            break;

                                    }
                                ?>
                            </p>
                            <?php 
                                if(!empty( $option['option_description'] ) ) :
                            ?>
                                <p class="description">
                                    <?php echo $option['option_description']; ?>
                                </p>
                            <?php
                                endif;
                            ?>
                        </div>
                    <?php 
                        }
                    ?>
                <?php
                }
            ?>
        </div>
    <?php
    }
}

function calibrefx_add_post_meta_boxes( $slug, $title, $callback, $post_types = array( 'post', 'page' ), $priority = 'high' ) {
    global $calibrefx_post_sections;

    if ( !isset( $calibrefx_post_sections ) ) {
        $calibrefx_post_sections = array();
    }

    if ( !isset( $calibrefx_post_sections[$slug] ) ) {
        $calibrefx_post_sections[$slug] = array();
    }

    //if the section already exist then we do nothing
    if ( !empty( $calibrefx_post_sections[$slug] ) ) {
        return;
    }

    $calibrefx_post_sections[$slug] = array(
        'title'      => $title,
        'post_types' => $post_types,
        'priority'   => $priority,
        'callback'   => $callback
    );
}

function calibrefx_add_post_meta_options( $slug, $option_name, $option_label, $options, $priority, $atts = array() ) {
    global $calibrefx_post_meta_options, $calibrefx;

    if ( !is_array( $calibrefx_post_meta_options ) ) {
        $calibrefx_post_meta_options = array();
    }

    $options = array_merge( array( 'option_label' => $option_label ), $options );

    $calibrefx_post_meta_options[$slug]['options'][$priority][$option_name] = $options;
}

/**
 * Output All the meta options based on given metabox id
 * 
 * @param  Object $settings_obj Screen Object
 * @param  string $metabox_id   Meta box id
 * @return void
 */
function calibrefx_do_post_meta_options( $slug ) {
    global $calibrefx_post_meta_options, $calibrefx;
    if( empty( $calibrefx_post_meta_options[$slug] ) ) return;

    do_action( $slug.'_options' );

    $calibrefx->load->library( 'form' );
    
    foreach ( $calibrefx_post_meta_options[$slug] as $options ) {
        if( empty( $options ) ) continue;
        ksort( $options );
                
        foreach ( $options as $option_priority ) {
            foreach ( $option_priority as $option_name => $option ) {
                //backward compatibility
                if( empty( $option['option_attr'] ) ) {
                    $option['option_attr'] = array();
                }
                $attr = '';
                foreach( $option['option_attr'] as $key => $val ) {
                    $attr .= ' ' . $key . '="' . $val .'"';
                }
            ?>
            <p <?php echo $attr; ?> >
                <?php 
                    switch ( $option['option_type'] ) {
                        case 'hidden':
                            echo $calibrefx->form->hidden( $option_name, calibrefx_get_custom_field( $option_name ), $option['option_attr'] );
                            break;

                        case 'text':
                        case 'textinput':
                        case 'textarea':
                        case 'password':
                            //we need to extract the class from the array
                            $classes = "";
                            if ( isset( $option['option_attr']['class'] ) ) {
                                $classes = $option['option_attr']['class'];
                                unset( $option['option_attr']['class'] );
                            }
                            echo '<label for="'.$option_name.'">'.$option["option_label"].'</label> ';
                            echo $calibrefx->form->{$option['option_type']}( $option_name, calibrefx_get_custom_field( $option_name ), $classes, $option['option_attr']);
                            break;
                        
                        /*case 'checkbox':
                            $classes = "calibrefx-settings-checkbox";
                            if(isset( $option['option_attr']['class']) ) {
                                $classes .= ' '.$option['option_attr']['class'];
                                unset( $option['option_attr']['class']);
                            }
                            $attr = array_merge(array("target" => $settings_field."-".$option_name, "class" => $classes), $option['option_attr']);
                            echo $calibrefx->form->{$option['option_type']}( $settings_field."-checkbox-".$option_name, $option['option_items'],
                                calibrefx_get_custom_field( $option_name), $option['option_label'], false, 
                                $attr);
                            echo $calibrefx->form->hidden( $option_name, calibrefx_get_custom_field( $option_name), 
                                array("id" => $settings_field."-".$option_name) );
                            break;
                        case 'radio':
                        case 'select':
                            echo '<label for="'.$option_name . '">'.$option["option_label"].'</label>';
                            echo $calibrefx->form->{$option['option_type']}( $option_name, $option['option_items'],calibrefx_get_custom_field( $option_name), '', $option['option_attr']);
                            break;*/
                        case 'custom':
                            if( isset( $option['option_custom'] ) ) {
                                echo '<label for="'.$option_name . '">'.$option["option_label"].'</label>';
                                echo $option['option_custom'];
                            }
                            break;
                    }
                ?>
            </p>
            <?php 
                if( !empty( $option['option_description'] ) ) :
            ?>
                <p class="description">
                    <?php echo $option['option_description']; ?>
                </p>
            <?php
                endif;
            }
        }
    }
}