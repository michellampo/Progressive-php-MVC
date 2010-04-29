<?php

class Db {
	
	private static function getDbToolbox() {
		return Progressive::getDbToolbox();
	}
	
	public static function dispense($beanname) {
		return Db::getDbToolbox()->getRedBean()->dispense($beanname);
	}
	
	public static function save($bean, $loglevel = 4) {
		$id = Db::getDbToolbox()->getRedBean()->store($bean);
		if ($bean->getMeta('type') != 'log') 
			Progressive::log($loglevel, 'DB Save', $bean->getMeta('type') . '@' . $id);
		return $id;
	}
	
	public static function load($beanname, $id, $loglevel = 4) {
		$bean =  Db::getDbToolbox()->getRedBean()->load($beanname, $id);
		Progressive::log($loglevel, 'DB Load', $bean->getMeta('type') . '@' . $id);
		return $bean;
	}
	
	public static function delete($bean, $loglevel = 4) {
		Progressive::log($loglevel, 'DB Delete', $bean->getMeta('type') . '@' . $bean->id);
		Db::getDbToolbox()->getRedBean()->trash($bean);
	}
	
	public static function saveSetting($setting, $value) {
		$adapter = Db::getDbToolbox()->getDatabaseAdapter();
		$settingid = '';
		try {
			$settingid = $adapter->getCell('select id from setting where `key` = :key', array(':key' => $setting));
		} catch (Exception $e) {}
		$settingBean = null;
		if ($settingid == '') {
			$settingBean = Db::getDbToolbox()->getRedBean()->dispense('setting');
			$settingBean->key = $setting;
		} else {
			$settingBean = Db::getDbToolbox()->getRedBean()->load('setting', $settingid);
		}
		$settingBean->value = $value;
		Db::getDbToolbox()->getRedBean()->store($settingBean);
		Progressive::log(4, 'DB Save setting', $setting . ' = ' . $value);
	}
	
	public static function getSetting($setting, $defaultvalue = '') {
		$adapter = Db::getDbToolbox()->getDatabaseAdapter();
		$settingid = '';
		try {
			$settingid = $adapter->getCell('select id from setting where `key` = :key', array(':key' => $setting));
		} catch (Exception $e) {}
		if ($settingid == '') {
			Progressive::log(4, 'DB Get setting', 'Not found : '. $setting . ' : ' . $defaultvalue);
			return $defaultvalue;
		} else {
			$settingBean = Db::getDbToolbox()->getRedBean()->load('setting', $settingid);
			Progressive::log(4, 'DB Get setting',  $setting . ' = ' . $settingBean->value);
			return $settingBean->value;
		}
	}
	
	
	
}