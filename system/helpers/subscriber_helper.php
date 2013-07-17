<?php
/**
 * CalibreFx Lib
 *
 * CalibreFx Plugin Libraries
 *
 * @package		calibrefxlib
 * @author		CalibreFx Dev Team
 * @copyright	Copyright (c) 2012, CalibreWorks. (http://www.calibreworks.com/)
 * @license		http://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 * @link		http://www.CalibreFx.com
 * @since		Version 1.0
 * @filesource
 */
 
/**
 * Subscriber Helper
 *
 * CalibreFx Subscriber Helper Function
 *
 * @package		calibrefxlib
 * @subpackage	Helper
 * @category	subscriber helper
 * @author		CalibreFx Dev Team
 * @link		http://www.CalibreFx.com
 */
// ------------------------------------------------------------------------


/**
 * Submit To GetResponse
 *
 * Submit name and email to form given from getresponse
 *
 * @param	string
 * @param	string 
 * @param	string
 * @return	bool
 */

include_once(CALIBREFX_LIBRARY_URI . '/third-party/GetResponseAPI.class.php');
function calibrefx_submit_getresponse($form, $name, $email, $args = array()){
	$url = '';

	$doc = new DOMDocument;

	if (!@$doc->loadhtml($form)) {
		return null;
	} else {
		$xpath = new DOMXpath($doc);

		foreach ($xpath->query('//form//input') as $eInput) {
			$data[$eInput->getAttribute('name')] = $eInput->getAttribute('value');
		}
		
		$result = $xpath->query('//form//@action');
		$url = $result->item( 0 )->nodeValue;
	}

	$data['name'] = $name;
	$data['email'] = $email;
	
	foreach($args as $key => $value){
		$data[$key] = $value;
	}

	$new_array = array_map(create_function('$key, $value', 'return $key."=".$value;'), array_keys($data), array_values($data));

	$post_data = implode("&", $new_array);
	$post_data = str_replace('\"', '', $post_data);
	
	$url = str_replace('\"', '', $url);
	calibrefx_log_message('debug', $url);
	calibrefx_log_message('debug', $post_data);
	$curl_handle = curl_init();
	curl_setopt($curl_handle, CURLOPT_URL, $url);
	curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 5);
	curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl_handle, CURLOPT_POST, 1);
	curl_setopt($curl_handle, CURLOPT_POSTFIELDS, $post_data);
	$buffer = curl_exec($curl_handle);
	calibrefx_log_message('debug', 'Return from getresponse: '.$buffer);
	curl_close($curl_handle);
	// check for success or failure
	if ($buffer)
		return true;
	else
		return false;
}

function calibrefx_getresponse_api_testing($api_key, $list_name){
	echo 'Testing Start <br/>';
	$api = new GetResponse($api_key);
	$ping = $api->ping();

	echo 'Ping: '.$ping.' <br/>';

	$campaigns 	 = (array)$api->getCampaigns('CONTAINS', $list_name);
	$campaignIDs = array_keys($campaigns);
	$campaign_id = $campaignIDs[0];

	echo 'Campaign: '.$campaign_id.' <br/>';
}

function calibrefx_submit_getresponse_api($name, $email, $api_key, $list_name, $customs = array()){
	$api = new GetResponse($api_key);
	
	$ping = $api->ping();
	
	if($ping){
		calibrefx_log_message('debug', 'Get Response Ping: '.$ping);
		
		$campaigns 	 = (array)$api->getCampaigns('CONTAINS', $list_name);
		
		if(count($campaigns) == 1){
			$campaignIDs = array_keys($campaigns);
			$campaign_id = $campaignIDs[0];
			
			$return = $api->addContact($campaign_id, $name, $email, 'standard', 0, $customs);
			
			calibrefx_log_message('debug', 'GetResponse Add Contact Success: '.debug_var($return, true));
			return $return;
		}else{
			calibrefx_log_message('debug', 'Campaign Name is not found: '.$list_name);
		}
	}else{
		calibrefx_log_message('debug', 'Get Response Ping Failed: '.$ping);
	}
	return FALSE;
}

function calibrefx_submit_aweber($form, $name, $email){
	$url = 'http://www.aweber.com/scripts/addlead.pl';

	$doc = new DOMDocument;

	if (!@$doc->loadhtml($form)) {
		return null;
	} else {
		$xpath = new DOMXpath($doc);

		foreach ($xpath->query('//form//input') as $eInput) {
			$data[$eInput->getAttribute('name')] = $eInput->getAttribute('value');
		}
	}

	$data['name'] = $name;
	$data['email'] = $email;

	$new_array = array_map(create_function('$key, $value', 'return $key."=".$value;'), array_keys($data), array_values($data));

	$post_data = implode("&", $new_array);

	$curl_handle = curl_init();
	curl_setopt($curl_handle, CURLOPT_URL, $url);
	curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
	curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl_handle, CURLOPT_POST, 1);
	curl_setopt($curl_handle, CURLOPT_POSTFIELDS, $post_data);
	$buffer = curl_exec($curl_handle);
	curl_close($curl_handle);
	// check for success or failure
	if ($buffer)
		return true;
	else
		return false;
}