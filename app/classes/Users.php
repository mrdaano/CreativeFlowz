<?php
	
class Users {
	
	private $errors = array();
	
	public function medewerkerToevoegen() {
		$this->errors = array();
		$error = false;
		$db = new Database();
		
		if (empty($_POST['vnaam'])) {
			$this->addError("Voornaam is een verplichte veld.");
			$error = true;
		}
		
		if (empty($_POST['naam'])) {
			$this->addError("Achternaam is een verplichte veld.");
			$error = true;
		}
		
		if (empty($_POST['email'])) {
			$this->addError("E-mail is een verplichte veld.");
			$error = true;
		}
		
		if (empty($_POST['password']) || empty($_POST['password_again'])) {
			$this->addError("Beide wachtwoord velden zijn verplicht.");
			$error = true;
		}
		
		if ($_POST['password'] != $_POST['password_again']) {
			$this->addError("Beide wachtwoorden moeten overeenkomen.");
			$error = true;
		}
		
		if ($error) {
			return false;
		}
		
		$db->start()->insert('user', array(
			'firstname' => $_POST['vnaam'],
			'lastname' => $_POST['naam'],
			'email' => $_POST['email'],
			'password' => hash('sha256', $_POST['password'])
		));
		
		die($db->lastId());
		
		$db->start()->insert('employee', array(
			'user_id' => $db->lastId(),
			'moderator' => 1
		));
		
		return true;
		
		
	}
	
	public function disableCustomer($id) {
		
	}
	
	public function oldInput($field) {
		return (isset($_POST[$field])) ? $_POST[$field] : '';
	}
	
	public function getUsers() {
		return Database::start()->get('*','user')->results();
	}
	
	public function getErrors() {
		return $this->errors;
	}
	
	private function addError($error) {
		if (is_string($error)) {
			array_push($this->errors, $error);
		}
	}
}