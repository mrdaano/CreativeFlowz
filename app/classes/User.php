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
}