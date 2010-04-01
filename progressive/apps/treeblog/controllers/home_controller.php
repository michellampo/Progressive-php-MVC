<?php

class home_controller extends Controller {
	
	public function index() {
		requiresHelpers(array('form'));
		$this->view('index', array('title' => 'Hello world!'));
	}
	
}