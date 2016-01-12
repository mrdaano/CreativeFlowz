<?php if (isset($_POST['name']) && isset ($_POST['mail']) && isset ($_POST['subject']) && isset ($_POST['message']) && isset($_POST['g-recaptcha-response'])) {
    header("location: http://{$_SERVER['HTTP_HOST']}/app/pages/module/mailcontact.php");
}else
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
                <td class="textintable">E-mail: moetnogkomen@idk.com</td>
              </tr><tr class="thirdheaderdata">
                <td class="textintable">K.v.k. Enschede nummer: 06083741</td>
              </tr>
          </table>
    </div>
</div>
<div class="wrapper">
    <div class="textheader">
      <p class="contact"> Wilt u contact met ons opnemen, kan dat ook met onderstaand formulier of de gegevens aan de linkerkant</p>
      <br/>
      <form method="post" class="contact">
        Naam<br/><input type="text" name="name" class="login"><br/>
        E-mail<br/><input type="text" name="mail" class="login"><br/>
        Telefoon<br/><input type="text" name="phone" class="login"><br/>
        Onderwerp<br/><input type="text" name="subject" class="login"><br/>
        Bericht<br/><textarea name="message" rows="10" cols="40" class="contact"></textarea><br/>
        <div class="g-recaptcha" data-sitekey="6LdUCxUTAAAAAJDMYzFoW3eBP9avxZP2MO0W-ZLj"></div>
        <input type="submit" name="send" value="verzenden" class="loginBtn">
      </form>
    </div>
</div>
