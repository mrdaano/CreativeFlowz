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
        if($data->homepage){
            $active = 'SELECTED';
        }else{
            $active = '';
        }
        echo '<select name="homepage">';
        echo '<option value="0" '.$active.'>Nee</option>';
        echo '<option value="1" '.$active.'>Ja</option>';
        echo '</select>';
    }
    
    public function SethomePage($id){
        $this->db->start()->update('page_management', array('homepage' => 1), array(array('id', '=', $id)));
        
    }
    
    public function checkHomePage(){
        $data = $this->db->start()->get('*','page_management', array(array('homepage', '=', '1'), array('id', '=', $this->id)))->first();
        if($this->db->start()->count() > 0){
           return false;
        }else{
           return true;
        }
    }
    
    public function checkifhomepage($id){
        $data = $this->db->start()->get('*','page_management', array(array('homepage', '=', '1'), array('id', '=', $id)))->first();
        if($this->db->start()->count() > 0){
           return 'Homepage';
        }else{
           return '';
        }
    }
    
    public function verificate(){
        var_dump($this->homepage);
        if(empty($this->title)){
            $this->setError('U heeft geen titel ingevuld!');
        }elseif(empty($this->keyword)){
            $this->setError('U heeft geen keywoorden ingevuld!');
        }elseif(empty($this->name)){
            $this->setError('U heeft geen naam ingevuld!');
        }elseif(empty($this->content)){
            $this->setError('U heeft geen content ingevuld!');
        }elseif($this->checkName() == true){
            $this->setError('U heeft een naam ingevuld die al bestaat!');
        }elseif($this->checkDomain() == false){
            $this->setError('U kan niet meer dan 1 pagina aan 1 domein koppelen');
        }elseif($this->homepage != 0 AND $this->checkHomepage() == false){
            $this->setError('U heeft al een actieve pagina als homepage!');
        }else{
            if($this->domain == ''){
                $this->domain = 0;
            }
            
            
            $this->db->start()->update('page_management', array('title' => $this->title, 'keyword' => $this->keyword, 'content' => $this->content, 'domain_id' => $this->domain, 'homepage' => $this->homepage), array(array('id', '=', $this->id)));
            $this->setMSG('De pagina is succesvol geupdate!');
        }
    }
    
    protected function checkName(){
        if($this->id != NULL OR $this->id != ''){
            $this->db->start()->get('*','page_management', array(array('name', '=', $this->name), array('id', '!=', $this->id)))->first();
            if($this->db->start()->count() < 1){
                return false;
            }else{
                return true;
            }
        }else{
            $this->db->start()->get('*','page_management', array(array('name', '=', $this->name)))->first();
            if($this->db->start()->count() < 1){
                return false;
            }else{
                return true;
            }
        }  
    }
    
    protected function checkDomain(){
        if($this->domain != ''){
            $this->db->start()->get('*','page_management', array(array('domain_id', '=', $this->domain), array('id', '!=', $this->id)))->first();
            if($this->db->start()->count() > 0){
                return false;
            }else{
                return true;
            }
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
    
    public function setMSG($msg){
        $this->msg = $msg;
    }
    
    public function getMSG(){
        return $this->msg;
    }
    
    public function getPageMedia(){
        $data = $this->db->start()->get('*','media', '')->results();
        echo '<ul id="mediaitems">';
        foreach($data as $key => $val){
            echo '<li onclick="">'.$val->name.'</li>';
        }
        echo '</ul>';
    }

}