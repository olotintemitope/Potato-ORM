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

class DatabaseHelper extends \PDO
{
	protected $databaseName;
	protected $databaseHost;
	protected $databaseDriver;
	protected $databasePort;
	protected $databaseUsername;
	protected $databasePassword;
	protected $databaseHandle;

	/**
	 * This is a constructor; a default method  that will be called automatically during class instantiation
	 */
	public function __construct()
	{
		$this->databaseName     =  getenv('databaseName');
		$this->databaseHost     =  getenv('databaseHost');
		$this->databaseDriver   =  getenv('databaseDriver');
		$this->databasePort     =  getenv('databasePort');
		$this->databaseName     =  getenv('databaseName');
		$this->databasePassword =  getenv('databasePassword');

	}

	/**
	 * This method connects the specified database chosen by the user
	 * @params void
	 * @return boolean true or false
	 */
	public function connect()
	{
		// Create a new PDO instance
		try {
			$options = array (

				PDO::ATTR_PERSISTENT    => true,

				PDO::ATTR_ERRMODE       => PDO::ERRMODE_EXCEPTION
			);
			$this->databaseHandle = new PDO($this->getDatabaseDriver(), $this->databaseName, $this->databasePassword, $options);

		} catch(PDOException $e){

			return $e->getMessage();
		}
	}

	/**
	 * This method creates table
	 * @params array parameter
	 * @return boolean true or false
	 */
	public function createTable()
	{

	}

	/**
	 * This method creates table
	 * @params string table name
	 * @return boolean true or false
	 */
	public  function  dropTable()
	{

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
}