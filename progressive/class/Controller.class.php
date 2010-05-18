<?php
abstract class Controller {

	public $parameters = array();
	public $models = array();
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
	
	function loadModel($modelclass, $modelname = null) {
		if (is_null($modelname)) {
			$modelname = $modelclass;
		}
		
		$appfolder =  Progressive::getInstance()->getSetting('appfolder');
		$app =  Progressive::getInstance()->getSetting('app');
		require_once "$appfolder/$app/models/$modelclass.php";
		
		$fullclassname = $modelclass . '_model';
		$this->models[$modelname] = new $fullclassname();
		$this->$modelname = new $fullclassname();
	}
	
	function redirect($class, $action = 'index') {
		$controller_class = $class. '_controller';
		require_once "$appfolder/$app/controllers/$controller_class.php";
		$controller = new $controller_class();
		$controller->controller = $class;
		$controller->parameters = $this->parameters;
		Log::debug('Controller redirect', 'Redirected to : ' . $class . ' - ' . $action , 'access');
		$controller->$action();
	}

}