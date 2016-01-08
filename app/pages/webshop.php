<?php 
$url = '?page=webshop';
$gevonden = false;
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
                //View product
                if (isset($_GET['viewproduct'])) {
                    $Product->setAuto($_GET['viewproduct']); 
                    foreach ($Product->getAll() as $product){
                        if ($_GET['viewproduct'] == $product->getId()) { 
                            $gevonden = true; ?>
                            <div class="all">
                            <ul>
                                <li>
                                    <img class="imgspec" src="<?= $product->getImgPath() ?>"/>
                                </li>

                                <li><div class="namespec">
                                    <?php echo  $product->getName();?>
                                </li></div class="secondspec">
                                <li><div>
                                    <?php if ($product->getSecondhand() == 0) {  
                                        echo 'nee';
                                    } else {
                                        echo 'ja';         
                                    } ?>
                                </li></div>
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
                            </a></div>
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
                                    <?php  echo $Product->getName(); ?>   
                                    <br>
                                </div>
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
                                <?php  echo $product->getName(); ?>   
                                <br>
                            </div>
                        </div>
                    <?php } 
                }

                //Error
                if (!$gevonden && (isset($_GET['viewproduct']) || isset($_GET['category']))) {
                    echo 'Geen producten gevonden!';
                } ?>
            </div>
        </div>  