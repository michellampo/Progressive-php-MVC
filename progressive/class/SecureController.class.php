<?php

abstract class SecureController extends Controller {

	function __construct() {
		session_start();
		$permission = $this->hasPermission();
		if (permission) {
			Log::info('SecureController', 'SecureController: ' . get_class($this), 'access');
		} else {
			Log::error('SecureController', 'SecureController: ' . get_class($this), 'access');
		}
		if (!$permission) error(403);
	}
	
	abstract function hasPermission() ;

}