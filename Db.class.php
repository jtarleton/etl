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


class RestUtils {


	public static function createNode() {

			$curl = curl_init();

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
			      "value": "Example fleet vehicle title' . uniqid() . '"
			    }
			  ],
			  "type": [
			    {
			      "target_id": "fleet_vehicle"
			    }
			  ]
			}',
			  CURLOPT_HTTPHEADER => array(
			    "Content-Type: application/hal+json",
			    "_format: hal_json",
			    "Authorization: Basic anRhcmxldG9uOmphbWVzMjAxOA=="
			  ),
			));

			$response = curl_exec($curl);
if(!$response) WriteLog(curl_error($curl));
			curl_close($curl);
			WriteLog($response);


	}
	public static function createTaxonomyTerm() {
			// CREATE TAXONOMY TERM
			$curl = curl_init();

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
			      "value": "Verizon ' . uniqid() . '",
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
			      "value": "Verizon description' . uniqid() . '"
			    }
			  ],
			  "field_organization_name": [
			    {
			      "value": "org name ' . uniqid() . '"
			    }
			  ],
			  "field_organization_type": [
			    {
			      "value": 2
			    }
			  ],
			  "field_organization_address": [
			    {
			      "langcode": null,
			      "country_code": "US",
			      "administrative_area": "NY",
			      "locality": "new york",
			      "dependent_locality": null,
			      "postal_code": "10007",
			      "sorting_code": null,
			      "address_line1": "' . uniqid() . '",
			      "address_line2": "water st",
			      "organization": "Charitable Organization ' . uniqid() . '",
			      "given_name": null,
			      "additional_name": null,
			      "family_name": null
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
			curl_close($curl);
			WriteLog($response);
	} 

}