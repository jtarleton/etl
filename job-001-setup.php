<?php 

class setup 
{



function Proc($mysql1, $mongo, $mysql2) 
{
echo get_class($mysql1);
echo get_class($mongo);
$mongo->createCollection('wp_user');
$mongo->createCollection('wp_post');
$mongo->createCollection('wp_comment');
$mongo->createCollection('wp_commentmeta');
$mongo->createCollection('wp_postmeta');
$mongo->createCollection('wp_usermeta');
$mongo->createCollection('wp_link');
$mongo->createCollection('wp_term');
$mongo->createCollection('wp_term_taxonomy');
$mongo->createCollection('wp_term_relationship');
$mongo->createCollection('wp_option');
$list = $mongo->listCollections();
foreach ($list as $collection) {
    echo " $collection... ";
   
}







echo get_class($mysql2);

}


}
