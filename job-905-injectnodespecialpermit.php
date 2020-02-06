<?php 

class injectnodespecialpermit {

	function Proc($source, $staging, $target,$aws_resource) {
		// special_permit
		
		$hiprs = HtpIssuePermits::getAll($source);
		
		$k=0;
		$curl = curl_init(); 
		foreach($hiprs as $row) {
			if (($k%500) == 0) echo $k.' ';
			RestUtils::createNodeSpecialPermit($row,$curl);
				$k++;
		}
		curl_close($curl);
		echo PHP_EOL;
		WriteLog('Done with injectnodespecialpermit');
	}
}