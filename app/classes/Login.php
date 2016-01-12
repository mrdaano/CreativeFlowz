<?php
/*
 *  Author: Yannick Berendsen
 *  Datum: 25-11-2015
 *  Classe: Login Class
 *  Desc: route bepaald de route van de website
 *
 */

class Login{
    
    public $email, $password;
    protected $attempts;
    
    public function __construct($db){
        $this->db = $db;
    }
    
    public function inputFields($array){
        foreach($array as $val => $key){
            $this->$val = $key;
        }
    }
    
    protected function userLevel($userid){
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
    
    public function verificate(){
        if($_SESSION['loginattempt'] > 5){
            $this->setError('U heeft meer dan 5x uw wachtwoord fout getypt en kunt daarom even niet meer inloggen!');
        }elseif(empty($this->mail) OR empty($this->password)){
            $_SESSION['loginattempt'] = $_SESSION['loginattempt'] + 1;
            $this->setError('Beiden velden moeten ingevuld worden!');
        }elseif (filter_var($this->mail, FILTER_VALIDATE_EMAIL) === false) {
            $_SESSION['loginattempt'] = $_SESSION['loginattempt'] + 1;
            $this->setError('Dit is geen E-Mail adres!');
        }else{
            $this->password = hash('sha256', $this->password);
            $data = $this->db->start()->get('*','user', array(array('email', '=', $this->mail), array('password', '=', $this->password)))->first();
            
            if($data == '' OR empty($data)){
                $_SESSION['loginattempt'] = $_SESSION['loginattempt'] + 1;
                $this->setError('De combinatie tussen E-Mail en Password is ongeldig!');
            }else{
                $_SESSION['_user'] = array('id' => $data->id, 'firstname' => $data->firstname, 'lastname' => $data->lastname, 'email' => $data->email, 'userLevel' => $this->userLevel($data->id));
                switch($this->userLevel($data->id)){
                    case 0:
                    if($_SESSION['prevpage'] != 'login'){
                        $page = 'index.php?page='.$_SESSION['prevpage'];
                    }else{
                        $page = 'index.php?page=customer';
                    }
                     break;
                    case 1: $page = 'index.php?page=cms'; break;
                    default: $page = 'index.php'; break;
                }
                echo '<script type="text/javascript">window.location.href = "'.$page.'";</script>';
            }
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
    
    private function sendMail($mail){
        $to      = $mail;
        $subject = 'Wachtwoord wijziging The Service Group';
        
        $message ="
        <!DOCTYPE HTML PUBLIC 
        'http://www.w3.org/TR/html4/loose.dtd'>
        <html>
        <head></head>
        <body>
        <h1>Wachtwoord wijzigen</h1>
        Beste,<br/>
        <br/>
        Hierbij de bevestiging dat uw wachtwoord is aangepast.
        <br/>
        Uw nieuwe wachtwoord is: ".$this->plain_password." 
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
    
    public function sendPassword($mail){
        if(empty($mail)){
            $this->setError('U heeft een ongeldig E-Mail adres ingevoerd!');
        }else{
            $data = $this->db->start()->get('*','user', array(array('email', '=', $mail)))->first();
            if(empty($data)){
                $this->setError('Dit email adres bestaat niet!');
            }else{
                $this->createRandomPassword();
                $this->db->start()->update('users', array('password' => $this->crypted_password), array(array('id', '=', $data->id)));
                $this->sendMail($mail);
                $this->setMSG('We hebben uw nieuwe wachtwoord naar het opgegeven mail adres verzonden!');
            }
        }
    }
    
    protected function setError($error){
        $this->error = $error;
    }
    
    protected function setMSG($msg){
        $this->msg = $msg;
    }
    
    public function getError(){
        return $this->error;
    }
    
    public function getMSG(){
        return $this->msg;
    }
}
