<?php
class Database {

	private static $_instance = null;
	private $_pdo, $_query, $_results, $_count = 0, $_error = false, $_sql, $_values = array();

	public function __construct() {
		$this->_pdo = new PDO('mysql:host=localhost;dbname=mydb', 'root', 'root');
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
	public function get($colmns = "*", $table, $params = array(), $orderBy = array()) {
		$where = null;
		$operators = array('=', '>', '<', '>=', '<=', '!=', 'IS', 'IS NOT');
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
			foreach ($params as $param) {
				$key = $param[0];
				$operator = $param[1];
				$value = $param[2];
				if (in_array($operator, $operators)) {
					$end = '?';
					if ($value == 'NULL') {
						$end = $value;
					} else {
						array_push($values, $value);
					}

					$where .= " {$key} {$operator} {$end}";

					if ($x < count($params)) {
						$where .= " AND ";
					}
					$x++;
				}
			}
		}

		$order = "";
		if (!empty($orderBy)) {
			$order = $this->orderBy($orderBy);
		}

		$sql = "SELECT {$selectColmns} FROM `{$table}` {$where}{$order}";

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
			$sql = "INSERT INTO `{$table}` (";
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

	/**
	 * Daan (25-11-2015)
	 * string	$table
	 * array	$data
	 * array	$params
	 * Usage:
	 * DB::start()->update('users', array('username' => 'John', 'email' => 'johndoe@example.com'), array(array('id', '=', 1)));
	 */
	public function update($table, $data, $params) {
		$sql = "UPDATE {$table} SET ";
		$operators = array('=', '>', '<', '>=', '<=', '!=', 'IS', 'IS NOT');
		$x = 1;
		$values = array();

		foreach($data as $key => $item) {
			$sql .= "{$key}=? ";
			if ($x < count($data)) {
				$sql .=", ";
			}
			$x++;
			array_push($values, $item);
		}

		$sql .= "WHERE ";
		$x = 1;

		foreach ($params as $param) {
				$key = $param[0];
				$operator = $param[1];
				$value = $param[2];
				if (in_array($operator, $operators)) {
					$end = '?';
					if ($value == 'NULL') {
						$end = $value;
					} else {
						array_push($values, $value);
					}

					$sql .= " {$key} {$operator} {$end}";

					if ($x < count($params)) {
						$sql .= " AND ";
					}
					$x++;
				}
			}

		if(!$this->query($sql, $values)->error()) {
			return $this;
		}
	}

	/**
	 * Daan (25-11-2015)
	 * string	$table
	 * array	$params
	 * Usage:
	 * DB::start()->delete('users', array(array('id' => 1)));
	 */
	public function delete($table, $params = array()) {
		$sql = "DELETE FROM {$table} WHERE ";
		$values = array();
		$x = 1;
		$operators = array('=', '>', '<', '>=', '<=');

		foreach($params as $param) {
			$colmn = $param[0];
			$operator = $param[1];
			$value = $param[2];

			if (in_array($operator, $operators)) {
				$sql .= "{$colmn}{$operator}?";
				if ($x < count($params)) {
					$sql .=" AND ";
				}
				$x++;
				array_push($values, $value);
			}
		}

		if(!$this->query($sql, $values)->error()) {
			return $this;
		}

	}

	/**
	 * Daan (4-12-2015)
	 * string/array	$colmns
	 * string		$table
	 * array		$join
	 * array		$where
	 * Usage:
	 * DB::start()->join('*', 'users', array('orders' => array('user_id', 'users.id')) array(array('id' => 1)));
	 */
	public function join($colmns = "*", $table, $joins, $where = array()) {
		$joinClause = "";
		$whereClause = "";
		$values = array();
		$operators = array('=', '>', '<', '>=', '<=');

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

		foreach($joins as $joinTable => $join) {
			$joinClause .= " JOIN {$joinTable} ON {$join[0]}={$join[1]}";
		}

		if (!empty($where)) {
			$whereClause = " WHERE ";
			foreach($where as $item) {
				$colmn = $item[0];
				$operator = $item[1];
				$value = $item[2];

				if (in_array($operator, $operators)) {
					$whereClause .= "{$colmn}{$operator}?";
					if ($x < count($where)) {
						$whereClause .=", ";
					}
					$x++;
					array_push($values, $value);
				}

			}
		}

		$sql = "SELECT {$selectColmns} FROM `{$table}` {$joinClause}{$whereClause}";

		if(!$this->query($sql, $values)->error()) {
			return $this;
		}
	}

	/**
	 * Daan (4-12-2015)
	 * string/array	$colmns
	 * string		$table
	 * array		$join
	 * array		$where
	 * Usage:
	 * DB::start()->leftJoin('*', 'users', array('orders' => array('user_id', 'users.id')) array(array('id' => 1)));
	 */
	public function leftJoin() {
		$joinClause = "";
		$whereClause = "";
		$values = array();
		$operators = array('=', '>', '<', '>=', '<=');

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

		foreach($joins as $joinTable => $join) {
			$joinClause .= " LEFT JOIN {$joinTable} ON {$join[0]}={$join[1]}";
		}

		if (!empty($where)) {
			$whereClause = " WHERE ";
			foreach($where as $item) {
				$colmn = $item[0];
				$operator = $item[1];
				$value = $item[2];

				if (in_array($operator, $operators)) {
					$whereClause .= "{$colmn}{$operator}?";
					if ($x < count($where)) {
						$whereClause .=", ";
					}
					$x++;
					array_push($values, $value);
				}

			}
		}

		$sql = "SELECT {$selectColmns} FROM `{$table}` {$joinClause}{$whereClause}";

		if(!$this->query($sql, $values)->error()) {
			return $this;
		}
	}


	/**
	 * Daan (2-12-2015)
	 * Note:
	 * This can only included in other functions in the class
	 */
	private function orderBy($order = array()) {
		$accepted = array('ASC','DESC');
		$return = " ORDER BY ";

		$x = 1;
		foreach ($order as $key => $value) {
			$value = strtoupper($value);
			if (in_array($value, $accepted)) {
				$return .= "{$key} {$value}";
				if ($x < count($order)) {
					$return .=", ";
				}
				$x++;
			}
		}
		return $return;
	}

	/**
	 * Daan (25-11-2015)
	 * Note:
	 * This can only be used with a insert
	 */
	public function lastId() {
		return $this->_pdo->lastInsertId();
	}

	public function first() {
		return $this->_results[0];
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
