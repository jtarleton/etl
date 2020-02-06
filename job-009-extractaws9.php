<?php 

class extractaws9 {

	function Proc($source, $staging, $target,$aws_resource) {


		$header =FALSE;
		$lines = [];
		 while (($row = fgetcsv($aws_resource, 1500, ',')) !== FALSE){
		            if(!$header) {
		                $header = $row;
		               //print_r($header);
		            }
		            else{

		            	$lines[] = array_combine($header, $row);
		            }
		        
		    	// Read bytes of the body
		}
		foreach($header as &$headerk) {
			$headerk = str_replace(' ', '', $headerk);
		}
		$to_shift = $header;
		$to_shift = array_unique($to_shift);
		$pk = array_shift($to_shift);
		//unset($to_shift[array_search($pk,$to_shift)]);


		$to_shift_placeholders = [];
		foreach ($to_shift as $key => $value) {
			$to_shift_placeholders[] = ':' . str_replace(' ', '',$value);
		}
		$rand = rand();
		
		MySqlUtils::createTbl($source, 'pppd_state_active_org', $pk , $to_shift);
		foreach($lines as $line) { 
			//die(var_dump($to_shift));
			try {
				
				$sql = 'INSERT INTO pppd_state_active_org (';
				$sql .= implode(',', $to_shift);
				$sql .= ') VALUES (';
				$sql .= implode(',', $to_shift_placeholders);
				$sql .= ')';
				
				$stmt = $source->prepare($sql);
			 
				foreach ($to_shift as $to_shift_k) {
					$val = @$line[$to_shift_k];
					if(empty($val)) {
						$val = '';
					}
					$stmt->bindValue(':'. $to_shift_k, $val, PDO::PARAM_STR); 
				}
		
				
				//die(var_dump($sql));
				$stmt->execute();

			}
			catch (PDOException $pdoe) {
			   echo "Error: " . $pdoe->getMessage();
			} 

		}

		WriteLog('Done with extractnodespecialpermit');
	}
}
