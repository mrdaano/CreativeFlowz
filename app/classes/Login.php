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
    
    public function verificate(){
        if(empty($this->mail) OR empty($this->password)){
            $this->setError('Beiden velden moeten ingevuld worden!');
        }elseif (filter_var($this->mail, FILTER_VALIDATE_EMAIL) === false) {
            $this->setError('Dit is geen E-Mail adres!');
        }else{
            $this->password = hash('sha256', $this->password);
            $data = $this->db->start()->get('*','user', array(array('email', '=', $this->mail), array('password', '=', $this->password)))->first();
            
            if($data == '' OR empty($data)){
                $this->setError('De combinatie tussen E-Mail en Password is ongeldig!');
            }else{
                $_SESSION['_user'] = array('id' => $data->id, 'firstname' => $data->firstname, 'lastname' => $this->lastname, 'email' => $this->email);
                header('Location:  ');
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