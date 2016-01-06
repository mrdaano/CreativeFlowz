<div class="thirdheader">
            <div class="wrapper">
                <div class="fourthheader">
                    <table class="thirdheadertable">
                        <tr class="thirdheaderhead">
                            <td class="textintable">categoriën</td>
                        </tr>
                            <tr class="thirdheaderdata">
                            <td class="textintable" class="activecategorie"><a href="index.php?page=webshop">- alles</a></td>
                        </tr>
                        <tr class="thirdheaderdata">
                            <td class="textintable"><a href="index.php?page=alescowebshop">- alesco</a></td>
                        </tr>
                        <tr class="thirdheaderdata">
                            <td class="textintable"><a href="index.php?page=balcowebshop">- balco</a></td>
                        </tr>
                        <tr class="thirdheaderdata">
                            <td class="textintable"><a href="index.php?page=faipwebshop">- faip</a></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="wrapper">
            <div class="textheader">
                <?php 
                    $product = $db->start()->get('*', 'product')->results();
                    $join = $db->start()->join('*', 'product', array('product_media' => array('product.id', 'product_id')), array(array('product.id' => 1)));
                    $joinMedia = $db->start()->join('*', 'product_media', array('media' => array('media_id', 'media.id')), array(array('media_id' => 1)));
                    
                    foreach($product as $key => $product) {
                ?>
                    <div class="product">
                        <div class="productimg">
                            <img class="img" src="img/inductiewarmer.jpg"/>
                            <div class="view">
                                <a href="product1.php"><img src=""/>bekijk product</a>
                            </div>
                        </div>
                        <div class="productnr">
                            <?php
                                echo $product->name; 
                            ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>  