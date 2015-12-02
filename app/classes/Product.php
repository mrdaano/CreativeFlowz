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

	//Other functions

}

?>