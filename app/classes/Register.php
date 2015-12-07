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
    
    protected function emptyFields($fields){
    
    }
    
    public function getError($error){
        return $error;
    }
    
}