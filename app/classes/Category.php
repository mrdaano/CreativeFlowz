<?php

/**
* 
*/
class Category
{
	private $_id, $_name, $_head, $_nameHead;
	
	function __construct()
	{
		include_once 'Database.php';	
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
			case 'head':
				return $this->_head;
				break;
			case 'nameHead':
				return $this->_nameHead;
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
			case 'head':
				$this->_head = $value;

				$database = new Database();
				$sql = $database::start()->get('name', 'category', array(array('id', '=', $this->_head)))->results();
				if (!empty($sql)) {
					$this->_nameHead =$sql[0]->name;
				} else $this->_nameHead = null;
				break;
			case 'auto':
				$database = new Database();
				$this->_id = $value;
				$sql = $database::start()->get(array('name', 'head'), 'category', array(array('id', '=', $this->_id)))->results();
				foreach ($sql as $std) {
					$this->_name = $std->name;
					$this->set('head', $std->head);
				}
				break;
		}
	}

	public function createCategory($name, $head)
	{
		if ($name == '') {
			return "?m=none";
		} else {
			$this->set('name', $name);
		}

		$this->set('head', $head);

		$database = new Database();
		$sql = $database::start()->get('name', 'category', array(array('head', '=', $this->_head)))->results();
		foreach ($sql as $std) {
			if (strtolower($std->name) == strtolower($this->_name)) {
				return "?m=exist";
				break;
			}
		}
	
		$database::start()->insert('category', array('name' => $this->_name, 'head' => $this->_head));
		return;
	}

	public function updateCategory($id, $name ,$head, $oldName, $oldHead)
	{
		$returnId = "?e=" .  $id . "&m=";
		
		$this->set('id', $id);

		if ($name == '') {
			return $returnId . "none";
		} else {
			$this->set('name', $name);
		}

		$this->set('head', $head);

		$database = new Database();
		$sql = $database::start()->get('name', 'category', array(array('head', '=', $this->_head)))->results();
		if (strtolower($oldName) != strtolower($name)) {
			foreach ($sql as $std) {
				if (strtolower($std->name) == strtolower($this->_name)) {
					return $returnId . "exist";
					break;
				}
			}
		}

		if ($oldHead == 0 && $this->_head != 0) {
			$sql = $database::start()->get('id', 'category', array(array('head', '=', $this->_id)))->results();	
			if (!empty($sql)) {
				return $returnId . "subcat";
				break;
			}
		}

		$database::start()->update('category', array('name' => $this->_name, 'head' => $this->_head), array('id' => $this->_id));
		return;		
	}

	public function removeCategory($id)
	{
		$this->set('id', $id);
		$database = new Database();
		$database::start()->update('category', array('head' => 0), array('head' => $this->_id));
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