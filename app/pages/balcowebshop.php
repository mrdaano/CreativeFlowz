        <div class="header">
            <div class="wrapper">
                <div class="sitenameblock"><a class="sitename" href="index.php"><span class="bold">Theservice</span><span class="italic">Group</span></a></div>
                <ul class="forheader">
                    <li><a href="aboutus.php">over ons</a></li>
                    <li class="active"><a href="webshop.php">webshop</a></li>
                    <li><a href="contact.php">contact</a></li>
                </ul>
                <ul class="rightlist">
                    <li><a href="login.php">aanmelden</a></li>
                </ul>
            </div>
        </div>
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
                    $product = DB::start()->get(array('id','name','description','price'), 'product', array(array('supplier_id', '=', '2')))->results();
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
