<?php
// Chewitts
// Hewitt Tracker by Tom Calpin

require_once('config.php');
require_once('includes/bootstrap.php');

// TODO: a proper router
if(isset($_GET['region'])) require_once('template/pages/region.php');
elseif(isset($_GET['collection'])) require_once('template/pages/collection.php');
elseif(isset($_GET['summit'])) require_once('template/pages/summit.php');
elseif(isset($_GET['search'])) require_once('template/pages/search.php');
else  require_once('template/pages/dashboard.php');

require_once('template/footer.php');
?>