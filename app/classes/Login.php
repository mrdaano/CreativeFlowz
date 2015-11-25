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
        if(empty($this->email) OR empty($this->password)){
            self::setError('Beiden velden moeten ingevuld worden!');
        }elseif (!filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            self::setError('Dit is geen E-Mail adres!');
        }else{
            $this->password = hash('sha256', $this->password);
            $data = $this->db->get('*','users', array(array('email', '=', $this->email), array('password', '=', $this->password)))->first();
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