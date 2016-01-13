<?php
$response = '';
if(isset($_POST['change_pass'])){
    $Login->sendPassword($_POST['mail']);
    if($Login->getError() != NULL){
        $response = $Login->getError();
    }
    if($Login->getMSG() != NULL){
        $response = $Login->getMSG();
    }
}
?>
<div class="login">
<h3 class="login">wachtwoord vergeten?</h3><br/>
<?=$response?>
<form class="login" method="post">
  <input type="text" name="mail" class="login" placeholder='Vul hier je E-Mail adres in!'><br/><br/>
  <input type="submit" name="change_pass" value="vraag nieuw wachtwoord aan" class="loginBtn">
</form>
</div>