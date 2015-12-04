<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set("log_errors", 1);
ini_set("error_log", "/errors.log");
spl_autoload_register(function ($class) {
    include 'app/classes/' . $class . '.php';
});
$db = new Database;
$Route = new Route($db);
$Register = new Register($db);
$Login = new Login($db);
$Category = new Category($db);
?>
<!DOCTYPE html>
<html>
    <head>
        <title>DeServiceGroup</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <script type="text/javascript" src="js/jquery.js"/></script>
    </head>
    <body>
        <div class="header">
            <div class="wrapper">
                <div class="sitenameblock"><a class="sitename" href="index.php"><span class="bold">Deservice</span><span class="italic">Group</span></a></div>
                <ul class="forheader">
                    <li><a href="aboutus.php">over ons</a></li>
                    <li><a href="webshop.php">webshop</a></li>
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
                <div class="wrapper">
                    <div class="fourthheader">

                    </div>
                </div>
            </div>
        </div>
        <div class="wrapper">
            <div class="textheader">

            </div>
        </div>
        <?php
            /*
             *  Hier word de route van de website bepaald.
             *  Aan de hand van $_GET['page'] word bepaald welke pagina word ingeladen.
             *  @author: Yannick Berendsen
             */
            if(isset($_GET['page'])){
               include($Route->request($_GET));
            }elseif(isset($_GET['cmspage'])){
                include($Route->request($_GET));
            }
        ?>
    </body>
</html>
