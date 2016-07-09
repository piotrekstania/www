<?php

class RntSession {

	public function __construct() {
		session_start();
	}

	public function isLogin() {

		if (!isset($_SESSION['init'])) {
			session_regenerate_id();
			$_SESSION['init'] = true;
			$_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
		}

		//niezgodnosc ip, automatyczne wylogowanie
		if($_SESSION['ip'] != $_SERVER['REMOTE_ADDR']) {
			$_SESSION = array();
			return false;
		}

		//pierwsza wizyta niezalogowanego uzytkownia
		if(!isset($_SESSION['id'])) {
			$_SESSION['id'] = 0;
		}

		//kolejna wizyta niezalogowanego uzytkownika
		if($_SESSION['id'] == 0) {
			return false;
		}

		$_SESSION['time'] = time();
		return true;
	}

	//logowanie
	public function login($_id) {

		session_regenerate_id();

		$_SESSION['init'] = true;
		$_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
		$_SESSION['id'] = $_id;
		$_SESSION['time'] = time();

		return true;
	}

	//wylogowyanie
	public function logout() {
		$_SESSION = array();
	}


	public function getID() {
		if(isset($_SESSION['id'])) return $_SESSION['id'];
		else throw new Exception("Brak ID sesji.");
	}

}
?>
