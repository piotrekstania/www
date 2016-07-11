<?php

class RtUsers {

	private $db_dir          = "data.db";
	private $db_table_users  = "users";
	private $db_admin_user   = "admin";
	private $db_admin_pass   = "admin";

	private $session_time = 3600;

	private $message;

	function __construct() {

		session_start();

		//brak inicjalizacji -> wygenerowanie nowgo id
		if (!isset($_SESSION['init'])) {
			session_regenerate_id();
			$_SESSION['init'] = true;
			$_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
		}

		//niezgodnosc ip, automatyczne wylogowanie
		if($_SESSION['ip'] != $_SERVER['REMOTE_ADDR']) {
			$_SESSION = array();
			$this->message = "Niezgodność IP. Zaloguj się ponownie.";
			return;
		}

		//pierwsza wizyta niezalogowanego uzytkownia
		if(!isset($_SESSION['id'])) {
			$_SESSION['id'] = 0;
		}

		//czas sesji
		if($_SESSION['id'] > 0) {
			if($_SESSION['time'] < (time()-$this->session_time)) {
				$_SESSION = array();
				$this->message = "Sesja wygasła. Zaloguj się ponownie.";
				return;
			} else $_SESSION['time'] = time();
		}

		try {
			//otwarcie bazy i ustawienie parametrow
			$this->db = new PDO('sqlite:' . $this->db_dir);
			$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
			$this->db->setAttribute(PDO::ATTR_TIMEOUT, 5);

			//sprawdzenie czy istnieje tabela z uzytkownikami
			$sql = sprintf("SELECT name FROM sqlite_master WHERE type='table' AND name='%s'", $this->db_table_users);

			//jezeli nie ma tabeli z uzytkownikami
			if($this->db->query($sql)->fetch() == null) {

				//utworzenie nowej tabeli
				$sql = sprintf("CREATE TABLE '%s' (
					'id'	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
					'user'	TEXT NOT NULL UNIQUE,
					'pass'	TEXT NOT NULL,
					'count' INTEGER DEFAULT 0,
					'last_login' INTEGER DEFAULT 0);", $this->db_table_users);
				$this->db->exec($sql);
			}

			//sprawdzenie czy istnieje konto admina z indexsem 1
			$sql = sprintf("SELECT * FROM '%s' WHERE id=1 AND user='%s'", $this->db_table_users, $this->db_admin_user);

			if($this->db->query($sql)->fetch() == null) {

				//dodanie admina do tabeli
				$sql = sprintf("REPLACE INTO %s(id, user, pass) VALUES(1, '%s', '%s')",
					$this->db_table_users,
					$this->db_admin_user,
					password_hash($this->db_admin_pass, PASSWORD_DEFAULT));
				$this->db->exec($sql);
			}

		} catch(PDOException $e) {
			$this->message = $e->getMessage();
			return;
		}

		if($_SERVER['REQUEST_METHOD'] === 'POST') {

			switch($_POST['type']) {

				case 'logout':
					$_SESSION = array();
					$this->message = "Poprawnie wylogowano.";
					return;

				case 'login':
					if(empty($_POST['user']) || empty($_POST['pass'])) {
						$this->message = "Niepoprawne dane.";
						return;
					}

					try {
						$sql = sprintf("SELECT * FROM %s WHERE user='%s'", $this->db_table_users, $_POST['user']);
						$result = $this->db->query($sql)->fetch();

						if(password_verify($_POST['pass'], $result['pass'])) {
							session_regenerate_id();
							$_SESSION['init'] = true;
							$_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
							$_SESSION['id'] = $result['id'];
							$_SESSION['time'] = time();

							$sql = sprintf("UPDATE %s SET count=count+1, last_login=%u WHERE id=%u", $this->db_table_users, time(), $_SESSION['id']);
							$this->db->exec($sql);

							$this->message = "Poprawnie zalogowano.";

						} else {
							$this->message = "Niepoprawne dane.";
							return;
						}

					} catch(PDOException $e) {
						$this->message = $e->getMessage();
						return;
					}
					break;

				case 'change_pass':
					if($_SESSION['id'] == 0) {
						$this->message = "Brak uprawnień.";
						return;
					}

					if(empty($_POST['old_pass']) || empty($_POST['new_pass'])) {
						$this->message = "Niepoprawne dane.";
						return;
					}


					try {
						$sql = sprintf("SELECT * FROM %s WHERE id=%u", $this->db_table_users, $_SESSION['id']);
						$result = $this->db->query($sql)->fetch();

						if(!password_verify($_POST['old_pass'], $result['pass'])) {
							$this->message = "Niepoprawne dane.";
							return;
						}

						$sql = sprintf("UPDATE %s SET pass='%s' WHERE id=%u", $this->db_table_users, password_hash($_POST['new_pass'], PASSWORD_DEFAULT), $_SESSION['id']);

						if($this->db->exec($sql)) $this->message = "Hasło zostało zmienione.";
						else $this->message = "Niepoprawne dane.";
						return;

					} catch(PDOException $e) {
						$this->message = $e->getMessage();
						return;
					}
					break;

				//dodawanie nowego uzytkownika
				case 'add_user':
					if($_SESSION['id'] != 1) {
						$this->message = "Brak uprawnień.";
						return;
					}

					if(empty($_POST['user']) || empty($_POST['pass'])) {
						$this->message = "Niepoprawne dane.";
						return;
					}

					try {
						$sql = sprintf("INSERT INTO %s(user, pass) VALUES('%s', '%s')",
							$this->db_table_users,
							$_POST['user'],
							password_hash($_POST['pass'], PASSWORD_DEFAULT));

						if($this->db->exec($sql)) $this->message = "Dodano nowego użytkownika.";
						else $this->message = "Niepoprawne dane.";
						return;

					} catch(PDOException $e) {
						$this->message = $e->getMessage();
						return;
					}
					break;

					//usuwanie uzytkownika
					case 'remove_user':
						if($_SESSION['id'] != 1) {
							$this->message = "Brak uprawnień.";
							return;
						}

						if(empty($_POST['id']) || ($_POST['id'] < 2)) {
							$this->message = "Niepoprawne dane.";
							return;
						}

						try {
							$sql = sprintf("DELETE FROM %s WHERE id=%u",
								$this->db_table_users,
								$_POST['id']);

							if($this->db->exec($sql)) $this->message = "Usunięto użytkownika.";
							else $this->message = "Niepoprawne dane.";
							return;

						} catch(PDOException $e) {
							$this->message = $e->getMessage();
							return;
						}
						break;

				}
			}
		}


	public function isLogin() {
		if(isset($_SESSION['id'])) {
			if($_SESSION['id'] > 0) return true;
		}
		return false;
	}


	public function isAdmin() {
		if(isset($_SESSION['id'])) {
			if($_SESSION['id'] == 1) return true;
		}
		return false;
	}

	public function getMessage() {
		if($this->message) return $this->message;
		return false;
	}

	public function getUserName() {

		if(!isset($_SESSION['id'])) return false;
		if($_SESSION['id'] == 0) return false;

		try {
			$sql = sprintf("SELECT user FROM %s WHERE id=%s", $this->db_table_users, $_SESSION['id']);
			$result = $this->db->query($sql)->fetch();
			if($result) return $result['user'];
		} catch(PDOException $e) {
			$this->message = $e->getMessage();
			return false;
		}

		return false;
	}

	public function getUsers() {
		if(!isset($_SESSION['id'])) return false;
		if($_SESSION['id'] != 1) return false;

		try {
			$sql = sprintf("SELECT id AS 'ID', user AS 'Login', datetime(last_login, 'unixepoch', 'localtime') AS 'Ostatnie logowanie', count AS 'Logowań' FROM %s", $this->db_table_users);
			$result = $this->db->query($sql)->fetchAll();
			if($result) return $result;
		} catch(PDOException $e) {
			$this->message = $e->getMessage();
			return false;
		}

		return false;
	}

}
?>
