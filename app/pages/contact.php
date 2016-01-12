<?php
// define variables and set to empty values
$nameErr = $emailErr = $genderErr = $messageErr = $subjectErr = $captchaErr = "";
$name = $email = $gender = $message = $subject = $tel = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   if (empty($_POST["name"])) {
     $nameErr = "Uw naam is vereist";
   } else {
     $name = $_POST["name"];
     // check if name only contains letters and whitespace
     if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
       $nameErr = "Uw naam mag alleen uit letters en spaties bestaan";
     }
   }

   if (empty($_POST["mail"])) {
     $emailErr = "Uw e-mail is vereist";
   } else {
     $email = $_POST["mail"];
     // check if e-mail address is well-formed
     if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
       $emailErr = "Vul een correct e-mail adres in";
     }
   }

   if (empty($_POST["subject"])) {
     $subjectErr = "Een onderwerp is vereist";
   } else {
     $subject = $_POST["subject"];
   }

   if (empty($_POST["message"])) {
     $messageErr = "Een berichicht is vereist";
   } else {
     $message = $_POST["message"];
   }
   if (empty($_POST['phone'])){
     $tel= "";
   }else {
     $tel = $_POST['phone'];
   }
   if (empty($_POST['g-recaptcha-response'])){
     $captchaErr = "Captcha is vereist";
   }
}
?>

<div class="thirdheader">
    <div class="wrapper">
        <div class="fourthheader">
          <table class="thirdheadertable">
            <tr class="thirdheaderhead">
                <td class='textintable'>contact</td>
            </tr>
              <tr class="thirdheaderdata">
                <td class="textintable">De servicegroup</td>
              </tr>
              <tr class="thirdheaderdata">
                <td class="textintable">Bart de Jong</td>
              </tr><tr class="thirdheaderdata">
                  <td class="textintable">De Karekiet 32</td>
              </tr><tr class="thirdheaderdata">
                <td class="textintable">7671 LA Vriezenveen</td>
              </tr><tr class="thirdheaderdata">
                <td class="textintable">The Netherlands</td>
              </tr><tr class="thirdheaderdata">
                <td class="textintable">Telefoon: +31546-564663</td>
              </tr><tr class="thirdheaderdata">
                <td class="textintable">Fax: +31546-642186</td>
              </tr><tr class="thirdheaderdata">
                <td class="textintable">Mobiel: +31653234496</td>
              </tr><tr class="thirdheaderdata">
                <td class="textintable">E-mail: info@theservicegroup.nl</td>
              </tr><tr class="thirdheaderdata">
                <td class="textintable">K.v.k. Enschede nummer: 06083741</td>
              </tr>
          </table>
    </div>
</div>
<div class="wrapper">
    <div class="textheader">
      <p class="contact"> Wilt u contact met ons opnemen, dat kan ook met onderstaand formulier of de gegevens aan de linkerkant</p>
      <br/><br/>
      <p><span class="error">* vereist veld.</span></p>
      <form method="post" class="contact" action="app/pages/module/mailcontact.php">
        Naam<br/><input type="text" name="name" class="login" value="<?php echo $name;?>">
        <span class="error">* <?php echo $nameErr;?></span><br/>
        E-mail<br/><input type="text" name="mail" class="login" value="<?php echo $email;?>">
        <span class="error">* <?php echo $emailErr;?></span><br/>
        Telefoon<br/><input type="text" name="phone" class="login" value="<?php echo $tel;?>"><br/>
        Onderwerp<br/><input type="text" name="subject" class="login" value="<?php echo $subject;?>">
        <span class="error">* <?php echo $subjectErr;?></span><br/>
        Bericht<br/><textarea name="message" rows="10" cols="40" class="contact" value="<?php echo $message;?>"></textarea>
        <span class="error">* <?php echo $messageErr;?></span><br/><br/>
        <div class="g-recaptcha" data-sitekey="6LdUCxUTAAAAAJDMYzFoW3eBP9avxZP2MO0W-ZLj"></div>
        <span class="error">* <?php echo $captchaErr;?></span><br/>
        <input type="submit" name="send" value="verzenden" class="loginBtn">
      </form>
    </div>
</div>
