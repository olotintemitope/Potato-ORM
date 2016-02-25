<?php

/**
 * @package  Laztopaz\potato-ORM
 * @author   Temitope Olotin <temitope.olotin@andela.com>
 * @license  <https://opensource.org/license/MIT> MIT
 */

namespace Laztopaz\potatoORM;

use PDO;
use Dotenv\Dotenv;
use PDOException;

class DatabaseConnection extends \PDO
{
	private
		$databaseName,
		$databaseHost,
	    $databaseDriver,
	    $databaseUsername,
	    $databasePassword,
	    $databaseHandle;

	public  function  __construct()
	{
		self::loadEnv(); // load the environment variables

		$this->databaseName     =  getenv('databaseName');
		$this->databaseHost     =  getenv('databaseHost');
		$this->databaseDriver   =  getenv('databaseDriver');
		$this->databaseUsername =  getenv('databaseUsername');
		$this->databasePassword =  getenv('databasePassword');

		$this->databaseHandle = $this->connect();

	}

	/**
	 * This method connects the specified database chosen by the user
	 * @params void
	 * @return boolean true or false
	 */
	public function connect()
	{
		try {

			$options = [

				PDO::ATTR_PERSISTENT    => true,

				PDO::ATTR_ERRMODE       => PDO::ERRMODE_EXCEPTION
			];

			$databaseHandle = new PDO($this->getDatabaseDriver(), $this->databaseUsername, $this->databasePassword, $options);

		} catch(PDOException $e) {

			return $e->getMessage();

		}

		return $databaseHandle;
	}


	/**
	 * This method determines the driver to be used for appropriate database server
	 * @params void
	 * @return string dsn
	 */
	public function getDatabaseDriver()
	{
		$dsn = "";

		switch ($this->databaseDriver)
		{
			case 'mysql':

				// Set DSN
				$dsn = 'mysql:host='.    $this->databaseHost. ';dbname='. $this->databaseName;
				break;
			case 'sqlite':

				// Set DSN
				$dsn = 'sqlite:host='.   $this->databaseHost. ';dbname='. $this->databaseName;
				break;
			case 'pgsql':

				// Set DSN
				$dsn = 'pgsqlsql:host='. $this->databaseHost. ';dbname='. $this->databaseName;
				break;
			default:
				// Set DSN
				$dsn = 'mysql:host='.    $this->databaseHost. ';dbname='. $this->databaseName;
		}
		return $dsn;
	}

	/**
	 * Load Dotenv to grant getenv() access to environment variables in .env file
	 */
	private function loadEnv()
	{
		if (!getenv("APP_ENV"))
		{
			$dotenv = new Dotenv($_SERVER['DOCUMENT_ROOT']);
			$dotenv->load();
		}
	}

}