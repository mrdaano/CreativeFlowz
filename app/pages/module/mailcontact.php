<?php
/*
Author: Arnold Buntsma
09-12-2015
*/

$name = $_POST['name'];
$mail = $_POST['mail'];
$tel = $_POST['phone'];
$subject = "Contact via website over: ".$_POST['subject'];
$message = $_POST['message'];
$to = 'info@theservicegroup.nl';

$captcha_response = $_POST['g-recaptcha-response'];
$secret = "6LdUCxUTAAAAAMoMNjH9ldbG8I3PvSQehxSPThvU";
$user_ip = $_SERVER['REMOTE_ADDR'];

if (empty($_POST['name'])
    || empty($_POST['mail'])
    || empty($_POST['subject'])
    || empty($_POST['message'])
    || empty($_POST['g-recaptcha-response'])
    ){
header("Location: http://{$_SERVER['HTTP_HOST']}{$_SERVER['SCRIPT_NAME']}?page=contact");
}

$mail_message = "$name\n$mail\n$tel\n\n$message";

$captcha_verify = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secret."&response=".$captcha_response."&remoteip=".$_SERVER['REMOTE_ADDR']);
if ($captcha_verify.success==false){
  die();
}else{

  if ($_POST['send']){
    if (mail ($to, $subject, $mail_message)) {
    echo '<p>Uw bericht is verzonden.</p><a href="http://localhost/creativeflowz/index.php?page=contact">Terug naar de site</a>';
    } else {
      echo '<p>Something went wrong</p>';
      }
    }else {
      echo '<p>vul alle gegeves in </p>';
    }
  }
?>
