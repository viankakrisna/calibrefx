<?php
/**
 * Calibrefx Notification Class
 *
 */

class CFX_Notification {

	protected $_message;

	/**
	 * Initialize Logging class
	 *
	 * @return	void
	 */
	public function __construct() {
		$this->_message = array();
	}

	public function set_flashmessage( $message, $status = 'success' ) {
		if ( ! session_id() ) {
			session_start();
		}

		if ( ! empty( $_SESSION['flashmsg']) ) {
			$this->_message = $_SESSION['flashmsg'];
		}

		$this->_message[] = array(
			'message' => $message,
			'status' => $status
		);

		$_SESSION['flashmsg'] = $this->_message;

		return $this->_message;
	}

	public function show_flashmessage() {
		if ( empty( $_SESSION['flashmsg'] ) ) { return; }

		$this->_message = $_SESSION['flashmsg'];

		foreach ( $this->_message as $msg ) {
			printf( "<p class='notification bg-%s'>%s</p>", $msg['status'], $msg['message'] );
		}

		unset( $_SESSION['flashmsg'] );
	}
}