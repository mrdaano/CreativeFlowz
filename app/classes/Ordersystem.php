<?php 

class Ordersystem {
	public function __construct($db){
        $this->db = $db;
        $this->db->start();
    }

    public function setProduct($id, $created_at) {
		$productset = Database::start()->get('$id', 'product', array(
        	array('product_id', '=', $id),
        	array('user_id', '=', $_SESSION['_user']['id'])
      	));
		if ($productset->count() > 0) {
			Database::start()->insert('order_line', array(
          		'id' => $product_id,
          		'user_id' => $_SESSION['_user']['id']
        	));
		}
    }



}