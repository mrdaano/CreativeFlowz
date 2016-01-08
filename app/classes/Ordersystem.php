<?php 

class Ordersystem {

	private $order_id = 0;
	public function __construct($db){
        $this->db = $db;
        $this->db->start();
    }

    private function setOrderId() {
    	Database::start()->insert('order', array(
    		'user_id' = $_SESSION['_user']['id']
    	));

    	$this->order_id = Database::lastId();
    }

    public function getShoppingcart() {
    	$products = Database::start()->get('*', 'shoppingcart', array(
    			array('user_id', '=', $_SESSION['_user']['id'])
    		))->results();

    	$this->setOrderId();

    	foreach($products as $key => $product) {
    		$this->setOrderLine($this->order_id, $product->product_id, $product->amount);
    	}
    }

    private function setOrderLine($order_id, $product_id, $amount) {
		Database::start()->insert('order_line', array(
				'order_id' = $order_id,
				'amount' => $amount,
				'product_id' => $product_id,
			));
    }

    public function myOrders() {
    	// return order
    }
}
	
