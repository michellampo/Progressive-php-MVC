<?php

class taconite_controller extends Controller {
	
	public function index() {
		if (isset($this->parameters['page'])) {
	//		Db::saveSetting('page', $this->parameters['page']);
	/*		$namebean = Db::dispense('names');
			$namebean->name = $this->parameters['name'];
			Db::save($namebean); */
			$this->view('page', array('title' => $this->parameters['page']));
		} else {
	//		$setting = Db::getSetting('page', 'no val');
			$this->view('page', array('title' => 'Index'));
		}
	}
	
	public function reindex() {
		$log = $this->parameters['log'];
		$this->view('reindex', array('log' => $log));
	}
	
}