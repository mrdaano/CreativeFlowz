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
$Domain = new Domain($db);
$Page = new Page($db);

//$actual_link = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; 
$actual_link = "http://www.deservicegroup.dev/testwebsite/";
$Domain->getsiteID($actual_link);

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
    </head>
    <body>
        
        <div class="header">
            <div class="wrapper">
                <div class="sitenameblock"><a class="sitename" href="index.php"><span class="bold">Deservice</span><span class="italic">Group</span></a></div>
                <ul class="forheader">
                    <li><a href="/index.php?page=webshop">webshop</a></li>
                    <li><a href="/index.php?page=contact">contact</a></li>
                </ul>
            </div>
        </div>
        
        <?php
           echo $Domain->getDomainContent(); 
        ?>
    </body>
</html>
