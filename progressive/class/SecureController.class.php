<?php

abstract class SecureController extends Controller {

	function __construct() {
		if (!$this->hasPermission()) error(403);
	}
	
	abstract function hasPermission() ;

}