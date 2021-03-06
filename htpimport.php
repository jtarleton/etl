<?php 
ini_set('memory_limit','1G');
require __DIR__ . '/vendor/autoload.php';
require_once( dirname(__FILE__) .'/Db.class.php' );
require_once( dirname(__FILE__) .'/MyAws.php' );





try {
	$aws_resource = null;
	$aws_resource = MyAws::getResrc(); 
}
catch(Exception $e) {
	WriteLog('Error ' . $e->getMessage());
}

global $logname, $logfp;

error_reporting(E_ALL);
ini_set('display_errors', 1 );

StartLog( 'Starting...');

/** Command line arguments **/
$argc = $_SERVER['argc'];
$argv = $_SERVER['argv'];


$dsn=sprintf('mysql:host=%s;port=%s;dbname=%s', 
PVTCONFIG_DBHOST,PVTCONFIG_DBPORT,PVTCONFIG_DBNAME
);

$dsn2=sprintf('mysql:host=%s;port=%s;dbname=%s',
PVTCONFIG_DBHOST2,PVTCONFIG_DBPORT2,PVTCONFIG_DBNAME2
);

$dsn3=sprintf('mysql:host=%s;port=%s;dbname=%s',
PVTCONFIG_DBHOST3,PVTCONFIG_DBPORT3,PVTCONFIG_DBNAME3
);

$mysql1 = Db::getCon( $dsn,PVTCONFIG_DBUSER,
PVTCONFIG_DBPASS);

$mysql2 = Db::getCon( $dsn2,PVTCONFIG_DBUSER2,
PVTCONFIG_DBPASS2);

$mysql3 = Db::getCon( $dsn3,PVTCONFIG_DBUSER3,
PVTCONFIG_DBPASS3);

/*
$constring = 'mongodb://'.PVTCONFIG_MONGOHOST.':'.PVTCONFIG_MONGOPORT;
$options = array('connect'=>true,
				'timeout'=>10000,
				'username'=>PVTCONFIG_MONGOUSER,
				'password'=>PVTCONFIG_MONGOPASS,
				'db'=>PVTCONFIG_MONGODBNAME);
*/

$dsn_sqlite = 'sqlite::memory:';
$sqlite= Db::getSqliteCon($dsn_sqlite);

if ($argc > 1) {
	$runlevel = intval($argv[1]);
	$endrunlevel = intval($argv[2]);

	if ($endrunlevel < $runlevel) {
		$endrunlevel = $runlevel;
	}
	WriteLog('Filtering to runlevel: '.$runlevel.' to '.$endrunlevel);
}
else {
	$runlevel = 0;
	$endrunlevel = 9999;
}

/*
JOB FILE STRUCTURE:

JOB-LLL-XXXXXXX.php

Where LLL is a three-position run-level;  ie, 001, 002, 090, etc...
Where XXX is the class name for this run.


*/


$classes = array();

$dh = opendir('./');
while(FALSE !== ($fname=readdir($dh))) {

	// Use REGEX to pull out the run-level and class:  LLL-XXXXXXX
	$m = array();
	preg_match( '/job-(\d*-.*)\.php/i', $fname, $m );
	if(isset($m[1])) {
		$classes[$m[1]] = $fname;
	}
}

// Sort by RL-NAME
ksort($classes);

WriteLog('Found '.count($classes).' class(es)');

foreach($classes as $k=>$v)
	WriteLog('....'.$v);

WriteLog('Beginning execution');

foreach ($classes as $k=>$v) {
	WriteLog('..Class file:'.$v);

	list($r,$t) = @explode('-',$k);

	$r = intval($r);

	WriteLog('..Classname: *'.$t.'*  Runlevel:'.$r);
	/* If filtering runlevels, do it here */
	if ($runlevel) {
		if (!($r >= $runlevel && $r <= $endrunlevel)) {
			WriteLog('Skipping based on runlevel');
			continue;
		}
	}

	include ($v);
	WriteLog('...instantiating job type ' . $t);
	$thisetl = new $t;
	WriteLog('.....calling PROC');
	try {
		$thisetl->Proc( $mysql1, $mysql2,$mysql3,$aws_resource );
	}
	catch(Exception $e) {
		WriteLog('**** Caught Exception: '.$e->getMessage() );
		WriteLog('**** Trace: '.$e->getTraceAsString() );
		FatalError( 'Terminating on exception' );
		exit;
	}
	unset($thisetl);
}

WriteLog('Normal termination');
StopLog();
exit;

/************************************ LIBRARY FUNCTIONS *******************************/
function StartLog() {
	global $logname, $logfp, $LOGPATH;
	$logname = __DIR__ . '/logs/htpimport-log_' 
					   . date("Y-m-d-H-i-s") 
					   . '-log.txt';

	$logfp = fopen( $logname, 'a' );
	WriteLog('Log Started');
}

function StopLog() {
	global $logname, $logfp;

	fclose($logfp);
}

function WriteLog($s){
	global $logfp;
	$w = date("Y-m-d H:i:s").' '.$s."\r\n";
	fwrite($logfp,$w);
	echo $w;
}

function FatalError($e) {
	WriteLog($e);
	WriteLog('Terminating on fatal error.');
	StopLog();
	exit;
}

function xs($s) {
	$s = rtrim(ltrim($s));
	if( empty($s) )
		return null;

	// Change all back ticks to apostrophes
	$s = str_replace('`',"'",$s);
	return $s;
}
