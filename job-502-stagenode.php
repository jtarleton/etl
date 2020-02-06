<?php 

class stagenode {

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



			try {
				
				$sql = 'INSERT INTO external_organizations (attributes) VALUES (';
				$sql .= ':attributes';
				$sql .= ')';
				
				$stmt = $staging->prepare($sql);
			 
				//foreach ($to_shift as $to_shift_k) {
				//	$val = @$line[$to_shift_k];
				//	if(empty($val)) {
				//		$val = '';
				//	}
					$stmt->bindValue(':attributes', 
						json_encode($row, JSON_PRETTY_PRINT), 
						PDO::PARAM_STR); 
				//}
		
				
				//die(var_dump($sql));
				$stmt->execute();

			}
			catch (PDOException $pdoe) {
			   echo "Error: " . $pdoe->getMessage();
			} 



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
		WriteLog('Done with stagenode');
	}
}
