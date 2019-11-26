<?php 

class Db {


	public static function getSqliteCon($dsn) {
		try
                {

                $pdo = new PDO($dsn, $u, $p);
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
