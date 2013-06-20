<?php

class AC_Reseller extends MailVenture {

	public $url;
	public $api_key;

	function __construct($url, $api_key) {
		$this->url = $url;
		$this->api_key = $api_key;
	}

	function add($params, $post_data) {
		$request_url = "{$this->url}&api_action=account_add&api_output={$this->output}";
		if ($params) $request_url .= "&{$params}";
		$response = $this->curl($request_url, $post_data);
		return $response;
	}

	function cancel($params) {
		$request_url = "{$this->url}&api_action=account_cancel&api_output={$this->output}&{$params}";
		var_dump($request_url);
		$response = $this->curl($request_url);
		return $response;
	}

	function status($params, $post_data) {
		$request_url = "{$this->url}&api_action=account_status&api_output={$this->output}&{$params}";
		$response = $this->curl($request_url, $post_data);
		return $response;
	}

	function name_check($params, $post_data) {
		$request_url = "{$this->url}&api_action=account_name_check&api_output={$this->output}&{$params}";
		$response = $this->curl($request_url, $post_data);
		return $response;
	}

	function plan($params, $post_data) {
		$request_url = "{$this->url}&api_action=account_plans&api_output={$this->output}&{$params}";
		$response = $this->curl($request_url, $post_data);
		return $response;
	}

	function list_($params, $post_data) {
		$request_url = "{$this->url}&api_action=account_list&api_output={$this->output}&{$params}";
		$response = $this->curl($request_url, $post_data);
		return $response;
	}
}
