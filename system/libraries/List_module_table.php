<?php 
defined( 'CALIBREFX_URL' ) OR exit();
/**
 * CalibreFx Framework
 *
 * WordPress Themes Framework by CalibreFx Team
 *
 * @package     CalibreFx
 * @author      CalibreFx Team 
 * @copyright   Copyright (c) 2012-2013, Calibreworks. (http://www.calibreworks.com/)
 * @license     GNU GPL v2
 * @link        http://www.calibrefx.com
 * @filesource 
 *
 * WARNING: This file is part of the core CalibreFx framework. DO NOT edit
 * this file under any circumstances. 
 *
 * This define the framework constants
 *
 * @package CalibreFx
 */

/**
 * Calibrefx Module Table List Class
 *
 * @package     Calibrefx
 * @subpackage  Library
 * @author      CalibreFx Team
 * @since       Version 1.1.0
 * @link        http://www.calibrefx.com
 */


class CFX_List_Module_Table extends WP_List_Table {
    
    function __construct( $args = array() ) {
        global $status, $page;

        parent::__construct( array(
            'plural' => 'modules',
            'screen' => isset( $args['screen'] ) ? $args['screen'] : null,
        ) );

        $status = 'all';
        if ( isset( $_REQUEST['module_status'] ) && in_array( $_REQUEST['module_status'], array( 'active', 'inactive', 'recently_activated', 'upgrade', 'mustuse', 'dropins', 'search' ) ) )
            $status = $_REQUEST['module_status'];

        if ( isset( $_REQUEST['s']) )
            $_SERVER['REQUEST_URI'] = add_query_arg( 's', wp_unslash( $_REQUEST['s']) );
        $page = $this->get_pagenum();
    }

    function get_table_classes() {
        return array( 'widefat', $this->_args['plural'] );
    }

    function ajax_user_can() {
        return current_user_can( 'activate_plugins' );
    }

    function prepare_items() {
        global $status, $modules, $totals, $page, $orderby, $order, $s;

        wp_reset_vars( array( 'orderby', 'order', 's' ) );

        $modules = array(
            'all' => apply_filters( 'all_modules', get_modules() ),
            'search' => array(),
            'active' => array(),
            'inactive' => array(),
            /*'recently_activated' => array(),
            'upgrade' => array(),
            'mustuse' => array(),
            'dropins' => array()*/
        );

        $screen = $this->screen;
        foreach ( (array) $modules['all'] as $module_file => $module_data ) {
            // Filter into individual sections
            if ( ( ! $screen->in_admin( 'network' ) && is_plugin_active( $module_file ) )
                || ( $screen->in_admin( 'network' ) && is_plugin_active_for_network( $module_file ) ) ) {
                $modules['active'][ $module_file ] = $module_data;
            } else {
                if ( ! $screen->in_admin( 'network' ) && isset( $recently_activated[ $module_file ] ) ) // Was the plugin recently activated?
                    $modules['recently_activated'][ $module_file ] = $module_data;
                $modules['inactive'][ $module_file ] = $module_data;
            }
        }

        if ( $s ) {
            $status = 'search';
            $modules['search'] = array_filter( $modules['all'], array( $this, '_search_callback' ) );
        }

        $totals = array();
        foreach ( $modules as $type => $list )
            $totals[ $type ] = count( $list );

        if ( empty( $modules[ $status ] ) && !in_array( $status, array( 'all', 'search' ) ) )
            $status = 'all';

        $this->items = array();
        // die_dump( $modules);
        foreach ( $modules[ $status ] as $module_file => $module_data ) {
            // Translate, Don't Apply Markup, Sanitize HTML
            $this->items[$module_file] = _get_module_data_markup_translate( $module_file, $module_data, false, true );
        }

        $total_this_page = $totals[ $status ];

        if ( $orderby ) {
            $orderby = ucfirst( $orderby );
            $order = strtoupper( $order );

            uasort( $this->items, array( $this, '_order_callback' ) );
        }

        $modules_per_page = $this->get_items_per_page( str_replace( '-', '_', $screen->id . '_per_page' ), 999 );

        $start = ( $page - 1 ) * $modules_per_page;

        if ( $total_this_page > $modules_per_page )
            $this->items = array_slice( $this->items, $start, $modules_per_page );

        $this->set_pagination_args( array(
            'total_items' => $total_this_page,
            'per_page' => $modules_per_page,
        ) );
    }

    function no_items() {
        global $modules;

        if ( !empty( $modules['all'] ) )
            _e( 'No plugins found.' );
        else
            _e( 'You do not appear to have any modules available at this time.' );
    }

    function get_columns() {
        global $status;
        return array(
            'cb'          => !in_array( $status, array( 'mustuse', 'dropins' ) ) ? '<input type="checkbox" />' : '',
            'name'        => __( 'Module' ),
            'description' => __( 'Description' ),
        );
    }

    function get_sortable_columns() {
        return array();
    }

    function get_views() {
        global $totals, $status;

        $status_links = array();
        foreach ( $totals as $type => $count ) {
            if ( !$count )
                continue;

            switch ( $type ) {
                case 'all':
                    $text = _nx( 'All <span class="count">(%s)</span>', 'All <span class="count">(%s)</span>', $count, 'plugins' );
                    break;
                case 'active':
                    $text = _n( 'Active <span class="count">(%s)</span>', 'Active <span class="count">(%s)</span>', $count );
                    break;
                case 'recently_activated':
                    $text = _n( 'Recently Active <span class="count">(%s)</span>', 'Recently Active <span class="count">(%s)</span>', $count );
                    break;
                case 'inactive':
                    $text = _n( 'Inactive <span class="count">(%s)</span>', 'Inactive <span class="count">(%s)</span>', $count );
                    break;
                case 'mustuse':
                    $text = _n( 'Must-Use <span class="count">(%s)</span>', 'Must-Use <span class="count">(%s)</span>', $count );
                    break;
                case 'dropins':
                    $text = _n( 'Drop-ins <span class="count">(%s)</span>', 'Drop-ins <span class="count">(%s)</span>', $count );
                    break;
                case 'upgrade':
                    $text = _n( 'Update Available <span class="count">(%s)</span>', 'Update Available <span class="count">(%s)</span>', $count );
                    break;
            }

            if ( 'search' != $type ) {
                $status_links[$type] = sprintf( "<a href='%s' %s>%s</a>",
                    add_query_arg( 'plugin_status', $type, 'plugins.php' ),
                    ( $type == $status ) ? ' class="current"' : '',
                    sprintf( $text, number_format_i18n( $count ) )
                    );
            }
        }

        return $status_links;
    }

    function get_bulk_actions() {
        global $status;

        $actions = array();

        if ( 'active' != $status )
            $actions['activate-selected'] = $this->screen->in_admin( 'network' ) ? __( 'Network Activate' ) : __( 'Activate' );

        if ( 'inactive' != $status && 'recent' != $status )
            $actions['deactivate-selected'] = $this->screen->in_admin( 'network' ) ? __( 'Network Deactivate' ) : __( 'Deactivate' );

        return $actions;
    }

    function extra_tablenav( $which ) {
        global $status;

        if ( ! in_array( $status, array( 'recently_activated', 'mustuse', 'dropins' ) ) )
            return;

        echo '<div class="alignleft actions">';

        if ( ! $this->screen->in_admin( 'network' ) && 'recently_activated' == $status )
            submit_button( __( 'Clear List' ), 'button', 'clear-recent-list', false );
        elseif ( 'top' == $which && 'mustuse' == $status )
            echo '<p>' . sprintf( __( 'Files in the <code>%s</code> directory are executed automatically.' ), str_replace( ABSPATH, '/', WPMU_PLUGIN_DIR ) ) . '</p>';
        elseif ( 'top' == $which && 'dropins' == $status )
            echo '<p>' . sprintf( __( 'Drop-ins are advanced plugins in the <code>%s</code> directory that replace WordPress functionality when present.' ), str_replace( ABSPATH, '', WP_CONTENT_DIR ) ) . '</p>';

        echo '</div>';
    }

    function current_action() {
        if ( isset( $_POST['clear-recent-list']) )
            return 'clear-recent-list';

        return parent::current_action();
    }

    function display_rows() {
        global $status;

        foreach ( $this->items as $module_file => $module_data )
            $this->single_row( array( $module_file, $module_data ) );
    }

    function single_row( $item ) {
        global $status, $page, $s, $totals;

        list( $module_file, $module_data ) = $item;

        $context = $status;
        $screen = $this->screen;

        // preorder
        $actions = array(
            'deactivate' => '',
            'activate' => '',
            // 'edit' => '',
            // 'delete' => '',
        );

        // $module_file = file_exists( CALIBREFX_MODULE_URI . '/' . $module_file )? CALIBREFX_MODULE_URI . '/' . $module_file : CHILD_MODULE_URI . '/' . $module_file;

        $is_active = calibrefx_is_module_active( $module_file );
        
        if ( $is_active ) {
            $actions['deactivate'] = '<a href="' . wp_nonce_url( 'admin.php?page=calibrefx-module&action=deactivate&amp;module=' . $module_file . '&amp;module_status=' . $context . '&amp;paged=' . $page . '&amp;s=' . $s, 'deactivate-module_' . $module_file) . '" title="' . esc_attr__( 'Deactivate this plugin' ) . '">' . __( 'Deactivate' ) . '</a>';
        } else {
            $actions['activate'] = '<a href="' . wp_nonce_url( 'admin.php?page=calibrefx-module&action=activate&amp;module=' . $module_file . '&amp;module_status=' . $context . '&amp;paged=' . $page . '&amp;s=' . $s, 'activate-module_' . $module_file) . '" title="' . esc_attr__( 'Activate this plugin' ) . '" class="edit">' . __( 'Activate' ) . '</a>';
        } // end if $is_active

        $class = $is_active ? 'active' : 'inactive';
        $checkbox_id =  "checkbox_" . md5( $module_data['Name']);
        if ( in_array( $status, array( 'mustuse', 'dropins' ) ) ) {
            $checkbox = '';
        } else {
            $checkbox = "<label class='screen-reader-text' for='" . $checkbox_id . "' >" . sprintf( __( 'Select %s' ), $module_data['Name'] ) . "</label>"
                . "<input type='checkbox' name='checked[]' value='" . esc_attr( $module_file ) . "' id='" . $checkbox_id . "' />";
        }
        if ( 'dropins' != $context ) {
            $description = '<p>' . ( $module_data['Description'] ? $module_data['Description'] : '&nbsp;' ) . '</p>';
            $module_name = $module_data['Name'];
        }

        $id = sanitize_title( $module_name );
        if ( ! empty( $totals['upgrade'] ) && ! empty( $module_data['update'] ) )
            $class .= ' update';

        echo "<tr id='$id' class='$class'>";
        
        list( $columns, $hidden ) = $this->get_column_info();
        foreach ( $columns as $column_name => $column_display_name ) {
            $style = '';
            if ( in_array( $column_name, $hidden ) )
                $style = ' style="display:none;"';

            switch ( $column_name ) {
                case 'cb':
                    echo "<th scope='row' class='check-column'>$checkbox</th>";
                    break;
                case 'name':
                    echo "<td class='plugin-title'$style><strong>$module_name</strong>";
                    echo $this->row_actions( $actions, true );
                    echo "</td>";
                    break;
                case 'description':
                    echo "<td class='column-description desc'$style>
                        <div class='plugin-description'>$description</div>
                        <div class='$class second plugin-version-author-uri'>";

                    $plugin_meta = array();
                    if ( !empty( $module_data['Version'] ) )
                        $plugin_meta[] = sprintf( __( 'Version %s' ), $module_data['Version'] );
                    if ( !empty( $module_data['Author'] ) ) {
                        $author = $module_data['Author'];
                        if ( !empty( $module_data['AuthorURI'] ) )
                            $author = '<a href="' . $module_data['AuthorURI'] . '" title="' . esc_attr__( 'Visit author homepage' ) . '">' . $module_data['Author'] . '</a>';
                        $plugin_meta[] = sprintf( __( 'By %s' ), $author );
                    }
                    if ( ! empty( $module_data['PluginURI'] ) )
                        $plugin_meta[] = '<a href="' . $module_data['PluginURI'] . '" title="' . esc_attr__( 'Visit plugin site' ) . '">' . __( 'Visit plugin site' ) . '</a>';

                    $plugin_meta = apply_filters( 'plugin_row_meta', $plugin_meta, $module_file, $module_data, $status );
                    echo implode( ' | ', $plugin_meta );

                    echo "</div></td>";
                    break;
                default:
                    echo "<td class='$column_name column-$column_name'$style>";
                    do_action( 'manage_plugins_custom_column', $column_name, $module_file, $module_data );
                    echo "</td>";
            }
        }

        echo "</tr>";
    }
}