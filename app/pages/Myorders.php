<?php

$myOrder = myOrder::getOrder();

foreach($myOrder as $key => $order) {
	$orderline = myOrder::getOrder_line($order->id);

	foreach($orderline as $key => $line) {
		$products = myOrder::getProduct($line->product_id)
	}
}

?>

