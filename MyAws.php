<?php 

use Aws\S3\S3Client;
use GuzzleHttp\Psr7\StreamWrapper;
class MyAws {
	public static function getResrc() {

		try {


			$token = '';

			$creds = new Aws\Credentials\Credentials($key, $secret);

			$client = new Aws\S3\S3Client([
				'region'=>'us-east-2',
			]); 


			// Register the stream wrapper from an S3Client object
			//$client->registerStreamWrapper();

			$listResponse = $client->listBuckets();

			

			$buckets = $listResponse['Buckets'];



			$obj = $client->getObject([
					'Bucket' => 'pppdstatelegacy', 'Key' => 'pppd_state_active_org.csv'

			]); 


			$aws_resource = NULL;
			if ($body = $obj['Body']) {
				//echo $body;
				// Cast to a string: { ... }
				$body->seek(0);
				// $body is a guzzle Stream object
				//$stream = GuzzleHttp\Psr7\stream_for('hello!');
				$aws_resource = StreamWrapper::getResource($body); 

				return $aws_resource;
			}
			throw new Exception('No connection to AWS.');
		}
		catch (Exception $e) {
			WriteLog($e->getMessage());
		}
	}
}

