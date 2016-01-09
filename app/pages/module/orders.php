	
<div class="orders">
<div class="order">
	<?php

	$myOrder = myOrder::getOrder();

		foreach($myOrder as $key => $order) {
			$orderline = myOrder::getOrder_line($order->id);

			foreach($orderline as $key => $line) {
				$products = myOrder::getProduct($line->product_id);
			}
		}

	?>
	<div class="leftside">
		order: <?php echo "{$order->id}"?><br><br>
		products: <?php echo "{$product->name}"?><br>
		price: <?php echo "&euro;{$price}" ?><br>
		amount:<br>

	</div>
	<div class="rightside">
		<br>
		created_at:<br><br><br>
		totalprice:
	</div>
</div>
</div>