<?php 

class Db {


	public static function getSqliteCon($dsn) {
		try
                {

                $pdo = new PDO($dsn);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return $pdo;

                }
                catch (PDOException $e)
                {
                printf('PDO ERROR: %s', $e->getMessage());
                exit(0);
                }

	}

	static public function getCon($v, $u, $p)
	{


		try
		{

		$pdo = new PDO($v, $u, $p);
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		return $pdo;

		}
		catch (PDOException $e)
		{
		printf('PDO ERROR: %s', $e->getMessage());
		exit(0);
		}



	}

}


class HelperUtils {
	public static $ps = [];


	public static $flds = [
		'active_permit_details' => [
			'SOURCE', 
			'PERMIT_NUM',  
			'PERMIT_YEAR',
			'ISSUED_DATE',  

			'EXPIRATION_DATE',  
			'EFFECTIVE_DATE',
			'PLATE_NUM',
			'VALID_DAYS',
			'VALID_TIMES',
			'RESTRICTIONS',

			'VEHICLE_ID',
			'VIN',	
			'VEHICLE_STATUS',	
			'MODEL',
			'MAKE',
			'YEAR',	
			'VEHICLE_TYPE',

			'ValidFor',
			'AuthoriedBy',
			'Notes'
		],
		'contact_liaison_details'=>[
			'SOURCE',  
			'PERMIT_NUM',  
			'CUSTOMER_ID',  
			'COMPANY_ID', 

			'LAST_NAME',  
			'FIRST_NAME',  
			'EMAIL',
			'ADDRESS_1', 

			'ADDRESS_2',
			'CITY', 
			'STATE',
			'ZIP'
		],
		'organization_details'=>[
			'SOURCE',  
			'PERMIT_NUM' , 
			'CUSTOMER_ID',    
			'CUSTOMER_NAME' ,  

			'CUSTOMER_TYPE' ,  
			'CUST_TYPE_DESC',
			'CUSTOMER_CLASS',
			'EMAIL_ADDRESS' ,

			'CompanyAddress',  
			'CompanyCity',   
			'CompanyState',   
			'CompanyZip',  
'CompanyPhone',
'CompanyFax',
			'DFTA_FUNDED',  
			'VAS_ORG',  
			'VAS_NO',  
			'Borough'  






		]
	]; 

	public static function initPsSql() {

			$flds = self::$flds['active_permit_details'];

			$sql = 'INSERT INTO active_permit_details (' . implode(',', $flds) . ') VALUES (';

			$sqlparts = [];
			foreach($flds as $fld) {
				$sqlparts[] = ':' . $fld; 
			}
			$sql .= implode(',',$sqlparts);
			$sql .= ')';


			self::$ps['Create'] = $sql;
			



			$flds = self::$flds['contact_liaison_details'];


		
			$sql = 'INSERT INTO contact_liaison_details (' . implode(',', $flds) . ') VALUES (';
			$sqlparts = [];
			foreach($flds as $fld) {
				$sqlparts[] = ':' . $fld; 
			}
			$sql .= implode(',',$sqlparts);
			$sql .= ')';
			self::$ps['createContact'] =$sql;




			$flds = self::$flds['organization_details'];

			$sql = 'INSERT INTO organization_details (' . implode(',', $flds) . ') VALUES (';

			$sqlparts = [];
			foreach ($flds as $fld) {
				$sqlparts[] = ':' . $fld; 
			}
			$sql .= implode(',',$sqlparts);
			$sql .= ')';
			self::$ps['createOrg'] = $sql;


	}

	public static function getPs($db, $function) {
		$sql = self::$ps[$function];
		$stmt = $db->prepare($sql);
		return $stmt;
	}

}


class RestUtils {

	public static function createNodeSpecialPermit($row,$curl=NULL) {
		if(!isset($curl)) {
			$curl = curl_init(); 
		}









			curl_setopt_array($curl, array(
			  CURLOPT_URL => "https://web2local.nycdotprojects.info/node?_format=hal_json",
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_SSL_VERIFYHOST=>false,
			  CURLOPT_SSL_VERIFYPEER=>false,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "POST",
			  CURLOPT_POSTFIELDS =>'{
			  "_links": {
			    "type": {
			      "href": "https://web2local.nycdotprojects.info/rest/type/node/special_permit"
			    }
			  },
			  "title": [
			    {
			      "value": "HTP-' 			      . $row['PermitNo'] .'"
			    }
			  ],
			  "field_sp_number":[{
			      "value":  "HTP-' 			      . $row['PermitNo'] .'"
			      }],
			  "type": [
			    {
			      "target_id": "special_permit"
			    }
			  ],

			  "field_sp_type_of_permit" : [{
			      "value": "' . 'suh' . '"
			      }],
			  	
			  	"field_sp_issue_date" : [{
			      "value": "' . date('Y-m-d',strtotime($row['IssueDate'])) . '"
			      }],
			  	
			  	"field_sp_expiry_date":[{
			      "value": "' . date('Y-m-d',strtotime($row['ExpirationDate'])) . '"
				}],
				"field_sp_notes":[{
			      "value": "' . $row['PermitPurpose'] . '"
				}],
				"field_sp_vehicle_plate_num":[{
			      "value": "' . $row['VehiclePlate1'] . '"
				}]
			  
			}',

				

			  CURLOPT_HTTPHEADER => array(
			    "Content-Type: application/hal+json",
			    "_format: hal_json",
			    "Authorization: Basic OmphbWVzMjAxOA=="
			  ),
			));

			$response = curl_exec($curl);
			
			if(!$response) WriteLog(curl_error($curl));






















				//die(var_dump($row));

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

	public static function createNode($row, $curl=NULL) {

				if(!isset($curl)) {
			$curl = curl_init(); 
			}
				//die(var_dump($row));

				//$row['CompanyName'];
				//	$row['CompanyAddress'];
				//	$row['CompanyCity'];
				//	$row['CompanyState'];
				//	$row['CompanyZip'];
				//	$row['Borough'];
				//	$row['CompanyPhone'];
				//	$row['CompanyFax'];
				//	$row['eMailAddress'];

		//	$row['CompanyID'];
				//	$row['VehiclePlateFi1'];
				//	$row['VehicleDescription']; 




			curl_setopt_array($curl, array(
			  CURLOPT_URL => "https://web2local.nycdotprojects.info/node?_format=hal_json",
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_SSL_VERIFYHOST=>false,
			  CURLOPT_SSL_VERIFYPEER=>false,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "POST",
			  CURLOPT_POSTFIELDS =>'{
			  "_links": {
			    "type": {
			      "href": "https://web2local.nycdotprojects.info/rest/type/node/fleet_vehicle"
			    }
			  },
			  "title": [
			    {
			      "value": "' 			      . $row['VehicleDescription'] .'"
			    }
			  ],
			  "type": [
			    {
			      "target_id": "fleet_vehicle"
			    }
			  ],

"field_fleet_tractor_plate_no": [
			    {
			      "value" : "' . $row['VehiclePlateFi1'] .  '" }],  
"field_fleet_gross_vehicle_weight": [
			    {
			      "value" : "' .$row['VehicleAvgWeight']  .  '" }],  
"field_fleet_ma": [
			    {
			      "value" : "' .$row['VehicleAvgWeight'] .  '" }],  
"field_fleet_company_name": [
			    {
			      "value" : "' . $row['CompanyName'] .  '" }],  
"field_fleet_load": [
			    {
			      "value" : "' . $row['YellowBusCapacity'] . $row['MiniBusesCapacity'] 
. $row['MotorcoachCapacity'] 
			      . $row['VanCapacity']  .  '" }],  

"field_engineer_comments": [
			    {
			      "value" : "' . $row['OtherDescription']  .  '" }],  
"field_dot_comments": [
			    {
			      "value" : "' .$row['VehiclePlateFi2'] .' '.$row['VehiclePlateFi3'] . '" }] 





			}',
			  CURLOPT_HTTPHEADER => array(
			    "Content-Type: application/hal+json",
			    "_format: hal_json",
			    "Authorization: Basic anRhcmxldG9uOmphbWVzMjAxOA=="
			  ),
			));

			$response = curl_exec($curl);
			if(!$response) WriteLog(curl_error($curl));
			//curl_close($curl);
			//if(!is_array(var))
			//WriteLog(implode(PHP_EOL, json_decode($response, 1)));


	}
	public static function createTaxonomyTerm($row, $curl=NULL) {

			// CREATE TAXONOMY TERM
		if(!isset($curl)) {
			$curl = curl_init(); 
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



			curl_setopt_array($curl, array(
			  CURLOPT_URL => "https://web2local.nycdotprojects.info/entity/taxonomy_term?_format=hal_json",
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_SSL_VERIFYHOST=>false,
			  CURLOPT_SSL_VERIFYPEER=>false,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "POST",
			  CURLOPT_POSTFIELDS =>'{
			  "_links": {
			    "type": {
			      "href": "https://web2local.nycdotprojects.info/rest/type/taxonomy_term/external_organization"
			    }
			  },
			  "vid": [
			    {
			      "target_id": "external_organization"
			    }
			  ],
			  "name": [
			    {
			      "value": "' . $row['CompanyName'] . '",
			      "lang": "en"
			    }
			  ],
			  "status": [
			    {
			      "value": true
			    }
			  ],
			  "description": [
			    {
			      "value": "' . $row['CompanyName'] .' '. $row['eMailAddress'] .'"
			    }
			  ],
			  "field_organization_id": [
			    {
			      "value": "' . $row['CompanyID'] . '"
			    }
			  ],
			  "field_organization_name": [
			    {
			      "value": "' . $row['CompanyName'] . '"
			    }
			  ],
			  "field_organization_type": [
			    {
			      "value": 2
			    }
			  ],
			  "field_organization_address": [
			    {
			      "langcode": "en",
			      "country_code": "US",
			      "administrative_area": "' . $row['CompanyState'] . '",
			      "locality": "' . $row['CompanyCity'] . '",
			      "dependent_locality": null,
			      "postal_code": "' . $row['CompanyZip'] . '",
			      "sorting_code": null,
			      "address_line1": "' . $row['CompanyAddress'] . '",
			      "address_line2": "' . $row['CompanyAddress'] . '",
			      "organization": "' . $row['CompanyName'] . '",
			      "given_name": "'.$row['FirstName'].'",
			      "additional_name": "' . '' . '",
			      "family_name": "'.$row['LastName'].'"
			    }
			  ]
			}',
			  CURLOPT_HTTPHEADER => array(
			    "Upgrade-Insecure-Requests: 1",
			    "Cache-Control: max-age=0",
			    "Content-Type: application/hal+json"
			  ),
			));

			$response = curl_exec($curl);
			if(!$response) WriteLog(curl_error($curl));
			//curl_close($curl);
			//WriteLog(implode(PHP_EOL, json_decode($response, 1)));
	} 

}





class ApaActivePermitDetails {
	public $permitType;
	public $legacySource;

	public $contactLiaisonObj;
	public $organizationObj;



	public static function clearStrict($db) {
		try {
			$sql = 'set global sql_mode=\'\'';
			$stmt = $db->prepare($sql);
			$stmt->execute();

			$sql = 'set autocommit = 0';
			$stmt = $db->prepare($sql);
			$stmt->execute();
		} 
		catch(Exception $pdoe) {
			echo "Error: " . $pdoe->getMessage();
		}
	}


	public static function disKeys($db) {
		try {
			$sql = 'ALTER TABLE apa_new.active_permit_details DISABLE KEYS';
			$stmt = $db->prepare($sql);
			$stmt->execute();

			$sql = 'ALTER TABLE apa_new.contact_liaison_details DISABLE KEYS';
			$stmt = $db->prepare($sql);
			$stmt->execute();

			$sql = 'ALTER TABLE apa_new.organization_details DISABLE KEYS';
			$stmt = $db->prepare($sql);
			$stmt->execute();
		} 
		catch(Exception $pdoe) {
			echo "Error: " . $pdoe->getMessage();
		}
	}
	public static function enKeys($db) {
		try {
			$sql = 'ALTER TABLE apa_new.active_permit_details ENABLE KEYS';
			$stmt = $db->prepare($sql);
			$stmt->execute();

			$sql = 'ALTER TABLE apa_new.contact_liaison_details ENABLE KEYS';
			$stmt = $db->prepare($sql);
			$stmt->execute();

			$sql = 'ALTER TABLE apa_new.organization_details ENABLE KEYS';
			$stmt = $db->prepare($sql);
			$stmt->execute();

		} 
		catch(Exception $pdoe) {
			echo "Error: " . $pdoe->getMessage();
		}
	}


	public static function clearTbls($db) {
		self::clearStrict($db);
		try {
			$sql = 'TRUNCATE TABLE apa_new.active_permit_details';
			$stmt = $db->prepare($sql);
			$stmt->execute();

			$sql = 'TRUNCATE TABLE apa_new.contact_liaison_details';
			$stmt = $db->prepare($sql);
			$stmt->execute();

			$sql = 'TRUNCATE TABLE apa_new.organization_details';
			$stmt = $db->prepare($sql);
			$stmt->execute();
		}
		catch (PDOException $pdoe) {
		   echo "Error: " . $pdoe->getMessage();
		} 



	}

	public static function create($stmt, $row) {
		try {
			/* 
			$sql = 'INSERT INTO active_permit_details (LEGACY_SOURCE, PERMIT_NUM, ISSUED_DATE, EXPIRATION_DATE, EFFECTIVE_DATE) VALUES (';

			$sqlparts = [];
			foreach(['LEGACY_SOURCE', 'PERMIT_NUM', 'ISSUED_DATE', 'EXPIRATION_DATE', 'EFFECTIVE_DATE'] as $fld) {
				$sqlparts[] = ':' . $fld; 
			}
			$sql .= implode(',',$sqlparts);
			$sql .= ')'; */
			


			//$stmt = HelperUtils::getPs($db, __FUNCTION__);

			//$stmt = $db->prepare($sql);
			foreach(HelperUtils::$flds['active_permit_details'] as $fld) {
				$val = @$row[$fld];
				if(empty($row[$fld])) {
					$val = '';
				}
				$stmt->bindValue(':' . $fld, $val, PDO::PARAM_STR); 
			}
			$stmt->execute();
		}
		catch (PDOException $pdoe) {
		   echo "Error: " . $pdoe->getMessage();
		} 
	}


	public static function createContact($stmt, $row) {
		try {
			/* 
			$sql = 'INSERT INTO contact_liaison_details (SOURCE, PERMIT_NUM, CUSTOMER_ID, LAST_NAME, FIRST_NAME, EMAIL) VALUES (';

			$sqlparts = [];
			foreach(['SOURCE', 'PERMIT_NUM', 'CUSTOMER_ID', 'LAST_NAME', 'FIRST_NAME', 'EMAIL'] as $fld) {
				$sqlparts[] = ':' . $fld; 
			}
			$sql .= implode(',',$sqlparts);
			$sql .= ')';
			
			$stmt = $db->prepare($sql); 
			*/
			//$stmt = HelperUtils::getPs($db, __FUNCTION__);
			foreach(HelperUtils::$flds['contact_liaison_details'] as $fld) {
				$val = @$row[$fld];
				if(empty($row[$fld])) {
					$val = '';
				}
				$stmt->bindValue(':' . $fld, $val, PDO::PARAM_STR); 
			}

			$stmt->execute();
		}
		catch (PDOException $pdoe) {
		   echo "Error: " . $pdoe->getMessage();
		} 
	}



	public static function createOrg($stmt, $row) {
		try {
			/*
			$sql = 'INSERT INTO organization_details (LEGACY_SOURCE, PERMIT_NUM, CUSTOMER_NAME, CUSTOMER_TYPE, EMAIL_ADDRESS) VALUES (';

			$sqlparts = [];
			foreach(['LEGACY_SOURCE', 'PERMIT_NUM', 'CUSTOMER_NAME', 'CUSTOMER_TYPE', 'EMAIL_ADDRESS'] as $fld) {
				$sqlparts[] = ':' . $fld; 
			}
			$sql .= implode(',',$sqlparts);
			$sql .= ')';
			
			$stmt = $db->prepare($sql);
			*/
			//$stmt = HelperUtils::getPs($db, __FUNCTION__);
			foreach (HelperUtils::$flds['organization_details'] as $fld) {
				$val = @$row[$fld];
				if(empty($row[$fld])) {
					$val = '';
				}
				$stmt->bindValue(':' . $fld, $val, PDO::PARAM_STR); 
			}

			$stmt->execute();
		}
		catch (PDOException $pdoe) {
		   echo "Error: " . $pdoe->getMessage();
		} 
	}






	public function getIndividualForActiveAosppPermitNum($permit_num = 0) {
		
	}

	public function getOrgForActiveAosppPermitNum($permit_num = 0) {
		
	}


	public function getIndividualForActiveHighwayPermitNum($permit_num = 0) {
		
	}

	public function getOrgForActiveHighwayPermitNum($permit_num = 0) {
		
	}


	public function getIndividualForActivePppdStatePermitNum($permit_num = 5093449) {
		
	}




	public function getOrgForActivePppdStatePermitNum($permit_num = 5016038) {
		


		$sql = 'CALL getOrgForActivePppdStatePermitNum(?)';
		$stmt = $conn->prepare($sql);

		$second_name = "Rickety Ride";
		$weight = 0;

		$stmt->bindParam(1, $permit_num, PDO::PARAM_INT|PDO::PARAM_INPUT_OUTPUT, 32);


		print "Values of bound parameters _before_ CALL:\n";
		print "  1: {$second_name} 2: {$weight}\n";

		$stmt->execute();
		$row = $stmt->fetchAll(PDO::FETCH_ASSOC);






	}








	public function getPermitForActivePppdStatePermitNum() {

/* 
CUSTOMER_ID	
ORG_NAME	
CUSTOMER_NAME	
CUSTOMER_TYPE	
CUST_TYPE_DESC	
CUSTOMER_CLASS	
OP_CERT	PERSON_ID	
ORG_ROLE_CODE	


FIRST_NAME	
LAST_NAME	
ADDRESS_1	
EMAIL	



IS_EMAIL_PREF	
CITY	
STATE	
ZIP	
DRIVER_LIC_NUM	
DOCTOR_ID	
PERMIT_NUM	
STATUS	
EFFECTIVE_DATE	
EXPIRATION_DATE */


	}









}

class ApaContactLiaisonDetails {
	public $legacySource;


	public $LEGACY_SOURCE;
	public $LAST_NAME;
	public $FIRST_NAME;
	public $EMAIL;
}

class ApaOrganizationDetails {
	public $legacySource;
	public $COMPANY_ID;
	public $CompanyName;
	public $CompanyAddress;
	public $CompanyState;
	public $CompanyCity;
	public $CompanyZip;
	public $Borough;
	public $CompanyPhone;
	public $EMAIL_ADDRESS;



}



class Aospp {
	public static function getAll($mysql1) {
		try {
			$tbl = ' highway_permits_legacy.AOSPPallorgstoallpermitsvehiclesliasons20191114 p';
			$sql = 'SELECT p.* FROM ' .$tbl;
			$stmt = $mysql1->prepare($sql);
			$stmt->execute();
			//$stmt->bindValue(':', ,PDO::PARAM_STR);
			$rs = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $rs;

		}
		catch (PDOException $pdoe) {
		   echo "Error: " . $pdoe->getMessage();
		} 
	}
}


class PppdSt {

	public static function getAllI($mysql1) {
		try {
			$tbl = ' highway_permits_legacy.pppd_state_active_ind i';
			$sql = 'SELECT i.* FROM ' .$tbl;
			$stmt = $mysql1->prepare($sql);
			$stmt->execute();
			//$stmt->bindValue(':', ,PDO::PARAM_STR);
			$rs = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $rs;

		}
		catch (PDOException $pdoe) {
		   echo "Error: " . $pdoe->getMessage();
		} 
	}

	public static function getAllO($mysql1) {
		try {
			$tbl = ' highway_permits_legacy.pppd_state_active_org o';
			$sql = 'SELECT o.* FROM ' .$tbl;
			$stmt = $mysql1->prepare($sql);
			$stmt->execute();
			//$stmt->bindValue(':', ,PDO::PARAM_STR);
			$rs = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $rs;

		}
		catch (PDOException $pdoe) {
		   echo "Error: " . $pdoe->getMessage();
		} 
	}
}



class FleetInfo {
	public static function getAll($mysql1) {
		try {
			$tbl = ' highway_permits_legacy.FleetInfo fi';
			$sql = 'SELECT * FROM ' .$tbl .'  LEFT JOIN highway_permits_legacy.HtpCompanyProfile c ON fi.CompanyID = c.CompanyID WHERE fi.CompanyID IN (SELECT cp.CompanyID From highway_permits_legacy.HtpCompanyProfile cp)';
			$stmt = $mysql1->prepare($sql);
			$stmt->execute();
			//$stmt->bindValue(':', ,PDO::PARAM_STR);
			$rs = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $rs;

		}
		catch (PDOException $pdoe) {
		   echo "Error: " . $pdoe->getMessage();
		} 
	}
}

class HtpCompanyProfile {
	public static function getAll($mysql1) {
		try {
			$tbl = ' highway_permits_legacy.HtpCompanyProfile';
			$sql = 'SELECT * FROM ' .$tbl;
			$stmt = $mysql1->prepare($sql);
			//$stmt->bindValue(':', ,PDO::PARAM_STR);
			$stmt->execute();
			$rs = $stmt->fetchAll(PDO::FETCH_ASSOC); 
			return $rs;
	

		}
		catch (PDOException $pdoe) {
		   echo "Error: " . $pdoe->getMessage();
		} 
	}
}


class HtpIssuePermits {
	public static function getAll($mysql1) {
		try {
			$tbl = ' highway_permits_legacy.HighwayTravelSourceData20191122'; //HtpIssuePermits';
			$sql = 'SELECT * FROM ' .$tbl;
			$stmt = $mysql1->prepare($sql);
			//$stmt->bindValue(':', ,PDO::PARAM_STR);
			$stmt->execute();
			$rs = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $rs;

		}
		catch (PDOException $pdoe) {
		   echo "Error: " . $pdoe->getMessage();
		} 
	}
}



class MySqlUtils {

	public static function createTbl($mysql1, $tbl_name, $pk_field_name, $field_list) {
		$field_list = array_unique($field_list);

		$sql = 'CREATE TABLE '.$tbl_name.' (PermitNumber INT(100) UNSIGNED AUTO_INCREMENT PRIMARY KEY, ';

		foreach($field_list as $field_list_line){
			$sql.= "$field_list_line LONGTEXT NOT NULL,";

		};
		$sql.= "sys_ts TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP)";


		try {
	
			$ok = $mysql1->exec($sql);
			//$stmt->bindValue(':', ,PDO::PARAM_STR);
			//$ok = $stmt->execute();
			
			return $ok;

		}
		catch (PDOException $pdoe) {
		   echo "Error: " . $pdoe->getMessage();
		}
	}
}
