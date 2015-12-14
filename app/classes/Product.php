<?php

/**
* 
*/
class Product
{
	
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

	protected function setError($error)
	{
        $this->_error = $error;
    }
    
    public function getError()
    {
        return $this->_error;
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

	//Other functions
	public function newProduct()
	{
		$arrayProduct = array(	'name' => $this->getName(), 
								'code' => $this->getCode(), 
								'secondhand' => $this->getSecondhand(),
								'description' => $this->getDescription(),
								'supplier_id' => $this->getSupplierId(),
								'price' => $this->getPrice());
		$this->db->insert('product', $arrayProduct);	
	}

	public function updateProduct() 
	{
		$arrayProduct = array(	'name' => $this->getName(), 
								'code' => $this->getCode(), 
								'secondhand' => $this->getSecondhand(),
								'description' => $this->getDescription(),
								'supplier_id' => $this->getSupplierId(),
								'price' => $this->getPrice());
		$this->db->start()->update('product', $arrayProduct, array('id' => $this->getId()));
	}

	public function removeProduct()
	{
		$this->db->start()->delete('order_line', array(array('product_id', '=', $this->getId())));
		$this->db->start()->delete('shoppingcart', array(array('product_id', '=', $this->getId())));
		$this->db->start()->delete('product_category', array(array('product_id', '=', $this->getId())));
		$this->db->start()->delete('product_media', array(array('product_id', '=', $this->getId())));
		$this->db->start()->delete('product', array(array('id', '=', $this->getId())));
	}

	public function controle()
	{
		$error = array();
		if ($this->getName() == '') {
			$this->setError('Er is geen naam ingevuld.');
			return;
		}
		if ($this->getCode() == '') {
			$this->setError('Er is geen code ingevuld.');
			return;
		}
		if ($this->getDescription() == '') {
			$this->setError('Er is geen beschrijving ingevuld.');
			return;
		}
		if ($this->getPrice() == '') {
			$this->setError('Er is geen prijs ingevuld.');
			return;
		}

	}

	public function getLinkedCategory()
	{
		$linkdeCategorys = array();
		$sql = $this->db->start()->get(array('name', 'id'), 'category')->results();
		foreach ($sql as $key => $std) {
			$linkedCategory = array();
			$linkedCategory[0] = $std->id;
			$linkedCategory[1] = $std->name;
			$linkedCategory[2] = false;
			$sqlChecked = $this->db->start()->get('product_id', 'product_category', array(array('product_id', '=', $this->_id)))->results();
			foreach ($sqlChecked as $stdChecked) {
				if ($stdChecked->product_id == $std->id) {
					$linkedCategory[2] = true;
				}
			}
			$linkedCategorys[$key] = $linkedCategory;
		}
		return $linkedCategorys;
	}

	public function linkCategory($category_id = array())
	{
		$this->db->start()->delete('product_category', array(array('product_id', '=', $this->_id)));
		if (!empty($category_id)) {
			foreach ($category_id as $id) {
				$this->db->start()->insert('product_category', array('product_id' => $this->_id, 'category_id' => $id));
			}
		}
	}

}

?>