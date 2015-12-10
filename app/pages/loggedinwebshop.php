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
                    <table class="thirdheadertable">
                        <tr class="thirdheaderhead">
                            <td class="textintable">categoriën</td>
                        </tr>
                            <tr class="thirdheaderdata">
                            <td class="textintable" class="activecategorie"><a href="loggedinwebshop.php">- alles</a></td>
                        </tr>
                        <tr class="thirdheaderdata">
                            <td class="textintable"><a href="loggedinalescowebshop.php">- alesco</a></td>
                        </tr>
                        <tr class="thirdheaderdata">
                            <td class="textintable"><a href="loggedinbalcowebshop.php">- balco</a></td>
                        </tr>
                        <tr class="thirdheaderdata">
                            <td class="textintable"><a href="loggedinfaipwebshop.php">- faip</a></td>
                        </tr>
                    </table>
                </div>
                <script language="javascript">
                    function send()
                    {document.theform.submit()}
                </script>
                <form action="/search" method="get" class="sfm" name="theform">
                    <input type="text" name="q" placeholder="Zoeken..." value="" id="sf"/>
                </form>
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
                            <img class="img" src="<?php echo $joinMedia->name; $joinMedia->path;?>"/>
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
                <?php
                    }
                ?>
            </div>
        </div>
