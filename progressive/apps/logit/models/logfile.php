<?php

class logfile_model {
	
	public function getFiles($dir) {
		if (!endsWith($files, '/')) {
			$dir .= '/';
		}
		$files = array();
		
		if ($handle = opendir($dir)) {
			
			while (false !== ($file = readdir($handle))) {
				if (is_file($dir . $file)) {
					$files[] = $file;
				}
			}
		}
		
		closedir($handle);
		
		return $files;
	}
	
	public function getApplications($dir) {
		$files = $this->getFiles($dir);
		$apps = array();
		
		foreach ($files as $file) {
			$app = split('[/-]', $file);
			$appname = $app[count($app) - 2];
			$apps[] = $appname;
		}
		
		return array_unique($apps);
	}
	
	public function getLogsForApplication($dir, $app) {
		$files = $this->getFiles($dir);
		$logs = array();
		
		foreach ($files as $file) {
			$appnamelist = split('[/-]', $file);
			if ($appnamelist[count($appnamelist) - 2] == $app) {
				$appnamelist = split('[.]', $file);
				$log = $appnamelist[count($appnamelist) - 1];
				$logs[] = $log;
			}
		}
		
		$logs = array_unique($logs);
		sort($logs);
		return $logs;
	}
	
}