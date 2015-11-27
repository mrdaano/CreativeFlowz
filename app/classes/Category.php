<?php

/*
Baruch
Catogorieen toevoegen, verwijderen en bewerken
*/

class Category
{

	private $_id;
	private $_category;
	private $_position;

	function __construct($category = array()) {
		include_once 'Database.php';
	}

	public function setId($id)
	{
		if (isset($id)) {
			$this->_id = $id;	
		}
	}

	public function setCategory($category)
	{
		if (isset($category)) {
			$this->_category = $category;	
		}
	}

	public function setPostion($position)
	{
		if (isset($position)) {
			$this->_position = $position;	
		}
	}

	public function getCategory()
	{
		return $this->_category;	
	}

	public function getId()
	{
		return $this->_id;	
	}

	public function getPostion()
	{
		return $this->_position;
	}

	public function createCategory()
	{
		$database = new Database();
		if (isset($this->_position)) {
			$database::start()->insert('category', array('name' => $this->_category, 'position' => $this->_position));	
		} else {
			$database::start()->insert('category', array('name' => $this->_category));	
		}
	}

	public function delete()
	{
		$database = new Database();
	}

	public function update()
	{
		$database = new Database();
	}

	public function controle()
	{
		$database = new Database();
		$controleCategory = $database::start()->get('*', 'category')->results();
		foreach ($controleCategory as $std) {
			if ($this->_category == $std->name) {
				$return  = 'catexist';
				break;
			}
			/*
			if(isset($this->_position))	{
				if ($this->_position == $std->position) {
					$return = 'posexist';
					break;
				}
			}
			*/
		}
		if (!isset($return)) {
				$return = 'true';
		}	
		return $return;
	}
}
