<?php
$collection_id=(int)$_GET['collection'];
define('_mode','collection');
define('_collection_id',$collection_id);

require_once('template/header.php');
$collection=new Collection;
$collection->viewCollection($collection_id);

require_once('template/footer.php');