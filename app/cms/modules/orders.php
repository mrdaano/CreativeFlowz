
<div class='neworders page'>
    <?php
    if(!isset($_GET['orderid'])){
    $allOrders = allOrders::getOrder();
        foreach($allOrders as $key => $order) {
            $orderline = allOrders::getOrder_line($order->id);
            $totalprice = 0;
    ?>
        <table class='cms page'>
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
                    <?php echo "{$order->id}"?>
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
                            <?php echo "{$order->user_id}"?><br>
                        </td>
                        <td>
                            <?php echo "{$order->created_at}"?><br>
                        </td>
                <?php
                    foreach($orderline as $key => $line) {
                        $product = myOrder::getProduct($line->product_id);
                        $price = ($line->amount * $product->price);
                        $totalprice = $totalprice + $price;
                    }
                ?>        
                <td>
                  &euro;<?php echo $totalprice; ?>
                </td>
                <td>
                    <a class="btn" href="index.php?page=cms&module=orders&orderid=<?=$order->id?>">Bekijk order</a>
                  </td>
              </tr>
          </table>
        <?php 
        }
        
        }else{
            if(isset($_GET['status'])){
                switch($_GET['status']){
                    case 'done' : $order->changeOrderstatus($_GET['orderid'], 1); break;
                    case 'notdone' : $order->changeOrderstatus($_GET['orderid'], 0); break;
                }
            }
            if($order->getError() != NULL){
                $response = $order->getError();
            }
            if($order->getMSG() != NULL){
                $response = $order->getMSG();
                //echo '<script type="text/javascript">window.location.href = "index.php?page=cms&module=page";</script>';
            }
            
            
            ?>
            <style>
                table.page tr td:nth-child(odd){
                    border-right: 1px solid #8C8C8C;
                }
            </style>
            <a class='btn' href=''>Terug</a> <a class='btn' href='/index.php?page=cms&module=orders&orderid=<?=$_GET['orderid']?>&status=done'>Er is voldaan aan de order</a>
            <a class='btn' href='/index.php?page=cms&module=orders&orderid=<?=$_GET['orderid']?>&status=notdone'>Er is nog niet voldaan aan de order</a>
            <?php
            if(isset($response) && $response != '' ){
                echo '<br/>'.$response.'<br/><br/>';
            }
           $order->getOrderByID($_GET['orderid']);
            
        ?>
		
	<?php
        }
    ?>
</div>