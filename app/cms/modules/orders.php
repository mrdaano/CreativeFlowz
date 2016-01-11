	<div class="orders">
		
	<?php

	$allOrders = allOrders::getOrder();
		foreach($allOrders as $key => $order) {
			$orderline = allOrders::getOrder_line($order->id);
			$totalprice = 0;
	?>
		<div class="order">
		<div class="leftside">
			order: <?php echo "{$order->id}"?><br><br>
		<?php
			foreach($orderline as $key => $line) {
				$product = myOrder::getProduct($line->product_id);
				$price = ($product->price)
		?>
				products: <?php echo "{$product->name}"?><br>	
				amount: <?php echo "{$line->amount}"?><br>
				price: <?php echo "&euro;{$price}" ?><br><br>
		<?php
			}
		?>
		</div>
		<div class="rightside">
			user: <?php echo "{$order->user_id}"?><br>
			created: <?php echo "{$order->created_at}"?>
		<?php
			foreach($orderline as $key => $line) {
				$product = myOrder::getProduct($line->product_id);
				$price = ($line->amount * $product->price);
				$totalprice = $totalprice + $price;
		?>
				<br><br><br>subtotal: <?php echo "&euro;{$price}" ?>
		<?php
			}
		?>
		<br>Totaal: &euro;<?php echo $totalprice; ?>
		</div>
	</div>
	<?php
		}
	?>
	
</div>