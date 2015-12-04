<?php

/**
* 
*/
class Product
{
	
	private $_id, $_name, $_code, $_secondhand, $_description, $supplier_id, $_price; 

	function __construct()
	{
		
	}
	
	//Setters
	public function setId($id)
	{
		$this->_id = $id;
	}

	public function setName($name)
	{
		$this->_name = $name;
	}

	public function setCode($code)
	{
		$this->_code = $code;
	}

	public function setSecondhand($secondhand)
	{
		$this->_secondhand = $secondhand;
	}

	public function setDescription($description)
	{
		$this->_description = $description;
	}

	public function setSupplierId($supplier_id)
	{
		$this->_supplier_id = $supplier_id;
	}

	public function setPrice($price)
	{
		$this->_price = $price;
	}

	public function setAuto($id)
	{
		$this->_id = $id;

		$sql = $this->db->start()->get('*', 'product', array(array('id', '=', $this->getId())))->results();
		foreach ($sql as $pro) {
			$this->setName($pro->name);
			$this->setCode($pro->code);
			$this->setSecondhand($pro->secondhand);
			$this->setDescription($pro->description);
			$this->setSupplierId($pro->supplier_id);
			$this->setPrice($pro->price);
		}
	}

	//Getters
	public function getId()
	{
		return $this->_id;
	}

	public function getName()
	{
		return $this->_name;
	}

	public function getCode()
	{
		return $this->_code;
	}

	public function getSecondhand()
	{
		return $this->_secondhand;
	}

	public function getDescription()
	{
		return $this->_description;
	}

	public function getSupplierId()
	{
		return $this->_supplier_id;
	}

	public function getPrice()
	{
		return $this->_price;
	}

	public function getAll($where = array()) {
		$allProducts = array();

		if (empty($where)) {
			$sql = $this->db->start()->get('*', 'product')->results();
		} else {
			$sql = $this->db->start()->get('*', 'product', $where)->results();
		}

		foreach ($sql as $key => $std) {
			$allProducts[$key] = new Product($this->db);
			$this->setAuto($std->id);
		}
	}

	//Other functions

}

?>