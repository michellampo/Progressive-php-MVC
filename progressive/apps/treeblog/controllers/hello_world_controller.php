<?php

class hello_world_controller extends Controller {
	
	public function index() {
		if (isset($this->parameters['name'])) {
			echo 'hello ' . $this->parameters['name'];
		} else {
			echo 'hello world';
		}
	}
	
}