<?php 

class injecttaxonomyterm {
	
	function Proc($source, $staging, $target,$aws_resource) {
	

	

$curl = curl_init(); 
		$cors = HtpCompanyProfile::getAll($source);
		$k=0;
		foreach($cors as $row) {
				echo ($k%10) == 0 ? $k .' ' : NULL;
				RestUtils::createTaxonomyTerm($row,$curl);
				$k++;
		}
		curl_close($curl);

			echo PHP_EOL;
		

			WriteLog('Done with injecttaxonomyterm');
	}
}