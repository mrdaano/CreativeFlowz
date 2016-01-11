<?php
    if(isset($_POST['login'])){
        $Login->inputFields($_POST);
        $Login->verificate();
        
        $msg = $Login->getError();
    } elseif (isset($_POST['register'])) {
      $Register->inputFields($_POST);
      $Register->verificate();
      if($Register->getError()) {
        $error = $Register->getError(); 
      } else {
        echo "<h1>" . $Register->getNotification() . "</h1>";
      }
    }


    $landen = array(
            'AF' => 'Afghanistan',
            'AL' => 'Albanië',
            'DZ' => 'Algerije',
            'AS' => 'Amerikaans-Samoa',
            'VI' => 'Amerikaanse Maagdeneilanden',
            'AD' => 'Andorra',
            'AO' => 'Angola',
            'AI' => 'Anguilla',
            'AQ' => 'Antarctica',
            'AG' => 'Antigua en Barbuda',
            'AR' => 'Argentinië',
            'AM' => 'Armenië',
            'AW' => 'Aruba',
            'AU' => 'Australië',
            'AZ' => 'Azerbeidzjan',
            'BS' => 'Bahama\'s',
            'BH' => 'Bahrein',
            'BD' => 'Bangladesh',
            'BB' => 'Barbados',
            'BE' => 'België',
            'BZ' => 'Belize',
            'BJ' => 'Benin',
            'BM' => 'Bermuda',
            'BT' => 'Bhutan',
            'BO' => 'Bolivia',
            'BA' => 'Bosnië en Herzegovina',
            'BW' => 'Botswana',
            'BV' => 'Bouvet',
            'BR' => 'Brazilië',
            'IO' => 'Brits Territorium in de Indische Oceaan',
            'VG' => 'Britse Maagdeneilanden',
            'BN' => 'Brunei',
            'BG' => 'Bulgarije',
            'BF' => 'Burkina Faso',
            'BI' => 'Burundi',
            'KH' => 'Cambodja',
            'CA' => 'Canada',
            'CF' => 'Centraal-Afrikaanse Republiek',
            'CL' => 'Chili',
            'CN' => 'China',
            'CX' => 'Christmaseiland',
            'CC' => 'Cocoseilanden',
            'CO' => 'Colombia',
            'KM' => 'Comoren',
            'CG' => 'Congo-Brazzaville',
            'CD' => 'Congo-Kinshasa',
            'CK' => 'Cookeilanden',
            'CR' => 'Costa Rica',
            'CU' => 'Cuba',
            'CY' => 'Cyprus',
            'DK' => 'Denemarken',
            'DJ' => 'Djibouti',
            'DM' => 'Dominica',
            'DO' => 'Dominicaanse Republiek',
            'DE' => 'Duitsland',
            'EC' => 'Ecuador',
            'EG' => 'Egypte',
            'SV' => 'El Salvador',
            'GQ' => 'Equatoriaal-Guinea',
            'ER' => 'Eritrea',
            'EE' => 'Estland',
            'ET' => 'Ethiopië',
            'FO' => 'Faeröer',
            'FK' => 'Falklandeilanden',
            'FJ' => 'Fiji',
            'PH' => 'Filipijnen',
            'FI' => 'Finland',
            'FR' => 'Frankrijk',
            'GF' => 'Frans-Guyana',
            'PF' => 'Frans-Polynesië',
            'TF' => 'Franse Zuidelijke en Antarctische Gebieden',
            'GA' => 'Gabon',
            'GM' => 'Gambia',
            'GE' => 'Georgië',
            'GH' => 'Ghana',
            'GI' => 'Gibraltar',
            'GD' => 'Grenada',
            'GR' => 'Griekenland',
            'GL' => 'Groenland',
            'GP' => 'Guadeloupe',
            'GU' => 'Guam',
            'GT' => 'Guatemala',
            'GG' => 'Guernsey',
            'GN' => 'Guinee',
            'GW' => 'Guinee-Bissau',
            'GY' => 'Guyana',
            'HT' => 'Haïti',
            'HM' => 'Heard en McDonaldeilanden',
            'HN' => 'Honduras',
            'HU' => 'Hongarije',
            'HK' => 'Hongkong',
            'IE' => 'Ierland',
            'IS' => 'IJsland',
            'IN' => 'India',
            'ID' => 'Indonesië',
            'IQ' => 'Irak',
            'IR' => 'Iran',
            'IM' => 'Isle of Man',
            'IL' => 'Israël',
            'IT' => 'Italië',
            'CI' => 'Ivoorkust',
            'JM' => 'Jamaica',
            'JP' => 'Japan',
            'YE' => 'Jemen',
            'JE' => 'Jersey',
            'JO' => 'Jordanië',
            'KY' => 'Kaaimaneilanden',
            'CV' => 'Kaapverdië',
            'CM' => 'Kameroen',
            'KZ' => 'Kazachstan',
            'KE' => 'Kenia',
            'KG' => 'Kirgizië',
            'KI' => 'Kiribati',
            'UM' => 'Kleine Pacifische eilanden van de Verenigde Staten',
            'KW' => 'Koeweit',
            'HR' => 'Kroatië',
            'LA' => 'Laos',
            'LS' => 'Lesotho',
            'LV' => 'Letland',
            'LB' => 'Libanon',
            'LR' => 'Liberia',
            'LY' => 'Libië',
            'LI' => 'Liechtenstein',
            'LT' => 'Litouwen',
            'LU' => 'Luxemburg',
            'MO' => 'Macau',
            'MK' => 'Macedonië',
            'MG' => 'Madagaskar',
            'MW' => 'Malawi',
            'MV' => 'Maldiven',
            'MY' => 'Maleisië',
            'ML' => 'Mali',
            'MT' => 'Malta',
            'MA' => 'Marokko',
            'MH' => 'Marshalleilanden',
            'MQ' => 'Martinique',
            'MR' => 'Mauritanië',
            'MU' => 'Mauritius',
            'YT' => 'Mayotte',
            'MX' => 'Mexico',
            'FM' => 'Micronesia',
            'MD' => 'Moldavië',
            'MC' => 'Monaco',
            'MN' => 'Mongolië',
            'ME' => 'Montenegro',
            'MS' => 'Montserrat',
            'MZ' => 'Mozambique',
            'MM' => 'Myanmar',
            'NA' => 'Namibië',
            'NR' => 'Nauru',
            'NL' => 'Nederland',
            'AN' => 'Nederlandse Antillen',
            'NP' => 'Nepal',
            'NI' => 'Nicaragua',
            'NC' => 'Nieuw-Caledonië',
            'NZ' => 'Nieuw-Zeeland',
            'NE' => 'Niger',
            'NG' => 'Nigeria',
            'NU' => 'Niue',
            'KP' => 'Noord-Korea',
            'MP' => 'Noordelijke Marianen',
            'NO' => 'Noorwegen',
            'NF' => 'Norfolk',
            'UG' => 'Oeganda',
            'UA' => 'Oekraïne',
            'UZ' => 'Oezbekistan',
            'OM' => 'Oman',
            'TL' => 'Oost-Timor',
            'AT' => 'Oostenrijk',
            'PK' => 'Pakistan',
            'PW' => 'Palau',
            'PS' => 'Palestijnse Autoriteit',
            'PA' => 'Panama',
            'PG' => 'Papoea-Nieuw-Guinea',
            'PY' => 'Paraguay',
            'PE' => 'Peru',
            'PN' => 'Pitcairneilanden',
            'PL' => 'Polen',
            'PT' => 'Portugal',
            'PR' => 'Puerto Rico',
            'QA' => 'Qatar',
            'RO' => 'Roemenië',
            'RU' => 'Rusland',
            'RW' => 'Rwanda',
            'RE' => 'Réunion',
            'KN' => 'Saint Kitts en Nevis',
            'LC' => 'Saint Lucia',
            'VC' => 'Saint Vincent en de Grenadines',
            'BL' => 'Saint-Barthélemy',
            'PM' => 'Saint-Pierre en Miquelon',
            'SB' => 'Salomonseilanden',
            'WS' => 'Samoa',
            'SM' => 'San Marino',
            'ST' => 'Sao Tomé en Principe',
            'SA' => 'Saoedi-Arabië',
            'SN' => 'Senegal',
            'RS' => 'Servië',
            'SC' => 'Seychellen',
            'SL' => 'Sierra Leone',
            'SG' => 'Singapore',
            'SH' => 'Sint-Helena',
            'MF' => 'Sint-Maarten',
            'SI' => 'Slovenië',
            'SK' => 'Slowakije',
            'SD' => 'Soedan',
            'SO' => 'Somalië',
            'ES' => 'Spanje',
            'SJ' => 'Spitsbergen en Jan Mayen',
            'LK' => 'Sri Lanka',
            'SR' => 'Suriname',
            'SZ' => 'Swaziland',
            'SY' => 'Syrië',
            'TJ' => 'Tadzjikistan',
            'TW' => 'Taiwan',
            'TZ' => 'Tanzania',
            'TH' => 'Thailand',
            'TG' => 'Togo',
            'TK' => 'Tokelau-eilanden',
            'TO' => 'Tonga',
            'TT' => 'Trinidad en Tobago',
            'TD' => 'Tsjaad',
            'CZ' => 'Tsjechië',
            'TN' => 'Tunesië',
            'TR' => 'Turkije',
            'TM' => 'Turkmenistan',
            'TC' => 'Turks- en Caicoseilanden',
            'TV' => 'Tuvalu',
            'UY' => 'Uruguay',
            'VU' => 'Vanuatu',
            'VA' => 'Vaticaanstad',
            'VE' => 'Venezuela',
            'GB' => 'Verenigd Koninkrijk',
            'AE' => 'Verenigde Arabische Emiraten',
            'US' => 'Verenigde Staten',
            'VN' => 'Vietnam',
            'WF' => 'Wallis en Futuna',
            'EH' => 'Westelijke Sahara',
            'BY' => 'Wit-Rusland',
            'ZM' => 'Zambia',
            'ZW' => 'Zimbabwe',
            'ZA' => 'Zuid-Afrika',
            'GS' => 'Zuid-Georgië en de Zuidelijke Sandwicheilanden',
            'KR' => 'Zuid-Korea',
            'SE' => 'Zweden',
            'CH' => 'Zwitserland',
            'AX' => 'Aland'
        );
?>
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
    <a href="index.php?page=forgotpassword" class="login">wachtwoord vergeten</a>
</div>

<div class="login">
  <h3 class="login">registreren</h3>
  <form method="post" class="login" >
    <table class="login">
      <tr>
        <td>voornaam</td>
        <td rowspan="15" class="line"></td>
        <td><input type="text" name="firstname" class="login" placeholder="Jan"></td>
      </tr><tr>
        <td>achternaam</td>
        <td><input type="text" name="lastname" class="login" placeholder="Jansen"></td>
      </tr><tr>
        <td>e-mail</td>
        <td><input type="text" name="mail" class="login" placeholder="jan@jansen.nl"></td>
      </tr><tr>
        <td>telefoon</td>
        <td><input type="text" name="phone_number" class="login" placeholder="0612345678"></td>
      </tr><tr>
      </tr><tr>
        <td>postcode</td>
        <td><input type="text" name="zip" class="login" placeholder="1234AB"></td>
      </tr><tr>
        <td>huisnummer</td>
        <td><input type="text" name="number" class="login" placeholder="381"></td>
      </tr><tr>
        <td>toevoeging</td>
        <td><input type="text" name="addition" class="login" placeholder="b"></td>
      </tr><tr>
        <td>straat</td>
        <td><input type="text" name="street" class="login" placeholder="Kalverstraat"></td>
      </tr><tr>
        <td>woonplaats</td>
        <td><input type="texr" name="city" class="login" placeholder="Amsterdam"></td>
      </tr><tr>
      <td>land</td>
        <td><select name="country" class="login">
          <?php 
          foreach ($landen as $key => $land) { ?>
            <option id="<?= $land ?>" <?php if($key == 'NL') { echo 'selected'; } ?>><?= $land ?></option>
          <?php } ?>
        </select></td>
      </tr><tr>
      </tr><tr>
        <td>naam van bedrijf</td>
        <td><input type="text" name="company" class="login" placeholder="Optioneel">
      </tr><tr>
        <td>btw-nummer</td>
        <td><input type="text" name="taxnumber" class="login">
      </tr><tr>
        <td></td>
        <td><input type="submit" name="register" value="registreren" class="loginBtn">
      </tr>
    </table>
  </form>
</div>

