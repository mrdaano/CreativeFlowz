<!DOCTYPE html>
<html>
    <head>
        <title>Aanmelden</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="css/style.css">
    </head>
    <body>
        <div class="header">
            <div class="wrapper">
                <div class="sitenameblock"><a class="sitename" href="index.html"><span class="bold">Deservice</span><span class="italic">Group</span></a></div>
                <ul class="forheader">
                    <li><a href="aboutus.html">over ons</a></li>
                    <li><a href="webshop.html">webshop</a></li>
                    <li><a href="contact.html">contact</a></li>
                </ul>
                <ul class="rightlist">
                    <li class="active">aanmelden</li>
                </ul>
            </div>
        </div>
        <br/><br/><br/>
        <div class="login">
            <h3 class="login">inloggen</h3>
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
            <a href="forgotpassword.php" class="login">wachtwoord vergeten?</a>
        </div>
        <br/><br/>
        <div class="login">
          <h3 class="login">registreren</h3>
          <form method="post" class="login">
            <table class="login">
              <tr>
                <td>voornaam</td>
                <td rowspan="9" class="line"></td>
                <td><input type="text" name="firstname" class="login"></td>
              </tr><tr>
                <td>achternaam</td>
                <td><input type="text" name="lastname" class="login"></td>
              </tr><tr>
                <td>e-mail</td>
                <td><input type="text" name="mail" class="login"></td>
              </tr><tr>
                <td>telefoon</td>
                <td><input type="text" name="phone_number" class="login">
              </tr><tr>
                <td>woonplaats</td>
                <td><input type="texr" name="city" class="login"></td>
              </tr><tr>
                <td>straat</td>
                <td><input type="text" name="street" class="login"></td>
              </tr><tr>
                <td>huisnummer</td>
                <td><input type="text" name="number" class="login"></td>
              </tr><tr>
                <td>btw-nummer</td>
                <td><input type="text" name="taxnumber" class="login" id="btw" value="optioneel" onfocus="if (this.value == 'optioneel') {this.value = '';}">
              </tr><tr>
                <td></td>
                <td><input type="submit" name="register" value="registreren" class="loginBtn">
              </tr>
            </table>
          </form>
        </div>
    </body>
</html>
