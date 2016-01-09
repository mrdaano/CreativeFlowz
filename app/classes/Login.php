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
                $_SESSION['_user'] = array('id' => $data->id, 'firstname' => $data->firstname, 'lastname' => $data->lastname, 'email' => $data->email, 'userLevel' => $this->userLevel($data->id));
                switch($this->userLevel($data->id)){
                    case 0: $page = 'index.php?page=customer'; break;
                    case 1: $page = 'index.php?page=cms'; break;
                    default: $page = 'index.php'; break;
                }
                echo '<script type="text/javascript">window.location.href = "'.$page.'";</script>';
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