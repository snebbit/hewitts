<?php

class Region extends Chewitts{
    
    public $id;
    public $name;
    public $totalSummits;
    public $totalBags;
    public $image_bg;
    public $image_bg_attribution;
    
    function __construct(){
        $this->generateCache();
    }
    
    function generateCache(){
        if(!file_exists('var/cache/summits.cache')){
            $summits=$this->getAllSummits();
            $myfile = fopen("var/cache/summits.cache", "w") or die("Unable to open file!");
            fwrite($myfile, json_encode($summits));
            fclose($myfile);
        }
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
        $this->image_bg=$resultArray['image_bg'];
        $this->image_bg_attribution=$resultArray['image_bg_attribution'];
    }
    
    function getSummits($all=false){
        $outArray=array();
        if($all) $result=$this->query("select *,summits.summit_id as summit_id from summits left join bags on bags.summit_id=summits.summit_id order by name asc");
        $result=$this->query("select *,summits.summit_id as summit_id from summits left join bags on bags.summit_id=summits.summit_id where region='$this->id' order by name asc");
        $this->totalSummits=0;
        $this->totalBagged=0;
        while ($summit=$result->fetch_assoc()) {
            $outArray[]=$summit;
            $this->totalSummits++;
            if(strlen($summit['user_id'])>0) $this->totalBagged++;
        }
        return $outArray;
    }
    
    function getAllSummits(){
        $outArray=array();
        if($this->excludeIreland) $qstring="select *,summits.summit_id as summit_id from summits left join bags on bags.summit_id=summits.summit_id where region<10 order by name asc";
        else $qstring="select *,summits.summit_id as summit_id from summits left join bags on bags.summit_id=summits.summit_id order by name asc";
        $result=$this->query($qstring);
        while ($summit=$result->fetch_assoc()) {
            $outArray[]=$summit;
        }
        return $outArray;
    }
    
    function getRegionMapJs($all=false){
        if($all) $summits=$this->getAllSummits();
        else $summits=$this->getSummits();
        $out='var markers = ['."\r\n";
        foreach($summits as $summit){
            
            $out.= "['".str_replace("'","",$summit['name'])."',".$summit['lat'].",".$summit['long'];
            if($summit['user_id']==1) $out.=',1'; else $out.=',0';
            $out.="],\r\n";
        }
        $out.='];'."\r\n";
        return $out;
    }
    
    function viewRegion($id=null){
        if($id) $this->id=$id;
        $this->getById($this->id);
        $summits=$this->getSummits();
        echo '<h2>'.$this->name;
        if(_mode!='region') echo ' <a href="region/'.$this->id.'/" class="btn btn-xs btn-default">View Region</a>';
        if(_mode!='region') echo '  <small>'.$this->totalBagged.'/'.$this->totalSummits.'</small>';;
        echo '</h2>';
        ?>
        <table id="example" class="table table-striped table-bordered table-condensed" cellspacing="0" width="100%" data-sortable>
        <thead>
            <tr>
                <th>Name</th>
                <th>Alt (m)</th>
                <th class="text-center">Done</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>Name</th>
                <th>Alt (m)</th>
                <th class="text-center">Done</th>
            </tr>
        </tfoot>
        <tbody>
            <?php
            foreach($summits as $summit){
                echo '<tr';
                if(strlen($summit['user_id']>0)) echo ' class="success"';
                else echo ' class="danger"';
                echo '>';
                    echo '<td>';
                    echo '<a href="summit/'.$summit['summit_id'].'/">';
                    echo $summit['name'].'</a></td>';
                    echo '<td>'.$summit['altitude'].'</td>';
                    echo '<td class="text-center">';
                        if(strlen($summit['user_id']>0)) echo '<span class="glyphicon glyphicon-check"></span>';
                    echo '</td>';
                echo '</tr>';   
            }
            ?>
        </tbody>
    </table>
        <?php
        
    }
    
    function genericMapInit($zoomLevel=10){
        ?>
        var map;
        var bounds = new google.maps.LatLngBounds();
        var mapOptions = {
            mapTypeId: 'roadmap'
        };
                        
        // Display a map on the page
        map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
        map.setTilt(45);
            
        
                            
        // Info Window Content
        var infoWindowContent = [
            ['<div class="info_content">' +
            '<h3>London Eye</h3>' +
            '<p>The London Eye is a giant Ferris wheel situated on the banks of the River Thames. The entire structure is 135 metres (443 ft) tall and the wheel has a diameter of 120 metres (394 ft).</p>' +        '</div>'],
            ['<div class="info_content">' +
            '<h3>Palace of Westminster</h3>' +
            '<p>The Palace of Westminster is the meeting place of the House of Commons and the House of Lords, the two houses of the Parliament of the United Kingdom. Commonly known as the Houses of Parliament after its tenants.</p>' +
            '</div>']
        ];
            
        // Display multiple markers on a map
        var infoWindow = new google.maps.InfoWindow(), marker, i;
        
        // Loop through our array of markers & place each one on the map  
        for( i = 0; i < markers.length; i++ ) {
            var position = new google.maps.LatLng(markers[i][1], markers[i][2]);
            bounds.extend(position);
            if(markers[i][3]==1){
                var theIcon='https://maps.google.com/mapfiles/kml/pushpin/grn-pushpin.png';
            }
            else{
                var theIcon='https://maps.google.com/mapfiles/kml/pushpin/red-pushpin.png';
            }
            marker = new google.maps.Marker({
                position: position,
                map: map,
                title: markers[i][0],
                icon: theIcon
            });
            
            // Allow each marker to have an info window    
            google.maps.event.addListener(marker, 'click', (function(marker, i) {
                return function() {
                    infoWindow.setContent(infoWindowContent[i][0]);
                    infoWindow.open(map, marker);
                }
            })(marker, i));
    
            // Automatically center the map fitting all markers on the screen
            map.fitBounds(bounds);
        }
    
        // Override our map zoom level once our fitBounds function runs (Make sure it only runs once)
        var boundsListener = google.maps.event.addListener((map), 'bounds_changed', function(event) {
            this.setZoom(<?php echo $zoomLevel;?>);
            google.maps.event.removeListener(boundsListener);
        });
    <?php
    }
    
    
}





?>