<?php 

class injectnodehtpspecialpermit {

	function Proc($source, $staging, $target,$aws_resource) {
		$source->setAttribute(PDO::ATTR_AUTOCOMMIT,0);
		$staging->setAttribute(PDO::ATTR_AUTOCOMMIT,0);
		$target->setAttribute(PDO::ATTR_AUTOCOMMIT,0);


		ApaActivePermitDetails::clearTbls($target);
		WriteLog('Truncate tables operation complete.');

		// special_permit
		$hiprs = HtpIssuePermits::getAll($source);
		
		$k=0;
		HelperUtils::initPsSql();
		ApaActivePermitDetails::disKeys($target);
		$stmtCreate = HelperUtils::getPs($target, 'Create');
		$stmtcreateContact = HelperUtils::getPs($target, 'createContact');
		$stmtcreateOrg = HelperUtils::getPs($target, 'createOrg');


		$target->beginTransaction();
		foreach($hiprs as $hiprs_row){
			//print_r($hiprs_row);

			//if($hiprs_row['PermitQty'] > 1) {


			if (($k%100) == 0) echo $k.' ';


			ApaActivePermitDetails::Create($stmtCreate, [
				'SOURCE' =>'Highway Travel Permits CSV', 
				'PERMIT_NUM'=>'HTP-' . $hiprs_row['PermitNo'],  
				'PERMIT_YEAR'=>date('Y-m-d', strtotime(str_replace(' ','',$hiprs_row['EffectiveDate']))),
				'ISSUED_DATE'=>date('Y-m-d', strtotime(str_replace(' ','',$hiprs_row['IssueDate']))),  
				
				'EXPIRATION_DATE'=>date('Y-m-d', strtotime(str_replace(' ','',$hiprs_row['ExpirationDate']))),  
				'EFFECTIVE_DATE'=>date('Y-m-d', strtotime(str_replace(' ','',$hiprs_row['EffectiveDate']))),
				'PLATE_NUM' =>$hiprs_row['VehiclePlateFi1'],
				'VALID_DAYS'=>$hiprs_row['ValidDays'],
				'VALID_TIMES'=>$hiprs_row['ValidTimes'],
				'RESTRICTIONS'=>$hiprs_row['ConditionRestrictions'],

				'VEHICLE_ID' =>'',
				'VIN' =>'',	
				'VEHICLE_STATUS' =>'',	
				'MODEL' =>'',
				'MAKE' =>'',
				'YEAR' =>'',	
				'VEHICLE_TYPE' =>'',

				'ValidFor'=>$hiprs_row['ValidFor'],
				'AuthoriedBy'=>$hiprs_row['AuthoriedBy'],
				'Notes'=>$hiprs_row['Notes']
			]); 


 
			ApaActivePermitDetails::createContact($stmtcreateContact, [
				'SOURCE' =>'Highway Travel Permits CSV',  
				'PERMIT_NUM' =>'HTP-' . $hiprs_row['PermitNo'],  
				'CUSTOMER_ID' =>'',  
				'COMPANY_ID' =>$hiprs_row['CompanyID'],  

				'LAST_NAME' =>$hiprs_row['LastName'],  
				'FIRST_NAME' =>$hiprs_row['FirstName'],
				'ADDRESS_1' =>$hiprs_row['CompanyAddress'],   
				'ADDRESS_2' =>'',

				'CITY' =>$hiprs_row['CompanyCity'], 
				'STATE' =>$hiprs_row['CompanyState'],
				'ZIP' =>$hiprs_row['CompanyZip'], 
				'EMAIL' =>$hiprs_row['eMailAddress']
			]);

			ApaActivePermitDetails::createOrg($stmtcreateOrg,[
				'SOURCE' =>'Highway Travel Permits CSV',  
				'PERMIT_NUM' =>'HTP-' . $hiprs_row['PermitNo'],   
				'CUSTOMER_ID' =>'',  
				'CUSTOMER_NAME' =>$hiprs_row['CompanyName'],  

				'CUSTOMER_TYPE' =>'',  
				'CUST_TYPE_DESC' =>'',
				'CUSTOMER_CLASS' =>'',
				'EMAIL_ADDRESS' =>$hiprs_row['eMailAddress'],

				'CompanyAddress'=>$hiprs_row['CompanyAddress'],    
				'CompanyCity'=>$hiprs_row['CompanyCity'],     
				'CompanyState'=>$hiprs_row['CompanyState'],   
				'CompanyZip'=>$hiprs_row['CompanyZip'],  

				'CompanyPhone'=>$hiprs_row['CompanyPhone'],
				'CompanyFax'=>$hiprs_row['CompanyFax'],

				'DFTA_FUNDED'=>'',  
				'VAS_ORG'=>'',  
				'VAS_NO'=>'',  
				'Borough' =>$hiprs_row['Borough']
			]); 

			$k++;
		}
		$target->commit();
		echo PHP_EOL;
		WriteLog('Done with injectnodehtpspecialpermit');
	}
}