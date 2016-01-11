<?php 
$url = '?page=webshop';
$gevonden = false;
$shoppingcart = new Shoppingcart();
?>


<div class="thirdheader">
            <div class="wrapper">
                <div class="fourthheader">
                    <table class="thirdheadertable">
                        <tr class="thirdheaderhead">
                            <td class="textintable">Categoriën</td>
                        </tr>
                            <tr class="thirdheaderdata">
                            <td class="textintable"><a href="<?= $url ?>">- Alles</a></td>
                        </tr>
                        <?php foreach ($Category->getAll(array(array('parent', 'IS', 'NULL'))) as $cat) { ?>
                            <tr class="thirdheaderdata">
                                <td class="textintable"><a href="<?= $url . '&category=' . $cat->getId() ?>">- <?= $cat->getName() ?></a></td>
                            </tr>
                            <?php 
                            foreach ($Category->getAll(array(array('parent', '=', $cat->getId()))) as $child) { ?>
                                <tr class="thirdheaderdata">
                                    <td class="textintablesecond textintable"><a href="<?= $url . '&category=' . $child->getId() ?>">- <?= $child->getName() ?></a></td>
                                </tr>
                            <?php }
                        } ?>
                    </table>
                </div>
            </div>
        </div>
        <div class="wrapper">
            <div class="textheader">
                <?php
                if (isset($_GET['order'])) {
                    $Product->setId($_GET['order']);

                    if(count($Product->getAll(array(array('id', '=', $Product->getId())))) > 0) {
                        $Shoppingcart = new Shoppingcart();
                        $Shoppingcart->addItem($Product->getId());
                        header('location:' . $url . '&viewproduct=' . $Product->getId());
                    } else {
                        header('location:' . $url);
                    }
                }

                //View product
                elseif (isset($_GET['viewproduct'])) {
                    $Product->setAuto($_GET['viewproduct']); 
                    foreach ($Product->getAll() as $product){
                        if ($_GET['viewproduct'] == $product->getId()) { 
                            $gevonden = true; ?>
                                <img class="imgspec" src="<?= $product->getImgPath() ?>"/>
                                <div class="Allspec">
                                <div class="namespec">
                                <h1>
                                    <?php echo  $product->getName();?>
                                </div>
                                </h1>
                                <div class="secondhandspec">
                                    <?php if ($product->getSecondhand() == 1) {  
                                        echo 'tweedehans product: ja';
                                    } else {
                                        echo '';         
                                    } ?>
                                </div>
                                <div class="supplierspec">    
                                    <?php echo 'leverancier: ' . $product->getSupplierName();?>
                                </div>   
                                <div class="pricespec"> 
                                    <?php echo 'prijs per stuk: ' . number_format($product->getPrice(), 2, ',', '.');?>
                                </div>
                                <?php ?>
                                <div class="orderspec">
                            <a href="<?php echo $url . "&order=" . $product->getId(); ?> " class="btn">
                                klik en bestel
                            </a>
                                </div>
                                </div>
                                <div class="descrspec">
                                    <b><h2>Artikelomschrijving</h2></b>
                                    <div>
                                    <?php echo  $product->getDescription();?>
                                </div>
                                </div>
                        <?php } 
                    }
                } 

                elseif(isset($_GET['category'])) {
                    $Category->setAuto($_GET['category']);
                    foreach ($Category->getLinkedProducts() as $product) { 
                        if($product[2]) { 
                            $gevonden = true;
                            $Product->setAuto($product[0]); ?>
                            <div class="product">
                                <div class="productimg">
                                    <a href="<?php echo $url . '&viewproduct=' . $Product->getId(); ?>">
                                        <img class="img" src="<?= $Product->getImgPath() ?>"/>
                                    </a>
                                    <div class="view">
                                        <a href="<?php echo $url . '&viewproduct=' . $Product->getId(); ?>">Bekijk product</a>
                                    </div>
                                </div>
                                <div class="productnr">
                                <span>   
                                    <?php  echo $product->getName(); ?>
                                </span>
                                <br>
                            </div>
                        <?php } 
                    }
                }

                //Alle producten
                else {
                    if ($Product->getAll()) {
                        $gevonden = true;
                    } 
                    foreach ($Product->getAll() as $product) { ?>
                        <div class="product">
                            <div class="productimg">
                                <a href="<?php echo $url . '&viewproduct=' . $product->getId(); ?>">
                                    <img class="img" src="<?= $product->getImgPath() ?>"/>
                                </a>
                                <div class="view">
                                    <a href="<?php echo $url . '&viewproduct=' . $product->getId(); ?>">Bekijk dit product</a>
                                </div>
                            </div>
                            <div class="productnr">
                                <span>   
                                    <?php  echo $product->getName(); ?>
                                </span>
                                <br>
                            </div>
                        </div>
                    <?php } 
                }

                //Error
                if (!$gevonden && (isset($_GET['viewproduct']) || isset($_GET['category']))) {
                    echo '<h1>Geen producten gevonden!</h1>';
                } ?>
            </div>
        </div>  