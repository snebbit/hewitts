<?php
// Chewits
// Hewitt Tracker by Tom Calpin

require_once('includes/classes/abstract.php');
require_once('template/header.php');

$master=new Chewitts;

if(isset($_GET['done'])){
    $summit_id=(int)$_GET['summit_id'];
    $result2=$master->query("insert into bags (summit_id,user_id,date) values ('".$summit_id."',1,0001-01-01)");
}


$result=$master->query("select * from summits order by region asc");
while($summit=$result->fetch_assoc()){
    echo '<br>';
    echo $summit['name'];
    echo ' ';
    echo '<a href="categorising.php?summit_id='.$summit['summit_id'].'&done=historical">Done - old</a>';
}





require_once('template/footer.php');
?>