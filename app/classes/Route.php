<?php
/*
 *  Author: Yannick Berendsen 
 *  Datum: 25-11-2015
 *  Classe: route Class
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
     *  Bekijkt welke pagina ingeladen moet worden als bestand en welke vanuit het database.
     *  Wanneer de route true is mag de pagina worden ingeladen, is die false gaat hij door naar de 404 pagina.
     *
     *  $_GET['page'] word aangeroepen voor een pagina.
     *  $_GET['sub'] word aangeroepen als er een pagina uit het database moet worden aangeroepen
     *  $_GET['page'] = 'cms', dit gebruik je wanneer een pagina uit het db komt.
     *  $_GET['cmspage'] is voor het cms.
     *  $_GET['module'] is het onderdeel dat cmspage aanroept.
     *
     *  Voorbeeld pagina die aangemaapt is in het mapje: app/pages/
     *  Het bestandje bestaat daar altijd. De $_GET moet dus altijd gelijk zijn aan het bestandje zonder de .php extensie.
     *  Voorbeeld:
     *  app/pages/aboutus.php dan word de link: www.website.nl?page=aboutus
     *
     *  Voorbeeld pagina die binnen het cms valt (dus je moet ingelogd zijn)
     *  www.website.nl?index.php?page=cms&sub=mediabeheer /// page=cms zijn pagina's uit het cms -> database
     *
     *  Voorbeeld pagina IN het cms
     *  index.php?cmspage&module=modulenaam
     *  
     */
    public function request($get){
        $this->get = $get;
        $root = 'app/pages';
        $cms = 'app/cms';
        $extension = '.php';
            
        if(isset($this->get['page'])){
            /*
            * Het is een pagina die niet een module is
            * Dan gaan we checken of de pagina uit het database komt, komt hij niet uit het database dan halen we hem uit het mapje app/pages
            */
            
            if(file_exists($root.'/'.$this->get['page'].''.$extension)){
                /*
                 * Check of die in het DB voor MOET komen
                 */
                
                if(isset($_GET['sub'])){
                    $res = $this->db->get('*','page_management', array(array('name', '=', $_GET['sub'])))->first();
                    if($res->name == ''){
                        $include = $root.'/404.php';
                    }else{
                        //$include = 'index.php?page=site&sub='.$_GET['sub'];
                        $include = $root.'/site.php';
                    }
                }else{
                    $include = $root.'/'.$_GET['page'].''.$extension; 
                }
            }else{
                $include = 'app/pages/404.php';
            }
        }elseif(isset($this->get['cmspage'])){
            /*
             *  cmspage is het cms gedeelte, hierin staan de modules, je kunt hier alleen bij komen wanneer je ingelogd bent
             */
            if($_SESSION['_user']['id'] > 0){
                /*
                 *  Wanneer de gebruiker is ingelogd en hij rechten tot de pagina heeft mag hij hier komen.
                 */
                /*
                 *if(!file_exists($cms.'/modules/'.$_GET['module'].$extension)){
                   $include = 'app/pages/404.php';
                }else{
                */
                    if(isset($_GET['module'])){
                        $include = $cms.'/modules/'.$_GET['module'].$extension.'';
                    }else{
                        $include = $cms.'/cms'.$extension;
                    }
                //}
            }else{
                $include = $root.'/login'.$extension;
            }
        }
        return $include;
    }
    
    public function getDbPage($name){
        // Voorbeeld Link: index.php?page=site&sub=Test%20Test
       if($name != ''){
             $res = $this->db->get('*','page_management', array(array('name', '=', $_GET['sub'])))->first();
             echo $res->content;
        }
    
        unset($id);
    }
}