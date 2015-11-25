<?php
	
class Database {
	
	private static $_instance = null;
	private $_pdo, $_query, $_results, $_count = 0, $_error = false;
	
	public function __construct() {
		$this->_pdo = new PDO('mysql:host=localhost;dbname=cursus', 'root', '');
	}
	
	/**
	 * Daan (24-11-2015)
	 * Usage:
	 * DB::start();
	 */
	public static function start() {
		if(!isset(self::$_instance)) {
			self::$_instance = new Database();
		}
		return self::$_instance;
	}

	public function raw($query, $params = array()) {
		if(!$this->query($query, $params)->error()) {
			return $this;
		}
	}
	
	/**
	 * Daan (24-11-2015)
	 * string	$sql
	 * array	$params
	 * Usage:
	 * $this->query(//sql, array('params')); 
	 * Note: Only use in this class!
	 */
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
	 * DB::start()->get(array('username','email'), 'users', array(array('username', '=', 'john')))->results();
	 */
	public function get($colmns = "*", $table, $params = array()) {
		$where = null;
		$operators = array('=', '>', '<', '>=', '<=');
		$x = 1;
		$values = array();

		if (is_array($colmns)) {
			$y = 1;
			$selectColmns = null;
			foreach ($colmns as $colmn) {
				$selectColmns .= "`{$colmn}`";
				if ($y < count($colmns)) {
					$selectColmns .= ", ";
				}
				$y++;
			}
		} else {
			$selectColmns = $colmns;
		}

		if (!empty($params)) {
			$where = "WHERE";
			foreach ($params as $key => $param) {
				$operator = $param[0];
				$value = $param[1];
				if (in_array($operator, $operators)) {
					$where .= " {$key} {$operator} ?";
					array_push($values, $value);
					if ($x < count($params)) {
						$where .= " AND ";
					}
					$x++;
				}
			}
		}

		$sql = "SELECT {$selectColmns} FROM `{$table}` {$where}";
		
		if(!$this->query($sql, $values)->error()) {
			return $this;
		}
	}
	
	/**
	 * Daan (25-11-2015)
	 * string	$table
	 * array	$items
	 * Usage:
	 * DB::start()->insert('users', array('username' => 'John', 'email' => 'johndoe@example.com'));
	 */
	public function insert($table, $params) {
		if (is_array($params)) {
			$sql = "INSERT INTO {$table} (";
			$x = 1;
			$queryEnd = "";
			$values = array();
			foreach($params as $key => $param) {
				$sql .= "`{$key}`";
				$queryEnd .= "?";
				if ($x < count($params)) {
					$sql .=", ";
					$queryEnd .= ", ";
				}
				array_push($values, $param);
				$x++;
			}
			$sql .= ") VALUES ({$queryEnd})";
			
			if(!$this->query($sql, $values)->error()) {
				return $this;
			}
			
		}
		return false;
	}
	
	public function results() {
		return $this->_results;
	}
	
	public function error() {
		return $this->_error;
	}

	public function count() {
		return $this->_count;
	}
}
