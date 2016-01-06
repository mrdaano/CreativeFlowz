        <div class="secondheader">
            <div class="wrapper">
                <div class="customername"><span id="customername">Klantnaam</span><br>
                    <span id="customer">klant</span>
                </div>
                <ul class="customertabs">
                    <li><a href="myorders.php">mijn orders</a></li>
                    <li><a href="sendingoptions.php">verzenden en retouneren</a></li>
                <ul>
            </div>
        </div>
        <div class="thirdheader">
            <div class="wrapper">
                <div class="fourthheader">

                </div>
            </div>
        </div>
        <div class="wrapper">
            <div class="textheader">
                
            </div>
        </div>
<?php
$shoppingcart = new ShoppingCart;
if(isset($_POST['del_x']) || isset($_POST['del_x'])){
  $shoppingcart->deleteItem($_POST['product']);
}

if(isset($_POST['amount'])){
  $shoppingcart->updateQuantity($_POST['product'], $_POST['amount']);
}
 ?>
 <form method="post">
  ID om toe te voegen <input type="number" name="itemId">
  <input type="submit" value="Voeg item toe aan winkelwagen"><br/>(dit is tijdelijk en alleen voor nu om te laten zien dat het werkt, dit gaat natuurlijk later rechtstreeks vanaf de webshop;)<br/>
  <?php if(isset($_POST[itemId])){
    $shoppingcart->addItem($_POST[itemId]);
  } ?>

<br/>
<div class="top row">
  <div class="productName bold">Artikel</div>
  <div class="productPrice bold">Prijs</div>
  <div class="productAmount bold">Hoeveelheid</div>
  <div class="subtotaal bold">Subtotaal</div>
</div>
<?php
foreach($shoppingcart->getShoppingcart() as $item) {
  $product = $shoppingcart->getProduct($item->product_id);
  $price = ($product->price * $item->amount);
  ?>
  <div class="row">
    <div class="productName"><?php echo "{$product->name}"?></div>
    <div class="productPrice"><?php echo "{$product->price}" ?></div>
    <div class="productAmount">
      <form method="post" action="#">
        <input type="hidden" name="product" value="<?php echo $product->id; ?>">
        <input type="number" value="<?php echo $item->amount; ?>" class="productAmount" name="amount" onchange="this.form.submit()">
      </form>
    </div>
    <div class="subtotaal"><?php echo "&euro;{$price}"; ?></div>
    <div class="delete">
      <form method="post" name="deleteForm">
      <input type="hidden" value="<?php echo $product->id; ?>" name="product">
      <input type="image" src="img/delete-icon.png" class="delete" name="del">
    </form></div>
  </div>
  <?php
  }
?>

