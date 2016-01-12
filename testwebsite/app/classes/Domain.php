<?php
/*
 *  Author: Yannick Berendsen
 *  Datum: 25-11-2015
 *  Classe: Domain Class
 *
 */

class Domain{
    
    protected $data;
    
    public function __construct($db){
        $this->db = $db;
    }
    
    public function indicator($id){
        $this->id = $id;
    }
    
    public function inputFields($array){
        foreach($array as $val => $key){
            $this->$val = $key;
        }
    }
    
    protected function checkName(){
        $this->db->start()->get('*','domain', array(array('url', '=', $this->url), array('id', '!=', $this->id)))->first();
        if($this->db->start()->count() < 1){
            return false;
        }else{
            return true;
        }
    }
    
    public function returnDomains($plain = false, $selectname){
        $Domains = $this->db->start()->get('*','domain')->results();
        if($plan != false){
            foreach($Domains as $domaindata){
                echo $domaindata->url;
            }
        }else{
            echo '<select name="'.$selectname.'">';
            foreach($Domains as $domaindata){
                echo '<option value="'.$domaindata->id.'">'.$domaindata->url.'</option>';
            }
            echo '</select>';
        }
    }
    public function getDomain(){
        return $this->db->start()->get('*','domain')->results();
    }
    
    public function domainData($id){
        $this->id = $id;
        $data = $this->db->start()->get('*','domain', array(array('id', '=', $this->id)))->first();
        
        if($this->db->start()->count() < 1){
            die('<a href="index.php?page=cms&module=domainmanagement"><button>Dit domain bestaat niet klik hier om terug te gaan!</button></a>');
        }else{
            return $data;
        } 
    }
    
    public function verificate(){
        if(empty($this->name)){
            $this->setError('U heeft geen naam ingevuld!');
        }elseif(empty($this->url)){
            $this->setError('U heeft geen url ingevuld!');
        }elseif($this->checkName() == true){
            $this->setError('U heeft een URL ingevuld die al bestaat!');
        }else{
            $this->db->start()->update('domain', array('name' => $this->name, 'url' => $this->url), array('id' => $this->id));
            $this->setMSG('De informatie van dit domain naam is succesvol geupdate!');
        }
    }
    
    public function newDomain(){
       if(empty($this->url)){
            $this->setError('U heeft geen URL ingevuld!');
        }elseif(empty($this->name)){
            $this->setError('U heeft geen naam ingevuld!');
        }elseif($this->checkName() == true){
            $this->setError('U heeft een URL ingevuld die al bestaat!');
        }else{
            $this->db->start()->insert('domain', array(
                                            'name' => $this->name, 'url' => $this->url));
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
    
    public function getsiteID($url){
        if (strpos($url, 'http://www.') !== false) {
            $url = str_replace('http://www.', '', $url);
        }
        
        if (strpos($url, 'https://www.') !== false) {
            $url = str_replace('https://www.', '', $url);
        }
        
        $domainData = $this->db->start()->get('*','domain', array(array('url', '=', $url)))->first();
        
        if($domainData == ''){
            $this->content = 'Oeps, er kon geen pagina data worden opgehaald want het domein komt niet in het database voor!';
        }else{
            $pageData = $this->db->start()->get('*','page_management', array(array('domain_id', '=', $domainData->id)))->first();
            if($pageData == ''){
                $this->content = 'Oeps, er kon geen pagina data worden opgehaald want er is geen pagina gekoppeld aan dit domein!';
            }else{
                $this->content = $pageData->content;
            }
        }
    }
    
    public function getDomainContent(){
        echo '<div class="wrapper">';
        echo $this->content;
        echo '</div>';
    }
}