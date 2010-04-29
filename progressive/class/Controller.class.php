<?php
abstract class Controller {

	public $parameters = array();
	public $controller;

	function __construct() {}
	
	function view($viewname, $data = array(), $getText = false) {
		$appfolder =  Progressive::getInstance()->getSetting('appfolder');
		$app =  Progressive::getInstance()->getSetting('app');
		foreach ($data as $key => $value) {
  			// initialize the variables as global
   			global $$key;
   			$$key = $value;
		}
		if ($getText) ob_start();
		include "$appfolder/$app/views/" . $this->controller . "/$viewname.php";
		if ($getText) return ob_get_clean();
	}

}