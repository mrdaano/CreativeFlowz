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
                
                $this->city = $std->city_id;
                $this->street = $std->street;
                $this->phone_number = $std->phone_number;
                $this->zip = $std->zip;
                $this->housenumber = $std->housenumber;
                $this->addition = $std->addition;
            }
        }
    }

    public function housenumber()
    {
        return $this->housenumber;
    }

    public function addition()
    {
        return $this->addition;
    }

    public function company()
    {
        return $this->company;
    }

    public function city()
    {
        return  $this->city;
    }

    public function street()
    {
        return $this->street;
    }

    public function phone_number()
    {
        return $this->phone_number;
    }

    public function tax()
    {
        return $this->tax;
    }

    public function company_name()
    {
        return $this->company_name;
    }

    public function zip()
    {
        return $this->zip;
    }
    public function id()
    {
        return $this->id;
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

    public function error()
    {
        return $this->error;
    }

    
}