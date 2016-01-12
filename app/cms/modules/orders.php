	<div class="orders">
		
	<?php

	$allOrders = allOrders::getOrder();
		foreach($allOrders as $key => $order) {
			$orderline = allOrders::getOrder_line($order->id);
			$totalprice = 0;
	?>
		<div class="order">
		<div class="leftside">
			Ordernummer: <?php echo "{$order->id}"?><br><br>
		<?php
			foreach($orderline as $key => $line) {
				$product = myOrder::getProduct($line->product_id);
				$price = ($product->price)
		?>
				Product: <?php echo "{$product->name}"?><br>	
				Aantal: <?php echo "{$line->amount}"?><br>
				Prijs: <?php echo "&euro;{$price}" ?><br><br>
		<?php
			}
		?>
		</div>
		<div class="rightside">
			Klantnummer: <?php echo "{$order->user_id}"?><br>
			Tijd van plaatsen: <?php echo "{$order->created_at}"?><br>
		<?php
			foreach($orderline as $key => $line) {
				$product = myOrder::getProduct($line->product_id);
				$price = ($line->amount * $product->price);
				$totalprice = $totalprice + $price;
		?>
				<br><br>Subtotaal: <?php echo "&euro;{$price}" ?><br><br>
		<?php
			}
		?>
		Totaal: &euro;<?php echo $totalprice; ?>
		</div>
	</div>
	<?php
		}
	?>
	
</div>