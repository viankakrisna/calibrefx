<?php
/**
 * Calibrefx List Table Class
 */

if ( ! class_exists( 'WP_List_Table' ) ) :
	require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
endif;

class CFX_List_Table extends WP_List_Table {

	/**
	 * Define our columns header
	 *
	 * @var array
	 */
	protected $_columns;

	/**
	 * Default settings
	 *
	 * @var array
	 */
	protected $_default;

	/**
	 * Class settings
	 *
	 * @var array
	 */
	protected $_settings;

	/**
	 * Constructor
	 */
	public function __construct( $columns = array(), $settings = array() ) {
		$this->_columns = $columns;

		$this->_default = array(
			'items_per_page' => 5,
			'singular'  => 'item',     //singular name of the listed records
			'plural'    => 'items',
			'ajax'  => false,
		);

		$this->_settings = $settings + $this->_default;

		//Set parent defaults
		parent::__construct( $this->_settings );
	}

	/**
	 * If columns is not defined
	 *
	 * @param type $item
	 * @param type $column_name
	 * @return mixed
	 */
	function column_default( $item, $column_name) {
		return $item[$column_name];
	}

	/**
	 * Set columns
	 *
	 * @param type $columns
	 */
	function set_columns( $columns = array() ) {
		$this->_columns = $columns;
	}

	/**
	 * Get columns
	 * this will be use by WP_List_Table
	 *
	 * @return type
	 */
	function get_columns() {
		return $this->_columns;
	}

	/**
	 * Get the shortable columns
	 *
	 * @return type
	 */
	function get_sortable_columns( $sortable_columns = array() ) {
		return $sortable_columns;
	}

	/**
	 * Return the bulk actions data
	 *
	 * @return array
	 */
	function get_bulk_actions( $actions = array() ) {
		return $actions;
	}

	/**
	 * Process bulk actions
	 * will override in child class
	 */
	function process_bulk_action() {}

	/**
	 * This will get all the data from the database
	 * will filtered and sorted
	 *
	 * This will override in child class
	 *
	 * @param type $filter
	 * @param type $order_by
	 * @param type $order_type
	 * @param type $page
	 * @param type $limit
	 */
	function get_data( $filter = '', $order_by = 'ID', $order_type = 'ASC',  $page = 0, $limit = 20) {return null;}

	/**
	 * Count max data
	 * Will override in child class
	 * @param string $filter
	 */
	function count_data( $filter = '' ) {return null;}

	/**
	 * Prepare the items to show in display() function
	 */
	function prepare_items() {

		/**
		 * First, lets decide how many records per page to show
		 */
		$per_page = $this->_settings['items_per_page'];

		$columns = $this->get_columns();
		$hidden = array();
		$sortable = $this->get_sortable_columns();

		$this->_column_headers = array( $columns, $hidden, $sortable);
		$this->process_bulk_action();

		$orderby = ( ! empty( $_REQUEST['orderby']) ) ? $_REQUEST['orderby'] : $this->_settings['orderby']; //If no sort, default to title
		$order = ( ! empty( $_REQUEST['order']) ) ? $_REQUEST['order'] : $this->_settings['order']; //If no order, default to asc
		$current_page = $this->get_pagenum();
		$search = ( ! empty( $_REQUEST['s']) ) ? $_REQUEST['s'] : '';

		$data = $this->get_data( $search, $orderby, $order, $current_page, $per_page );

		$total_items = $this->count_data( $search );

		$this->items = $data;

		$this->set_pagination_args(array(
			'total_items' => $total_items, //WE have to calculate the total number of items
			'per_page' => $per_page, //WE have to determine how many items to show on a page
			'total_pages' => ceil( $total_items / $per_page )   //WE have to calculate the total number of pages
		) );
	}

}