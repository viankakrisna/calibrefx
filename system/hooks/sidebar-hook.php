<?php

class Calibrefx_Dynamic_Sidebars {

	private $i;
	private $sidebars;

	function __construct(){

		$this->i = 0;
		$this->sidebars = apply_filters('calibrefx_dynamic_sidebars', array(

			array(
			 	'name' => 'Before Header Widget',
				'priority' => 0,
				'action' => 'calibrefx_before_header'
			),

			array(
				'name' => 'Before Footer Widget',
				'priority' => 0,
				'action' => 'calibrefx_before_footer'
			),

			array(
			 	'name' => 'Footer Widgets', //It should be 'Footer Widget', but it is conflicting with default calibrefx widget. Should be changed if merged to core.
				'priority' => 0,
				'action' => 'calibrefx_before_footer'
			),

			array(
			 	'name' => 'After Footer Widget',
				'priority' => 99,
				'action' => 'calibrefx_before_footer'
			)

		));

		add_action( 'widgets_init', array( $this, 'init' ) );

	}


	function init() {

		$sidebars = $this->sidebars;

		foreach ( $sidebars as $sidebar ) {

			$name = $sidebar['name'];
			$name = $this->slugify( $name );

			register_sidebar( array(
				'name'			=> __( $name, 'calibrefx' ),
				'id'			=> "$name-sidebar",
				'description'	=> __( "", 'calibrefx' ),
				'before_widget'	=> '<div id="%1$s" class="widget %2$s">',
				'after_widget'	=> '</div>',
				'before_title'	=> '<h4 class="widgettitle">',
				'after_title'	=> '</h4>',
			) );

			add_action($sidebar['action'], array( $this, 'print_sidebar' ), $sidebar['priority']);

		}

	}

	function print_sidebar() {

		$sidebars = $this->sidebars;

		$name = $sidebars[$this->i]['name'];
		$name = $this->slugify($name);

		$sidebar = '';
		if ( is_active_sidebar( "$name-sidebar" ) ) {
			$sidebar = $this->get_dynamic_sidebar( "$name-sidebar" );
		}
		?>
			<div id="<?php echo $name; ?>">
				<div class="container">
					<div class="row">
						<?php echo $sidebar; ?>
					</div>
				</div>
			</div>
		<?php

		$this->i++;

	}


	function get_dynamic_sidebar( $name = 1 ){

		$sidebar_contents = "";

		ob_start();
		dynamic_sidebar( $name );

		return ob_get_clean();

	}

	function slugify( $string ) {

		//Lower case everything
		$string = strtolower($string);
		//Make alphanumeric (removes all other characters)
		$string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
		//Clean up multiple dashes or whitespaces
		$string = preg_replace("/[\s-]+/", " ", $string);
		//Convert whitespaces and underscore to dash
		$string = preg_replace("/[\s_]/", "-", $string);
		return $string;
	}
}

new Calibrefx_Dynamic_Sidebars();
