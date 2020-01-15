<?php 

class injecttaxonomyterm {
	
	function Proc($source, $staging, $target) {
		for($k=0; $k < 100; $k++) {
			if ( ($k%10) == 0) echo $k .' ';
			RestUtils::createTaxonomyTerm(); 
		}
		echo PHP_EOL;
	}
}