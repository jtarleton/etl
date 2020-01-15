<?php 

class injectnode {

	function Proc($source, $staging, $target) {
		echo get_class($source);
		echo get_class($staging);
		echo get_class($target);
		for($i=0; $i < 100; $i++) {
			if ( ($i%10) == 0) echo $i .' ';
			RestUtils::createNode();
		}
		echo PHP_EOL;
	}
}
