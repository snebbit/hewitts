<?php
$region_id=(int)$_GET['region'];
$region=new Region;
$region->getById($region_id);
define('_mode','region');
define('_region_id',$region_id);
define('_page_title',$region->name.': Region Details');

require_once('template/header.php');
$region=new Region;
$region->getById($region_id);
?>
<div class="container">
    <div class="row">
            
        <div class="col-md-6 alert alert-info">
            <?php
            $region->viewRegion($region_id);
            ?>
        </div>
        
        <div class="col-md-6">
                
            <div class="alert alert-success">
                <?php echo '  <h2>'.$region->totalBagged.'/'.$region->totalSummits.'</h2>'; ?>    
            </div>
            
            <div class="alert alert-success">
                <div id="map_wrapper">
                        <div id="map_canvas" class="mapping"></div>
                </div>
            </div>

            <script>
                function initialize() {
                    <?php echo $region->getRegionMapJs();?>
                    <?php echo $region->genericMapInit();?>
                }
                $(document).ready(function(){
                   initialize(); 
                });
            </script>
        </div>
        
    </div>
</div>

<div id="attribution"><?php echo $summit->image_bg_attribution;?></div>

<style>
    body{
        background-image:url('media/regions/backgrounds/<?php echo $region->image_bg;?>');
    }
</style>

<?php
require_once('template/footer.php');