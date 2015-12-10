        <div class="secondheader">
            <div class="wrapper"></div>
        </div>
        <div class="thirdheader">
            <div class="wrapper">
                <div class="fourthheader">
                    <table class="thirdheadertable">
                        <tr class="thirdheaderhead">
                            <td class="textintable">categoriën</td>
                        </tr>
                            <tr class="thirdheaderdata">
                            <td class="textintable" class="activecategorie"><a href="webshop.php">- alles</a></td>
                        </tr>
                        <tr class="thirdheaderdata">
                            <td class="textintable"><a href="alescowebshop.php">- alesco</a></td>
                        </tr>
                        <tr class="thirdheaderdata">
                            <td class="textintable"><a href="balcowebshop.php">- balco</a></td>
                        </tr>
                        <tr class="thirdheaderdata">
                            <td class="textintable"><a href="faipwebshop.php">- faip</a></td>
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
                    $product = DB::start()->get(array('id','name','description','price'), 'product', array(array('supplier_id', '=>', '1')))->results();
                    $join = DB::start()->join('*', 'product', array('product_media' => array('product.id', 'product_id')) array(array('product.id' => 1)));
                    $joinMedia = DB::start()->join('*', 'product_media', array('media' => array('media_id', 'media.id')) array(array('media_id' => 1)));
                    foreach($product as $key => $product) {
                ?>
                    <div class="product">
                        <div class="productimg">
                            <img class="img" src="img/inductiewarmer.jpg"/>d
                            <div class="view">
                                <a href="product1.php"><img src=" "/>bekijk product</a>
                            </div>
                        </div>
                        <div class="productnr">
                            <?php
                                echo $product->id; 
                            ?>
                        </div>
                    </div>
                <?php
                    }
                ?>
            </div>
        </div>
