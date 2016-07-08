<?php

class RntAuthorisation {

	private $db_dir = null;
	private $db_table_users = null;
	private $db_admin_user = null;
	private $db_admin_pass = null;
	private $db_session_time = null;

	private $db;
	private $error;

	//funkcja sprawdza czy podana zmienna jest liczbą, jak nie to zwraca stirng NULL
	private function isInt($var) {
			if(empty($var)) return 'NULL';
			else if(!is_numeric($var)) return 'NULL';
			else return $var;
	}

	//pobieranie ostatniego bledu
	public function getError() {
		return $this->error;
	}

	//inicjalizacja
	public function init($_db_dir, $_db_table_users, $_db_admin_user, $_db_admin_pass, $_db_session_time) {
		$this->db_dir = $_db_dir;
		$this->db_table_users = $_db_table_users;
		$this->db_admin_user = $_db_admin_user;
		$this->db_admin_pass = $_db_admin_pass;
		$this->db_session_time = $_db_session_time;

		try {
			$this->db = new PDO('sqlite:' . $this->db_dir);
			$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
			$this->db->setAttribute(PDO::ATTR_TIMEOUT, 5);

			//sprawdzenie czy istnieje tabela z uzytkownikami
			$sql = sprintf("SELECT name FROM sqlite_master WHERE type='table' AND name='%s'", $this->db_table_users);

			//jezeli nie ma tabeli z uzytkownikami
			if($this->db->query($sql)->fetch() == null) {
				$sql = sprintf("CREATE TABLE '%s' (
					'id'	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
					'user'	TEXT NOT NULL UNIQUE,
					'pass'	TEXT NOT NULL,
					'session_time' INTEGER NOT NULL);", $this->db_table_users);
				$this->db->exec($sql);

				$sql = sprintf("INSERT INTO %s(user, pass, session_time) VALUES('%s', '%s', '%s')",
					$this->db_table_users,
					$this->db_admin_user,
					password_hash($this->db_admin_pass, PASSWORD_DEFAULT),
					$this->db_session_time);

				$this->db->exec($sql);
			}
		} catch(PDOException $e) {
			$this->error = $e->getMessage();
			return false;
		}
		return true;
	}

	//pobieranie nazwy uzytkownia z bazy danych
	public function getUserName($_id) {
		try {
			$sql = sprintf("SELECT user FROM %s WHERE id=%s", $this->db_table_users, $this->isInt($_id));
			$result = $this->db->query($sql)->fetch();
		} catch(PDOException $e) {
			$this->error = $e->getMessage();
			return false;
		}

		if($result) return $result['user'];
		else {
			$this->error = 'Brak użytkownika o podanym ID';
			return false;
		}
	}

	//pobieranie nazwy uzytkownia z bazy danych
	public function getUserSessionTime($_id) {
		try {
			$sql = sprintf("SELECT session_time FROM %s WHERE id=%s", $this->db_table_users, $this->isInt($_id));
			$result = $this->db->query($sql)->fetch();
		} catch(PDOException $e) {
			$this->error = $e->getMessage();
			return false;
		}

		if($result) return (int) $result['session_time'];
		else {
			$this->error = 'Brak użytkownika o podanym ID';
			return false;
		}
	}

	//sprawdzanie nazwy uzytkownika i hasla
	public function getUserId($_user, $_pass) {

		try {
			$sql = sprintf("SELECT * FROM %s WHERE user='%s'", $this->db_table_users, $_user);
			$result = $this->db->query($sql)->fetch();
		} catch(PDOException $e) {
			$this->error = $e->getMessage();
			return false;
		}

		if($result) {
			if(password_verify($_pass, $result['pass'])) return (int) $result['id'];
			else {
				$this->error = 'Błędne hasło.';
				return false;
			}
		}

		$this->error = 'Podany użytkownik nie istnieje.';
		return false;
	}


}
?>
