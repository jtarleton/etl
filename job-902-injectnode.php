<?php 

class injectnode {

	function Proc($source, $staging, $target,$aws_resource) {
		$fvrs = FleetInfo::getAll($source);

		// special_permit
		$rs = HtpIssuePermits::getAll($source);
		foreach($rs as $row) {
		//$row['PermitNo']
					//$row['CompanyID']
					//$row['VehicleDescription']
					//$row['VehiclePlate1']
				}


		
		$k=0;
		$curl = curl_init(); 
		foreach($fvrs as $row) {
			echo ($k%10) == 0 ? $k .' ' : NULL;
			RestUtils::createNode($row,$curl);
				

				$k++;
		}
		curl_close($curl);


				echo PHP_EOL;
			
			WriteLog('Done with injectnode');
		
	}
}