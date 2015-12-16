<?php
include 'app/classes/Database.php';

?>
<div class="secondheader">
            <div class="wrapper">
                <div class="customername"><span id="customername">Klantnaam</span><br>
                    <span id="customer">klant</span>
                </div>
                <ul class="customertabs">
                    <li><a href="myorders.php" class="active">mijn orders</a></li>
                    <li><a href="sendingoptions.php">verzenden en retouneren</a></li>
                <ul>
            </div>
        </div>
        <div class="thirdheader">
            <div class="wrapper">
                <div class="fourthheader">
                    <table class="thirdheadertable">
                        <tr class="thirdheaderhead">
                            <td class="textintable">mijn orders</td>
                        </tr>
                        <tr class="thirdheaderdata">
                            <td class="textintable"><a href="myorders.php">alle orders</a></td>
                        </tr>
                        <tr class="thirdheaderdata">
                            <td class="textintable"><a href="myalescoorders.php">alesco orders</a></td>
                        </tr>
                        <tr class="thirdheaderdata">
                            <td class="textintable"><a href="mybalcoorders.php">balco orders</a></td>
                        </tr>
                        <tr class="thirdheaderdata">
                            <td class="textintable"><a href="myfaiporders.php">faip orders</a><br><br><br><br><br><br></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="wrapper">
            <div class="textheader">
                <div class="order">
                    <?php
                        $orders = $db->start()->get('*', 'order')->results();
                        $order_lines = $db->start()->join('*', 'order', array('order_line' => array('order.id', 'order')), array(array('order.id' => 1)));
                        foreach ($orders as $key => $order) {
                            echo $order->id;
                            echo $order->user_id;
                            echo $order->created_at;
                            echo $order_lines->product_id;
                            echo $order_lines->amount;
                        }
                    ?>
            </div>
        </div>
