<?php

class auth_controller extends AuthController {
	
	/**
	 * override to have your own design and login form
	 * Needs to echo the a page with form to the user
	 * @return void
	 */
//	function loginform($actionurl) {
		// only used with form auth
//	}

	/**
	 * Will be called to check the validity of the user when using 'Form' authentication
	 *
	 * @param array with key/value pairs. Where the keys are the same as given with method getFormFieldsNames
	 * @return true/false whether the authentication was succesful
	 */
	function authenticateForm($array) {
		// only used with form auth
	}

	/**
	 * Will be called to check the validity of the user when using 'Basic' authentication
	 *
	 * @param $login entered by the user
	 * @param $password entered by the user
	 * @return true/false whether the authentication was succesful
	 */
	function authenticate($login, $password) {
		if ($login == 'michel' && $login == $password) return 1;
		return 0;
	}

	/**
	 *
	 * @return 'Basic' or 'Form'
	 */
	function getAuthenticationMethod() {
		return 'Basic';
	}

	/**
	 *
	 * @return array with key/value pairs where the values equal the names of the corresponding fields.
	 * The values are replaced by the values given by the user and sent to 'authenticateForm'
	 */
	function getFormFieldsNames() {
		// only used with form auth
	}

	/**
	 *
	 * @return true/false. True if it requires https
	 */
	function requireSSL() {
		return true;
	}
	
	/**
	 * 
	 * @return string with url of page where the user needs to be redirected to after succesfull login
	 */
	function loginSuccesfullUrl() {
		return BASE_URL . 'log';
	}
	
	/**
	 * 
	 * @return string with url of page where the user needs to be redirected to after failed login
	 */
	function loginFailedUrl() {
		return BASE_URL;
	}

//	function preLoginHook() {}
//	function postLoginHook() {}

//	function preLogoutHook() {}
	
	/**
	 * use this if you want to redirect the user of loggin out, otherwise the user gets a blank page
	 * @return void
	 */
	function postLogoutHook() {
		header('Location: ' . BASE_URL);
	}
	
}