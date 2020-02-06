<?php 

class injectnodepppdstatespecialpermit {

	function Proc($source, $staging, $target,$aws_resource) {
		$source->setAttribute(PDO::ATTR_AUTOCOMMIT,0);
		$staging->setAttribute(PDO::ATTR_AUTOCOMMIT,0);
		$target->setAttribute(PDO::ATTR_AUTOCOMMIT,0);



		$pppdst_by_ind = PppdSt::getAllI($source);
		$k=0;
		HelperUtils::initPsSql();
		$stmtCreate = HelperUtils::getPs($target, 'Create');
		$stmtcreateContact = HelperUtils::getPs($target, 'createContact');
		$stmtcreateOrg = HelperUtils::getPs($target, 'createOrg');


		$target->beginTransaction();
		foreach($pppdst_by_ind as $pppdst_by_ind_row){
			//print_r($hiprs_row);
			echo ($k%100) == 0 ? $k .' ' : NULL;
			ApaActivePermitDetails::Create($stmtCreate, [

				'SOURCE' =>'PPPD State - Individual - DB2', 
				'PERMIT_NUM'=>$pppdst_by_ind_row['PERMIT_NUM'],
				'PERMIT_YEAR'=>'',  
				'ISSUED_DATE'=>'',  
				
				'EXPIRATION_DATE'=>date('Y-m-d', strtotime($pppdst_by_ind_row['EXPIRATION_DATE'])),  
				'EFFECTIVE_DATE'=>date('Y-m-d', strtotime($pppdst_by_ind_row['EFFECTIVE_DATE'])),	
				'PLATE_NUM' =>'',
				'VALID_DAYS'=>'',
				'VALID_TIMES'=>'',
				'RESTRICTIONS' =>$pppdst_by_ind_row['EFFECTIVE_DATE'],

				'VEHICLE_ID' =>'',
				'VIN' =>'',	
				'VEHICLE_STATUS' =>'',	
				'MODEL' =>'',
				'MAKE' =>'',
				'YEAR' =>'',	
				'VEHICLE_TYPE' =>'',

				'ValidFor'=>'',
				'AuthoriedBy'=>'',
				'Notes'=>''
			]); 

			ApaActivePermitDetails::createContact($stmtcreateContact, [

				'SOURCE' =>'PPPD State - Individual - DB2', 
				'PERMIT_NUM' =>$pppdst_by_ind_row['PERMIT_NUM'],   
				'CUSTOMER_ID' =>'',   
				'COMPANY_ID' =>'',  
				
				'LAST_NAME' =>$pppdst_by_ind_row['LAST_NAME'],  
				'FIRST_NAME' =>$pppdst_by_ind_row['FIRST_NAME'], 
				'ADDRESS_1' =>$pppdst_by_ind_row['ADDRESS_1'], 
				'ADDRESS_2' =>'',
				
				'CITY' =>$pppdst_by_ind_row['CITY'],  
				'STATE' =>$pppdst_by_ind_row['STATE'],  
				'ZIP' =>$pppdst_by_ind_row['ZIP'], 
				'EMAIL' =>$pppdst_by_ind_row['EMAIL']
			]);

			ApaActivePermitDetails::createOrg($stmtcreateOrg,[
			
				'SOURCE' =>'PPPD State - Individual - DB2', 
				'PERMIT_NUM' =>$pppdst_by_ind_row['PERMIT_NUM'],  
				'CUSTOMER_ID' =>'',  
				'CUSTOMER_NAME' =>'', 

				'CUSTOMER_TYPE' =>'',
				'CUST_TYPE_DESC' =>'',
				'CUSTOMER_CLASS' =>'',
				'EMAIL_ADDRESS' =>$pppdst_by_ind_row['EMAIL'],

				'CompanyAddress' =>$pppdst_by_ind_row['ADDRESS_1'], 
				'CompanyCity' =>$pppdst_by_ind_row['CITY'],  
				'CompanyState' =>$pppdst_by_ind_row['STATE'],  
				'CompanyZip' =>$pppdst_by_ind_row['ZIP'], 

				'CompanyPhone'=>'',
				'CompanyFax'=>'',

				'DFTA_FUNDED'=>'',  
				'VAS_ORG'=>'',  
				'VAS_NO'=>'',  
				'Borough' =>''  
			]);
			$k++;
		}
		$target->commit();
		WriteLog('Done with pppd state - individual permits');

		$pppdst_by_org = PppdSt::getAllO($source);



		$stmtCreate = HelperUtils::getPs($target, 'Create');
		$stmtcreateContact = HelperUtils::getPs($target, 'createContact');
		$stmtcreateOrg = HelperUtils::getPs($target, 'createOrg');


		$target->beginTransaction();
		foreach($pppdst_by_org as $pppdst_by_org_row){
			//print_r($hiprs_row);
			if (($k%100) == 0) echo $k.' ';
			ApaActivePermitDetails::Create($stmtCreate, [
				'SOURCE' =>'PPPD State - Organization - DB2', 
				'PERMIT_NUM'=>$pppdst_by_org_row['PERMIT_NUM'],
				'PERMIT_YEAR'=>'',  
				'ISSUED_DATE'=>'',  
				
				'EXPIRATION_DATE'=>date('Y-m-d', strtotime($pppdst_by_org_row['EXPIRATION_DATE'])),  
				'EFFECTIVE_DATE'=>date('Y-m-d', strtotime($pppdst_by_org_row['EFFECTIVE_DATE'])),	
				'PLATE_NUM' =>'',
				'VALID_DAYS'=>'',
				'VALID_TIMES'=>'',
				'RESTRICTIONS' =>$pppdst_by_org_row['EFFECTIVE_DATE'],

				'VEHICLE_ID' =>'',
				'VIN' =>'',	
				'VEHICLE_STATUS' =>'',	
				'MODEL' =>'',
				'MAKE' =>'',
				'YEAR' =>'',	
				'VEHICLE_TYPE' =>'',

				'ValidFor'=>'',
				'AuthoriedBy'=>'',
				'Notes'=>''
			]); 
			ApaActivePermitDetails::createContact($stmtcreateContact, [
				'SOURCE' =>'PPPD State - Organization - DB2', 
				'PERMIT_NUM' =>$pppdst_by_org_row['PERMIT_NUM'],   
				'CUSTOMER_ID' =>$pppdst_by_org_row['CUSTOMER_ID'],   
				'COMPANY_ID' =>'',  
				
				'LAST_NAME' =>$pppdst_by_org_row['LAST_NAME'],  
				'FIRST_NAME' =>$pppdst_by_org_row['FIRST_NAME'], 
				'ADDRESS_1' =>$pppdst_by_org_row['ADDRESS_1'], 
				'ADDRESS_2' =>'',
				
				'CITY' =>$pppdst_by_org_row['CITY'],  
				'STATE' =>$pppdst_by_org_row['STATE'],  
				'ZIP' =>$pppdst_by_org_row['ZIP'], 
				'EMAIL' =>$pppdst_by_org_row['EMAIL']
			]);
			ApaActivePermitDetails::createOrg($stmtcreateOrg,[
				'SOURCE' =>'PPPD State - Organization - DB2', 
				'PERMIT_NUM' =>$pppdst_by_org_row['PERMIT_NUM'],  
				'CUSTOMER_ID' =>'',  
				'CUSTOMER_NAME' =>$pppdst_by_org_row['ORG_NAME'], 

				'CUSTOMER_TYPE' =>$pppdst_by_org_row['CUSTOMER_TYPE'],
				'CUST_TYPE_DESC' =>$pppdst_by_org_row['CUST_TYPE_DESC'],
				'CUSTOMER_CLASS' =>$pppdst_by_org_row['CUSTOMER_CLASS'],
				'EMAIL_ADDRESS' =>$pppdst_by_org_row['EMAIL'],

				'CompanyAddress' =>$pppdst_by_org_row['ADDRESS_1'], 
				'CompanyCity' =>$pppdst_by_org_row['CITY'],  
				'CompanyState' =>$pppdst_by_org_row['STATE'],  
				'CompanyZip' =>$pppdst_by_org_row['ZIP'], 

				'CompanyPhone'=>'',
				'CompanyFax'=>'',

				'DFTA_FUNDED'=>'',  
				'VAS_ORG'=>'',  
				'VAS_NO'=>'',  
				'Borough' =>''  
			]);
			$k++;
		}
		$target->commit();
		WriteLog('Done with pppd state - organization permits');


		echo PHP_EOL;
		WriteLog('Done with job injectnodepppdstatespecialpermit');
	}
}