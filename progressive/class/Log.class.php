<?php

class Log {

	public static function debug($location, $message, $type = 'log') {
		Log::logAtLevel(2, $location, $message, $type);
	}

	public static function info($location, $message, $type = 'log') {
		Log::logAtLevel(4, $location, $message, $type);
	}

	public static function warn($location, $message, $type = 'log') {
		Log::logAtLevel(6, $location, $message, $type);
	}

	public static function error($location, $message, $type = 'log') {
		Log::logAtLevel(8, $location, $message, $type);
	}

	public static function fatal($location, $message, $type = 'log') {
		Log::logAtLevel(10, $location, $message, $type);
	}

	public static function logAtLevel($level, $location, $message, $type = 'log') {
		if ($type === 'log') {
			Progressive::log($level, $location, $message);
		} else {
			if (Progressive::getInstance()->hasSetting($type . 'loglevel')) {
				if ($level < Progressive::getInstance()->getSetting($type . 'loglevel')) {
					return;
				}
			}
			$levelname = $level;
			if (Progressive::getInstance()->hasSetting($type . 'loglevels')) {
				$levelname = decode($level, Progressive::getInstance()->getSetting($type . 'loglevels'), $level);
			}
			Progressive::getInstance()->writeLogType($levelname, $location, $message, $type);
		}
	}
}