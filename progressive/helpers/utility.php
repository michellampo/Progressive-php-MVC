<?php

function error_404() {
	header("HTTP/1.0 404 Not Found");
	include_once(SITE_PATH .'/views/404.php');
	exit;
}

function startsWith($Haystack, $Needle){
    return strpos($Haystack, $Needle) === 0;
}

function requiresHelpers($helpers) {
	foreach ($helpers as $helper) {
		require_once dirname(__FILE__) . '/' . $helper . '.php';
	}
}