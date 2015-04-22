<?php

class WP_Test_Calibrefx extends WP_UnitTestCase {

	/**
	 * @author ivankristianto
	 * @covers Calibrefx::init
	 * @since 2.0
	 */
	public function test_get_instance() {
		$this->assertInstanceOf( 'Calibrefx', Calibrefx::get_instance() );
	}

	/**
	 * @author ivankristianto
	 * @covers Calibrefx::theme_support
	 * @since 2.0
	 */
	public function test_theme_support() {

		$calibrefx = Calibrefx::get_instance();

		$this->assertTrue( current_theme_supports( 'custom-header' ) );
		$this->assertTrue( current_theme_supports( 'calibrefx-custom-background' ) );
		$this->assertTrue( current_theme_supports( 'calibrefx-default-styles' ) );
		$this->assertTrue( current_theme_supports( 'calibrefx-inpost-layouts' ) );
		$this->assertTrue( current_theme_supports( 'calibrefx-responsive-style' ) );
		$this->assertTrue( current_theme_supports( 'calibrefx-footer-widgets' ) );
		$this->assertTrue( current_theme_supports( 'calibrefx-header-right-widgets' ) );
	}

	/**
	 * @author ivankristianto
	 * @covers Calibrefx::admin_url
	 * @since 2.0
	 */
	public function test_admin_url() {

		$test_admin_url = Calibrefx::admin_url( );
		$this->assertEquals( admin_url( 'admin.php?page=calibrefx' ), $test_admin_url );
	}

	/**
	 * @author ivankristianto
	 * @covers Calibrefx::get_available_modules
	 * @since 2.0
	 */
	public function test_get_available_modules() {

		$available_modules = Calibrefx::get_available_modules();

		$this->assertContains( 'custom-fonts', $available_modules );
		$this->assertContains( 'debugging', $available_modules );
	}

	/**
	 * @author ivankristianto
	 * @covers Calibrefx::get_module_slug
	 * @since 2.0
	 */
	public function test_get_module_slug() {

		$module_test_path = CALIBREFX_MODULE_URI . '/custom-fonts.php';

		$module_slug = Calibrefx::get_module_slug( $module_test_path );

		$this->assertEquals( 'custom-fonts', $module_slug );
	}

	/**
	 * @author ivankristianto
	 * @covers Calibrefx::get_module_path
	 * @since 2.0
	 */
	public function test_get_module_path() {

		$module_test = CALIBREFX_MODULE_URI . '/custom-fonts.php';

		$module = Calibrefx::get_module_path( 'custom-fonts' );

		$this->assertEquals( $module_test, $module );
	}

	/**
	 * @author ivankristianto
	 * @covers Calibrefx::get_module
	 * @since 2.0
	 */
	public function test_get_module() {

		$module = Calibrefx::get_module( 'custom-fonts' );

		$this->assertTrue( is_array( $module ) );
		$this->assertEquals( 'Custom Fonts', $module['name'] );
	}

	/**
	 * @author ivankristianto
	 * @covers Calibrefx::activate_module
	 * @since 2.0
	 */
	public function test_activate_deactivate_module() {

		Calibrefx::activate_module( 'custom-fonts', false, false );
		$this->assertTrue( Calibrefx::is_module_active( 'custom-fonts' ) );

		Calibrefx::deactivate_module( 'custom-fonts' );
		$this->assertTrue( ! Calibrefx::is_module_active( 'custom-fonts' ) );
	}
}