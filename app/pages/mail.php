<?php
$name = $_POST['name'];
$mail = $_POST['mail'];
$tel = $_POST['phone'];
$subject = "Contact via website over: ".$_POST['subject'];
$message = $_POST['message'];
$to = 'arnold8520@gmail.com';

$body = "$name\n $mail\n $tel\n $subject\n\n $message";

if ($_POST['send']){
  if (isset ($_POST['name']) && isset ($_POST['mail']) && isset ($_POST['subject']) && isset ($_POST['message'])){
    if (mail ($to, $subject, $body)) {
    echo '<p>Uw bericht is verzonden.</p>';
  } else {
    echo '<p>Something went wrong</p>';
    }
  }else {
    echo '<p>vul alle gegeves in </p>';
  }
}
?>
