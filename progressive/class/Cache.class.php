<?php

class Cache {

	private $cacheignores;
	private $timeout;

	function __construct($timeout, $cacheignore) {
		$this->cacheignores = explode(',', $cacheignore);
		$this->timeout = $timeout;
	}

	public function hasPage($app, $cachename, $query) {
		if (!$this->needsCache($cachename, $query)) return false;
		$filename = $this->getFilename($app, $cachename, $query);
		//check if the cache is ok to use (exists and not expired)
		if (file_exists($filename)) {
			//check the data the cache was saved
			$last_modified = filemtime($filename);
			if ($last_modified > time() - $this->timeout ) {
				return true;
			} else {
				//cache has expired so delete it
				unlink($filename);
			}
		}
	}

	public function savePage($app, $cachename, $query, $page) {
		if (!$this->needsCache($cachename, $query)) return;
		$filename = $this->getFilename($app, $cachename, $query);
		$fh = fopen($filename, 'w');
        fwrite($fh, $page);
        fclose($fh);
	}

	public function getPage($app, $cachename, $query) {
		if (!$this->needsCache($cachename, $query)) return '';
		$filename = $this->getFilename($app, $cachename, $query);
		//check if the cache is ok to use (exists and not expired)
		if (file_exists($filename)) {
			//check the data the cache was saved
			$last_modified = filemtime($filename);
			if ($last_modified > time() - $this->timeout ) {
				//display what is in the cache file
				print file_get_contents($filename);
			}
		}
	}

	private function needsCache($cachename, $query) {
		if (strlen($cachename) == 0) return false;
		foreach ($this->cacheignores as $ignore) {
			if (startsWith($query, $ignore)) return false;
		}
		return true;
	}

	private function getFilename($app, $cachename, $query) {
		$cachefolder = Progressive::getInstance()->getSetting('cachefolder');
		$query = str_replace(array('/', '_'), '-', $query);
		return "$cachefolder/" . strtolower("$cachename-$app-$query.cache");
	}

}