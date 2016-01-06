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
}