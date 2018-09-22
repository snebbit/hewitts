<?php
$summit_id=(int)$_GET['summit'];
$summit=new Summit;
$summit->getById($summit_id);
define('_mode','summit');
define('_summit_id',$summit_id);
define('_page_title',$summit->name.': Summit Details');

require_once('template/header.php');

?>
<div class="container summit">
    <div class="row">egd
            
        <div class="col-md-8">
            <?php
            
            echo '<div class="row alert alert-info">';
                echo '<div class="col-md-3">';
                    $search_keyword=str_replace(' ','+',$summit->name.' '.$summit->region_name);
                    $newhtml =file_get_html("https://www.google.com/search?q=".$search_keyword."&tbm=isch&tbs=isz:lt,islt:2mp");
                    $result_image_source = $newhtml->find('img', 0)->src;
                    echo '<img src="'.$result_image_source.'">';
                echo '</div>';
                echo '<div class="col-md-9">';
                        echo '<h1>'.$summit->name.'</h1>';
                echo '</div>';
                
            echo '</div>';


            //$bagInstance=new Bag;
            //$bags=$bagInstance->getBagsBySummit($summit->id);
            
            //foreach($bags as $bag){
                
            //}
            
            if(count($bags)==0){
                echo '<br><br><p class="alert alert-warning">No bags of this summit yet.</p>';   
            }

            
            
            ?>
        </div>
        
        <div class="col-md-4">
            <div class="alert alert-success">
                    <?php
                    echo $summit->grid_sheet.' '.$summit->grid_north.' '.$summit->grid_east;
                    echo '<br>'.$summit->latitude.','.$summit->longitude;
                    
                    echo '<h5>Region: <a href="region/'.$summit->region_id.'/">'.$summit->region_name.'</a></h5>';
                    echo '<h5>Altitude: '.$summit->altitude.'m</h5>';
                    ?>
                    
            </div>
        </div>
        
    </div>
</div>

<div id="attribution"><?php echo $summit->image_bg_attribution;?></div>

<style>
    body{
        background-image:url('media/summits/backgrounds/<?php echo $summit->image_bg;?>');
        background-size: cover;
    }
</style>

<?php

require_once('template/footer.php');