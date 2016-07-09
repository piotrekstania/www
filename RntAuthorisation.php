<?php

class RntAuthorisation {

	private $db_dir          = "baza.db";
	private $db_table_users  = "users";
	private $db_admin_user   = "admin";
	private $db_admin_pass   = "admin";
	private $db_session_time = 60;

	private $db;

	public function __construct() {
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
					'session_time' INTEGER NOT NULL);", $this->db_table_users);
				$this->db->exec($sql);

				//dodanie admina do tabeli
				$sql = sprintf("INSERT INTO %s(id, user, pass, session_time) VALUES(1, '%s', '%s', '%s')",
					$this->db_table_users,
					$this->db_admin_user,
					password_hash($this->db_admin_pass, PASSWORD_DEFAULT),
					$this->db_session_time);

				$this->db->exec($sql);
			}
		} catch(PDOException $e) {
			throw new Exception($e->getMessage());
		}
	}

	//pobieranie nazwy uzytkownia z bazy danych
	public function getUserName($_id) {
		try {
			$sql = sprintf("SELECT user FROM %s WHERE id=%s", $this->db_table_users, $_id);
			$result = $this->db->query($sql)->fetch();
		} catch(PDOException $e) {
			throw new Exception($e->getMessage());
		}

		if(isset($result['user'])) return $result['user'];
		else throw new Exception("Brak użytkownika o podanym ID.");
	}


	public function getSessionTime($_id) {
		try {
			$sql = sprintf("SELECT session_time FROM %s WHERE id=%s", $this->db_table_users, $this->isInt($_id));
			$result = $this->db->query($sql)->fetch();
		} catch(PDOException $e) {
			throw new Exception($e->getMessage());
		}

		if(isset($result['session_time'])) return $result['session_time'];
		else throw new Exception("Brak użytkownika o podanym ID.");
	}

	//sprawdzanie nazwy uzytkownika i hasla
	public function getUserId($_user, $_pass) {
		try {
			$sql = sprintf("SELECT * FROM %s WHERE user='%s'", $this->db_table_users, $_user);
			$result = $this->db->query($sql)->fetch();
		} catch(PDOException $e) {
			throw new Exception($e->getMessage());
		}

		if($result) {

			if(password_verify($_pass, $result['pass'])) return (int) $result['id'];
			else throw new Exception("Niepoprawne hasło.");

		} else throw new Exception("Niepoprawna nazwa użytkownika.");
	}

	//dodawania nowego uzytkownika do bazy danych
	public function addUser($_user, $_pass, $_session_time) {
		try {
			$sql = sprintf("INSERT INTO %s(user, pass, session_time) VALUES('%s', '%s', '%s')",
				$this->db_table_users,
				$_user,
				password_hash($_pass, PASSWORD_DEFAULT),
				$_session_time);

			$this->db->exec($sql);

		} catch(PDOException $e) {
			throw new Exception($e->getMessage());
		}

		return true;
	}

	//pobieranie listy uzytkownikow
	public function getUsers() {
		try {
			$sql = sprintf("SELECT id, user, session_time FROM %s", $this->db_table_users);
			$result = $this->db->query($sql)->fetchAll();
		} catch(PDOException $e) {
			throw new Exception($e->getMessage());
		}

		if($result) return $result;
		else throw new Exception("Nie udało się pobrać listy użytkowników.");
	}

}
?>
