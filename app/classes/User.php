<?php
/*
 *  Author: Yannick Berendsen 
 *  Datum: 25-11-2015
 *  Classe: User Class
 *  Desc: route bepaald de route van de website
 *
 */

class User{
    
    private $root, $extension;
    public $get;
    
    public function __construct($db){
        $this->db = $db;
        $this->db->start();
        $this->initializeUser();
    }
    
    private function initializeUser(){
        foreach($_SESSION['_user'] as $key => $value){
            $this->$key = $value;
        }
        
        if ($this->userLevel() == 0) {
            $sql = $this->db->get('*', 'customer', array(array('user_id', '=', $this->id())))->results();
            foreach ($sql as $std) {
                if ($std->company_name == null) {
                    $this->company = false;
                } else {
                    $this->company = true;
                    $this->tax = $std->company_taxnumber;
                    $this->company_name = $std->company_name;
                }
                
                $sql = $this->db->start()->get('*', 'city', array(array('id', '=', $std->city_id)))->results();
                $this->city = $sql[0]->cityname;
                $this->country = $sql[0]->country;
                $this->street = $std->street;
                $this->phone_number = $std->phone_number;
                $this->zip = $std->zip;
                $this->housenumber = $std->housenumber;
                $this->addition = $std->addition;
            }
        }
    }
    public function id(){
        return $this->id;
    }
    
    public function error()
    {
        if (isset($this->error)) {
            return $this->error;
        } else {
            return false;
        }
    }

    public function lastname(){
        return $this->lastname;
    }
    
    public function firstname(){
        return $this->firstname;
    }
    
    public function email(){
        return $this->email;
    }
    
    public function userLevel(){
        return $this->userLevel;
    }
    
    public function phone_number()
    {
        return $this->phone_number;
    }
    public function street()
    {
        return $this->street;
    }
    public function housenumber()
    {
        return $this->housenumber;
    }
    public function addition()
    {
        return $this->addition;
    }
    public function zip()
    {
        return $this->zip;
    }
    
    public function city()
    {
        return $this->city;
    }
    public function country()
    {
        return $this->country;
    }
    public function tax()
    {
        if (isset($this->tax)) {
            return $this->tax;
        } else {
            return;
        }
    }
    public function company_name()
    {
        if (isset($this->company_name)) {
            return $this->company_name;
        } else {
            return;
        }
    }
    public function company()
    {
        return $this->company;
    }
    
    protected function getuserLevel($userid){
        /*
         *  1 = Admin
         *  2 = Moderator
         */
        $data = $this->db->start()->get('*','employee', array(array('user_id', '=', $userid)))->first();
        if(empty($data)){
            return 0;
        }else{
            return $data->moderator;
        }
    }
    
    // Pas de sessie aan 
    public function checkUserSettings(){
        $data = $this->db->start()->get('*','user', array(array('id', '=', $_SESSION['_user']['id'])))->first();
        $_SESSION['_user'] = array('id' => $data->id, 'firstname' => $data->firstname, 'lastname' => $data->lastname, 'email' => $data->email, 'userLevel' => $this->getuserLevel($data->id));    
    }
    
    public function isAdmin(){
        if($this->userLevel != 1){
            header('Location: index.php');
        }
    }
    
    public function update($newuser, $olduser)
    {
        if (!isset($newuser['company'])) {
            $this->company = false;
            $newuser['company_name'] = '';
        }
        foreach ($newuser as $key => $value) {
            $this->$key = $value;
        }
        if (empty($this->firstname)) {
            $this->error = "Uw voornaam is niet ingevuld!";
        } elseif (empty($this->lastname)) {
            $this->error = "Uw achternaam is niet ingevuld!";
        } elseif (empty($this->email)) {
            $this->error = "Uw email is niet ingevuld!";
        } elseif (empty($this->zip)) {
            $this->error = "Uw postcode is niet ingevuld!";
        } elseif (empty($this->street)) {
            $this->error = "Uw straat is niet ingevuld!";
        } elseif (empty($this->housenumber)) {
            $this->error = "Uw huisnummer is niet ingevuld!";
        } elseif (empty($this->city)) {
            $this->error = "Uw plaats is niet ingevuld!";
        } elseif (empty($this->country)) {
            $this->error = "Uw land is niet ingevuld!";
        } elseif (empty($this->phone_number)) {
            $this->error = "Uw telefoonnummer is niet ingevuld!";
        } elseif (empty($this->company_name) && $this->company) {
            $this->error = "Uw bedrijfsnaam is niet ingevuld!";
        } elseif ($this->company && empty($this->tax)) {
            $this->error = "Uw BTW-nummer is niet ingevuld!";
        } elseif (!array_search($this->country, $this->Landen())) {
            $this->error = "Dit land bestaat niet!";
        } elseif (!is_numeric($this->housenumber) || strlen($this->housenumber) > 7) {
            $this->error = "Dit is een ongeldig huisnummer!";
        } elseif (strlen($this->phone_number) > 16) {
            $this->error = "Dit is een ongeldig telefoonnummmer!";
        } elseif (filter_var($this->email, FILTER_VALIDATE_EMAIL) === false) {
            $this->error = "Dit is een ongeldig email adres!";
        } else {
            $sql = $this->db->start()->get('id', 'user', array(array('email', '=', $this->email)))->results();
            foreach ($sql as $user) {
                if($user->id != $this->id()){
                    $this->error = "Dit email adres bestaat al!";
                    break;
                }
            }

            if ($this->country == "Nederland") {
                $zip = str_replace(' ', '', $this->zip);
                $numericzip = $zip[0] . $zip[1] . $zip[2] . $zip[3];
                if (strlen($zip) != 6) {
                    $this->error = "Er is een ongeldige postcode ingevuld!";
                } elseif (!is_numeric($numericzip)) {
                    $this->error = "Er is een ongeldige postcode ingevuld!";     
                } elseif (!ctype_alpha($zip[4]) || !ctype_alpha($zip[5])) {
                    $this->error = "Er is een ongeldige postcode ingevuld!";
                }
            }

            //UPDATE
            $this->db->start()->update('user', array(   'firstname' => $this->firstname,
                                                        'lastname' => $this->lastname,
                                                        'email' => $this->email), array(array('id', '=', $this->id())));
            $sql = $this->db->start()->get('id', 'city', array(array('cityname', '=', $this->city), array('country', '=', $this->country)))->results();
            if (empty($sql)) {
                $this->db->start()->insert('city', array('cityname' => $this->city, 'country' => $this->country));
            }
            $sql = $this->db->start()->get('id', 'city', array(array('cityname', '=', $this->city), array('country', '=', $this->country)))->results();
            $city_id = $sql[0]->id;
            $this->db->start()->update('customer', array('city_id' => $city_id,
                                                            'street' => $this->street,
                                                            'zip' => $this->zip,
                                                            'housenumber' => $this->housenumber,
                                                            'addition' => $this->addition,
                                                            'phone_number' => $this->phone_number,
                                                            'company_name' => $this->company_name,
                                                            'company_taxnumber' => $this->tax), array(array('user_id', '=', $this->id())));
            $sql = $this->db->start()->get('id', 'city', array(array('cityname', '=', $olduser->city()), array('country', '=', $olduser->country())))->results();
            $oldCity_id = $sql[0]->id;
            $sql = $this->db->start()->get('city_id', 'customer', array(array('city_id', '=', $oldCity_id)))->results();
            if (empty($sql)) {
                $this->db->start()->delete('city', array(array('id', '=', $oldCity_id)));
            }
            $_SESSION['_user']['firstname'] = $this->firstname;
            $_SESSION['_user']['lastname'] = $this->lastname;
            $_SESSION['_user']['email'] = $this->email;
            
        }
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
            'AX' => 'Aland'
        );
    }

    public function ArrayShit()
    {
        $row = 1;
        if (($handle = fopen("http://localhost/file.csv", "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $num = count($data);
                $row++;
                echo '"';
                for ($c=0; $c < $num; $c++) {
                    echo $data[$c] . '",<br />';
                }
            }
        }
        fclose($handle);
    }
}