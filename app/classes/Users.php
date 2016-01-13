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
		
		$id = Database::start()->get('*', 'user', array(
			array('email', '=', $_POST['email'])
		))->first()->id;
		
		$db->start()->insert('employee', array(
			'user_id' => $id,
			'moderator' => 1
		));
		
		return true;
		
		
	}
	
	public function updateMedewerker() {
		$this->errors = array();
		$error = false;
		
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
		
		Database::start()->update('user', array(
			'password' => hash('sha256', $_POST['password'])
		), array(
			array('id','=', $_POST['id'])
		));
		
		return true;
	}
	
	public function isMedewerker($id) {
		$count = Database::start()->get('*', 'employee', array(
			array('user_id', '=', $id)
		))->count();
		
		if($count > 0) {
			return true;
		}
		
		return false;
	}
	
	public function deleteMedewerker($id) {
		Database::start()->delete('employee', array(
			array('user_id', '=', $id)
		));
		
		Database::start()->delete('user', array(
			array('id', '=', $id)
		));
	}
	
	public function activeCheck($id) {
		return Database::start()->get('*', 'customer', array(
			array('user_id', '=', $id)
		))->first()->active;
	}
	
	public function setActive($id) {
		$active = ($this->activeCheck($id)) ? 0 : 1;
		Database::start()->update('customer', array(
			'active' => $active
		), array(
			array('user_id', '=', $id)
		));
	}
	
	public function getKlant($id) {
		return Database::start()->join('*', 'user', array(
			'customer' => array('user.id', 'user_id'),
			'city' => array('city.id', 'city_id')
		), array(
			array('user.id', '=', $id)
		))->first();
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