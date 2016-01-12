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
        $this->addition = 0;
        if(empty($this->mail)){
            $this->setError('Het e-mail adres is niet ingevuld!');
        }elseif(empty($this->firstname)){
            $this->setError('Uw voornaam is niet ingevuld!');
        }elseif(empty($this->lastname)){
            $this->setError('Uw achternaam is niet ingevuld!');
        }elseif(empty($this->phone_number)){
            $this->setError('Uw telefoon-nummer is niet ingevuld!');
        }elseif(empty($this->city)){
            $this->setError('Uw woonplaats is niet ingevuld!');
        }elseif(empty($this->street)){
            $this->setError('Uw straatnaam is niet ingevuld!');
        }elseif(empty($this->number)){
            $this->setError('Uw huisnummer is niet ingevuld!');
        }elseif(strlen($this->number) > 7){
            $this->setError('Dit is een ongeldig huisnummer!');
        }elseif(strlen($this->phone_number) > 16){
            $this->setError('Dit is een ongeldig telefoonnummer!');
        }elseif (filter_var($this->mail, FILTER_VALIDATE_EMAIL) === false) {
            $this->setError('Dit is een ongeldig email adres!');
        }elseif($this->checkMail() == true){
            $this->setError('Dit email adres bestaat al!');
        }else{
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
        $this->zip = '1';
        $this->createRandomPassword();
        $this->db->start()->insert('user', array(
                                            'firstname' => $this->firstname, 'lastname' => $this->lastname,
                                            'password' => $this->crypted_password, 'email' => $this->mail));
        
        $userID = $this->db->start()->lastId();
        
        
        $this->db->start()->insert('customer', array(
                                            'user_id' => $userID, 
                                            'city_id' => $this->checkCity(), 'street' => $this->street,
                                            'zip' => $this->zip, 'housenumber' => $this->number,
                                            'phone_number' => $this->phone_number
                                            
                                            ));
    }

    protected function setError($error){
        $this->error = $error;
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
    
}