<?php

class hello_world_controller extends Controller {
	
	public function index() {
		if (isset($this->parameters['name'])) {
			Db::saveSetting('name', $this->parameters['name']);
	/*		$namebean = Db::dispense('names');
			$namebean->name = $this->parameters['name'];
			Db::save($namebean); */
			echo 'hello ' . $this->parameters['name'];
		} else {
			$settingname = Db::getSetting('name', 'no val');
			echo 'hello ' . $settingname;
		}
	}
	
}