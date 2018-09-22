<!DOCTYPE html>

<html>
    
    <head>
        <title><?php echo _page_title;?></title>
        <base href="<?php echo _base_url;?>" />
        <link href="https://fonts.googleapis.com/css?family=Libre+Franklin" rel="stylesheet">
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link href="skin/css/paper.css" rel="stylesheet" />
        <link href="skin/css/custom.css" rel="stylesheet" />
        <link href="skin/css/sortable-theme-minimal.css" rel="stylesheet" />
        <script src="https://code.jquery.com/jquery-3.2.1.min.js" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script> 
        <script src="skin/js/sortable.min.js"></script>
        <script type="text/javascript" src="//maps.googleapis.com/maps/api/js?sensor=false&callback=initialize"></script>
        <?php /*<script type="text/javascript" src="http://openspace.ordnancesurvey.co.uk/osmapapi/openspace.js?key=5759F76D9F0F7EA8E0530B6CA40A18D8"></script>
        <script type= "text/javascript" src="http://openspace.ordnancesurvey.co.uk/osmapapi/script/mapbuilder/basicmap.js"></script>*/ ?>
    </head>
    
    <body>
        
        <div id="container">
        <header>
            
            
            <nav class="navbar navbar-default">
              <div class="container-fluid">
                <div class="navbar-header">
                  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                  </button>
                  <a class="navbar-brand" href="#"><img src="skin/logo-small.png" alt="CHEWITS" /></a>
                  <a class="navbar-brand" href="#">CHEWITTS</a>
                </div>
            
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                  <ul class="nav navbar-nav">
                    <li class="<?php if(_mode=='dashboard') echo ' active';?>"><a href="/">DASHBOARD</a></li>
                    
                    <?php
                    $regionInstance=new Region;
                    $regions=$regionInstance->getAllRegions();
                    ?>
                    <li class="dropdown<?php if(_mode=='region') echo ' active';?>">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">REGIONS <span class="caret"></span></a>
                      <ul class="dropdown-menu">
                          <?php
                          foreach($regions as $region){
                              echo '<li';
                              if(_mode=='region' AND _region_id==$region['region_id']) echo ' class="active"';
                              echo '><a href="region/'.$region['region_id'].'/">'.$region['name'].'</a></li>';
                              
                          }
                          ?>
                        <?php /*<li role="separator" class="divider"></li>
                        <li><a href="#">Separated link</a></li>*/?>
                      </ul>
                    </li>
                    
                    
                    <?php
                    $collectionInstance=new Collection;
                    $collections=$collectionInstance->getAllCollections();
                    ?>
                    <li class="dropdown<?php if(_mode=='collection') echo ' active';?>">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">COLLECTIONS <span class="caret"></span></a>
                      <ul class="dropdown-menu">
                        <?php
                          foreach($collections as $collection){
                              echo '<li';
                              if(_mode=='collection' AND _collection_id==$collection['collection_id']) echo ' class="active"';
                              echo '><a href="collection/'.$collection['collection_id'].'/">'.$collection['name'].'</a></li>';
                              
                          }
                          ?>
                        <?php /*<li role="separator" class="divider"></li>
                        <li><a href="#">One more separated link</a></li>*/?>
                      </ul>
                    </li>
                  </ul>
                  <form class="navbar-form navbar-right" action="search/">
                    <div class="form-group">
                      <input type="text" class="typeahead form-control" placeholder="Search Summits...">
                    </div>
                    <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
                  </form>
                  
                </div>
              </div>
            </nav>
            
        </header>
        
        <script type="text/javascript">
      	$('input.typeahead').typeahead({
      	    source:  function (query, process) {
              return $.get('var/cache/summits.cache', { query: query }, function (data) {
              		console.log(data);
              		data = $.parseJSON(data);
      	            return process(data);
      	        });
      	    },
      	    updater: function (item) {
                window.location.href = 'summit/'+item.summit_id+'/';
                return item;
            }
      	});
      </script>