<?php

require('RntAuthorisation.php');
require('RntSession.php');

class RntUsers {

	private $session;
	private $auth;

	private $message;

	private $isLogin;
	private $isAdmin;


	public function __construct() {

		try {
			$this->session = new RntSession();
			$this->auth = new RntAuthorisation();

			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				switch($_POST['type']) {

					case 'login':
						if(empty($_POST['user'])) throw new Exception("Brak nazwy użytkownika.");
						if(empty($_POST['pass'])) throw new Exception("Brak hasła.");
						$this->session->login($this->auth->getUserId($_POST['user'], $_POST['pass']));
						break;

					case 'logout':
						$this->session->logout();
						break;
				}
			}

			$this->isLogin = $this->session->isLogin();

		} catch(Exception $e) {
			throw new Exception($e->getMessage());
		}

	}

	public function isLogin() {
		return $this->isLogin;
	}

	public function isAdmin() {
		return $this->isAdmin;
	}

	public function getMessage() {
		return $this->message;
	}

}

?>
