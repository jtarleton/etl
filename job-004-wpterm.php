<?php 

class wpterm 
{



function Proc($mysql1, $mongo, $mysql2) 
{
echo get_class($mysql1);
echo get_class($mongo);

$mongo->createCollection('wp_term');

$list = $mongo->listCollections();
foreach ($list as $collection) {
    echo " $collection... ";
   
}







echo get_class($mysql2);

}


}
