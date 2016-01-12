<?php
    if(isset($_POST['login'])){
        $Login->inputFields($_POST);
        $Login->verificate();
        
        $msg = $Login->getError();
    }
    if (isset($_POST['country'])) {
      $country = $_POST['country'];
    } else {
      $country = 'Nederland';
    }

    if (isset($_POST['register'])) {
      $Register->inputFields($_POST);
      $Register->verificate();
      if(!$Register->getError()) {
        $email = $_POST['mail'];
      }
    } 

?>
<div class="login">
    <h3 class="login">inloggen</h3>
    <form method="post" class="login">
      <table class="login">
        <tr>
          <td>e-mail</td>
          <td rowspan=3 class="line"></td>
          <td><input type="text" name="mail" class="login" value="<?= $email ?>"></td>
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
  <?php 
    if (!$Register->getError() && isset($_POST['register'])) {
        echo '<h3 class="login">' . $Register->getNotification() . "</h3>";
        echo '<br><a href="/">Klik hier om terug te gaan</a>';
    }
    if($Register->getError() || !isset($_POST['register'])) { ?>
      <h3 class="login">registreren</h3>
      <?php if ($Register->getError()) {
        echo '<div class="error">';
        foreach ($Register->getError() as $error) {
          echo '<br>'. $error;
        }
        echo "</div>";
      } ?>
      <form method="post" class="login" >
        <table class="login">
          <tr>
            <td>voornaam</td>
            <td rowspan="15" class="line"></td>
            <td><input type="text" name="firstname" class="login" placeholder="Jan" value="<?= $_POST['firstname'] ?>"></td>
          </tr><tr>
            <td>achternaam</td>
            <td><input type="text" name="lastname" class="login" placeholder="Jansen"  value="<?= $_POST['lastname'] ?>"></td>
          </tr><tr>
            <td>e-mail</td>
            <td><input type="text" name="mail" class="login" placeholder="jan@jansen.nl"  value="<?= $_POST['mail'] ?>"></td>
          </tr><tr>
            <td>telefoon</td>
            <td><input type="text" name="phone_number" class="login" placeholder="0612345678"  value="<?= $_POST['phone_number'] ?>"></td>
          </tr><tr>
          </tr><tr>
            <td>postcode</td>
            <td><input type="text" name="zip" class="login" placeholder="1234AB"  value="<?= $_POST['zip'] ?>"></td>
          </tr><tr>
            <td>huisnummer</td>
            <td><input type="text" name="number" class="login" placeholder="381"  value="<?= $_POST['number'] ?>"></td>
          </tr><tr>
            <td>toevoeging</td>
            <td><input type="text" name="addition" class="login" placeholder="b"  value="<?= $_POST['addition'] ?>"></td>
          </tr><tr>
            <td>straat</td>
            <td><input type="text" name="street" class="login" placeholder="Kalverstraat"  value="<?= $_POST['street'] ?>"></td>
          </tr><tr>
            <td>woonplaats</td>
            <td><input type="texr" name="city" class="login" placeholder="Amsterdam"  value="<?= $_POST['city'] ?>"></td>
          </tr><tr>
          <td>land</td>
            <td><select name="country" class="login">
              <?php 
              foreach ($Register->landen() as $key => $land) { ?>
                <option id="<?= $land ?>" <?php if($land == $country) { echo 'selected'; } ?>><?= $land ?></option>
              <?php } ?>
            </select></td>
          </tr><tr>
          </tr><tr>
            <td>naam van bedrijf</td>
            <td><input type="text" name="company" class="login" placeholder="Optioneel"  value="<?= $_POST['company'] ?>">
          </tr><tr>
            <td>btw-nummer</td>
            <td><input type="text" name="taxnumber" class="login"  value="<?= $_POST['taxnumber'] ?>">
          </tr><tr>
            <td></td>
            <td><input type="submit" name="register" value="registreren" class="loginBtn">
          </tr>
        </table>
      </form>
  <?php } ?>
</div>

