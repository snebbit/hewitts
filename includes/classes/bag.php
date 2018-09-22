<?php

class Bag extends Chewitts{
    
    public $id;
    
    function __construct(){
        
    }
    
    function getAllRegions(){
        $outArray=array();
        $result=$this->query("select * from regions order by region_id asc");
        while($resultArray=$result->fetch_assoc()){
            $outArray[]=$resultArray;
        }
        return $outArray;
    }
    
    function getById($id){
        $this->id=$id;
        $result=$this->query("select * from regions where region_id='$this->id' limit 1");
        $resultArray=$result->fetch_assoc();
        $this->name=$resultArray['name'];
    }
    
    function getTotalBagged(){
        $result=$this->query("select bag_id from bags where user_id=1 group by summit_id");
        return $result->num_rows;
    }
    
    function getBagsBySummit($id){
         $outArray=array();
        $result=$this->query("select * from bags where summit_id='$id' order by date desc");
        while($resultArray=$result->fetch_assoc()){
            $outArray[]=$resultArray;
        }
        return $outArray;
    }
    
    
    
}





?>