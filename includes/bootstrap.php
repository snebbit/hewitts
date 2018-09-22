<?php $classes=array(
    'abstract',
    'user',
    'summit',
    'region',
    'collection',
    'bag'
);
foreach($classes as $classToInclude){
    require_once('includes/classes/'.$classToInclude.'.php');
}

require_once('includes/simple_html_dom.php');
