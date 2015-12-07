<!DOCTYPE html>
<html>
    <head>
        <title>Contact</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="css/style.css">
    </head>
    <body>
        <div class="header">
            <div class="wrapper">
                <div class="sitenameblock"><a class="sitename" href="index.php"><span class="bold">Theservice</span><span class="italic">Group</span></a></div>
                <ul class="forheader">
                    <li><a href="aboutus.php">over ons</a></li>
                    <li><a href="webshop.php">webshop</a></li>
                    <li class="active"><a href="contact.php">contact</a></li>
                </ul>
                <ul class="rightlist">
                    <li><a href="login.php">aanmelden</a></li>
                </ul>
            </div>
        </div>
        <div class="secondheader">
            <div class="wrapper"></div>
        </div>
        <div class="thirdheader">
            <div class="wrapper">
                <div class="fourthheader">
                  <table class="thirdheadertable">
                    <tr class="thirdheaderhead">
                      <td class="textintable">contact</td>
                    </tr>
                    <tr class="thirdheaderdata">
                      <td class="textintable">De servicegroup</td>
                    </tr>
                    <tr class="thirdheaderdata">
                      <td class="textintable">Bart de Jong</td>
                    </tr>
                    <tr class="thirdheaderdata">
                        <td class="textintable">De Karekiet 32</td>
                    </tr>
                    <tr class="thirdheaderdata">
                      <td class="textintable">7671 LA Vriezenveen</td>
                    </tr>
                    <tr class="thirdheaderdata">
                      <td class="textintable">The Netherlands</td>
                    </tr>
                    <tr class="thirdheaderdata">
                      <td class="textintable">Telefoon: +31546-564663</td>
                    </tr>
                    <tr class="thirdheaderdata">
                      <td class="textintable">Fax: +31546-642186</td>
                    </tr>
                    <tr class="thirdheaderdata">
                      <td class="textintable">Mobiel: +31653234496</td>
                    </tr>
                    <tr class="thirdheaderdata">
                      <td class="textintable">E-mail: moetnogkomen@idk.com</td>
                    </tr>
                    <tr class="thirdheaderdata">
                      <td class="textintable">K.v.k. Enschede nummer: 06083741</td>
                    </tr>
                  </table>
            </div>
        </div>
        <div class="wrapper">
            <div class="textheader">
              <br/><br/><br/><br/><br/>
              <p class="login"> Wilt u contact met ons opnemen, kan dat ook met onderstaand formulier</p>
              <br/>
              <form method="post">
                Naam<br/><input type="text" name="name" class="login"><br/>
                E-mail<br/><input type="text" name="mail" class="login"><br/>
                Telefoon<br/><input type="text" name="phone" class="login"><br/>
                Onderwerp<br/><input type="text" name="subject" class="login"><br/>
                Bericht<br/><textarea name="message" rows="10" cols="40" class="contact"></textarea><br/>
                <input type="submit" name="send" value="verzenden" class="loginBtn">
              </form>
            </div>
        </div>
    </body>
</html>
