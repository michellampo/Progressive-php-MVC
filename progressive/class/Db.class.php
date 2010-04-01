<?php

class Db {
	
	private static function getDbToolbox() {
		return Progressive::getDbToolbox();
	}
	
	static function dispense($beanname) {
		return Db::getDbToolbox()->getRedBean()->dispense($beanname);
	}
	
	static function save($bean) {
		return Db::getDbToolbox()->getRedBean()->store($bean);
	}
	
	
	
}