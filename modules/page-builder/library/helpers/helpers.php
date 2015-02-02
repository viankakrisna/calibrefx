<?php

/**
 * Helpers Loader
 */
 
$includes = glob(dirname(__FILE__).DIRECTORY_SEPARATOR.'include'.DIRECTORY_SEPARATOR.'*.php');
if($includes){
	foreach ($includes as $include) {
	    $file_name = basename($include);
		if (substr($file_name, 0, 1) !== '_' && substr($file_name, 0, 5) !== 'index') {
			include($include);
		}
	}
}

$includes = glob(dirname(__FILE__).DIRECTORY_SEPARATOR.'whitelisted'.DIRECTORY_SEPARATOR.'*.php');
if($includes){
	foreach ($includes as $include) {
	    $file_name = basename($include);
		if (substr($file_name, 0, 1) !== '_' && substr($file_name, 0, 5) !== 'index') {
			include($include);
			VP_Security::instance()->whitelist_function(basename($include, '.php'));
		}
	}
}