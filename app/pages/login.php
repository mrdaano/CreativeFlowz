<?php
    if(isset($_POST['login'])){
        $Login->inputFields($_POST);
        $Login->verificate();
        
        $msg = $Login->getError();
    }
    if(isset($_POST['register'])){
        $Register->inputFields($_POST);
        $Register->verificate();
        $regMSG = $Register->getError();
        $reggMSG = $Register->getNotification();
    }
?>
<div class="login">
    <h3 class="login">inloggen</h3>
    <?php if(isset($msg)){ echo $msg; }?>
    <form method="post" class="login">
      <table class="login">
        <tr>
          <td>e-mail</td>
          <td rowspan=3 class="line"></td>
          <td><input type="text" name="mail" class="login"></td>
        </tr>
        <tr>
          <td>wachtwoord</td>
          <td><input type="password" name="password" class="login"></td>
        </tr>
        <tr>
          <td></td>
          <td><input type="submit" name="login" value="inloggen" class="loginBtn"></td>
        </tr>
      </table>
    </form>
    <a href="index.php?page=forgotpassword" class="login">wachtwoord vergeten</a>
</div>

<div class="login">
  <h3 class="login">registreren</h3>
  <?php if(isset($regMSG)){ echo $regMSG; }?>
  <?php if(isset($reggMSG)){ echo $reggMSG; }?>
  <form method="post" class="login">
    <table class="login">
      <tr>
        <td>voornaam</td>
        <td rowspan="9" class="line"></td>
        <td><input type="text" name="firstname" class="login" ></td>
      </tr><tr>
        <td>achternaam</td>
        <td><input type="text" name="lastname" class="login"></td>
      </tr><tr>
        <td>e-mail</td>
        <td><input type="text" name="mail" class="login" ></td>
      </tr><tr>
        <td>telefoon</td>
        <td><input type="text" name="phone_number" class="login">
      </tr><tr>
        <td>woonplaats</td>
        <td><input type="texr" name="city" class="login" ></td>
      </tr><tr>
        <td>straat</td>
        <td><input type="text" name="street" class="login"></td>
      </tr><tr>
        <td>huisnummer</td>
        <td><input type="text" name="number" class="login" ></td>
      </tr><tr>
        <td>btw-nummer</td>
        <td><input type="text" name="taxnumber" class="login" id="btw" placeholder="optioneel">
      </tr><tr>
        <td></td>
        <td><input type="submit" name="register" value="registreren" class="loginBtn">
      </tr>
    </table>
  </form>
</div>

