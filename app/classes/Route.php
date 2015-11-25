<?php
/*
 *  Author: Yannick Berendsen & Arnold Buntsma
 *  Datum: 25-11-2015
 *  Classe: Login Class
 *  Desc: route bepaald de route van de website
 *
 */

class Route{
    
    private $root, $extension;
    public $get;
    
    public function __construct($db){
        $this->db = $db;
        $this->db->start();
    }
    
    /*
     *  Bekijk welke pagina ingeladen moet worden
     */
    public function request($get){
        print_r($this->db);
        $this->get = $get;
        if(!empty($this->get)){
            $root = 'app/pages';
            $extension = '.php';
            if(file_exists($root.'/'.$this->get.''.$extension)){
               // Check of die in het DB voor MOET komen
               if(isset($_GET['sub'])){
                    $res = $this->db->get('*','page_management', array(array('id', '=', '1')))->results();
                    var_dump($res);
                    if(!empty($res)){
                        return true;
                    }else{
                        return false;
                    }
               }
               return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
}