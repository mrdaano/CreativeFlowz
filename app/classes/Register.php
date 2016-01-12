<?php
/*
 *  Author: Yannick Berendsen
 *  Datum: 25-11-2015
 *  Classe: Login Class
 *  Desc: route bepaald de route van de website
 *
 */

class Register{
    
    public $fields;
    
    public function __construct($db){
        $this->db = $db;
    }
    
    public function inputFields($array){
        foreach($array as $val => $key){
            $this->$val = $key;
        }
    }
    
    private function createRandomPassword(){
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        $this->plain_password = implode($pass);
        $this->crypted_password = hash('sha256', implode($pass));
    }
    
    public function verificate(){
        if(empty($this->mail)){
            $this->setError('Het e-mail adres is niet ingevuld!');
        }if(empty($this->firstname)){
            $this->setError('Uw voornaam is niet ingevuld!');
        }if(empty($this->lastname)){
            $this->setError('Uw achternaam is niet ingevuld!');
        }if(empty($this->phone_number)){
            $this->setError('Uw telefoon-nummer is niet ingevuld!');
        }if (empty($this->zip)) {
            $this->setError("Uw postcode is niet ingevuld!");
        }if(empty($this->city)){
            $this->setError('Uw woonplaats is niet ingevuld!');
        }if(empty($this->street)){
            $this->setError('Uw straatnaam is niet ingevuld!');
        }if(empty($this->number)){
            $this->setError('Uw huisnummer is niet ingevuld!');
        }if (empty($this->country)) {
            $this->setError("Uw land is niet ingevuld!");
        }if (empty($this->taxnumber) && !empty($this->company)) {
            $this->setError("Uw BTW-nummer is niet ingevuld!");
        }if (!empty($this->taxnumber) && empty($this->company)) {
            $this->setError("Uw bedrijfsnaam is niet ingevuld");
        }if(strlen($this->number) > 7 || !is_numeric($this->number)){
            $this->setError('Dit is een ongeldig huisnummer!');
        }if(strlen($this->phone_number) > 16){
            $this->setError('Dit is een ongeldig telefoonnummer!');
        }if (filter_var($this->mail, FILTER_VALIDATE_EMAIL) === false) {
            $this->setError('Dit is een ongeldig email adres!');
        }if($this->checkMail() == true){
            $this->setError('Dit email adres bestaat al!');
        }if ($this->country == "Nederland") {
            $zip = str_replace(' ', '', $this->zip);
            $numericzip = $zip[0] . $zip[1] . $zip[2] . $zip[3];
            if (strlen($zip) != 6) {
                $this->setError("Er is een ongeldige postcode ingevuld!");
            } elseif (!is_numeric($numericzip)) {
                $this->setError("Er is een ongeldige postcode ingevuld!");   
            } elseif (!ctype_alpha($zip[4]) || !ctype_alpha($zip[5])) {
                $this->setError("Er is een ongeldige postcode ingevuld!");
            }
        }
        if (empty($this->error)) {
            $this->createAccount();
            $this->sendMail();
            echo $this->plain_password;
            $this->setNotification('U bent succesvol geregistreerd, we hebben een mail verstuurd met daarin uw wachtwoord naar het E-Mail adres '.$this->mail.'!');
        }
    }
    
    private function sendMail(){
        $to      = $this->mail;
        $subject = 'Welkom bij The Service Group';
        
        $message ="
        <!DOCTYPE HTML PUBLIC 
        'http://www.w3.org/TR/html4/loose.dtd'>
        <html>
        <head></head>
        <body>
        <h1>Welkom bij The Service Group</h1>
        Beste ".$this->firstname." ".$this->lastname.",<br/>
        <br/>
        Hierbij bevestigen wij uw aanmelding op <a href='www.theservicegroup.nl' target='_blanc'>theservicegroup.nl</a>.<br/>
        Het systeem heeft automatisch een wachtwoord voor u gemaakt. U kunt eventueel later uw wachtwoord aanpassen via uw account instellingen.<br/>
        <br/>
        <b>Hier onder staan de gegevens voor het inloggen op <a href='www.theservicegroup.nl' target='_blanc'>theservicegroup.nl</a></b><br/>
        <b>Inlog:</b> ".$this->mail."<br/>
        <b>Wachtwoord:</b> ".$this->plain_password."<br/>
        <br/>
        Mocht u nog vragen hebben kunt u mailen naar <b>bart@theservicegroup.nl</b>.
        <Br/><br/>
        Met vriendelijke groet,<br/>
        <br/>
        The Service Group
        </body>
        </html>";
        
        
        $headers = "From: noreplay@theservicegroup.nl\n";
        $headers .= "MIME-Version: 1.0\n" ;
        $headers .= "Content-Type: text/html; charset=\"iso-8859-1\"\n";

        // $headers = 'From: no-replay@theservicegroup.nl' . "\r\n" .'X-Mailer: PHP/' . phpversion();
        mail($to, $subject, $message, $headers);
    }
    
    private function checkMail(){
        $this->db->start()->get('*','user', array(array('email', '=', $this->mail)))->first();
        if($this->db->start()->count() < 1){
            return false;
        }else{
            return true;
        }
    }
    
    private function checkCity(){
        $data = $this->db->start()->get('*','city', array(array('cityname', '=', $this->city)))->first();
        if(!empty($data)){
            return $data->id;
        }else{
            $this->db->start()->insert('city', array(
                                            'country' => 'Nederland', 'cityname' => $this->city));
            $data = $this->db->start()->lastId();
            return $data;
        }
    }
    
    private function createAccount(){
        $this->createRandomPassword();
        $this->db->start()->insert('user', array(
                                            'firstname' => $this->firstname, 'lastname' => $this->lastname,
                                            'password' => $this->crypted_password, 'email' => $this->mail));
        
        $userID = $this->db->start()->lastId();
        
        if (empty($this->addition)) {
            $this->addition = null;
        }

        $this->db->start()->insert('customer', array(
                                            'user_id' => $userID, 
                                            'city_id' => $this->checkCity(), 'street' => $this->street,
                                            'zip' => $this->zip, 'housenumber' => $this->number,
                                            'addition' => $this->addition, 'phone_number' => $this->phone_number
                                            ));
    }

    protected function setError($error){
        $this->error[] = $error;
        //$this->error = $error;
    }
    
    public function getError(){
        return $this->error;
    }
    
    protected function setNotification($msg){
        $this->msg = $msg;
    }
    
    public function getNotification(){
        return $this->msg;
    }

    public function Landen()
    {
        return array(
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
            'AX' => 'Aland');
    }
    
}