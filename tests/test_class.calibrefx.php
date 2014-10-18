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

		$this->assertTrue( current_theme_supports( 'calibrefx-admin-menu' ) );
		$this->assertTrue( current_theme_supports( 'calibrefx-custom-header' ) );
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
}