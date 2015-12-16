<?php
$shoppingcart = new ShoppingCart;
 ?>
<form method="post">
  <input type="number" name="qty">
  <?php if (isset($_POST[qty])){
    $shoppingcart->updateQuantity(1, $_POST[qty]);
  } ?>
