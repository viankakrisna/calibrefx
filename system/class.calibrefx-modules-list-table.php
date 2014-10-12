<?php

if ( ! class_exists( 'WP_List_Table' ) )
	require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';

class Calibrefx_Modules_List_Table extends WP_List_Table {

	/**
     * Singleton
     *
     * @var	object
     */
    protected static $instance;
    
	function __construct() {
		parent::__construct();

		$this->items = $this->all_items = $this->get_modules();
		$this->items = apply_filters( 'calibrefx_modules_list_table_items', $this->items );
		$this->_column_headers = array( $this->get_columns(), array(), array() );

	}

	/**
     * Return the Calibrefx object
     *
     * @return  object
     */
    public static function get_instance() {
        if( ! self::$instance ){
            self::$instance = new Calibrefx_Modules_List_Table();
        }
        
        return self::$instance;
    }

	function get_views() {
		return array();
	}

	function views() {
		$views = $this->get_views();
		echo "<ul class='subsubsub'>\n";
		foreach ( $views as $class => $view ) {
			$views[ $class ] = "\t<li class='$class'>$view</li>";
		}
		echo implode( "\n", $views ) . "\n";
		echo "</ul>";
	}

	function get_columns() {
		$columns = array(
			'cb'          => '<input type="checkbox" />',
			'name'        => __( 'Name', 'calibrefx' ),
		);
		return $columns;
	}

	function get_bulk_actions() {
		$actions = array(
			'bulk-activate'   => __( 'Activate',   'calibrefx' ),
			'bulk-deactivate' => __( 'Deactivate', 'calibrefx' ),
		);
		return $actions;
	}

	function single_row( $item ) {
		static $i = 0;
		$row_class = ( ++$i % 2 ) ? ' alternate' : '';

		if ( ! empty( $item['activated'] )  )
			$row_class .= ' active';

		if ( ! $this->is_module_available( $item ) )
			$row_class .= ' unavailable';

		echo '<tr class="calibrefx-module' . esc_attr( $row_class ) . '" id="' . esc_attr( $item['module'] ) . '">';
		$this->single_row_columns( $item );
		echo '</tr>';
	}

	function get_table_classes() {
		return array( 'table', 'table-bordered', 'wp-list-table', 'widefat', 'fixed', 'calibrefx-modules' );
	}

	function column_cb( $item ) {
		if ( ! $this->is_module_available( $item ) )
			return '';

		return sprintf( '<input type="checkbox" name="modules[]" value="%s" />', $item['module'] );
	}

	function column_name( $item ) {
		$actions = array(
		);

		if ( ! empty( $item['configurable'] ) ) {
			$actions['configure'] = $item['configurable'];
		}

		if ( empty( $item['activated'] ) && $this->is_module_available( $item ) ) {
			$url = wp_nonce_url(
				Calibrefx::admin_url( array(
					'page'   => 'calibrefx-modules',
					'action' => 'activate',
					'module' => $item['module'],
				) ),
				'calibrefx_activate-' . $item['module']
			);
			$actions['activate'] = sprintf( '<a href="%s">%s</a>', esc_url( $url ), esc_html__( 'Activate', 'calibrefx' ) );
		} elseif ( ! empty( $item['activated'] ) ) {
			$url = wp_nonce_url(
				Calibrefx::admin_url( array(
					'page'   => 'calibrefx-modules',
					'action' => 'deactivate',
					'module' => $item['module'],
				) ),
				'calibrefx_deactivate-' . $item['module']
			);
			$actions['delete'] = sprintf( '<a href="%s">%s</a>', esc_url( $url ), esc_html__( 'Deactivate', 'calibrefx' ) );
		}

		$description = sprintf( '<span class="description">%s</span>', $item['description'] );
		$title = sprintf( '<span class="info">%s</span>', $item['name'] );
		return wptexturize( $title ) . ' : ' . $description . $this->row_actions( $actions );
	}

	function column_module_tags( $item ) {
		$module_tags = array();
		foreach( $item['module_tags'] as $module_tag ) {
			$module_tags[] = sprintf( '<a href="%3$s" data-title="%2$s">%1$s</a>', esc_html( $module_tag ), esc_attr( $module_tag ), add_query_arg( 'module_tag', urlencode( $module_tag ) ) );
		}
		return implode( ', ', $module_tags );
	}

	function column_default( $item, $column_name ) {
		switch ( $column_name ) {
			case 'icon':
			case 'name':
			case 'description':
				break;
			default:
				return print_r( $item, true );
		}
	}

	function get_modules(){
        $available_modules = Calibrefx::get_available_modules();
		$active_modules    = Calibrefx::get_active_modules();

        $modules           = array();
        foreach ( $available_modules as $module ) {
        	if ( $module_array = Calibrefx::get_module( $module ) ) {
        		
        		$module_array['module']            = $module;
        		$module_array['activated']         = in_array( $module, $active_modules );
				$module_array['deactivate_nonce']  = wp_create_nonce( 'calibrefx_deactivate-' . $module );
				$module_array['activate_nonce']    = wp_create_nonce( 'calibrefx_activate-' . $module );
				$module_array['available']         = $this->is_module_available( $module_array );
				// $module_array['short_description'] = $short_desc_trunc;
				// $module_array['configure_url']     = Calibrefx::module_configuration_url( $module );

        		$modules[ $module ] = $module_array;
        	}
        }

        return $modules;
    }

    function is_module_available( $module ) {
		if ( ! is_array( $module ) || empty( $module ) )
			return false;

		return ! ( $module['requires_connection'] );
	}
}