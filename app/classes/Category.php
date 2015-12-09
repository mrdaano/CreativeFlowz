<?php

/**
* 
*/
class Category
{
	private $_id, $_name, $_parent, $_nameParent;
	
	function __construct($db)
	{
		$this->db = $db;
	}


	/*
	Setters:
	--------
	Baruch (2-11-2015)
	Usage: $category->setName('nameOfCategory');
	*/
	public function setId($id)
	{
		$this->_id = $id;
	}

	public function setName($name)
	{
		$this->_name = $name;
	}

	public function setParent($parent)
	{
		$this->_parent = $parent;
		$sql = $this->db->start()->get('name', 'category', array(array('id', '=', $this->_parent)))->results();
			if (!empty($sql)) {
				$this->setNameParent($sql[0]->name);
			} else $this->setNameParent(null);
	}

	public function setNameParent($nameParent)
	{
		$this->_nameParent = $nameParent;
	}

	/*
	Auto set:
	---------
	Baruch (2-11-2015)
	Usage: $category->setAuto(1);
	
	$id = Int
	*/
	public function setAuto($id) 
	{
		$this->setId($id);
		$sql = $this->db->start()->get(array('name', 'parent'), 'category', array(array('id', '=', $this->_id)))->results();
		foreach ($sql as $std) {
			$this->setName($std->name);
			$this->setParent($std->parent);
		}	
	}

	/*
	Create a new category:
	----------------------
	Baruch (2-11-2015)
	Usage: $category->createCategory();
	*/
	public function createCategory()
	{
		if ($this->_name == '') {
			return "&m=none";
		}

		if ($this->_parent == NULL) {
			$sql = $this->db->start()->get('name', 'Category', array(array('parent', 'IS', 'NULL')))->results();
		} else {
			$sql = $this->db->start()->get('name', 'category', array(array('parent', '=', $this->_parent)))->results();
		}

		foreach ($sql as $std) {
			if (strtolower($std->name) == strtolower($this->_name)) {
				return "&m=exist";
				break;
			}
		}
		if ($this->_parent == NULL) {
			$this->db->start()->insert('category', array('name' => $this->_name));
		} else {	
			$this->db->start()->insert('category', array('name' => $this->_name, 'parent' => $this->_parent));
			return;
		}
	}

	/*
	Update a category:
	------------------
	Baruch (2-11-2015)
	Usage: $category->updateCategory('oldCategoryName', 3);

	$oldParent = Int
	$oldName = String
	*/
	public function updateCategory($oldName, $oldParent)
	{
		$returnId = "&e=" .  $this->_id . "&m=";
		
		if ($this->_name == '') {
			return $returnId . "none";
		}

		if ($this->_parent == NULL) {
			$sql = $this->db->start()->get('name', 'category', array(array('parent', 'IS', 'NULL')))->results();
		} else {
			$sql = $this->db->start()->get('name', 'category', array(array('parent', '=', $this->_parent)))->results();
		}
		if (strtolower($oldName) != strtolower($this->_name)) {
			foreach ($sql as $std) {
				if (strtolower($std->name) == strtolower($this->_name)) {
					return $returnId . "exist";
					break;
				}
			}
		}

		if ($oldParent == NULl && $this->_parent != NULL) {
			$sql = $this->db->start()->get('id', 'category', array(array('parent', '=', $this->_id)))->results();	
			if (!empty($sql)) {
				return $returnId . "subcat";
				break;
			}
		}

		if ($this->_parent == NULl) {
			$this->db->start()->update('category', array('name' => $this->_name), array('id' => $this->_id));
			return;
		} else {
			$this->db->start()->update('category', array('name' => $this->_name, 'parent' => $this->_parent), array('id' => $this->_id));
			return;	
		}	
	}	

	/*
	Remove a category:
	------------------
	Baruch (2-11-2015)
	Usage: $category->removeCategory();
	*/
	public function removeCategory()
	{
		$this->db->start()->update('category', array('parent' => NULL), array('parent' => $this->_id));
		$this->linkProduct();
		$this->db->start()->delete('category', array(array('id', '=', $this->_id)));		
	}

	/*
	Link a category and product:
	-----------------------------
	Baruch (2-11-2015)
	Usage: $category->linkProduct(array(1, 2, 3, 4, 5));

	$product_id = array(Int);
	*/
	public function linkProduct($product_id = array())
	{
		$this->db->start()->delete('product_category', array(array('category_id', '=', $this->_id)));
		if (!empty($product_id)) {
			foreach ($product_id as $id) {
				$this->db->start()->insert('product_category', array('category_id' => $this->_id, 'product_id' => $id));
			}
		}
	}

	/*
	Getters
	-------
	Baruch (2-11-2015)
	Usage: $category->getName();
	*/
	public function getId()
	{
		return $this->_id;
	}

	public function getName()
	{
		return $this->_name;
	}

	public function getParent()
	{
		return $this->_parent;
	}

	public function getNameParent()
	{
		return $this->_nameParent;
	}

	public function getLinkedProducts() {
		$linkedProducts = array();
		$sql = $this->db->start()->get(array('name', 'id'), 'product')->results();
		foreach ($sql as $key => $std) {
			$linkedProduct = array();
			$linkedProduct[0] = $std->id;
			$linkedProduct[1] = $std->name;
			$sqlChecked = $this->db->start()->get('product_id', 'product_category', array(array('category_id', '=', $this->_id)))->results();
			foreach ($sqlChecked as $stdChecked) {
				if ($stdChecked->product_id == $std->id) {
					$linkedProduct[2] = true;
				} else {
					$linkedProduct[2] = false;
				}
			}
			$linkedProducts[$key] = $linkedProduct;
		}

		return $linkedProducts;
	}

	/*
	Get all category's
	------------------
	Baruch (2-11-2015)
	Usage: $category->getAll(array('id', 'name'), array('parent', 'IS', 'NULL'));
	*/
	public function getAll($where = array()) {
		$allCategory = array();

		if (empty($where)) {
			$sql = $this->db->start()->get('*', 'category')->results();
		} else {
			$sql = $this->db->start()->get('*', 'category', $where)->results();
		
		foreach ($sql as $key => $std) {
			$allCategory[$key] = new Category($this->db);
			$allCategory[$key]->setAuto($std->id);
		}
		return $allCategory;
	}

	
}
?>
