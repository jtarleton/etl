<?php 

class wppost 
{



function Proc($mysql1, $mongo, $mysql2) 
{
echo get_class($mysql1);
echo get_class($mongo);
$mongo->createCollection('wp_post');
$mongo->wp_post->remove();
$mongo->wp_post->deleteIndexes();
$mongo->wp_post->ensureIndex(array('_id'=>1));

for($i=0;$i<1000000;$i++)
{
	if ( ($i%5000) == 0) echo $i;
	$doc = array (
	'post_content'=>

		'<p>The Sonoran Desert is the only place in the world where the famous Saguaro cactus (<i>Carnegiea gigantea</i>) grows in the wild.</p>

		<p><img style="width:400px; height:300px;" src="http://www.crystalbit.com/images/Sonoran-Desert-at-sunset.jpg"></img></p>'



	);

	$mongo->wp_post->insert($doc, array('safe'=>true)); 

}
echo get_class($mysql2);

}


}
