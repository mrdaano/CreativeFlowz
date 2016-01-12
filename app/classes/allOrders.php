<?php

class allOrders {

public function __construct(){
}

public function getOrder(){
	return Database::start()->get('*', 'order', array(
		array('user_id', '>=', '0')
	))->results();
}

public function getOrder_line($order_id){
	return Database::start()->get('*', 'order_line', array(
		array('order_id', '=', $order_id)
	))->results();
}

public function getProduct($id){
	return Database::start()->get('*', 'product', array(
		array('id', '=', $id)
	))->first();
}
public function getCity($cityname) {
	return Database::start()->get('*', 'city', array(
		array('id', '=', $id)
	))->results();
}
public function getUser() {
	return Database::start()->join('firstname', 'user', array('order' => array('user_id', 'users.id')));
}
}

