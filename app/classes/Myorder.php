<?php

class myOrder {

public function __construct($db){
        $this->db = $db;
        $this->db->start();
}

public function getOrder(){
	return Database::start()->get('*', 'order', array(
		array('user_id', '=', $_SESSION['_user']['id'])
	))->results();
}

public function getOrder_line($order_id){
	return Database::start()->get('*', 'orderline', array(
		array('id', '=', $order_id)
	))->results();
}

public function getProduct($id){
	return Database::start()->get('*', 'product', array(
		array('product_id', '=', $id)
	))->first();
}
}

