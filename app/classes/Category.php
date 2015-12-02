<?php

/**
* 
*/
class Category
{
	private $_id, $_name, $_parent, $_nameParent;
	
	function __construct()
	{
		//include_once 'Database.php';	
	}

	public function get($wat)
	{
		switch ($wat) {
			case 'id':
				return $this->_id;
				break;			
			case 'name':
				return $this->_name;
				break;
			case 'parent':
				return $this->_parent;
				break;
			case 'nameParent':
				return $this->_nameParent;
				break;			
		}
	}

	public function set($wat, $value) 
	{
		switch ($wat) {
			case 'id':
				$this->_id = $value;
				break;
			case 'name':
				$this->_name = $value;
				break;
			case 'parent':
				$this->_parent = $value;

				$database = new Database();
				$sql = $database::start()->get('name', 'category', array(array('id', '=', $this->_parent)))->results();
				if (!empty($sql)) {
					$this->_nameParent =$sql[0]->name;
				} else $this->_nameParent = null;
				break;
			case 'auto':
				$database = new Database();
				$this->_id = $value;
				$sql = $database::start()->get(array('name', 'parent'), 'category', array(array('id', '=', $this->_id)))->results();
				foreach ($sql as $std) {
					$this->_name = $std->name;
					$this->set('parent', $std->parent);
				}
				break;
		}
	}

	public function createCategory($name, $parent)
	{
		if ($name == '') {
			return "&m=none";
		} else {
			$this->set('name', $name);
		}

		$this->set('parent', $parent);

		$database = new Database();
		if ($this->_parent == NULL) {
			$sql = $database::start()->get('name', 'Category', array(array('parent', 'IS', 'NULL')))->results();
		} else {
			$sql = $database::start()->get('name', 'category', array(array('parent', '=', $this->_parent)))->results();
		}

		foreach ($sql as $std) {
			if (strtolower($std->name) == strtolower($this->_name)) {
				return "&m=exist";
				break;
			}
		}
		if ($this->_parent == NULL) {
			$database::start()->insert('category', array('name' => $this->_name));
		} else {	
			$database::start()->insert('category', array('name' => $this->_name, 'parent' => $this->_parent));
			return;
		}
	}

	public function updateCategory($id, $name ,$parent, $oldName, $oldParent)
	{
		$returnId = "&e=" .  $id . "&m=";
		
		$this->set('id', $id);

		if ($name == '') {
			return $returnId . "none";
		} else {
			$this->set('name', $name);
		}

		$this->set('parent', $parent);

		$database = new Database();
		if ($this->_parent == NULL) {
			$sql = $database::start()->get('name', 'category', array(array('parent', 'IS', 'NULL')))->results();
		} else {
			$sql = $database::start()->get('name', 'category', array(array('parent', '=', $this->_parent)))->results();
		}
		if (strtolower($oldName) != strtolower($name)) {
			foreach ($sql as $std) {
				if (strtolower($std->name) == strtolower($this->_name)) {
					return $returnId . "exist";
					break;
				}
			}
		}

		if ($oldParent == NULl && $this->_parent != NULL) {
			$sql = $database::start()->get('id', 'category', array(array('parent', '=', $this->_id)))->results();	
			if (!empty($sql)) {
				return $returnId . "subcat";
				break;
			}
		}

		if ($this->_parent == NULl) {
			$database::start()->update('category', array('name' => $this->_name), array('id' => $this->_id));
			return;
		} else {
			$database::start()->update('category', array('name' => $this->_name, 'parent' => $this->_parent), array('id' => $this->_id));
			return;	
		}	
	}	

	public function removeCategory($id)
	{
		$this->set('id', $id);
		$database = new Database();
		$database::start()->update('category', array('parent' => NULL), array('parent' => $this->_id));
		$database::start()->delete('product_category', array(array('category_id', '=', $this->_id)));
		$database::start()->delete('category', array(array('id', '=', $this->_id)));		
	}

	public function linkProduct($category_id, $product_id = array())
	{
		$this->set('id', $category_id);
		$database = new Database();
		$database::start()->delete('product_category', array(array('category_id', '=', $this->_id)));
		if (!empty($product_id)) {
			foreach ($product_id as $id) {
				$database::start()->insert('product_category', array('category_id' => $this->_id, 'product_id' => $id));
			}
		}
	}
}
?>