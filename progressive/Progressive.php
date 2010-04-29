<?php

require 'class/Cache.class.php';
require 'class/Router.class.php';

require 'class/Controller.class.php';

require 'helpers/utility.php';

class Progressive {

	private $settings;
	private $benchmarks = array();
	private $dbToolbox = null;
	private static $progressive;
	
	private $fromCache = false;

	/**
	 * Base of the MVC element, checks cache, gets database, gets controller
	 *
	 * @param $settings
	 * @return
	 */
	function __construct($settings) {
		Progressive::$progressive = $this;
		$this->settings = $settings;

		$url = $this->settings['url'] . '/';
		if (strlen($this->settings['pre_query_url']) != 0) {
			$url .= $this->settings['pre_query_url'] . '/';
		}
		define("BASE_URL", $url);

		if (strlen($this->settings['benchmark']) > 0) {
			Progressive::start_benchmark($this->settings['benchmark']);
		}
		$cache = new Cache($this->settings['cachetime'], $this->settings['cacheignore']);
		if ($cache->hasPage($this->settings['app'], $this->settings['cachename'], $_GET['query'])) {
			$this->fromCache = true;
			echo $cache->getPage($this->settings['app'], $this->settings['cachename'], $_GET['query']);
		} else {
			ob_start();
			$this->connectDb();
			define("SITE_PATH", $this->settings['appfolder'] . '/' . $this->settings['app']);
			$routesfile = SITE_PATH . '/routes.php';
				
			if (file_exists($routesfile)) {
				require($routesfile);
				$router = new Router(getRoutes());
				$router->route($_GET['query']);
			} else {
				echo 'no routes file found: ' . $routesfile;
			}
				
			$page = ob_get_flush();
			$cache->savePage($this->settings['app'], $this->settings['cachename'], $_GET['query'], $page);
		}
		if (strlen($this->settings['benchmark']) > 0) {
			Progressive::stop_benchmark($this->settings['benchmark']);
			Progressive::print_benchmark($this->settings['benchmark']);
		}
	}

	function getSetting($setting) {
		return $this->settings[$setting];
	}

	static function getInstance() {
		return Progressive::$progressive;
	}

	private function connectDb() {
		if (strlen($this->settings['sql']) > 0) {
			require 'lib/RedBean/redbean.inc.php';
			$this->dbToolbox = RedBean_Setup::kickstart($this->settings['sql'], $this->settings['sqluser'], $this->settings['sqlpasswd'], $this->settings['sqlfrozen']);
			require 'class/Db.class.php';
		}
	}

	private function writeLog($levelname, $location, $message) {
		if (strlen($this->settings['sql']) == 0 || $this->settings['log_to_file'] || ($this->dbToolbox == null && $this->settings['log_benchmark_cached'])) {
			if ($this->fromCache) $levelname = 'cache ' . $levelname;
			// log to file
			file_put_contents($this->settings['logfolder'] . '/' . $this->settings['app'] . ' ' . date('Y.m.d') . '.log', "# $levelname # " . date('H:i:s') . " # $location # ". $_GET['query'] . " # $message" . PHP_EOL, FILE_APPEND);
		} else {
			if ($this->dbToolbox != null) {
				// log to db
				$log = Db::dispense('log');
				$log->level = $levelname;
				$log->date = date('Y.m.d');
				$log->time = date('H:i:s');
				$log->location = $location;
				$log->query = $_GET['query'];
				$log->message = $message;
				Db::save($log);
			}
		}
	}

	// ------------------------ UTIL --------------------------------

	static function getDbToolbox() {
		return Progressive::getInstance()->dbToolbox;
	}

	static function log($level, $location, $message) {
		if ($level > Progressive::getInstance()->getSetting('loglevel')) {
			$levelname = '';
			switch ($level) {
				case 1: case 2: $levelname = 'DEBUG'; break;
				case 3: case 4: $levelname = 'INFO'; break;
				case 5: case 6: $levelname = 'WARN'; break;
				case 7: case 8: $levelname = 'ERROR'; break;
				case 9: case 10: $levelname = 'FATAL'; break;
			}
			Progressive::getInstance()->writeLog($levelname, $location, $message);
		}
	}

	// ------------------------ BENCHMARKS --------------------------------

	static function start_benchmark($name) {
		Progressive::getInstance()->benchmarks[$name]['start'] = microtime(TRUE);
	}

	static function stop_benchmark($name) {
		$progressive = Progressive::getInstance();
		$progressive->benchmarks[$name]['stop'] = microtime(TRUE);
		$progressive->benchmarks[$name]['memory'] = memory_get_usage();
		$progressive->benchmarks[$name]['time'] = $progressive->benchmarks[$name]['stop'] - $progressive->benchmarks[$name]['start'];
		if (($progressive->settings['loglevel'] % 2) == 1) {
			$progressive->writeLog('Benchmark', $name, $progressive->benchmarks[$name]['time'] . 'sec ' . $progressive->benchmarks[$name]['memory']);
		}
		return $progressive->benchmarks[$name]['time'];
	}

	static function get_benchmark_time($name) {
		return Progressive::getInstance()->benchmarks[$name]['time'];
	}

	static function get_benchmark_memory($name) {
		return Progressive::getInstance()->benchmarks[$name]['memory'];
	}

	static function print_benchmark($name) {
		echo "\n<!-- " . $name . ': ' . Progressive::get_benchmark_time($name) . 'sec ' . Progressive::get_benchmark_memory($name) . ' -->';
	}

}
