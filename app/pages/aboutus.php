<div class="secondheader">
    <div class="wrapper"></div>
</div>
<div class="thirdheader">
    <div class="wrapper">
        <div class="fourthheader">
            <table class="thirdheadertable">
                <tr class="thirdheaderhead">
                    <td class="textintable">wie wij ook zijn</td>
                </tr>
                <tr class="thirdheaderdata">
                    <td class="textintable"><a href="http://www.christianfacilities.nl">christianfacilities.nl</a></td>
                </tr>
                <tr class="thirdheaderdata">
                    <td class="textintable"><a href="http://www.faipservice.nl">faipservice.nl</a></td>
                </tr>
                <tr class="thirdheaderdata">
                    <td class="textintable"><a href="http://www.balcoservice.nl">balcoservice.nl</a></td>
                </tr>
                <tr class="thirdheaderdata">
                    <td class="textintable"><a href="http://www.alescoservice.nl">alescoservice.nl</a><br><br><br><br><br><br></td>
                </tr>
            </table>
        </div>
    </div>
</div>
<div class="wrapper">
    <div class="textheader">
        <?php
        //$orders = $db->start()->get(array('*'), 'order_line', array(array('user_id' => 1)))->results();
        //$order_lines = $db->start()->join('*', 'order_line', array('order' => array('order_id', 'order.id')), array(array('order_id' => 1)));

        $orders = $db->start()->get('*', 'order')->results();
        $order_lines = $db->start()->join('*', 'order', array('order_line' => array('order.id', 'order_id')), array(array('order.id' => 1)));
            foreach ($orders as $key => $order) {
        ?>
        <div class="orders">
        <div class="leftorder">
            user id: <?php echo $order->user_id; ?><br>
            order id: <?php echo $order->id; ?>
        </div>
        <div class="rightorder">
            created at: <?php echo $order->created_at; ?>
        </div>
        <br><br><br>
        <div class="rightorderinfo">
            <br><br>totalprice: <?php echo $order_lines->totalprice; ?>
        </div>
        <div class="orderinfo">
            product id: <?php echo $order_lines->product_id; ?> <br>
            price: <?php echo $order_line->price; ?><br>
            amount: <?php echo $order_lines->amount; ?><br>
        </div>

    </div>
        <?php } ?>
    </div>
</div>