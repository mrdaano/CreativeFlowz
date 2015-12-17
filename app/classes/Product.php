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

	public function setError($error)
	{
        $this->_error = $error;
    }

	/*
	Deze functie zet ook de supplier_name;
	*/
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

	/*
	Deze functie zet alles automatisch door middel van een id
	*/
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

	//Deze funcite zoekt de id op uit de database en slaat hem op.
	public function setIdFromDatabase() {
		$id = $this->db->start()->get('id', 'product', array(	array('name', '=', $this->getName()),
														array('code', '=', $this->getCode()),
														array('secondhand', '=', $this->getSecondhand()),
														array('description', '=', $this->getDescription()),
														array('supplier_id', '=', $this->getSupplierId()),
														array('price', '=', $this->getPrice())))->results();
		$this->setId($id[0]->id);
	}

	//Getters
	public function getId()
	{
		return $this->_id;
	}
    
    public function getError()
    {
    	if (isset($this->_error)) {
    		return $this->_error;
    	} else {
    		return false;
    	}
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

	/*
	Deze functie geeft alle producten, er kan gebruik gemaakt worden van een where statement. 
		Deze werkt net als in de database class (array(array('id', '=', 1)))
	Je krijgt een array met verschillende producten terug.
		Deze kun je uitlezen met een foreach:
		foreach ($producten->getAll(array(array('id', '>', '4'))) as $product) {
			echo 'Naam: ' . $product->name;
			echo 'Code: ' . $product->code;
			ect...
		}
	*/
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

	/*
	Met deze functie kun je alle leveranciers opvragen, er kan gebruik gemaakt worden van een were statement
		Deze werkt net als in de database class.
	Je krijgt een array met verschillende leveranciers terug. 
		Deze kun je uitlezen met een foreach:
		foreach($product->getAllSupplier(array(array('id', '=', '1'))) as $leverancier) {
			echo 'id: ' . $leverancier[0];
			echo 'naam: ' . $leverancier[1];
			echo 'website: ' . $leverancier[2];
		}
	*/
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

	/*
	Met deze functie krijg je alle categorieen en of ze gelinkt zijn of niet
	Je krijgt een array terug met daarin een andere array, 
	0 is de id
	1 is de naam
	2 is een boolean, als een product gelinkt is aan deze categorie is het true, anders is het false.
	*/
	public function getLinkedCategory()
	{
		$linkdeCategorys = array();
		$sql = $this->db->start()->get(array('name', 'id'), 'category')->results();
		foreach ($sql as $key => $std) {
			$linkedCategory = array();
			$linkedCategory[0] = $std->id;
			$linkedCategory[1] = $std->name;
			$linkedCategory[2] = false;
			$sqlChecked = $this->db->start()->get('*', 'product_category', array(array('product_id', '=', $this->getId())))->results();
			foreach ($sqlChecked as $stdChecked) {
				if ($stdChecked->category_id == $std->id) {
					$linkedCategory[2] = true;
				}
			}
			$linkedCategorys[$key] = $linkedCategory;
		}
		return $linkedCategorys;
	}

	//Other functions

	
	//Deze functie maakt een nieuw product aan.
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

	
	//Deze functie update een product
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

	//Deze functie verwijderd een product
	public function removeProduct()
	{
		$this->db->start()->delete('order_line', array(array('product_id', '=', $this->getId())));
		$this->db->start()->delete('shoppingcart', array(array('product_id', '=', $this->getId())));
		$this->db->start()->delete('product_category', array(array('product_id', '=', $this->getId())));
		$this->db->start()->delete('product_media', array(array('product_id', '=', $this->getId())));
		$this->db->start()->delete('product', array(array('id', '=', $this->getId())));
	}

	//Deze functie controleerd of er fouten zijn, Als deze er zijn wordt error de te weergeven error, anders wordt error false.
	public function controle()
	{
		$error = array();
		foreach( )



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

		if (!$this->controlPrice()){
			$this->setError('Er is geen correcte prijs ingevuld.');
			return;
		}

		$this->setError(false);

	}


	public function controlPrice()
	{
		$price = $this->getPrice();

		if (strpos($price, ',')) {
			$price = str_replace(',','.',$price);
		}

		if (!is_numeric($price)) {
			return false;
		} else {
			$price = round($price, 2);
			if (strpos($price, '.')) {
				$this->setPrice(str_replace('.',',',$price));
			}
			return true;
		}
	}


	//Deze functie linkt een category aan een product
	//Je geeft een array met category id's mee.
	public function linkCategory($category_id = array())
	{
		$this->db->start()->delete('product_category', array(array('product_id', '=', $this->getId())));
		if (!empty($category_id)) {
			foreach ($category_id as $id) {
				$this->db->start()->insert('product_category', array('category_id' => $id, 'product_id' => $this->getId()));
			}
		}
	}

}

?>