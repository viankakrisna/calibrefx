<?php
/**
 * CalibreFx
 *
 * WordPress Themes Framework by CalibreFx Team
 *
 * @package		CalibreFx
 * @author		CalibreFx Team
 * @copyright   Copyright (c) 2012, Suntech Inti Perkasa.
 * @license		GNU/GPL v2
 * @link		http://www.calibrefx.com
 * @since		Version 1.1.2
 * @filesource 
 *
 * WARNING: This file is part of the core CalibreFx framework. DO NOT edit
 * this file under any circumstances. 
 *
 * This File will handle theme-settings and provide default settings
 *
 * @package CalibreFx
 */

/**
 * Calibrefx Notification Class
 *
 * @package		Calibrefx
 * @subpackage  Library
 * @author		CalibreFx Team
 * @since		Version 1.1.2
 * @link		http://www.calibrefx.com
 */

class CFX_Notification {


	protected $_message;

    /**
     * Initialize Logging class
     *
     * @return	void
     */
    public function __construct() {        
        if( !session_id() ){
    		session_start();
		}
		$this->_message = array();
    }

    public function set_flashmessage($message, $status = 'success'){
    	if(!empty($_SESSION['flashmsg'])){
    		$this->_message = $_SESSION['flashmsg'];
    	}

		$this->_message[] = array(
			'message' => $message,
			'status' => $status
		);

		$_SESSION['flashmsg'] = $this->_message;

		return $this->_message;
    }

    public function show_flashmessage(){
    	if(empty($_SESSION['flashmsg'])) return;
    		
    	$this->_message = $_SESSION['flashmsg'];

    	foreach ($this->_message as $msg) {
    		printf("<p class='notification bg-%s'>%s</p>", $msg['status'], $msg['message']);
    	}

    	unset($_SESSION['flashmsg']);
    }
}