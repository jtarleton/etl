<?php 

class extracttaxonomyterm {

	function Proc($source, $staging, $target,$aws_resource) {



$rs = FleetInfo::getAll($source);
foreach($rs as $row) {
		//	$row['CompanyID'];
		//	$row['VehiclePlateFi1'];
		//	$row['VehicleDescription']; 
		}

$rs = HtpIssuePermits::getAll($source);
foreach($rs as $row) {
//$row['PermitNo']
			//$row['CompanyID']
			//$row['VehicleDescription']
			//$row['VehiclePlate1']
		}


$rs = HtpCompanyProfile::getAll($source);
foreach($rs as $row) {
		//$row['CompanyName'];
		//	$row['CompanyAddress'];
		//	$row['CompanyCity'];
		//	$row['CompanyState'];
		//	$row['CompanyZip'];
		//	$row['Borough'];
		//	$row['CompanyPhone'];
		//	$row['CompanyFax'];
		//	$row['eMailAddress'];
		}








		
		WriteLog($source->getAttribute(PDO::ATTR_CONNECTION_STATUS));
		WriteLog($staging->getAttribute(PDO::ATTR_CONNECTION_STATUS));
		WriteLog($target->getAttribute(PDO::ATTR_CONNECTION_STATUS));
		WriteLog('Done with extracttaxonomyterm');
	}
}
