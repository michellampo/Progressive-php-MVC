<?php

class log_controller extends SecureController {
	
	public function index() {
		$this->view('logview');
	}
	
	public function hasPermission() {
		return true;
	}
	
}