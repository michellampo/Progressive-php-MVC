<?php

class log_controller extends SecureController {
	
	public function index() {
		$this->loadModel('logfile');
		$apps = array();
		$logs = null;
		
		$activeapp = null;
		
		foreach (Progressive::getAppSetting('loglocations') as $location => $dir) {
			$apps[$location] = array();
			$locationapps = $this->logfile->getApplications($dir);
			
			foreach ($locationapps as $app) {
				if ($activeapp == null) {
					$activeapp = $app;
					$logs = $this->logfile->getLogsForApplication($dir, $app);
				}
				$apps[$location][] = $app;
			}
		}
		$this->view('logview', array('apps' => $apps, 'activeapp' => $activeapp, 'logsforapp' => $logs));
	}
	
	public function hasPermission() {
		return true;
	}
	
}