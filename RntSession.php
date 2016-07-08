<?php

require('RntAuthorisation.php');

class RntSession {

	//sciezka i nazwa bazy danych
	private $db_dir = "baza.db";
	//nazwa tablicy bazy danch z informacjami o uzytkownikach
	private $db_table_users = "users";
	//domyslna nazwa admina w przypadku tworzenia nowej bazy
	private $db_admin_user = "admin";
	//domyslne haslo admina w przypadku tworzenia nowej bazy
	private $db_admin_pass = "admin";
	//domyslny czas sesji w przypadku tworzenia nowej bazy (sekundy)
	private $db_session_time = 60;


	private $message;
	private $auth;


	private function killSession() {
		$_SESSION = array();
		session_destroy();
	}

	public function isLogin() {

		$this->auth = new RntAuthorisation();

		if(!$this->auth->init($this->db_dir, $this->db_table_users, $this->db_admin_user, $this->db_admin_pass, $this->db_session_time)) {
			$this->message = $this->auth->getError();
			return false;
		}

		session_start();

		if (!isset($_SESSION['init'])) {
			session_regenerate_id();
			$_SESSION['init'] = true;
			$_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
		}

		//niezgodnosc ip, automatyczne wylogowanie
		if($_SESSION['ip'] != $_SERVER['REMOTE_ADDR']) {
			$this->message = "Niezgodność IP. Zaloguj się ponownie.";
			$this->killSession();
			return false;
		}

		//pierwsza wizyta niezalogowanego uzytkownia
		if(!isset($_SESSION['id'])) {
			$_SESSION['id'] = 0;
		}

		//logowanie/wylogowywyanie
		if($_SERVER['REQUEST_METHOD'] == 'POST') {

			//wylogowywanie
			if(isset($_POST['logout'])) {
				$this->message = "Poprawne wylogowanie.";
				$this->killSession();
				return false;
			}

			//logowanie
			if(isset($_POST['login']) && isset($_POST['pass'])) {

				$id = $this->auth->getUserId($_POST['login'], $_POST['pass']);

				if(!$id) {
					$this->message = $this->auth->getError();
					return false;
				}

				//zalogowany poprawnie
				$_SESSION['id'] = $id;
				$_SESSION['time'] = time();
			}
		}

		//kolejna wizyta niezalogowanego uzytkownika
		if($_SESSION['id'] == 0) {
			$this->message = "Użytkownik niezalogowany.";
			return false;
		}

		//uplynal czas sesji, automatyczne wylogowanie
		if($session_time = $this->auth->getUserSessionTime($_SESSION['id'])) {
			if($_SESSION['time'] < (time()-$session_time)) {
				$this->message = "Sesja wygasła. Zaloguj się ponownie.";
				$this->killSession();
				return false;
			}
		}

		$this->message = "Zalogowany jako " . $this->getUserName();
		$_SESSION['time'] = time();

		return true;
	}

	public function getUserName() {
		if(isset($this->auth) && isset($_SESSION['id'])) return $this->auth->getUserName($_SESSION['id']);
		return false;
	}

	public function getMessage() {
		return $this->message;
	}

	public function isAdmin() {
		if(isset($_SESSION['id']) && isset($this->auth)) {
			if(($_SESSION['id'] == 1) && ($this->auth->getUserName($_SESSION['id']) == $this->db_admin_user)) return true;
		}
		return false;
	}

}
?>
