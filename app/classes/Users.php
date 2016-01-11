<?php
	
class Users {
	public function getUsers() {
		return Database::start()->get('*','user')->results();
	}
}