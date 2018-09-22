<?php

class Chewitts{
    
    public $db;
    public $excludeIreland=true;
    public $geo_choice_regions;
    public $geo_choice;

    public function __construct(){
        $this->db = new mysqli('localhost', 'tomcalpin', '', 'hewitts');
        $this->excludeIreland=true;
        $this->geo_choice_regions=array(
            // England
            0=>array(1,2,3,4,5,7),
            // Wales
            1=>array(6,8),
            // Ireland
            2=>array(10)
            );
        $this->geo_choice=$this->getGeoChoice();
    }
    
    function query($qstring){
        $this->db = new mysqli('localhost', 'tomcalpin', '', 'hewitts');
        $result=$this->db->query($qstring);
        return $result;
    }
    
    function getGeoChoice(){
        @session_start();
        if(!isset($_SESSION['geo_choice'])){
            $this->geo_choice=array(0,1,2);
            $this->setGeoChoice($this->geo_choice);
        }
        else $this->geo_choice=unserialize($_SESSION['geo_choice']);
    }
    
    function setGeoChoice($choice){
        @session_start();
        $_SESSION['geo_choice']=serialize($choice);
    }
    
    
}
?>