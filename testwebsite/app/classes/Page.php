<?php
/*
 *  Author: Yannick Berendsen
 *  Datum: 25-11-2015
 *  Classe: Login Class
 *  Desc: route bepaald de route van de website
 *
 */

class Page{
    
    protected $data;
    
    public function __construct($db, $Cookie){
        $this->db = $db;
        $this->cookie = $Cookie;
    }
    
    public function indicator($id){
        $this->id = $id;
    }
    
    public function inputFields($array){
        foreach($array as $val => $key){
            $this->$val = $key;
            $this->cookie->__set($val, $key);
        }
    }
    
    public function getPage(){
        return $this->db->start()->get('*','page_management')->results();
    }
    
    public function getDomain($domain){
        $this->domain = $domain;
        $data = $this->db->start()->get('*','domain', array(array('id', '=', $this->domain)))->first();

        if($this->db->start()->count() < 1){
            return 'Niet gekoppeld!';
        }else{
            return $data->name;
        }
    }
    
    public function pageData($id){
        $this->id = $id;
        $data = $this->db->start()->get('*','page_management', array(array('id', '=', $this->id)))->first();
        
        if($this->db->start()->count() < 1){
            die('<a href="index.php?page=cms&module=page"><button>Deze pagina bestaat niet klik hier om terug te gaan!</button></a>');
        }else{
            return $data;
        } 
    }
    
    public function getHomepage(){
        $data = $this->db->start()->get('*','page_management', array(array('homepage', '=', '1')))->first();
        if($this->db->start()->count() > 0){
            return $data->content;
        }else{
            echo '<h1>Welkom op The Service Group</h1>';
        }
    }
    
    public function isHomepage(){
        $data = $this->db->start()->get('*','page_management', array(array('homepage', '=', '1'), array('id', '=', $this->id)))->first();
        if($this->db->start()->count() > 0){
           return "<input class='btn' type='button' value='Ingesteld als Homepage' style='background-color:#6785A2;cursor:not-allowed;'>";
        }else{
           return "<input class='btn' type='button' onclick='setHomepage()' value='Zet Homepage'>";
        }
    }
    
    public function checkHomePage($id){
        $this->id = $id;
        $data = $this->db->start()->get('*','page_management', array(array('homepage', '=', '1'), array('id', '=', $this->id)))->first();
        if($this->db->start()->count() > 0){
           return "Ja";
        }else{
           return "Nee";
        }
    }
    
    public function verificate(){
        if(empty($this->title)){
            $this->setError('U heeft geen titel ingevuld!');
        }elseif(empty($this->keyword)){
            $this->setError('U heeft geen keywoorden ingevuld!');
        }elseif(empty($this->name)){
            $this->setError('U heeft geen naam ingevuld!');
        }elseif(empty($this->content)){
            $this->setError('U heeft geen content ingevuld!');
        }else{
            $this->db->start()->update('page_management', array('title' => $this->title, 'keyword' => $this->keyword, 'content' => $this->content), array('id' => $this->id));
            $this->setMGS('De pagina is succesvol geupdate!');
        }
    }
    
    protected function checkName(){
        $this->db->start()->get('*','page_management', array(array('name', '=', $this->name)))->first();
        if($this->db->start()->count() < 1){
            return false;
        }else{
            return true;
        }
    }
    
    public function newPage(){
        if(empty($this->title)){
            $this->setError('U heeft geen titel ingevuld!');
        }elseif(empty($this->keyword)){
            $this->setError('U heeft geen keywoorden ingevuld!');
        }elseif(empty($this->content)){
            $this->setError('U heeft geen content ingevuld!');
        }elseif(empty($this->name)){
            $this->setError('U heeft geen naam ingevuld!');
        }elseif($this->checkName() == true){
            $this->setError('U heeft een naam ingevuld die al bestaat!');
        }else{
            $this->db->start()->insert('page_management', array(
                                            'name' => $this->name, 'title' => $this->title,
                                            'content' => $this->content, 'keyword' => $this->keyword, 'domain_id' => $this->domain));
            $this->setMSG('De pagina is succesvol aangemaakt!');
        } 
    }
    
    private function setError($error){
        $this->error = $error;
    }
    
    public function getError(){
        return $this->error;
        unset($this->error);
    }
    
    private function setMSG($msg){
        $this->msg = $msg;
    }
    
    public function getMSG(){
        return $this->msg;
    }

}