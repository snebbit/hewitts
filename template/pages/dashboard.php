<?php

define('_mode','dashboard');
define('_page_title','Dashboard');

require_once('template/header.php');

$region=new Region;

$bag=new Bag;
$summit=new Summit;
$totalBagged=$bag->getTotalBagged();
$totalSummits=$summit->getTotalSummits();


?> 

<div class="row">
    
    <div class="col-md-3"> <?php
    $region->viewRegion(4);
    $region->viewRegion(1);
    $region->viewRegion(2);
    $region->viewRegion(8);
    $region->viewRegion(9);
    ?> </div> <?php
    
    ?> <div class="col-md-3"> <?php
    $region->viewRegion(3);
    ?> </div> <?php
    
    ?> <div class="col-md-3"> <?php
    $region->viewRegion(5);
    $region->viewRegion(6);
    ?> </div>
    
    <div class="col-md-3">
        
        <div class="alert alert-success">
            <h3><?php echo $totalBagged.' / '.$totalSummits; ?></h3>
        </div>   
        <div class="alert alert-success">
            <div id="map_wrapper">
                    <div id="map_canvas" class="mapping"></div>
            </div>
        
            <script>
                function initialize() {
                    <?php echo $region->getRegionMapJs(true);?>
                    <?php echo $region->genericMapInit(7);?>
                }
                $(document).ready(function(){
                   initialize(); 
                });
            </script>
        </div>
    </div>

</div>
<?php









require_once('template/footer.php');