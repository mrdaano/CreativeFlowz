<?php
session_start();
ob_start();
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set("log_errors", 1);
ini_set("error_log", "errors.log");
spl_autoload_register(function ($class) {
    include 'app/classes/' . $class . '.php';
});
$Cookie = new Cookie($_COOKIE);
$db = new Database;
$Route = new Route($db);
$Register = new Register($db);
$Login = new Login($db);
if($_SESSION['_user']['id'] > 0){
    $User = new User($db);
    $User->checkUserSettings();
}
$Domain = new Domain($db);
$Page = new Page($db, $Cookie);
$Product = new Product($db);
$Category = new Category($db);
$order = new Ordersystem($db);
$_SESSION['prevpage'] = $_GET['page'];  if(isset($_GET['viewproduct'])){ $_SESSION['prevpage'] .= '&viewproduct='.$_GET['viewproduct'];};
?>
<!DOCTYPE html>
<html>
    <head>
        <title>TheServiceGroup</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
        <script src='js/plugin/texteditor/jquery-te-1.4.0.min.js' type='text/javascript'></script>
        <link href='js/plugin/texteditor/jquery-te-1.4.0.css' rel='stylesheet' type='text/css'>
        <script src="js/plugin/ckeditor/ckeditor.js"></script>
        <script src="js/plugin/ckeditor/sample.js"></script>
        <script src='https://www.google.com/recaptcha/api.js'></script>
        <script type='text/javascript'>
        $( document ).ready(function() {
            //$('textarea').jqte();

            // settings of status
            var jqteStatus = true;
            $(".status").click(function()
            {
                jqteStatus = jqteStatus ? false : true;
                $('.jqte-test').jqte({"status" : jqteStatus})
            });


        });
</script>
    </head>
    <body>

        <div class="header">
            <div class="wrapper">
                <div class="sitenameblock"><a class="sitename" href="index.php"><span class="bold">Theservice</span><span class="italic">Group</span></a></div>
                <ul class="forheader">
                    <li><a href="index.php?page=aboutus">over ons</a></li>
                    <li><a href="index.php?page=webshop">webshop</a></li>
                    <li><a href="index.php?page=contact">contact</a></li>
                </ul>
                <ul class="rightlist">
                    <?php

                    if($_SESSION['_user']['id'] > 0){
                        
                        ?>
                         <?php
                         if($_SESSION['_user']['userLevel'] == 0){
                            echo '<li class="shoppingcart"><a href="index.php?page=shoppingcart"><img class="shoppingcartimg" src="img/shopping-cart12.png" width="20"/> winkelwagen</a><li>';
                            echo '<li>';
                            echo '<a href="index.php?page=customer">mijn account</a></li>';
                        }elseif($_SESSION['_user']['userLevel'] == 1){
                            echo '<li class="shoppingcart"></li>';
                            echo '<li>';
                            echo '<a href="index.php?page=cms">mijn account</a></li>';
                        }
                         ?>
                          | <li><a href="index.php?page=loguit">loguit</a></li>
                        <?php
                    }else{
                        ?>
                         <li><a href="index.php?page=login">aanmelden</a></li>
                        <?php
                    }?>

                </ul>
            </div>
        </div>
        <?php
            /*
             *  Hier word de route van de website bepaald.
             *  Zie Class: Route.php
             *  @author: Yannick Berendsen
             */
            if(isset($_GET['page'])){
                if($_GET['page'] == 'site'){
                    echo '<div class="wrapper">';
                    include($Route->request($_GET));
                    echo '</div>';
                }else{
                    include($Route->request($_GET));
                }

            }else{
                echo '<div class="wrapper">';
                echo $Page->getHomepage();
                echo '</div>';
            }
        ?>

    </body>
</html>
