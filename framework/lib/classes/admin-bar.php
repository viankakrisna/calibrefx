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
 * This file to handle calibrefx admin bar
 * based On WP_Admin_Bar but we cannot extend it since the _render is func
 *
 * @package CalibreFx
 */
 
class CalibreFx_Admin_Bar {
	private $top_nodes = array();
	private $bottom_nodes = array();
	public $user;

	public function initialize() {
		$this->user = new stdClass;
	}
	
	public function add_top_bar(){
		add_action( 'calibrefx_admin_bar_menu', 'calibrefx_admin_bar_my_account_menu', 0 );
		add_action( 'calibrefx_admin_bar_menu', 'calibrefx_admin_bar_search_menu', 4 );
		add_action( 'calibrefx_admin_bar_menu', 'calibrefx_admin_bar_my_account_item', 7 );
		
		add_action( 'calibrefx_admin_bar_menu', 'calibrefx_admin_bar_wp_menu', 10 );
		add_action( 'calibrefx_admin_bar_menu', 'calibrefx_admin_bar_site_menu', 20 );
		
		add_action( 'calibrefx_admin_bar_menu', 'calibrefx_admin_bar_add_top_groups', 200 );
	}
	
	public function add_bottom_bar(){
	}
	
	public function add_menu( $node ) {
		$this->add_node( $node );
	}

	public function remove_menu( $id ) {
		$this->remove_node( $id );
	}
	
	/**
	 * Gets a node.
	 *
	 * @return object Node.
	 */
	final public function get_node( $id ) {
		if ( $node = $this->_get_node( $id ) )
			return clone $node;
	}

	final protected function _get_node( $id ) {
		if ( $this->bound )
			return;

		if ( empty( $id ) )
			$id = 'root';

		if ( isset( $this->nodes[ $id ] ) )
			return $this->nodes[ $id ];
	}

	final public function get_nodes() {
	   if ( ! $nodes = $this->_get_nodes() )
	      return;

	   foreach ( $nodes as &$node ) {
	       $node = clone $node;
	   }
	   return $nodes;
	}

	final protected function _get_nodes() {
		if ( $this->bound )
			return;

		return $this->nodes;
	}
	
	/**
	 * Remove a node.
	 *
	 * @return object The removed node.
	 */
	public function remove_node( $id ) {
		$this->_unset_node( $id );
	}

	final protected function _unset_node( $id ) {
		unset( $this->nodes[ $id ] );
	}
	
	final public function add_group( $args ) {
		$args['group'] = true;

		$this->add_node( $args );
	}
	
	/**
	 * Add a node to the menu.
	 *
	 * @param array $args - The arguments for each node.
	 * - id         - string    - The ID of the item.
	 * - title      - string    - The title of the node.
	 * - parent     - string    - The ID of the parent node. Optional.
	 * - href       - string    - The link for the item. Optional.
	 * - group      - boolean   - If the node is a group. Optional. Default false.
	 * - meta       - array     - Meta data including the following keys: html, class, onclick, target, title, tabindex.
	 */
	public function add_node( $args ) {
		// Shim for old method signature: add_node( $parent_id, $menu_obj, $args )
		if ( func_num_args() >= 3 && is_string( func_get_arg(0) ) )
			$args = array_merge( array( 'parent' => func_get_arg(0) ), func_get_arg(2) );

		if ( is_object( $args ) )
			$args = get_object_vars( $args );

		// Ensure we have a valid title.
		if ( empty( $args['id'] ) ) {
			if ( empty( $args['title'] ) )
				return;

			_doing_it_wrong( __METHOD__, __( 'The menu ID should not be empty.' ), '3.3' );
			// Deprecated: Generate an ID from the title.
			$args['id'] = esc_attr( sanitize_title( trim( $args['title'] ) ) );
		}

		$defaults = array(
			'id'     => false,
			'title'  => false,
			'parent' => false,
			'href'   => false,
			'group'  => false,
			'meta'   => array(),
		);

		// If the node already exists, keep any data that isn't provided.
		if ( $maybe_defaults = $this->get_node( $args['id'] ) )
			$defaults = get_object_vars( $maybe_defaults );

		// Do the same for 'meta' items.
		if ( ! empty( $defaults['meta'] ) && empty( $args['meta'] ) )
			$args['meta'] = wp_parse_args( $args['meta'], $defaults['meta'] );

		$args = wp_parse_args( $args, $defaults );

		$back_compat_parents = array(
			'my-account-with-avatar' => array( 'my-account', '3.3' ),
			'my-blogs'               => array( 'my-sites',   '3.3' ),
		);

		if ( isset( $back_compat_parents[ $args['parent'] ] ) ) {
			list( $new_parent, $version ) = $back_compat_parents[ $args['parent'] ];
			_deprecated_argument( __METHOD__, $version, sprintf( 'Use <code>%s</code> as the parent for the <code>%s</code> admin bar node instead of <code>%s</code>.', $new_parent, $args['id'], $args['parent'] ) );
			$args['parent'] = $new_parent;
		}

		$this->_set_node( $args );
	}

	final protected function _set_node( $args ) {
		$this->nodes[ $args['id'] ] = (object) $args;
	}
	
	public function render(){
		$root = $this->_bind();
		if ( $root )
			$this->_render( $root );
	}
	
	final protected function _render_group( $node ) {
		if ( $node->type == 'container' )
			return $this->_render_container( $node );

		if ( $node->type != 'group' || empty( $node->children ) )
			return;

		$class = empty( $node->meta['class'] ) ? '' : $node->meta['class'];

		?><ul id="<?php echo esc_attr( 'wp-admin-bar-' . $node->id ); ?>" class="<?php echo esc_attr( $class ); ?>"><?php
			foreach ( $node->children as $item ) {
				$this->_render_item( $item );
			}
		?></ul><?php
	}

	final protected function _render_item( $node ) {
		if ( $node->type != 'item' )
			return;

		$is_parent = ! empty( $node->children );
		$has_link  = ! empty( $node->href );

		$tabindex = isset( $node->meta['tabindex'] ) ? (int) $node->meta['tabindex'] : 10;

		$menuclass = '';
		$aria_attributes = 'tabindex="' . $tabindex . '"';

		if ( $is_parent ) {
			$menuclass = 'menupop';
			$aria_attributes .= ' aria-haspopup="true"';
		}

		if ( ! empty( $node->meta['class'] ) )
			$menuclass .= ' ' . $node->meta['class'];

		?>

		<li id="<?php echo esc_attr( 'wp-admin-bar-' . $node->id ); ?>" class="<?php echo esc_attr( $menuclass ); ?>"><?php
			if ( $has_link ):
				?><a class="ab-item" <?php echo $aria_attributes; ?> href="<?php echo esc_url( $node->href ) ?>"<?php
					if ( ! empty( $node->meta['onclick'] ) ) :
						?> onclick="<?php echo esc_js( $node->meta['onclick'] ); ?>"<?php
					endif;
				if ( ! empty( $node->meta['target'] ) ) :
					?> target="<?php echo esc_attr( $node->meta['target'] ); ?>"<?php
				endif;
				if ( ! empty( $node->meta['title'] ) ) :
					?> title="<?php echo esc_attr( $node->meta['title'] ); ?>"<?php
				endif;
				?>><?php
			else:
				?><div class="ab-item ab-empty-item" <?php echo $aria_attributes;
				if ( ! empty( $node->meta['title'] ) ) :
					?> title="<?php echo esc_attr( $node->meta['title'] ); ?>"<?php
				endif;
				?>><?php
			endif;

			echo $node->title;

			if ( $has_link ) :
				?></a><?php
			else:
				?></div><?php
			endif;

			if ( $is_parent ) :
				?><div class="ab-sub-wrapper"><?php
					foreach ( $node->children as $group ) {
						$this->_render_group( $group );
					}
				?></div><?php
			endif;

			if ( ! empty( $node->meta['html'] ) )
				echo $node->meta['html'];

			?>
		</li><?php
	}

	public function recursive_render( $id, $node ) {
		_deprecated_function( __METHOD__, '3.3', 'WP_Admin_bar::render(), WP_Admin_Bar::_render_item()' );
		$this->_render_item( $node );
	}
	
	final protected function _bind() {
		// Add the root node.
		// Clear it first, just in case. Don't mess with The Root.
		$this->remove_node( 'root' );
		$this->add_node( array(
			'id'    => 'root',
			'group' => false,
		) );
		
		// Normalize nodes: define internal 'children' and 'type' properties.
		foreach ( $this->_get_nodes() as $node ) {
			$node->children = array();
			$node->type = ( $node->group ) ? 'group' : 'item';
			unset( $node->group );

			// The Root wants your orphans. No lonely items allowed.
			if ( ! $node->parent )
				$node->parent = 'root';
		}
		
		foreach ( $this->_get_nodes() as $node ) {
			if ( 'root' == $node->id )
				continue;

			// Fetch the parent node. If it isn't registered, ignore the node.
			if ( ! $parent = $this->_get_node( $node->parent ) ) {
				continue;
			}

			// Generate the group class (we distinguish between top level and other level groups).
			$group_class = ( $node->parent == 'root' ) ? 'ab-top-menu' : 'ab-submenu';

			if ( $node->type == 'group' ) {
				if ( empty( $node->meta['class'] ) )
					$node->meta['class'] = '';
				$node->meta['class'] .= ' ' . $group_class;
			}

			// Items in items aren't allowed. Wrap nested items in 'default' groups.
			if ( $parent->type == 'item' && $node->type == 'item' ) {
				$default_id = $parent->id . '-default';
				$default    = $this->_get_node( $default_id );

				// The default group is added here to allow groups that are
				// added before standard menu items to render first.
				if ( ! $default ) {
					// Use _set_node because add_node can be overloaded.
					// Make sure to specify default settings for all properties.
					$this->_set_node( array(
						'id'        => $default_id,
						'parent'    => $parent->id,
						'type'      => 'group',
						'children'  => array(),
						'meta'      => array(
							'class'     => $group_class,
						),
						'title'     => false,
						'href'      => false,
					) );
					$default = $this->_get_node( $default_id );
					$parent->children[] = $default;
				}
				$parent = $default;

			// Groups in groups aren't allowed. Add a special 'container' node.
			// The container will invisibly wrap both groups.
			} elseif ( $parent->type == 'group' && $node->type == 'group' ) {
				$container_id = $parent->id . '-container';
				$container    = $this->_get_node( $container_id );

				// We need to create a container for this group, life is sad.
				if ( ! $container ) {
					// Use _set_node because add_node can be overloaded.
					// Make sure to specify default settings for all properties.
					$this->_set_node( array(
						'id'       => $container_id,
						'type'     => 'container',
						'children' => array( $parent ),
						'parent'   => false,
						'title'    => false,
						'href'     => false,
						'meta'     => array(),
					) );

					$container = $this->_get_node( $container_id );

					// Link the container node if a grandparent node exists.
					$grandparent = $this->_get_node( $parent->parent );

					if ( $grandparent ) {
						$container->parent = $grandparent->id;

						$index = array_search( $parent, $grandparent->children, true );
						if ( $index === false )
							$grandparent->children[] = $container;
						else
							array_splice( $grandparent->children, $index, 1, array( $container ) );
					}

					$parent->parent = $container->id;
				}

				$parent = $container;
			}

			// Update the parent ID (it might have changed).
			$node->parent = $parent->id;

			// Add the node to the tree.
			$parent->children[] = $node;
		}
		
		$root = $this->_get_node( 'root' );	
		
		return $root;
	}
		
	final protected function _render( $root ) {
		global $is_IE, $is_iphone;
		
		// Add browser classes.
		// We have to do this here since admin bar shows on the front end.
		$class = 'nojq nojs';
		if ( $is_IE ) {
			if ( strpos( $_SERVER['HTTP_USER_AGENT'], 'MSIE 7' ) )
				$class .= ' ie7';
			elseif ( strpos( $_SERVER['HTTP_USER_AGENT'], 'MSIE 8' ) )
				$class .= ' ie8';
			elseif ( strpos( $_SERVER['HTTP_USER_AGENT'], 'MSIE 9' ) )
				$class .= ' ie9';
		} elseif ( $is_iphone ) {
			$class .= ' mobile';
		}
?>
		<div id="calibrefx-admin-bar-wrapper" class="<?php echo $class; ?>" role="navigation">
			<div id="calibrefx-admin-bar">
				<div id="calibrefx-admin-bar-logo">
					<a target="_blank" href="<?php echo FRAMEWORK_URL; ?>" title="'<?php echo FRAMEWORK_NAME; ?> v<?php echo FRAMEWORK_NAME; ?>">&nbsp;</a>
				</div>
				<div id="calibrefx-admin-bar-top">
					<div class="quicklinks">
<?php
					foreach ( $root->children as $group ) {
						$this->_render_group( $group );
					}
?>
					</div>
				</div>
				<div id="calibrefx-admin-bar-menu">
					
				</div>
			</div>
		</div>
<?php
	}
}