<?php

class Collection extends Chewitts{
    
    public $id;
    public $name;
    
    function __construct(){
        
    }
    
    function getAllCollections(){
        $outArray=array();
        $result=$this->query("select * from collections order by collection_id asc");
        while($resultArray=$result->fetch_assoc()){
            $outArray[]=$resultArray;
        }
        return $outArray;
    }
    
    function getById($id=null){
        if(!isset($this->id) AND $id) $this->id=$id;
        $result=$this->query("select * from collections where collection_id='$this->id' limit 1");
        $resultArray=$result->fetch_assoc();
        $this->name=$resultArray['name'];
    }

    
    
}





?>