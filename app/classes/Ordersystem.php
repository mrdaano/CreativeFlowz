<?php 

class Ordersystem {
	private $order_id = 0;
	public function __construct($db){
        $this->db = $db;
        $this->db->start();
    }

    public function setOrder() {
    	Database::start()->insert('order', array(
    		'user_id' => $_SESSION['_user']['id'],
    		

    	));

    	$this->order_id = Database::lastId();
    }

    public function getShoppingcart() {
    	$products = Database::start()->get('*', 'shoppingcart', array(
    			array('user_id', '=', $_SESSION['_user']['id'])
    		))->results();

    	foreach($products as $key => $product) {
    		$this->setOrderLine($product->product_id, $product->amount);
    	}
    }

    private function setOrderLine($id, $amount) {
		
    }
}