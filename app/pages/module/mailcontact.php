<?php
/*
Author: Arnold Buntsma
09-12-2015
*/
$name = $_POST['name'];
$mail = $_POST['mail'];
$tel = $_POST['phone'];
$captcha = $_POST['g-recaptcha-response'];
$subject = "Contact via website over: ".$_POST['subject'];
$message = $_POST['message'];
$to = 'theservicegroup@solcom.nl';

$body = "$name\n$mail\n$tel\n\n$message";


if ($_POST['send']){
  if (isset ($_POST['name']) && isset ($_POST['mail']) && isset ($_POST['subject']) && isset ($_POST['message'])){
    if (mail ($to, $subject, $body)) {
    echo '<p>Uw bericht is verzonden.</p><a href="http://localhost/creativeflowz/index.php?page=contact">Terug naar de site</a>';
  } else {
    echo '<p>Something went wrong</p>';
    }
  }else {
    echo '<p>vul alle gegeves in </p>';
  }
}
?>
