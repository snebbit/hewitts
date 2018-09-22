<?php

class Summit extends Chewitts{
    
    public $id;
    public $name;
    public $altitude;
    public $latitude;
    public $longitude;
    public $grid_ref;
    public $grid_sheet;
    public $grid_north;
    public $grid_east;
    public $region_id;
    public $image_bg;
    public $image_bg_attribution;
    
    function __construct(){
        
    }
    
    function getById($id){
        $this->id=$id;
        $result=$this->query("select *,summits.name as name,regions.name as region_name,summits.image_bg as image_bg,summits.image_bg_attribution as image_bg_attribution from summits left join regions on regions.region_id=summits.region where summit_id='$this->id' limit 1");
        echo mysqli_error($this->db);
        $resultArray=$result->fetch_assoc();
        $this->name=$resultArray['name'];
        $this->altitude=$resultArray['altitude'];
        $this->latitude=$resultArray['lat'];
        $this->longitude=$resultArray['long'];
        $this->grid_ref=$resultArray['grid_ref'];
        $this->grid_sheet=$resultArray['grid_sheet'];
        $this->grid_north=$resultArray['grid_north'];
        $this->grid_east=$resultArray['grid_east'];
        $this->region_id=$resultArray['region_id'];
        $this->region_name=$resultArray['region_name'];
        $this->image_bg=$resultArray['image_bg'];
        $this->image_bg_attribution=$resultArray['image_bg_attribution'];
    }
    
    function getAllSummits(){
        $outArray=array();
        $result=$this->query("select * from summits left join bags on bags.summit_id=summits.summit_id where region='$this->id' order by name asc");
        while ($summit=$result->fetch_assoc()) {
            $outArray[]=$summit;
        }
        return $outArray;
    }
    
    function getTotalSummits(){
        if($this->excludeIreland) $result=$this->query("select summit_id from summits where region!=10");
        else $result=$this->query("select summit_id from summits");
        return $result->num_rows;
    }
    
    function viewSummit($id=null){
        if($id) $this->id=$id;
        $this->getById($this->id);
        
        echo '<h1>'.$this->name.'</h1>';
        
    }
    
    
}