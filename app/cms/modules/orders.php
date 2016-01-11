	<div class="orders">

	<?php

	$allOrders = allOrders::getOrder();

		foreach($allOrders as $key => $order) {
			$orderline = allOrders::getOrder_line($order->id);

			foreach($orderline as $key => $line) {
				$products = allOrders::getProduct($line->product_id);
			}	
	?>
	<div class="order">
		<div class="leftside">
			order: <?php echo "{$order->id}"?><br><br>
			products: <?php echo "{$product->name}"?><br>	
			price: <?php echo "&euro;{$price}" ?><br>
			amount: <br>
		</div>
		<div class="rightside">
			userid: <br>
			created at:<br><br><br>
			totalprice:
		</div>
	</div>
	<?php
		}
	?>
	
</div>