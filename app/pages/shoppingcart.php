<?php
if (!isset($_SESSION['_user'])){
  header("location: http://{$_SERVER['HTTP_HOST']}{$_SERVER['SCRIPT_NAME']}?page=login");
}
$shoppingcart = new ShoppingCart;
if(isset($_POST['del_x']) || isset($_POST['del_x'])){
  $shoppingcart->deleteItem($_POST['product']);
}

if(isset($_POST['amount'])){
  $shoppingcart->updateQuantity($_POST['product'], $_POST['amount']);
}
 ?>
 <script language="JavaScript" type="text/javascript">
 $(document).ready(function() {
   $('.productAmount').on('change', checkform);
 });
 function checkform (){
  if ($(this).val() < 0) {
    alert("Vul een positieve hoeveelheid in");
  }else {
      $(this).parent().submit();
  }
 }
 </script>

<br/>
<div class="top row">
  <div class="productName bold">Artikel</div>
  <div class="productPrice bold">Prijs</div>
  <div class="productAmount bold">Hoeveelheid</div>
  <div class="subtotaal bold">Subtotaal</div>
</div>
<?php
$total_price = array();
foreach($shoppingcart->getShoppingcart() as $item) {
  $product = $shoppingcart->getProduct($item->product_id);
  $price = number_format(($product->price), 2, ',', '.');
  $qty = $item->amount;
  $subtotaal = ($product->price * $qty);
  str_replace('.', ',', $subtotaal);
  $subtotaal = number_format($subtotaal, 2, ',', '.');
  $total_price[] = $subtotaal;
  ?>
  <div class="row">
    <div class="productName"><?php echo "{$product->name}"?></div>
    <div class="productPrice"><?php echo "&euro;{$price}" ?></div>
    <div class="productAmount">
      <form method="post" action="#" id="amount">
        <input type="hidden" name="product" value="<?php echo $product->id; ?>">
        <input type="number" min="0" value="<?php echo $item->amount; ?>" class="productAmount" name="amount">
      </form>
    </div>
    <div class="subtotaal"><?php echo "&euro;{$subtotaal}"; ?></div>
    <div class="delete">
      <form method="post" name="deleteForm">
      <input type="hidden" value="<?php echo $product->id; ?>" name="product">
      <input type="image" src="img/delete-icon.png" class="delete" name="del">
    </form></div>
  </div>
  <?php
  }
  print_r($total_price);
?>
<div class="btn_right">
  <a href="" class="btn">Order plaatsen</a>
</div>
