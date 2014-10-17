<?php

// Extend with a public constructor so that can be mocked in tests
class MockJetpack extends Calibrefx {
	public function __construct() {
	}
}

class WP_Test_Calibrefx extends WP_UnitTestCase {
	/**
	 * @author ivankristianto
	 * @covers Calibrefx::init
	 * @since 2.3.3
	 */
	public function test_get_instance() {
		$this->assertInstanceOf( 'Calibrefx', Calibrefx::get_instance() );
	}
}