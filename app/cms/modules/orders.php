	<div class="orders">
		
	<?php

	$allOrders = allOrders::getOrder();
		foreach($allOrders as $key => $order) {
			$orderline = allOrders::getOrder_line($order->id);
			$totalprice = 0;
	?>
		<table class="ordertable">
			<tr>
				<th>
					Ordernummer:
				</th>
				<th>
					Klantnummer:
				</th>
				<th>
					Tijd van plaatsen:
				</th>
				<th>
					Totaalbedrag:
				</th>
				<th>
					Bekijk order:
				</th>
			</tr>
			<tr>
				<td>
					Ordernummer: <?php echo "{$order->id}"?>
				</td>
		<?php
			foreach($orderline as $key => $line) {
				$product = myOrder::getProduct($line->product_id);
				$price = ($product->price)
		?>
		<?php
			}
		?>
				<td>
					Klantnummer: <?php echo "{$order->user_id}"?><br>
				</td>
				<td>
					Tijd van plaatsen: <?php echo "{$order->created_at}"?><br>
				</td>
		<?php
			foreach($orderline as $key => $line) {
				$product = myOrder::getProduct($line->product_id);
				$price = ($line->amount * $product->price);
				$totalprice = $totalprice + $price;
			}
		?>		
				<td>
					Totaal: &euro;<?php echo $totalprice; ?>
				</td>
				<td>
					<a class="btn" href="index.php?page=cms&module=Bekijkpagina">Bekijk order</a>
  				</td>
  			</tr>
  		</table>
 
					
			
		<?php 
		}
	?>
	
</div>