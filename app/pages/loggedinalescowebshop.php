<div class="header">
            <div class="wrapper">
                <div class="sitenameblock"><a class="sitename" href="loggedin.php"><span class="bold">Theservice</span><span class="italic">Group</span></a></div>
                <ul class="forheader">
                    <li><a href="loggedinaboutus.php">over ons</a></li>
                    <li class="active"><a href="loggedinwebshop.php">webshop</a></li>
                    <li><a href="loggedincontact.php">contact</a></li>
                </ul>
                <ul class="rightlist">
                    <li><a href="myaccount.php">mijn account</a></li>
                    <li class="shoppingcart"><a href="shoppingcart.php"><img class="shoppingcartimg" src="img/shopping-cart12.png" width="20"/> winkelwagen</a><li>
                    <li><a href="index.php">afmelden</a><li>
                </ul>
            </div>
        </div>
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
                    $product = DB::start()->get(array('id','name','description','price'), 'product', array(array('supplier_id', '=', '1')))->results();
                    foreach($orders as $key => $order) {
                ?>
                    <div class="product">
                        <div class="productimg">
                            <img class="img" src="img/inductiewarmer.jpg"/>
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
