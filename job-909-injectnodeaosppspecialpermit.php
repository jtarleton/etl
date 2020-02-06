<?php 

class injectnodeaosppspecialpermit {

	function Proc($source, $staging, $target,$aws_resource) {
		$source->setAttribute(PDO::ATTR_AUTOCOMMIT,0);
		$staging->setAttribute(PDO::ATTR_AUTOCOMMIT,0);
		$target->setAttribute(PDO::ATTR_AUTOCOMMIT,0);

		
		// special_permit
		$aospp_rows = Aospp::getAll($source);
		
		$k=0;
		HelperUtils::initPsSql();
		$stmtCreate = HelperUtils::getPs($target, 'Create');
		$stmtcreateContact = HelperUtils::getPs($target, 'createContact');
		$stmtcreateOrg = HelperUtils::getPs($target, 'createOrg');

		$target->beginTransaction();

		foreach($aospp_rows as $aospp_row){
			if (($k%100) == 0) echo $k.' ';
			ApaActivePermitDetails::Create($stmtCreate, [
				'SOURCE' =>'AOSPP DB2', 
				'PERMIT_NUM'=>$aospp_row['PERMIT_NUM'],  
				'PERMIT_YEAR'=>'',
				'ISSUED_DATE'=>'',  

				'EXPIRATION_DATE'=>date('Y-m-d', strtotime($aospp_row['EXPIRATION_DATE'])),  
				'EFFECTIVE_DATE'=>date('Y-m-d', strtotime($aospp_row['EFFECTIVE_DATE'])),
				'PLATE_NUM' =>$aospp_row['PLATE_NUM'],	
				'VALID_DAYS'=>'',
				'VALID_TIMES'=>'',
				'RESTRICTIONS' =>'',

				'VEHICLE_ID' =>$aospp_row['VEHICLE_ID'],
				'VIN' =>$aospp_row['VIN'],	
				'VEHICLE_STATUS' =>$aospp_row['STATUS'],
				'MODEL' =>$aospp_row['MODEL'],	
				'MAKE' =>$aospp_row['MAKE'],
				'YEAR' =>$aospp_row['YEAR'],	
				'VEHICLE_TYPE' =>$aospp_row['VEHICLE_TYPE'],

				'ValidFor'=>'',
				'AuthoriedBy'=>'',
				'Notes'=>''

			]); 

			ApaActivePermitDetails::createContact($stmtcreateContact, [
				'SOURCE' =>'AOSPP DB2',  
				'PERMIT_NUM' =>$aospp_row['PERMIT_NUM'],   
				'CUSTOMER_ID' =>$aospp_row['CUSTOMER_ID'],   
				'COMPANY_ID' =>'',  

				'LAST_NAME' =>$aospp_row['LAST_NAME'],  
				'FIRST_NAME' =>$aospp_row['FIRST_NAME'], 
				'ADDRESS_1' =>$aospp_row['STREET_ADDRESS'], 
				'ADDRESS_2' =>'',

				'CITY' =>$aospp_row['CITY'],  
				'STATE' =>$aospp_row['STATE'],  
				'ZIP' =>'', 			
				'EMAIL' =>$aospp_row['EMAIL']
			]);

			ApaActivePermitDetails::createOrg($stmtcreateOrg,[
				'SOURCE' =>'AOSPP DB2',  
				'PERMIT_NUM' =>$aospp_row['PERMIT_NUM'],  
				'CUSTOMER_ID' =>$aospp_row['CUSTOMER_ID'],  
				'CUSTOMER_NAME' =>$aospp_row['CUSTOMER_NAME'], 

				'CUSTOMER_TYPE' =>$aospp_row['CUSTOMER_TYPE'],
				'CUST_TYPE_DESC' =>$aospp_row['CUST_TYPE_DESC'],
				'CUSTOMER_CLASS' =>$aospp_row['CUSTOMER_CLASS'],
				'EMAIL_ADDRESS' =>$aospp_row['EMAIL'],

				'CompanyAddress' =>$aospp_row['STREET_ADDRESS'], 
				'CompanyCity' =>$aospp_row['CITY'],  
				'CompanyState' =>$aospp_row['STATE'],  
				'CompanyZip' =>'',  

				'CompanyPhone'=>$aospp_row['PHONE'],
				'CompanyFax'=>$aospp_row['FAX'],

				'DFTA_FUNDED' =>$aospp_row['DFTA_FUNDED'], 
				'VAS_ORG' => $aospp_row['VAS_ORG'], 
				'VAS_NO' => $aospp_row['VAS_NO'], 
				'Borough' =>'',  
				
				
			]);
			
			$k++;
		}
		$target->commit();
		echo PHP_EOL;
		ApaActivePermitDetails::enKeys($target);
		WriteLog('Done with injectnodeaosppspecialpermit');
	}
}