<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set("log_errors", 1);
ini_set("error_log", "errors.log");
spl_autoload_register(function ($class) {
    include 'app/classes/' . $class . '.php';
});
$db = new Database;
$Route = new Route($db);
$Register = new Register($db);
$Login = new Login($db);
if($_SESSION['_user']['id'] > 0){
    $User = new User($db);
    
}
$Page = new Page($db);
?>
<!DOCTYPE html>
<html>
    <head>
        <title>DeServiceGroup</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
        <script src='js/plugin/texteditor/jquery-te-1.4.0.min.js' type='text/javascript'></script>
        <link href='js/plugin/texteditor/jquery-te-1.4.0.css' rel='stylesheet' type='text/css'>
        <script src="js/plugin/ckeditor/ckeditor.js"></script>
        <script src="js/plugin/ckeditor/sample.js"></script>
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
                <div class="sitenameblock"><a class="sitename" href="index.php"><span class="bold">Deservice</span><span class="italic">Group</span></a></div>
                <ul class="forheader">
                    <li><a href="index.php?page=aboutus">over ons</a></li>
                    <li><a href="index.php?page=webshop">webshop</a></li>
                    <li><a href="index.php?page=contact">contact</a></li>
                </ul>
                <ul class="rightlist">
                    <?php
                    
                    if($_SESSION['_user']['id'] > 0){
                        ?>
                         <li class="shoppingcart"><a href="index.php?page=shoppingcart"><img class="shoppingcartimg" src="img/shopping-cart12.png" width="20"/> winkelwagen</a><li>
                         <li><a href="index.php?page=customer">mijn account</a></li> | <li><a href="index.php?page=loguit">loguit</a></li>
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
               include($Route->request($_GET));
            }elseif(isset($_GET['cmspage'])){
                include($Route->request($_GET));
            }else{
                echo '<div class="wrapper">';
                echo $Page->getHomepage();
                echo '</div>';
            }   
        ?>
        
    </body>
</html>
