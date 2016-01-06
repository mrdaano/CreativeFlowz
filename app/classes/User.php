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
            $this->error = "Uw telefoonnummr is niet ingevuld!";
        } elseif (empty($this->company_name) && $this->company) {
            $this->error = "Uw bedrijfsnaam is niet ingevuld!";
        } elseif ($this->company && empty($this->tax)) {
            $this->error = "Uw BTW-nummer is niet ingevuld!";
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
}