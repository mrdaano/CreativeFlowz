<?php

/**
* 
*/
class Product
{
	
	private $_id, $_name, $_code, $_secondhand, $_description, $supplier_id, $_price, $_supplier_name; 

	function __construct($db)
	{
		$this->db = $db;
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
		$sql = $this->db->start()->get('name', 'supplier', array(array('id', '=', $this->getSupplierId())))->results();
		foreach ($sql as $suppName) {
			$this->_supplier_name = $suppName->name;
		}
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

	public function getSupplierName() {
		return $this->_supplier_name;
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
			$allProducts[$key]->setAuto($std->id);
		}

		return $allProducts;
	}

	//Other functions
	public function newProduct()
	{
		$this->db->insert('product', array(	'name' => $this->getName(), 
											'code' => $this->getCode(), 
											'secondhand' => $this->getSecondhand(),
											'description' => $this->getDescription(),
											'supplier_id' => $this->getSupplierId(),
											'price' => $this->getPrice()));
	}

	public function getAllSupplier($where = array())
	{
		$allSupplier = array();

		if (empty($where)) {
			$sql = $this->db->get('*', 'supplier')->results();
		} else {
			$sql = $this->db->get('*', 'supplier', $where)->results();
		}

		foreach ($sql as $key => $suppl) {
			$allSupplier[$key] = array($suppl->id, $suppl->name, $suppl->website);
		}

		return $allSupplier;
	}

	public function updateProduct() 
	{
		$this->db->start()->update('product', array('name' => $this->getName(), 
													'code' => $this->getCode(), 
													'secondhand' => $this->getSecondhand(),
													'description' => $this->getDescription(),
													'supplier_id' => $this->getSupplierId(),
													'price' => $this->getPrice()), array('id' => $this->getId()));
		//return $this->getId();

	}

	public function removeProduct()
	{
		$this->db->start()->delete('order_line', array(array('product_id', '=', $this->getId())));
		$this->db->start()->delete('shoppingcart', array(array('product_id', '=', $this->getId())));
		$this->db->start()->delete('product_category', array(array('product_id', '=', $this->getId())));
		$this->db->start()->delete('product_media', array(array('product_id', '=', $this->getId())));
		$this->db->start()->delete('product', array(array('id', '=', $this->getId())));
	}

}

?>