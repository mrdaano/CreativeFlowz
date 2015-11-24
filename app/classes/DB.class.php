<?php
	
class DB {
	
	private $_pdo, $_query, $_results, $_count = 0, $_error = false;
	
	public function __construct() {
		$this->_pdo = new PDO("mysql:host=localhost;dbname=none", "root", "");
	}
	
	private function query($sql, $params = array()) {
		$this->_error = false;
		if ($this->_query = $this->_pdo->prepare($sql)) {
			$x = 1;
			if (count($params)) {
				foreach($params as $param) {
					$this->_query->bindValue($x, $param);
					$x++;
				}
			}

			if ($this->_query->execute()) {
				$this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
				$this->_count = $this->_query->rowCount();
			} else {
				$this->_error = true;
			}

		return $this;
		}
	}
	
	
	/**
	 * Daan (24-11-2015)
	 * array/string $items
	 * string		$table
	 * Usage:
	 * DB::get(array(array('username', '=', 'john')), 'users')->results();
	 */
	public function get($items = "*", $table) {
		$query = "SELECT ";
		$items = array();
		
		if (!is_array($items)) {
			$query .= "* ";
		} else {
			// Loop all the params
		}
		
		$this->query($query, $params);
		
		return $this;
	}
	
	public function results() {
		return $this->_results;
	}
}