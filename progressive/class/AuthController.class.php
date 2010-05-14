<?php

abstract class AuthController extends Controller {

	function __construct() {
		session_start();
		if($this->requireSSL() && $_SERVER['SERVER_PORT'] != 443) {
			header('HTTP/1.1 301 Moved Permanently');
			header('Location: https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
			exit();
		}
	}

	final function index() {
		$this->login();
	}


	final function form() {
		$fields = $this->getFormFieldsNames();
		$filled = true;
		foreach ($fields as $key => $value) {
			if (!isset($_POST[$value])) {
				$filled = false;
			}
		}
		if ($filled) {
			$this->login();
		} else {
			$actionurl = 'http://' . $this->requireSSL()?'s':'' . "://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
			$this->loginform($actionurl);
		}
	}

	/**
	 * override to have your own design and login form
	 * Needs to echo the a page with form to the user
	 * @return void
	 */
	function loginform($actionurl) {
		$form = <<<FORM
<html>
  <head>
    <title>Login</title>
  </head>
  <body>
FORM;

		$form .= "<form action='$actionurl' method='post' >";

		foreach ($fields as $key => $value) {
			$form .= '<label for="' . $value . '">' . $value . '</label><input type="text" name="' . $value . '" /></br>';
		}

		$form .= <<<FORM
      <input type="submit" value="Submit" />
    </form>
  </body>
</html>
FORM;
		echo $form;
	}

	final function login() {
		$this->preLoginHook();
		$authmethod = $this->getAuthenticationMethod();
		if ( strcmp( strtolower( $authmethod ), strtolower( 'Form' ) ) == 0 ) {

		} else {
			// Basic auth
			if (!isset($_SERVER['PHP_AUTH_USER'])) {
				header('WWW-Authenticate: Basic realm="' . Progressive::getInstance()->getSetting('app') . '"');
				header('HTTP/1.0 401 Unauthorized');
				echo 'You need to log in to see this part of the application';
			} else {
				if ($this->authenticate($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']) != 0) {
					Log::info('Authcontroller', 'User logged in', 'access');
					header('Location: ' . $this->loginSuccesfullUrl());
				} else {
					Log::error('Authcontroller', 'User refused', 'access');
					header('HTTP/1.0 401 Unauthorized');
					header('Location: ' . $this->loginFailedUrl());
				}
			}
		}
		$this->postLoginHook();
	}

	final function logout() {
		$this->preLogoutHook();
		session_destroy();
		$this->postLogoutHook();
	}

	/**
	 * Will be called to check the validity of the user when using 'Form' authentication
	 *
	 * @param array with key/value pairs. Where the keys are the same as given with method getFormFieldsNames
	 * @return true/false whether the authentication was succesful
	 */
	abstract function authenticateForm($array) ;

	/**
	 * Will be called to check the validity of the user when using 'Basic' authentication
	 *
	 * @param $login entered by the user
	 * @param $password entered by the user
	 * @return 0 als user niet geldig is, anders de userid
	 */
	abstract function authenticate($login, $password) ;

	/**
	 *
	 * @return 'Basic' or 'Form'
	 */
	abstract function getAuthenticationMethod() ;

	/**
	 *
	 * @return array with key/value pairs where the values equal the names of the corresponding fields.
	 * The values are replaced by the values given by the user and sent to 'authenticateForm'
	 */
	abstract function getFormFieldsNames() ;

	/**
	 *
	 * @return true/false. True if it requires https
	 */
	abstract function requireSSL() ;

	/**
	 *
	 * @return string with url of page where the user needs to be redirected to after succesfull login
	 */
	abstract function loginSuccesfullUrl();

	/**
	 *
	 * @return string with url of page where the user needs to be redirected to after failed login
	 */
	abstract function loginFailedUrl();

	function preLoginHook() {}
	function postLoginHook() {}

	function preLogoutHook() {}

	/**
	 * use this if you want to redirect the user of loggin out, otherwise the user gets a blank page
	 * @return void
	 */
	function postLogoutHook() {}

}