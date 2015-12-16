<div class="secondheader">
    <div class="wrapper">
        <div class="customername"><span id="customername"><?Php echo $User->lastname()?></span><br>
            <span id="customer">klant</span>
        </div>
        <ul class="customertabs">
            <li><a href="index.php?page=customer&module=orders">mijn orders</a></li>
            <li><a href="index.php?page=customer&module=sending">verzenden en retouneren</a></li>
        <ul>
    </div>
</div>
<div class="thirdheader">
            <div class="wrapper">
                <div class="fourthheader">
                    <table class="thirdheadertable">
                        <tr class="thirdheaderhead">
                            <td class="textintable">categoriën</td>
                        </tr>
                            <tr class="thirdheaderdata">
<<<<<<< HEAD
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
=======
                            <td class="textintable">- alles</td>
                        </tr>
                        <tr class="thirdheaderdata">
                            <td class="textintable">- alesco</td>
                        </tr>
                        <tr class="thirdheaderdata">
                            <td class="textintable">- balco</td>
                        </tr>
                        <tr class="thirdheaderdata">
                            <td class="textintable">- faip tirechangers</td>
                        </tr>
                        <tr class="thirdheaderdata">
                            <td class="textintable">- faip wheelaligners</td>
                        </tr>
                        <tr class="thirdheaderdata">
                            <td class="textintable">- faip wheelbalancers</td>
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
                            <img class="img" src=""/>
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