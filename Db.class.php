<?php 

class Db {


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
