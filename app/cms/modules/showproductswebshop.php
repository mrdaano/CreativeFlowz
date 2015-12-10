<?php 

$db = new Database();
$products = new Product($db);
$url = '?page=cms&module=sproducts';
$gevonden = false;

if (isset($_GET['viewproduct'])) {
    $product = new Product($db);
    $product->setAuto($_GET['viewproduct']); ?>
    <ul>
        <li>
            <?php echo $product->getName();?>
        </li>
        <li>
            <?php if ($product->getSecondhand() == 0) {  
                echo 'nee';
            } else {
                echo 'ja';         
            } ?>
        </li>
        <li>
            <?php echo $product->getDescription();?>
        </li>
        <li>
            <?php echo $product->getSupplierName();?>
        </li>
        <li>
            <?php echo $product->getPrice();?>
        </li>
    </ul>
        <a href="<?php echo 'index.php?page=order&id=' . $product->getId(); ?> ">
             Bestellen
        </a>
<?php } 

elseif (isset($_GET['category'])) {
    $category = new Category($db);
    $category->setAuto($_GET['category']);
    foreach($category->getLinkedProducts() as $pro) {
        if($pro[2]) {
            $gevonden = true;
            $product = new Product($db); 
            $product->setAuto($pro[0]); ?>
            <div class="product">
            <div class="productimg">
                    <img class="img" src="img/inductiewarmer.jpg"/>
            <div class="view">
                <a href="<?php echo $url . '&viewproduct=' . $product->getId(); ?>"><img src=" "/>bekijk product
                </a>
            </div>
            </div>
            <div class="productnr">
                    <?php  echo $product->getName();  ?> <br>
            </div>
            </div>
        <?php }
    } 
}

else {
    if ($products->getAll()) {
            $gevonden = true;
    } 

    foreach ($products->getAll() as $product) { ?>
        <div class="product">
            <div class="productimg">
            <img class="img" src="img/inductiewarmer.jpg"/>
            <div class="view">
                <a href="<?php echo $url . '&viewproduct=' . $product->getId(); ?>"><img src=" "/>     bekijk product
                </a>
            </div>
            </div>
            <div class="productnr">
                    <?php  echo $product->getName(); ?>   <br>
            </div>
            </div>
    <?php }
}

if (!$gevonden) {
    echo 'Geen producten gevonden';
} 

?>